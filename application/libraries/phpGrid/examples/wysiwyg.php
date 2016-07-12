<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enable Datagrid Edit</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders"); 

// change column titles
$dg -> set_col_title("orderNumber", "Order No.");
$dg -> set_col_title("orderDate", "Order Date");
$dg -> set_col_title("shippedDate", "Shipped Date");
$dg -> set_col_title("customerNumber", "Customer No.");
 
// hide a column
$dg -> set_col_hidden("requiredDate");

$dg -> set_col_edittype('status', 'autocomplete', 'Shipped:Shipped;Cancelled:Cancelled;Pending:Pending;');

// enable edit
$dg -> enable_edit("FORM", "CRUD");

// Wysiwyg is available in paid version only. If you are using phpGrid Lite, please the below screenshot
// Screenshot: http://phpgrid.com/wp-content/uploads/2012/04/phpGrid_WYSIWYG.png
$dg -> set_col_wysiwyg('comments');
//$dg->set_col_fileupload('status');
$dg->enable_debug(false);
$dg -> display();
?>

</body>
</html>