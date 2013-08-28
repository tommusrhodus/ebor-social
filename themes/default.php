<?php 
// Render the Plugin options form
function ebor_social_render_form() { 
	$display = get_option('ebor_social_display_options'); ?>
	
	<div class="wrap">
	
		<!-- Display Plugin Icon, Header, and Description -->
		<?php screen_icon('ebor-social'); ?>
		<h2><?php _e('Ebor Social Settings','ebor'); ?></h2>
		<?php echo '<p>' . __('Welcome to <b>Ebor Social</b>, a fantastic little plugin for displaying Retina Enabled Social Icons in your theme.','ebor') . '</p>'; ?>
		
		<div class="wrap">
		
				<!-- Beginning of the Plugin Options Form -->
				<form method="post" action="options.php">
					<?php settings_fields('ebor_social_plugin_display_options'); ?>
					<?php $displays = get_option('ebor_social_display_options'); ?>
					
					<table class="form-table">
							<tr>
								<th scope="row"><?php _e('Select Icon Size','ebor'); ?></th>
								<td>
									<select name='ebor_social_display_options[option_size]'>
										<option value='16px' <?php selected('16px', $displays['option_size']); ?>>16px</option>
										<option value='32px' <?php selected('32px', $displays['option_size']); ?>>32px</option>
									</select>
									<span style="color:#666666;margin-left:2px;"><?php _e('Choose the output size for your social icons','ebor'); ?></span>
								</td>
							</tr>
					</table>
					
					<?php submit_button('Save Options'); ?>
					
				</form>
		
		</div>

		<!-- Beginning of the Plugin Options Form -->
		<form method="post" action="options.php">
			<?php settings_fields('ebor_social_plugin_options'); ?>
			<?php $options = get_option('ebor_social_options'); ?>

			<?php $image_links = array(
								'500px' => '500px Social Link',
								'aim' => 'Aim Social Link',
								'android' => 'Android Social Link',
								'badoo' => 'Badoo Social Link',
								'dailybooth' => 'DailyBooth Social Link',
								'dribbble' => 'Dribbble Social Link',
								'facebook' => 'Facebook Social Link',
								'foursquare' => 'Foursquare Social Link',
								'github' => 'Github Social Link',
								'google' => 'Google+ Social Link',
								'hipstamatic' => 'Hipstamatic Social Link',
								'icq' => 'Icq Social Link',
								'instagram' => 'Instagram Social Link',
								'lastfm' => 'LastFM Social Link',
								'linkedin' => 'LinkedIn Social Link',
								'path' => 'Path Social Link',
								'picasa' => 'Picasa Social Link',
								'pinterest' => 'Pinterest Social Link',
								'quora' => 'Quora Social Link',
								'rdio' => 'Rdio Social Link',
								'reddit' => 'Reddit Social Link',
								'rss' => 'RSS Social Link',
								'skype' => 'Skype Social Link',
								'spotify' => 'Spotify Social Link',
								'thefancy' => 'TheFancy Social Link',
								'tumblr' => 'Tumblr Social Link',
								'twitter' => 'Twitter Social Link',
								'vimeo' => 'vimeo Social Link',
								'xbox' => 'XBox Social Link',
								'youtube' => 'YouTube Social Link',
								'zerply' => 'Zerply Social Link'
						);
						
				?>
			
			<hr />
			
			<h2><?php _e('Image Display Type Social Links','ebor'); ?></h2>
			<table class="form-table">
				<?php foreach ($image_links as $key => $value) : ?>
					<tr>
						<th scope="row"><img src="<?php echo plugins_url( '/img/32px/' , __FILE__ ); echo $key . '-32.png'; ?>" alt="<?php echo $key; ?>" width="16px" style="margin-right: 8px;" /><?php echo $value; ?></th>
						<td>
							<input type="text" size="50" name="ebor_social_options[<?php echo $key; ?>]" value="<?php echo $options[$key]; ?>" />
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			
			<hr />
			
			<?php submit_button('Save Links'); ?>
			
		</form>

	</div>
<?php }

//THE EBOR SHORTCODES WIDGET
add_action('widgets_init', 'ebor_social_load_widgets');

function ebor_social_load_widgets()
{
	register_widget('ebor_social_Widget');
}

class ebor_social_Widget extends WP_Widget {
	
	function ebor_social_Widget()
	{
		$widget_ops = array('classname' => 'ebor_social', 'description' => 'Place retina-ready social icons into your sidebars.');

		$control_ops = array('id_base' => 'ebor_social-widget');

		$this->WP_Widget('ebor_social-widget', 'Ebor Social', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo  $before_title.$title.$after_title;
		}
		
		$icons = get_option('ebor_social_options');
			echo '<ul class="ebor-social">';
			foreach ($icons as $key => $value) {
				if( startsWith($key,'icon') ) continue;
				if( $value !='' ){ echo '<li><a href="' . $value . '" class="ebor-social" target="_blank"><img src="' . plugins_url( '/img/64px/' , __FILE__ ) . $key . '-64.png" alt="' . $key . '" width="' . $instance['size'] . '" /></a></li>'; }
			}
			echo '</ul>';
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['size'] = strip_tags($new_instance['size']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Social Icons');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>">Size:</label>
			<select name='<?php echo $this->get_field_name('size'); ?>'>
				<option value='16px' <?php selected('16px', $instance['size']); ?>>16px</option>
				<option value='32px' <?php selected('32px', $instance['size']); ?>>32px</option>
			</select>
		</p>
	<?php
	}
}

if (!function_exists('ebor_social')) {
	function ebor_social( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'size' => '32px'
	), $atts));
	$icons = get_option('ebor_social_options');
		$output = '';
		$output .= '<ul class="ebor-social">';
		foreach ($icons as $key => $value) {
			if( startsWith($key,'icon') ) continue;
			if( $value !='' ){ $output .=  '<li><a href="' . $value . '" class="ebor-social" target="_blank"><img src="' . plugins_url( '/img/64px/' , __FILE__ ) . $key . '-64.png" alt="' . $key . '" width="' . $size . '" /></a></li>'; }
		}
		$output .= '</ul>';
	   return $output;
	}
	add_shortcode('ebor_social', 'ebor_social');
}