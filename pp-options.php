<?php

function contextual_related_links_settings(){
?>
<div class="wrap">
<h2>Contextual Related Links Options</h2>

<form method="post" action="options.php">
	<?php settings_fields('contextual_related_links_settings_group'); ?>
	<?php do_settings_sections('contextual_related_links_settings_group'); ?>
	<table class="form-table">
		<tr valign="top">
		<th scope="row">Delete chat history older than how many days?</th>
		<td>
		<input type="number" name="contextual_related_links_settings" value="<?php echo esc_attr(get_option('contextual_related_links_settings')); ?>" />
		</td>
		</tr>
	</table>
    
	<?php submit_button(); ?>

</form>
</div>
<?php }

?>