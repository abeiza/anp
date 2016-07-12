<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Datagrid Mobile-Friendly</title>
</head>
<body>


<div id="mydiv" style="width:600px">
<?php
$dg = new C_DataGrid("SELECT orderNumber, orderDate, status, comments FROM orders", "orderNumber", "orders");
$dg->enable_autowidth(true)->enable_autoheight(true);
$dg->set_pagesize(100); // need to be a large number
$dg->set_scroll(true);
$dg->enable_kb_nav(true);

$dg->set_col_title('orderNumber', 'Order#');
$dg->set_col_date('orderDate');
$dg->set_col_width('orderDate', '150px');
$dg->set_col_width('orderNumber', '90px');
$dg->set_col_width('status', '100px');
/* uncomment to set width to parent DIV instead
$dg->before_script_end .= 'setTimeout(function(){$(window).bind("resize", function() {
        phpGrid_orders.setGridWidth($("#mydiv").width());
    }).trigger("resize");}, 0)';
*/
$dg->enable_edit('INLINE');
$dg -> display();
?>
<style>
    /* optional. removes page margin */
    body{margin:0px;}
    /* optional. widen textbox width */
    .ui-jqgrid-bdiv input{width:100%;}

    /* row height */
   

    #gbox_orders table tr > th{
        padding-top:10px;
        padding-bottom:20px;
    }

    .ui-jqgrid .ui-jqgrid-htable .ui-jqgrid-labels th div{
        height: auto !important;
    }

    /* caption font size */
    /* content font size */
	#gbox_orders table, #gbox_orders table tr > th > div, #gview_orders > div.ui-jqgrid-titlebar > span{
		font-size: 40pt;
	}

	#gview_orders > div.ui-jqgrid-titlebar{
		padding: 20px;
	}

    #gview_orders input, #gview_orders textarea{
        font-size: 40pt;
    }

</style>
</div>

</body>
</html>