<?php
/* Plugin Name: Wats Latest Tickets Widget
Plugin URI: http://zoecorkhill.co.uk/
Description: A plugin to display the latest tickets in a sidebar widget. Designed to work with <a href="http://www.ticket-system.net/">Wordpress Advanced Ticket System</a>.
Author: Zoe Corkhill
Version: 1.0
Author URI: http://zoecorkhill.co.uk/
*/

function widget_latesttickets($args) {
  extract($args);

  $options = get_option("widget_latesttickets");
    if (!is_array( $options ))
  {
  $options = array(
        'title' => 'Latest Tickets',
        'numberoftickets' => '5'
        );
	} 
  
  echo $before_widget;
  echo $before_title;
  echo $options['title']; 
  echo $after_title;
	echo '<ul>';
 $the_query = new WP_Query( 'post_type=ticket&posts_per_page='.$options['numberoftickets'] );
  
  if ( $the_query->have_posts()) :
  
  // The Loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  
	echo '<li><a href="';
	the_permalink();
	echo '">';
	the_title();
	echo '</a></li>';
	
  //	header("location: ".get_permalink());
  endwhile;
  endif;
  
  // Reset Query
  wp_reset_query();
  echo '</ul>';

echo $after_widget;
  
}



function latesttickets_control()
{
  $options = get_option("widget_latesttickets");
  if (!is_array( $options ))
{
$options = array(
      'title' => 'Latest Tickets',
      'numberoftickets' => '5'
      );
  }
 
  if ($_POST['latesttickets-Submit'])
  {
    $options['title'] = htmlspecialchars($_POST['latesttickets-WidgetTitle']);
    $options['numberoftickets'] = htmlspecialchars($_POST['latesttickets-WidgetCount']);
    update_option("widget_latesttickets", $options);
  }
 
?>
  <p>
    <label for="latesttickets-WidgetTitle">Widget Title: </label>
    <input type="text" id="latesttickets-WidgetTitle" name="latesttickets-WidgetTitle" value="<?php echo $options['title'];?>" /> </p><p>
      <label for="latesttickets-WidgetCount">Number of Tickets: </label>
      <input type="text" id="latesttickets-WidgetCount" name="latesttickets-WidgetCount" value="<?php echo $options['numberoftickets'];?>" />
    <input type="hidden" id="latesttickets-Submit" name="latesttickets-Submit" value="1" />
  </p>
<?php
} 
 
function latesttickets_init() {
  register_sidebar_widget(__('Latest Tickets'), 'widget_latesttickets');
  register_widget_control(   'Latest Tickets', 'latesttickets_control');
  
}

add_action("plugins_loaded", "latesttickets_init"); 
?>