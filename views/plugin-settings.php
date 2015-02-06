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
		if (file_exists(BACKUP_BK_PLUGIN_DIR . "/lib/get-plugin-settings.php"))
		{
			include BACKUP_BK_PLUGIN_DIR . "/lib/get-plugin-settings.php";
		}
		?>
		<div id="message" class="top-right message" style="display: none;">
			<div class="message-notification"></div>
			<div class="message-notification ui-corner-all growl-success" >
				<div onclick="message_close('message');" id="close-message" class="message-close">x</div>
				<div class="message-header"><?php _e("Success!",  wp_backup_bank); ?></div>
				<div class="message-message"><?php _e("Settings has been saved successfully!",  wp_backup_bank); ?></div>
			</div>
		</div>
		<form id="frm_backup_email_notification" name ="frm_backup_email_notification" class = "bkup_page_width layout-form">
			<div class="fluid-layout" >
				<div class="layout-span12">
					<div class="widget-layout">
						<div class="widget-layout-title">
							<h4>
								<?php _e("Plugin Settings ", wp_backup_bank); ?>
								<i class = "standard_edition">
									(Available in Premium Editions)
								</i>
							</h4>
						</div>
						<div class="widget-layout-body">
						<input type="button" id="ux_btn_action" onclick="save_plugin_settings();" name="ux_btn_action" class="btn btn-danger" value="<?php _e("Save Settings", wp_backup_bank); ?>" style = "float:right"/>
							<div class="fluid-layout" >
								<div class="layout-span12">
								<div class="separator-doubled"></div>
									<div class="layout-control-group">
										<label class="backup-plugins-settings-label ">
											<?php _e("Show Backup Bank Plugin Menu", wp_backup_bank); ?> : 
											<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
												class="tooltip_img hovertip" data-original-title="<?php _e("It allows you to control the capabilities of WP Backup Bank among different roles of WordPress users",wp_backup_bank) ;?>"/>
										</label>
										<div class="backup-plugins-settings-control bkup_margin_top">
											<span class="check-bottom">
												<input type="checkbox" id="ux_chk_admin" name="ux_chk_admin" value="1" 
													checked="checked" disabled="disabled" />
												<label class="backup-layout-controls-label">
													<?php _e("Administrator", wp_backup_bank); ?>
												</label>
											</span>
											<span class="check-bottom">
												<input type="checkbox" id="ux_chk_editor" name="ux_chk_editor" value="1" 
													<?php echo $backup_editor_role == "1" ? "checked=\"checked\"" : "";?>  disabled="disabled" />
												<label class="backup-layout-controls-label">
													<?php _e("Editor", wp_backup_bank); ?>
												</label>
											</span>
											<span class="check-bottom">
												<input type="checkbox" id="ux_chk_author" name="ux_chk_author"value="1" 
													<?php echo $backup_author_role == "1" ? "checked=\"checked\"" : "";?>  disabled="disabled" />
												<label class="backup-layout-controls-label">
													<?php _e("Author", wp_backup_bank); ?>
												</label>
											</span>
											<span class="check-bottom">
												<input type="checkbox"  id="ux_chk_contributor" name="ux_chk_contributor" value="1" 
													<?php echo $backup_contributor_role == "1" ? "checked=\"checked\"" : "";?>  disabled="disabled" />
												<label class="backup-layout-controls-label">
													<?php _e("Contributor", wp_backup_bank); ?>
												</label>
											</span>
											<span class="check-bottom">
												<input type="checkbox"  id="ux_chk_admin_subscriber" name="ux_chk_admin_subscriber" 
													value="1" <?php echo $backup_subscriber_role == "1" ? "checked=\"checked\"" : "";?>  disabled="disabled" />
												<label class="backup-layout-controls-label">
													<?php _e("Subscriber", wp_backup_bank); ?>
												</label>
											</span>
										</div>
									</div>
									<div class="layout-control-group">
										<label class="backup-plugins-settings-label ">
											<?php _e("Backup Bank Menu Top Bar", wp_backup_bank); ?> : 
											<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
												class="tooltip_img hovertip" data-original-title="<?php _e("It allows you to enable or disable WP Backup Bank for top menu bar among different roles of WordPress users",wp_backup_bank) ;?>"/>
										</label>
										<div class="backup-plugins-settings-control bkup_margin_top">
											<input type="radio" id="ux_rdl_enable_border" name= "ux_rdl_enable_menu" checked="checked" value="1"  disabled="disabled" />
												<?php _e( "Enable", wp_backup_bank ); ?>
											<input type="radio" style="margin-left:10px;" id="ux_rdl_enable_border" name="ux_rdl_enable_menu" value="0"  disabled="disabled" />
												<?php _e( "Disable", wp_backup_bank ); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		jQuery(".hovertip").tooltip({placement: "right"});
		
		if(typeof(save_plugin_settings) != "function")
		{
			function save_plugin_settings()
			{
				jQuery("#top-error").remove();
				var premium_edition_message = jQuery("<div id=\"top-error\" class=\"top-right top-error\" style=\"display: block;\"><div class=\"top-error-notification\"></div><div class=\"top-error-notification ui-corner-all growl-top-error\" ><div onclick=\"message_close();\" id=\"close-top-error\" class=\"top-error-close\">x</div><div class=\"top-error-header\">Error!</div><div class=\"top-error-top-error\">This Feature is Available in Premium Editions!</div></div></div>");
				jQuery("body").append(premium_edition_message);
			}
		}
	
		if(typeof(message_close) != "function")
		{
			function message_close()
			{
				jQuery("#message").css("display", "none");
				jQuery("#top-error").css("display", "none");
			}
		}
		</script>
	<?php
	}
}
?>