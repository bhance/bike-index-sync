<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Bike_Index_Widget
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<form action="options.php" method="post">
	
		<?php
		settings_fields( 'logmycalls-settings-group' );
		do_settings_sections( 'logmycalls-settings' );
		?>
		<input name="Submit" type="submit" value="Save Changes" />
	</form>
</div>
