<?php 
// the request url should looks sth like this: 
// masterdetail.php?id=2&_search=false&nd=1277597709752&rows=20&page=1&sidx=lineid&sord=asc
require_once('phpGrid.php');
if(!session_id()){ session_start();}  

$gridName = isset($_GET['gn']) ? $_GET['gn'] : die('PHPGRID_ERROR: URL parameter "gn" is not defined');
$data_type  = isset($_GET['dt']) ? $_GET['dt']:'json';

$grid_sql	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql'];
$sql_key	= unserialize($_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_key']);
$sql_fkey	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_fkey'];
$sql_table	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_table'];  
$sql_filter	= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_sql_filter'];
// $is_debug		= $_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_is_debug'];
$db_connection = unserialize($_SESSION[GRID_SESSION_KEY.'_'.$gridName.'_db_connection']);

//establish db connection
$cn = $db_connection;
if(empty($cn)){
    $db = new C_DataBase(PHPGRID_DB_HOSTNAME, PHPGRID_DB_USERNAME, PHPGRID_DB_PASSWORD, PHPGRID_DB_NAME, PHPGRID_DB_TYPE, PHPGRID_DB_CHARSET);
}
else {       
    $db = new C_DataBase($cn["hostname"],$cn["username"],$cn["password"],$cn["dbname"],$cn["dbtype"],$cn["dbcharset"]);        
}

//01.26.2011 by yuuki
//Desc: commented line below
//$sdg= $dg->obj_md;

//$pk_val = $_GET['id'];
$fk_val = (isset($_GET['fkey_value'])) ? $_GET['fkey_value'] : die();   // no selected row (when page is first loaded)
if(stripos($fk_val, '<input') !== false && stripos($fk_val, 'class="editable"') !== false){
    die();  // adding a new row in INLINE edit - do not load child grid
}

$fk     = $sql_fkey; //$dg->get_sql_fkey();

// ###### DEBUG ONLY #############
//	echo 'sql_fkey: '. $sql_fkey;
//  echo 'fk_val: '.($fk_val);
//  echo '$fk: ' .($fk);
// ###############################

$page   = (isset($_GET['page']))?$_GET['page']:1; 
$limit  = (isset($_GET['rows']))?$_GET['rows']:20;
$sord   = (isset($_GET['sord']))?$_GET['sord']:'asc';           
$sidx   = (isset($_GET['sidx']))?$_GET['sidx']:''; 

$rs     = $db->select_limit($grid_sql, 1, 1);

// prepare sql WHERE statement.
// there are THREE filters in detail grid
// 1. master foreign key filter ($sql_filter_md)
// 2. query filter (set_query_filter)
// 3. search filter (integral or advanced)
$sql_filter_md = $db->quote_field($grid_sql, $fk, C_Utility::add_slashes($fk_val));		// 1. master foreign key filter
$sqlWhere = '';															// 2. query filter
$searchOn = (isset($_REQUEST['_search']) && $_REQUEST['_search'] =='true')?true:false;
if($searchOn) {
	$col_dbnames = array();
	$col_dbnames = $db->get_col_dbnames($rs);        
	
	//print_r($col_dbnames);
	// check if the key is actual a database field. If true, add it to SQL Where (sqlWhere) statement
	foreach($_REQUEST as $key=>$value) {
		//echo 'key:'. $key ."\n";
		if(in_array($key, $col_dbnames)){
			$fm_type = $db->field_metatype($rs, $db->field_index($rs, str_replace('`', '', $key)));
			switch ($fm_type) {
				case 'I':
				case 'N':
				case 'R': case 'SERIAL':
				case 'L':
					$sqlWhere .= " AND ".$key." = ". $value;
					break;
				default:
					$sqlWhere .= " AND ".$key." LIKE '". $value."%'";
					break;
			}			
		}
		
	}

	//integrated toolbar and advanced search    
	if(isset($_REQUEST['filters']) && $_REQUEST['filters'] !=''){
		$op = array("eq"=>" ='%s' ","ne"=>" !='%s' ","lt"=>" < %s ",
			"le"=>" <= %s ","gt"=>" > %s ","ge"=>" >= %s ",
			"bw"=>" like '%s%%' ","bn"=>" not like '%s%%' " ,
			"in"=> " in (%s) ","ni"=> " not in (%s) ",
			"ew"=> " like '%%%s' ","en"=> " not like '%%%s' ",
			"cn"=> " like '%%%s%%' ","nc"=> " not like '%%%s%%' ");
		
		$filters = json_decode(stripcslashes($_REQUEST['filters']));
		$groupOp = $filters->groupOp;	// AND/OR
		$rules = $filters->rules;
		
		for($i=0;$i<count($rules);$i++){                   
			$sqlWhere .=  $groupOp . " ". $rules[$i]->field .
				sprintf($op[$rules[$i]->op],C_Utility::add_slashes($rules[$i]->data));
		}
	}
}

// remove leading sql AND/OR
$pos = strpos($sqlWhere,'AND ');
if ($pos !== false) {
	$sqlWhere = substr_replace($sqlWhere,'',$pos,strlen('AND '));
}
$pos = strpos($sqlWhere,'OR ');
if ($pos !== false) {
	$sqlWhere = substr_replace($sqlWhere,'',$pos,strlen('OR '));
}

// set ORDER BY. Don't use if user hasn't select a sort
$sqlOrderBy = (!$sidx) ? "" : " ORDER BY $sidx $sord";



// ********* prepare the final query ***********************
if($sql_filter != '' && $searchOn){
	$SQL = $grid_sql .' WHERE '. $sql_filter_md . ' AND '. $sql_filter .' AND '. $sqlWhere . $sqlOrderBy;
}elseif($sql_filter != '' && !$searchOn){
	$SQL = $grid_sql .' WHERE '. $sql_filter_md .' AND '. $sql_filter . $sqlOrderBy;
}elseif($sql_filter == '' && $searchOn){
	$SQL = $grid_sql .' WHERE '. $sql_filter_md .' AND '. $sqlWhere . $sqlOrderBy;
}else{ // if($sql_filter == '' && !$searchOn){
	$SQL = $grid_sql .' WHERE '. $sql_filter_md . $sqlOrderBy;
}

// **** DEBUG **** //
if(C_Utility::is_debug()){
    echo $SQL ."<br />";
}


// ********************** pagination *******************
$rs    = $db->db_query($SQL);
$count = $db->num_rows($rs);

// calculate the total pages for the query 
if( $count > 0 && $limit > 0) { 
	$total_pages = ceil($count/$limit); 
}else{ 
	$total_pages = 0; 
} 

// if for some reasons the requested page is greater than the total, set the requested page to total page 
if ($page > $total_pages) $page=$total_pages;
// calculate the starting position of the rows 
$start = $limit*$page - $limit;
// if for some reasons start position is negative set it to 0. typical case is that the user type 0 for the requested page 
if($start <0) $start = 0; 



// ******************* execute query finally *****************
$db->db->SetFetchMode(ADODB_FETCH_BOTH);
$result = $db->select_limit($SQL, $limit, $start);




// **** DEBUG **** //
if(C_Utility::is_debug()){
    echo $limit ."<br />";
    echo $start ."<br />";
    echo $total_pages ."<br />";
    echo $fk ."<br />";

    echo "<br />";
}




// $col_hiddens = $sdg->get_col_hiddens();   

//01.26.2011 by yuuki
//Desc: get the data type from $dg object
//$data_type = $sdg->get_jq_datatype();
// $data_type = $dg->get_jq_datatype();
switch($data_type)
{
	// render xml. Must set appropriate header information. 
	case "xml":
		$data = "<?xml version='1.0' encoding='utf-8'?>";
		$data .=  "<rows>";
		$data .= "<page>".$page."</page>";
		$data .= "<total>".$total_pages."</total>";
		$data .= "<records>".$count."</records>"; 
		$i = 0;
		while($row = $db->fetch_array_assoc($result)) {
			//01.26.2011 by yuuki
			//Desc: get the data key from $dg object
			// $data .= "<row id='". $row[$dg->get_sql_key()] ."'>";
            $data .= "<row id='". gen_rowids($row, $sql_key) ."'>";
            for($i = 0; $i < $db->num_fields($result); $i++) {
				$col_name = $db->field_name($result, $i);             
				$data .= "<cell>". $row[$col_name] ."</cell>";    
			}  
			$data .= "</row>";       
		}
		$data .= "</rows>";    

		header("Content-type: text/xml;charset=utf-8");
		echo $data;   
		break;
	
	case "json":
		$response = new stdClass();   // define anonymous objects
		$response->page = $page;
		$response->total = $total_pages;
		$response->records = $count;
		$i=0;
		$data = array();              
		while($row = $db->fetch_array_assoc($result)) {
			unset($data);
			//01.26.2011 by yuuki
			//Desc: get the key from $dg object
			//$response->rows[$i]['id']=$row[$sdg->get_sql_key()];
            $response->rows[$i][JQGRID_ROWID_KEY]=C_Utility::gen_rowids($row, $sql_key); //$row[$sql_key];
            for($j = 0; $j < $db->num_fields($result); $j++) {
				$col_name = $db->field_name($result, $j);                             
				$data[] = $row[$col_name];    
			}            
			$response->rows[$i]['cell'] = $data;
			$i++;
		}        
		echo json_encode($response);  
		break;
} 

// free resource       
$db = null;
?>
