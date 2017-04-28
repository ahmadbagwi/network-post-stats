<?php
/**
* Plugin Name: Network Post Stats
* Plugin URI: http://kdesain.com
* Description: Display stats of network post
* Version: 1.0
* Author: Ahmad Bagwi Rifai
* Author URI: https://23redstrip.wordpress.com
*/

function network_post_stats_actions() {
     add_menu_page("Network Post Stats", "Network Post Stats", "network_post_stats", "post-stats", "post_stats_function");
}
add_action('admin_menu', 'network_post_stats_actions');

function post_stats_function() {
	$blogs = wp_get_sites();

	if ( 0 < count( $blogs ) ) :
		foreach( $blogs as $blog ) : 
			switch_to_blog( $blog[ 'blog_id' ] );

			$description  = get_bloginfo( 'description' );
			$blog_details = get_blog_details( $blog[ 'blog_id' ] );
			$count_post = wp_count_posts()->publish;
			$year = "2017";
			$month = "01";
		
			global $wpdb;
				$post_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_date LIKE '{$year}-{$month}%' AND post_status='publish' AND post_type='post'" );
	
		?>
		
			<ul>
				<li class="no-mp">

					<h2 class="no-mp blog_title">
						<a href="<?php echo $blog_details->path ?>">
							<?php echo  $blog_details->blogname; ?>
						</a>
						<?php echo $blog_details->blog_id;?>
						<?php echo $post_count; ?>
					</h2>

					<div class="blog_description">
						<?php echo $description; ?>
					</div>
				</li>
			</ul>
			<?php restore_current_blog(); ?>
		<?php endforeach;
	endif; ?>

<?php }