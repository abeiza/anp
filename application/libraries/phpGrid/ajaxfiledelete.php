<?php
require_once("phpGrid.php");
if(!session_id()){ session_start();}

if (!isset($HTTP_POST_VARS) && isset($_POST)){ $HTTP_POST_VARS = $_POST;}  // backward compability when register_long_arrays = off in config 
$col_fileupload  = isset($_GET['col']) ? $_GET['col'] : die('phpGrid fatal error: URL parameter "col" for file upload is not defined');
$upload_folder	 = isset($_GET['folder']) ? urldecode($_GET['folder']) : '';

$msg = "";
$error = "";

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

$rs			= $db->select_limit($grid_sql, 1, 1);
$pk			= $sql_key; // $dg->get_sql_key();      // primary key
$pk_val     = explode(",", $_POST[JQGRID_ROWID_KEY]);   // e.g. "10104---141,10103---14111", convert to Array
$pk_val_new = $db->quote_fields($rs, $sql_key, $pk_val);
$sql_where = ' ('. implode(',', $sql_key) .') IN ('. implode(',', $pk_val_new) .') ';
/*
$fm_type	= $db->field_metatype($rs, $db->field_index($rs, $pk));
if($fm_type != 'I' && $fm_type != 'N' && $fm_type != 'R')
	$pk_val = "'" . $pk_val ."'"; 
*/
$select_query = "SELECT ". $col_fileupload ." FROM ". $sql_table ." WHERE ". $sql_where;
$result = $db->query_then_fetch_array_first($select_query);
$file_name = (!empty($result)) ? $result[$col_fileupload] : null;

// ----------- delete file from file system -----------
$is_deleted = @unlink($upload_folder . $file_name);
if(C_Utility::is_debug())
	$msg .= ' SQL SELECT: '. $select_query;
if(!$is_deleted)
	$error .= 'File remove failed.';

// ----------- update file name to empty string -----------
$update_query = "UPDATE ". $sql_table ." SET ". $col_fileupload ."=''  WHERE ". $sql_where;
$db->db_query($update_query);
if(C_Utility::is_debug())
	$msg .= ' | SQL UPDATE: '. $update_query;
else
	$msg .= ' OK. ';


// ----------- json return -----------
echo '{"error": "' . $error . '", 
	   "msg": "'   . $msg . '"}';

?>