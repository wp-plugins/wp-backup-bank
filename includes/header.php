<?php 
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
	<div id="welcome-panel" class="welcome-panel" style="width:1000px;padding:0px !important;background-color: #f9f9f9 !important">
		<div class="welcome-panel-content">
			<img src="<?php echo plugins_url("/assets/images/backup-bank.png" , dirname(__FILE__)); ?>" style="margin-top:10px;"/>
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column" style="width:240px !important;">
					<h4 class="welcome-screen-margin">
						<?php _e("Get Started", wp_backup_bank); ?>
					</h4>
						<a class="button button-primary button-hero" href="#">
							<?php _e("Watch Backup Video!", wp_backup_bank); ?>
						</a>
						<p>or,
							<a target="_blank" href="">
								<?php _e("read documentation here", wp_backup_bank); ?>
							</a>
						</p>
				</div>
				<div class="welcome-panel-column" style="width:250px !important;">
					<h4 class="welcome-screen-margin"><?php _e("Go Premium", wp_backup_bank); ?></h4>
					<ul>
						<li>
							<a href="http://tech-banker.com/products/wp-backup-bank/" target="_blank" class="welcome-icon welcome-write-blog">
								<?php _e("Features", wp_backup_bank); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-backup-bank/demo/" target="_blank" class="welcome-icon welcome-view-site">
								<?php _e("Online Demos", wp_backup_bank); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-backup-bank/pricing/" target="_blank" class="welcome-icon welcome-comments">
								<?php _e("Premium Pricing Plans", wp_backup_bank); ?>
							</a>
						</li>
					</ul>
				</div>
				<div class="welcome-panel-column" style="width:240px !important;">
					<h4 class="welcome-screen-margin">
						<?php _e("Knowledge Base", wp_backup_bank); ?>
					</h4>
					<ul>
						<li>
							<a href="http://tech-banker.com/forums/forum/backup-bank-support/" target="_blank" class="welcome-icon welcome-write-blog">
								<?php _e("Support Forum", wp_backup_bank); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-backup-bank/knowledge-base/" target="_blank" class="welcome-icon welcome-add-page">
								<?php _e("FAQ's", wp_backup_bank); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/products/wp-backup-bank/" target="_blank" class="welcome-icon welcome-view-site">
								<?php _e("Detailed Features", wp_backup_bank); ?>
							</a>
						</li>
					</ul>
				</div>
				<div class="welcome-panel-column welcome-panel-last" style="width:250px !important;">
					<h4 class="welcome-screen-margin"><?php _e("More Actions", wp_backup_bank); ?></h4>
					<ul>
						<li>
							<a href="admin.php?page=backup_recommendations" class="welcome-icon welcome-comments">
								<?php _e("Recommendations", wp_backup_bank); ?>
							</a>
						</li>
						<li>
							<a href="admin.php?page=backup_other_services" class="welcome-icon welcome-comments">
								<?php _e("Our Other Services", wp_backup_bank); ?>
							</a>
						</li>
						<li>
							<a href="http://tech-banker.com/shop/plugin-customization/order-customization-wp-backup-bank/" target="_blank" class="welcome-icon welcome-comments">
								<?php _e("Plugin Customization", wp_backup_bank); ?>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<h2 class="nav-tab-wrapper" style="width:988px;font-size:10px;">
		<a class="nav-tab" id="backup_dashboard" href="admin.php?page=backup_dashboard">
			<?php _e("Dashboard", wp_backup_bank); ?>
		</a>
		<a class="nav-tab wpab-btn-disable" id="generate_backup" href="admin.php?page=generate_backup">
			<?php _e("Generate Backup", wp_backup_bank); ?>
		</a>
		<a class="nav-tab wpab-btn-disable" id="backup_plugin_settings" href="admin.php?page=backup_plugin_settings">
			<?php _e("Plugin Settings", wp_backup_bank); ?>
		</a>
		<a class="nav-tab wpab-btn-disable" id="backup_premium_editions" href="admin.php?page=backup_premium_editions">
			<?php _e("Premium Editions", wp_backup_bank); ?>
		</a>
		<a class="nav-tab wpab-btn-disable" id="backup_recommendations" href="admin.php?page=backup_recommendations">
			<?php _e("Recommendations", wp_backup_bank); ?>
		</a>
		<a class="nav-tab wpab-btn-disable" id="backup_other_services" href="admin.php?page=backup_other_services">
			<?php _e("Our Other Services", wp_backup_bank); ?>
		</a>
	</h2>
	<?php 
		$current_page = $_REQUEST["page"];
		if($_REQUEST["page"] == "backup_second_step" || $_REQUEST["page"] == "backup_third_step" || $_REQUEST["page"] == "backup_forth_step" 
			|| $_REQUEST["page"] == "backup_fifth_step" || $_REQUEST["page"] == "backup_sixth_step" || $_REQUEST["page"] == "backup_seventh_step")
		{
			$current_page = "generate_backup";
		}
	?>
	<script type="text/javascript">
		jQuery(document).ready(function()
		{
			jQuery(".nav-tab-wrapper > a#<?php echo $current_page;?>").addClass("nav-tab-active");
		});
	</script>
	<?php 
}
?>
