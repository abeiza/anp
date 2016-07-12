<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpGrid - Conditional Value</title>
<style>
.tstyle{
	display:block;background-image:none;margin-right:-2px;margin-left:-2px;padding:5px;background-color:green;color:navy;font-weight:bold
}
.fstyle{
	display:block;background-image:none;margin-right:-2px;margin-left:-2px;padding:5px;background-color:yellow;color:navy
}
</style>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM joborders", "jobNumber", "joborders");
$dg -> set_col_title("jobNumber", "Job Number");
$dg -> set_col_title("jobDescription", "Description");
$dg -> set_col_title("status", "Status");               
$dg -> set_col_title("percentComplete", "Progress (%)"); 
$dg -> set_col_title("isClosed", "Closed"); 

$dg->set_conditional_value("isClosed", "==1", array(
	"TCellValue"=>"<img src='SampleImages/checked.gif' />",
	"FCellValue"=>"<img src='SampleImages/unchecked.gif' />"));

// $dg->set_col_format('isClosed', "checkbox");	// works too, but should only used for read only grid

$dg->set_conditional_value("status", "=='Complete'", array(
	"TCellStyle"=>"tstyle",
	"FCellStyle"=>"fstyle"));


$dg->enable_edit('INLINE', 'CRUD');

$dg->set_multiselect(true);
$dg -> set_databar("percentComplete","red");

$dg->set_dimension(800, 300);
$dg -> display();
?>
</body>
</html>