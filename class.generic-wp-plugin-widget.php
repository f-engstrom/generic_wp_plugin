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
            'class'            =>    'gwp_widget',
            'description'    =>    __('A widget to do generic-wp-plugin things', 'generic-wp-plugin')
        );

        parent::__construct(
            'gwp_widget',            //base id
            __('generic-wp-plugin', 'generic-wp-plugin'),    //title
            $widget_ops
        );
    }


    /**
     * Displaying the widget on the back-end
     * @param  array $instance An instance of the widget
     */
    public function form($instance)
    {
        $widget_defaults = array(
            'title'            =>    'Something generic-wp-plugin',
            'number_events'    =>    5
        );

        $instance  = wp_parse_args((array) $instance, $widget_defaults);
?>

        <!-- Rendering the widget form in the admin -->
        <p>
            Här kan man ha ett widget formulär
        </p>

    <?php
    }


    /**
     * Making the widget updateable
     * @param  array $new_instance New instance of the widget
     * @param  array $old_instance Old instance of the widget
     * @return array An updated instance of the widget
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['number_events'] = $new_instance['number_events'];

        return $instance;
    }


    /**
     * Displaying the widget on the front-end
     * @param  array $args     Widget options
     * @param  array $instance An instance of the widget
     */
    public function widget($args, $instance)
    {

        extract($args);
        //        $title = apply_filters('widget_title', $instance['title']);
        $title = apply_filters('widget_title', 'generic-wp-plugin');




        //Preparing to show the events
        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        if (isset($_POST['submit'])) {
        }

    ?>


        <p id="searched_email"><span>Email:</span></p>
        <p id="nps_score"><span>Score:</span< /p>
                <p id="nps_date"><span>Date:</span< /p>
                        <p>
                            <label for="db_sub_name">Email Adress</label>
                            <input type="text" name="db_sub_name" id="email" value="" placeholder="Enter your email adress">
                        </p>

                        <br>

                        <button id="postButton">Lookup score</button>




                <?php

                echo $after_widget;
            }
        }

        function gwp_register_widget()
        {
            register_widget('GWP_Widget');
        }
        add_action('widgets_init', 'gwp_register_widget');
