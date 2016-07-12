<?php
require_once("../conf.php");
if (!isset($HTTP_POST_VARS) && isset($_POST)){ $HTTP_POST_VARS = $_POST;}  // backward compability when register_long_arrays = off in config

$theme_name = (isset($_POST['_gridThemeRoller']))? $_POST['_gridThemeRoller']:'clean';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Load and Edit Grid from Complex Query with Theme Changer</title>
</head>
<body>

<?php
$sql = 'select
        s.supplierCode, s.supplierZip, s.supplierPhonenumber,
        spl.productLineNo, spl.productLine,
        p.productName, p.MSRP
        from suppliers s
        inner join supplierproductlines spl on s.supplierName = spl.supplierName
        inner join products p on s.supplierZip = p.supplierZip';

$db = new C_DataBase(PHPGRID_DB_HOSTNAME, PHPGRID_DB_USERNAME, PHPGRID_DB_PASSWORD, PHPGRID_DB_NAME, PHPGRID_DB_TYPE,PHPGRID_DB_CHARSET);

$results = $db->db_query($sql);
$data1 = array();
$count = 0;
while($row = $db->fetch_array_assoc($results)) {
 $data_row = array();
    for($i = 0; $i < $db->num_fields($results); $i++) {
        $col_name = $db->field_name($results, $i);
        $data1[$count][$col_name] = $row[$col_name];
    }
    $count++;
}

$dg = new C_DataGrid($data1, "id", "data1");
$dg->enable_edit('INLINE');
$dg->display();
?>




<!-- additional code snippet to submit local array back to server. users must provide their own save routine -->

<script src="http://malsup.github.com/jquery.form.js"></script>
<form id="admin_form">
    <div>
        <input type="submit" value="Submit Local Changes">
    </div>
</form>

<script>
    $(function() {
        // bind to the form's submit event
        $('#admin_form').submit(function(event) {
            $(this).ajaxSubmit({
                type: 'post',
                dataType:'json',
                url:'save_local_array.php',
                data:{
                    langArray:[] //leave as empty array here
                },
                beforeSubmit: function(arr, $form, options){
                    options.langArray = $('#data1').jqGrid('getRowData'); // get most current
                    console.log(JSON.stringify(options.langArray));
                    // return false; // here to prevent submit
                },
                success: function(){
                    // add routine here when success
                }
            });

            // return false to prevent normal browser submit and page navigation
            return false;
        });
    });
</script>

<br />
<div>
    The button above uses the below code snippet to submit local array back to server through Ajax POST.
    <a href="http://malsup.com/jquery/form/" target="_new">jQuery Form plugin</a> is required.
    Users must supply their own server-side save routine URL e.g. "save_local_array.php"
    <xmp style="background:#eee">
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <form id="admin_form">
            <div>
                <input type="submit" value="Submit Local Changes">
            </div>
        </form>

        <script>
            $(function() {
                // bind to the form's submit event
                $('#admin_form').submit(function(event) {
                    $(this).ajaxSubmit({
                        type: 'post',
                        dataType:'json',
                        url:'save_local_array.php',
                        data:{
                            langArray:[] //leave as empty array here
                        },
                        beforeSubmit: function(arr, $form, options){
                            options.langArray = $('#data1').jqGrid('getRowData'); // get most current
                            console.log(JSON.stringify(options.langArray));
                            // return false; // here to prevent submit
                        },
                        success: function(){
                            // add routine here when success
                        }
                    });

                    // return false to prevent normal browser submit and page navigation
                    return false;
                });
            });
        </script>
    </xmp>
</div>

</body>
</html>