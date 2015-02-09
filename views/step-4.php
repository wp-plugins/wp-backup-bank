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
		$destination_nonce = wp_create_nonce("backup_destination_nonce");
		$local_folder_nonce = wp_create_nonce("backup_local_folder_nonce");
	
		if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php"))
		{
			include BACKUP_BK_PLUGIN_DIR."/lib/get-meta-values.php";
		}
		$random_number = rand(1,100000);
	/////////////////////////////////////////////////////// Set default path to Local Folder Backup destination /////////////////////////////////////////
	
		$sql_file = "";
		$date = new DateTime();
		$content_dir = str_replace("\\","/",BACKUP_BK_CONTENT_DIR);
		$backup_option = $backup_option != "" ? $backup_option : "0";
	
		$default_local_folder = $content_dir."/wp-backup-bank/".date("d-m-Y")."/";
		switch($backup_option)
		{
			case "1":
				$default_local_folder.="database/";
			break;
			case "2":
				$default_local_folder.="wordpress/";
			break;
		}
	
		switch(intval($backup_option))
		{
			case 0:
				switch(intval($file_compression))
				{
					case 0:
						$typeof_compression = ".zip";
					break;
				}
				switch(intval($db_compression))
				{
					case 0:
						$sql_file = ".sql";
					break;
				}
			break;
			case 1:
				switch(intval($db_compression))
				{
					case 0:
						$typeof_compression = ".sql";
					break;
				}
			break;
			default:
				switch(intval($file_compression))
				{
					case 0:
						$typeof_compression = ".zip";
					break;
				}
			break;
		}
		?>
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
		<form id="ux_frm_backup_destination" action="#" method="post" class="layout-form bkup_page_width">
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
											<h4><?php _e("Step 3: Backup Destination", wp_backup_bank); ?></h4>
										</div>
										<div class="widget-layout-body">
											<div class="layout-control-group">
												<label class="layout-control-label">
													<?php _e( "Archive Name", wp_backup_bank ); ?> :
													<span class="bkup_validation_star">*</span>
													<img src="<?php echo BACKUP_BK_TOOLTIP; ?>" 
														class="tooltip_img hovertip" data-original-title="<?php _e("Archive name will be showing the name of your Backup. By setting this field the Backup will be shown like this only.",wp_backup_bank);?>"/>
												</label>
												<div class="layout-controls">
													<input type="text" class="layout-span12" name="ux_txt_archive_name_format" id="ux_txt_archive_name_format" 
														value="<?php echo (isset($archive_name_format) && ($archive_name_format != "")) ? $archive_name_format : "backup_".$random_number."_%Y-%m-%d_%H-%i-%s";?>"/>
												</div>
												<div class="layout-controls" style="margin-top:5px;">
													<label style="vertical-align: top;">
														<?php _e( "Preview", wp_backup_bank ); ?> :
													</label>
													<span class="archive-span">
														<span id="archivename"><?php echo $typeof_compression;?></span>
														<span id="archive_ext" style="margin-left: -3px;"></span>
														<span id="archive_name_hidden" hidden></span>
													</span>
												</div>
											</div>
											<div class="layout-control-group">
												<label class="layout-control-label">
													<?php _e( "Backup Destination", wp_backup_bank ); ?> :
													<span class="bkup_validation_star">*</span>
													<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
														class="tooltip_img hovertip" data-original-title="<?php _e("Select a Destination where you want to store your Backup",wp_backup_bank) ;?>"/>
												</label>
												<div class="layout-controls">
													<select id="ux_ddl_backup_destination" name="ux_ddl_backup_destination" class="layout-span12">
														<option value="6"><?php _e("Local Folder", wp_backup_bank); ?></option>
														<option value="2" disabled = "disabled"><?php _e("DropBox ", wp_backup_bank);?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
														<option value="3" disabled = "disabled"><?php _e("Email", wp_backup_bank);?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
														<option value="0" disabled = "disabled"><?php _e("FTP", wp_backup_bank);?><i class = "bkup_validation_star"> (Available in Premium Editions)</i></option>
													</select>
												</div>
											</div>
											<div class="fluid-layout">
												<div class="layout-span12">
													<div class="widget-layout">
														<div class="widget-layout-title">
															<h4><?php _e("Backup Destination - Local Folder", wp_backup_bank ); ?></h4>
														</div>
														<div class="widget-layout-body">
															<div class="layout-control-group">
																<label class="layout-control-label">
																	<?php _e("Folder Location", wp_backup_bank); ?> : 
																	<span class="error">*</span>
																	<img src="<?php echo BACKUP_BK_TOOLTIP; ?>"
																		class="tooltip_img hovertip" data-original-title="<?php _e("Enter Local folder path to store Backup on Local system",wp_backup_bank) ;?>"/>
																</label>
																<div class="layout-controls">
																	<input type="text" name="ux_localfolder_location" class="layout-span12" id="ux_localfolder_location" 
																	value="<?php echo (isset($local_folder_path) && ($local_folder_path != "")) ? $local_folder_path : $default_local_folder;?>" 
																	placeholder="<?php echo _e("Example", wp_backup_bank)." : Public_html/backup"; ?>"/>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="layout-control-group">
										<input type="button" id="ux_btn_action" onclick="proceed_to_back();" name="ux_btn_action" class="btn btn-danger" value="<< <?php _e("Back to Previous Step", wp_backup_bank); ?>"/>
										<input type="submit" id="ux_btn_submit" name="ux_btn_submit" class="btn btn-danger" value="<?php _e( "Proceed to Next Step", wp_backup_bank ); ?> >>" style="float:right;"/>
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
	
			jQuery("#ux_ftp_destination").css("display","block");
			jQuery("#ux_ddl_backup_destination").val(<?php echo (isset($backup_destination) && ($backup_destination  != "")) ? $backup_destination : "6"; ?>);
			jQuery("#ux_txt_archive_name_format").keyup();
		});
	
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
		jQuery("#ux_frm_backup_destination").validate
		({
			rules:
			{
				ux_ddl_backup_destination:
				{ 
					required: true
				},
				ux_localfolder_location:
				{
					required:true
				},
				ux_txt_archive_name_format:
				{
					required: true
				}
			},
			errorPlacement: function(error, element)
			{
				jQuery(element).css("background-color","#FFCCCC");
				jQuery(element).css("border","1px solid red");
			},
			submitHandler: function(form)
			{
				jQuery(".hovertip").tooltip({placement: "right"});
				show_overlay();
				var sql_file = "";
				var backup_option = "<?php echo $backup_option; ?>";
				var destination_type = parseInt(jQuery("#ux_ddl_backup_destination").val());
				var archive_name_format = jQuery("#ux_txt_archive_name_format").val();
				var archive_name = jQuery("#archive_name_hidden").text()+jQuery("#archive_ext").text()+"<?php echo $typeof_compression; ?>";
				var log_file = jQuery("#archive_name_hidden").text()+jQuery("#archive_ext").text()+".txt";
				if(backup_option == "0")
				{
					sql_file = jQuery("#archive_name_hidden").text()+jQuery("#archive_ext").text()+"<?php echo $sql_file; ?>";
				}
	
				jQuery.post(ajaxurl, "backup_id="+backup_id+"&archive_name="+archive_name+"&destination_type="+destination_type+"&log_file="+log_file+"&archive_name_format="+archive_name_format+"&sql_file="+sql_file+
					"&param=save_destination_details&action=backup_destination_library&_wpnonce=<?php echo $destination_nonce;?>", function(data)
				{
					var local_path = jQuery("#ux_localfolder_location").val();
					jQuery.post(ajaxurl,"backup_id="+backup_id+"&local_path="+local_path+"&param=save_local_folder_details&action=backup_destination_library&_wpnonce=<?php echo $local_folder_nonce;?>", function(data)
					{
						scroll_top();
						setTimeout(function () 
						{
							window.location.href = "admin.php?page=backup_fifth_step&backup_id="+backup_id;
						}, 1000);
					});	
				});
			}
		});
	
		if(typeof(proceed_to_back) != "function")
		{
			function proceed_to_back()
			{
				show_overlay();
				scroll_top();
				setTimeout(function () 
				{
					var backup_option = "<?php echo $backup_option?>";
					var redirect_path = (backup_option == "0" || backup_option == "1" || backup_option == "7") ? "backup_third_step" : "backup_second_step";
					window.location.href = "admin.php?page="+redirect_path+"&backup_id="+backup_id;
				}, 1000);
			}
		}
		if(typeof(message_close) != "function")
		{
			function message_close(id)
			{
				jQuery("#"+id).css("display", "none");
			}
		}
	
	////////////////////////////////////////////////////////////Functions to replace backup name  //////////////////////////////////////////////////
	
		jQuery("#ux_txt_archive_name_format").keyup(function () 
		{
			var filename = jQuery(this).val();
			filename = filename.replace( '%d', date( 'd' ) );
			filename = filename.replace( '%j', date( 'j' ) );
			filename = filename.replace( '%m', date( 'm' ) );
			filename = filename.replace( '%n', date( 'n' ) );
			filename = filename.replace( '%Y', date( 'Y' ) );
			filename = filename.replace( '%y', date( 'y' ) );
			filename = filename.replace( '%a', date( 'a' ) );
			filename = filename.replace( '%A', date( 'A' ) );
			filename = filename.replace( '%B', date( 'B' ) );
			filename = filename.replace( '%g', date( 'g' ) );
			filename = filename.replace( '%G', date( 'G' ) );
			filename = filename.replace( '%h', date( 'h' ) );
			filename = filename.replace( '%H', date( 'H' ) );
			filename = filename.replace( '%i', date( 'i' ) );
			filename = filename.replace( '%s', date( 's' ) );
			jQuery("#archivename").html(backbank_htmlspecialchars( filename ));
			jQuery("#archive_name_hidden").html(backupbank_removespecialchars( filename ));
		});
		backbank_htmlspecialchars = function( string ) 
		{
			var concate = string + "<?php echo $typeof_compression;?>";
			return jQuery("<span>").text( concate ).html();
		};
		backupbank_removespecialchars = function( string )
			{
				return jQuery("<span>").text( string ).html();
			};
		if(typeof(date) != "function")
		{
			function date(format, timestamp)
			{
				// http://kevin.vanzonneveld.net
				// +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
				// +      parts by: Peter-Paul Koch (http://www.quirksmode.org/js/beat.html)
				// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
				// +   improved by: MeEtc (http://yass.meetcweb.com)
				// +   improved by: Brad Touesnard
				// +   improved by: Tim Wiel
				// +   improved by: Bryan Elliott
				//
				// +   improved by: Brett Zamir (http://brett-zamir.me)
				// +   improved by: David Randall
				// +      input by: Brett Zamir (http://brett-zamir.me)
				// +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
				// +   improved by: Brett Zamir (http://brett-zamir.me)
				// +   improved by: Brett Zamir (http://brett-zamir.me)
				// +   improved by: Theriault
				// +  derived from: gettimeofday
				// +      input by: majak
				// +   bugfixed by: majak
				// +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
				// +      input by: Alex
				// +   bugfixed by: Brett Zamir (http://brett-zamir.me)
				// +   improved by: Theriault
				// +   improved by: Brett Zamir (http://brett-zamir.me)
				// +   improved by: Theriault
				// +   improved by: Thomas Beaucourt (http://www.webapp.fr)
				// +   improved by: JT
				// +   improved by: Theriault
				// +   improved by: Rafał Kukawski (http://blog.kukawski.pl)
				// +   bugfixed by: omid (http://phpjs.org/functions/380:380#comment_137122)
				// +      input by: Martin
				// +      input by: Alex Wilson
				// +   bugfixed by: Chris (http://www.devotis.nl/)
				// %        note 1: Uses global: php_js to store the default timezone
				// %        note 2: Although the function potentially allows timezone info (see notes), it currently does not set
				// %        note 2: per a timezone specified by date_default_timezone_set(). Implementers might use
				// %        note 2: this.php_js.currentTimezoneOffset and this.php_js.currentTimezoneDST set by that function
				// %        note 2: in order to adjust the dates in this function (or our other date functions!) accordingly
				// *     example 1: date('H:m:s \\m \\i\\s \\m\\o\\n\\t\\h', 1062402400);
				// *     returns 1: '09:09:40 m is month'
				// *     example 2: date('F j, Y, g:i a', 1062462400);
				// *     returns 2: 'September 2, 2003, 2:26 am'
				// *     example 3: date('Y W o', 1062462400);
				// *     returns 3: '2003 36 2003'
				// *     example 4: x = date('Y m d', (new Date()).getTime()/1000);
				// *     example 4: (x+'').length == 10 // 2009 01 09
				// *     returns 4: true
				// *     example 5: date('W', 1104534000);
				// *     returns 5: '53'
				// *     example 6: date('B t', 1104534000);
				// *     returns 6: '999 31'
				// *     example 7: date('W U', 1293750000.82); // 2010-12-31
				// *     returns 7: '52 1293750000'
				// *     example 8: date('W', 1293836400); // 2011-01-01
				// *     returns 8: '52'
				// *     example 9: date('W Y-m-d', 1293974054); // 2011-01-02
				// *     returns 9: '52 2011-01-02'
				var that = this,jsdate,f,formatChr = /\\?([a-z])/gi,formatChrCb,
				// Keep this here (works, but for code commented-out
				// below for file size reasons)
				//, tal= [],
					_pad = function (n, c)
					{
						n = n.toString();
						return n.length < c ? _pad('0' + n, c, '0') : n;
					},
					txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
				formatChrCb = function (t, s)
				{
					return f[t] ? f[t]() : s;
				};
				f = {
					// Day
					d: function ()
					{
						// Day of month w/leading 0; 01..31
						return _pad(f.j(), 2);
					},
					D: function ()
					{
						// Shorthand day name; Mon...Sun
						return f.l().slice(0, 3);
					},
					j: function ()
					{
						// Day of month; 1..31
						return jsdate.getDate();
					},
					l: function ()
					{
						// Full day name; Monday...Sunday
						return txt_words[f.w()] + 'day';
					},
					N: function ()
					{
						// ISO-8601 day of week; 1[Mon]..7[Sun]
						return f.w() || 7;
					},
					S: function()
					{
						// Ordinal suffix for day of month; st, nd, rd, th
						var j = f.j(),
						i = j%10;
						if (i <= 3 && parseInt((j%100)/10) == 1) i = 0;
						return ['st', 'nd', 'rd'][i - 1] || 'th';
					},
					w: function ()
					{
						// Day of week; 0[Sun]..6[Sat]
						return jsdate.getDay();
					},
					z: function ()
					{
						// Day of year; 0..365
						var a = new Date(f.Y(), f.n() - 1, f.j()),
							b = new Date(f.Y(), 0, 1);
						return Math.round((a - b) / 864e5);
					},
	
					// Week
					W: function ()
					{
						// ISO-8601 week number
						var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
							b = new Date(a.getFullYear(), 0, 4);
						return _pad(1 + Math.round((a - b) / 864e5 / 7), 2);
					},
	
					// Month
					F: function ()
					{
						// Full month name; January...December
						return txt_words[6 + f.n()];
					},
					m: function ()
					{
						// Month w/leading 0; 01...12
						return _pad(f.n(), 2);
					},
					M: function ()
					{
						// Shorthand month name; Jan...Dec
						return f.F().slice(0, 3);
					},
					n: function ()
					{
						// Month; 1...12
						return jsdate.getMonth() + 1;
					},
					t: function ()
					{
						// Days in month; 28...31
						return (new Date(f.Y(), f.n(), 0)).getDate();
					},
	
					// Year
					L: function ()
					{
						// Is leap year?; 0 or 1
						var j = f.Y();
						return j % 4 === 0 & j % 100 !== 0 | j % 400 === 0;
					},
					o: function ()
					{
						// ISO-8601 year
						var n = f.n(),
							W = f.W(),
							Y = f.Y();
						return Y + (n === 12 && W < 9 ? 1 : n === 1 && W > 9 ? -1 : 0);
					},
					Y: function ()
					{
						// Full year; e.g. 1980...2010
						return jsdate.getFullYear();
					},
					y: function ()
					{
						// Last two digits of year; 00...99
						return f.Y().toString().slice(-2);
					},
	
					// Time
					a: function ()
					{
						// am or pm
						return jsdate.getHours() > 11 ? "pm" : "am";
					},
					A: function ()
					{
						// AM or PM
						return f.a().toUpperCase();
					},
					B: function ()
					{
						// Swatch Internet time; 000..999
						var H = jsdate.getUTCHours() * 36e2,
						// Hours
							i = jsdate.getUTCMinutes() * 60,
						// Minutes
							s = jsdate.getUTCSeconds(); // Seconds
						return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
					},
					g: function ()
					{
						// 12-Hours; 1..12
						return f.G() % 12 || 12;
					},
					G: function ()
					{
						// 24-Hours; 0..23
						return jsdate.getHours();
					},
					h: function ()
					{
						// 12-Hours w/leading 0; 01..12
						return _pad(f.g(), 2);
					},
					H: function ()
					{
						// 24-Hours w/leading 0; 00..23
						return _pad(f.G(), 2);
					},
					i: function ()
					{
						// Minutes w/leading 0; 00..59
						return _pad(jsdate.getMinutes(), 2);
					},
					s: function ()
					{
						// Seconds w/leading 0; 00..59
						return _pad(jsdate.getSeconds(), 2);
					},
					u: function ()
					{
						// Microseconds; 000000-999000
						return _pad(jsdate.getMilliseconds() * 1000, 6);
					},
	
					// Timezone
					e: function ()
					{
						// Timezone identifier; e.g. Atlantic/Azores, ...
						// The following works, but requires inclusion of the very large
						// timezone_abbreviations_list() function.
						/*              return that.date_default_timezone_get();
						 */
						throw 'Not supported (see source code of date() for timezone on how to add support)';
					},
					I: function ()
					{
						// DST observed?; 0 or 1
						// Compares Jan 1 minus Jan 1 UTC to Jul 1 minus Jul 1 UTC.
						// If they are not equal, then DST is observed.
						var a = new Date(f.Y(), 0),
						// Jan 1
							c = Date.UTC(f.Y(), 0),
						// Jan 1 UTC
							b = new Date(f.Y(), 6),
						// Jul 1
							d = Date.UTC(f.Y(), 6); // Jul 1 UTC
						return ((a - c) !== (b - d)) ? 1 : 0;
					},
					O: function ()
					{
						// Difference to GMT in hour format; e.g. +0200
						var tzo = jsdate.getTimezoneOffset(),
							a = Math.abs(tzo);
						return (tzo > 0 ? "-" : "+") + _pad(Math.floor(a / 60) * 100 + a % 60, 4);
					},
					P: function ()
					{
						// Difference to GMT w/colon; e.g. +02:00
						var O = f.O();
						return (O.substr(0, 3) + ":" + O.substr(3, 2));
					},
					T: function ()
					{
						return 'UTC';
					},
					Z: function ()
					{
						// Timezone offset in seconds (-43200...50400)
						return -jsdate.getTimezoneOffset() * 60;
					},
	
					// Full Date/Time
					c: function ()
					{
						// ISO-8601 date.
						return 'Y-m-d\\TH:i:sP'.replace(formatChr, formatChrCb);
					},
					r: function ()
					{
						// RFC 2822
						return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
					},
					U: function ()
					{
						// Seconds since UNIX epoch
						return jsdate / 1000 | 0;
					}
				};
				this.date = function (format, timestamp)
				{
					that = this;
					jsdate = (timestamp === undefined ? new Date() : // Not provided
						(timestamp instanceof Date) ? new Date(timestamp) : // JS Date()
							new Date(timestamp * 1000) // UNIX timestamp (auto-convert to int)
						);
					return format.replace(formatChr, formatChrCb);
				};
				return this.date(format, timestamp);
			}
		}
		</script>
	<?php
	}
} 
?>