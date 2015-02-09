<?php
require_once(ABSPATH . "wp-admin/includes/upgrade.php");
if(!class_exists("save_data"))
{
	class save_data
	{
		function insert_data($tbl,$data)
		{
			global $wpdb;
			$wpdb->insert($tbl,$data);
		}
	}
}

if(!function_exists("create_tbl_backup_details"))
{
	function create_tbl_backup_details()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `".backup_tbl_backup_details()."` (
			`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`type` varchar(100) NOT NULL,
			`parent_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		) DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1";
		dbDelta($sql);
	}
}

if(!function_exists("create_tbl_backup_meta"))
{
	function create_tbl_backup_meta()
	{
		$sql = "CREATE TABLE IF NOT EXISTS `".backup_tbl_backup_meta()."` (
			`meta_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
			`backup_id` int(11) NOT NULL,
			`meta_key` varchar(255) NOT NULL,
			`meta_value` longtext NOT NULL,
			PRIMARY KEY (`meta_id`)
		) DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1";
		dbDelta($sql);
	}
}

$version = get_option("backup-bank-version-number");
if($version == "")
{
	if (count($wpdb->get_var("SHOW TABLES LIKE '" . backup_tbl_backup_details() . "'")) == 0)
	{
		create_tbl_backup_details();
		
		$insert_default_plugin_settings = new save_data();
		$default_plugin_settings_meta_key = array();
		$default_plugin_settings = array();
		
		$default_plugin_settings_meta_key["type"] = "plugin_settings";
		$default_plugin_settings_meta_key["parent_id"] = 0;
		$insert_default_plugin_settings->insert_data(backup_tbl_backup_details(),$default_plugin_settings_meta_key);
		$lastId = $wpdb->insert_id;
	}

	if (count($wpdb->get_var("SHOW TABLES LIKE '" . backup_tbl_backup_meta() . "'")) == 0)
	{
		create_tbl_backup_meta();
		
		$insert_plugin_settings = new save_data();
		$plugin_setting_value = array();
		$plugin_settings = array();
		
		$plugin_settings["show_backup_bank_plugin_menu_admin"] = "1";
		$plugin_settings["show_backup_bank_plugin_menu_editor"] = "1";
		$plugin_settings["show_backup_bank_plugin_menu_author"] = "1";
		$plugin_settings["show_backup_bank_plugin_menu_contributor"] = "0";
		$plugin_settings["show_backup_bank_plugin_menu_subscriber"] = "0";
		$plugin_settings["backup_bank_menu_top_bar"] = "1";
		$plugin_settings["backup_bank_menu_top_bar"] = "1";

		foreach ($plugin_settings as $val => $innerKey)
		{
			$plugin_setting_value["backup_id"] = $lastId;
			$plugin_setting_value["meta_key"] = $val;
			$plugin_setting_value["meta_value"] = $innerKey;
			$insert_plugin_settings->insert_data(backup_tbl_backup_meta(),$plugin_setting_value);
		}
	}

	update_option("backup-bank-version-number","1.0");
	$backup_plugin_updates = get_option("backup-bank-automatic-update");
	if($backup_plugin_updates == "")
	{
		update_option("backup-bank-automatic-update",1);
	}
}
?>