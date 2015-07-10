<?php

function contextual_related_links_settings(){
?>
<div class="wrap">
<h2>Contextual Related Links Options</h2>

<form method="post" action="options.php">
	<?php settings_fields('contextual-related-links-settings-group'); ?>
	<?php do_settings_sections('contextual-related-links-settings-group'); ?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Tags to exclude (comma-separated, e.g.: toys, pony, pink):</th>
		<td>
		<input type="text" name="banned_tags" value="<?php echo esc_attr(get_option('banned_tags')); ?>" />
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">Include ONLY those tags (leave empty if ou want to include all tags, comma-separated, e.g.: toys, pony, pink):</th>
		<td>
		<input type="text" name="include_tags" value="<?php echo esc_attr(get_option('include_tags')); ?>" />
		</td>
		</tr>
	</table>
    
	<?php submit_button(); ?>

</form>
</div>
<?php }

?>