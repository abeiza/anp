<?php
//include('../../Glimpse/index.php');
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A Pivot Datagrid</title>
</head>
<body>
<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");

// setting options: http://www.trirand.com/jqgridwiki/doku.php?id=wiki:pivotsettings
$dg->set_pivotgrid(
		array
		(
		    "footerTotals" => 1,
		    "footerAggregator" => "sum",
		    "totals" => 1,
		    "totalHeader" => "Grand Total",
		    "totalText" => "Grand {0} {1}",
		    "xDimension" => array
		        (
		            array
		                (
		                    "dataName" => "status",
		                    "label" => "status",
		                    "sortorder" => "desc"
		                ),
					array
		                (
		                    "dataName" => "ProductName",
		                    "label" => "Product Name",
		                    "footerText" => "Total:"
		                )

		        ),

		    "yDimension" => array
		        (
		            array
		                (
		                    "dataName" => "orderDate",
		                    "sorttype" => "date",
		                    "totalHeader" => "Total in {0}"
		                )

		        ),

		    "aggregates" => array
		        (
		            array
		                (
		                    "member" => "status",
		                    "aggregator" => "count",
		                    "summaryType" => "count",
		                    "label" => "{1}"
		                )

		        )

		)
	);

$dg -> display();



?>
    
</body>
</html>