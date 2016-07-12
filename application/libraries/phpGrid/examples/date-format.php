<?php
//include('../../Glimpse/index.php');
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpGrid - Date Format Options</title>
</head>
<body>
<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");

// Method 1: change date display and datepicker display (used for edit) to Spanish date
$dg -> set_col_date("orderDate", "Y-m-d", "m/d/Y", "m/d/yy");

// Method 2: change date display and datepicker display (used for edit) to Spanish date
$dg -> set_col_property("requiredDate", 
                             array("formatter"=>"date",
                                   "formatoptions"=>array("srcformat"=>"Y-m-d","newformat"=>"m/d/Y"),
                                   "editoptions"=>array(
			                            "dataInit"=>"function(el) {
			                                $(el).datepicker({
			                                    changeMonth: true,
			                                    changeYear: true,
			                                    dateFormat: 'm/d/yy'
			                                })
				                        }")));

// Method 3: Display using jQuery Datetimepicker extension replacing the built-in datepicker plus option time picker
$dg -> set_col_datetime("contractDateTime", "Y-m-d H:i", "m/d/Y H:i", "m/d/Y H:i");

// Display time only. No date. It cannot be edited, so we also made it hidden on the edit form.
$dg -> set_col_property("shippedDate",
            array("formatter"=>"date", 
                "formatoptions"=>array("srcformat"=>"ISO8601Short","newformat"=>"g:i A"),
                'editable'=>false,'hidedlg'=>true));


$dg->enable_edit();
$dg -> display();
?>
    
</body>
</html>