<?php 
//THE EBOR SOCIAL FUNCTION
function ebor_social($description=0) {
	if( $description ) { echo '<p class="ebor-description">' . $description . '</p>'; }
	$icons = get_option('ebor_social_options');
	$display = get_option('ebor_social_display_options');
	echo '<ul class="ebor-social">';
	foreach ($icons as $key => $value) {
		if(!( startsWith($key,'icon') )) continue;
		if( $value !='' ){ echo '<li><a href="' . $value . '" class="ebor-social-' . $display['option_size'] . '" target="_blank"><i class="' . $key . '"></i></a></li>'; }
	}
	echo '</ul>';
}

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

			<?php $font_links = array(
								'icon-bitbucket' => 'Bitbucket Social Link',
								'icon-bitbucket-sign' => 'Bitbucket Social Link (alt)',
								'icon-dribbble' => 'Dribbble Social Link',
								'icon-dropbox' => 'Dropbox Social Link',
								'icon-facebook' => 'Facebook Social Link',
								'icon-facebook-sign' => 'Facebook Social Link (alt)',
								'icon-flickr' => 'Flickr Social Link',
								'icon-foursquare' => 'Foursquare Social Link',
								'icon-github' => 'Github Social Link',
								'icon-github-alt' => 'Github Social Link (alt)',
								'icon-github-sign' => 'Github Social Link (alt 2)',
								'icon-google-plus' => 'Google+ Social Link',
								'icon-google-plus-sign' => 'Google+ Social Link (alt)',
								'icon-instagram' => 'Instagram Social Link',
								'icon-linkedin' => 'LinkedIn Social Link',
								'icon-linkedin-sign' => 'LinkedIn Social Link (alt)',
								'icon-pinterest' => 'Pinterest Social Link',
								'icon-pinterest-sign' => 'Pinterest Social Link (alt)',
								'icon-skype' => 'Skype Social Link',
								'icon-stackexchange' => 'Stackexchange Social Link',
								'icon-tumblr' => 'Tumblr Social Link',
								'icon-tumblr-sign' => 'Tumblr Social Link (alt)',
								'icon-twitter' => 'Twitter Social Link',
								'icon-twitter-sign' => 'Twitter Social Link (alt)',
								'icon-xing' => 'Xing Social Link',
								'icon-xing-sign' => 'Xing Social Link (alt)',
								'icon-youtube' => 'Youtube Social Link',
								'icon-youtube-play' => 'Youtube Social Link (alt)',
								'icon-youtube-sign' => 'Youtube Social Link (alt 2)'
						);
				?>
			
			<hr />
			
			<h2><?php _e('Social Links','ebor'); ?></h2>
			<table class="form-table">
				<?php foreach ($font_links as $key => $value) : ?>
					<tr>
						<th scope="row"><?php echo $value; ?></th>
						<td>
							<input type="text" size="50" name="ebor_social_options[<?php echo $key; ?>]" value="<?php echo $options[$key]; ?>" />
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			
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
		$widget_ops = array('classname' => 'ebor_social', 'description' => '');

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
				if(!( startsWith($key,'icon') )) continue;
				if( $value !='' ){ echo '<li><a href="' . $value . '" class="ebor-social-' . $instance['size'] . '" target="_blank"><i class="' . $key . '"></i></a></li>'; }
			}
			echo '</ul>';
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['size'] = strip_tags($new_instance['size']);
		$instance['type'] = strip_tags($new_instance['type']);

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