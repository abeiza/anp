<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editable Datagrid - Inline Edit Action Column</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");

// change column titles
$dg -> set_col_title("orderNumber", "Order No.");
$dg -> set_col_title("orderDate", "Order Date");
$dg -> set_col_title("shippedDate", "Shipped Date");
$dg -> set_col_title("customerNumber", "Customer No.");

$dg->set_col_hidden('comments');
$dg -> enable_edit("INLINE");
$dg->set_col_edittype('orderNumber', 'select', 'select orderNumber, orderNumber from orders');

/*$onSelectCell = <<<ONSELECTCELL
function(evt, rowid, col_index, cellContent)
{
// var cont = $('#orders').jqGrid('getCell',rowid,'customerNumber');
$('#jqg1_orderDate').text($('#orders').jqGrid('getCell',rowid,'orderDate'));
}
ONSELECTCELL;
$dg -> add_event("jqGridCellSelect", $onSelectCell);
*/

$dg->add_column("actions", array('name'=>'actions',
    'index'=>'actions',
    'width'=>'70',
    'formatter'=>'actions',
    'formatoptions'=>array('keys'=>true, 'editbutton'=>true, 'delbutton'=>true)),'Actions');

//$dg->set_theme('aristo');
$dg -> display();

?>

<style>
    #orders_pager1_left{visibility: hidden;}
</style>

</body>
</html>