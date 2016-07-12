<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>In-Cell Data Bar</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM joborders", "jobNumber", "joborders");
$dg -> set_col_title("jobNumber", "Job Number");
$dg -> set_col_title("jobDescription", "Description");
$dg -> set_col_title("status", "Status");               
$dg -> set_col_title("percentComplete", "Progress (%)"); 
$dg -> set_col_title("isClosed", "Closed"); 

$dg -> set_databar("percentComplete","red");
$dg -> set_databar("jobNumber","blue");
$dg -> enable_edit("INLINE", "CRUD"); 

$dg -> display();
?>
</body>
</html>