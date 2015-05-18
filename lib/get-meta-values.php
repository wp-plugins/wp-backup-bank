<?php
if (!is_user_logged_in())
{
	return;
}
else
{
	if(isset($_REQUEST["backup_id"]))
	{
		$backup_id = intval($_REQUEST["backup_id"]);
	}
	
	$backup_meta = $wpdb->get_results
	(
		$wpdb->prepare
		(
			"SELECT * FROM " . backup_tbl_backup_meta(). " WHERE backup_id = %d",
			$backup_id
		)
	);
	
	$backup_meta_keys = array();
	for ($flag = 0; $flag < count($backup_meta); $flag++)
	{
		array_push($backup_meta_keys, $backup_meta[$flag]->meta_key);
	}
	switch($_REQUEST["page"])
	{
		case "generate_backup":
			$index = array_search("backup_title", $backup_meta_keys);
			$backup_title = $index == 0 ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("email", $backup_meta_keys);
			$backup_email = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("pass_enable", $backup_meta_keys);
			$pass_enable = $index == "" ? "" : $backup_meta[$index]->meta_value;
			
			$index = array_search("password", $backup_meta_keys);
			$password = $index == "" ? "" : $backup_meta[$index]->meta_value;
		break;
		
		case "backup_second_step":
			$index = array_search("backup_option", $backup_meta_keys);
			$backup_option = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_destination", $backup_meta_keys);
			$backup_destination = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("file_compression", $backup_meta_keys);
			$file_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("db_compression", $backup_meta_keys);
			$db_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("time_limit", $backup_meta_keys);
			$time_limit = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("exclude_file_ext", $backup_meta_keys);
			$exclude_file_ext = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
		
		case "backup_third_step":
			$index = array_search("backup_tables", $backup_meta_keys);
			$backup_tables = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
		
		case "backup_forth_step":
			$index = array_search("backup_option", $backup_meta_keys);
			$backup_option = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("archive_name_format", $backup_meta_keys);
			$archive_name_format = $index != "" ?  $backup_meta[$index]->meta_value : "";
			
			$index = array_search("archive_name", $backup_meta_keys);
			$archive_name = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("local_folder_path", $backup_meta_keys);
			$local_folder_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("file_compression", $backup_meta_keys);
			$file_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("db_compression", $backup_meta_keys);
			$db_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
		
		case "backup_fifth_step":
			$index = array_search("backup_option", $backup_meta_keys);
			$backup_option = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
		
		case "backup_sixth_step":
			$index = array_search("db_compression", $backup_meta_keys);
			$db_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_tables", $backup_meta_keys);
			$backup_tables = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_option", $backup_meta_keys);
			$backup_option = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_title", $backup_meta_keys);
			$backup_title = $index == 0 ? $backup_meta[$index]->meta_value : "";
				
			$index = array_search("email", $backup_meta_keys);
			$backup_email = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("pass_enable", $backup_meta_keys);
			$pass_enable = $index == "" ? "" : $backup_meta[$index]->meta_value;
				
			$index = array_search("password", $backup_meta_keys);
			$password = $index == "" ? "" : $backup_meta[$index]->meta_value;
			
			$index = array_search("time_limit", $backup_meta_keys);
			$time_limit = $index != "" ? $backup_meta[$index]->meta_value : "";
				
			$index = array_search("exclude_file_ext", $backup_meta_keys);
			$exclude_file_ext = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("archive_name_format", $backup_meta_keys);
			$archive_name_format = $index != "" ?  $backup_meta[$index]->meta_value : "";
				
			$index = array_search("archive_name", $backup_meta_keys);
			$archive_name = $index != "" ? $backup_meta[$index]->meta_value : "";
				
			$index = array_search("local_folder_path", $backup_meta_keys);
			$local_folder_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("file_compression", $backup_meta_keys);
			$file_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_destination", $backup_meta_keys);
			$backup_destination = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
		
		case "backup_seventh_step":
			$index = array_search("backup_title", $backup_meta_keys);
			$backup_title = $index == 0 ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("email", $backup_meta_keys);
			$backup_email = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("pass_enable", $backup_meta_keys);
			$pass_enable = $index == "" ? "" : $backup_meta[$index]->meta_value;
			
			$index = array_search("password", $backup_meta_keys);
			$password = $index == "" ? "" : $backup_meta[$index]->meta_value;
			
			$index = array_search("archive_name_format", $backup_meta_keys);
			$archive_name_format = $index != "" ?  $backup_meta[$index]->meta_value : "";
			
			$index = array_search("archive_name", $backup_meta_keys);
			$archive_name = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_option", $backup_meta_keys);
			$backup_option = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_destination", $backup_meta_keys);
			$backup_destination = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("file_compression", $backup_meta_keys);
			$file_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("db_compression", $backup_meta_keys);
			$db_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("time_limit", $backup_meta_keys);
			$time_limit = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("local_folder_path", $backup_meta_keys);
			$local_folder_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("exclude_file_ext", $backup_meta_keys);
			$exclude_file_ext = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_tables", $backup_meta_keys);
			$backup_tables = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_path", $backup_meta_keys);
			$backup_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("sql_file_path", $backup_meta_keys);
			$sql_file_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("sql_file_name", $backup_meta_keys);
			$sql_file_name = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("log_file", $backup_meta_keys);
			$log_file = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
		case "backup_dashboard":
			$index = array_search("backup_title", $backup_meta_keys);
			$backup_title = $index == 0 ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("email", $backup_meta_keys);
			$backup_email = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("pass_enable", $backup_meta_keys);
			$pass_enable = $index == "" ? "" : $backup_meta[$index]->meta_value;
			
			$index = array_search("password", $backup_meta_keys);
			$password = $index == "" ? "" : $backup_meta[$index]->meta_value;
			
			$index = array_search("archive_name_format", $backup_meta_keys);
			$archive_name_format = $index != "" ?  $backup_meta[$index]->meta_value : "";
			
			$index = array_search("archive_name", $backup_meta_keys);
			$archive_name = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_option", $backup_meta_keys);
			$backup_option = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_destination", $backup_meta_keys);
			$backup_destination = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("file_compression", $backup_meta_keys);
			$file_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("db_compression", $backup_meta_keys);
			$db_compression = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("time_limit", $backup_meta_keys);
			$time_limit = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("local_folder_path", $backup_meta_keys);
			$local_folder_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_scheduling", $backup_meta_keys);
			$backup_scheduling = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("exclude_file_ext", $backup_meta_keys);
			$exclude_file_ext = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_tables", $backup_meta_keys);
			$backup_tables = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("backup_path", $backup_meta_keys);
			$backup_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("sql_file_path", $backup_meta_keys);
			$sql_file_path = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("sql_file_name", $backup_meta_keys);
			$sql_file_name = $index != "" ? $backup_meta[$index]->meta_value : "";
			
			$index = array_search("log_file", $backup_meta_keys);
			$log_file = $index != "" ? $backup_meta[$index]->meta_value : "";
		break;
	}
}
?>