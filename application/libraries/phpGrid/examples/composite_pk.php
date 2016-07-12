<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Datagrid Composite Primary Key</title>
</head>
<body>

Composite Primary Key (in green yellow background color):
<ul>
    <li>orderNumber,
    <li>productCode
</ul>
<?php
$dg = new C_DataGrid("SELECT * FROM orderdetails", array("productCode", "orderNumber"), "orderdetails");
$dg->set_col_dynalink("productCode", "http://www.example.com/", "orderLineNumber", '&foo');
$dg->set_col_format('orderNumber','integer', array('thousandsSeparator'=>'','defaultValue'=>''));
$dg->set_col_currency('priceEach','$');

// enable CRUD for detail grid
$dg->enable_edit("FORM", "CRUD");

$dg->set_col_property('orderNumber', array('classes'=>'comppk'));
$dg->set_col_property('productCode', array('classes'=>'comppk'));

$dg->display();
?>

<style>
    .comppk{background-color: greenyellow !important;}
</style>

</body>
</html>