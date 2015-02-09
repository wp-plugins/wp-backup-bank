<?php
//--------------------------------------------------------------------------------------------------------------//
// CODE FOR CREATING MENUS
//---------------------------------------------------------------------------------------------------------------//
if (!is_user_logged_in())
{
	return;
}
else
{
	add_menu_page("WP Backup Bank", __("WP Backup Bank", wp_backup_bank), "read", "backup_dashboard", "",plugins_url("/assets/images/backup.png" , dirname(__FILE__)));
	add_submenu_page("backup_dashboard", "Dashboard", __("Dashboard", wp_backup_bank), "read", "backup_dashboard","backup_dashboard");
	add_submenu_page("backup_dashboard", "Generate Backup", __("Generate Backup", wp_backup_bank), "read", "generate_backup","generate_backup");
	add_submenu_page("backup_dashboard", "Plugin Settings", __("Plugin Settings", wp_backup_bank), "read", "backup_plugin_settings","backup_plugin_settings");
	add_submenu_page("backup_dashboard", "Plugin Updates", __("Plugin Updates", wp_backup_bank), "read", "backup_plugin_updates","backup_plugin_updates");
	add_submenu_page("backup_dashboard","Premium Editions", __("Premium Editions", wp_backup_bank), "read", "backup_premium_editions","backup_premium_editions");
	add_submenu_page("backup_dashboard", "Recommendations", __("Recommendations", wp_backup_bank), "read", "backup_recommendations","backup_recommendations");
	add_submenu_page("backup_dashboard","Our Other Services", __("Our Other Services", wp_backup_bank), "read", "backup_other_services","backup_other_services");
	add_submenu_page("backup_dashboard", "System Status", __("System Status", wp_backup_bank), "read", "backup_system_status","backup_system_status");
	add_submenu_page("", "", "", "read", "backup_second_step","backup_second_step");
	add_submenu_page("", "", "", "read", "backup_third_step","backup_third_step");
	add_submenu_page("", "","", "read", "backup_forth_step","backup_forth_step");
	add_submenu_page("", "","", "read", "backup_fifth_step","backup_fifth_step");
	add_submenu_page("", "","", "read", "backup_sixth_step","backup_sixth_step");
	add_submenu_page("", "","", "read", "backup_seventh_step","backup_seventh_step");
	
	if(!function_exists("backup_dashboard"))
	{
		function backup_dashboard()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/dashboard.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/dashboard.php";
			}
		}
	}
	
	if(!function_exists("backup_plugin_settings"))
	{
		function backup_plugin_settings()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/plugin-settings.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/plugin-settings.php";
			}
		}
	}
	
	if(!function_exists("generate_backup"))
	{
		function generate_backup()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-1.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-1.php";
			}
		}
	}
	
	if(!function_exists("backup_second_step"))
	{
		function backup_second_step()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-2.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-2.php";
			}
		}
	}
	
	if(!function_exists("backup_third_step"))
	{
		function backup_third_step()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-3.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-3.php";
			}
		}
	}
	
	if(!function_exists("backup_forth_step"))
	{
		function backup_forth_step()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-4.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-4.php";
			}
		}
	}
	
	if(!function_exists("backup_fifth_step"))
	{
		function backup_fifth_step()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-5.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-5.php";
			}
		}
	}
	
	if(!function_exists("backup_sixth_step"))
	{
		function backup_sixth_step()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-6.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-6.php";
			}
		}
	}
	
	if(!function_exists("backup_seventh_step"))
	{
		function backup_seventh_step()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/step-7.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/step-7.php";
			}
		}
	}
	
	if(!function_exists("backup_system_status"))
	{
		function backup_system_status()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/system-status.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/system-status.php";
			}
		}
	}
	
	if(!function_exists("backup_premium_editions"))
	{
		function backup_premium_editions()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/purchase-premium-edition.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/purchase-premium-edition.php";
			}
		}
	}
	
	if(!function_exists("backup_recommendations"))
	{
		function backup_recommendations()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/recommended-plugins.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/recommended-plugins.php";
			}
		}
	}
	
	if(!function_exists("backup_other_services"))
	{
		function backup_other_services()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/other-services.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/other-services.php";
			}
		}
	}
	if(!function_exists("backup_plugin_updates"))
	{
		function backup_plugin_updates()
		{
			global $wpdb,$current_user,$user_role_permission;
			if(is_super_admin())
			{
				$bb_role = "administrator";
			}
			else
			{
				$bb_role = $wpdb->prefix . "capabilities";
				$current_user->role = array_keys($current_user->$bb_role);
				$bb_role = $current_user->role[0];
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/includes/header.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/includes/header.php";
			}
			if(file_exists(BACKUP_BK_PLUGIN_DIR . "/views/automatic-plugin-update.php"))
			{
				include_once BACKUP_BK_PLUGIN_DIR . "/views/automatic-plugin-update.php";
			}
		}
	}
}
?>