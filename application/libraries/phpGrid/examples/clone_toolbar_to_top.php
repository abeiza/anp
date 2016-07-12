<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Clone Topbar to Top</title>
</head>
<body>

<?php
$dg = new C_DataGrid("SELECT `orderNumber`, `orderDate`, `requiredDate`, `shippedDate`, `status`, `comments`, `customerNumber` FROM `orders`", "`orderNumber`", "orders");

// change column titles
$dg -> set_col_title("orderNumber", "Order No.");
$dg -> set_col_title("orderDate", "Order Date");
$dg -> set_col_title("shippedDate", "Shipped Date");
$dg -> set_col_title("customerNumber", "Customer No.");

$dg->cust_prop_jsonstr = 'toppager:true,';
// Add top toolbar
$dg->before_script_end = '
        jQuery("#orders")
                    .navSeparatorAdd("#orders_toppager_left",{
                        position:"first"
                    })
                    .navButtonAdd("#orders_toppager_left",{
                        caption:"Advanced Search &nbsp;",
                        title:"Advanced Search",
                        buttonicon:"ui-icon-search",
                        onClickButton: function(){
                            jQuery("#orders").jqGrid("searchGrid", {multipleSearch:true,showQuery:true});
                        },
                        position:"first"
                    })
                    .navButtonAdd("#orders_toppager_left",{
                        caption:"",
                        title:"Inline Search",
                        buttonicon:"ui-icon-search",
                        onClickButton: function(){
                                phpGrid_orders[0].toggleToolbar();
                        },
                        position:"last"
                    })
                    .navButtonAdd("#orders_toppager_left",{
                        caption:"",
                        title:"Export to Excel",
                        buttonicon:"ui-icon-extlink",
                        onClickButton: function(){
                            jQuery("#orders").jqGrid("excelExport",{url:"../export.php?dt=json&gn=orders&export_type=EXCEL"});
                        },
                        position:"last"
                    })
                    .navSeparatorAdd("#orders_pager1_left",{
                        position:"first"
                    })
                    .navButtonAdd("#orders_pager1_left",{
                        caption:"Advanced Search &nbsp;",
                        buttonicon:"ui-icon-search",
                        onClickButton: function(){
                            jQuery("#orders").jqGrid("searchGrid", {multipleSearch:true,showQuery:true});
                        },
                        position:"first"
                    });

        ';

//  Add INLINE new button and script remove unwanted buttons
$dg->before_script_end .= '
        jQuery("#orders")
                    .navButtonAdd("#orders_toppager_left",{
                        caption:"",
                        title:"Add",
                        buttonicon:"ui-icon-plus",
                        onClickButton: function(){
                            jQuery("#orders").jqGrid("addRow","new",{reloadAfterSubmit:false});
                        },
                        position:"last"
                    });
                    
        var topPagerDiv = $("#orders_pager")[0];
        var btmPagerDiv = $("#orders_pager")[0];

        $("#refresh_orders_top", topPagerDiv).remove();
        $("#refresh_orders", btmPagerDiv).remove();';

$dg -> enable_edit("INLINE", "CRUD");
$dg->enable_search(true);
$dg -> display();
?>

</body>
</html>