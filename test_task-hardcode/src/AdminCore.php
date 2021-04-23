<?php
class AdminCore
{

    public static function init()
    {

        add_action('admin_head', [__CLASS__, 'addTinyMCEButton']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueueAdminAssets']);
    }

    public static function addTinyMCEButton() {
        // проверяем права пользователя - может ли он редактировать посты и страницы
        if (!current_user_can( 'edit_posts') && !current_user_can('edit_pages') ) {
            return; // если не может, то и кнопка ему не понадобится, в этом случае выходим из функции
        }
        // проверяем, включен ли визуальный редактор у пользователя в настройках (если нет, то и кнопку подключать незачем)
        if ('true' == get_user_option('rich_editing')) {
            add_filter('mce_external_plugins', [__CLASS__, 'addTinymceScript']);
            add_filter('mce_buttons', [__CLASS__, 'registerMceButton']);
        }
    }

    // В этом функции указываем ссылку на JavaScript-файл кнопки
    public static function addTinymceScript($plugin_array) {
        $plugin_array['k0d_button'] = plugins_url('/assets/admin/js/tinyMce.js', __FILE__); // true_mce_button - идентификатор кнопки
        return $plugin_array;
    }

    // Регистрируем кнопку в редакторе
    public static function registerMceButton($buttons) {
        array_push( $buttons, 'k0d_button' ); // true_mce_button - идентификатор кнопки
        return $buttons;
    }

    public static function enqueueAdminAssets()
    {
        wp_enqueue_script(
            Config::SLUG . '-script',
            plugins_url('/assets/admin/js/main.js', __FILE__),
            ['jquery'],
            PLUGIN_VERSION,
            true
        );
    }
}