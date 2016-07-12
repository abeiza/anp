<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Load Datagrid from a Google Spreadsheet</title>
</head>
<body>


<?php
$spreadsheet_url = 'https://docs.google.com/spreadsheets/d/1IvbMsUZTCdYb5zaciT3lWSXHPP_qPDG8FrJl8dq1ZbI/pub?output=csv';
$csv = file_get_contents($spreadsheet_url);
$rows = explode("\n",$csv);
$data = array();
$names = array();
for($i=0; $i<count($rows); $i++) {
    if($i==0){
        $names = str_getcsv($rows[$i]);
    }else{
        $data[] = str_getcsv($rows[$i]);
    }
}


$dg = new C_DataGrid($data, "id", "Google_Spreadsheet");
for($i=0; $i<count($names); $i++) {
    $dg->set_col_title($i, $names[$i]);
}
$dg->enable_search(true, array(1,2,3,5));
$dg->set_theme('aristo');
$dg->display();
?>


</body>
</html>