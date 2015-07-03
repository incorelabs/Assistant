<?php

	include_once ROOT.'db/header_db.php';

	function get_last_table_id($table)
	{	
		global $connection;
		$id=0;
		$sql = "SELECT MAX(id) FROM ".$table.";";
		if($result = mysqli_query($connection,$sql))
		{
			while($row=mysqli_fetch_row($result))
			{
				$id=$row[0];
			}
		}
		mysqli_close($connection);
		return $id;
	}

	function get_table_fields($table)
	{
		global $connection;
		$table_fields = array();
		$sql = "SHOW COLUMNS FROM ".$table.";";
		//echo $sql;
		$result = mysqli_query($connection, $sql);
		if (!$result) {
		    echo 'Could not run query: ' . mysql_error();
		    exit;
		}
		if (mysqli_num_rows($result) > 0) {
		    while ($row = mysqli_fetch_assoc($result)) {
		        array_push($table_fields, $row);
		    }
		}
		//mysqli_close($connection);
		return $table_fields;
	}

	function build_table_field_str($table)
	{
		$field_name = get_table_fields($table);

		$insert_field_str = "";

		foreach ($field_name as $value)
		{
			$insert_field_str .= $value["Field"].", ";
		}

		return rtrim($insert_field_str,", ");
	}

	function build_table_value_str($arr_values)
	{
		$insert_value_str = "";

		foreach ($arr_values as $value)
		{	
			if(is_null($value) ||  $value == ""){
				$insert_value_str .= "null, ";
			}
			else
			{
				if (is_string($value))
				{
					$value = str_replace("'", "", $value);
					$value = str_replace('"', "", $value);
					//$value = str_replace("\n", "<br>", $value);
					$insert_value_str .= "'".$value."', ";
				}
				else{
					$insert_value_str .= $value.", ";
				}
			}

				
		}

		return rtrim($insert_value_str, ", ");
	}

	function build_insert_str($table,$arr_values)
	{
		$insert_field_str = build_table_field_str($table);
		$insert_value_str = build_table_value_str($arr_values);	

		$sql = "INSERT INTO ".$table." ( ".$insert_field_str.") VALUES (".$insert_value_str.")";

		return $sql;
	}

	function build_custom_insert_str($table, $arr_fields, $arr_values)
	{
		$insert_field_str = build_table_field_str($arr_fields);
		$insert_value_str = build_table_value_str($arr_values);

		$sql = "INSERT INTO ".$table." ( ".$insert_field_str.") VALUES (".$insert_value_str.")";
		return $sql;
	}

	function build_field_str($arr_fields)
	{
		$fields = "";
		foreach ($arr_fields as $key => $value) {
			$fields .= $value.", ";
		}

		return rtrim($fields,", ");
	}

	function build_value_type($value)
	{
		$insert_value_str = "";

		if (strcasecmp(gettype($value), "string") == 0)
		{
			$insert_value_str .= "'".$value."'";
		}
		else
		{
			if(strcasecmp(gettype($value), "null") == 0)
				$insert_value_str .= "null";
			else
				$insert_value_str .= $value;
		}

		return $insert_value_str;
	}

	function get_table_values($table_name)
	{
		global $connection;
		$arr_temp = array();
		$sql = "SELECT * FROM ".$table_name.";";
		if($result = mysqli_query($connection,$sql))
		{
			while($row=mysqli_fetch_row($result))
			{
				$temp_arr = array();

				for ($i=0; $i < mysqli_num_fields($result) ; $i++) 
				{ 
					$finfo = mysqli_fetch_field_direct($result,$i);

					if($finfo->type == 10)
					{	
						$new_date = "";
						if(is_null($row[$i]) || $row[$i] == ""){
							$new_date = null;
						}
						else{
							$new_date = date('d-m-Y',strtotime($row[$i]));
						}
						array_push($temp_arr, $new_date);
					}
					else
					{
						array_push($temp_arr,$row[$i]);
					}
				}

				array_push($arr_temp, $temp_arr);
			}
		}
		mysqli_close($connection);
		return $arr_temp;
	
	}

	function put_col_attr($arr_table,$arr_column)
	{
		for($i=0; $i < 3; $i++) 
		{ 
			$temp = array();
			$temp_col = array();
			$temp_col_type = array();
			# code...
			for ($j=0; $j < count($arr_column) ; $j++) {
				
				if($i == 0)
				{
					array_push($temp, $arr_column[$j]["Field"]);
				}

				if($i == 1)
				{
					$var1="";
					$txt=$arr_column[$j]["Type"];

					$re1='(int)';	# Variable Name 1

					if ($c=preg_match_all ("/".$re1."/is", $txt, $matches))
					{
					    $var1=$matches[1][0];
					    //print "$var1 \n";
					}

					if($var1 == "int")
					{
						array_push($temp,"INTEGER");
					}
					else
					{
						//array_push($temp_col,"TEXT");
						array_push($temp,"TEXT");
					}

					/*if ($j == (count($arr_column)-1)) 
					{
						array_push($temp, $temp_col);
					}*/
				}
				if($i == 2)
				{
					$temp_str="";

					if($arr_column[$j]["Key"] == "PRI")
						$temp_str = "PRIMARY KEY ";
					
					if($arr_column[$j]["Null"] == "NO")
					{
						$temp_str .= "NOT NULL";
					}
					elseif ($arr_column[$j]["Null"] == "YES") 
					{
						$temp_str .= "NULL";
					}

					array_push($temp, $temp_str);

					/*if ($j == (count($arr_column)-1)) {
						array_push($temp, $temp_col);
					}*/
					
				}
			}

			array_push($arr_table, $temp);
		}

		return $arr_table;
	}

	function get_field_value($field)
	{
		$temp_type="";
        	$var1="";
        	$txt=$field["Type"];

			$re1='(int)';	# Variable Name 1

			if ($c=preg_match_all ("/".$re1."/is", $txt, $matches))
			{
			    $var1=$matches[1][0];
			    //print "$var1 \n";
			}

			if($var1 == "int")
			{
				//array_push($temp,"INTEGER");
				$temp_type = "INTEGER";
			}
			else
			{
				//array_push($temp,"TEXT");
				$temp_type = "TEXT";
			}

			//Null and keys

			$temp_str="";

			if($field["Key"] == "PRI")
				$temp_str = "PRIMARY KEY ";
			
			if($field["Null"] == "NO")
			{
				$temp_str .= "NOT NULL";
			}
			elseif ($field["Null"] == "YES") 
			{
				$temp_str .= "NULL";
			}

			return ($temp_type." ".$temp_str);
	}
?>