<?php 
if (!is_user_logged_in())
{
	return;
}
else
{
	switch($bb_role)
	{
		case "administrator":
			$user_role_permission = "manage_options";
		break;
		case "editor":
			$user_role_permission = "publish_pages";
		break;
		case "author":
			$user_role_permission = "publish_posts";
		break;
	}
	if (!current_user_can($user_role_permission))
	{
		return;
	}
	else
	{
		$plugin_update_nonce = wp_create_nonce( "update_plugin_nonce" );
		$backup_updates = get_option("backup-bank-automatic-update");
		?>
		<form id="frm_auto_update" class="layout-form bkup_page_width">
			<div class="fluid-layout">
				<div class="layout-span12">
					<div class="widget-layout">
						<div class="widget-layout-title">
							<h4>
								<?php _e("Plugin Updates", wp_backup_bank); ?>
							</h4>
						</div>
						<div class="widget-layout-body">
							<div class="layout-control-group" style="margin: 10px 0 0 0 ;">
								<label class="layout-control-label"><?php _e("Plugin Updates", wp_backup_bank); ?> :</label>
								<div class="layout-controls-radio">
									<input type="radio" name="ux_cleanup_update" id="ux_enable_update" onclick="backup_bank_autoupdate(this);" <?php echo $backup_updates == "1" ? "checked=\"checked\"" : "";?> value="1">
									<label style="vertical-align: baseline;">
										<?php _e("Enable", wp_backup_bank); ?>
									</label>
									<input type="radio" name="ux_cleanup_update" id="ux_disable_update" onclick="backup_bank_autoupdate(this);" <?php echo $backup_updates == "0" ? "checked=\"checked\"" : "";?> style="margin-left: 10px;" value="0">
									<label style="vertical-align: baseline;">
										<?php _e("Disable", wp_backup_bank); ?>
									</label>
								</div>
							</div>
							<div class="layout-control-group" style="margin:10px 0 10px 0 ;">
								<strong><i>This feature allows the plugin to update itself automatically when a new version is available on WordPress Repository.<br/>This allows to stay updated to the latest features. If you would like to disable automatic updates, choose  the disable option above.</i></strong>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript">
			function backup_bank_autoupdate(control)
			{
				var backup_updates = jQuery(control).val();
				jQuery.post(ajaxurl, "backup_updates="+backup_updates+"&param=backup_bank_plugin_updates&action=backup_destination_library&_wpnonce=<?php echo $plugin_update_nonce ;?>", function(data)
				{
				});
			}
		</script>
	<?php
	}
}
?>