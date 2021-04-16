<?php

class GWP_Admin
{


    public static function init()
    {

        add_action('admin_init', array('GWP_Admin', 'dbi_register_settings'));

        add_action('admin_menu', array('GWP_Admin', 'dbi_add_settings_page'));
    }

    public static function dbi_render_plugin_settings_page()
    {
        ?>
        <h2>Example Plugin Settings</h2>
        <form action="options.php" method="post">
            <?php
            settings_fields('gwp_plugin_options');
            do_settings_sections('gwp_plugin'); ?>
            <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save'); ?>"/>
        </form>
        <?php
    }

    public static function dbi_register_settings()
    {
        register_setting('gwp_plugin_options', 'gwp_plugin_options');
        add_settings_section('api_settings', 'API Settings', array('GWP_Admin', 'gwp_plugin_section_text'), 'gwp_plugin');
        add_settings_section('api_settings', 'API Settings', array('GWP_Admin', 'gwp_plugin_section_current_url'), 'gwp_plugin');


        add_settings_field('gwp_plugin_setting_api_url', 'API Url', array('GWP_Admin', 'gwp_plugin_setting_api_url'), 'gwp_plugin', 'api_settings');
    }


    public static function gwp_plugin_section_text()
    {
        echo '<p>Here you can set all the options for using the API</p>';
    }

    public static function gwp_plugin_section_current_url()
    {
        $options = get_option('gwp_plugin_options');

        if ($options) {
            printf(__('<p> The current url is: %s </p>'), $options['api_url']);
        } else {

            echo '<p> The current url is: </p>';
        }
    }

    public static function gwp_plugin_setting_api_url()
    {
        echo "<input id='gwp_plugin_setting_api_url' name='gwp_plugin_options[api_url]' type='text' value='' />";
    }


    public static function dbi_add_settings_page()
    {
        global $settingsPageName;


        add_options_page('gwp data', 'gwp widget settings', 'manage_options', 'dbi_render_plugin_settings_page', array('GWP_Admin', 'dbi_render_plugin_settings_page'));
    }
}
