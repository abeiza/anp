<?php
//include('../../Glimpse/index.php');
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpGrid Ajax File Upload (Form edit only)</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM shippers", "ShipperID", "shippers");

$dg -> set_col_fileupload("fileToUpload", '/phpGridx/examples/SampleImages/');
$dg -> enable_edit('FORM');
$dg->set_col_img("fileToUpload", "/phpGridx/examples/SampleImages/");

$dg -> set_col_edittype("officeCode", "autocomplete", "Select officeCode,city from offices",false);


$dg->enable_debug(false);
$dg -> display();

?>


<style>
    /* resize displayed images */
    .ui-jqgrid tr.jqgrow td img{
        width:50px;
        border: 1px gray solid;
        box-shadow: 2px 2px 3px #888888;
        border-radius:25px;
    }
</style>

</body>
</html>