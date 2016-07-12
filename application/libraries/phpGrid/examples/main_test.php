<?php
//include('../../Glimpse/index.php');
require_once("../conf.php");      
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>A Basic PHP Datagrid</title>
</head>
<body>
<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");
$dg->enable_rownumbers(true);

$dg -> before_script_end =
                "cm = jQuery('#orders').jqGrid('getGridParam', 'colModel'),

                saveObjectInLocalStorage = function (storageItemName, object) {
                    if (typeof window.localStorage !== 'undefined') {
                        console.log(object);
                        window.localStorage.setItem(storageItemName, JSON.stringify(object));
                    }
                },
                removeObjectFromLocalStorage = function (storageItemName) {
                    if (typeof window.localStorage !== 'undefined') {
                        window.localStorage.removeItem(storageItemName);
                    }
                },
                getObjectFromLocalStorage = function (storageItemName) {
                    if (typeof window.localStorage !== 'undefined') {
                        return JSON.parse(window.localStorage.getItem(storageItemName));
                    }
                },
                myColumnStateName = 'ColumnChooserAndLocalStorage.colState',
                saveColumnState = function (perm) {
                    // console.log('hi');
                    // console.log(this);
                    var colModel = this.jqGrid('getGridParam', 'colModel'), i, l = colModel.length, colItem, cmName,
                        postData = this.jqGrid('getGridParam', 'postData'),
                        columnsState = {
                            search: this.jqGrid('getGridParam', 'search'),
                            page: this.jqGrid('getGridParam', 'page'),
                            sortname: this.jqGrid('getGridParam', 'sortname'),
                            sortorder: this.jqGrid('getGridParam', 'sortorder'),
                            permutation: perm,
                            colStates: {}
                        },
                        colStates = columnsState.colStates;

                    if (typeof (postData.filters) !== 'undefined') {
                        columnsState.filters = postData.filters;
                    }

                    for (i = 0; i < l; i++) {
                        colItem = colModel[i];

                        console.log(colItem.name + ': ' + colItem.width);
                        cmName = colItem.name;
                        if (cmName !== 'rn' && cmName !== 'cb' && cmName !== 'subgrid') {
                            colStates[cmName] = {
                                width: colItem.width,
                                hidden: colItem.hidden
                            };
                        }
                    }
                    saveObjectInLocalStorage(myColumnStateName, columnsState);


                },
                myColumnsState = null,
                isColState = false,
                restoreColumnState = function (colModel) {
                    var colItem, i, l = colModel.length, colStates, cmName,
                        columnsState = getObjectFromLocalStorage(myColumnStateName);

                    if (columnsState) {
                        colStates = columnsState.colStates;
                        for (i = 0; i < l; i++) {
                            colItem = colModel[i];
                            cmName = colItem.name;
                            if (cmName !== 'rn' && cmName !== 'cb' && cmName !== 'subgrid') {
                                colModel[i] = $.extend(true, {}, colModel[i], colStates[cmName]);
                            }
                        }
                    }
                    return columnsState;
                },
                firstLoad = true;

            myColumnsState = restoreColumnState(cm);
            isColState = typeof (myColumnsState) !== 'undefined' && myColumnsState !== null;";

$gridComplete = <<<GRIDCOMPLETE
function ()
{
  //  console.log('firstload: ' + firstLoad);
  //  console.log(isColState);
  //  console.log(myColumnsState);

    $(this).jqGrid("remapColumns", myColumnsState.permutation, true);

   if (firstLoad) {
        firstLoad = false;
        if (isColState) {
            $(this).jqGrid("remapColumns", myColumnsState.permutation, true);
        }
    }
   saveColumnState.call($(this), this.p.remapColumns);
}
GRIDCOMPLETE;

$dg->add_event("jqGridLoadComplete", $gridComplete);

$dg -> display();
?>





<script type="text/javascript">
    //<![CDATA[
        /*global $ */
        /*jslint devel: true, browser: true, plusplus: true */
        $.jgrid.formatter.integer.thousandsSeparator = ',';
        $.jgrid.formatter.number.thousandsSeparator = ',';
        $.jgrid.formatter.currency.thousandsSeparator = ',';
        $(document).ready(function () {
            'use strict';
            /*var myData = [
                    {id: "1",  invdate: "2007-10-01", name: "test",   note: "note",   amount: "200.00", tax: "10.00", closed: true,  ship_via: "TN", total: "210.00"},
                    {id: "2",  invdate: "2007-10-02", name: "test2",  note: "note2",  amount: "300.00", tax: "20.00", closed: false, ship_via: "FE", total: "320.00"},
                    {id: "3",  invdate: "2011-07-30", name: "test3",  note: "note3",  amount: "400.00", tax: "30.00", closed: true,  ship_via: "FE", total: "430.00"},
                    {id: "4",  invdate: "2007-10-04", name: "test4",  note: "note4",  amount: "200.00", tax: "10.00", closed: true,  ship_via: "TN", total: "210.00"},
                    {id: "5",  invdate: "2007-10-31", name: "test5",  note: "note5",  amount: "300.00", tax: "20.00", closed: false, ship_via: "FE", total: "320.00"},
                    {id: "6",  invdate: "2007-09-06", name: "test6",  note: "note6",  amount: "400.00", tax: "30.00", closed: false, ship_via: "FE", total: "430.00"},
                    {id: "7",  invdate: "2011-07-30", name: "test7",  note: "note7",  amount: "200.00", tax: "10.00", closed: true,  ship_via: "TN", total: "210.00"},
                    {id: "8",  invdate: "2007-10-03", name: "test8",  note: "note8",  amount: "300.00", tax: "20.00", closed: true,  ship_via: "FE", total: "320.00"},
                    {id: "9",  invdate: "2007-09-01", name: "test9",  note: "note9",  amount: "400.00", tax: "30.00", closed: false, ship_via: "TN", total: "430.00"},
                    {id: "10", invdate: "2007-09-08", name: "test10", note: "note10", amount: "500.00", tax: "30.00", closed: true,  ship_via: "TN", total: "530.00"},
                    {id: "11", invdate: "2007-09-08", name: "test11", note: "note11", amount: "500.00", tax: "30.00", closed: false, ship_via: "FE", total: "530.00"},
                    {id: "12", invdate: "2007-09-10", name: "test12", note: "note12", amount: "500.00", tax: "30.00", closed: false, ship_via: "FE", total: "530.00"}
                ],
                */
                var $grid = $("#list"),
/*                initDateSearch = function (elem) {
                    setTimeout(function () {
                        $(elem).datepicker({
                            dateFormat: 'dd-M-yy',
                            autoSize: true,
                            //showOn: 'button', // it dosn't work in searching dialog
                            changeYear: true,
                            changeMonth: true,
                            showButtonPanel: true,
                            showWeek: true,
                            onSelect: function () {
                                var that = this;
                                if (this.id.substr(0, 3) === "gs_") {
                                    setTimeout(function () {
                                        that.triggerToolbar();
                                    }, 50);
                                } else {
                                    // to refresh the filter
                                    $(this).trigger('change');
                                }
                            }
                        });
                    }, 100);
                },
*/                numberSearchOptions = ['eq', 'ne', 'lt', 'le', 'gt', 'ge', 'nu', 'nn', 'in', 'ni'],
                numberTemplate = {formatter: 'number', align: 'right', sorttype: 'number',
                    searchoptions: { sopt: numberSearchOptions }},
                /* cm = [
                    //{name: 'id', index: 'id', width: 70, align: 'center', sorttype: 'int', formatter: 'int'},
                    {name: 'invdate', index: 'invdate', width: 75, align: 'center', sorttype: 'date',
                        formatter: 'date', formatoptions: {newformat: 'd-M-Y'}, datefmt: 'd-M-Y'
                        
                        searchoptions: {
                            sopt: ['eq', 'ne'],
                            dataInit: initDateSearch
                        }
                     },
                    {name: 'name', index: 'name', width: 65},
                    {name: 'amount', index: 'amount', width: 75, template: numberTemplate},
                    {name: 'tax', index: 'tax', width: 52, template: numberTemplate},
                    {name: 'total', index: 'total', width: 60, search: false, template: numberTemplate},
                    {name: 'closed', index: 'closed', width: 67, align: 'center', formatter: 'checkbox',
                        edittype: 'checkbox', editoptions: {value: 'Yes:No', defaultValue: 'Yes'},
                        stype: 'select', searchoptions: { sopt: ['eq', 'ne'], value: ':Any;true:Yes;false:No' }},
                    {name: 'ship_via', index: 'ship_via', width: 95, align: 'center', formatter: 'select',
                        edittype: 'select', editoptions: {value: 'FE:FedEx;TN:TNT;IN:Intim', defaultValue: 'Intime'},
                        stype: 'select', searchoptions: { sopt: ['eq', 'ne'], value: ':Any;FE:FedEx;TN:TNT;IN:Intim'}},
                    {name: 'note', index: 'note', width: 60, sortable: false}
                ],
                */
                saveObjectInLocalStorage = function (storageItemName, object) {
                    if (typeof window.localStorage !== 'undefined') {
                        window.localStorage.setItem(storageItemName, JSON.stringify(object));
                    }
                },
                removeObjectFromLocalStorage = function (storageItemName) {
                    if (typeof window.localStorage !== 'undefined') {
                        window.localStorage.removeItem(storageItemName);
                    }
                },
                getObjectFromLocalStorage = function (storageItemName) {
                    if (typeof window.localStorage !== 'undefined') {
                        return JSON.parse(window.localStorage.getItem(storageItemName));
                    }
                },
                myColumnStateName = 'ColumnChooserAndLocalStorage_FOO.colState',
                saveColumnState = function (perm) {
                    var colModel = this.jqGrid('getGridParam', 'colModel'), i, l = colModel.length, colItem, cmName,
                        postData = this.jqGrid('getGridParam', 'postData'),
                        columnsState = {
                            search: this.jqGrid('getGridParam', 'search'),
                            page: this.jqGrid('getGridParam', 'page'),
                            sortname: this.jqGrid('getGridParam', 'sortname'),
                            sortorder: this.jqGrid('getGridParam', 'sortorder'),
                            permutation: perm,
                            colStates: {}
                        },
                        colStates = columnsState.colStates;
        
                    if (typeof (postData.filters) !== 'undefined') {
                        columnsState.filters = postData.filters;
                    }
        
                    for (i = 0; i < l; i++) {
                        colItem = colModel[i];
                        cmName = colItem.name;
                        if (cmName !== 'rn' && cmName !== 'cb' && cmName !== 'subgrid') {
                            colStates[cmName] = {
                                width: colItem.width,
                                hidden: colItem.hidden
                            };
                        }
                    }
                    saveObjectInLocalStorage(myColumnStateName, columnsState);
                },
                myColumnsState,
                isColState,
                restoreColumnState = function (colModel) {
                    var colItem, i, l = colModel.length, colStates, cmName,
                        columnsState = getObjectFromLocalStorage(myColumnStateName);
        
                    if (columnsState) {
                        colStates = columnsState.colStates;
                        for (i = 0; i < l; i++) {
                            colItem = colModel[i];
                            cmName = colItem.name;
                            if (cmName !== 'rn' && cmName !== 'cb' && cmName !== 'subgrid') {
                                colModel[i] = $.extend(true, {}, colModel[i], colStates[cmName]);
                            }
                        }
                    }
                    return columnsState;
                },
                firstLoad = true;
        
            myColumnsState = restoreColumnState(cm);
            isColState = typeof (myColumnsState) !== 'undefined' && myColumnsState !== null;

            $grid.jqGrid({
                url:"/phpGridx/data.php?dt=json&gn=orders",
                datatype: 'json',
               // data: myData,
               // colNames: [/*'Inv No',*/'Date', 'Client', 'Amount', 'Tax', 'Total', 'Closed', 'Shipped via', 'Notes'],
               // colModel: cm,
                colNames: ["orderNumber", "orderDate", "requiredDate", "shippedDate", "status", "comments", "customerNumber"],
                    colModel: [{
                        "name": "orderNumber",
                        "index": "orderNumber",
                        "hidden": false,
                        "edittype": "text",
                        "editable": false,
                        "editoptions": {
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false,
                            "number": true
                        }
                    }, {
                        "name": "orderDate",
                        "index": "orderDate",
                        "hidden": false,
                        "edittype": "text",
                        "editable": false,
                        "editoptions": {
                            "dataInit": function(el) {
                                $(el).datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    dateFormat: 'yy-mm-dd'
                                });
                            },
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false
                        }
                    }, {
                        "name": "requiredDate",
                        "index": "requiredDate",
                        "hidden": false,
                        "edittype": "text",
                        "editable": false,
                        "editoptions": {
                            "dataInit": function(el) {
                                $(el).datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    dateFormat: 'yy-mm-dd'
                                });
                            },
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false
                        }
                    }, {
                        "name": "shippedDate",
                        "index": "shippedDate",
                        "hidden": false,
                        "edittype": "text",
                        "editable": false,
                        "editoptions": {
                            "dataInit": function(el) {
                                $(el).datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    dateFormat: 'yy-mm-dd'
                                });
                            },
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false
                        }
                    }, {
                        "name": "status",
                        "index": "status",
                        "hidden": false,
                        "edittype": "text",
                        "editable": false,
                        "editoptions": {
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false
                        }
                    }, {
                        "name": "comments",
                        "index": "comments",
                        "hidden": false,
                        "edittype": "textarea",
                        "editable": false,
                        "editoptions": {
                            "cols": 42,
                            "rows": 6,
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false
                        }
                    }, {
                        "name": "customerNumber",
                        "index": "customerNumber",
                        "hidden": false,
                        "edittype": "text",
                        "editable": false,
                        "editoptions": {
                            "size": "30"
                        },
                        "editrules": {
                            "edithidden": false,
                            "required": false,
                            "number": true
                        }
                    }],
                rowNum: 10,
                rowList: [5, 10, 20],
                pager: '#pager',
                gridview: true,
                sortable:function(){saveColumnState.call($grid, $grid[0].p.remapColumns);},
/*                page: isColState ? myColumnsState.page : 1,
                search: isColState ? myColumnsState.search : false,
                postData: isColState ? { filters: myColumnsState.filters } : {},
                sortname: isColState ? myColumnsState.sortname : 'invdate',
                sortorder: isColState ? myColumnsState.sortorder : 'desc',
*/                rownumbers: true,
                ignoreCase: true,
                //shrinkToFit: false,
                //viewrecords: true,
                caption: 'phpGrid Persist width',
                height: 'auto',
                loadComplete: function () {
                    if (firstLoad) {
                        firstLoad = false;
                        if (isColState) {
                            $(this).jqGrid("remapColumns", myColumnsState.permutation, true);
                        }
                    }
                    saveColumnState.call($(this), this.p.remapColumns);
                },
                resizeStop: function (newwidth, index) {
                    console.log("start saving state..." + newwidth);
                    saveColumnState.call($grid, $grid[0].p.remapColumns);
                    console.log("end save");
                    console.log(myColumnsState);
                }
            });

/*
            $.extend($.jgrid.search, {
                multipleSearch: true,
                multipleGroup: true,
                recreateFilter: true,
                closeOnEscape: true,
                closeAfterSearch: true,
                overlay: 0
            });
            $grid.jqGrid('navGrid', '#pager', {edit: false, add: false, del: false});
            $grid.jqGrid('navButtonAdd', '#pager', {
                caption: "",
                buttonicon: "ui-icon-calculator",
                title: "choose columns",
                onClickButton: function () {
                    $(this).jqGrid('columnChooser', {
                        done: function (perm) {
                            if (perm) {
                                this.jqGrid("remapColumns", perm, true);
                                saveColumnState.call(this, perm);
                            }
                        }
                    });
                }
            });
            $grid.jqGrid('navButtonAdd', '#pager', {
                caption: "",
                buttonicon: "ui-icon-closethick",
                title: "clear saved grid's settings",
                onClickButton: function () {
                    removeObjectFromLocalStorage(myColumnStateName);
                    window.location.reload();
                }
            });

*/
        });
    //]]>
    </script>

    <table id="list"><tr><td/></tr></table>
    <div id="pager"></div>

</body>
</html>