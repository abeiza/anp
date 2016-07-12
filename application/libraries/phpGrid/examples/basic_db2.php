<?php
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpGrid DB2</title>
</head>
<body>
<?php
/*
// Read more about PDO attributes -  https://www-01.ibm.com/support/knowledgecenter/SSEPGG_9.5.0/com.ibm.db2.luw.apdv.php.doc/doc/t0023135.html
    putenv('ODBCSYSINI=/etc');
    putenv('ODBCINI=/etc/odbc.ini');
    $username = "db2inst1";
    $password = "db2user99";
    try {
      $dbh = new PDO('odbc:sample',
                    "$username",
                    "$password"
                        , array(
                            PDO::ATTR_PERSISTENT => TRUE,
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                          );
    } catch (PDOException $exception) {
      echo "failed \n";
      echo $exception->getMessage();
      exit;
    }

    echo var_dump($dbh);

$sql = 'select * from EMPLOYEE';
foreach ($dbh->query($sql) as $row) {
        print $row['EMPNO'] . "\t";
        print $row['FIRSTNME'] . "\t";
        print $row['LASTNAME'] . "\n<p />";
    }

// $dbh->closeCursor;
unset($dbh);
/**/
//*
$dg = new C_DataGrid("SELECT * FROM EMPLOYEE", "EMPNO", "EMPLOYEE");
$dg->set_col_title('EMPNO', 'Employee #');
$dg->set_col_title('PHONENO', 'Phone Number');
$dg->set_col_width('SEX', 50)->set_col_align('SEX', 'center');
$dg->set_col_width('MIDINIT', 30)->set_col_align('MIDINIT', 'center');
$dg->enable_search(true);
$dg->enable_edit('FORM');
$dg->enable_export('CSV');
$dg->enable_autowidth(true);
$dg->set_col_edittype('WORKDEPT', 'select', 'select DEPTNO, DEPTNAME from DEPARTMENT');
$dg->set_col_edittype('SEX', 'select', 'M:M;F:F');
$dg->set_conditional_format("SEX","CELL",array(
    "condition"=>"eq","value"=>"F","css"=> array("color"=>"black","background-color"=>"#FDA6B2")));
$dg->set_conditional_format("SEX","CELL",array(
    "condition"=>"eq","value"=>"M","css"=> array("color"=>"black","background-color"=>"#A6D7FC")));
$dg->set_conditional_format("SALARY","CELL",array(
    "condition"=>"gt","value"=>75000,"css"=> array("color"=>"black","background-color"=>"lightgreen")));
$dg -> display();
/**/
/*
$dg = new C_DataGrid("SELECT * FROM User_Sample", "ID", "User_Sample");
$dg->display();
/**/
?>

<script type="text/javascript">
    $(function() {
        var grid = jQuery("#EMPLOYEE");
        grid[0].toggleToolbar();
    });
</script>

<pre id="_changes_debug_ajaxresponse"></pre>
<script type="text/javascript">﻿
// replace "phpGridx" with your path to phpGrid
$(document).ajaxComplete(function( event, xhr, settings ) {
  if ( settings.url.split('?')[0] === "/phpGrid/edit.php" ){  
    // alert( xhr.responseText ); 
    $("#_changes_debug_ajaxresponse").text( xhr.responseText );
  }
});
</script> 
</body>
</html>