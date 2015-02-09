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
	if(!current_user_can($user_role_permission))
	{
		return;
	}
	else
	{
		if((isset($complete_backup)))
		{
			wp_mkdir_p(BACKUP_BK_CONTENT_DIR."/wp-backup-bank/".date("d-m-Y")."/database");
		}
		
		$sql_file_full_path = $backup_path.$db_file_name;
		///////////////////////////////////////// Update backup path and sql file path in database ////////////////////////////////
		if(!function_exists("update_data"))
		{
			function update_data($tbl,$values,$where)
			{
				global $wpdb;
				$wpdb->update($tbl,$values,$where);
			}
		}
		
		$form = array();
		$form["meta_value"] = $sql_file_full_path;
		$where = array();
		$where["backup_id"] = $backup_id;
		$where["meta_key"] = "sql_file_path";
		update_data(backup_tbl_backup_meta(),$form,$where);
		
		if(!(isset($complete_backup)))
		{
			$backup_file_path = explode("/wp-backup-bank/",$sql_file_full_path)[1];
			$form["meta_value"] = content_url()."/wp-backup-bank/".$backup_file_path;
		}
		else 
		{
			$zip_file_path = explode("/wp-backup-bank/",$backup_path)[1];
			$form["meta_value"] = content_url()."/wp-backup-bank/".$zip_file_path;
		}
		$where = array();
		$where["backup_id"] = $backup_id;
		$where["meta_key"] = "backup_path";
		update_data(backup_tbl_backup_meta(),$form,$where);
		
		//////////////////////////////////////////////////////////////// Code to cretae database sql file ////////////////////////////////////////////////
		$return = "";
		
		$backup_tbls = $wpdb->get_var
		(
			$wpdb->prepare
			(
				"Select meta_value from " .backup_tbl_backup_meta() . " Where backup_id = %d And meta_key = %s",
				$backup_id,
				"backup_tables"
			)
		);
		
		if($backup_tbls != "")
		{
			$table = explode(";",$backup_tbls);
		}
		else
		{
			$table = array();
		}
		
		if(count($table) > 0)  ///////// update to no. of tables for backup
		{
			$value = array();
			$where = array();
			$where["backup_id"] = $backup_id;
			$where["meta_key"] = "total_no_of_files";
			$value["meta_value"] = count($table);
			update_data(backup_tbl_backup_meta(),$value,$where);
		}
		
		class Database_backup
		{
		
			public $mysqli = NULL;
				
			public $table_data = NULL;
				
			public $tables = array();
				
			public $table_type = array();
				
			public $table_status = array();
				
			public $tables_to_dump = array();
				
			public $table = NULL;
				
			public $dbname = NULL;
				
			public $destination = NULL;
				
			public $log_file_path = NULL;
			
			public $handle = NULL;
				
			public function __construct($default_args = array())
			{
				$default_args = array(
					"dbhost" 	  => DB_HOST,
					"dbname" 	  => DB_NAME,
					"dbuser" 	  => DB_USER,
					"dbpassword"  => DB_PASSWORD
				);
		
				$this->mysqli = mysqli_connect($default_args["dbhost"],$default_args["dbuser"],$default_args["dbpassword"],$default_args["dbname"]);
				$this->dbname = $default_args["dbname"];
				if(!$this->mysqli)
				{
					$file_content = __("Could'nt connect to Database ", wp_backup_bank).$this->dbname."\r\n";
					create_log_file($log_file_path,$file_content);
				}
			}
		
			function write($dump)
			{
				$this->handle = fopen($this->destination, "a");
				fwrite($this->handle, $dump);
			}
		
			function dump_table_footer($table)
			{
				if ($this->table_status[ $table]["Rows"] !== 0)
				{
					$file_content = __("Backup database table ", wp_backup_bank)."'". $table ."'".__(" with ", wp_backup_bank) . str_replace("~","",$this->table_status[ $table]["Rows"]) . " ".__("records", wp_backup_bank)."\r\n";
					create_log_file($this->log_file_path,$file_content);
					$this->write( "/*!40000 ALTER TABLE `" . $table . "` ENABLE KEYS */;\nUNLOCK TABLES;\n");
				}
			}
		
			function dump_table_head($table)
			{
				if ($this->table_type == "VIEW")
				{
					$charset = $this->mysqli->character_set_name();
					$tablecreate = "\n--\n-- View structure for `" . $table . "`\n--\n\n";
					$tablecreate .= "DROP VIEW IF EXISTS `" . $table . "`;\n";
					$tablecreate .= "/*!40101 SET @saved_cs_client     = @@character_set_client */;\n";
					$tablecreate .= "/*!40101 SET character_set_client = '".$charset."' */;\n";
		
					$res = mysqli_query($conn, "SHOW CREATE VIEW `" . $table . "`");
					$createview = mysqli_fetch_assoc($res);
					$tablecreate .= $createview["Create View"] . ";\n";
					$tablecreate .= "/*!40101 SET character_set_client = @saved_cs_client */;\n";
					$this->write($tablecreate, $sql_file_full_path);
				}
				else
				{
					$charset = $this->mysqli->character_set_name();
					$tablecreate = "\n--\n-- Table structure for `" . $table . "`\n--\n\n";
					$tablecreate .= "DROP TABLE IF EXISTS `" . $table . "`;\n";
					$tablecreate .= "/*!40101 SET @saved_cs_client     = @@character_set_client */;\n";
					$tablecreate .= "/*!40101 SET character_set_client = '".$charset."' */;\n";
		
					$result = mysqli_query( $this->mysqli , "SHOW CREATE TABLE `".$table."`");
					$createtable = mysqli_fetch_assoc($result);
					$tablecreate .= $createtable["Create Table"] . ";\n";
					$tablecreate .= "/*!40101 SET character_set_client = @saved_cs_client */;\n";
					$this->write( $tablecreate);
						
					if ( $this->table_status[ $table ]["Engine"] !== "MyISAM")
					{
						$this->table_status[ $table ]["Rows"] = '~' . $this->table_status[ $table ]["Rows"];
					}
						
					if ($this->table_status[ $table ]["Rows"] !== 0)
					{
						$this->write( "\n--\n-- Backup data for table `" . $table . "`\n--\n\nLOCK TABLES `" . $table . "` WRITE;\n/*!40000 ALTER TABLE `" . $table . "` DISABLE KEYS */;\n");
					}
						
					return $this->table_status[ $table ]["Rows"];
				}
			}
		
			function dump_table($table)
			{
				global $wpdb;
				$done_records = 0;
				$dump = "";
				$counter = 0;
				$fieldsarray = array();
				$fieldinfo = array();
		
				$result = mysqli_query( $this->mysqli ,"SELECT * FROM `". $table."`",MYSQLI_USE_RESULT);
		
				while($fields = mysqli_fetch_field($result))
				{
					$fieldsarray[$counter] = $fields->orgname;
					$fieldinfo[$fieldsarray[$counter]] =  $fields->type;
					$counter ++;
				}
		
				while($data = mysqli_fetch_assoc($result))
				{
					$values = array();
					foreach($data as $key => $value )
					{
						if ((is_null($value)) || (!isset($value)))
						{
							$value = "NULL";
						}
						elseif(in_array($fieldinfo[$key], array(MYSQLI_TYPE_DECIMAL,MYSQLI_TYPE_TINY,MYSQLI_TYPE_SHORT,MYSQLI_TYPE_LONG,MYSQLI_TYPE_FLOAT,MYSQLI_TYPE_DOUBLE,MYSQLI_TYPE_LONGLONG,MYSQLI_TYPE_INT24)))
						{
							$value = empty( $value ) ? 0 : $value;
						}
						else
						{
							$value = "'".$this->mysqli->real_escape_string($value)."'";
						}
						$values[] = $value;
					}
						
					if ( empty( $dump ) )
					{
						$dump = "INSERT INTO `" . $table . "` (`" . implode( "`, `", $fieldsarray ) . "`) VALUES \n";
					}
					if ( strlen( $dump ) <= 50000  )
					{
						$dump .= "(" . implode( ", ", $values ) . "),\n";
					}
					else
					{
						$dump .= "(" . implode( ", ", $values ) . ");\n";
						$this->write( $dump);
						$dump = '';
					}
					$done_records ++;
				}
				if (!empty($dump))
				{
					$dump = substr($dump, 0, -2).";\n";
					$this->write($dump);
				}
			}
		
			function execute($selected_tables,$destination,$log_file_path)
			{
				$this->log_file_path = $log_file_path;
				$this->destination = $destination;
		
				$all_tables = mysqli_query($this->mysqli,"SHOW FULL TABLES FROM `".$this->dbname."`" );
				while ( $table = mysqli_fetch_array( $all_tables , MYSQLI_NUM) )
				{
					if(in_array($table[0],$selected_tables))
					{
						$this->tables_to_dump[] = $table[0];
						$this->table_type[]= $table[1];
					}
				}
				$result = mysqli_query($this->mysqli,"SHOW TABLE STATUS FROM `".$this->dbname."`");
				while ($tablestatus = mysqli_fetch_assoc($result))
				{
					if(in_array($tablestatus["Name"],$selected_tables))
					{
						$this->table_status[$tablestatus["Name"]] = $tablestatus;
					}
				}
		
				foreach($this->tables_to_dump as $table_key => $table)
				{
					$this->dump_table_head($table);
					$this->dump_table($table);
					$this->dump_table_footer($table);
				}
			}
			
			public function __destruct()
			{
				//Close Databas Connection//
				mysqli_close($this->mysqli);
				//Closing the file//
				if(is_resource($this->handle))
				{
					fclose($this->handle);
				}
			}
		}
	
		$create = new Database_backup();
		$create->execute($table,$sql_file_full_path,$log_file_path);
		
		$file_info = round(filesize($sql_file_full_path)/1000,2);
		$file_content =  __("Sql file size is", wp_backup_bank)." ".$file_info." Kb.\r\n";
		create_log_file($log_file_path,$file_content);
	}
}
?>
