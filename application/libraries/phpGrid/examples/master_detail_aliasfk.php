<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Master/Detail with Alias FK, Parent/Child PHP Datagrid</title>
</head>
<body>

<?php
$sg = new C_DataGrid("SELECT employeeNumber, employeeNumber as salesRepEmployeeNumber, lastName, firstName, email, jobTitle FROM  employees","employeeNumber","employees");
$sg_d1 = new C_DataGrid("SELECT customerNumber, customerName, city, state, salesRepEmployeeNumber, phone FROM customers","customerNumber","customers");

$sg->set_masterdetail($sg_d1, 'salesRepEmployeeNumber');
$sg->enable_edit()->set_col_readonly("salesRepEmployeeNumber");;
$sg_d1->enable_edit();

$sg->display();
?>
</body>
</html>  

