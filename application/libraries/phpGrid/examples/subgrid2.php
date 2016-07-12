<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Subgrid 2</title>
</head>
<body> 

<h3>Note:<br />that due to the calling sequence, the enable_edit() should be called BEFORE set_subgrid() method, or edit properties will be ignored.</h3>

<?php
$sg = new C_DataGrid("SELECT * FROM suppliers","supplierCode","suppliers");
$sg->enable_edit('INLINE', 'CRUD');

//supplier detail2: products
$sg_d2 = new C_DataGrid("SELECT * FROM products","productCode","products");
$sg_d2->enable_edit('INLINE', 'CRUD');

//set detail 2 for suppliers
$sg->set_subgrid($sg_d2, 'supplierZip');

$sg->display();
?>

</body>
</html>