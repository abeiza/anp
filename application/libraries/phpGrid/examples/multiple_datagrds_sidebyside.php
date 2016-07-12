<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Multiple Datagrids Side by Side Layout</title>
</head>
<body>

<div id="bigcontainer">

    <div id="dg1">
        <?php
        $dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", 'orders');
        $dg->enable_edit("FORM", "CRUD");
        $dg->display();
        ?>
    </div>

    <div id="dg2">
        <?php
        $dg2 = new C_DataGrid("select * from employees", "employeeNumber", "employees");
        $dg2->enable_edit("FORM", "CRUD");
        $dg2->display();
        ?>
    </div>


    <div id="dg3">
        <?php
        $dg3 = new C_DataGrid("select * from offices", "officeCode", "offices");
        $dg3->enable_edit("FORM", "CRUD");
        $dg3->display();
        ?>
    </div>

</div>

<style>
    div#bigcontainer{
        width: 5000px;
    }
    div#dg1, div#dg2, div#dg2, div#dg3{
        float:left;
    }
</style>

</body>
</html>