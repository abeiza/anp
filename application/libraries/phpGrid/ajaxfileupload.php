<?php
require_once("phpGrid.php");
if(!session_id()){ session_start();}

if (!isset($HTTP_POST_VARS) && isset($_POST)){ $HTTP_POST_VARS = $_POST;}  // backward compability when register_long_arrays = off in config 
$col_fileupload  = isset($_GET['col']) ? $_GET['col'] : die('phpGrid fatal error: URL parameter "col" for file upload is not defined');
$upload_folder	 = isset( $_GET['folder']) ? urldecode($_GET['folder']) : '';

$error = "";
$msg = "";

if(!empty($_FILES[$col_fileupload]['error'])){
	switch($_FILES[$col_fileupload]['error']){
		case '1':
			$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			break;
		case '2':
			$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			break;
		case '3':
			$error = 'The uploaded file was only partially uploaded';
			break;
		case '4':
			$error = 'No file was uploaded.';
			break;

		case '6':
			$error = 'Missing a temporary folder';
			break;
		case '7':
			$error = 'Failed to write file to disk';
			break;
		case '8':
			$error = 'File upload stopped by extension';
			break;
		case '999':
		default:
			$error = 'No error code avaiable';
	}
}elseif(empty($_FILES[$col_fileupload]['tmp_name']) || $_FILES[$col_fileupload]['tmp_name'] == 'none'){
	$error = 'No file was uploaded..';
}else {
	$msg .= "File Name: " . $_FILES[$col_fileupload]['name'] . ", ";
	$msg .= "File Size: " . @filesize($_FILES[$col_fileupload]['tmp_name']);
			
	$fname = $_FILES[$col_fileupload]['name'];		
	
	// echo ' upload_folder . fname '. $upload_folder . $fname;
		
	$is_moved = move_uploaded_file($_FILES[$col_fileupload]['tmp_name'], $upload_folder . $fname);
	if ($is_moved) {
		
		// if file moved, update record in database
		$gridName   = isset($_GET['gn']) ? $_GET['gn'] : die('phpGrid fatal error: URL parameter "gn" is not defined');
		$grid_sql	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql'];
		$sql_key	= unserialize($_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_key']);
		$sql_fkey	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_fkey'];
		$sql_table	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_table'];  
		$sql_filter	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_filter'];       
		$db_connection = unserialize($_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_db_connection']);  
		// $is_debug		= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_is_debug'];

        //establish db connection
        $cn = $db_connection;
		if(empty($cn)){
			$db = new C_DataBase(PHPGRID_DB_HOSTNAME, PHPGRID_DB_USERNAME, PHPGRID_DB_PASSWORD, PHPGRID_DB_NAME, PHPGRID_DB_TYPE, PHPGRID_DB_CHARSET);
		}
		else {       
			$db = new C_DataBase($cn["hostname"],$cn["username"],$cn["password"],$cn["dbname"],$cn["dbtype"],$cn["dbcharset"]);        
		}

		$rs     = $db->select_limit($grid_sql, 1, 1);
		$pk         = $sql_key; // $dg->get_sql_key();          // Array: primary key
		$pk_val     = explode(",", $_POST[JQGRID_ROWID_KEY]);   // e.g. "10104---141,10103---14111", convert to Array
        $pk_val_new = $db->quote_fields($rs, $sql_key, $pk_val);
        $sql_where = ' ('. implode(',', $sql_key) .') IN ('. implode(',', $pk_val_new) .') ';
        /*
        $fm_type   = $db->field_metatype($rs, $db->field_index($rs, $pk));
		if($fm_type != 'I' && $fm_type != 'N' && $fm_type != 'R')     
			$pk_val = "'" . $pk_val ."'"; 
        */
		$query = "UPDATE ". $sql_table ." SET ". $col_fileupload ."='". $_FILES[$col_fileupload]['name'] ."'  WHERE ". $sql_where;
		$db->db_query($query);     
		
		if(C_Utility::is_debug())
			$msg .= ' OK. SQL: '. $query;
		else
			$msg .= ' OK.';
	} else {
		$error= 'Possible file upload attack. The file will be automatically deleted.';
		@unlink($_FILES[$col_fileupload]);
	}				
}		

// json return
echo '{"error": "' . $error . '", 
	   "msg": "'   . $msg . '"}';
?>