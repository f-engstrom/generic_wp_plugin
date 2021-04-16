Files generic-wp-plguin.php and class.generic-plugin-widget.php 
contain the needed parts to make a working wordpress widget and plugin. 


##Plugin



##Widget

https://codex.wordpress.org/Widgets_API
For the widget to work the it needs to inherit from the class WP_Widget 
and implement it's methods. 


    public function __construct()


    public function form($instance)
   

   
    public function update($new_instance, $old_instance)
    public function widget($args, $instance)
