<?php

class GWP_Widget_Backend
{


    public static function init()
    {

        // add_action('wp_enqueue_scripts', 'theme_name_scripts');

        wp_register_script('generic-wp-plugin-widget.js', plugin_dir_url(__FILE__) . '_inc/generic-wp-plugin-widget.js', array('jquery'));
        wp_enqueue_script('generic-wp-plugin-widget.js');

        wp_localize_script('generic-wp-plugin-widget.js', 'MyAjax', array(
            // URL to wp-admin/admin-ajax.php to process the request
            'ajaxurl' => admin_url('admin-ajax.php'),
            // generate a nonce with a unique ID "myajax-post-comment-nonce"
            // so that you can check it later when an AJAX request is sent
            'security' => wp_create_nonce('my-special-string')
        ));

        add_action('wp_ajax_my_action', array('GWP_Widget_Backend', 'get_data_callback'));
        add_action('wp_ajax_nopriv_my_action', array('GWP_Widget_Backend', 'get_data_callback'));
    }

    // function theme_name_scripts()
    // {


    // }

    // The function that handles the AJAX request

    public static function get_data_callback()
    {
        check_ajax_referer('my-special-string', 'security');
        $email = $_POST['email'];


        $options = get_option('gwp_plugin_options');


        $response = wp_remote_get($options['api_url'] . '?email=' . $email);
        $http_code = wp_remote_retrieve_response_code($response);





        if (!is_wp_error($response) && ($response['response']['code'] === 200 || $response['response']['code'] === 201)) {


            $data = json_decode(wp_remote_retrieve_body($response));
            $nps = $data->nps;
            $nps_date = $data->latest_nps;

            $arr = array('nps_score' => $nps, 'nps_date' => $nps_date, 'email' => $email);


            echo json_encode($arr);
        } else {

            if (is_wp_error($response)) {

                //printf( __( '<p> The date was %s </p>'), $response );

                echo $response->get_error_message();
            }
        }





        die(); // this is required to return a proper result
    }
}
