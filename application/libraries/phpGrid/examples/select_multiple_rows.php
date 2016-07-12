<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Select Multiple Rows</title>
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

// read only columns, one or more columns delimited by comma
$dg -> set_col_readonly("orderDate, customerNumber"); 

// required fields
$dg -> set_col_required("orderNumber, customerNumber");

// multiple select
$dg -> set_multiselect(true);

$dg -> display();

?>
<input type="button" id="bSelRow" value="Get Selected Rows" onclick="showSelectedRows()" style="background:red;color:white;font-size:14px">
<input type="button" id="bSavSelRowIds" value="Save Selected Row Ids" onclick="saveSelectedRowIds()" style="background:blue;color:white;font-size:14px">
<input type="button" id="bSavSelRows" value="Save Selected Rows" onclick="saveSelectedRows()" style="background:green;color:white;font-size:14px">

<script type="text/javascript">
function showSelectedRows(){
    var rows = getSelRows();
    if (rows == "") {
        alert("no rows selected");
        return;
    }else{
    	alert(rows);
	}
}


function saveSelectedRowIds() {
    var rows = getSelRows();
    if (rows == "") {
        alert("no rows selected");
        return;
    } else { 
        $.ajax({
		  url: 'http://example.com/save_selected_rowids.php',
		  data: {selectedRows: rows},
		  type: 'POST',
		  dataType: 'JSON'
		});
		alert(rows + ' row Ids were posted to a remote URL via $.ajax');
    }
    // window.location = "index.php#ajax/save_selected_row.php?refresh=1&rows="+rows;
}

function saveSelectedRows(){
	gdata = $('#orders').jqGrid('getRowData');
	rows = getSelRows();
	if (rows == "") {
        alert("no rows selected");
        return;
    } else { 
		selIndices = [];  // get index selected
		$.each(gdata, function(index, value){
			if($.inArray(value["orderNumber"], rows) != -1){
				selIndices.push(index);
			}
		});
		selRows = [];	// get row object from each index selected
		$.each(gdata, function(index, value){
			if($.inArray(index, selIndices) != -1){
				selRows.push(gdata[index]);
			}
		})
		$.ajax({
		  url: 'http://example.com/save_selected_rows.php',
		  data: {selectedRows: selRows},
		  type: 'POST',
		  dataType: 'JSON'
		});
		alert(selRows + ' with row ids ' + rows + ' were posted to a remote URL via $.ajax');
    }
}

</script>


</body>
</html>