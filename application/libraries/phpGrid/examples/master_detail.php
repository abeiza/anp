<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Master/Detail, Parent/Child PHP Datagrid</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");

// change column titles
$dg->set_col_title("orderNumber", "Order No.");
$dg->set_col_title("orderDate", "Order Date");
$dg->set_col_title("shippedDate", "Shipped Date");
$dg->set_col_title("customerNumber", "Customer No.");

$dg->set_pagesize(10);
$dg->enable_search(true);
$dg->enable_export('HTML');

$dg->enable_search(true);
// enable edit
//$dg->enable_edit("INLINE", "CRUD");

// hide a column
//$dg -> set_col_hidden("requiredDate");

// read only columns, one or more columns delimited by comma
//$dg -> set_col_readonly("orderDate, customerNumber");

// required fields
$dg -> set_col_required("orderNumber, customerNumber");

$dg->set_query_filter("status ='Shipped'");
// multiple select
//$dg->enable_export('PDF');

// second grid as detail grid. Notice it is just another regular phpGrid with properites.
$sdg = new C_DataGrid("SELECT orderNumber,productCode,quantityOrdered,priceEach FROM orderdetails", array("productCode", "orderNumber"), "orderdetails");
$sdg -> set_query_filter("quantityOrdered>30");
$sdg->set_col_title("orderNumber", "Order No.");
$sdg->set_col_title("productCode", "Product Code");
$sdg->set_col_title("quantityOrdered", "Quantity");
$sdg->set_col_title("priceEach", "Unit Price");
$sdg->set_col_dynalink("productCode", "http://www.example.com/", "orderLineNumber", '&foo');
$sdg->set_col_format('orderNumber','integer', array('thousandsSeparator'=>'','defaultValue'=>''));
$sdg->set_col_currency('priceEach','$');
$sdg->enable_export('PDF');

$sdg->enable_search(true);
// enable CRUD for detail grid
//$sdg->enable_edit("FORM", "CRUD");

$dg->set_masterdetail($sdg, 'orderNumber');

//$dg->set_dimension(400);
//$sdg->set_dimension(400);

// automatically select a row onload
// $dg->before_script_end ='setTimeout(function(){jQuery("#orders").jqGrid("setSelection", 10101, true);}, 1000);';

$dg->display();
?>

</body>
</html>