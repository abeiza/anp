<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpGrid Edit Form Layout</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders"); 

// change column titles
$dg -> set_col_title("orderNumber", "Order No.");
$dg -> set_col_title("orderDate", "Order Date");
$dg -> set_col_title("shippedDate", "Shipped Date");
$dg -> set_col_title("customerNumber", "Customer No.");

// hide a column
$dg -> set_col_hidden("requiredDate");

// enable edit
$dg -> enable_edit("FORM", "CRUD"); 

$dg -> set_col_property("orderNumber", array("formoptions"=>array("rowpos"=>1,"colpos"=>1)));
$dg -> set_col_property("orderDate", array("formoptions"=>array("rowpos"=>1,"colpos"=>2)));
$dg -> set_col_property("requiredDate", array("formoptions"=>array("rowpos"=>2,"colpos"=>1)));
$dg -> set_col_property("shippedDate", array("formoptions"=>array("rowpos"=>2,"colpos"=>2)));
$dg -> set_col_property("status", array("formoptions"=>array("rowpos"=>3,"colpos"=>1)));
$dg -> set_col_property("customerNumber", array("formoptions"=>array("rowpos"=>3,"colpos"=>2)));
$dg -> set_col_property("comments", array("formoptions"=>array("rowpos"=>4,"colpos"=>1)));
$dg -> set_col_property("comments", array("editoptions"=>array("style"=>"width:95%;")));

$dg->set_col_wysiwyg('comments');

$dg->set_form_dimension(700, 400);

$dg->enable_debug(false);
$dg -> display();
?>

<script>
// set <textarea> to always have the full width of the form. Make sure nothing else is sharing the same row!
$(document).ready(function(){
    var grid=$("#orders");      // your jqGrid (the <table> element)
    var orgEditGridRow = grid.jqGrid.editGridRow; // save original function
    $.jgrid.extend ({editGridRow : function(rowid, p){
        $.extend(p,
            {
                beforeShowForm : function(form) {
                    form = $(form);
                    $("tr", form).each(function() {
                        var inputs = $(">td.DataTD:has(textarea)",this);
                        if (inputs.length == 1) {
                            var tds = $(">td", this);
                            tds.eq(1).attr("colSpan", tds.length - 1);
                            tds.slice(2).hide();
                        }
                    });
                }
            });
        orgEditGridRow.call (this,rowid, p);
    }});
});
</script>
</body>
</html>