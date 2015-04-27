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
		if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php"))
		{
			include BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php";
		}
		$date = new DateTime();
		$curr_time = date_format($date, "G-i-a");
	
		$file_name = $archive_name;
		$backup_path = BACKUP_BK_CONTENT_DIR."/wp-backup-bank/".date("d-m-Y")."/";
	
		$bkup_file_name = $file_name;
		switch($backup_option)
		{
			case "1":
				$backup_path.="database/";
				$db_file_name = $file_name;
			break;
			case "2":
				$backup_path.="wordpress/";
			break;
			
		}
	
		$log_folder_path = BACKUP_BK_CONTENT_DIR."/wp-backup-bank/".date("d-m-Y")."/logs";
		$log_folder_path = str_replace("\\","/", $log_folder_path);
		$log_file_path = $log_folder_path."/".$log_file;
		$backup_path = str_replace("\\","/", $backup_path);
	
		$backup_option == "0" ? $complete_bk_dir = $backup_path : "" ;
	
		$generate_backup_nonce = wp_create_nonce("generate_backup_nonce");
		$backup_dest_nonce = wp_create_nonce("backup_destination_nonce");
		$file_size_nonce = wp_create_nonce("file_size_nonce");
		$file_size_for_email_nonce = wp_create_nonce("file_size_for_email_nonce");
		?>
	
	<!--  error message display in case of email destination when backup size more than 15 mb  -->
	
		<div id="message" class="top-right message" style="display: none;">
			<div class="message-notification"></div>
			<div class="message-notification ui-corner-all growl-success" >
				<div onclick="message_close('message');" id="close-message" class="message-close">x</div>
				<div class="message-header"><?php _e("Success!",  wp_backup_bank); ?></div>
				<div class="message-message"><?php _e("Plugin Settings has been updated ",  wp_backup_bank); ?></div>
			</div>
		</div>
	
		<div id="top-error" class="top-right top-error" style="display: none;">
			<div class="top-error-notification"></div>
			<div class="top-error-notification ui-corner-all growl-top-error" >
				<div onclick="message_close('top-error');" id="close-top-error" class="top-error-close">x</div>
				<div class="top-error-header"><?php _e("Error!",  wp_backup_bank); ?></div>
				<div class="top-error-top-error" id="error_message_div"></div>
			</div>
		</div>
		<form id="ux_frm_backup_schedule" class="layout-form bkup_page_width" method="post">
			<?php 
			if(file_exists(BACKUP_BK_PLUGIN_DIR."/includes/progress-bar.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR."/includes/progress-bar.php";
			}
			?>
			<div class="fluid-layout">
				<div class="layout-span12 responsive">
					<div class="widget-layout">
						<div class="widget-layout-title">
							<h4><?php _e( "Generate New Backup", wp_backup_bank ); ?></h4>
						</div>
						<div class="widget-layout-body">
							<div class="fluid-layout">
								<div class="layout-span12 responsive">
									<div class="widget-layout">
										<div class="widget-layout-title">
												<h4><?php _e("Step 7 : Backup Process", wp_backup_bank); ?></h4>
										</div>
										<div class="widget-layout-body backup-no-margin">
											<div class="fluid-layout backup-no-margin">
												<div class="layout-span12 responsive">
													<div class="fluid-layout">
														<div class="layout-span12 responsive">
															<div class="layout-control-group">
																<label class="layout-control-label">
																	<?php _e("File Compression", wp_backup_bank); ?> : 
																	<span class="error">*</span>
																	<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
																		class="tooltip_img hovertip" data-original-title="<?php _e("Compressed Archive status in percentage",wp_backup_bank) ;?>"/>
																</label>
																<div class="layout-controls backup_scheduler_lbl">
																	<div class="backup_progress_div">
																		<div id="backup_progress_bar" class="backup_progress_bar">
																		0%
																		</div>
																	</div>
																</div>
															</div>
															<div class="layout-control-group">
																<label class="layout-control-label">
																	<?php _e("Backup Tasks", wp_backup_bank); ?> : 
																	<span class="error">*</span>
																	<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
																		class="tooltip_img hovertip" data-original-title="<?php _e("Showing running task of Backup Process",wp_backup_bank) ;?>"/>
																</label>
																<div class="layout-controls backup_scheduler_lbl">
																	<div class="backup_progress_div">
																		<div id="progress_steps_bar" class="backup_progress_bar">
																			0%
																		</div>
																	</div>
																</div>
																<div class="layout-controls backup_scheduler_lbl">
																	<div id="progress_steps" class="progress_steps">
																		<?php _e("Compressing Archive",wp_backup_bank) ;?>
																	</div>
																</div>
																<div class="layout-controls backup_scheduler_lbl">
																	<div id="progress_msg" class="progress_msg">
																		<?php _e("Be patient, Backup Process may take few minutes.",wp_backup_bank) ;?>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
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
		var backup_id = "<?php echo $backup_id; ?>";
		var timer;
		var bkup_zip_size = 0;
		var Iferror = 0;
		var backup_option = "<?php echo $backup_option;?>";
	
		jQuery(document).ready(function()
		{
			jQuery(".hovertip").tooltip({placement: "right"});
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
			jQuery(".multi-step #backup_seventh_step").addClass("current");
			generate_backup();
		});
		
		if(typeof(zip_size) != "function")
		{
			function zip_size(zip_file_path)
			{
				jQuery.post(ajaxurl,"&zip_file_path="+zip_file_path+"&backup_id="+backup_id+"&param=file_size&action=backup_destination_library&_wpnonce=<?php echo $file_size_nonce;?>", function(data)
				{
					var responce_data = data.split(";");
					var zip_percentage = responce_data[0];
					var steps = responce_data[1];
					bkup_zip_size = responce_data;
	
					var str = jQuery("#backup_progress_bar").html();
					var match = str.search("100");
					if(match == "-1")
					{
						jQuery("#backup_progress_bar").css("width",zip_percentage+"%");
						jQuery("#backup_progress_bar").html(zip_percentage+"%");
					}
	
					var str_steps = jQuery("#progress_steps").html();
					var match = str_steps.search("Destination");
					if((match != "-1") && (parseInt(steps) < 6))
					{
						steps = "7";
					}
	
					switch(steps)
					{
						case "0":
							jQuery("#progress_steps_bar").css("width","10%");
							jQuery("#progress_steps_bar").html("10%");
							jQuery("#progress_steps").html("<?php _e("Compressing Archive", wp_backup_bank); ?>");
							jQuery("#backup_progress_bar").css("width","20%");
							jQuery("#backup_progress_bar").html("20%");
						break;
						case "1":
							jQuery("#progress_steps_bar").css("width","50%");
							jQuery("#progress_steps_bar").html("50%");
							jQuery("#progress_steps").html("<?php _e("Archive created", wp_backup_bank); ?>");
							
						break;
						case "2":
							jQuery("#progress_steps_bar").css("width","10%");
							jQuery("#progress_steps_bar").html("10%");
							jQuery("#progress_steps").html("<?php _e("Creating Database Sql file", wp_backup_bank); ?>");
						break;
						case "3":
							jQuery("#progress_steps_bar").css("width","55%");
							jQuery("#progress_steps_bar").html("60%");
							jQuery("#progress_steps").html("<?php _e("Creating Database Sql file", wp_backup_bank); ?>");
						break;
						case "4":
							jQuery("#progress_steps_bar").css("width","65%");
							jQuery("#progress_steps_bar").html("65%");
							jQuery("#progress_steps").html("<?php _e("Database Sql file created", wp_backup_bank); ?>");
						break;
						case "5":
							jQuery("#progress_steps_bar").css("width","80%");
							jQuery("#progress_steps_bar").html("80%");
							jQuery("#progress_steps").html("<?php _e("Creating Archive", wp_backup_bank); ?>");
							jQuery("#backup_progress_bar").css("width","50%");
							jQuery("#backup_progress_bar").html("50%");
						break;
						case "6":
							jQuery("#progress_steps_bar").css("width","60%");
							jQuery("#progress_steps_bar").html("60%");
							jQuery("#progress_steps").html("<?php _e("Adding Files to Archive", wp_backup_bank); ?>");
							jQuery("#backup_progress_bar").css("width","50%");
							jQuery("#backup_progress_bar").html("50%");
						break;
						case "7":
							jQuery("#progress_steps_bar").css("width","65%");
							jQuery("#progress_steps_bar").html("65%");
							jQuery("#progress_steps").html("<?php _e("Moving Backup to Destination", wp_backup_bank); ?>");
							jQuery("#backup_progress_bar").css("width","100%");
							jQuery("#backup_progress_bar").html("100%");
						break;
						case "8":
							jQuery("#progress_steps_bar").css("width","100%");
							jQuery("#progress_steps_bar").html("100%");
							jQuery("#backup_progress_bar").css("width","100%");
							jQuery("#backup_progress_bar").html("100%");
							jQuery("#progress_steps").html("<?php _e("Backup Process complete", wp_backup_bank); ?>");
						break;
					}
				});
			}
		}
		if(typeof(generate_backup) != "function")
		{
			function generate_backup()
			{
				var backup_path = "<?php echo $backup_path;?>";
				var file_archive_type = "<?php echo $file_compression;?>";
				var db_archive_type = "<?php echo $db_compression;?>";
				var file_name = "<?php echo $bkup_file_name;?>";
				var backup_option = "<?php echo $backup_option;?>";
				var backup_destination = "<?php echo $backup_destination;?>";
				var curr_time = "<?php echo $curr_time;?>";
				var zip_file_path = backup_path+file_name;
				var backup_id = "<?php echo $backup_id;?>";
				var log_file_path = "<?php echo $log_file_path;?>";
				var db_file_name = "<?php echo isset($db_file_name) ? $db_file_name : ""; ?>";
				var backup_destination_path = "<?php echo $local_folder_path;?>";
				var exclude_file = "<?php echo $exclude_file_ext ?>";
	
				jQuery.post(ajaxurl,"&backup_destination_path="+backup_destination_path+"&db_archive_type="+db_archive_type+"&file_archive_type="+
						file_archive_type+"&curr_time="+curr_time+"&backup_path="+backup_path+"&backup_option="+backup_option+"&file_name="+file_name
					+"&backup_destination="+backup_destination+"&backup_id="+backup_id+"&log_file_path="+log_file_path+"&db_file_name="+db_file_name+"&exclude_file="+exclude_file+
					"&param=create_backup_zip&action=backup_zip_library&_wpnonce=<?php echo $generate_backup_nonce;?>", function(data)
				{
					if(data == "memory_execution_time")
					{
						jQuery("#progress_steps_bar").css("width","65%");
						jQuery("#progress_steps_bar").html("65%");
						jQuery("#progress_steps").css("color","red");
						jQuery("#progress_steps").html("<?php _e("Increase the Time Limit while generating the backup.", wp_backup_bank); ?>");
	
						jQuery("#message").css("display","none");
						jQuery("#top-error").css("display","block");
						jQuery("#error_message_div").html("<?php _e("Maximum execution time limit reached", wp_backup_bank); ?>");
	
						setTimeout(function () 
						{
							jQuery("#top-error").css("display", "none");
							window.location.href="admin.php?page=backup_dashboard";
						}, 7000);
						Iferror = 1;
					}
					clearInterval(timer);
					if(Iferror == 0)
					{
						move_to_destination();
					}
					function move_to_destination()
					{
						var backup_path = "<?php echo $backup_path;?>";
						var file_name = "<?php echo $bkup_file_name;?>";
						var backup_option = "<?php echo $backup_option;?>";
						var backup_destination = "<?php echo $backup_destination;?>";
						var curr_time = "<?php echo $curr_time;?>";
						var zip_file_path = backup_path+file_name;
						var backup_id = "<?php echo $backup_id;?>";
						var log_file_path = "<?php echo $log_file_path;?>";
						var db_file_name = "<?php echo isset($db_file_name) ? $db_file_name : ""; ?>";
	
						clearInterval(timer);
						jQuery("#progress_steps").html("<?php _e("Moving Backup to Destination", wp_backup_bank); ?>");
						jQuery("#progress_steps_bar").css("width","65%");
						jQuery("#progress_steps_bar").html("65%");
						jQuery("#backup_progress_bar").css("width","100%");
						jQuery("#backup_progress_bar").html("100%");
	
						jQuery.post(ajaxurl,"&backup_id="+backup_id+"&backup_option="+backup_option+"&backup_path="+backup_path+
							"&file_name="+file_name+"&backup_destination="+backup_destination+"&db_file_name="+db_file_name+"&log_file_path="+log_file_path+
							"&param=move_zip_to_destination&action=backup_zip_library&_wpnonce=<?php echo $backup_dest_nonce;?>", function(data)
						{
							jQuery("#progress_steps_bar").css("width","100%");
							jQuery("#progress_steps_bar").html("100%");
							jQuery("#progress_steps").html("<?php _e("Backup Process complete", wp_backup_bank); ?>");
	
							scroll_top();
							setTimeout(function () 
							{
								jQuery("#zip_mgs_content").html("<strong><?php _e("Backup Generated Successfully!", wp_backup_bank); ?>");
								window.location.href="admin.php?page=backup_dashboard";
							}, 2000);
						});
					}
				});
				timer = setInterval(function() {zip_size(zip_file_path);}, 1500);
			}
		}
		if(typeof(scroll_top) != "function")
		{
			function scroll_top()
			{
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