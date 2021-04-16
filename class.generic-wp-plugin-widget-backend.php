<?php

class GWP_Widget_Backend
{


    public static function init()
    {

        // add_action('wp_enqueue_scripts', 'theme_name_scripts');

        wp_register_script('generic-wp-plugin-widget.js', plugin_dir_url(__FILE__) . '_inc/generic-wp-plugin-widget.js', array('jquery'));
        wp_enqueue_script('generic-wp-plugin-widget.js');

        $current_user = wp_get_current_user();

        wp_localize_script('generic-wp-plugin-widget.js', 'MyAjax', array(
            // URL to wp-admin/admin-ajax.php to process the request
            'ajaxurl' => admin_url('admin-ajax.php'),
            // generate a nonce with a unique ID "myajax-post-comment-nonce"
            // so that you can check it later when an AJAX request is sent
            'security' => wp_create_nonce('my-special-string'),
//            'userEmail' => $current_user->user_email

        ));

        add_action('wp_ajax_my_action', array('GWP_Widget_Backend', 'get_data_callback'));
        add_action('wp_ajax_nopriv_my_action', array('GWP_Widget_Backend', 'get_data_callback'));


        add_action('comment_post', array('GWP_Widget_Backend', 'add_comment_points'), 10, 2);

        add_action( 'woocommerce_edit_account_form', array('GWP_Widget_Backend','iconic_print_user_frontend_fields'), 10 );

    }




   public static function iconic_get_account_fields($loyalty_points) {



        return apply_filters( 'iconic_account_fields', array(
            'user_url' => array(
                'type'        => 'text',
                'label'       => __( 'Loyalty Points', 'generic-wp-plugin' ),
                'placeholder' => __( $loyalty_points, 'generic-wp-plugin' ),
                'required'    => true,
            ),
        ) );

    }

    public static function iconic_print_user_frontend_fields() {

        $current_user = wp_get_current_user();
        $loyalty_points =  get_user_meta(wp_get_current_user()->ID, 'user_notes', true);
        $fields = self::iconic_get_account_fields($loyalty_points);

        foreach ( $fields as $key => $field_args ) {
            woocommerce_form_field( $key, $field_args );
        }
    }



    public static function add_comment_points($comment_ID, $comment_approved)
    {

        if (is_user_logged_in()) {

            if (1 === $comment_approved) {

                $current_user = wp_get_current_user();


                $options = get_option('gwp_plugin_options');

                $response = wp_remote_get($options['api_url'] . '?woocomment=true' . '&userEmail=' . $current_user->user_email);
                //$http_code = wp_remote_retrieve_response_code($response);


                if (!is_wp_error($response) && ($response['response']['code'] === 200 || $response['response']['code'] === 201)) {

                    $data = json_decode(wp_remote_retrieve_body($response));
                    $points_on_bosbec = $data->points;

                    $loyalty_points = get_user_meta($current_user->ID, 'user_loyalty_points', true);
                    if (isset($loyalty_points)) {
                        //if we saved already more the one notes
                        $loyalty_points = $points_on_bosbec;
                        update_user_meta($current_user->ID, 'user_notes', $loyalty_points);
                    }
                    if (!isset($loyalty_points)) {
                        //first note we are saving fr this user
                        update_user_meta($current_user->ID, 'user_notes', $loyalty_points);
                     }


                } else {

                    if (is_wp_error($response)) {

                        //printf( __( '<p> The date was %s </p>'), $response );

                        echo $response->get_error_message();
                    }
                }


                // die(); // this is required to return a proper result


            }
        }
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


        $current_user = wp_get_current_user();

        $response = wp_remote_get($options['api_url'] . '?woocomment=false' . '&userEmail=' . $current_user->user_email);
        $http_code = wp_remote_retrieve_response_code($response);


        if (!is_wp_error($response) && ($response['response']['code'] === 200 || $response['response']['code'] === 201)) {


            $data = json_decode(wp_remote_retrieve_body($response));
            $points = $data->points;

            $arr = array('points' => $points, 'data' => $data);


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
