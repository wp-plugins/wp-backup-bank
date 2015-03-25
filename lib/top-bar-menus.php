<?php
if (!is_user_logged_in()) 
{
	return;
}
else
{
	$wp_admin_bar->add_menu(array
	(
		"id" => "wp_backup_links",
		"title" => "<img src=\"" . plugins_url("/assets/images/backup.png", dirname(__file__)) .
		"\" width=\"25\" height=\"25\" style=\"vertical-align:text-top; margin-right:5px;\" />WP Backup Bank",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_dashboard",
	));
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_dashboard_link",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_dashboard",
		"title" => __("Dashboard", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_generate_backup_links",
		"href" => site_url() . "/wp-admin/admin.php?page=generate_backup",
		"title" => __("Generate Backup", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_plugin_settings_links",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_plugin_settings",
		"title" => __("Plugin Settings", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_plugin_updates_link",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_plugin_updates",
		"title" => __("Plugin Updates", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_premium_editions_links",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_premium_editions",
		"title" => __("Premium Editions", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_recommendations_links",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_recommendations",
		"title" => __("Recommendations", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_other_services_links",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_other_services",
		"title" => __("Our Other Services", wp_backup_bank))
	);
	$wp_admin_bar->add_menu(array
	(
		"parent" => "wp_backup_links",
		"id" => "backup_system_status_link",
		"href" => site_url() . "/wp-admin/admin.php?page=backup_system_status",
		"title" => __("System Status", wp_backup_bank))
	);
}
?>