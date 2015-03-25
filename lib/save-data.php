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
		if(!class_exists("save_data"))
		{
			class save_data
			{
				function insert_data($tbl,$data)
				{
					global $wpdb;
					$wpdb->insert($tbl,$data);
				}
				
				function update_records($tbl,$form,$where)
				{
					global $wpdb;
					$wpdb->update($tbl,$form,$where);
				}
				
				function delete_records($tbl,$where)
				{
					global $wpdb;
					$wpdb->delete($tbl,$where);
				}
				
				function multi_delete($tbl,$keys,$backup_id)
				{
					global $wpdb;
					$wpdb->query
					(
						$wpdb->prepare
						(
							"DELETE FROM ".$tbl." WHERE backup_id = %d AND meta_key IN (".$keys.")",
							$backup_id
						)
					);
				}
			}
		}
		
		if(!class_exists("FlxZipArchive"))
		{
			class FlxZipArchive extends ZipArchive
			{
				function addDir($location, $name)
				{
					$this->addEmptyDir($name);
					$this->addDirDo($location, $name);
				}
				function addDirDo($location, $name)
				{
					$name .= '/';
					$location .= '/';
					
					$dir = opendir ($location);
					while ($file = readdir($dir))
					{
						if ($file == '.' || $file == '..') continue;
	
						$do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
						$this->$do($location . $file, $name . $file);
					}
				}
			}
		}
	
		if(!class_exists("Restoring_Backup"))
		{
			class Restoring_Backup
			{
				function bkup_fetch_file($file_path)
				{
					$file_info = pathinfo($file_path);
					if(is_file( BACKUP_BK_CLONE_PATH . $file_info["basename"]))
					{
						return BACKUP_BK_CLONE_PATH.$file_info["basename"];
					}
					else
					{
						$url = download_url($file_path, 750);
						if(is_wp_error($url))
						{
							echo is_wp_error($url);
						}
						else
						{
							return $url;
						}
					}
				}
				
				function processing_database($db_file)
				{
					$content = file_get_contents($db_file);
					$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
					if(false === $conn)
					{
						echo "Cannot Connect to database";
					}
					
					$query = mysqli_query($conn, "SHOW TABLES");
					while (($fetch = mysqli_fetch_array($query)))
					{
						mysqli_query($conn, "Drop table `{$fetch[0]}`");
					}
					flush();
					
					//      Restoring Database    //
					$res = explode(";\n", $content);
					foreach ($res as $query)
					{
						mysqli_query($conn, $query);
					}
					mysqli_close($conn);
				}
				
				function restoring_folders($source,$target)
				{
					if(is_readable($source))
					{
						if(is_dir($source))
						{
							if(!file_exists($target))
							{
								mkdir($target);
							}
							$d = dir($source);
							while(FALSE !== ($entry = $d->read()))
							{
								if ($entry == '.' || $entry == '..')
								{
									continue;
								}
								$Entry = "{$source}/{$entry}";
								if(is_dir($Entry))
								{
									$this -> restoring_folders($Entry, $target . '/' . $entry);
								}
								else
								{
									copy($Entry, $target . '/' . $entry);
								}
							}
							$d->close();
						}
						else
						{
							copy($source, $target, true);
						}
					}
				}
				
				function remove_directory($dirname)
				{
					if (is_dir($dirname))
					{
						$dir_handle = opendir($dirname);
					}
					if (!$dir_handle)
					{
						return false;
					}
					while($file = readdir($dir_handle))
					{
						if ($file != "." && $file != "..")
						{
							if (!is_dir($dirname."/".$file))
							{
								@unlink($dirname."/".$file);
							}
							else
							{
								$this -> remove_directory($dirname.'/'.$file);
							}
						}
					}
					closedir($dir_handle);
					@rmdir($dirname);
					return true;
				}
			}
		}
		
		if(isset($_REQUEST["param"]))
		{
			switch($_REQUEST["param"])
			{
				case "save_setup_details":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_step1_nonce"))
					{
						$insert = new save_data();
						$backup_details = array();
						$meta_records_array = array();
						$meta_value = array();
						$meta_key = array();
						
						$backup_details["type"] = "backup";
						$backup_details["parent_id"] = 0;
						
						$meta_records_array["backup_title"] = htmlspecialchars(esc_attr($_REQUEST["ux_txt_backup_title"]));
						$meta_records_array["email"] = esc_attr($_REQUEST["ux_txt_email_address"]);
						$meta_records_array["pass_enable"] = isset($_REQUEST["ux_chk_set_password"]) ? "1" : "0";
						$meta_records_array["password"] = isset($_REQUEST["ux_chk_set_password"]) ? esc_attr($_REQUEST["ux_password"]) : "";
						$meta_records_array["backup_status"] = "Not executed Yet";
	
						if(intval($_REQUEST["backup_id"]) == 0)
						{
							$insert->insert_data(backup_tbl_backup_details(),$backup_details);
							echo $backup_id = $wpdb->insert_id;
							foreach ($meta_records_array as $key => $val)
							{
								$meta_value["backup_id"] = $backup_id;
								$meta_value["meta_key"] = $key;
								$meta_value["meta_value"] = $val;
								$insert->insert_data(backup_tbl_backup_meta(),$meta_value);
							}
						}
						else
						{
							$where = array();
							$where["id"] = intval($_REQUEST["backup_id"]);
							$insert->update_records(backup_tbl_backup_details(),$backup_details,$where);
							foreach ($meta_records_array as $key => $val)
							{
								$meta_key["backup_id"] = intval($_REQUEST["backup_id"]);
								$meta_key["meta_key"] = $key;
								$meta_value["meta_value"] = $val;
								$insert->update_records(backup_tbl_backup_meta(),$meta_value,$meta_key);
							}
						}
						die();
					}
				break;
				case "setup_option_details":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_step2_nonce"))
					{
						$backup_id = intval($_REQUEST["backup_id"]);
						$meta_records_array = array();
						$meta_value = array();
						$insert = new save_data();
						$delete_keys = '"backup_option","exclude_file_ext","file_compression","db_compression","time_limit"';
						$insert->multi_delete(backup_tbl_backup_meta(),$delete_keys,$backup_id);
	
						$meta_records_array["backup_option"] = intval($_REQUEST["ux_ddl_backup_option"]);
						switch(intval($_REQUEST["ux_ddl_backup_option"]))
						{
							case 0:
								$meta_records_array["exclude_file_ext"] = isset($_REQUEST["ux_txt_exclude_files"]) ? esc_attr($_REQUEST["ux_txt_exclude_files"]) : "";
								$meta_records_array["file_compression"] = isset($_REQUEST["ux_ddl_compression_type"]) ? esc_attr($_REQUEST["ux_ddl_compression_type"]) : "0";
								$meta_records_array["db_compression"] = isset($_REQUEST["ux_ddl_db_compression_type"]) ? esc_attr($_REQUEST["ux_ddl_db_compression_type"]) : "0";
								$meta_records_array["time_limit"] = isset($_REQUEST["ux_txt_time_limit"]) ? esc_attr($_REQUEST["ux_txt_time_limit"]) : "";
							break;
							case 1:
								$meta_records_array["db_compression"] = isset($_REQUEST["ux_ddl_db_compression_type"]) ? esc_attr($_REQUEST["ux_ddl_db_compression_type"]) : "0";
								$meta_records_array["time_limit"] = isset($_REQUEST["ux_txt_time_limit"]) ? esc_attr($_REQUEST["ux_txt_time_limit"]) : "";
							break;
							default:
								$meta_records_array["exclude_file_ext"] = isset($_REQUEST["ux_txt_exclude_files"]) ? esc_attr($_REQUEST["ux_txt_exclude_files"]) : "";
								$meta_records_array["file_compression"] = isset($_REQUEST["ux_ddl_compression_type"]) ? esc_attr($_REQUEST["ux_ddl_compression_type"]) : "0";
								$meta_records_array["time_limit"] = isset($_REQUEST["ux_txt_time_limit"]) ? esc_attr($_REQUEST["ux_txt_time_limit"]) : "";
								
								$delete_where = array();
								$delete_where["backup_id"] = $backup_id;
								$delete_where["meta_key"] = "backup_tables";
								$insert->delete_records(backup_tbl_backup_meta(),$delete_where);
							break;
						}
	
						foreach ($meta_records_array as $key => $val)
						{
							$meta_value["backup_id"] = $backup_id;
							$meta_value["meta_key"] = $key;
							$meta_value["meta_value"] = $val;
							$insert->insert_data(backup_tbl_backup_meta(),$meta_value);
						}
						die();
					}
				break;
				case "db_tables_details":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_db_tables_nonce"))
					{
						$backup_id = intval($_REQUEST["backup_id"]);
						$insert = new save_data();
						$delete_where = array();
						$meta_value = array();
						$delete_where["backup_id"] = $backup_id;
						$delete_where["meta_key"] = "backup_tables";
						$insert->delete_records(backup_tbl_backup_meta(),$delete_where);
	
						$meta_value["backup_id"] = $backup_id;
						$meta_value["meta_key"] = "backup_tables";
						$meta_value["meta_value"] = isset($_REQUEST["ux_tables"]) ? esc_sql(implode(";",$_REQUEST["ux_tables"])) : "";
						$insert->insert_data(backup_tbl_backup_meta(),$meta_value);
						die();
					}
				break;
				case "save_destination_details":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_destination_nonce"))
					{
						$backup_id = intval($_REQUEST["backup_id"]);
						$insert = new save_data();
						$meta_records_array = array();
						$meta_value = array();
						$delete_keys = '"archive_name_format","archive_name","backup_destination"
									  ,"local_folder_path","sql_file_name"';
						$insert->multi_delete(backup_tbl_backup_meta(),$delete_keys,$backup_id);
	
						$meta_records_array["archive_name_format"] = esc_attr($_REQUEST["archive_name_format"]);
						$meta_records_array["archive_name"] = esc_attr($_REQUEST["archive_name"]);
						$meta_records_array["backup_destination"] = esc_attr($_REQUEST["destination_type"]);
						$meta_records_array["log_file"] = esc_attr($_REQUEST["log_file"]);
						$meta_records_array["sql_file_name"] = esc_attr($_REQUEST["sql_file"]);
						
						foreach ($meta_records_array as $key => $val)
						{
							$meta_value["backup_id"] = $backup_id;
							$meta_value["meta_key"] = $key;
							$meta_value["meta_value"] = $val;
							$insert->insert_data(backup_tbl_backup_meta(),$meta_value);
						}
						die();
					}
				break;
				case "save_email_details":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_email_nonce"))
					{
						$insert = new save_data();
						$meta_records_array = array();
						$meta_value = array();
						$meta_records_array["destination_email"] = esc_attr($_REQUEST["ux_txt_email_address"]);
						$meta_records_array["destination_cc"] = esc_attr($_REQUEST["ux_txt_email_cc"]);
						$meta_records_array["destination_bcc"] = esc_attr($_REQUEST["ux_txt_email_bcc"]);
	
						foreach ($meta_records_array as $key => $val)
						{
							$meta_value["backup_id"] = intval($_REQUEST["backup_id"]);
							$meta_value["meta_key"] = $key;
							$meta_value["meta_value"] = $val;
							$insert->insert_data(backup_tbl_backup_meta(),$meta_value);
						}
						die();
					}
				break;
				case "save_local_folder_details":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_local_folder_nonce"))
					{
						$insert = new save_data();
						$values = array();
						$values["meta_value"] = esc_attr(stripslashes($_REQUEST["local_path"]));
						$values["backup_id"] = intval($_REQUEST["backup_id"]);
						$values["meta_key"] = "local_folder_path";
						$insert->insert_data(backup_tbl_backup_meta(),$values);
						die();
					}
				break;
				case "insert_path_keys":  /////////////insert keys required in backup process ///
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "sixth_step_nonce"))
					{
						$backup_id = intval($_REQUEST["backup_id"]);
						$insert = new save_data();
						$meta_records_array = array();
						$meta_value = array();
						$delete_keys = '"log_file_path","backup_path","sql_file_path","restore_log_file_path","backup_start_time","backup_destination_time",
								"total_no_of_files","files_compressed","backup_steps","backup_local_folder","log_file_local_folder"';
						$insert->multi_delete(backup_tbl_backup_meta(),$delete_keys,$backup_id);
	
						$meta_records_array["backup_path"] = "";
						$meta_records_array["sql_file_path"] = "";
						$meta_records_array["restore_log_file_path"] = "";
						$meta_records_array["backup_start_time"] = "";
						$meta_records_array["backup_destination_time"] = "";
						$meta_records_array["total_no_of_files"] = "";
						$meta_records_array["files_compressed"] = "";
						$meta_records_array["backup_steps"] = "";
						$meta_records_array["log_file_path"] = "";
						$meta_records_array["backup_local_folder"] = "";
						$meta_records_array["log_file_local_folder"] = "";
	
						foreach ($meta_records_array as $key => $val)
						{
							$meta_value["backup_id"] = $backup_id;
							$meta_value["meta_key"] = $key;
							$meta_value["meta_value"] = $val;
							$insert->insert_data(backup_tbl_backup_meta(),$meta_value);
						}
					}
				break;
				case "update_backup_licensing":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "backup_licensing_nonce"))
					{
						$form = array();
						$insert = new save_data();
						$form["api_key"] = esc_attr($_REQUEST["ux_api_key"]);
						$form["order_id"] = esc_attr($_REQUEST["ux_order_id"]);
						$where = array();
						$where["licensing_id"] = "1";
						$insert->update_records(backup_tbl_licensing(),$form,$where);
						die();
					}
				break;
				case "delete_all_backups":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "delete_backups_nonce"))
					{
						$backups = isset($_REQUEST["ux_chk_backup"]) ? implode(",",esc_sql($_REQUEST["ux_chk_backup"])) : "0";
						$wpdb->query
						(
							"DELETE FROM ".backup_tbl_backup_details()." WHERE id IN (".$backups.")"
						);
						$wpdb->query
						(
							"DELETE FROM ".backup_tbl_backup_meta()." WHERE backup_id IN (".$backups.")"
						);
						die();
					}
				break;
				case "delete_backup":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "delete_backup_nonce"))
					{
						$backup_id = intval($_REQUEST["backup_id"]);
						$object = new save_data();
						$where = array();
						$where["id"] = $backup_id;
						$object->delete_records(backup_tbl_backup_details(),$where);
						$where_array = array();
						$where_array["backup_id"] = $backup_id;
						$object->delete_records(backup_tbl_backup_meta(),$where_array);
						die();
					}
				break;
				case "file_size":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "file_size_nonce"))
					{
						$backup_id = intval($_REQUEST["backup_id"]);
						$backup_details = $wpdb->get_results
						(
							$wpdb->prepare
							(
								"Select meta_key,meta_value from " .backup_tbl_backup_meta() . " Where backup_id = %d And (meta_key = %s Or meta_key = %s Or meta_key = %s)",
								$backup_id,
								"files_compressed",
								"total_no_of_files",
								"backup_steps"
							)
						);
	
						$backup_meta_keys = array();
						for ($flag = 0; $flag < count($backup_details); $flag++)
						{
							array_push($backup_meta_keys, $backup_details[$flag]->meta_key);
						}
	
						$index = array_search("files_compressed", $backup_meta_keys);
						$files_compressed = $backup_details[$index]->meta_value;
	
						$index = array_search("total_no_of_files", $backup_meta_keys);
						$total_no_of_files = $backup_details[$index]->meta_value;
						$total_no_of_files = intval($total_no_of_files) == 0 ? 1 : $total_no_of_files;
	
						$index = array_search("backup_steps", $backup_meta_keys);
						$backup_steps = $backup_details[$index]->meta_value;
	
						$percentage = intval(($files_compressed/$total_no_of_files)*100);
						echo floor($percentage).";".$backup_steps;
						die();
					}
				break;
				case "backup_bank_plugin_updates":
					if(wp_verify_nonce( $_REQUEST["_wpnonce"], "update_plugin_nonce"))
					{
						$backup_update = intval($_REQUEST["backup_updates"]);
						update_option("backup-bank-automatic-update",$backup_update);
					}
				break;
			}
		}
	}
}
?>