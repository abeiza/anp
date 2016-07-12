<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Auto-resize PHP Datagrid Like Excel Spreadsheet</title>
</head>
<body>


<div id="mydiv" style="width:600px">
<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");
$dg->enable_autowidth(true)->enable_autoheight(true);
$dg->set_pagesize(100); // need to be a large number
$dg->set_scroll(true);
$dg->enable_kb_nav(true);

$dg->enable_edit('INLINE');

/* uncomment to set width to parent DIV instead
$dg->before_script_end .= 'setTimeout(function(){$(window).bind("resize", function() {
        phpGrid_orders.setGridWidth($("#mydiv").width());
    }).trigger("resize");}, 0)';
*/
$dg -> display();
?>
<style>
    /* optional. removes page margin */
    body{margin:0px;}
</style>
<script>
$('#orders').keydown(function (e) {
	if(e.target != 'undefined'){
	    var $td = $(e.target).closest("td"),
	        $tr = $td.closest("tr.jqgrow"),
	        ci, ri, rows = this.rows;
	    if ($td.length === 0 || $tr.length === 0) {
	        return;
	    }
	    ci = $.jgrid.getCellIndex($td[0]);
	    ri = $tr[0].rowIndex;
	    if (e.keyCode === $.ui.keyCode.UP) { // 38
	        if (ri > 0) {
	            $(rows[ri-1]).focus();
	        }
	    }
	    if (e.keyCode === $.ui.keyCode.DOWN) { // 40
	        if (ri + 1 < rows.length) {
				$(rows[ri+1]).focus();

	        }
	    }
	}
});
</script>
</div>

</body>
</html>