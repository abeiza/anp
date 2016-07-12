<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpGrid Virtual Column (Calculated Column)</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");
$dg->enable_edit('FORM');

// creating a virtual column
$col_formatter = <<<COLFORMATTER
function(cellvalue, options, rowObject){
	var n1 = parseInt(rowObject[0],10), 
		n2 = parseInt(rowObject[6],10);
	return n1+n2;
}
COLFORMATTER;

$dg->add_column('total', array('name'=>'total', 'index'=>'total', 'width'=>'100', 'align'=>'right', 'sortable'=>false,
	'formatter'=>$col_formatter),
		'Total (Virtual)', 0);

$foo =  isset($_GET['foo'])? $_GET['foo'] : 'bar';
$dg->add_column('foo', array('name'=>'foo', 'index'=>'foo', 'width'=>'100', 'align'=>'right', 'sortable'=>false,
        'formatter'=>'function(cellvalue, options, rowObject){return \''.$foo.'\';}'),
    'Foo (Virtual)');


// post virtual column data to another page after submit through another Ajax call
$afterSubmit = <<<AFTERSUBMIT
function (event, status, postData)
{
    selRowId = $("#orders").jqGrid ('getGridParam', 'selrow');
    virtual_data1 = $("#orders").jqGrid("getCell", selRowId, 'total');
    virtual_data2 = $("#orders").jqGrid("getCell", selRowId, 'foo');
    console.log('going to post virtual column data ' + virtual_data1 + ', ' + virtual_data2 + ' to another page through a separate AJAX call');
    $.ajax({ url: 'save_virtual_column.php',
        data: {v_data1: virtual_data1, v_data2: virtual_data2}, // replace customerNumber with your own field name
        type: 'post',
        success: function(output) {
                    alert(output);
                }
        });

}
AFTERSUBMIT;
$dg->add_event("jqGridAddEditAfterSubmit", $afterSubmit);

/*
//Format a cell based on the specified condition
$dg->set_conditional_format("orderNumber","CELL",array(
    "condition"=>"eq","value"=>"10107","css"=> array("color"=>"#ffffff","background-color"=>"green")));

$dg->set_conditional_format("customerNumber","CELL",array(
    "condition"=>"eq","value"=>"141","css"=> array("color"=>"red","background-color"=>"#DCDCDC")));

// Format a row based on the specified condition
$dg->set_conditional_format("comments","ROW",array(
    "condition"=>"cn","value"=>"request","css"=> array("color"=>"white","background-color"=>"#4297D7")));


$dg->set_conditional_format("orderDate","CELL",array(
    "condition"=>"gt","value"=>"2010-01-01 00:00:00","css"=> array("color"=>"lightblue","background-color"=>"#2227D7")));

$dg->set_conditional_format("shippedDate","ROW",array(
    "condition"=>"lt","value"=>"2003-01-01 00:00:00","css"=> array("color"=>"lightred","background-color"=>"#AAA7D7")));
*/
$dg->display();
?>

Virtual Column
<ul>
<li>The col_name cannot contain space and must begin with a letter
<li>Use "formatter" column property to hook up javascript function
<li>The virtual column always adds to the end of the grid in the order of virtual column is created.
<li>Text must be surrounded with single quote
<li>Virtual column is not sortable.
</ul>