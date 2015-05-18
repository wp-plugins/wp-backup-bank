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
		$step1_nonce = wp_create_nonce("backup_step1_nonce");
		
		if(isset($_REQUEST["backup_id"]))
		{
			if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php"))
			{
				include BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php";
			}
		}
		?>
		<form id="ux_frm_generate_backup"  method="post" class="layout-form bkup_page_width">
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
							<h4><?php _e("Generate New Backup", wp_backup_bank ); ?></h4>
						</div>
						<div id="bkup-nav-bar" class="widget-layout-body" >
							<div class="fluid-layout" >
								<div class="layout-span12">
									<div class="widget-layout">
										<div class="widget-layout-title">
											<h4><?php _e("Step 1: Backup Setup", wp_backup_bank ); ?></h4>
										</div>
										<div class="widget-layout-body">
											<div class="layout-control-group">
												<label class="layout-control-label">
													<?php _e("Backup Name", wp_backup_bank ); ?> :
													<span class="bkup_validation_star">*</span>
													<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
														class="tooltip_img hovertip" data-original-title="<?php _e("Set the name for your Backup",wp_backup_bank) ;?>"/>
												</label>
												<div class="layout-controls">
													<input type="text" class="layout-span12"  id="ux_txt_backup_title" name="ux_txt_backup_title" 
														value="<?php echo isset($backup_title) ? stripslashes($backup_title) 
														: __("Untitled Backup", wp_backup_bank );?>" placeholder="<?php _e("Enter the Title for your Backup", wp_backup_bank ); ?>"/>
												</div>
											</div>
											<div class="layout-control-group">
												<label class="layout-control-label">
													<?php _e("Email Address", wp_backup_bank ); ?> :
													<span class="bkup_validation_star">*</span>
													<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
														class="tooltip_img hovertip" data-original-title="<?php _e("Enter your email address to get all Email Notifications",wp_backup_bank) ;?>"/>
												</label>
												<div class="layout-controls">
													<input type="text" class="layout-span12" id="ux_txt_email_address" name="ux_txt_email_address" 
														value="<?php echo isset($backup_email) ? $backup_email : get_option("admin_email"); ?>" 
														placeholder="<?php _e("Enter Email Address", wp_backup_bank ); ?>"/>
												</div>
											</div>
											<div id="password_show" style="display: none;">
												<div class="layout-control-group">
													<div class="layout-controls">
														<input type="checkbox" <?php echo (isset($pass_enable) && ($pass_enable == "1")) ? "checked=\"checked\"" : "";?> id="ux_chk_set_password" 
															name="ux_chk_set_password" value="1" onclick="show_password();" class="bkup_margin_chk"/>
														<label>
															<?php _e("Do you want to set password for your Backup", wp_backup_bank); ?>
														</label>
													</div>
												</div>
												<div class="layout-control-group">
													<label class="layout-control-label">
														<?php _e("Password", wp_backup_bank ); ?> :
														<span class="bkup_validation_star">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
															class="tooltip_img hovertip" data-original-title="<?php _e("Enter a password to make this backup Password Protected",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<input type="password" class="layout-span12" id="ux_password" name="ux_password" 
														value="<?php echo isset($password) ? stripslashes($password) : "";?>" 
														placeholder="<?php _e("Enter Your Password", wp_backup_bank ); ?>"/>
													</div>
												</div>
												<div class="layout-control-group">
													<label class="layout-control-label">
														<?php _e("Confirm Password", wp_backup_bank ); ?> :
														<span class="bkup_validation_star">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
															class="tooltip_img hovertip" data-original-title="<?php _e("Re-enter the password for confirmation",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls">
														<input type="password" class="layout-span12" id="ux_confirm_password" name="ux_confirm_password" 
														value="<?php echo isset($password) ? stripslashes($password) : "";?>" 
														placeholder="<?php _e("Confirm Password", wp_backup_bank ); ?>"/>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="layout-control-group">
										<input type="submit" id="ux_btn_submit" name="ux_btn_submit" class="btn btn-backup-bank" 
										value="<?php _e("Proceed to Next Step", wp_backup_bank ); ?> >>" style="float:right;"/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		jQuery(document).ready(function()
		{
			jQuery(".hovertip").tooltip({placement: "right"});
			jQuery(".multi-step li").removeClass("current");
			jQuery(".multi-step #generate_backup").addClass("current");
			show_password();
		});
		if(typeof(show_password) != "function")
		{
			function show_password()
			{
				if(jQuery("#ux_chk_set_password").prop("checked") == "1")
				{
					jQuery("#password_show").css("display","block");
				}
				else
				{
					jQuery("#password_show").css("display","none");
				}
			}
		}
		jQuery("#ux_frm_generate_backup").validate
		({
			rules:
			{
				ux_txt_backup_title:
				{
					required:true
				},
				ux_txt_email_address:
				{
					required:true,
					email:true
				},
				ux_password:
				{
					required:true
				},
				ux_confirm_password:
				{
					required:true,
					equalTo: "#ux_password"
				}
			},
			errorPlacement: function(error, element)
			{
				jQuery(element).css("background-color","#FFCCCC");
				jQuery(element).css("border","1px solid red");
			},
			submitHandler: function(form)
			{
				var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
				jQuery("body").append(overlay_opacity);
				var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
				jQuery("body").append(overlay);
				var backup_id = "<?php echo isset($backup_id) ? $backup_id : "0"; ?>";
				jQuery.post(ajaxurl,jQuery(form).serialize()+"&backup_id="+backup_id+"&param=save_setup_details&action=backup_destination_library&_wpnonce=<?php echo $step1_nonce;?>", function(data) 
				{
					<?php 
					if(isset($_REQUEST["backup_id"]))
					{
						?>
						var backupId = <?php echo intval($_REQUEST["backup_id"]);?>;
						<?php 
					}
					else
					{
						?>
						var backupId = data;
						<?php
					}
					?>
					jQuery("body,html").animate
					({
						scrollTop: jQuery("body,html").position().top
						},"slow"
					);
					setTimeout(function () 
					{
						window.location.href = "admin.php?page=backup_second_step&backup_id="+backupId;
					}, 1000);
				});	
			}
		});
		</script>
	<?php
	}
}
?>