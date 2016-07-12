<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Summary Row</title>
</head>
<body>

<?php
$dg = new C_DataGrid('SELECT customerName, city, state, creditLimit FROM customers', 'customerName', 'customers'); // Basic
$dg -> set_caption('phpGrid Summary Row');
$dg -> set_query_filter("state is not null"); // Where clause
$dg -> set_col_format('creditLimit','integer', array('thousandsSeparator'=>',', 'defaultValue'=>'0'));

$dg->set_grid_property(array("footerrow"=>true));
$loadComplete = <<<LOADCOMPLETE
function ()
{
    var colSum = $('#customers').jqGrid('getCol', 'creditLimit', false, 'sum');
    $('#customers').jqGrid('footerData', 'set', { state: 'Total:', 'creditLimit': colSum });
}
LOADCOMPLETE;
$dg->add_event("jqGridLoadComplete", $loadComplete);

$dg -> display();

?>
</body>
</html>