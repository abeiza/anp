<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Single Level, Multiple Subgrids</title>
</head>
<body> 

<?php
//suppliers master-subgrid
$sg = new C_DataGrid("SELECT * FROM suppliers","supplierCode","suppliers");
//$sg->set_sql_key("supplierName");

// change column titles
$sg->set_col_title("supplierCode", "Supplier Code");
$sg->set_col_title("supplierName", "Supplier Name");
$sg->set_col_title("supplierAddress", "Address");
$sg->set_col_title("supplierState", "State");
$sg->set_col_title("supplierZip", "Zip Code");
$sg->set_col_title("supplierPhoneNumber", "Phone Number");
$sg->enable_edit("INLINE");
//supplier detail 1: product lines
$sg_d1 = new C_DataGrid("SELECT * FROM supplierproductlines","productLineNo","supplierproductlines");

// change column titles
$sg_d1->set_col_title("productLineNo", "Product Line No.");
$sg_d1->set_col_title("productLine", "Product Line");

$sg_d1->set_col_hidden("supplierCode");
$sg_d1->set_col_hidden("supplierName");

$sg_d1->enable_autowidth(true);

$sg_d1->enable_edit("INLINE", "CRUD");

$sg->set_subgrid($sg_d1, 'supplierName');


//supplier detail2: products
$sg_d2 = new C_DataGrid("SELECT * FROM products","productCode","products");

// change column titles
$sg_d2->set_col_title("productCode", "Product Code");
$sg_d2->set_col_title("productName", "Product Name");
$sg_d2->set_col_title("productDescription", "Product Description");
$sg_d2->set_col_title("quantityInStock", "In-Stock");
$sg_d2->set_col_title("MSRP", "Retail Price");

$sg_d2->set_col_wysiwyg("productDescription");
$sg_d2->enable_autowidth(true);



$sg_d2->enable_edit("INLINE");

//set detail 2 for suppliers
$sg->set_subgrid($sg_d2, 'supplierZip');


$sg->display();
?>
</body>
</html>  

