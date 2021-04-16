<?php

/**
 * Class Upcoming_Events
 */
class GWP_Widget extends WP_Widget
{

    /**
     * Initializing the widget
     */
    public function __construct()
    {
        $widget_ops = array(
            'class' => 'gwp_widget',
            'description' => __('A widget to do generic-wp-plugin things', 'generic-wp-plugin')
        );

        parent::__construct(
            'gwp_widget',            //base id
            __('Generic WP Plugin', 'generic-wp-plugin'),    //title
            $widget_ops
        );
    }


    /**
     * Displaying the widget on the back-end
     * @param array $instance An instance of the widget
     */
    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', 'text_domain');
        $rndNr = !empty($instance['rndNr']) ? $instance['rndNr'] : 9;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('rndNr')); ?>"><?php esc_attr_e('Rnd Nr:', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('rndNr')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('rndNr')); ?>" type="text"
                   value="<?php echo esc_attr($rndNr); ?>">
        </p>
        <?php
    }


    /**
     * Making the widget updateable
     * @param array $new_instance New instance of the widget
     * @param array $old_instance Old instance of the widget
     * @return array An updated instance of the widget
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['rndNr'] = (!empty($new_instance['rndNr'])) ? $new_instance['rndNr'] : '';


        return $instance;
    }


    /**
     * Displaying the widget on the front-end
     * @param array $args Widget options
     * @param array $instance An instance of the widget
     */
    public function widget($args, $instance)
    {

        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $rndNr = $instance['rndNr'];
        // $title = apply_filters('widget_title', 'generic-wp-plugin');


        if (is_user_logged_in()) {
            //Preparing to show the events
            echo $before_widget;
            if ($title) {
                echo $before_title . $title . $after_title;
            }

                $current_user = wp_get_current_user();
                $loyalty_points =  get_user_meta($current_user->ID, 'user_notes', true);




            ?>

            <p>Loyalty points prerendered from database: <?php echo $loyalty_points; ?></p>

            <p id="points"><span>Loalty Points via Ajax:</span></p>


            <br>



            <?php

            echo $after_widget;


        } else {


            echo $before_widget;
            if ($title) {
                echo $before_title . $title . $after_title;
            }




            ?>

            <p>Become an member and start collecting points!</p>


            <?php

            echo $after_widget;


        }
    }


}


function gwp_register_widget()
{
    register_widget('GWP_Widget');
}

add_action('widgets_init', 'gwp_register_widget');
