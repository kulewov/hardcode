<?php

class PublicCore
{
    public static function init()
    {
        add_action("wp_ajax_k0d_navigate_posts", [__CLASS__, 'ajaxNavigatePosts']);
        add_action("wp_ajax_nopriv_k0d_navigate_posts", [__CLASS__, 'ajaxNavigatePosts']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'actionAssetsEnqueueFront']);
        add_shortcode('k0d', [__CLASS__, 'renderShortcode']);
    }

    public static function renderShortcode($atts)
    {
        $atts = shortcode_atts([
            'post'     => '',
            'pagen'    => '',
            'showlist' => 'new',
            'title'    => 'Тест',
        ], $atts);
        if ((!$atts['post'] || !post_type_exists($atts['post']))
            || !$atts['pagen']
        ) {
            return '';
        }
        return self::renderTemplate($atts);
    }

    private static function renderTemplate($atts)
    {
        $args  = [
            'numberposts' => (int)$atts['pagen'],
            'orderby'     => 'date',
            'order'       => $atts['showList'] === 'new' ? 'DESC' : 'ASC',
            'post_type'   => $atts['post'],
            'post_status' => 'publish'
        ];
        $posts = self::GetPosts($args);

        $totalPages = (int)ceil(wp_count_posts($atts['post'])->publish / count($posts));
        ob_start(); ?>
        <div id="shortcode-k0d">
            <div class="shortcode-content">
                <?php
                foreach ($posts as $post) {
                    include __DIR__ . '/templates/single-post.php';
                } ?>
            </div>
            <?php
            if ($totalPages > 1) {
                $perPage  = $atts['pagen'];
                $postType = $atts['post'];
                $sort     = $atts['showlist'];
                include_once __DIR__ . '/templates/paginate.php';
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
    }

    public static function ajaxNavigatePosts()
    {
        $data    = $_POST;
        $curPage = $data['cur_page'];
        $isPrev  = $data['helper'] === 'prev';
        $curPage = $isPrev ? $curPage - 2 : $curPage;
        $offset  = ($curPage * $data['per_page']);

        $args  = [
            'numberposts' => (int)$data['per_page'],
            'orderby'     => 'date',
            'order'       => $data['sort'] === 'new' ? 'ASC' : 'DESC',
            'post_type'   => $data['post_type'],
            'post_status' => 'publish',
            'offset'      => $offset
        ];
        $posts = self::getPosts($args);
        ob_start();
        foreach ($posts as $post) {
            include __DIR__ . '/templates/single-post.php';
        }
        die(json_encode(ob_get_clean()));
    }

    public static function actionAssetsEnqueueFront()
    {
        wp_enqueue_script('k0d-shortcode', SHORTCODE_URL . '/src/assets/front/js/public.js', [], false, true);
        wp_enqueue_style('k0d-shortcode', SHORTCODE_URL . '/src/assets/front/css/public.css');
        $args = [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ];
        wp_localize_script('k0d-shortcode', 'k0d', $args);
    }

    private static function getPosts($args)
    {
        return get_posts($args);
    }
}