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
		<th scope="row">What type of links you need?</th>
		<td>
			<select name="links_type" value="<?php echo esc_attr(get_option('links_type')); ?>" style="width:auto;">	
				<option value="1" <?php if (get_option('links_type')==1) {echo "selected"; } ?>>Link tags assigned to the post</option>
				<option value="2" <?php if (get_option('links_type')==2) {echo "selected"; } ?>>Link all site tags that appears in content</option>
				<option value="3" <?php if (get_option('links_type')==3) {echo "selected"; } ?>>Link to posts that contain tags found in content</option>
			</select>
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">Exclude tags (comma-separated, e.g.: toys, pony, pink):</th>
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