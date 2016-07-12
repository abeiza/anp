<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subgrid</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");

// enable edit
$dg->enable_edit("INLINE", "CRUD");

// second grid as detail grid. Notice it is just another regular phpGrid with properites.
$sdg = new C_DataGrid("SELECT * FROM orderdetails", array("orderLineNumber", "productCode"), "orderdetails");


$sdg->enable_edit("INLINE", "CRUD");


// second grid as detail grid. Notice it is just another regular phpGrid with properites.
$sdg2 = new C_DataGrid("SELECT * FROM products", array("productCode"), "products");

$sdg2->enable_edit("INLINE", "CRUD");

// define master detail relationship by passing the detail grid object as the first parameter, then the foriegn key name.
$sdg->set_subgrid($sdg2, 'productCode');
$dg->set_subgrid($sdg, 'orderNumber');

$gridComplete = <<<GRIDCOMPLETE
function ()
{
    rowIds = $("#orders").getDataIDs();
    $.each(rowIds, function (index, rowId) {
        $("#orders").expandSubGridRow(rowId);
    });
}
GRIDCOMPLETE;

$sdg->set_conditional_format("quantityOrdered","CELL",array(
    "condition"=>"gt","value"=>"30","css"=> array("color"=>"red","background-color"=>"green")));

$sdg2->set_conditional_format("buyPrice","CELL",array(
    "condition"=>"gt","value"=>"40","css"=> array("color"=>"blue","background-color"=>"red")));


$dg->add_event("jqGridLoadComplete", $gridComplete);


$dg->display();
?>

</body>
</html>