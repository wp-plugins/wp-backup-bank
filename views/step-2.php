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
		$step2_nonce = wp_create_nonce("backup_step2_nonce");
		?>
		<form id="ux_frm_generate_new_backup" action="#" method="post" class="layout-form bkup_page_width">
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
											<h4><?php _e("Step 2: Backup Options", wp_backup_bank); ?></h4>
										</div>
										<div class="widget-layout-body backup-no-margin">
											<div class="fluid-layout">
												<div class="layout-control-group">
													<label class="layout-control-label">
														<?php _e( "Backup options", wp_backup_bank ); ?> :
														<span class="bkup_validation_star">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
															class="tooltip_img hovertip" data-original-title="<?php _e("Select an option to create Backup like Complete Wordpress, Database, File System, Plugins, Themes, WP-Content Folder, Wordpress XML Export",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<select id="ux_ddl_backup_option" name="ux_ddl_backup_option" class="layout-span12" 
															onchange="show_divs(this.value);" >
															<option value="2"><?php _e("Only WordPress", wp_backup_bank); ?></option>
															<option value="1"><?php _e("Only Database", wp_backup_bank); ?></option>
															<option value="0" disabled = "disabled"><?php _e("Complete Backup", wp_backup_bank); ?> (Available in Premium Editions)</option>
															<option value="3" disabled = "disabled"><?php _e("Only Plugins and Themes", wp_backup_bank); ?>  (Available in Premium Editions)</option>
															<option value="4" disabled = "disabled"><?php _e("Only Themes", wp_backup_bank); ?>  (Available in Premium Editions)</option>
															<option value="5" disabled = "disabled"><?php _e("Only Plugins", wp_backup_bank); ?>  (Available in Premium Editions)</option>
															<option value="6" disabled = "disabled"><?php _e("Only WP-Content Folder", wp_backup_bank); ?>  (Available in Premium Editions)</option>
															<option value="8" disabled = "disabled"><?php _e("WordPress XML export", wp_backup_bank); ?> (Available in Premium Editions)</option>
														</select>
													</div>
												</div>
												<div class="layout-control-group" id="exclude_files">
													<label class="layout-control-label">
														<?php _e( "Exclude List", wp_backup_bank ); ?> :
														<span class="error">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
															class="tooltip_img hovertip" data-original-title="<?php _e("Enter file extensions seperated by comma to exclude the type of files from Backup",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<input type="text" class="layout-span12" name="ux_txt_exclude_files" id="ux_txt_exclude_files" placeholder = "Example : .svn, .git, .ds_store"
															value="<?php echo $exclude_file_ext != "" ? $exclude_file_ext : ".svn, .git, .ds_store";?>"/>
													</div>
												</div>
												<div class="layout-control-group" id="ux_file_compression">
													<label class="layout-control-label">
														<?php _e("File Compression", wp_backup_bank); ?> : 
														<span class="error">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"  
															class="tooltip_img hovertip" data-original-title="<?php _e("Choose Backup file compression types like zip, tar, Gzip and Bzip",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<select id="ux_ddl_compression_type" name="ux_ddl_compression_type" class="layout-span12">
															<option value="0"><?php _e(".zip", wp_backup_bank); ?></option>
															<option value="1"  disabled = "disabled"><?php _e(".tar", wp_backup_bank); ?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
															<option value="2"  disabled = "disabled"><?php _e(".tar.gz", wp_backup_bank); ?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
															<option value="3"  disabled = "disabled"><?php _e(".tar.bz2", wp_backup_bank); ?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
														</select>
													</div>
												</div>
												<div class="layout-control-group" id="ux_db_compression">
													<label class="layout-control-label">
														<?php _e("DB Compression", wp_backup_bank); ?> : 
														<span class="error">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
															class="tooltip_img hovertip" data-original-title="<?php _e("Choose Database Backup compression type like sql, sql.zip, sql.gzip and sql.bzip",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<select id="ux_ddl_db_compression_type" name="ux_ddl_db_compression_type" class="layout-span12">
															<option value="0"><?php _e(".sql", wp_backup_bank); ?></option>
															<option value="1"  disabled = "disabled"><?php _e(".sql.zip", wp_backup_bank); ?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
															<option value="2"  disabled = "disabled"><?php _e(".sql.gz", wp_backup_bank); ?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
															<option value="3"  disabled = "disabled"><?php _e(".sql.bz2", wp_backup_bank); ?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
														</select>
													</div>
												</div>
												<div class="layout-control-group">
													<label class="layout-control-label">
														<?php _e( "Time Limit", wp_backup_bank ); ?> (<?php _e( "Sec", wp_backup_bank ); ?>) :
														<span class="error">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
															class="tooltip_img hovertip" data-original-title="<?php _e("Set maximum execution Time Limit",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<input type="number" class="layout-span12" name="ux_txt_time_limit" id="ux_txt_time_limit" placeholder = "Example : 500"
															min="0" step="1" value="<?php echo (isset($time_limit) && ($time_limit != "")) ? $time_limit : "1000";?>"/>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="layout-control-group">
										<div>
											<input type="button" id="ux_btn_action" onclick="proceed_to_back();" name="ux_btn_action" class="btn btn-danger" value="<< <?php _e("Back to Previous Step", wp_backup_bank); ?>"/>
											<input type="submit" id="ux_btn_submit" name="ux_btn_submit" class="btn btn-danger" value="<?php _e( "Proceed to Next Step", wp_backup_bank ); ?> >>" style="float:right;"/>
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
		jQuery(document).ready(function ()
		{
			jQuery(".hovertip").tooltip({placement: "right"});
			jQuery(".multi-step li").removeClass("current");
			jQuery(".multi-step #generate_backup").addClass("current");
			jQuery(".multi-step #backup_second_step").addClass("current");
			
			jQuery("#ux_ddl_backup_option").val(<?php echo (isset($backup_option) && ($backup_option != "")) ? $backup_option : "2";?>);
			jQuery("#ux_ddl_compression_type").val(<?php echo (isset($file_compression) && ($file_compression != "")) ? $file_compression : "0";?>);
			jQuery("#ux_ddl_db_compression_type").val(<?php echo (isset($db_compression) && ($db_compression != "")) ? $db_compression : "0";?>);

			show_divs(jQuery("#ux_ddl_backup_option").val());
		});
	
		if(typeof(proceed_to_back) != "function")
		{
			function proceed_to_back()
			{
				show_overlay();
				scroll_top();
				setTimeout(function () 
				{
					window.location.href = "admin.php?page=generate_backup&backup_id="+backup_id;
				}, 1000);
			}
		}
	
		jQuery("#ux_frm_generate_new_backup").validate
		({
			rules:
			{
				ux_ddl_backup_option:
				{
					required:true
				},
				ux_txt_exclude_files:
				{
					required:true,
				},
				ux_ddl_compression_type:
				{
					required:true
				},
				ux_txt_time_limit:
				{
					required:true,
				}
			},
			errorPlacement: function(error, element)
			{
				jQuery(element).css("background-color","#FFCCCC");
				jQuery(element).css("border","1px solid red");
			},
			submitHandler: function(form)
			{
				show_overlay();
				jQuery.post(ajaxurl,jQuery(form).serialize()+"&backup_id="+backup_id+"&param=setup_option_details&action=backup_destination_library&_wpnonce=<?php echo $step2_nonce;?>", function() 
				{
					scroll_top();
					setTimeout(function () 
					{
						var backup_option = jQuery("#ux_ddl_backup_option").val();
						var redirect_path = (backup_option == "0" || backup_option == "1") ? "backup_third_step" : "backup_forth_step"
						window.location.href = "admin.php?page="+redirect_path+"&backup_id="+backup_id;
					}, 1000);
				});	
			}
		});
		
		if(typeof(show_divs) != "function")
		{
			function show_divs(option)
			{
				switch(option)
				{
					case "1":
						jQuery("#exclude_files").css("display","none");
						jQuery("#ux_db_compression").css("display","block");
						jQuery("#ux_file_compression").css("display","none");
						jQuery("#ux_div_tables").css("display","block");
						jQuery(".multi-step #backup_third_step").removeClass("check_option");
					break;
					default:
						jQuery("#ux_db_compression").css("display","none");
						(jQuery("#ux_ddl_compression_type").val() == 0) ? jQuery("#exclude_files").css("display","block") : jQuery("#exclude_files").css("display","none");
						jQuery("#ux_file_compression").css("display","block");
						jQuery("#ux_div_tables").css("display","none");
						jQuery(".multi-step #backup_third_step").addClass("check_option");
					break; 
				}
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
		</script>
	<?php
	} 
}
?>
