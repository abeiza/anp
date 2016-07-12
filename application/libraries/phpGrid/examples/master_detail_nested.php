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
//suppliers master-detail
$sg = new C_DataGrid("SELECT * FROM suppliers","supplierCode","suppliers");
$sg->set_sql_key("supplierName");
$sg->enable_export('PDF');

// change column titles
$sg->set_col_title("supplierCode", "Supplier Code");
$sg->set_col_title("supplierName", "Supplier Name");
$sg->set_col_title("supplierAddress", "Address");
$sg->set_col_title("supplierState", "State");
$sg->set_col_title("supplierZip", "Zip Code");
$sg->set_col_title("supplierPhoneNumber", "Phone Number");

//supplier detail2: products
$sg_d1 = new C_DataGrid("SELECT * FROM products","productCode","products");
$sg_d1->enable_export('EXCEL');

// change column titles
$sg_d1->set_col_title("productCode", "Product Code");
$sg_d1->set_col_title("productName", "Product Name");
$sg_d1->set_col_title("productDescription", "Product Description");
$sg_d1->set_col_title("quantityInStock", "In-Stock");
$sg_d1->set_col_title("MSRP", "Retail Price");

//nested grid-level 3 for products
$sg_d1_n1 = new C_DataGrid("SELECT * FROM productparts","partNo","productparts");
$sg_d1_n1->enable_export('HTML');

// change column titles
$sg_d1_n1->set_col_title("partNo", "Part No.");
$sg_d1_n1->set_col_title("partName", "Part Name");
$sg_d1_n1->set_dimension(600);


//hide other columns
//$sg_d1_n1 -> set_col_hidden("productCode", false);

//set detail for products
$sg_d1->set_masterdetail($sg_d1_n1, 'productCode');

//set detail 2 for suppliers
$sg->set_masterdetail($sg_d1, 'supplierZip');

$sg->enable_edit();
$sg_d1->enable_edit();
$sg_d1_n1->enable_edit();

$sg->display();
?>
</body>
</html>