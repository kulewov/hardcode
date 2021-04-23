<?php

class Core
{
    public static function activate()
    {
        self::createDefaultPages();
    }

    public static function deactivate()
    {
        self::deleteDefaultPages();
    }

    public static function init()
    {
        add_action('init', [__CLASS__, 'registerPostType']);

    }

    public static function registerPostType()
    {
        $postTypeArgs = [
            'labels'       => [
                'name'               => 'k0d\'s',
                'singular_name'      => 'k0d',
                'add_new'            => 'Добавить',
                'add_new_item'       => 'Добавить k0d',
                'edit_item'          => 'Редактировать',
                'new_item'           => 'Новая k0d',
                'view_item'          => 'Просмотр',
                'search_items'       => 'Поиск k0d',
                'not_found'          => 'k0d\'s не найдены',
                'not_found_in_trash' => 'k0d\'s не найдены в корзине',
            ],
            'public'       => true,
            'has_archive'  => true,
            'supports'     => ['title','excerpt', 'editor', 'author', 'revisions'],
            'map_meta_cap' => true
        ];

        register_post_type(Config::POST_TYPE, $postTypeArgs);
    }

    private static function createDefaultPages()
    {
        for ($i = 0; $i < Config::DEFAULT_PAGE_COUNT; $i++) {
            $args = [
                'comment_status' => 'closed',
                'post_author'    => __CLASS__,
                'post_name'      => sprintf('default page %d', $i),
                'post_content'   => self::generateRandomString(150),
                'post_status'    => 'publish',
                'post_title'     => sprintf('%s %s %d', self::generateRandomString(20), 'title', $i),
                'post_type'      => Config::POST_TYPE
            ];
            wp_insert_post($args);
        }
    }

    private static function generateRandomString($strength = 16)
    {
        $input        = Config::PERMITED_CHARS;
        $length       = strlen($input);
        $randomString = '';
        for ($i = 0; $i < $strength; $i++) {
            $randomCharacter = $input[mt_rand(0, $length - 1)];
            $randomString    .= ' ' . $randomCharacter;
        }

        return $randomString;
    }

    private static function deleteDefaultPages()
    {

    }


}