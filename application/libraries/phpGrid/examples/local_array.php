<?php
require_once("../conf.php");
if (!isset($HTTP_POST_VARS) && isset($_POST)){ $HTTP_POST_VARS = $_POST;}  // backward compability when register_long_arrays = off in config

$theme_name = (isset($_POST['_gridThemeRoller']))? $_POST['_gridThemeRoller']:'clean';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Load Grid from Local Data Array with Theme Changer</title>
</head>
<body>

<style>
.tstyle
{
display:block;background-image:none;margin-right:-2px;margin-left:-2px;height:14px;padding:5px;background-color:red;color:whitefont-weight:bold
}
</style>


<?php

$name = array('Bonado', 'Sponge', 'Decker', 'Snob', 'Kocoboo');
//*
for ($i = 0; $i < 200; $i++)
{
	$data1[$i]['id']    = $i+1;
	$data1[$i]['foo']    = md5(rand(0, 10000));
	$data1[$i]['bar1']    = 'bar'.($i+1);
	$data1[$i]['bar2']    = 'bar'.($i+1);
	$data1[$i]['cost']    = rand(0, 100);
	$data1[$i]['name']	  = $name[rand(0, 4)];
	$data1[$i]['quantity'] = rand(0, 100);
	$data1[$i]['discontinued'] = rand(0, 1);
	$data1[$i]['email']	= 'grid_'. rand(0, 100) .'@example.com';
	$data1[$i]['notes'] = '';
}
/**/

$dg = new C_DataGrid($data1, "id", "data1");
$dg->set_col_title("id", "ID")->set_col_width('id', 20);
$dg->set_col_title("foo", "Foo");
$dg->set_col_title("bar", "Bar");
$dg->set_col_title('discontinued', 'disc.')->set_col_width('discontinued', 35);
$dg->set_col_align('cost', 'right')->set_col_currency('cost', '$');
$dg->set_col_width('bar1', 40);
$dg->set_col_width('quantity', 220);
$dg->set_row_color('lightblue', 'yellow', 'lightgray');
$dg->enable_search(true);
$dg->enable_edit('FORM', 'CRUD');
$dg->enable_export('EXCEL');
$dg->enable_resize(true);
$dg->set_col_format('email', 'email');
$dg->set_col_dynalink('name', 'http://example.com', array("id", "name"));
$dg->set_caption('Array Data Test');
$dg->set_col_hidden('bar2');
$dg->set_col_property('notes', array('edittype'=>'textarea','editoptions'=>array('cols'=>40,'rows'=>10)))->set_col_wysiwyg('notes');
$dg->set_dimension(900, 400);
//$dg->set_multiselect(true);

$dg->set_conditional_value('discontinued', '==1',  array("TCellStyle"=>"tstyle"));
$dg->set_conditional_format("cost","CELL",array("condition"=>"lt","value"=>"20.00","css"=> array("color"=>"black","background-color"=>"yellow")));

$dg->set_theme($theme_name);

$dg -> set_col_property("quantity",  array("sorttype"=>"integer"));  // fix sort
$dg -> set_col_property("cost",  array("sorttype"=>"currency"));  // fix sort

$dg->set_databar('quantity', 'blue');

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