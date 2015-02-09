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
		$restore_bkup = wp_create_nonce( "restore_backup_nonce");
		$delete_bkups = wp_create_nonce( "delete_backups_nonce");
		$delete_bkup = wp_create_nonce( "delete_backup_nonce");
	
		$backup_titles = $wpdb->get_results
		(
			$wpdb->prepare
			(
				"SELECT backup_id,meta_value FROM " .backup_tbl_backup_meta(). "
				 INNER JOIN ".backup_tbl_backup_details(). " ON " 
				.backup_tbl_backup_meta().".backup_id = " .backup_tbl_backup_details().".id WHERE meta_key = %s",
				"backup_title"
			)
		);

		?>
		<div id="zip_success_message" class="zip_size_div" style="display: none;">
			<div class="zip_size_inner_div">
				<span id="zip_mgs_content" style="font-size:14px;"></span>
			</div>
		</div>
		<div id="message" class="top-right message" style="display: none;">
			<div class="message-notification"></div>
			<div class="message-notification ui-corner-all growl-success" >
				<div onclick="message_close();" id="close-message" class="message-close">x</div>
				<div class="message-header"><?php _e("Success!",  wp_backup_bank); ?></div>
				<div class="message-message"><?php _e("Plugin Settings has been updated ",  wp_backup_bank); ?></div>
			</div>
		</div>
		<div id="top-error" class="top-right top-error" style="display: none;">
			<div class="top-error-notification"></div>
			<div class="top-error-notification ui-corner-all growl-top-error" >
				<div onclick="message_close();" id="close-top-error" class="top-error-close">x</div>
				<div class="top-error-header"><?php _e("Error!",  wp_backup_bank); ?></div>
				<div class="top-error-top-error" id="error_message_div"></div>
			</div>
		</div>
		<form id="ux_frm_backup_dashboard" class="bkup_page_width">
			<div class="fluid-layout">
				<div class="layout-span12">
					<div class="widget-layout">
						<div class="widget-layout-title">
							<h4>
								<?php _e("Backup Events", wp_backup_bank); ?>
							</h4>
						</div>
						<div class="widget-layout-body">
							<div class="layout-control-group">
								<select id="ux_ddl_bulk_action" name="ux_ddl_bulk_action" class="layout-span2">
									<option value="0"><?php _e("Bulk Action", wp_backup_bank); ?></option>
									<option value="1"><?php _e("Delete", wp_backup_bank); ?></option>
								</select>
								<input type="button" id="ux_btn_action" onclick="bulk_delete();" name="ux_btn_action" 
									class="btn btn-backup-bank" value="<?php _e("Apply", wp_backup_bank); ?>"/>
								<a class="btn btn-backup-bank" href="admin.php?page=generate_backup"
								><?php _e("Generate New Backup", wp_backup_bank); ?></a>
							</div>
							<div class="separator-doubled"></div>
							<table class="widefat" style="background-color:#fff !important;" id="backup-data-table-dashboard">
								<thead>
									<tr>
										<th style="width: 1%;"><input type="checkbox" id="selectall" name="selectall" style="margin:0px;"></th>
										<th style="width: 37%;"><?php _e("Backup Name", wp_backup_bank); ?></th>
										<th style="width: 18%;"><?php _e("Option", wp_backup_bank); ?></th>
										<th style="width: 14%;"><?php _e("Destination", wp_backup_bank); ?></th>
										<th style="width: 14%;"><?php _e("Schedule Type", wp_backup_bank); ?></th>
										<th style="width: 14%;"><?php _e("Backup Status", wp_backup_bank); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$alternate = "";
										for($flag = 0; $flag < count($backup_titles); $flag++)
										{
											$backup_id = $backup_titles[$flag]->backup_id;
											$backup_details = $wpdb->get_results
											(
												$wpdb->prepare
												(
													"SELECT * FROM " .backup_tbl_backup_meta() . " WHERE backup_id = %d AND 
													(meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s)",
													$backup_id,
													"backup_option",
													"backup_path",
													"backup_destination",
													"log_file_path",
													"backup_status",
													"backup_local_folder",
													"log_file_local_folder"
												)
											);

											$backup_meta_keys = array();
											for($flag1 = 0; $flag1 < count($backup_details); $flag1++)
											{
												array_push($backup_meta_keys, $backup_details[$flag1]->meta_key);
											}
	
											$index = array_search("backup_option", $backup_meta_keys);
											$backup_option = $index != "" ? $backup_details[$index]->meta_value : "";
	
											$index = array_search("backup_path", $backup_meta_keys);
											$backup_path = $index != "" ? $backup_details[$index]->meta_value : "";
											
											$index = array_search("backup_local_folder", $backup_meta_keys);
											$backup_local_folder_path = $index != "" ? $backup_details[$index]->meta_value : "";

											$index = array_search("backup_destination", $backup_meta_keys);
											$backup_destination = $backup_details[$index]->meta_value;
	
											$index = array_search("log_file_path", $backup_meta_keys);
											$log_file_path = $index != "" ? $backup_details[$index]->meta_value : "";
											
											$index = array_search("log_file_local_folder", $backup_meta_keys);
											$log_file_local_folder = $index != "" ? $backup_details[$index]->meta_value : "";
	
											$index = array_search("backup_status", $backup_meta_keys);
											$backup_status = $backup_details[$index]->meta_value;
											$alternate = (empty($alternate)) ? "alternate" : "";
											?>
											<tr class="<?php echo $alternate; ?>">
												<td>
													<input type="checkbox" class="ux_chk_delete" name="ux_chk_backup[]" value="<?php echo $backup_id; ?>" id="ux_chk_backup_<?php echo $flag; ?>" />
												</td>
												<td>
													<?php echo isset($backup_details) ? stripslashes($backup_titles[$flag]->meta_value) : "";?>
													<p style="margin: 0px;">
														<a href="admin.php?page=generate_backup&backup_id=<?php echo $backup_id;?>">
															<?php _e("Edit", wp_backup_bank); ?>
														</a> | 
														<a href="#" onclick="delete_backup(<?php echo $backup_titles[$flag]->backup_id; ?>)">
															<?php _e("Delete", wp_backup_bank); ?>
														</a>
														<?php 
														if($backup_path != "" && $backup_status == "Success" && file_exists($backup_local_folder_path))
														{
															?> |
															<a href="<?php echo $backup_path; ?>">
																<?php _e("Download", wp_backup_bank); ?>
															</a> |
															
															<?php 
														}
														else
														{
															?> |
															<a href="#" onclick = "check_file_exist();">
																<?php _e("Download", wp_backup_bank); ?>
															</a> | 
															<?php
														}
														?>
														<a href="#" onclick="restore_backup();">
															<?php _e("Restore", wp_backup_bank); ?>
														</a>
														<?php
														if(file_exists($log_file_local_folder))
														{
															?> |
															<a href="<?php echo $log_file_path;?>" target="_blank">
																<?php _e("Log Details", wp_backup_bank); ?>
															</a>
															<?php 
														}
														else
														{
															?> |
															<a href="#" onclick = "check_file_exist();">
																<?php _e("Log Details", wp_backup_bank); ?>
															</a>
															<?php 
														}
														?>
													</p>
												</td>
												<td>
													<?php 
													$bkup_option = isset($backup_details) ? $backup_option : "";
													if(isset($backup_details))
													{
														switch($backup_option)
														{
															case "1":
																_e("Only Database", wp_backup_bank);
															break;
															case "2":
																_e("Only Wordpress", wp_backup_bank);
															break;
														}
													}
													?>
												</td>
												<td>
													<?php
													$bkup_destination = isset($backup_destination) ? $backup_destination : "";
													switch($bkup_destination)
													{
														case "6":
															_e("Local Folder", wp_backup_bank);
														break;
													}
													?>
												</td>
												<td>
													<?php 
													if(isset($backup_details))
													{
														_e("Manual", wp_backup_bank);
													}
													?>
												</td>
												<td style = "font-weight:bold">
													<?php
														if($backup_status)
														{
															echo $backup_status;
														}
													?>
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
		</form>
		<script type="text/javascript">
		jQuery(document).ready(function()
		{
			oTable = jQuery("#backup-data-table-dashboard").dataTable
			({
				"bJQueryUI": false,
				"bAutoWidth": true,
				"sPaginationType": "full_numbers",
				"sDom": "<\"datatable-header\"fl>t<\"datatable-footer\"ip>",
				"oLanguage": {
				"sLengthMenu": "<span>Show entries:</span> _MENU_"
				},
				"aaSorting": [[ 1, "asc" ]],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [0] } ],
				"bFilter": false
			});
			jQuery(".dataTables_wrapper").css("margin-top","20px");
			jQuery(".datatable-header").css("float","right");
			jQuery(".datatable-header").css("margin-bottom","8px");
		});
		jQuery("#selectall").click(function()
		{
			if(jQuery("#selectall").prop("checked") == true)
			{
				jQuery("input:checkbox[name=\"ux_chk_backup[]\"]").attr("checked","checked");
			}
			else
			{
				jQuery("input:checkbox[name=\"ux_chk_backup[]\"]").removeAttr("checked");
			}
		});
		jQuery("input:checkbox[name=\"ux_chk_backup[]\"]").click(function()
		{
			if(jQuery(this).prop("checked") == false)
			{
				jQuery("#selectall").removeAttr("checked","checked");
			}
		});
		if(typeof(check_file_exist) != "function")
		{
			function check_file_exist()
			{
				jQuery("#top-error").remove();
				var premium_edition_message = jQuery("<div id=\"top-error\" class=\"top-right top-error\" style=\"display: block;\"><div class=\"top-error-notification\"></div><div class=\"top-error-notification ui-corner-all growl-top-error\" ><div onclick=\"message_close();\" id=\"close-top-error\" class=\"top-error-close\">x</div><div class=\"top-error-header\">Error!</div><div class=\"top-error-top-error\">File has been deleted from the Backup Folder!</div></div></div>");
				jQuery("body").append(premium_edition_message);
				auto_close();
			}
		}
		if(typeof(restore_backup) != "function")
		{
			function restore_backup(backup_id,backup_option)
			{
				jQuery("#top-error").remove();
				var premium_edition_message = jQuery("<div id=\"top-error\" class=\"top-right top-error\" style=\"display: block;\"><div class=\"top-error-notification\"></div><div class=\"top-error-notification ui-corner-all growl-top-error\" ><div onclick=\"message_close();\" id=\"close-top-error\" class=\"top-error-close\">x</div><div class=\"top-error-header\">Error!</div><div class=\"top-error-top-error\">This feature is available in Premium Editions!</div></div></div>");
				jQuery("body").append(premium_edition_message);
				auto_close();
			}
		}
		
		if(typeof(bulk_delete) != "function")
		{
			function bulk_delete()
			{
				if(jQuery("#ux_ddl_bulk_action").val() == "0")
				{
					jQuery("#message").css("display", "none");
					jQuery("#error_message_div").html("<?php _e( "Please choose an action first!", wp_backup_bank ); ?>");
					jQuery("#top-error").css("display", "block");
					auto_close();
					return;
				}
				else if(jQuery("input:checkbox[name=\"ux_chk_backup[]\"]:checked").length == 0)
				{
					jQuery("#message").css("display", "none");
					jQuery("#error_message_div").html("<?php _e( "Please choose atleast one Backup first!", wp_backup_bank ); ?>");
					jQuery("#top-error").css("display", "block");
					auto_close();
					return;
				}
				else
				{
					var confirm_delete =  confirm("<?php _e( "Are you sure, you want to delete these Backups ?", wp_backup_bank ); ?>");
					if(confirm_delete == true)
					{
						var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
						jQuery("body").append(overlay_opacity);
						var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
						jQuery("body").append(overlay);
	
						jQuery.post(ajaxurl,jQuery("#ux_frm_backup_dashboard").serialize()+"&param=delete_all_backups&action=backup_destination_library&_wpnonce=<?php echo $delete_bkups;?>", function(data) 
						{
							scroll_top();
							setTimeout(function () 
							{
								jQuery(".loader_opacity").remove();
								jQuery(".opacity_overlay").remove();
								jQuery("#top-error").css("display", "none");
								jQuery("#message").css("display", "block");
								jQuery(".message-message").html("<?php _e("Backups deleted Successfully.", wp_backup_bank ); ?>");
							}, 2000);
							time_out();
						});
					}
				}
			}
		}
		if(typeof(delete_backup) != "function")
		{
			function delete_backup(backup_id)
			{
				var confirm_delete =  confirm("<?php _e( "Are you sure, you want to delete this Backup?", wp_backup_bank ); ?>");
				if(confirm_delete == true)
				{
					var overlay_opacity = jQuery("<div class=\"opacity_overlay\"></div>");
					jQuery("body").append(overlay_opacity);
					var overlay = jQuery("<div class=\"loader_opacity\"><div class=\"processing_overlay\"></div></div>");
					jQuery("body").append(overlay);
	
					jQuery.post(ajaxurl,"backup_id="+backup_id+"&param=delete_backup&action=backup_destination_library&_wpnonce=<?php echo $delete_bkup;?>", function(data) 
					{
						scroll_top();
						setTimeout(function () 
						{
							jQuery(".loader_opacity").remove();
							jQuery(".opacity_overlay").remove();
							jQuery("#top-error").css("display", "none");
							jQuery("#message").css("display", "block");
							jQuery(".message-message").html("<?php _e("Backup deleted Successfully.", wp_backup_bank ); ?>");
						}, 1000);
						time_out();
					});
				}
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
		
		if(typeof(time_out) != "function")
		{
			function time_out()
			{
				setTimeout(function () {
					window.location.reload();
				}, 4000);
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
		
		if(typeof(auto_close) != "function")
		{
			function auto_close()
			{
				setTimeout(function ()
				{
					message_close()
				}, 2000);
			}
		}
		</script>
	<?php 
	}
}
?>