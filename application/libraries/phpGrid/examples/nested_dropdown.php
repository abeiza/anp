<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Nested Dropdown</title>
</head>
<body>

<p>
Note:<br />
<ul>
    <li>The example demostrate dependent dropdown, or sometimes called nested dropdown. It can be nested in unlimited level.
    <li>It's important that all the dropdowns must be set to "autocomplete" edit type before calling set_nested_dropdown() method.
    <li>Due to the way the select is implemented in jqGrid, the 3rd parameter of set_col_edittype() method must contain the<br />
        ENTIRE string of all the key:value pair of that column, or the data will appear to be missing when display. There is no way
        around due to the jqGrid limitation.
    <li>The dependency logic is essentially embedded in the javascript data source (e.g. $countryStateData) used to populate the dropdown dynamically based on <br />
        its selected parent value.
    <li>Nested dropdown only works in INLINE edit at the moment.</li>
</ul>
In a nutshell, the phpGrid displays the datagrid rendered by jqGrid. Select2 does the autocomplete and nested dropdown completely on the client side. <br />
which is also the reason why the data javascript data source must be structured correctly.
</p>

<?php
$countryStateData =
    array(
        'usa' => array(
            array('id'=>'',   'text'=>''),
            array('id'=>'ca', 'text'=>'CA'),
            array('id'=>'al', 'text'=>'AL'),
            array('id'=>'nj', 'text'=>'NJ')
         ),
        'canada' => array(
            array('id'=>'',   'text'=>''),
            array('id'=>'ab', 'text'=>'AB'),
            array('id'=>'qc', 'text'=>'QC'),
            array('id'=>'bc', 'text'=>'BC')
        )
    );

$stateCityData =
    array(
        'ca' => array(
            array('id'=>'',   'text'=>''),
            array('id'=>'ca', 'text'=>'San Francisco'),
            array('id'=>'al', 'text'=>'Los Angeles'),
            array('id'=>'nj', 'text'=>'San Diego')
         ),
        'al' => array(
            array('id'=>'',   'text'=>''),
            array('id'=>'ab', 'text'=>'test'),
            array('id'=>'qc', 'text'=>'test2'),
            array('id'=>'bc', 'text'=>'city2')
        ),
        'bc' => array(
            array('id'=>'',   'text'=>''),
            array('id'=>'ab', 'text'=>'2342344'),
            array('id'=>'qc', 'text'=>'bc city2'),
            array('id'=>'bc', 'text'=>'bc city333')
        )
    );
echo '<script>';
echo 'var countryStateData = '. json_encode($countryStateData).";\n";
echo 'var stateCityData = '. json_encode($stateCityData).";\n";
echo '</script>';
?>


<?php
$dg = new C_DataGrid('select customerNumber, customerName, phone, city, country, state, creditLimit from customers', 'customerNumber', 'customers');
$dg->enable_edit('FORM');
$dg->set_col_edittype('country', 'autocomplete', ':;usa:USA;canada:Canada;France:France;Germany:Germany;Norway:Norway;Poland:Poland;Australia:Australia;Spain:Spain;Denmark:Denmark;Singapore:Singapore;Belgium:Belgium;Finland:Finland;New Zealand:New Zealand;Italy:Italy;Japan:Japan;Irelan:Ireland;Hong Kong:Hong Kong;Russia:Russia;Israel:Israel');
$dg->set_col_edittype('state',   'autocomplete', ':;bc:BC;ab:AB;qc:QC;al:AL;nj:NJ;ca:CA;Co. Cork:Co. Cork;CT:CT;Isle of Wight:Isle of Wight;MA:MA;NH:NH;NSW:NSW;NV:NV;NY:NY;Osaka:Osaka;PA:PA;Pretoria:Pretoria;Québec:Québec;Queensland:Queensland;Tokyo:Tokyo;Victoria:Victoria');
$dg->set_nested_dropdown('country', 'state', 'countryStateData');

$dg->display();

?>

<h3>Dev note:</h3>
<pre>
//FORM select
$("#FrmGrid_customers tr#tr_country td select[id=country]")


//INLINE select
$("#customers tr#125 td select[id=125_country]")
$("#customers tr#125 td select[id=125_state]").select2("val", "nj");
//- OR -
$("#customers tr#125 td div#s2id_125_state > a > span.select2-chosen").text("ca");
</pre>

</body>
</html>
