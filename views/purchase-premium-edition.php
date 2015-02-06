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
		?>
		<div class="fluid-layout bkup_page_width">
			<div class="layout-span12">
				<div class="widget-layout">
					<div class="widget-layout-title">
						<h4><?php _e( "Premium Editions", wp_backup_bank ); ?></h4>
					</div>
					<div class="widget-layout-body">
						<h1 style="text-align: center; margin-bottom: 40px">
							<?php _e("WP Backup Bank is an one time Investment. Its Worth it!", cleanup_optimizer); ?>
						</h1>
						<div id="backup_bank_pricing"
							class="p_table_responsive p_table_hide_caption_column p_table_1 p_table_1_1 css3_grid_clearfix">
							<div class="caption_column column_0_responsive" style="width: 22.5%;">
								<ul>
									<li
										class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive radius5_topleft"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"></span></span></li>
									<li class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h2 class="caption">
													choose <span>your</span> plan
												</h2></span></span></li>
									<li class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Domains per License</span><span
													class="css3_grid_tooltip"><span>Number of websites that can use
															the plugin on purchase of a License.</span>Domains per License</span></span></span></span></li>
									<li class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Multisite Compatibility*</span><span
													class="css3_grid_tooltip"><span>Allows you to use this Plugin
															with network of sites / Multisites WordPress. But you need to
															have separate license for each domain. </span>Multisite
														Compatibility*</span></span></span></span></li>
									<li class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Technical Support</span><span
													class="css3_grid_tooltip"><span>Technical Support by the
															Development Team for Installation, Bug Fixing, Plugin
															Compatibility Issues.</span>Technical Support</span></span></span></span></li>
									<li class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Updates</span><span
													class="css3_grid_tooltip"><span>Automatic Plugin Update
															Notification with New Features, Bug Fixing and much more.</span>Plugin
														Updates</span></span></span></span></li>
									<li class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Manual Backups</span><span
													class="css3_grid_tooltip"><span>Schedules your backups manually
															on Local System or on Remote Destinations as per your
															instructions.</span>Manual Backups</span></span></span></span></li>
									<li class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Download Backups</span><span
													class="css3_grid_tooltip"><span>Download Backups on Local System.</span>Download
														Backups</span></span></span></span></li>
									<li class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Zip Compression</span><span
													class="css3_grid_tooltip"><span>Allows you to compress the files
															and folders without loosing the data.</span>Backup Zip
														Compression</span></span></span></span></li>
									<li class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Logs</span><span
													class="css3_grid_tooltip"><span>Generate log.txt file which would
															be send as an email attachment to your email address.</span>Backup
														Logs</span></span></span></span></li>
									<li class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Database</span><span
													class="css3_grid_tooltip"><span>This allow you to take backup for
															Database only.</span>Backups Only for Database</span></span></span></span></li>
									<li class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for File System</span><span
													class="css3_grid_tooltip"><span>This allow you to take backup for
															Files only .</span>Backups Only for File System</span></span></span></span></li>
									<li class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Local Folder </span><span
													class="css3_grid_tooltip"><span>Send your Backups to remote
															destination i.e. Email</span>Backup to Local Folder </span></span></span></span></li>
									<li class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Settings</span><span
													class="css3_grid_tooltip"><span>Allows you to control the
															capabilities of Backup Bank among different roles of WordPress
															users.</span>Plugin Settings</span></span></span></span></li>
									<li class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Restore Backups</span><span
													class="css3_grid_tooltip"><span>Restores a specific WordPress
															backup or files that are lost, damaged, or changed
															accidentally.</span>Restore Backups</span></span></span></span></li>
									<li class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to FTP </span><span
													class="css3_grid_tooltip"><span>Send your Backups to remote
															destination i.e. FTP</span>Backup to FTP </span></span></span></span></li>
									<li class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Automatic Backup </span><span
													class="css3_grid_tooltip"><span>Schedules your backups
															automatically every day, week or month on Local System or on
															Remote Destinations as per your instructions.</span>Automatic
														Backup </span></span></span></span></li>
									<li class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Dropbox</span><span
													class="css3_grid_tooltip"><span>Send your Backups to remote
															destination i.e. Dropbox</span>Backup to Dropbox</span></span></span></span></li>
									<li class="css3_grid_row_18 row_style_4 css3_grid_row_18_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Email </span><span
													class="css3_grid_tooltip"><span>Send your Backups to remote
															destination i.e. Email</span>Backup to Email </span></span></span></span></li>
									<li class="css3_grid_row_19 row_style_2 css3_grid_row_19_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Unlimited Access</span><span
													class="css3_grid_tooltip"><span>Create unlimited number of
															backups which can be either downloaded or stored to the remote
															destination.</span>Unlimited Access</span></span></span></span></li>
									<li class="css3_grid_row_20 row_style_4 css3_grid_row_20_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Themes </span><span
													class="css3_grid_tooltip"><span>This allow you to take backup of
															all Themes.</span>Backups Only for Themes </span></span></span></span></li>
									<li class="css3_grid_row_21 row_style_2 css3_grid_row_21_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">All Plugins and Themes </span><span
													class="css3_grid_tooltip"><span>This allow you to take backup of
															all Plugins and Themes.</span>All Plugins and Themes </span></span></span></span></li>
									<li class="css3_grid_row_22 row_style_4 css3_grid_row_22_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Email Notifications </span><span
													class="css3_grid_tooltip"><span>Email Notifications are the
															primary way to get notified of backups once it done.</span>Email
														Notifications </span></span></span></span></li>
									<li class="css3_grid_row_23 row_style_2 css3_grid_row_23_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Clone Migration</span><span
													class="css3_grid_tooltip"><span>Cloning and Migration allows you
															to transfer the whole WordPress to another Domain along with
															Back end.</span>Clone Migration</span></span></span></span></li>
									<li class="css3_grid_row_24 row_style_4 css3_grid_row_24_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Complete Backup </span><span
													class="css3_grid_tooltip"><span>This allow you to take complete
															backup of Wordpress including all Files and Database i.e.
															images, themes, plugins and database.</span>Complete Backup </span></span></span></span></li>
									<li class="css3_grid_row_25 row_style_2 css3_grid_row_25_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Plugins </span><span
													class="css3_grid_tooltip"><span>This allow you to take backup of
															all Plugins.</span>Backups Only for Plugins </span></span></span></span></li>
									<li class="css3_grid_row_26 row_style_4 css3_grid_row_26_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Compression Type</span><span
													class="css3_grid_tooltip"><span>Allows you to select different
															compression type for you backup such as .tar, .zip, .tar Gzip,
															and .tar Bzip2 .</span>Backup Compression Type</span></span></span></span></li>
									<li class="css3_grid_row_27 row_style_2 css3_grid_row_27_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Selected Files</span><span
													class="css3_grid_tooltip"><span>This allow you to take backup of
															selected files only.</span>Backups Only for Selected Files</span></span></span></span></li>
									<li class="css3_grid_row_28 row_style_4 css3_grid_row_28_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for WP-Content folder </span><span
													class="css3_grid_tooltip"><span>This allow you to take backup of
															WP-Content folder.</span>Backups Only for WP-Content folder </span></span></span></span></li>
									<li class="css3_grid_row_29 row_style_2 css3_grid_row_29_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar Compression</span><span
													class="css3_grid_tooltip"><span>TAR file is simply an archive, no
															compression techniques are used to reduce the size of the file.
															On Linux there are built in utilities to read the tar file.</span>Backup
														.Tar Compression</span></span></span></span></li>
									<li class="css3_grid_row_30 row_style_4 css3_grid_row_30_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar GZip Compression</span><span
													class="css3_grid_tooltip"><span>Allows you to compress the Files
															and Folders and the compressed file size will be less as
															compared to the .zip and .tar file. On Linux there are built in
															utilities to read the Gzip file.</span>Backup .Tar GZip
														Compression</span></span></span></span></li>
									<li class="css3_grid_row_31 row_style_2 css3_grid_row_31_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar BZip2 Compression</span><span
													class="css3_grid_tooltip"><span>Bzip2 is lossless data
															compression algorithm that makes it possible to retrieve the
															original data of a compressed file. On Linux there are built in
															utilities to read the Bzip2 file.</span>Backup .Tar BZip2
														Compression</span></span></span></span></li>
									<li class="css3_grid_row_32 footer_row css3_grid_row_32_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"></span></span></li>
								</ul>
							</div>
							<div class="column_1 column_1_responsive" style="width: 15.5%;">
								<div class="column_ribbon ribbon_style2_free"></div>
								<ul>
									<li
										class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h2 class="col1">Lite</h2></span></span></li>
									<li
										class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h1 class="col1">FREE</h1></span></span></li>
									<li
										class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Domains per License</span>1</span></span></span></li>
									<li
										class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Multisite Compatibility*</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Technical Support</span>None</span></span></span></li>
									<li
										class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Updates</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Manual Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Download Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Zip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Logs</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Database</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for File System</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Local Folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Settings</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Restore Backups</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to FTP </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Automatic Backup </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Dropbox</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_18 row_style_3 css3_grid_row_18_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Email </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_19 row_style_1 css3_grid_row_19_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Unlimited Access</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_20 row_style_3 css3_grid_row_20_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Themes </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_21 row_style_1 css3_grid_row_21_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">All Plugins and Themes </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_22 row_style_3 css3_grid_row_22_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Email Notifications </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_23 row_style_1 css3_grid_row_23_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Clone Migration</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_24 row_style_3 css3_grid_row_24_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Complete Backup </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_25 row_style_1 css3_grid_row_25_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Plugins </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_26 row_style_3 css3_grid_row_26_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Compression Type</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_27 row_style_1 css3_grid_row_27_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Selected Files</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_28 row_style_3 css3_grid_row_28_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for WP-Content folder </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_29 row_style_1 css3_grid_row_29_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar Compression</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_30 row_style_3 css3_grid_row_30_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar GZip Compression</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_31 row_style_1 css3_grid_row_31_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar BZip2 Compression</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li class="css3_grid_row_32 footer_row css3_grid_row_32_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><a target="_blank"
												href=""
												class="sign_up sign_up_orange radius3">Download!</a></span></span></li>
								</ul>
							</div>
							<div class="column_2 column_2_responsive" style="width: 15.5%;">
								<div class="column_ribbon ribbon_style2_heart"></div>
								<ul>
									<li
										class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h2 class="col1">Eco</h2></span></span></li>
									<li
										class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span class="css3_grid_tooltip"><span>You
														just need to pay for once for life time.</span>
												<h1 class="col1">
														&euro;<span>18</span>
													</h1>
													<h3 class="col1">one time</h3></span></span></span></li>
									<li
										class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Domains per License</span>1</span></span></span></li>
									<li
										class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Multisite Compatibility*</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Technical Support</span>1 Week</span></span></span></li>
									<li
										class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Updates</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Manual Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Download Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Zip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Logs</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Database</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for File System</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Local Folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Settings</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Restore Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to FTP </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Automatic Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Dropbox</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_18 row_style_4 css3_grid_row_18_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Email </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_19 row_style_2 css3_grid_row_19_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Unlimited Access</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_20 row_style_4 css3_grid_row_20_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_21 row_style_2 css3_grid_row_21_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">All Plugins and Themes </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_22 row_style_4 css3_grid_row_22_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Email Notifications </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_23 row_style_2 css3_grid_row_23_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Clone Migration</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_24 row_style_4 css3_grid_row_24_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Complete Backup </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_25 row_style_2 css3_grid_row_25_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Plugins </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_26 row_style_4 css3_grid_row_26_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Compression Type</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_27 row_style_2 css3_grid_row_27_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Selected Files</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_28 row_style_4 css3_grid_row_28_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for WP-Content folder </span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_29 row_style_2 css3_grid_row_29_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar Compression</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_30 row_style_4 css3_grid_row_30_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar GZip Compression</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li
										class="css3_grid_row_31 row_style_2 css3_grid_row_31_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar BZip2 Compression</span><img
													src="<?php echo plugins_url("/assets/images/cross_04.png" , dirname(__FILE__)); ?>"
													alt="no"></span></span></span></li>
									<li class="css3_grid_row_32 footer_row css3_grid_row_32_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><a
												href="http://tech-banker.com/shop/wp-backup-bank/wp-backup-bank-eco-edition/" target="_blank"
												class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
								</ul>
							</div>
							<div class="column_3 active_column column_3_responsive"
								style="width: 15.5%;">
								<div class="column_ribbon ribbon_style2_best"></div>
								<ul>
									<li
										class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h2 class="col2">Pro</h2></span></span></li>
									<li
										class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span class="css3_grid_tooltip"><span>You
														just need to pay for once for life time.</span>
												<h1 class="col1">
														&euro;<span>28</span>
													</h1>
													<h3 class="col1">one time</h3></span></span></span></li>
									<li
										class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Domains per License</span>1</span></span></span></li>
									<li
										class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Multisite Compatibility*</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Technical Support</span>1 Month</span></span></span></li>
									<li
										class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Updates</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Manual Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Download Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Zip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Logs</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Database</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for File System</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Local Folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Settings</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Restore Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to FTP </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Automatic Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Dropbox</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_18 row_style_3 css3_grid_row_18_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Email </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_19 row_style_1 css3_grid_row_19_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Unlimited Access</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_20 row_style_3 css3_grid_row_20_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_21 row_style_1 css3_grid_row_21_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">All Plugins and Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_22 row_style_3 css3_grid_row_22_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Email Notifications </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_23 row_style_1 css3_grid_row_23_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Clone Migration</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_24 row_style_3 css3_grid_row_24_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Complete Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_25 row_style_1 css3_grid_row_25_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Plugins </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_26 row_style_3 css3_grid_row_26_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Compression Type</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_27 row_style_1 css3_grid_row_27_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Selected Files</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_28 row_style_3 css3_grid_row_28_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for WP-Content folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_29 row_style_1 css3_grid_row_29_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_30 row_style_3 css3_grid_row_30_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar GZip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_31 row_style_1 css3_grid_row_31_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar BZip2 Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li class="css3_grid_row_32 footer_row css3_grid_row_32_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><a
												href="http://tech-banker.com/shop/wp-backup-bank/wp-backup-bank-pro-edition/" target = "_blank"
												class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
								</ul>
							</div>
							<div class="column_4 column_4_responsive" style="width: 15.5%;">
								<div class="column_ribbon ribbon_style2_hot"></div>
								<ul>
									<li
										class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h2 class="col1">Developer</h2></span></span></li>
									<li
										class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span class="css3_grid_tooltip"><span>You
														just need to pay for once for life time.</span>
												<h1 class="col1">
														&euro;<span>88</span>
													</h1>
													<h3 class="col1">one time</h3></span></span></span></li>
									<li
										class="css3_grid_row_2 row_style_4 css3_grid_row_2_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Domains per License</span>5</span></span></span></li>
									<li
										class="css3_grid_row_3 row_style_2 css3_grid_row_3_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Multisite Compatibility*</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_4 row_style_4 css3_grid_row_4_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Technical Support</span>1 Year</span></span></span></li>
									<li
										class="css3_grid_row_5 row_style_2 css3_grid_row_5_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Updates</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_6 row_style_4 css3_grid_row_6_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Manual Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_7 row_style_2 css3_grid_row_7_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Download Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_8 row_style_4 css3_grid_row_8_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Zip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_9 row_style_2 css3_grid_row_9_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Logs</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_10 row_style_4 css3_grid_row_10_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Database</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_11 row_style_2 css3_grid_row_11_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for File System</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_12 row_style_4 css3_grid_row_12_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Local Folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_13 row_style_2 css3_grid_row_13_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Settings</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_14 row_style_4 css3_grid_row_14_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Restore Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_15 row_style_2 css3_grid_row_15_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to FTP </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_16 row_style_4 css3_grid_row_16_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Automatic Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_17 row_style_2 css3_grid_row_17_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Dropbox</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_18 row_style_4 css3_grid_row_18_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Email </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_19 row_style_2 css3_grid_row_19_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Unlimited Access</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_20 row_style_4 css3_grid_row_20_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_21 row_style_2 css3_grid_row_21_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">All Plugins and Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_22 row_style_4 css3_grid_row_22_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Email Notifications </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_23 row_style_2 css3_grid_row_23_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Clone Migration</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_24 row_style_4 css3_grid_row_24_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Complete Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_25 row_style_2 css3_grid_row_25_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Plugins </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_26 row_style_4 css3_grid_row_26_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Compression Type</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_27 row_style_2 css3_grid_row_27_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Selected Files</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_28 row_style_4 css3_grid_row_28_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for WP-Content folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_29 row_style_2 css3_grid_row_29_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_30 row_style_4 css3_grid_row_30_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar GZip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_31 row_style_2 css3_grid_row_31_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar BZip2 Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li class="css3_grid_row_32 footer_row css3_grid_row_32_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><a
												href="http://tech-banker.com/shop/wp-backup-bank/wp-backup-bank-developer-edition/" target = "_blank"
												class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
								</ul>
							</div>
							<div class="column_1 column_5_responsive" style="width: 15.5%;">
								<div class="column_ribbon ribbon_style2_save"></div>
								<ul>
									<li
										class="css3_grid_row_0 header_row_1 align_center css3_grid_row_0_responsive radius5_topright"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><h2 class="col1">Extended</h2></span></span></li>
									<li
										class="css3_grid_row_1 header_row_2 css3_grid_row_1_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span class="css3_grid_tooltip"><span>You
														just need to pay for once for life time.</span>
												<h1 class="col1">
														&euro;<span>769</span>
													</h1>
													<h3 class="col1">one time</h3></span></span></span></li>
									<li
										class="css3_grid_row_2 row_style_3 css3_grid_row_2_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Domains per License</span>50</span></span></span></li>
									<li
										class="css3_grid_row_3 row_style_1 css3_grid_row_3_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Multisite Compatibility*</span><img src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>" alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_4 row_style_3 css3_grid_row_4_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Technical Support</span>1 Year</span></span></span></li>
									<li
										class="css3_grid_row_5 row_style_1 css3_grid_row_5_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Updates</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_6 row_style_3 css3_grid_row_6_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Manual Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_7 row_style_1 css3_grid_row_7_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Download Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_8 row_style_3 css3_grid_row_8_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Zip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_9 row_style_1 css3_grid_row_9_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Logs</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_10 row_style_3 css3_grid_row_10_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Database</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_11 row_style_1 css3_grid_row_11_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for File System</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_12 row_style_3 css3_grid_row_12_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Local Folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_13 row_style_1 css3_grid_row_13_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Plugin Settings</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_14 row_style_3 css3_grid_row_14_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Restore Backups</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_15 row_style_1 css3_grid_row_15_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to FTP </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_16 row_style_3 css3_grid_row_16_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Automatic Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_17 row_style_1 css3_grid_row_17_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Dropbox</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_18 row_style_3 css3_grid_row_18_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup to Email </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_19 row_style_1 css3_grid_row_19_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Unlimited Access</span>
													<img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes">
													</span></span></span></li>
									<li
										class="css3_grid_row_20 row_style_3 css3_grid_row_20_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_21 row_style_1 css3_grid_row_21_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">All Plugins and Themes </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_22 row_style_3 css3_grid_row_22_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Email Notifications </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_23 row_style_1 css3_grid_row_23_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Clone Migration</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_24 row_style_3 css3_grid_row_24_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Complete Backup </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_25 row_style_1 css3_grid_row_25_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Plugins </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_26 row_style_3 css3_grid_row_26_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup Compression Type</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_27 row_style_1 css3_grid_row_27_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for Selected Files</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_28 row_style_3 css3_grid_row_28_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backups Only for WP-Content folder </span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_29 row_style_1 css3_grid_row_29_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_30 row_style_3 css3_grid_row_30_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar GZip Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li
										class="css3_grid_row_31 row_style_1 css3_grid_row_31_responsive align_center"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><span><span
													class="css3_hidden_caption">Backup .Tar BZip2 Compression</span><img
													src="<?php echo plugins_url("/assets/images/tick_10.png" , dirname(__FILE__)); ?>"
													alt="yes"></span></span></span></li>
									<li class="css3_grid_row_32 footer_row css3_grid_row_32_responsive"><span
										class="css3_grid_vertical_align_table"><span
											class="css3_grid_vertical_align"><a
												href="http://tech-banker.com/shop/wp-backup-bank/wp-backup-bank-extended-edition/" target = "_blank"
												class="sign_up sign_up_orange radius3">Order Now!</a></span></span></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}
?>