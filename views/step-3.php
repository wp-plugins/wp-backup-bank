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
		$step3_nonce = wp_create_nonce("backup_db_tables_nonce");
		$selected_tables = explode(";",$backup_tables);
		
		if(is_multisite())
		{
			if(is_main_site())
			{
				$tables =  $wpdb->get_results
				(
					"SHOW TABLE STATUS FROM `".DB_NAME."`"
				);
			}
			else
			{
				$condition = "";
				$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
				foreach($blog_ids as $blog_id)
				{
					$condition.= " AND Name NOT LIKE '". $wpdb->prefix . $blog_id ."%'";
				}
				$tables =  $wpdb->get_results
				(
					"SHOW TABLE STATUS FROM `".DB_NAME."` WHERE Name LIKE '".$wpdb->prefix."%'" . $condition
				);
			}
		}
		else
		{
			$tables =  $wpdb->get_results
			(
				"SHOW TABLE STATUS FROM `".DB_NAME."`"
			);
		}
		$table_names = array();
		for($flag =0; $flag<count($tables); $flag++)
		{
			array_push($table_names, $tables[$flag]->Name);
		}
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
											<h4><?php _e("Step 3: Database Backup", wp_backup_bank); ?></h4>
										</div>
										<div class="widget-layout-body backup-no-margin">
											<div class="fluid-layout">
												<div class="layout-control-group" id="ux_div_tables">
													<label class="layout-control-label">
														<?php _e( "Backup Tables", wp_backup_bank ); ?> :
														<span class="bkup_validation_star">*</span>
														<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
															class="tooltip_img hovertip" data-original-title="<?php _e("Select tables for which you want to create Backup",wp_backup_bank) ;?>"/>
													</label>
													<div class="layout-controls bkup_margin_chk_rdl">
														<table class="widefat" style="background-color:#fff !important;clear:none;" id="backup-tables">
															<thead>
																<tr>
																	<th style="width: 2%;">
																		<input type="checkbox" id="selectall" name="selectall" onclick="check_tables();" style="margin:0px;" class="select_all"/>
																	</th>
																	<th style="width: 98%;">
																		<?php _e("Choose Tables for Backup", wp_backup_bank); ?>
																	</th>
																</tr>
															</thead>
															<tbody class = "all_chks">
																<?php 
																	for($flag1=0; $flag1 < count($table_names); $flag1++)
																	{
																		$alternate = $flag1 % 2 == 0 ? "alternate" : "";
																		?>
																			<tr class="<?php echo $alternate; ?>">
																				<td>
																					<input type="checkbox" id="ux_tables_<?php echo $flag1;?>" name="ux_tables[]" value="<?php echo $table_names[$flag1];?>" class="dynamic_chk"/>
																				</td>
																				<td>
																					<label class="backup-layout-controls-label">
																						<?php echo $table_names[$flag1];?>
																					</label>
																				</td>
																			</tr>
																		<?php
																	}
																?>
															</tbody>
														</table>
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
		var chk_tables_array = [];
		jQuery(document).ready(function ()
		{
			jQuery(".hovertip").tooltip({placement: "right"});
			jQuery(".multi-step li").removeClass("current");
			jQuery(".multi-step #generate_backup").addClass("current");
			jQuery(".multi-step #backup_second_step").addClass("current");
			jQuery(".multi-step #backup_third_step").addClass("current");
			check_tables();
			<?php 
				if(!empty($backup_tables))
				{
					for($flag2=0; $flag2<count($selected_tables); $flag2++)
					{
						?>
						jQuery("input[value=\"<?php echo $selected_tables[$flag2];?>\"]").prop("checked", "checked");
						<?php
					}
					?>
					var get_checkbox = jQuery(".dynamic_chk").length;
					var selected_checkboxes = jQuery("[name='ux_tables[]']:checked").length;
					if(get_checkbox == selected_checkboxes)
					{
						jQuery(".select_all").prop("checked", "checked");
					}
					<?php
				}
				else
				{
					?>
					jQuery(".select_all").prop("checked", "checked");
					jQuery(".dynamic_chk").prop("checked", "checked");
					<?php
				}
			?>
		});
		
		if(typeof(proceed_to_back) != "function")
		{
			function proceed_to_back()
			{
				show_overlay();
				scroll_top();
				setTimeout(function () 
				{
					window.location.href = "admin.php?page=backup_second_step&backup_id="+backup_id;
				}, 1000);
			}
		}
	
		jQuery("#ux_frm_generate_new_backup").validate
		({
			submitHandler: function(form)
			{
				var searchIDs = jQuery(".all_chks input:checkbox:checked").map(function()
				{
					chk_tables_array.push(jQuery(this).val());
				}).get();
				if(chk_tables_array != "")
				{
					show_overlay();
					var backup_id = "<?php echo $backup_id; ?>";
					jQuery.post(ajaxurl,jQuery(form).serialize()+"&backup_id="+backup_id+"&param=db_tables_details&action=backup_destination_library&_wpnonce=<?php echo $step3_nonce;?>", function() 
					{
						scroll_top();
						setTimeout(function () 
						{
							window.location.href = "admin.php?page=backup_forth_step&backup_id="+backup_id;
						}, 1000);
					});
				}
				else
				{
					var error_message = jQuery("<div id=\"top-error\" class=\"top-right top-error\" style=\"display: block;\"><div class=\"top-error-notification\"></div><div class=\"top-error-notification ui-corner-all growl-top-error\" ><div onclick=\"error_message_close();\" id=\"close-top-error\" class=\"top-error-close\">x</div><div class=\"top-error-header\"><?php _e("Error!",  wp_backup_bank); ?></div><div class=\"top-error-top-error\"><?php _e( "Please choose a table to proceed!", wp_backup_bank ); ?></div></div></div>");
					jQuery("body").append(error_message);
				}
			}
		});
	
		function check_tables()
		{
			var select_all_tbls = jQuery("#selectall").prop("checked");
			if(select_all_tbls == true)
			{
				jQuery("input[name=\"ux_tables[]\"]").attr("checked","checked");
			}
			else
			{
				jQuery("input[name=\"ux_tables[]\"]").removeAttr("checked");
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
		if(typeof(error_message_close) != "function")
		{
			function error_message_close()
			{
				jQuery("#top-error").remove();
			}
		}
		</script>
	<?php
	}
}
?>