<?php
/*
Plugin Name: WP Backup Bank
Plugin URI: http://tech-banker.com
Description: Easy Backup Plugin for WordPress to create, download and restore backups of your WordPress website.
Author: Tech Banker
Version: 1.0.7
Author URI: http://tech-banker.com
License: GPLv3 or later
*/
/////////////////////////////////////  Define WP Backup Bank Constants  ////////////////////////////////////////

if (!defined("BACKUP_BK_PLUGIN_DIR")) define("BACKUP_BK_PLUGIN_DIR",  plugin_dir_path( __FILE__ ));
if (!defined("BACKUP_BK_PLUGIN_DIRNAME")) define("BACKUP_BK_PLUGIN_DIRNAME", plugin_basename(dirname(__FILE__)));
if (!defined("BACKUP_BK_CONTENT_DIR")) define("BACKUP_BK_CONTENT_DIR", dirname(dirname(BACKUP_BK_PLUGIN_DIR)));
if (!defined("BACKUP_BK_TOOLTIP")) define("BACKUP_BK_TOOLTIP", plugins_url("/assets/images/questionmark_icon.png" , __FILE__));
if (!defined("wp_backup_bank")) define("wp_backup_bank", "backup-bank");
if (!defined("tech_bank")) define("tech_bank", "tech-banker");
if (!defined("BACKUP_BANK_FILE")) define("BACKUP_BANK_FILE","wp-backup-bank/wp-backup-bank.php");
/////////////////////////////////////  Define WP Backup Bank Table Name Functions  ////////////////////////////////////////
if (!is_dir(BACKUP_BK_CONTENT_DIR . "/wp-backup-bank/"))
{
	wp_mkdir_p(BACKUP_BK_CONTENT_DIR . "/wp-backup-bank/");
}

if(!function_exists("backup_tbl_backup_details"))
{
	function backup_tbl_backup_details()
	{
		global $wpdb;
		return $wpdb->prefix . "backup_details";
	}
}
if(!function_exists("backup_tbl_backup_meta"))
{
	function backup_tbl_backup_meta()
	{
		global $wpdb;
		return $wpdb->prefix . "backup_meta";
	}
}
/////////////////////////////////////  Include Menus on Dashboard ///////////////////////////////////////////////////////////////////////////////////

if(!function_exists("create_global_menus_for_backup_bank"))
{
	function create_global_menus_for_backup_bank()
	{
		if(file_exists(BACKUP_BK_PLUGIN_DIR . "/lib/menus.php"))
		{
			global $wpdb,$current_user;
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
			if (file_exists(BACKUP_BK_PLUGIN_DIR . "/lib/get-plugin-settings.php"))
			{
				include BACKUP_BK_PLUGIN_DIR . "/lib/get-plugin-settings.php";
				switch($bb_role)
				{
					case "administrator":
						if($backup_admin_role == "1")
						{
							if (file_exists(BACKUP_BK_PLUGIN_DIR."/lib/menus.php"))
							{
								include_once BACKUP_BK_PLUGIN_DIR."/lib/menus.php";
							}
						}
					break;
					case "editor":
						if($backup_editor_role == "1")
						{
							if (file_exists(BACKUP_BK_PLUGIN_DIR."/lib/menus.php"))
							{
								include_once BACKUP_BK_PLUGIN_DIR."/lib/menus.php";
							}
						}
					break;
					case "author":
						if($backup_author_role == "1")
						{
							if (file_exists(BACKUP_BK_PLUGIN_DIR."/lib/menus.php"))
							{
								include_once BACKUP_BK_PLUGIN_DIR."/lib/menus.php";
							}
						}
					break;
				}
			}
		}
	}
}

///////////////////////////////////// This Function created for using Cascade Style Sheet at Backend. ////////////////////////////////////////

if(!function_exists("admin_panel_css_calls_for_backup_bank"))
{
	function admin_panel_css_calls_for_backup_bank()
	{
		wp_enqueue_style("backup-framework.css", plugins_url("/assets/css/framework.css",__FILE__));
		wp_enqueue_style("custom-backup-bank.css", plugins_url("/assets/css/custom-backup-bank.css",__FILE__));
		wp_enqueue_style("global.css", plugins_url("/assets/css/global.css",__FILE__));
		wp_enqueue_style("modern.css", plugins_url("/assets/css/modern.css",__FILE__));
		wp_enqueue_style("colors.css", plugins_url("/assets/css/colors.css",__FILE__));
		wp_enqueue_style("backup-premium-edition.css", plugins_url("/assets/css/premium-edition.css",__FILE__));
		wp_enqueue_style("backup-responsive.css", plugins_url("/assets/css/responsive.css",__FILE__));
		wp_enqueue_style("backup-google-fonts-roboto", "//fonts.googleapis.com/css?family=Roboto Condensed:300|Roboto Condensed:300|Roboto Condensed:300|Roboto Condensed:regular|Roboto Condensed:300");
	}
}

///////////////////////////////////// This Function created for using JavaScript at Backend. /////////////////////////////////////////////////

if(!function_exists("admin_panel_js_calls_for_backup_bank"))
{
	function admin_panel_js_calls_for_backup_bank()
	{
		wp_enqueue_script("jquery");
		wp_enqueue_script("jquery.validate.min.js", plugins_url("/assets/js/jquery.validate.min.js",__FILE__));
		wp_enqueue_script("jquery.dataTables.min.js", plugins_url("/assets/js/jquery.dataTables.min.js",__FILE__));
		wp_enqueue_script("jquery.Tooltip.js", plugins_url("/assets/js/jquery.Tooltip.js",__FILE__));
	}
}

/////////////////////////////////////  This Function creates menus on the admin bar. ////////////////////////////////////////

if(!function_exists("create_admin_menus_for_backup_bank"))
{
	function create_admin_menus_for_backup_bank($meta = true)
	{
		global $wp_admin_bar, $wpdb, $current_user;
		if (!is_user_logged_in())
		{
			return;
		}
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

		if (file_exists(BACKUP_BK_PLUGIN_DIR . "/lib/get-plugin-settings.php"))
		{
			include BACKUP_BK_PLUGIN_DIR . "/lib/get-plugin-settings.php";
			if($backup_menu_top_bar == "1")
			{
				switch($bb_role)
				{
					case "administrator":
						if($backup_admin_role == "1")
						{
							if (file_exists(BACKUP_BK_PLUGIN_DIR."/lib/top-bar-menus.php"))
							{
								include_once BACKUP_BK_PLUGIN_DIR."/lib/top-bar-menus.php";
							}
						}
					break;
					case "editor":
						if($backup_editor_role == "1")
						{
							if (file_exists(BACKUP_BK_PLUGIN_DIR."/lib/top-bar-menus.php"))
							{
								include_once BACKUP_BK_PLUGIN_DIR."/lib/top-bar-menus.php";
							}
						}
					break;
					case "author":
						if($backup_author_role == "1")
						{
							if (file_exists(BACKUP_BK_PLUGIN_DIR."/lib/top-bar-menus.php"))
							{
								include_once BACKUP_BK_PLUGIN_DIR."/lib/top-bar-menus.php";
							}
						}
					break;
				}
			}
		}
	}
}

///////////////////////////////////////////////////////Register Ajax Based Functions ///////////////////////////////////////////////////

if(isset($_REQUEST["action"]))
{
	switch($_REQUEST["action"])
	{
		case "backup_destination_library":
			add_action( "admin_init", "backup_main_class");
			if(!function_exists("backup_main_class"))
			{
				function backup_main_class()
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
					if(file_exists(BACKUP_BK_PLUGIN_DIR."lib/save-data.php"))
					{
						include_once BACKUP_BK_PLUGIN_DIR."lib/save-data.php";
					}
				}
			}
		break;
		case "backup_zip_library":
			add_action( "admin_init", "backup_library_class");
			if(!function_exists("backup_library_class"))
			{
				function backup_library_class()
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
					if(file_exists(BACKUP_BK_PLUGIN_DIR."lib/create-zip.php"))
					{
						include_once BACKUP_BK_PLUGIN_DIR."lib/create-zip.php";
					}
				}
			}
		break;
	}
}

//////////////////////////////////////////////////// Plugin Updation //////////////////////////////////////////////////////////
$is_option_auto_update = get_option("backup-bank-automatic-update");

if($is_option_auto_update == "" || $is_option_auto_update == "1")
{
	if (!wp_next_scheduled("backup_bank_auto_update"))
	{
		wp_schedule_event(time(), "daily", "backup_bank_auto_update");
	}
	add_action("backup_bank_auto_update", "backup_bank_autoUpdate");
}
else
{
	wp_clear_scheduled_hook("backup_bank_auto_update");
}

if(!function_exists("backup_bank_autoUpdate"))
{
	function backup_bank_autoUpdate()
	{
		try
		{
			require_once(ABSPATH . "wp-admin/includes/class-wp-upgrader.php");
			require_once(ABSPATH . "wp-admin/includes/misc.php");
			define("FS_METHOD", "direct");
			require_once(ABSPATH . "wp-includes/update.php");
			require_once(ABSPATH . "wp-admin/includes/file.php");
			wp_update_plugins();
			ob_start();
			$plugin_upgrader = new Plugin_Upgrader();
			$plugin_upgrader->upgrade("wp-backup-bank/wp-backup-bank.php");
			$output = @ob_get_contents();
			@ob_end_clean();
		}
		catch(Exception $e)
		{
		}
	}
}

//////////////////////////////////////////////////// Call Install Script on Plugin Activation //////////////////////////////////////////////////////////////

if(!function_exists("plugin_install_script_for_backup_bank"))
{
	function plugin_install_script_for_backup_bank()
	{
		if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/install-script.php"))
		{
			global $wpdb;
			if (is_multisite())
			{
				$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
				foreach($blog_ids as $blog_id)
				{
					switch_to_blog($blog_id);
					if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/install-script.php"))
					{
						include BACKUP_BK_PLUGIN_DIR."/lib/install-script.php";
					}
					restore_current_blog();
				}
			}
			else
			{
				if(file_exists(BACKUP_BK_PLUGIN_DIR."/lib/install-script.php"))
				{
					include_once BACKUP_BK_PLUGIN_DIR."/lib/install-script.php";
				}
			}
		}
	}
}

//--------------------------------------------------------------------------------------------------------------//
// CODE FOR PLUGIN UPDATE MESSAGE
//--------------------------------------------------------------------------------------------------------------//
function backup_bank_plugin_update_message($args)
{
	$response = wp_remote_get( 'https://plugins.svn.wordpress.org/wp-backup-bank/trunk/readme.txt' );
	if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) )
	{
		// Output Upgrade Notice
		$matches        = null;
		$regexp         = '~==\s*Changelog\s*==\s*=\s*[0-9.]+\s*=(.*)(=\s*' . preg_quote($args['Version']) . '\s*=|$)~Uis';
		$upgrade_notice = '';
		if ( preg_match( $regexp, $response['body'], $matches ) ) {
			$changelog = (array) preg_split('~[\r\n]+~', trim($matches[1]));
			$upgrade_notice .= '<div class="framework_plugin_message">';
			foreach ( $changelog as $index => $line ) {
				$upgrade_notice .= "<p>".$line."</p>";
			}
			$upgrade_notice .= '</div> ';
			echo $upgrade_notice;
		}
	}
}

///////////////////////////////////////////////////// Language Convertions/////////////////////////////////////////////////////////////////////////////

if(!function_exists("plugin_load_textdomain_wp_backup_bank"))
{
	function plugin_load_textdomain_wp_backup_bank()
	{
		load_plugin_textdomain(wp_backup_bank, false, BACKUP_BK_PLUGIN_DIRNAME ."/languages");
	}
}

////////////////////////////////////////   Un-Intall Plugin ////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists("plugin_uninstallion_backup_bank"))
{
	function plugin_uninstallion_backup_bank()
	{
		delete_option("backup-bank-automatic-update");
		wp_clear_scheduled_hook("backup_bank_auto_update");
	}
}

//////////////////////////////////////////////////////////////////  Call Hooks   ///////////////////////////////////////////////////////////////////////

//------------------------------------------------------------------------------------------------------------//
// activation Hook called for Installation_of_WP_Backup_Bank
//------------------------------------------------------------------------------------------------------------//
register_activation_hook(__FILE__,"plugin_install_script_for_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// activation Hook called for Uninstallation_of_WP_Backup_Bank
//------------------------------------------------------------------------------------------------------------//
register_uninstall_hook(__FILE__,"plugin_uninstallion_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called to include language translated files
//------------------------------------------------------------------------------------------------------------//
add_action("plugins_loaded", "plugin_load_textdomain_wp_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called to include backend Cascade Style Sheets
//------------------------------------------------------------------------------------------------------------//
add_action("admin_init", "admin_panel_css_calls_for_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called to include backend javascripts
//------------------------------------------------------------------------------------------------------------//
add_action("admin_init", "admin_panel_js_calls_for_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called to create admin menus for WP Backup Bank
//------------------------------------------------------------------------------------------------------------//
add_action("admin_bar_menu", "create_admin_menus_for_backup_bank", 100);
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called to create global menus for WP Backup Bank
//------------------------------------------------------------------------------------------------------------//
add_action("admin_menu", "create_global_menus_for_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called to create global menus for WP Backup Bank on Multi-Site
//------------------------------------------------------------------------------------------------------------//
add_action("network_admin_menu", "create_global_menus_for_backup_bank");
//------------------------------------------------------------------------------------------------------------//
// add_action Hook called for plugin update message 
//------------------------------------------------------------------------------------------------------------//
add_action("in_plugin_update_message-".BACKUP_BANK_FILE,"backup_bank_plugin_update_message" );
?>