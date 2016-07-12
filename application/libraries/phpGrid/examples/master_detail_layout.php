<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Master/Detail, Parent/Child PHP Datagrid</title>
</head>
<body>

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");
$sdg = new C_DataGrid("SELECT orderNumber,productCode,quantityOrdered,priceEach FROM orderdetails", array("productCode", "orderNumber"), "orderdetails");
$dg->set_masterdetail($sdg, 'orderNumber');
$dg->set_dimension('500');
$sdg->set_dimension('400');
$dg->display();
?>

<style>

    br{
        display:none;
    }
    div{
        float: left;
    }

</style>


</body>
</html>