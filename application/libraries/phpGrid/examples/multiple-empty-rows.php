<?php
//include('../../Glimpse/index.php');
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A Basic PHP Datagrid</title>
</head>
<body>
<?php
$dg = new C_DataGrid("SELECT * FROM shippers", "ShipperID", "shippers");

$onGridLoadComplete = <<<ONGRIDLOADCOMPLETE
function (event, data) 
{
    var grid = jQuery("#shippers"),
    pageSize = parseInt(grid.jqGrid("getGridParam", "rowNum")),
    emptyRows = pageSize - data.rows.length;

  if (emptyRows > 0) {
    for (var i = 1; i <= emptyRows; i++)
        // Send rowId as undefined to force jqGrid to generate random rowId
        grid.jqGrid('addRowData', undefined, {});

    // adjust the counts at lower right
    grid.jqGrid("setGridParam", {
      reccount: grid.jqGrid("getGridParam", "reccount") - emptyRows,
      records: grid.jqGrid("getGridParam", "records") - emptyRows
    });
    grid[0].updatepager();
  }
}
ONGRIDLOADCOMPLETE;
$dg->add_event("jqGridLoadComplete", $onGridLoadComplete);

$dg->enable_edit('INLINE');
$dg -> display();
?>
</body>
</html>