<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modify Edit Method Using Javascript</title>
</head>
<body> 

<?php
$dg = new C_DataGrid("SELECT * FROM `orders`", "`orderNumber`", "orders");
$dg -> enable_edit("FORM", "CRUD");
$dg -> display();
?>

<script>
// set closeAfterEdit to false
$(document).ready(function(){
    var grid=$("#orders");      // your jqGrid (the <table> element)
    var orgEditGridRow = grid.jqGrid.editGridRow; // save original function
    $.jgrid.extend ({editGridRow : function(rowid, p){
        $.extend(p,
            {   // modify some parameters of editGridRow
                beforeShowForm: function(formid) {
                    alert("Edit form will stay open after submit.");
                },
                closeAfterEdit: false
            });
        orgEditGridRow.call (this,rowid, p);
    }});
});
</script>

</body>
</html>