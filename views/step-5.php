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
		?>
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
												<h4><?php _e("Step 4 : Schedule Backup", wp_backup_bank); ?></h4>
										</div>
										<div class="widget-layout-body backup-no-margin">
											<div class="fluid-layout backup-no-margin">
												<div class="layout-span12 responsive">
													<div class="fluid-layout">
														<div class="layout-span12 responsive">
															<div class="layout-control-group">
																<label class="layout-control-label">
																	<?php _e("Backup", wp_backup_bank); ?> : 
																	<span class="error">*</span>
																	<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
																		class="tooltip_img hovertip" data-original-title="<?php _e("Select Backup Scheduling Type Now and Schedule. If Schedule is selected the backup will be generating on the selected date and time and Now will be generating the backup instantly",wp_backup_bank) ;?>"/>
																</label>
																<div class="layout-controls backup_scheduler_lbl">
																	<input type="radio" name="ux_rdl_backup_scheduling" id="ux_rdl_backup_now" value="0" onchange="show_shedule_options(this.value);" checked="checked" />
																	<label class="bkup_rdl_label" style="vertical-align: top;">
																		<?php _e("Now", wp_backup_bank); ?>
																	</label>
																	<input type="radio" name="ux_rdl_backup_scheduling" id="ux_rdl_backup_schedule" value="1" disabled = "disabled"/>
																	<label class="bkup_rdl_label" style="vertical-align: top;">
																		<?php _e("Schedule", wp_backup_bank); ?>
																	</label><strong><i class = "standard_edition"> (Available in Premium Editions)</i></strong>
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
							<div>
								<input type="button" id="ux_btn_action_back" name="ux_btn_action_back" onclick="proceed_to_back();" class="btn btn-backup-bank" value="<< <?php _e("Back to Previous Step", wp_backup_bank); ?>" />
								<input type="button" id="ux_btn_action" name="ux_btn_action" onclick="proceed_to_next();" class="btn btn-backup-bank" value="<?php _e("Proceed to Next Step", wp_backup_bank); ?> >>" style="float:right;" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
		<script type="text/javascript">
		var backup_id = "<?php echo $backup_id; ?>";
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
		});
	
		if(typeof(proceed_to_next) != "function")
		{
			function proceed_to_next()
			{
				show_overlay();
				scroll_top();
				setTimeout(function ()
				{
					window.location.href = "admin.php?page=backup_sixth_step&backup_id="+backup_id;
				}, 1000);
			}
		}
		
		if(typeof(proceed_to_back) != "function")
		{
			function proceed_to_back()
			{
				show_overlay();
				scroll_top();
				setTimeout(function () 
				{
					window.location.href = "admin.php?page=backup_forth_step&backup_id="+backup_id;
				}, 1000);
			}
		}
	
		if(typeof(backup_rdl) != "function")
		{
			function backup_rdl()
			{
				var value = jQuery("#ux_rdl_on").prop("checked");
				if(value == false)
				{
					jQuery("#ux_rdl_display").css("display","block");
				}
				else
				{
					jQuery("#ux_rdl_display").css("display","none");
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