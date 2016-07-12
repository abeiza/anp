<?php
if(!session_id()){ session_start();} // this is nessecory for PHP that running on Windows

class C_DataBase{
	public $hostName;
	public $userName;
	public $password;
	public $databaseName;
	public $tableName;
	public $link;
	public $dbType;
	public $charset;
    public $db; 
    public $result;
	
	public function __construct($host, $user, $pass, $dbName, $db_type = "pdo_odbc_db2", $charset="", $sql_table=""){
		$this -> hostName = $host;
		$this -> userName = $user;
		$this -> password = $pass;
		$this -> databaseName = $dbName;
		$this -> dbType  = $db_type;
        $this -> charset = $charset;
        $this -> tableName = $sql_table;
		
		$this -> _db_connect();	
	}

	/*
	****************************** working with this function in DB2 layer class ************************
	*                                                                                                   *
	*  Connect to the Database                                                                          *
	*                                                                                                   *
	*****************************************************************************************************
	*/
	public function _db_connect(){
		try {
			/*
			$dbh = new PDO('odbc:'.$this->databaseName,
			            $this->userName,
			            $this->password
			                , array(
			                    PDO::ATTR_PERSISTENT => TRUE,
			                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
			                  );
			*/
			// $dbh = new PDO('odbc:DRIVER={DB2};HOSTNAME=75.126.155.153;PORT=50001;DATABASE=SQLDB;PROTOCOL=TCPIP;UID=user07599;PWD=UviZULzvvvHM;sslConnection=yes');
			$dbh = new PDO('odbc:DRIVER={DB2};HOSTNAME='. PHPGRID_DB_HOSTNAME .';PORT='. PHPGRID_DB_PORT .';DATABASE='. PHPGRID_DB_NAME .';PROTOCOL=TCPIP;UID='. PHPGRID_DB_USERNAME .';PWD='. PHPGRID_DB_PASSWORD .';');
			
			$this->db = $dbh;
		} catch (PDOException $exception) {
		      echo "failed \n";
		      echo $exception->getMessage();
		      exit;
		}
	}
	       
	// Desc: query database
	public function db_query($query_str, $kv=array()){
		// $this->db->SetFetchMode(ADODB_FETCH_BOTH);
		$stmt = $this->db->prepare($query_str) or die('C_Database->db_query() error.');

		if(!empty($kv)){
			$stmt->execute($kv);
		}else{
			$stmt->execute();
		}
		
		$stmt->setFetchMode(PDO::FETCH_BOTH);

		// var_dump($result);

		$this->result = $stmt;        
        return $this->result;
	}

	// select [..] from table limit offset, size. 
	// select [..] from table limit size. 
	// DB2 setting DB2_COMPATIBILITY_VECTOR must equal to MYS
	public function select_limit($query_str, $size = -1, $offset = -1)
	{
		$limitStr = '';
		if($offset >= 0 && $size > 0){
			$limitStr = "LIMIT $offset,$size";
		}elseif($offset < 0 && $size > 0){
			$limitStr = "LIMIT $size";
		}

		$stmt = $this->db->query($query_str . " $limitStr") or die('C_Database->select_limit() error.');
 		$stmt->setFetchMode(PDO::FETCH_BOTH);

 		/*
 		foreach ($result as $row) {
	        print $row['EMPNO'] . "\t";
	        print $row['FIRSTNME'] . "\t";
	        print $row['LASTNAME'] . "\n<p />";
	    }
		*/
	
    	$this->result = $stmt;  

		return $this->result;
	}

	// Desc: number of data fields in the recordset
	public function num_fields($result){
		return $result->columnCount();
	}

	// Desc: a specific field name (column name) with that index in the recordset
	public function field_name($result, $index){
		$stmt = $this->db->query("Select distinct(name), COLNO, ColType, Length from Sysibm.syscolumns where tbname = '". $this -> tableName ."' and COLNO = ". $index) or die("Error executing field_name(). Can't fetch meta data.");
        $stmt->setFetchMode(PDO::FETCH_BOTH);
        $row = $stmt->fetch();
        $name = strtoupper($row[0]);

        return $name;
	}

    // Desc: the generic Meta type of a specific field name by index. 
    // Ref: http://stackoverflow.com/questions/2973186/how-to-view-db2-table-structure
    // Note: In V7r1, it could be SYSIBM.COLUMNS     
    // Returns: 
    // C: Character fields that should be shown in a <input type="text"> tag.
    // X: Clob (character large objects), or large text fields that should be shown in a <textarea>
    // D: Date field
    // T: Timestamp field
    // L: Logical field (boolean or bit-field)
    // N: Numeric field. Includes decimal, numeric, floating point, and real.
    // I:  Integer field.
    // R: Counter (Access), Serial(PostgreSQL) or Autoincrement int field. Must be numeric.
    // B: Blob, or binary large objects.
    public function field_metatype($result, $index){
        // $obj_field = new ADOFieldObject();
        // $obj_field = $result->fetchColumn($index);
        //print_r($obj_field);
        // $type = $result->MetaType($obj_field->type, $obj_field->max_length);   // Since ADOdb 3.0, MetaType accepts $fieldobj as the first parameter, instead of $nativeDBType.
        $rs = $this->db->query("Select distinct(name), COLNO, ColType, Length from Sysibm.syscolumns where tbname = '". $this -> tableName ."' and COLNO = ". $index) or die("Error. Can't fetch meta data.");
        $row = $rs->fetch();
        $coltype = trim(strtoupper($row['COLTYPE']));
        
        $type = 'C';
        switch($coltype){
        	case 'DATE':
        	case 'TIME':
        		$type = 'D';
	        break;
        	case 'DECIMAL':
        	case 'REAL':
        	case 'FLOAT':
        		$type = 'N';
				break;
        	case 'INTEGER':
        	case 'SMALLINT':
        	case 'BIGINT':
        		$type = 'I';
        		break;
        	case 'CHAR':
        	case 'VARCHAR':
        		$type = 'C';
        		break;
        	case 'TIMESTAMP':
        		$type = 'T';
        		break;
        	case 'BLOB':
        	case 'BINARY':
        	case 'VARBINARY':
        		$type = 'B';
        		break;
        	case 'CLOB':
        	case 'DBCLOB':
        		$type = 'X';
        		break;
        	default:
        		$type = 'C';
        }

        return $type;              
    }	

	// Desc: number of rows query returned
	public function num_rows($result){
		$sql="SELECT count(*) FROM (". $result->queryString .")";
		$result = $this->db->query($sql);
		$row = $result->fetch(PDO::FETCH_NUM);
		
		return $row[0];
        // return $result->rowCount();
	} 

	// Desc: fetch a SINGLE record from database as associative array
	// Note: the parameter is passed as reference
	public function fetch_array_assoc(&$result){
		// $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		 	$rs = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);  
		 	return $rs;
	}	

	// Desc: get original database field names in an array
	public function get_col_dbnames($result){
		$col_dbnames = array();
		$num_fields = $result->columnCount();
		for($i = 0; $i < $num_fields; $i++) {
			$col_dbname = $this->field_name($result, $i);             
			$col_dbnames[] = $col_dbname;        
		}          
		
		return $col_dbnames;
	}	


	// Desc: helper function to get array from select_limit function
	public function select_limit_array($query_str, $size, $starting_row){
		$stmt = $this->select_limit($query_str, $size, $starting_row);
		$resultArray = $stmt->fetchAll();

        $this->result = $resultArray;
		return $resultArray;
	}
    	
	// Desc: return corresponding field index by field name
    public function field_index($result, $field_name){
        $field_count = $this->num_fields($result);
        $i=0;
        for($i=0;$i<$field_count;$i++){
            if($field_name == $this->field_name($result, $i))
                return $i;        
        }    
        return -1;
    }

    // obtain meta column info as specific field in a table.e.g. auto increment, not null
    // file: adodb.$dbtype.inc.php - ADODB_$dbtype::ADOConnection.MetaColumns()
    // return false if col_name is not in table, else return metacolumn
    public function field_metacolumn($table, $col_name){
        $arr = array();   
        $arr =  $this->db->MetaColumns($table);

        $obj_field = new ADOFieldObject();
        if(isset($arr[strtoupper($col_name)])){
            $obj_field = $arr[strtoupper($col_name)];
    //        print('<pre>');
    //        print_r($obj_field);
    //        print('</pre>');
            return $obj_field;                                        
        }else{
            return false;
        }


    }

    // DB2 only. Later used to idenitify if a column is a identity column (auto-increment). 
    // DB2 Syntax for identity column (COL_NAME INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 0) NOT NULL,
    public function db2_field_metacolumns(){
        $stmt = $this->db->query("Select distinct(name), IDENTITY from Sysibm.syscolumns where tbname = '". $this -> tableName ."'") or die("Error. Can't fetch meta column.");
        $resultArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultArray;
    }

    // check MULTIPLE fields for datatype and add quotes around non-numeric fields.
    // SQL WHERE syntax for query multiple records with composite PK:
    //      where (A, B) in (('T1', 2010), ('T2', 2009), ('AG', 1992))
    function quote_fields(&$rs, $sql_key=array(), $key_value=array()){
        $pk_val_new = array();

        $fm_types = array();
        for($t=0; $t<count($sql_key); $t++){
            $fm_type   = $this->field_metatype($rs, $this->field_index($rs, str_replace('`', '', $sql_key[$t])));
            $fm_types[] = $fm_type;
        }

        for($i =0; $i < count($key_value); $i++){
            $pk_val_fields = explode(PK_DELIMITER, $key_value[$i]);

            // ###### DEBUG ONLY ######################
            //    echo '$key_value[$i]: '. $key_value[$i] ."\n";
            //    echo 'pk_val_fields: ';
            //    print_r($pk_val_fields);
            // ########################################

            for($j=0; $j < count($sql_key); $j++){
                $fm_type = $fm_types[$j];
                if($fm_type != 'I' && $fm_type != 'N' && $fm_type != 'R'){
                    $pk_val_fld = "'" . $pk_val_fields[$j] ."'";
                }else{
                    $pk_val_fld = $pk_val_fields[$j];
                }
                $pk_val_fields[$j] = $pk_val_fld;
            }

            $pk_val_new[] = '('. implode(',', $pk_val_fields) .')';
        }

        return $pk_val_new;
    }

	// PDO - get last insert id 
	public function Insert_ID(){
		return $this->db->lastInsertId();
	}

    // Custom CRUD Sql builder
    // How to use:
    // 	select(table name, where clause as associative array)
	//	insert(table name, data as associative array, mandatory column names as array)
	//	update(table name, column names as associative array, where clause as associative array, mandatory columns as array)
	//	delete(table name, where clause as array)
	//	Ref: http://www.angularcode.com/useful-database-helper-class-to-generate-crud-statements-using-php-and-mysql/
	public function GetInsertSQL($rs, $arrFields, $table) {
	    try {
	        $c = "";
	        $v = "";
	        foreach($arrFields as $key => $value) {
	            $c.=$key.", ";
	            $v.=":".$key.", ";
	        }
	        $c = rtrim($c, ’, ‘);
	        $v = rtrim($v, ’, ‘);
	        
	        return "INSERT INTO $table($c) VALUES($v)";

	    } catch (PDOException $e) {
	        echo'Insert Failed: '.$e -> getMessage();
	    }
	}	

	public function GetUpdateSQL($rs, $arrFields, $table) {
		try {
	        $c = "";
	        foreach($arrFields as $key => $value) {
	            $c.=$key." = :".$key.", ";
	        }
	        $c = rtrim($c, ", ");

		    return "UPDATE $table SET $c";

	    } catch (PDOException $e) {
			echo "Update Failed: ".$e -> getMessage();
	    }	

	}

    /* 
    public function select($table, $where) {
	    try {
	        $a = array();
	        $w = "";
	        foreach($where as $key => $value) {
	            $w .= " and " .$key ." like :".$key;

	            $a[":".$key] = $value;
	        }
	        $stmt = $this -> db -> prepare("select * from ".$table.
	            " where 1=1 ".$w);
	        $stmt -> execute($a);
	        $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
	        if (count($rows) <= 0) {
	            $response["status"] = "warning";
	            $response["message"] = "No data found.";
	        } else {
	            $response["status"] = "success";
	            $response["message"] = "Data selected from database";
	        }
	        $response["data"] = $rows;
	    } catch (PDOException $e) {
	        $response["status"] = "error";
	        $response["message"] = 'Select Failed: '.$e -> getMessage();
	        $response["data"] = null;
	    }
	    return $response;
	}
	
	public function delete($table, $where) {
	    if (count($where) <= 0) {
	        $response["status"] = "warning";
	        $response["message"] = "Delete Failed: At least one condition is required";
	    } else {
	        try {
	            $a = array();
	            $w = "";
	            foreach($where as $key => $value) {
	                $w.=" and ".$key.
	                " = :".$key;
	                $a[":".$key] = $value;
	            }
	            $stmt = $this -> db -> prepare("DELETE FROM $table WHERE 1=1 ".$w);
	            $stmt -> execute($a);
	            $affected_rows = $stmt -> rowCount();
	            if ($affected_rows <= 0) {
	                $response["status"] = "warning";
	                $response["message"] = "No row deleted";
	            } else {
	                $response["status"] = "success";
	                $response["message"] = $affected_rows.
	                " row(s) deleted from database";
	            }
	        } catch (PDOException $e) {
	            $response["status"] = "error";
	            $response["message"] = 'Delete Failed: '.$e -> getMessage();
	        }
	    }
	    return $response;
	}


	private function verifyRequiredParams($inArray, $requiredColumns) {
	    $error = false;
	    $errorColumns = "";
	    foreach($requiredColumns as $field) {
	        if (!isset($inArray[$field]) || strlen(trim($inArray[$field])) <= 0) {
	            $error = true;
	            $errorColumns.=$field.', ';
	        }
	    }

	    if ($error) {
	        $response = array();
	        $response["status"] = "error";
	        $response["message"] = 'Required field(s)'.rtrim($errorColumns, ', ').'is missing or empty';
	        print_r($response);
	        exit;
	    }
	}
*/
















/*
	// Desc: query database
	public function db_query($query_str){
		$this->db->SetFetchMode(ADODB_FETCH_BOTH);
		$result = $this->db->Execute($query_str) or die(
            (C_Utility::is_debug())?
                "\n". 'PHPGRID_DEBUG: C_Database->db_query() - '. $this->db->ErrorMsg() ."\n":
                "\n". 'PHPGRID_ERROR: Could not execute query. Error 101.' ."\n");

		$this->result = $result;        
        return $result;
	}

	// Desc: fetch a SINGLE record from database as associative array
	// Note: the parameter is passed as reference
	public function fetch_array_assoc(&$result){
		// $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		if(!$result->EOF){
		 	$rs = $result->fields;
		 	$result->MoveNext();  
		 	return $rs;
		}
	}	

	public function select_limit($query_str, $size, $starting_row){
		$this->db->SetFetchMode(ADODB_FETCH_BOTH);
		$result = $this->db->SelectLimit($query_str, $size, $starting_row) or die(
            (C_Utility::is_debug())?
                "\n". 'PHPGRID_DEBUG: C_Database->select_limit() - '. $this->db->ErrorMsg() ."\n":
                "\n". 'PHPGRID_ERROR: Could not execute query. Error 102' ."\n");

        $this->result = $result; 

        print_r($result);       
		return $result;
	}

	// Desc: helper function to get array from select_limit function
	public function select_limit_array($query_str, $size, $starting_row){
		$result = $this->select_limit($query_str, $size, $starting_row);
		$resultArray = $result->GetArray();

        $this->result = $resultArray;
		return $resultArray;
	}
    	
	// Desc: fetch a SINGLE record from database as row
	// Note: the parameter is passed as reference
	public function fetch_row(&$result){
		// $ADODB_FETCH_MODE = ADODB_FETCH_NUM;
		if(!$result->EOF){
		 	$rs = $result->fields;
		 	$result->MoveNext();        
		 	return $rs;
		}
	}
	
	// Desc: fetch a SINGLE record from database as array
	// Note: the parameter is passed as reference
	public function fetch_array(&$result){
		// $ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		if(!$result->EOF){
		 	$rs = $result->fields;
		 	$result->MoveNext();   
		 	return $rs;
		}  
	}
		
	// Desc: number of rows query returned
	public function num_rows($result){
        return $result->rowCount();
	} 
	
	// Desc: helper function. query then, fetch the FIRST record from database as associative array
	public function query_then_fetch_array_first($query_str){
		// $ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
		$result = $this->db->Execute($query_str) or die('PHPGRID_ERROR: query_then_fetch_array_first() - '. $this->db->ErrorMsg());
		// die("Error: Could not execute query $query_str");
		if(!$result->EOF){
			$rs = $result->fields;
			$result->MoveNext();     
			return $rs;
		}
	}
	
	// Desc: number of data fields in the recordset
	public function num_fields($result){
		return $result->FieldCount();
	}
	
	// Desc: a specific field name (column name) with that index in the recordset
	public function field_name($result, $index){
		$obj_field = new ADOFieldObject();
		$obj_field = $result->FetchField($index);
		return isset($obj_field->name) ? $obj_field->name : "";
	}
       
      // Desc: the type of a specific field name (column name) with that index in the recordset
    public function field_nativetype($result, $index){
        $obj_field = new ADOFieldObject();
        $obj_field = $result->FetchField($index);
        return isset($obj_field->type) ? $obj_field->type : "";
    }
   
    // Desc: the generic Meta type of a specific field name by index.      
    // Returns: 
    // C: Character fields that should be shown in a <input type="text"> tag.
    // X: Clob (character large objects), or large text fields that should be shown in a <textarea>
    // D: Date field
    // T: Timestamp field
    // L: Logical field (boolean or bit-field)
    // N: Numeric field. Includes decimal, numeric, floating point, and real.
    // I:  Integer field.
    // R: Counter (Access), Serial(PostgreSQL) or Autoincrement int field. Must be numeric.
    // B: Blob, or binary large objects.
    public function field_metatype($result, $index){
        $obj_field = new ADOFieldObject();
        $obj_field = $result->FetchField($index);
        //print_r($obj_field);
        $type = $result->MetaType($obj_field->type, $obj_field->max_length);   // Since ADOdb 3.0, MetaType accepts $fieldobj as the first parameter, instead of $nativeDBType.
                
        return $type;              
    }
    
    // obtain meta column info as specific field in a table.e.g. auto increment, not null
    // file: adodb.$dbtype.inc.php - ADODB_$dbtype::ADOConnection.MetaColumns()
    // return false if col_name is not in table, else return metacolumn
    public function field_metacolumn($table, $col_name){
        $arr = array();   
        $arr =  $this->db->MetaColumns($table);

        $obj_field = new ADOFieldObject();
        if(isset($arr[strtoupper($col_name)])){
            $obj_field = $arr[strtoupper($col_name)];
    //        print('<pre>');
    //        print_r($obj_field);
    //        print('</pre>');
            return $obj_field;                                        
        }else{
            return false;
        }
        


    }
    
    // Desc: return corresponding field index by field name
    public function field_index($result, $field_name){
        $field_count = $this->num_fields($result);
        $i=0;
        for($i=0;$i<$field_count;$i++){
            if($field_name == $this->field_name($result, $i))
                return $i;        
        }    
        return -1;
    }
	
	// Desc: the length of a speciifc field name (column name) with that index in the recordset
	public function field_len($result, $index){
		$obj_field = new ADOFieldObject();
		$obj_field = $result->FetchField($index);
		return isset($obj_field->max_length) ? $obj_field->max_length : "";
	}

	// check SINGLE field datatype and add quotes around if it is a non-numeric field.
	function quote_field($sql, $fieldname, $fieldvalue){
		$rs         = $this->select_limit($sql, 1, 1);
        $fm_type    = $this->field_metatype($rs, $this->field_index($rs, str_replace('`', '', $fieldname)));
		switch ($fm_type) {
			case 'I':
			case 'N':
			case 'R':
			case 'L':
				$qstr = $fieldname ."=". $fieldvalue;  
				break;
			default:
				$qstr = $fieldname ."='". $fieldvalue ."'";    
				break;
		}
		
		return $qstr;
	}

    // check MULTIPLE fields for datatype and add quotes around non-numeric fields.
    // SQL WHERE syntax for query multiple records with composite PK:
    //      where (A, B) in (('T1', 2010), ('T2', 2009), ('AG', 1992))
    function quote_fields(&$rs, $sql_key=array(), $key_value=array()){
        $pk_val_new = array();

        $fm_types = array();
        for($t=0; $t<count($sql_key); $t++){
            $fm_type   = $this->field_metatype($rs, $this->field_index($rs, str_replace('`', '', $sql_key[$t])));
            $fm_types[] = $fm_type;
        }

        for($i =0; $i < count($key_value); $i++){
            $pk_val_fields = explode(PK_DELIMITER, $key_value[$i]);

            // ###### DEBUG ONLY ######################
            //    echo '$key_value[$i]: '. $key_value[$i] ."\n";
            //    echo 'pk_val_fields: ';
            //    print_r($pk_val_fields);
            // ########################################

            for($j=0; $j < count($sql_key); $j++){
                $fm_type = $fm_types[$j];
                if($fm_type != 'I' && $fm_type != 'N' && $fm_type != 'R'){
                    $pk_val_fld = "'" . $pk_val_fields[$j] ."'";
                }else{
                    $pk_val_fld = $pk_val_fields[$j];
                }
                $pk_val_fields[$j] = $pk_val_fld;
            }

            $pk_val_new[] = '('. implode(',', $pk_val_fields) .')';
        }

        return $pk_val_new;
    }

	
	// Desc: get original database field names in an array
	public function get_col_dbnames($result){
		$col_dbnames = array();
		$num_fields = $result->FieldCount();
		for($i = 0; $i < $num_fields; $i++) {
			$col_dbname = $this->field_name($result, $i);             
			$col_dbnames[] = $col_dbname;        
		}          
		
		return $col_dbnames;
	}

*/ 
	
}
?>