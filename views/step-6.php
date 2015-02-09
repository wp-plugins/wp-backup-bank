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
		global $wpdb;
		if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php"))
		{
			include BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php";
		}
	
		$log_folder_path = BACKUP_BK_CONTENT_DIR."/wp-backup-bank/".date("d-m-Y")."/logs";
		$log_folder_path = str_replace("\\","/", $log_folder_path);
		$log_file_path = $log_folder_path."/".$archive_name.".txt";
		
		$sixth_step_nonce = wp_create_nonce("sixth_step_nonce");
		?>
		<div id="message" class="top-right message" style="display: none;">
			<div class="message-notification"></div>
			<div class="message-notification ui-corner-all growl-success" >
				<div onclick="message_close('message');" id="close-message" class="message-close">x</div>
				<div class="message-header"><?php _e("Success!",  wp_backup_bank); ?></div>
				<div class="message-message"><?php _e("Plugin Settings has been updated ",  wp_backup_bank); ?></div>
			</div>
		</div>
		<form id="ux_frm_backup_designation" action="#" method="post" class="layout-form bkup_page_width">
			<?php 
			if(file_exists(BACKUP_BK_PLUGIN_DIR."/includes/progress-bar.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR."/includes/progress-bar.php";
			}
			?>
			<div class="fluid-layout">
				<div class="layout-span12">
					<div class="widget-layout">
						<div class="widget-layout-title">
							<h4><?php _e( "Generate New Backup", wp_backup_bank ); ?></h4>
						</div>
						<div class="widget-layout-body">
							<div class="fluid-layout">
								<div class="layout-span12">
									<div class="widget-layout">
										<div class="widget-layout-title">
											<h4><?php _e("Step 6: Confirmation", wp_backup_bank); ?></h4>
										</div>
										<div class="widget-layout-body">
											<b><?php _e( "Kindly confirm the settings you have set in previous steps.", wp_backup_bank ); ?></b>
											<div class="widget-layout" style="border:2px dashed #000000 ;margin-top: 12px ;">
												<div class="fluid-layout" style="margin: 15px ;">
													<div class="layout-control-group">
														<label class="layout-control-label">
															<b>
																<?php _e("Backup Setup", wp_backup_bank); ?>
															</b>
														</label>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Backup Title", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php echo isset($backup_title) ? $backup_title : "N/A";?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Email Address for Notification", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php echo isset($backup_email) ? $backup_email : "N/A";?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Password Required for Backups", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php 
																echo (isset($pass_enable) && ($pass_enable == "1")) ? __("Yes", wp_backup_bank) : __("No", wp_backup_bank);
															?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Excluded File Extensions", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php echo $exclude_file_ext != "" ? $exclude_file_ext : "N/A"; ?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Max Execution", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php echo $time_limit; ?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Archive Name Format", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php echo $archive_name_format; ?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Archive Name", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php echo $archive_name; ?>
														</div>
													</div>
													<?php 
													if($backup_option != "1")
													{
														?>
														<div class="layout-control-group">
															<label class="layout-control-label-lbl">
																<?php _e("File Compression Type", wp_backup_bank); ?> :
															</label>
															<div class="layout-controls">
																<?php 
																	switch($file_compression)
																	{
																		case "0":
																			echo ".zip";
																		break;
																	}
																?>
															</div>
														</div>
														<?php 
													}
													if($backup_option == "0" || $backup_option == "1")
													{
														?>
														<div class="layout-control-group">
															<label class="layout-control-label-lbl">
																<?php _e("DB Compression Type", wp_backup_bank); ?> :
															</label>
															<div class="layout-controls">
																<?php
																	switch($db_compression)
																	{
																		case "0":
																			echo ".sql";
																		break;
																	}
																?>
															</div>
														</div>
														<div class="layout-control-group">
															<label class="layout-control-label">
																<b>
																	<?php _e("Backup Tables", wp_backup_bank); ?>
																</b>
															</label>
														</div>
														<div class="layout-control-group">
															<label class="layout-control-label-lbl">
																<?php _e("Backup Option", wp_backup_bank); ?> :
															</label>
															<div class="layout-controls" style="float:left;margin:0;">
																<?php 
																if($backup_tables != "")
																{
																	$backup_tbl_array = explode(";",$backup_tables);
																	for($flag1 = 0; $flag1 < count($backup_tbl_array); $flag1++)
																	{
																		echo $backup_tbl_array[$flag1]."<br/>";
																	}
																}
																else
																{
																	echo "N/A";
																}
																?>
															</div>
														</div>
														<?php
													}
													?>
													<div class="layout-control-group">
														<label class="layout-control-label">
															<b>
																<?php _e("Backup Option", wp_backup_bank); ?>
															</b>
														</label>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Backup Option", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php 
																switch($backup_option)
																{
																	case "1":
																		_e("Only Database", wp_backup_bank);
																	break;
																	case "2":
																		_e("Only WordPress", wp_backup_bank);
																	break;
																}
															?>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label">
															<b>
																<?php _e("Backup Destination", wp_backup_bank); ?>
															</b>
														</label>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Backup Destination", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php 
																switch($backup_destination)
																{
																	case "6":
																		_e("Local Folder", wp_backup_bank);
																	break;
																}
															?>
														</div>
													</div>
													<div class="layout-control-group" id="ux_txt_local_folder" style="display: none">
														<div class="layout-control-group">
															<label class="layout-control-label-lbl">
																<?php _e("Local Folder Path", wp_backup_bank); ?> :
															</label>
															<div class="layout-controls">
																<?php echo $local_folder_path; ?>
															</div>
														</div>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label">
															<b>
																<?php _e("Schedule Backup", wp_backup_bank); ?>
															</b>
														</label>
													</div>
													<div class="layout-control-group">
														<label class="layout-control-label-lbl">
															<?php _e("Schedule Backup", wp_backup_bank); ?> :
														</label>
														<div class="layout-controls">
															<?php
																_e("Manual", wp_backup_bank);
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="layout-control-group">
										<input type="button" id="ux_btn_action" onclick="proceed_to_back();" name="ux_btn_action" class="btn btn-backup-bank" value="< <?php _e("Back to Previous Step", wp_backup_bank); ?>" />
										<input type="button" id="ux_btn_submit" name="ux_btn_submit" class="btn btn-backup-bank" value="<?php _e("Confirm & Proceed to Generate Backup", wp_backup_bank ); ?>" style="float:right;" onclick="confirm_backup();" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		var backup_id = "<?php echo $backup_id; ?>";
		var timer;
		var complete_backup = 0;
		var bkup_zip_size = 0;
		var log_file_path = "<?php echo $log_file_path; ?>";
		var backup_option = "<?php echo $backup_option;?>";
	
		jQuery(document).ready(function()
		{ 
			jQuery(".multi-step li").removeClass("current");
			jQuery(".multi-step #generate_backup").addClass("current");
			jQuery(".multi-step #backup_second_step").addClass("current");
			if(backup_option == "0" || backup_option == "1")
			{
				jQuery(".multi-step #backup_third_step").addClass("current");
			}
			else
			{
				jQuery(".multi-step #backup_third_step").addClass("check_option");
			}
			jQuery(".multi-step #backup_forth_step").addClass("current");
			jQuery(".multi-step #backup_fifth_step").addClass("current");
			jQuery(".multi-step #backup_sixth_step").addClass("current");
			var destination ="<?php echo $backup_destination; ?>";
			
			switch(parseInt(destination))
			{
				case 0 :
					jQuery("#ux_txt_ftp").css("display","block");
				break;
				case 3 :
					jQuery("#ux_txt_email").css("display","block");
				break;
				case 6 : 
					jQuery("#ux_txt_local_folder").css("display","block");
				break;
			}
		});
	
		if(typeof(proceed_to_back) != "function")
		{
			function proceed_to_back()
			{
				show_overlay();
				setTimeout(function () 
				{
					window.location.href = "admin.php?page=backup_fifth_step&backup_id="+backup_id;
				}, 1000);
			}
		}
		if(typeof(confirm_backup) != "function")
		{
			function confirm_backup()
			{
				show_overlay();
				jQuery.post(ajaxurl, "&backup_id="+backup_id+"&param=insert_path_keys&action=backup_destination_library&_wpnonce=<?php echo $sixth_step_nonce;?>", function()
				{
					setTimeout(function () 
					{
						window.location.href = "admin.php?page=backup_seventh_step&backup_id="+backup_id;
					}, 1000);
				});
			}
		}
		if(typeof(show_overlay) != "function")
		{
			function show_overlay()
			{
				var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
				jQuery("body").append(overlay_opacity);
				var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
				jQuery("body").append(overlay);
	
				jQuery("body,html").animate
				({
					scrollTop: jQuery("body,html").position().top
					},"slow"
				);
			}
		}
		if(typeof(message_close) != "function")
		{
			function message_close(id)
			{
				jQuery("#"+id).css("display", "none");
			}
		}
		</script>
	<?php
	}
}
?>