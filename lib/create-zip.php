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
	
	///////////////////////////////////////////////////////// Creating Zip file /////////////////////////////////////////////////////////////////////////////
	
		if(isset($_REQUEST["param"]))
		{
			/////////////////////////////////////// Common variables for all params ////////////////////////////////
			error_reporting(E_ALL);
			$log_file_path = esc_attr($_REQUEST["log_file_path"]);
			$backup_id = intval($_REQUEST["backup_id"]);
			
			$backup_keys = $wpdb->get_results
			(
				$wpdb->prepare
				(
					"Select meta_key,meta_value from " .backup_tbl_backup_meta(). " Where backup_id = %d And (meta_key = %s Or meta_key = %s)",
					$backup_id,
					"time_limit",
					"exclude_file_ext"
				)
			);
	
			$backup_meta_keys = array();
			for ($flag1 = 0; $flag1 < count($backup_keys); $flag1++)
			{
				array_push($backup_meta_keys, $backup_keys[$flag1]->meta_key);
			}
	
			$index = array_search("time_limit", $backup_meta_keys);
			$max_time_limit = $backup_keys[$index]->meta_value;
	
			$index = array_search("exclude_file_ext", $backup_meta_keys);
			$exclude_file_ext = $backup_keys[$index]->meta_value;
	
			$time_limit  = count($max_time_limit) > 0 ? $max_time_limit : "1000";
			ini_set("max_execution_time",$time_limit);
			ini_set("memory_limit","-1"); // set memory limit here
			
			function error_reporting_function($buffer,$backup_id)
			{
				if (false !== (stripos($buffer,"<b>Fatal error</b>")))
				{
					if (false !== (stripos($buffer,"Maximum execution")))
					{
						$buffer = "memory_execution_time";
					}
				}
				return $buffer;
			}
			
			ob_start("error_reporting_function");
	
			////////////////////////////////////////////////////////// function to write content in log file  ////////////////////////////////////////////////
	
			if(!function_exists("create_log_file"))
			{
				function create_log_file($log_file_path,$file_content)
				{
					$file = fopen($log_file_path,"a+");
					fwrite($file, pack("CCC",0xef,0xbb,0xbf));
					$file_content = "[".date("d-m-Y")." ".date("G:i:s")." (UTC)] ".$file_content;
					fwrite($file,$file_content);
					fclose($file);
				}
			}
	
			if(!function_exists("update_backup_steps"))
			{
				function update_backup_steps($backup_id,$steps)
				{
					global $wpdb;
					$value = array();
					$where = array();
					$where["backup_id"] = $backup_id;
					$where["meta_key"] = "backup_steps";
					$value["meta_value"] = $steps;
					$wpdb->update(backup_tbl_backup_meta(),$value,$where);
				}
			}
			$steps = 0; /////////////////////////////// zip compression start
			update_backup_steps($backup_id,$steps);
	
		//////////////////////////////////////////////// function to update keys in meta_table /////////////////////////////////////////////
	
			if(!class_exists("save_data"))
			{
				class save_data
				{
					function update_backup_keys($tbl,$values,$where)
					{
						global $wpdb;
						$wpdb->update($tbl,$values,$where);
					}
				}
			}
	
			//////////////////////////////////////////////////////////// code to get total no of files in backup directory ///////////////////////////////
	
			if(!class_exists("total_files"))
			{
				class total_files
				{
					var $total_no_files = 0;
					var $backup_id = "";
					function count_files($src)
					{
						$dir = opendir($src);
						while(false !== ( $file = readdir($dir)) )
						{
							if (( $file != "." ) && ( $file != ".." ))
							{
								if ( is_dir($src . "/" . $file) )
								{
									$this->total_no_files++;
									$this->count_files($src . "/" . $file);
								}
								else
								{
									$this->total_no_files++;
								}
							}
						}
						closedir($dir);
					}
	
					function update_data()
					{
						global $wpdb;
						$value = array();
						$where = array();
						$where["backup_id"] = $this->backup_id;
						$where["meta_key"] = "total_no_of_files";
						$value["meta_value"] = $this->total_no_files;
						$wpdb->update(backup_tbl_backup_meta(),$value,$where);
					}
				}
			}
			
			if(!class_exists("Archive"))
			{
				class Archive
				{
					public $backup_id = NULL;
					public $folders_to_backup = NULL;
					public $files_to_backup = NULL;
					public $archive_file = NULL;
					public $ziparchive = NULL;
					public $folders = array();
					public $file = array();
					public $backup_folder = NULL;
					public $exclude_files = array();
					public $files = array();
					public $counter = 0;
					public $log_file = NULL;
					public $count_file = 1;
					public $backup_filesize = 0;
					public $filesize = 0;
					public $total_no_files = 0;
				
					public function __construct( $file, $backup_folder, $exclude_files, $log_file, $backup_id)
					{
						$this->backup_id = $backup_id;
						$this->log_file = $log_file;
						$this->exclude_files = (($exclude_files != "")) ? explode(",",$exclude_files) : "" ;
						$this->backup_folder = $backup_folder;
						$this->archive_file = $file;
						$this->ziparchive = new ZipArchive();
						$this->path = trailingslashit(str_replace('\\', '/', realpath( ABSPATH )));
						$ziparchive_open = $this->ziparchive->open( $this->archive_file, ZipArchive::CREATE );
						if ( $ziparchive_open !== TRUE )
						{
							$file_content = __("Cannot Open Zip File") . "."."\n\r";
							create_log_file($this->log_file, $file_content);
						}
						else
						{
							$count_files = 1;
							$count_folder = 1;
							$get_backup_folders = $this->folders_to_backup($this->backup_folder);
							while($folder = array_shift($get_backup_folders))
							{
								$files_in_folder = $this->files_to_backup($folder);
								if ( empty( $files_in_folder ) )
								{
									$folder_name_in_archive = trim( ltrim( str_replace( $this->path, "", $folder ), "/" ) );
									if ( ! empty ( $folder_name_in_archive ) )
										$this->add_empty_folder( $folder, $folder_name_in_archive, $count_folder);
										$count_folder++;
									continue;
								}
								while ( $file = array_shift( $files_in_folder ) )
								{
									$name_in_archive = ltrim( str_replace( $this->path, "", $file ), "/" );
									$this->add_File($file, $name_in_archive,$count_files);
									$count_files++;
								}
							}
						}
					}
				
					public function add_File($file_name, $name_in_archive = "", $count_files)
					{
						$file_name = trim($file_name);
						if(empty($name_in_archive))
						{
							$name_in_archive = $file_name;
						}
						$name_in_archive = str_replace( array("?", "[", "]", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0)) , '', $name_in_archive );
						$file_size = abs( (int) filesize( $file_name ) );
						if($file_size < ( 1024 * 1024 * 2))
						{
							$this->ziparchive->addFromString( $name_in_archive, file_get_contents( $file_name ));
							$this->count_file++;
							if($count_files == 1)
							{
								$steps = 6; ////////////////////////// adding files to zip
								update_backup_steps($this->backup_id,$steps);
							}
						}
						else
						{
							$this->ziparchive->addFile( $file_name, $name_in_archive );
							$this->count_file++;
						}
					}
				
					public function folders_to_backup($backup_folder)
					{
						if($this->counter == 0)
						{
							$this->folders [] = str_replace("\\","/",$backup_folder."/");
						}
						$folder = scandir($backup_folder);
						foreach($folder as $subfolder)
						{
							if(($subfolder != ".") && ($subfolder != ".."))
							{
								if(is_dir($backup_folder."/".$subfolder) && (is_dir($backup_folder)))
								{
									$this->folders [] = str_replace("\\","/",$backup_folder."/".$subfolder."/");
									$this->counter = 1;
									$this->folders_to_backup($backup_folder."/".$subfolder);
								}
							}
						}
						return $this->folders;
					}
				
					public function files_to_backup($folder)
					{
						$matched = 0;
						$files = array();
						$folder = trailingslashit( $folder );
						if($dir = opendir($folder))
						{
							while(FALSE !== ($file = readdir($dir)))
							{
								if (( in_array( $file, array( '.', '..' ) )) || (is_dir( $folder . $file )))
									continue;
								if(($this->exclude_files != ""))
								{
									$path_info = pathinfo($folder.$file,PATHINFO_EXTENSION);
									$file_extension = $path_info;
									for($flag = 0; $flag < count($this->exclude_files); $flag++)
									{
										$exclusion = str_replace(".","",$this->exclude_files[$flag]);
										if($file_extension == $exclusion)
										{
											$matched = 1;
										}
									}
									($matched == 0) ? $files [] = $folder . $file : $matched = 0;
								}
							}
						}
						closedir($dir);
						return $files;
					}
						
					public function add_empty_folder( $folder_name, $name_in_archive = "", $count )
					{
						$this->ziparchive->addEmptyDir( $name_in_archive );
						if($count == 1)
						{
							$file_content = __("Trying to add Folders into Archive", wp_backup_bank).".\r\n";
							create_log_file($this->log_file,$file_content);
							$this->count_folders($this->backup_folder);
							$file_content = $this->total_no_files.__(" Folders in Archive", wp_backup_bank).".\r\n";
							create_log_file($this->log_file,$file_content);
							$steps = 5; /////////////////////////// creating folders
							update_backup_steps($this->backup_id,$steps);
						}
					}
					
					public function __destruct()
					{
						if (is_object($this->ziparchive))
						{
							$file_content = __("Archive contains", wp_backup_bank)." ".$this->count_file." ".__("files", wp_backup_bank).".\r\n";
							create_log_file($this->log_file,$file_content);
							
							$file_content = __("Backup Archive created Successfully", wp_backup_bank).".\r\n";
							create_log_file($this->log_file,$file_content);

							$this->ziparchive->close();
							$file_info = round(filesize($this->archive_file)/1000,2);
							$file_content = __("Backup Archive size is", wp_backup_bank)." ".$file_info." Kb.\r\n";
							create_log_file($this->log_file,$file_content);
						}
					}
					
					public function count_folders($backup_folder)
					{
						$dir = opendir($backup_folder);
						while(false !== ( $file = readdir($dir)) )
						{
							if (( $file != "." ) && ( $file != ".." ))
							{
								if ( is_dir($backup_folder . "/" . $file) )
								{
									$this->total_no_files++;
									$this->count_folders($backup_folder . "/" . $file);
								}
							}
						}
						closedir($dir);
					}
				}
			}
			
			switch($_REQUEST["param"])
			{
				case "create_backup_zip":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "generate_backup_nonce"))
					{
						$date = new DateTime();
						$file_archiving_type = esc_attr($_REQUEST["file_archive_type"]);
						$db_compression = esc_attr($_REQUEST["db_archive_type"]);
						$curr_time = isset($_REQUEST["curr_time"]) ? $_REQUEST["curr_time"] : date_format($date, "G-i-a");
						$backup_path = esc_attr($_REQUEST["backup_path"]);
						$bkup_file_name = esc_attr($_REQUEST["file_name"]);
						$backup_option = esc_attr($_REQUEST["backup_option"]);
						$backup_destination = esc_attr($_REQUEST["backup_destination"]);
						$db_file_name = esc_attr($_REQUEST["db_file_name"]);
						$archive_type = $backup_option == "1" ? " Sql file " : " Achive ";
						$file_info = 0;
						$exclude_files = esc_attr($_REQUEST["exclude_file"]);
						$backup_destination_path = esc_attr($_REQUEST["backup_destination_path"]);
	
						switch($backup_option)
						{
							case "1":
								$backup_option_str = __("Only Database", wp_backup_bank);
							break;
							case "2":
								$backup_option_str = __("Only WordPress", wp_backup_bank);
							break;
						}
						switch($backup_destination)
						{
							case "6":
								$backup_destination_str = __("Local Folder", wp_backup_bank);
							break;
						}
	
	///////////////////////////////////////////////////////////////////// Create log file /////////////////////////////////////////////////////////////////
						$backup_title = $wpdb->get_var
						(
							$wpdb->prepare
							(
								"SELECT meta_value FROM ".backup_tbl_backup_meta() . " WHERE backup_id = %d AND meta_key = %s",
								$backup_id,
								"backup_title"
							)
						);
	
						$log_folder_path = BACKUP_BK_CONTENT_DIR."/wp-backup-bank/".date("d-m-Y")."/logs";
						wp_mkdir_p($log_folder_path);
	
						$update = new save_data();
						$log_file_name = explode("/wp-backup-bank/",$log_file_path)[1];
						$log_file_url = content_url()."/wp-backup-bank/".$log_file_name;
						$form = array();
						$form["meta_value"] = $log_file_url;
						$where = array();
						$where["backup_id"] = $backup_id;
						$where["meta_key"] = "log_file_path";
						$update->update_backup_keys(backup_tbl_backup_meta(),$form,$where);

						$form = array();
						$form["meta_value"] = str_replace("\\","/",WP_CONTENT_DIR."/wp-backup-bank/".$log_file_name);
						$where = array();
						$where["backup_id"] = $backup_id;
						$where["meta_key"] = "log_file_local_folder";
						$update->update_backup_keys(backup_tbl_backup_meta(),$form,$where);
						
						$values = array();
						$values["meta_value"] = time();
						$where = array();
						$where["backup_id"] = $backup_id;
						$where["meta_key"] = "backup_start_time";
						$update->update_backup_keys(backup_tbl_backup_meta(),$values,$where);
						
						if(file_exists($log_file_path))
						{
							unlink($log_file_path);
						}
						
						$exclude_file_ext = $exclude_file_ext != "" ? $exclude_file_ext : "N/A";
						$file_content = __("Backup Title", wp_backup_bank)." : ".$backup_title."\r\n";
						$file_content .= __("Backup Option", wp_backup_bank)." : ".$backup_option_str."\r\n";
						$file_content .= __("Backup Destination", wp_backup_bank)." : ".$backup_destination_str."\r\n";
						if($backup_option == "1")
						{
							switch(intval($db_compression))
							{
								case 0:
									$file_content .= __("Compression Type", wp_backup_bank)." : ".__("Sql", wp_backup_bank)."\r\n";
								break;
							}
						}
						else
						{
							switch($file_archiving_type)
							{
								case 0:
									$file_content .= __("Compression Type", wp_backup_bank)." : ".__("Zip/Archive", wp_backup_bank)."\r\n";
								break;
							}
						}
						$file_content .= __("Excluded Files", wp_backup_bank)." : ".$exclude_file_ext."\r\n";
						$file_content .= __("Archive Name", wp_backup_bank)." : ".$bkup_file_name."\r\n";
						$file_content .= __("Start Time", wp_backup_bank)." : ".date("G:i:s")." (".__("UTC", wp_backup_bank).")\r\n";
						$file_content .= __("Php Version", wp_backup_bank)." : ".esc_html(phpversion())."\r\n";
						$file_content .= __("MySql Version", wp_backup_bank)." : ".$wpdb->db_version()."\r\n";
						$file_content .= __("Php Max Execution Time", wp_backup_bank)." : ".ini_get("max_execution_time")."\r\n";
						$file_content .= __("Php Max Upload Size", wp_backup_bank)." : ".ini_get("upload_max_filesize")."\r\n\r\n";
	
						$file = fopen($log_file_path,"a+");
						fwrite($file, pack("CCC",0xef,0xbb,0xbf));
						fwrite($file,$file_content);
						fclose($file);
	
	/////////////////////////////////////////////////////////////////// Log file code end here ////////////////////////////////////////////////////////////
	
						if(!function_exists("backup_file_size_log"))
						{
							function backup_file_size_log($backup_path,$log_file_path)
							{
								$file_content = __("Backup Archive created Successfully", wp_backup_bank).".\r\n";
								create_log_file($log_file_path,$file_content);
	
								$file_info = round(filesize($backup_path)/1000,2);
								$file_content = __("Backup Archive size is", wp_backup_bank)." ".$file_info." Kb.\r\n";
								create_log_file($log_file_path,$file_content);
	
								$zip_ach = new ZipArchive();
								$zip_ach->open($backup_path);
								$file_content = __("Archive contains", wp_backup_bank)." ".$zip_ach->numFiles." ".__("files", wp_backup_bank).".\r\n";
								$zip_ach->close();
								create_log_file($log_file_path,$file_content);
							}
						}
						
						switch(intval($backup_option))
						{
							case 1:
								$steps = 2; ///////////////////////////////creating sql file in only database backup 
								update_backup_steps($backup_id,$steps);
	
								$file_content = __("Creating Sql file of database. Please be patient, it may take a moment", wp_backup_bank).".\r\n";
								create_log_file($log_file_path,$file_content);
								
								if(file_exists(BACKUP_BK_PLUGIN_DIR . "lib/database-sql.php"))
								{
									include BACKUP_BK_PLUGIN_DIR . "lib/database-sql.php";
								}
								$bkup_file_name = $db_file_name;
								$backup_path = $sql_file_full_path;
	
								$steps = 4; /////////////////////////////// sql file created
								update_backup_steps($backup_id,$steps);
							break;
							case 2:
								$base_dir = dirname(BACKUP_BK_CONTENT_DIR);
								$chk_htdocs = explode("\\",$base_dir);
								$chk_htdocs = $chk_htdocs[count($chk_htdocs)-1];
								if($chk_htdocs == "htdocs")
								{
									$backup_of_folder = dirname($base_dir);
								}
								else
								{
									$backup_of_folder = $base_dir;
								}
	
								wp_mkdir_p(BACKUP_BK_CONTENT_DIR."/wp-backup-bank/".date("d-m-Y")."/wordpress");
								$backup_path = $backup_path.$bkup_file_name;
	
						//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
								switch($file_archiving_type)
								{
									case 0:
										//                        Creating ZIP File                            //
										$file_content = __("Compressing files as Zip. Please be patient, it may take a moment", wp_backup_bank).".\r\n";
										create_log_file($log_file_path,$file_content);
										
										//////////////////////////////////////////// update total no of files in backup directory ////////////////////////////////
										
										$total_file_obj = new total_files();
										$total_file_obj->count_files($backup_of_folder);
										$total_file_obj->backup_id = $backup_id;
										$total_file_obj->update_data();
										
										$create_backup = new Archive($backup_path,$backup_of_folder,$exclude_files,$log_file_path,$backup_id);
									break;
								}
							break;
						}
						$update = new save_data();
						$values = array();
						$archive_file_path = explode("/wp-backup-bank/",$backup_path)[1];
						$values["meta_value"] = content_url()."/wp-backup-bank/".$archive_file_path;
						$where = array();
						$where["backup_id"] = $backup_id;
						$where["meta_key"] = "backup_path";
						$update->update_backup_keys(backup_tbl_backup_meta(),$values,$where);
						
						$values["meta_value"] = str_replace("\\","/",WP_CONTENT_DIR."/wp-backup-bank/".$archive_file_path);
						$where = array();
						$where["backup_id"] = $backup_id;
						$where["meta_key"] = "backup_local_folder";
						$update->update_backup_keys(backup_tbl_backup_meta(),$values,$where);
						
						ob_end_flush();
						die();
					}
				break;
				case "move_zip_to_destination":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_destination_nonce"))
					{
						$bkup_file_name = esc_attr($_REQUEST["file_name"]);
						$backup_path = esc_attr($_REQUEST["backup_path"]).$bkup_file_name;
						$backup_option = esc_attr($_REQUEST["backup_option"]);
						$backup_destination = esc_attr($_REQUEST["backup_destination"]);
						$archive_type = $backup_option == "1" ? __("Sql file", wp_backup_bank) : __("Archive", wp_backup_bank);
	
						if(!function_exists("update_backup_destination_time"))
						{
							function update_backup_destination_time($backup_id)
							{
								global $wpdb;
								$form = array();
								$form["meta_value"] =  time();
								$where = array();
								$where["backup_id"] = $backup_id;
								$where["meta_key"] = "backup_destination_time";
								$wpdb->update(backup_tbl_backup_meta(),$form,$where);
							}
						}
						if(!class_exists("save_data"))
						{
							class save_data
							{
								function update_backup_keys($tbl,$values,$where)
								{
									global $wpdb;
									$wpdb->update($tbl,$values,$where);
								}
							}
						}
						
						$update = new save_data();
						$values = array();
						$where = array();
						$values["meta_value"] = "Success";
						$where["backup_id"] = $backup_id;
						$where["meta_key"] = "backup_status";
						$update->update_backup_keys(backup_tbl_backup_meta(),$values,$where);
	
						if($_REQUEST["db_file_name"] != "" && $backup_option == "1")
						{
							$backup_path = esc_attr($_REQUEST["backup_path"]).$_REQUEST["db_file_name"];
							$bkup_file_name = $_REQUEST["db_file_name"];
						}
						
						switch($backup_destination)
						{
							case "6":
								$steps = 7; /////////////////////////////// moving backup to destination
								update_backup_steps($backup_id,$steps);
	
								$destination_details = $wpdb->get_results
								(
									$wpdb->prepare
									(
										"SELECT * FROM " .backup_tbl_backup_meta(). " WHERE backup_id = %d AND (meta_key = %s OR meta_key = %s)",
										$backup_id,
										"local_folder_path",
										"backup_start_time"
									)
								);
								
								$backup_meta_keys = array();
								for($flag = 0; $flag < count($destination_details); $flag++)
								{
									array_push($backup_meta_keys, $destination_details[$flag]->meta_key);
								}
	
								$index = array_search("local_folder_path", $backup_meta_keys);
								$local_folder_path = $destination_details[$index]->meta_value;
	
								$index = array_search("backup_start_time", $backup_meta_keys);
								$start_time = $destination_details[$index]->meta_value;
	
								$local_folder_path = rtrim($local_folder_path, "/");
								$local_folder_path = rtrim($local_folder_path, "\\");
								wp_mkdir_p($local_folder_path);
								strstr($local_folder_path."/".$bkup_file_name,$backup_path);
	
								$file_content = __("Trying to send Backup", wp_backup_bank)." ".$archive_type." ".__("to", wp_backup_bank)." ".$local_folder_path.".\r\n";
								create_log_file($log_file_path,$file_content);
	
								if(!strstr($local_folder_path."/".$bkup_file_name,$backup_path))
								{
									if(copy($backup_path,$local_folder_path."/".$bkup_file_name))
									{
										$file_content = __("Backup", wp_backup_bank)." ".$archive_type." ".__("sent to", wp_backup_bank)." ".$local_folder_path.".\r\n";
										create_log_file($log_file_path,$file_content);
									}
									else
									{
										$last_error = "";
										if(error_get_last())
										{
											$error_details = error_get_last();
											$last_error = __("Error", wp_backup_bank)." : ".$error_details["message"]." ".__("in", wp_backup_bank)." ".$error_details["file"];
										}
										$file_content = __("Fail to send Backup", wp_backup_bank)." ".$archive_type." ".__("to", wp_backup_bank)." ".$local_folder_path.".".$last_error."\r\n";
										create_log_file($log_file_path,$file_content);
									}
								}
								else
								{
									$file_content = __("Backup", wp_backup_bank)." ".$archive_type." ".__("sent to", wp_backup_bank)." ".$local_folder_path.".\r\n";
									create_log_file($log_file_path,$file_content);
								}
								update_backup_destination_time($backup_id);
	
								$time_diff = time() - $start_time;
								$file_content = __("Backup Process complete in", wp_backup_bank)." ".$time_diff." ".__("seconds", wp_backup_bank).".";
								create_log_file($log_file_path,$file_content);
	
								$steps = 8; /////////////////////////////// backup send to destination
								update_backup_steps($backup_id,$steps);
							break;
						}
					}
				break;
			}
		}
	}
}
?>