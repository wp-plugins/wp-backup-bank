<?php
if (!is_user_logged_in())
{
	return;
}
else
{
	$backup_plugin_settings = $wpdb->get_results
	(
		$wpdb->prepare
		(
			"SELECT * FROM " .  backup_tbl_backup_meta() . " WHERE 
			(meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s OR meta_key = %s)",
			"show_backup_bank_plugin_menu_admin",
			"show_backup_bank_plugin_menu_editor",
			"show_backup_bank_plugin_menu_author",
			"show_backup_bank_plugin_menu_contributor",
			"show_backup_bank_plugin_menu_subscriber",
			"backup_bank_menu_top_bar"
		)
	);
	
	if (count($backup_plugin_settings) != 0)
	{
		$backup_plugin_settings_keys = array();
		for ($flag = 0; $flag < count($backup_plugin_settings); $flag++)
		{
			array_push($backup_plugin_settings_keys, $backup_plugin_settings[$flag]->meta_key);
		}
	
		$index = array_search("show_backup_bank_plugin_menu_admin", $backup_plugin_settings_keys);
		$backup_admin_role = $backup_plugin_settings[$index]->meta_value;
	
		$index = array_search("show_backup_bank_plugin_menu_editor", $backup_plugin_settings_keys);
		$backup_editor_role =$backup_plugin_settings[$index]->meta_value;
	
		$index = array_search("show_backup_bank_plugin_menu_author", $backup_plugin_settings_keys);
		$backup_author_role = $backup_plugin_settings[$index]->meta_value;
	
		$index = array_search("show_backup_bank_plugin_menu_contributor", $backup_plugin_settings_keys);
		$backup_contributor_role = $backup_plugin_settings[$index]->meta_value;
	
		$index = array_search("show_backup_bank_plugin_menu_subscriber", $backup_plugin_settings_keys);
		$backup_subscriber_role = $backup_plugin_settings[$index]->meta_value;
		
		$index = array_search("backup_bank_menu_top_bar", $backup_plugin_settings_keys);
		$backup_menu_top_bar = $backup_plugin_settings[$index]->meta_value;
	}
}
?>