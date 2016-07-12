<?php
require_once("../conf.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpGrid - Persist State</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>

<?php
$dg = new C_DataGrid("SELECT * FROM orders", "orderNumber", "orders");
$dg->display();
?>

<script type="text/javascript">

$(document).ready(function () {
    $grid = phpGrid_orders,
        numberSearchOptions = ['eq', 'ne', 'lt', 'le', 'gt', 'ge', 'nu', 'nn', 'in', 'ni'],
        numberTemplate = {formatter: 'number', align: 'right', sorttype: 'number',
            searchoptions: { sopt: numberSearchOptions }},
        cm = jQuery('#orders').jqGrid('getGridParam', 'colModel'),
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
        myColumnStateName = 'ColumnChooserAndLocalStorage.colState',
        saveColumnState = function (perm) {
            var colModel = phpGrid_orders.jqGrid('getGridParam', 'colModel'), i, l = colModel.length, colItem, cmName,
                postData = phpGrid_orders.jqGrid('getGridParam', 'postData'),
                columnsState = {
                    search: phpGrid_orders.jqGrid('getGridParam', 'search'),
                    page: phpGrid_orders.jqGrid('getGridParam', 'page'),
                    sortname: phpGrid_orders.jqGrid('getGridParam', 'sortname'),
                    sortorder: phpGrid_orders.jqGrid('getGridParam', 'sortorder'),
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
        myColumnsState='',
        isColState=null,
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
});

</script>

<script type="text/javascript">
//<![CDATA[
/*global $ */
/*jslint devel: true, browser: true, plusplus: true */
/*
$.jgrid.formatter.integer.thousandsSeparator = ',';
$.jgrid.formatter.number.thousandsSeparator = ',';
$.jgrid.formatter.currency.thousandsSeparator = ',';
$(document).ready(function () {
    'use strict';
    var myData = [
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
        $grid = $("#list"),
        initDateSearch = function (elem) {
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
        numberSearchOptions = ['eq', 'ne', 'lt', 'le', 'gt', 'ge', 'nu', 'nn', 'in', 'ni'],
        numberTemplate = {formatter: 'number', align: 'right', sorttype: 'number',
            searchoptions: { sopt: numberSearchOptions }},
        cm = [
            //{name: 'id', index: 'id', width: 70, align: 'center', sorttype: 'int', formatter: 'int'},
            {name: 'invdate', index: 'invdate', width: 75, align: 'center', sorttype: 'date',
                formatter: 'date', formatoptions: {newformat: 'd-M-Y'}, datefmt: 'd-M-Y',
                searchoptions: {
                    sopt: ['eq', 'ne'],
                    dataInit: initDateSearch
                }},
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
        myColumnStateName = 'ColumnChooserAndLocalStorage.colState',
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
        datatype: 'local',
        data: myData,
        colNames: ['Date', 'Client', 'Amount', 'Tax', 'Total', 'Closed', 'Shipped via', 'Notes'],
        colModel: cm,
        rowNum: 10,
        rowList: [5, 10, 20],
        pager: '#pager',
        gridview: true,
        page: isColState ? myColumnsState.page : 1,
        search: isColState ? myColumnsState.search : false,
        postData: isColState ? { filters: myColumnsState.filters } : {},
        sortname: isColState ? myColumnsState.sortname : 'invdate',
        sortorder: isColState ? myColumnsState.sortorder : 'desc',
        rownumbers: false,
        ignoreCase: true,
        //shrinkToFit: false,
        //viewrecords: true,
        caption: 'The usage of localStorage to save jqGrid preferences',
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
        resizeStop: function () {
            saveColumnState.call($grid, $grid[0].p.remapColumns);
        }
    });
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
});
*/
//]]>
</script>

<table id="list"><tr><td/></tr></table>
<div id="pager"></div>

</body>
</html>