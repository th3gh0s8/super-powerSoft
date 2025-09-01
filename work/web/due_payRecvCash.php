<?php
$title = 'Pay Receive Cash';
$pageRights = 'due_/due_payRecvCash';
include('path.php');

include('includeFile.php');


$sql_printNmCus = $mysqli->query("SELECT PrintNm FROM `all_print_type` WHERE Form = 'Pay Receive Cash' AND status = 'Customer' AND br_id = '$br_id'");
if($sql_printNmCus->num_rows == true){
    $printNmCus = $sql_printNmCus->fetch_array();
    $cusPrintNm = $printNmCus['PrintNm'];
}else{
    $cusPrintNm = 'paymntRecvInvPrint';
}

$sql_printNmVen = $mysqli->query("SELECT PrintNm FROM `all_print_type` WHERE Form = 'Pay Receive Cash' AND status = 'Vendor' AND br_id = '$br_id'");
if($sql_printNmVen->num_rows == true){
    $printNmVen = $sql_printNmVen->fetch_array();
    $venPrintNm = $printNmVen['PrintNm'];
}else{
    $venPrintNm = 'printVendor';
}

if (isset($_SESSION['print_functn'])) {
    
    if ($_SESSION['print_functn'] == 'payRecvPrnt_cus') {
        echo '<script>window.open("print/'.$cusPrintNm.'.php?PAY_PRINT='.$_SESSION['payRecvRecptNo'].'", "_BLANK")</script>';
    }else if ($_SESSION['print_functn'] == 'payRecvPrnt_ven()') {
        echo '<script>window.open("print/'.$venPrintNm.'.php?PAY_PRINT='.$_SESSION['payRecvRecptNo'].'", "_BLANK")</script>';
    }
    unset($_SESSION['print_functn']);
}


$title = 'Pay Receive Cash';


if (isset($_POST['hiddnID'])) {

    $payRecvType = $_POST['payRecvType'];
    $hiddnID = $_POST['hiddnID'];
    $srchNam = trim($_POST['serchTxt']);
    $reciptNo = $_POST['reciptNo'];
    $currencyID = explode(" ", $_POST['currency'])[0];
    $currencyValue = explode(" ", $_POST['currency'])[1];

    $entyDate = $_POST['entyDate'];
    $receivAmnt = (trim($_POST['receivAmnt']) !== '') ? $_POST['receivAmnt'] : 0;
    $payAmnt = (trim($_POST['payAmnt']) !== '') ? $_POST['payAmnt'] : 0;
    $descrptn = $_POST['descrptn'];

    $payBy = $_POST['com_pay'];
    $jour = $_POST['com_jou'];
    $jou2 = explode('|F|', $jour);
    $jtb = $jou2[0];
    $jID = $jou2[1];
    $jNm = $jou2[2];
    $jType = $jou2[3];
    $jShow = $jou2[4];



    $process = ($receivAmnt > 0) ? 'Receive' : 'Payment';
    $date = date('Y-m-d');
    $time = date('h:i:s');

    // get a new vourchar number ##################################################################################### 

    $qry_vno = $mysqli->query("SELECT MAX(VNo) FROM `jentry` where br_id= '$br_id'  AND VNo != '0' ORDER BY VNo DESC LIMIT 01  ");
    //echo "SELECT MAX(`VNo`) FROM `jentry` where br_id= '$br_id' ";
    $ecu_vno = $qry_vno->fetch_array();
    $vur_no = $ecu_vno[0];
    if ($vur_no < 10) {
        $vur_no = 9;
    }
    $var_no = $vur_no + 1;
    $v_no = trim($var_no);

    // get a new vourchar number ##################################################################################### 



    if ($payRecvType == 'Customer') {
        $printPage = 'payRecvPrnt_cus';
        $recptNo = noteNo('cus', $br_id);
        $invAmnt = $payAmnt - $receivAmnt;

        $sql_custTb = $mysqli->query("SELECT ID FROM custtable WHERE CustomerID = '$hiddnID' AND br_id = '$br_id'");
        $cusTbID = $sql_custTb->fetch_assoc();
        //die; 
        $invAmnt = $invAmnt * $currencyValue;
        $sql_invoice = $mysqli->query("INSERT INTO invoice (Balance, cusTbID, CusID, Date, InvNO, InvTot, RcvdAmnt, RepID, ShowType, cloud, NowTime, Time, 
									RepComm, OperatorID, br_id, dscrpn_note, Stype) VALUES ('$invAmnt', '$cusTbID[ID]', '$hiddnID', '$entyDate', '$recptNo',
									'$invAmnt' , '0', '', '', 'NEW', '$time', '$time', '0', '$user_id', '$br_id', '$descrptn', 'NOTE')");

        if ($sql_invoice) {
            $sql_statmnt = $mysqli->query("INSERT INTO cusstatement (cusID, cusTbID, Date, InvAmnt, InvNo, Name, NowTime, Paid, ShowType, Pass, FromDue, RepID, 
								    mysql_db, user_id, cloud, br_id, currency_tb, currencyValue) VALUES ( '$hiddnID', '$cusTbID[ID]', '$entyDate', '$invAmnt', '$recptNo' , '$srchNam', 
									'$time', '0', '', 'Sent', '', 'CTrans', 'WEB', '$user_id', 'New','$br_id', '$currencyID','$currencyValue') ");

            if ($receivAmnt != 0) {
                $qry = "INSERT INTO `jentry`(`AccID`, `AccName`, `AccType`, `Credit`, `Date`, `Debit`,
	 `Description`, `showTYPE`, `VNo`, `br_id`, `recodTime`,`recodDate`,`SerNo`,`userID`,`cloud`,InvoicedSMS,Location)
	 VALUES ('$jID','$jNm','$jType','$receivAmnt','$entyDate','0','Customer received payment ($srchNam)',
	 '$jShow','$v_no','$br_id','$time','$entyDate','$v_no','$user_id','payRecvCash','payRecvCash_customer','$recptNo')";
            }
            if ($payAmnt != 0) {

                $qry = "INSERT INTO `jentry`(`AccID`, `AccName`, `AccType`, `Credit`, `Date`, `Debit`,
	 `Description`, `showTYPE`, `VNo`, `br_id`, `recodTime`,`recodDate`,`SerNo`,`userID`,`cloud`,InvoicedSMS,Location)
	 VALUES ('$jID','$jNm','$jType','0','$entyDate','$payAmnt','Customer paid payment ($srchNam)',
	 '$jShow','$v_no','$br_id','$time','$entyDate','$v_no','$user_id','payRecvCash','payRecvCash_customer','$recptNo')";
            }

            if ($payBy == 'Journal') {
                echo 'journal ' . $payBy;
                $save_jentry = $mysqli->query($qry);
            }
        }
    } elseif ($payRecvType == 'Vendor') {
        $printPage = 'payRecvPrnt_ven()';
        $recptNo = noteNo('ven', $br_id);
        $purAmnt = $receivAmnt - $payAmnt;

        $sql_purchs = $mysqli->query("INSERT INTO purchase( Balance, Date, Paid, Total, VendorID, RefNo, P_No, user_id, cloud, ShowType, br_id, 
								   dscrpn_note, pType, recordDate, recordTime) VALUES ('$purAmnt', '$entyDate', '0', '$purAmnt', '$hiddnID', 
								   '$recptNo', '$recptNo', '$user_id', 'New', '', '$br_id', '$descrptn', 'None_note', '$date' , '$time')");

        if ($sql_purchs) {
            $sql_statmnt = $mysqli->query("INSERT INTO venstatement(Cname, Date, InvAmnt, Paid, showTYPE, VendID, P_No, user_id, cloud, RefNo, Pass, 
									br_id, FromDue, recordDate, recordTime, ByCheque) VALUES ('$srchNam', '$entyDate', '$purAmnt', '0', '',
									'$hiddnID', '$recptNo', '$user_id', 'New', '$recptNo', 'Sent', '$br_id', '', '$date' , '$time', 'CTrans')");

            if ($receivAmnt != 0) {
                $qry = "INSERT INTO `jentry`(`AccID`, `AccName`, `AccType`, `Credit`, `Date`, `Debit`,
	 `Description`, `showTYPE`, `VNo`, `br_id`, `recodTime`,`recodDate`,`SerNo`,`userID`,`cloud`,InvoicedSMS,Location)
	 VALUES ('$jID','$jNm','$jType','$receivAmnt','$entyDate','0','Vendor received payment ($srchNam)',
	 '$jShow','$v_no','$br_id','$time','$entyDate','$v_no','$user_id','payRecvCash','payRecvCash_vendor','$recptNo')";
            }
            if ($payAmnt != 0) {

                $qry = "INSERT INTO `jentry`(`AccID`, `AccName`, `AccType`, `Credit`, `Date`, `Debit`,
	 `Description`, `showTYPE`, `VNo`, `br_id`, `recodTime`,`recodDate`,`SerNo`,`userID`,`cloud`,InvoicedSMS,Location)
	 VALUES ('$jID','$jNm','$jType','0','$entyDate','$payAmnt','Vendor paid payment ($srchNam)',
	 '$jShow','$v_no','$br_id','$time','$entyDate','$v_no','$user_id','payRecvCash','payRecvCash_vendor','$recptNo')";
            }

            if ($payBy == 'Journal') {
                $save_jentry = $mysqli->query($qry);
            }
        }
    }

    if ($sql_statmnt) {
        $_SESSION['succsess_msg'] = $payRecvType . '&nbsp; ' . $srchNam . '&nbsp; ' . $process . ' Process Done ! ';
        $_SESSION['payRecvRecptNo'] = $recptNo;
        $_SESSION['print_functn'] = $printPage;
        redirect('due_payRecvCash.php');
        die();
    } else {
        $_SESSION['error_msg'] = 'Error in ' . $payRecvType . '&nbsp; ' . $srchNam . '&nbsp; ' . $process . ' Payment Process !';
        redirect('due_payRecvCash.php');
        die();
    }
}


function noteNo($noteType, $thisBr_id)
{
    global $mysqli;

    if ($noteType == 'cus') {
        //=========================== create new Invoice no for note ======================//
        $sql_maxRecp = $mysqli->query("SELECT MAX(ID), InvNO FROM invoice WHERE br_id='$thisBr_id' AND InvNO LIKE 'NOTE%' 
									GROUP BY InvNO ORDER BY ID DESC LIMIT 1");
        $res_maxRecp = $sql_maxRecp->fetch_array();
        $maxRecp = $res_maxRecp[1];
        $maxRecp = explode('-', $maxRecp);
        $noteNo = $maxRecp[1] + 1;
        $noteNo = 'NOTE-' . $noteNo;
    } elseif ($noteType == 'ven') {
        //=========================== create new Purchase no for note ======================//
        $sql_maxRecp = $mysqli->query("SELECT MAX(ID), P_No FROM purchase WHERE br_id='$thisBr_id' AND P_No LIKE 'NOTE%' 
									GROUP BY P_No ORDER BY ID DESC LIMIT 1");
        $res_maxRecp = $sql_maxRecp->fetch_array();
        $maxRecp = $res_maxRecp[1];
        $maxRecp = explode('-', $maxRecp);
        $noteNo = $maxRecp[1] + 1;
        $noteNo = 'NOTE-' . $noteNo;
    }

    return $noteNo;
}


?>




<style>
    input[type='text'],
    input[type='number'],
    select {
        padding: 2px 2px 2px 5px;
        height: 20px;
    }



    #ajax_img_lod,
    #ajax_img_lod_chq {
        display: none;
    }



    #chqMsgContent {
        text-align: center;
        font-size: 12;
        font-weight: bold
    }


    /***************   STYLE FOR AUTOCOMPLETE DROPDOWN ***********/
    .ui-autocomplete {
        width: 700px;
        max-height: 150px;
        min-width: 170px;
        background: #CCC;
        overflow-y: auto;
        overflow-x: hidden;
    }


    .ui-autocomplete::-webkit-scrollbar {
        width: 12px;
    }

    .ui-autocomplete::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .ui-autocomplete::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
    }

    /*************** END OF  STYLE FOR AUTOCOMPLETE DROPDOWN ***********/

    .lblStyle {
        display: block;
        width: 100%;
        height: 20px;
        padding: 1px 3px;
        font-size: 12px;
        line-height: 1.42857143;
        color: #555555;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s
    }
</style>




</head>

<body class="nav-sm">
    <div class="container body">
        <div class="main_container">
            <?php
            include($path . 'side.php');
            include($path . 'mainBar.php');
            ?>

            <form action="due_payRecvCash.php" method="post" id="paymntForm">
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3><?php echo $title; ?></h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">

                                    <div class="x_title">
                                        <h2><i class="fa fa-align-left"></i> Pay Receive Cash <small></small></h2>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="box-content">

                                            <table class="table table-bordered table-striped table-condensed searchDisplTB">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="5">
                                                            <input type="radio" name="payRecvType" id="" class="payRecvType" value="Customer" checked="checked" />
                                                            <label class="drLbl"> Customer </label> &nbsp;&nbsp;
                                                            <input type="radio" name="payRecvType" id="" class="payRecvType" value="Vendor" />
                                                            <label class="drLbl"> Vendor </label> &nbsp;&nbsp;
                                                            Payment By &nbsp;&nbsp;
                                                            <select id="com_pay" name="com_pay" style="height: 30px; width: 100px; border-radius: 8px;">
                                                                <option value="Cash"> Cash </option>
                                                                <option value="Journal"> Journal </option>
                                                            </select>
                                                            &nbsp;&nbsp;
                                                            <select id="com_jou" name="com_jou" style="display:none; height: 30px; width: 200px; border-radius: 8px;">
                                                                <option value=""> Select a Journal </option>
                                                                <?php

                                                                $qry_jou = $mysqli->query("SELECT `ID`, `AccID`, `AccType`, `Description`, `AccountMode`,ShowType FROM `journal` WHERE `br_id`='$br_id' ");
                                                                while ($jou = $qry_jou->fetch_array()) {
                                                                    $jval = $jou['ID'] . '|F|' . $jou['AccID'] . '|F|' . $jou['Description'] . '|F|' . $jou['AccountMode'] . '|F|' . $jou['ShowType'];
                                                                    echo '<option value="' . $jval . '"> ' . $jou['Description'] . ' </option>';
                                                                }

                                                                ?>

                                                            </select>




                                                            <input type="hidden" id="cuDetilResponse" style="width:650px" />
                                                            <input type="hidden" id="getCusNoteNo" value="<?php echo noteNo('cus', $br_id) ?>" />
                                                            <input type="hidden" id="getVenNoteNo" value="<?php echo noteNo('ven', $br_id) ?>" />

                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr style="background:rgb(112, 178, 157)">
                                                        <td>
                                                            <div align="right" id="detail1">Name </div>
                                                        </td>
                                                        <td style="max-width:95px;min-width:80px">
                                                            <input type="text" class="serchTxt" name="serchTxt" id="srch_Customer" autocomplete="off" autofocus="autofocus" />
                                                            <input type="hidden" name="hiddnID" id="hiddnID" />
                                                            <img src="img/ajax-loaders/ajax-loader-3.gif" id="ajax_img_lod" />
                                                        </td>
                                                        <td>
                                                            <div align="right" id="detail2">Customer ID </div>
                                                        </td>
                                                        <td style="max-width:95px;min-width:80px"><label id="detailLbl2"></label></td>
                                                        <td align="right">
                                                            <div align="right" id="detail3">Address </div>
                                                        </td>
                                                        <td style="max-width:185px;min-width:150px"><label id="detailLbl3"></label></td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                            <div style="text-align: right;margin-bottom: 15px;">

                                            </div>

                                            <table class="table table-bordered table-striped table-condensed chqTbl">
                                                <thead>
                                                    <tr class="thClas">
                                                        <th style="width:105px">Date</th>
                                                        <th style="width:105px">Receipt No</th>
                                                        <th style="width:105px">Currency</th>
                                                        <th style="width:105px">Receive</th>
                                                        <th style="width:105px">Pay </th>
                                                        <th style="width:40%">Description </th>
                                                        <th> </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr class="thClas">
                                                        <td>
                                                            <div align="right">
                                                                <div class="controls" style="padding-top:0px;margin-left:-15px">
                                                                    <div align="left" class="col-sm-10 input-append date cashDate" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                                                                        <input size="16" type="text" name="entyDate" id="autoFocusDate" value="<?php echo date('Y-m-d') ?>" required readonly class="date_change_warning form-control" style="width:100px;height:20px;display:inline">
                                                                        <span class="add-on" style=""><i class="icon-th"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="reciptNo" id="reciptNo" readonly="readonly" style="width:105px;text-transform: uppercase;" class="readonly" value="<?php echo noteNo('cus', $br_id) ?>" />
                                                        </td>
                                                        <td>
                                                            <select name="currency" id="currency" style="width:100px">
                                                                <?php
                                                                $sql_currencyDet = $mysqli->query("SELECT `ID`,`currencyName`, `currencyValue` FROM `currency_list`");

                                                                while ($currencyDet = $sql_currencyDet->fetch_assoc()) {
                                                                    echo '<option value="' . $currencyDet['ID'] . ' ' . $currencyDet['currencyValue'] . '" >' . $currencyDet['currencyName'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="receivAmnt" id="receivAmnt" class="required amntBox" ondrop="return false;" onpaste="return false;" onkeypress="return IsNumeric(event);" style="width:105px;height:20px;text-align:right;" data-value="recivTxt" />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="payAmnt" id="payAmnt" class="required amntBox" ondrop="return false;" onpaste="return false;" onkeypress="return IsNumeric(event);" style="width:105px;height:20px;text-align:right" data-value="payTxt" />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="descrptn" id="descrptn" style="width: 100%;" value="" class="required" />
                                                        </td>
                                                        <td>
                                                            <input type="button" class="btn btn-success btn-xs saveChqBtn" name="Save" value="Save" />
                                                            <input type="button" class="btn btn-success btn-xs search" value="Search" id="search">
                                                            <input type="button" class="btn btn-success btn-xs vsearch" value="Search" id="vsearch" style="display:none;">
                                                            <!--<input type="submit" class="btn btn-success btn-xs" name="Save" value="Save" />-->
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>




                                            <!-- Start of Description for Customer  -->
                                            <table class="table table-bordered table-striped table-condensed" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th> </th>
                                                        <th class="" colspan="2">
                                                            <div align="center"> Customer </div>
                                                        </th>
                                                        <th class="" colspan="2">
                                                            <div align="center"> Vendor </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th> </th>
                                                        <th class=""> Balance </th>
                                                        <th class="payLbl"> Cash in hand </th>
                                                        <th class=""> Balance </th>
                                                        <th class="payLbl"> Cash in hand </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Receive Cash</td>
                                                        <td class="Customer_recivTxt procesCls_row1">decreases &nbsp; [
                                                            - ]</td>
                                                        <td class="Customer_recivTxt procesCls_row1">increases &nbsp; [
                                                            + ]</td>
                                                        <td class="Vendor_recivTxt procesCls_row1">increases &nbsp; [ +
                                                            ]</td>
                                                        <td class="Vendor_recivTxt procesCls_row1">increases &nbsp; [ +
                                                            ]</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Pay Cash</td>
                                                        <td class="Customer_payTxt procesCls_row2">increases &nbsp; [ +
                                                            ]</td>
                                                        <td class="Customer_payTxt procesCls_row2">decreases &nbsp; [ +
                                                            ]</td>
                                                        <td class="Vendor_payTxt procesCls_row2">decreases &nbsp; [ - ]
                                                        </td>
                                                        <td class="Vendor_payTxt procesCls_row2">decreases &nbsp; [ - ]
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- End of Description for Customer  -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Start of warning -->
                <div id="creatCusMsg" style="display:none;">
                    <div class="errConfrmHaed"> Warning ! </div>
                    <span style="color:#F00" id="responseSpan"> </span>
                    <br />

                    <button type="button" class="btn btn-default blockUIClosBtn" style="" />Ok</button>
                </div>
                <!--end of warning -->

            </form>
            <!-- /page content -->
            <!-- content ends -->







            <!-- Start Modal of warning -->
            <div class="modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3 style="margin:0">
                                <div id="ermsgHead"> </div>
                            </h3>
                        </div>
                        <div class="modal-body">
                            <div id="chqMsgContent"> </div>
                        </div>
                        <div class="modal-footer footerFrBtn"> </div>
                    </div>
                </div>
            </div>
            <!--end of Modal of uwarning -->
            <div class="modal fade" id="payRecieve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">

                <div class="modal-dialog modal-dialog" style="width:80%; padding-left:50px;">
                    <div class="modal-content modalSeachDialog">
                        <div class="modal-header" style="background: #5CB85C;border-top-left-radius: 4px;border-top-right-radius: 
                                        4px;border-bottom: 2px solid #4D7579;">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3 style="margin:15px 0px 0px 0px;color:rgba(46, 27, 71, 0.72);"> Pay Recieved Cash </h3>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="form-gorup col-md-3">From <br><input type="date" name="fromDate" id="fromDate" value="<?php echo date('Y-m-d'); ?>""></div>
                                <div class=" form-gorup col-md-3">To <br><input type=" date" id="toDate" name="toDate" value="<?php echo date('Y-m-d'); ?>"></div>
                                <div class="form-gorup col-md-1" style="text-align;left;">&nbsp; <br><button class="btn btn-primary loadBtn">Load</button></div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:20%;">Date</th>
                                        <th style="width:10%;">Inv. No</th>
                                        <th style="text-align:center;">Customer Name</th>
                                        <th style="text-align:right;">Amount</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="payDateRange"></tbody>
                            </table>
                            <div id="InvSumryResult2">
                                <!--Invoice Footer Start-->








                                <!-- credit limit message farsan############################################################
                                            ####################################################### -------------------------------------------------------->
                                <div class="modal fade modalcredit" id="modalcredit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">

                                    <div class="modal-dialog">
                                        <div class="modal-content modalSeachDialog">

                                            <div class="modal-footer">
                                                <button class="btn btn-danger btn-xs" type="button" style="width:50px;" data-dismiss="modal">Close</button>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="cancelOrder" style="display:none;">
                                    <div class="errConfrmHaed"> Warning ! </div>
                                    <span style="color:#F00" id="responseSpan"> </span>
                                    <br />
                                    <button type="button" class="btn btn-default blckUIbtn " id="okCancelBtn" style="">Ok</button>
                                    <button type="button" class="btn btn-default blockUIClosBtn" style="">Cancel</button>
                                </div>
                                <div id="cancelQuotation" style="display:none;">
                                    <div class="errConfrmHaed "> Warning ! </div>
                                    <span style="color:#F00" id="QuotationMsg"> </span>
                                    <br />
                                    <button type="button" class="btn btn-default blckUIbtn " id="QuatationDelete" style="">Ok</button>
                                    <button type="button" class="btn btn-default blockUIClosBtn" style="">Cancel</button>
                                </div>

                                <div id="question" style="display:none; cursor: default">
                                    <div class="errConfrmHaed"> Last Price </div>
                                    <br />
                                    <div id="lastPricDetil"> </div>
                                    <button type="button" id="close" class="btn btn-default blockUIClosBtn" style="">Ok</button>
                                </div>

                                <!--Invoice Footer End-->
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-xs" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">

                <div class="modal-dialog modal-dialog" style="width:80%; padding-left:50px;">
                    <div class="modal-content modalSeachDialog">
                        <div class="modal-header" style="background: #5CB85C;border-top-left-radius: 4px;border-top-right-radius: 
                                        4px;border-bottom: 2px solid #4D7579;">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h3 style="margin:15px 0px 0px 0px;color:rgba(46, 27, 71, 0.72);"> Pay Recieved Cash </h3>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="form-gorup col-md-3">From <br> <input type="date" name="vfromDate" id="vfromDate" value="<?php echo date('Y-m-d'); ?>""></div>
                                <div class=" form-gorup col-md-3">To <br> <input type=" date" id="vtoDate" name="vtoDate" value="<?php echo date('Y-m-d'); ?>"></div>
                                <div class="form-gorup col-md-1" style="text-align;left;">&nbsp; <br><button class="btn btn-primary vloadBtn">Load</button></div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width:20%;">PO. No</th>
                                        <th style="width:10%;">Vendor</th>
                                        <th style="text-align:center;">Total</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="vpayDateRange"></tbody>
                            </table>
                            <div id="InvSumryResult2">
                                <!--Invoice Footer Start-->








                                <!-- credit limit message farsan############################################################
                                            ####################################################### -------------------------------------------------------->
                                <div class="modal fade modalcredit" id="modalcredit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">

                                    <div class="modal-dialog">
                                        <div class="modal-content modalSeachDialog">

                                            <div class="modal-footer">
                                                <button class="btn btn-danger btn-xs" type="button" style="width:50px;" data-dismiss="modal">Close</button>


                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="cancelOrder" style="display:none;">
                                    <div class="errConfrmHaed"> Warning ! </div>
                                    <span style="color:#F00" id="responseSpan"> </span>
                                    <br />
                                    <button type="button" class="btn btn-default blckUIbtn " id="okCancelBtn" style="">Ok</button>
                                    <button type="button" class="btn btn-default blockUIClosBtn" style="">Cancel</button>
                                </div>
                                <div id="cancelQuotation" style="display:none;">
                                    <div class="errConfrmHaed "> Warning ! </div>
                                    <span style="color:#F00" id="QuotationMsg"> </span>
                                    <br />
                                    <button type="button" class="btn btn-default blckUIbtn " id="QuatationDelete" style="">Ok</button>
                                    <button type="button" class="btn btn-default blockUIClosBtn" style="">Cancel</button>
                                </div>

                                <div id="question" style="display:none; cursor: default">
                                    <div class="errConfrmHaed"> Last Price </div>
                                    <br />
                                    <div id="lastPricDetil"> </div>
                                    <button type="button" id="close" class="btn btn-default blockUIClosBtn" style="">Ok</button>
                                </div>

                                <!--Invoice Footer End-->
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-xs" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php include($path . 'footer.php'); ?>

            <script>
                $(document).ready(function() {
                    // Attach click event handler to the radio buttons
                    $('.payRecvType').click(function() {
                        // Retrieve the value of the clicked radio button
                        var selectedValue = $(this).val();

                        // Display an alert with the selected value
                        if(selectedValue=='Vendor'){
                            $('.search').hide()
                            $('.vsearch').show()
                        }else{
                            $('.vsearch').hide() 
                            $('.search').show()
                        }
                    });
                });

                // My edits
                $(document).on('click', '.search', function() {
                    $('#payRecieve').modal('show');
                    load()

                });

                $(document).on('click', '.vsearch', function() {
                    $('#purchaseModal').modal('show');
                    load2()

                });
                function load(){
                        var fromDate = $('#fromDate').val()
                    var toDate = $('#toDate').val()
                    $.ajax({
                        type: "POST",
                        url: "ajx/loadPayRecieve.php",
                        data: {
                            'fromcode': fromDate,
                            'tocode': toDate,
                            'btn': 'searchBtn'
                        },
                        dataType: "json",
                        success: function(res) {
                            $('#payDateRange').html(res.htmlVal);
                        }
                    });
                    }

                $(document).on('click', '.loadBtn', function() {
                    load()

                });

                function load2(){
                    var fromDate = $('#vfromDate').val()
                    var toDate = $('#vtoDate').val()
                    $.ajax({
                        type: "POST",
                        url: "ajx/loadPayRecieve.php",
                        data: {
                            'vfromcode': fromDate,
                            'vtocode': toDate,
                            'btn': 'vsearchBtn'
                        },
                        dataType: "json",
                        success: function(res) {
                            $('#vpayDateRange').html(res.htmlVal);
                        }
                    });
                }

                $(document).on('click', '.vloadBtn', function() {
                    load2()
                });

                $(document).on('click', '#printBtn', function() {
                    var prntBtn = $(this).attr('prntBtn');
                    window.open("print/<?php echo $cusPrintNm; ?>.php?PAY_PRINT=" + prntBtn, "_BLANK");
                });
                
                $(document).on('click', '#vprintBtn', function() {
                    var prntBtn = $(this).attr('vprntBtn');
                    window.open("print/<?php echo $venPrintNm; ?>.php?PAY_PRINT=" + prntBtn, "_BLANK");
                });
                
                $(document).on('click', '#deleteBtn', function() {
                    var deleteVal = $(this).attr('deleteBtn');

                    if (confirm('Are you sure you wanted to delete invoice? Data cannot be restored.')) {


                        $.ajax({
                            type: "POST",
                            url: "ajx/loadPayRecieve.php",
                            data: {
                                'btn': 'deleteBtn',
                                'deletecode': deleteVal
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.status == 200) {
                                    location.reload()
                                }
                            }
                        });
                    }


                });

                $(document).on('click', '#vdeleteBtn', function() {
                    var deleteVal = $(this).attr('vdeleteBtn');
                    if (confirm('Are you sure you wanted to delete this purchase? Data cannot be restored.')) {


                        $.ajax({
                            type: "POST",
                            url: "ajx/loadPayRecieve.php",
                            data: {
                                'btn': 'vdeleteBtn',
                                'vdeletecode': deleteVal
                            },
                            dataType: "json",
                            success: function(res) {
                                if (res.status == 200) {
                                    location.reload()
                                }
                            }
                        });
                    }


                });

                $(document).on('change', '#com_pay', function() {

                    var val = $('#com_pay').val();
                    //alert(val);
                    if (val == 'Journal') {
                        $('.payLbl').html('Journal');
                        $('#com_jou').show();
                    } else {
                        $('.payLbl').html('Cash in hand ');
                        $('#com_jou').hide();
                    }

                });

                $('body').on('keypress', 'input', function(evt) {

                    if (evt.keyCode == 13) {

                        if ($(this).hasClass("yes")) {
                            /* break the keypress function on enter &  allow to run the click event of this property[Button] */
                        } else if (
                            $(this).hasClass("no")) {
                            /* break the keypress function on enter &  allow to run the click event of this property[Button] */
                        } else if (
                            $(this).hasClass("ok")) {
                            /* break the keypress function on enter &  allow to run the click event of this property[Button] */
                        } else {
                            var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
                            var index = fields.index(this);
                            if (index > -1 && (index + 1) < fields.length) {

                                var isHiddn = true;
                                i = 1;
                                while (isHiddn == true) {

                                    inputTyp = fields.eq(index + i).attr('type');
                                    isReadonly = fields.eq(index + i).hasClass('readonly');

                                    if (inputTyp != 'hidden' && isReadonly == false) {
                                        fields.eq(index + i).focus();
                                        isHiddn = false;
                                    }
                                    i++;

                                }

                            }
                        }
                    }
                });

                $.widget('custom.mcautocomplete', $.ui.autocomplete, {
                    _create: function() {
                        this._super();
                        this.widget().menu("option", "items", "> :not(.ui-widget-header)");
                    },
                    _renderMenu: function(ul, items) {
                        var self = this,
                            thead;
                        if (this.options.showHeader) {
                            table = $('<div class="ui-widget-header" style="width:100%"></div>');
                            $.each(this.options.columns, function(index, item) {
                                table.append('<span style="padding:0 4px;float:left;width:' + item
                                    .width + ';">' + item.name + '</span>');
                            });
                            table.append('<div style="clear: both;"></div>');
                            ul.append(table);
                        }
                        $.each(items, function(index, item) {
                            self._renderItem(ul, item);
                        });
                    },
                    _renderItem: function(ul, item) {
                        var t = '',
                            result = '';
                        $.each(this.options.columns, function(index, column) {
                            t += '<span style="padding:0 4px;float:left;width:' + column.width + ';">' +
                                item[column.valueField ? column.valueField : index] + '</span>'
                        });
                        result = $('<li></li>')
                            .data('ui-autocomplete-item', item)
                            .append('<a class="mcacAnchor">' + t + '<div style="clear: both;"></div></a>')
                            .appendTo(ul);
                        return result;
                    }
                });

                $(document).on('keyup', '#srch_Customer', function() {
                    payRecvType = $('.payRecvType:checked').val();

                    var cusNam = $(this).val();
                    if ((event.which != 13)) {
                        removeSelctedDetils();
                    }

                    if (cusNam.length > 0) {
                        if (event.which == 13) {
                            $('#ajax_img_lod').hide();

                        } else {
                            $('.serchDetTB').fadeOut();
                            if (cusNam.length > 1) {
                                $('#ajax_img_lod').show();
                            }

                            $(this).mcautocomplete({
                                showHeader: true,
                                columns: [{
                                    name: 'Name',
                                    width: '200px',
                                    valueField: 'Name'
                                }, {
                                    name: 'Address',
                                    width: '450px',
                                    valueField: 'add'
                                }],
                                minLength: 0,
                                autoFocus: true,
                                source: function(request, response) {
                                    $.ajax({
                                        url: 'ajx/bill_cusDetil.php',
                                        dataType: "json",
                                        method: 'post',
                                        data: {
                                            Name: cusNam
                                        },
                                        success: function(data) {
                                            $('#ajax_img_lod').hide();
                                            if (data[0] == 'Login Please') {
                                                alert(
                                                    'Your Session is expired, Please Login!'
                                                );
                                                window.location = '../login.php';
                                                return false;
                                            }
                                            response($.map(data, function(item) {
                                                return {
                                                    Name: item.Name,
                                                    add: item.Add,
                                                    OtherDetils: item
                                                        .OtherDetils
                                                }
                                            }));
                                        }
                                    });
                                },
                                select: function(event, ui) {
                                    this.value = (ui.item ? ui.item.Name : '');
                                    OtherDetils = $.trim(ui.item.OtherDetils);
                                    $('#cuDetilResponse').val(OtherDetils + '|' + ui.item.Name + '|' +
                                        ui.item.add);
                                    OtherDetils = OtherDetils.split('|');

                                    if (ui.item.Name == 'No records found') {
                                        alert('Please select a valid  customer ');
                                        $(this).val('');
                                    } else {

                                        $('#detailLbl2').text($.trim(OtherDetils[0]));
                                        $('#detailLbl3').text(ui.item.add);
                                        $('#hiddnID').val($.trim(OtherDetils[0]));
                                        //displyCusDet(); 

                                    }

                                    return false;
                                }

                            });
                        }
                    } else {
                        //$('.ui-autocomplete').hide();	
                    }
                });



                function removeSelctedDetils() {
                    $('#detailLbl2').text('');
                    $('#detailLbl3').text('');
                    $('#hiddnID').val('');
                }



                $(document).on('keyup', '#srch_Vendor', function() {
                    payRecvType = $('.payRecvType:checked').val();

                    var vendNam = $(this).val();
                    if ((event.which != 13)) {

                    }

                    if (vendNam.length > 0) {
                        if (event.which == 13) {
                            $('#ajax_img_lod').hide();

                        } else {
                            $('.serchDetTB').fadeOut();
                            if (vendNam.length > 0) {
                                $('#ajax_img_lod').show();
                            }

                            $(this).mcautocomplete({
                                showHeader: true,
                                columns: [{
                                    name: 'Name',
                                    width: '200px',
                                    valueField: 'Name'
                                }, {
                                    name: 'Address',
                                    width: '450px',
                                    valueField: 'add'
                                }],
                                minLength: 0,
                                autoFocus: true,
                                source: function(request, response) {
                                    $.ajax({
                                        url: 'ajx/vendrSerch.php',
                                        dataType: "json",
                                        method: 'post',
                                        data: {
                                            Name: vendNam
                                        },
                                        success: function(data) {
                                            $('#ajax_img_lod').hide();
                                            if (data[0] == 'Login Please') {
                                                alert(
                                                    'Your Session is expired, Please Login!'
                                                );
                                                window.location = '../login.php';
                                                return false;
                                            }
                                            response($.map(data, function(item) {
                                                return {
                                                    Name: item.Name,
                                                    add: item.Add,
                                                    OtherDetils: item
                                                        .OtherDetils
                                                }
                                            }));
                                        }
                                    });
                                },
                                select: function(event, ui) {
                                    this.value = (ui.item ? ui.item.Name : '');
                                    OtherDetils = $.trim(ui.item.OtherDetils);
                                    $('#cuDetilResponse').val(OtherDetils + '|' + ui.item.Name + '|' +
                                        ui.item.add);
                                    OtherDetils = OtherDetils.split('|');

                                    if (ui.item.Name == 'No records found') {
                                        alert('Please select a valid  Vendor ');
                                        $(this).val('');
                                    } else {
                                        $('#detailLbl2').text($.trim(OtherDetils[0]));
                                        $('#detailLbl3').text(ui.item.add);
                                        $('#hiddnID').val($.trim(OtherDetils[2]));
                                    }

                                    return false;
                                }

                            });
                        }
                    } else {

                        //$('.ui-autocomplete').hide();	
                    }
                });





                $(document).on('click', '.saveChqBtn', function(e) {
                    submitWithChq();
                });

                $(document).on('keyup', '.amntBox', function(e) {

                    if (e.keyCode != 13 && e.keyCode != 9) {

                        $('.procesCls_row1').css({
                            'background': '#FFF',
                            'color': '#000'
                        });
                        $('.procesCls_row2').css({
                            'background': '#f9f9f9',
                            'color': '#000'
                        });

                        payRecvType = $.trim($('.payRecvType:checked').val());
                        dataVal = $(this).data("value");
                        procesTyp = payRecvType + '_' + dataVal;

                        $('.' + procesTyp).css({
                            'background': '#FF002F',
                            'color': '#FFF'
                        });
                    }
                });

                $(document).on('keyup', '#receivAmnt', function(e) {
                    if (e.keyCode != 13 && e.keyCode != 9) {
                        $('#payAmnt').val('');
                    }
                });

                $(document).on('keyup', '#payAmnt', function(e) {
                    if (e.keyCode != 13 && e.keyCode != 9) {
                        $('#receivAmnt').val('');
                    }

                });


                function submitWithChq() {

                    payRecvType = $('.payRecvType:checked').val();
                    var payBy = $('#com_pay').val();
                    var jou = $('#com_jou').val();

                    if ($.trim($('#hiddnID').val()) !== '') {

                        valCount = 0;
                        $('.amntBox').each(function(index, element) {
                            if ($.trim(this.value) !== '') {
                                valCount++;
                            }
                        });

                        if (valCount == 0) {

                            $('#ermsgHead').html('Warning!');
                            $('#chqMsgContent').html('Please enter a valid amount in Receive/Pay ');
                            $('#myModal').modal('show');
                            $('.modal-dialog').css('width', '350');
                            var btnsForModl =
                                '<input type="button" class="btn btn-success btn-xs ok" id="chqEx" value="Ok" data-dismiss="modal" ';
                            btnsForModl += 'data-value="receivAmnt" />';
                            $('.footerFrBtn').html(btnsForModl);
                            $('#chqEx').focus();

                        } else {

                            if ($.trim($('#descrptn').val()) !== '') {
                                //alert(jou);
                                if (payBy == 'Journal' && jou == '') {
                                    alert('Please select a journal!..');
                                } else {

                                    $('#ermsgHead').html('Conformation!');
                                    $('#chqMsgContent').html('Save data?');
                                    $('#myModal').modal('show');
                                    $('.modal-dialog').css('width', '350');
                                    var btnsForModl =
                                        '<input type="button" class="btn btn-success btn-xs ok" id="chqEx" value="Ok" data-dismiss="modal" ';
                                    btnsForModl += 'data-value="save" />';
                                    btnsForModl +=
                                        '<input type="button" class="btn btn-success btn-xs" value="Cancel" data-dismiss="modal" />';
                                    $('.footerFrBtn').html(btnsForModl);
                                    $('#chqEx').focus();
                                }

                            } else {
                                $('#descrptn').focus();
                            }
                        }

                    } else {

                        $('#ermsgHead').html('Warning!');
                        $('#chqMsgContent').html('Please select a valid ' + payRecvType);
                        $('#myModal').modal('show');
                        $('.modal-dialog').css('width', '350');
                        var btnsForModl =
                            '<input type="button" class="btn btn-success btn-xs ok" id="chqEx" value="Ok" data-dismiss="modal" ';
                        btnsForModl += 'data-value="serchTxt" />';
                        $('.footerFrBtn').html(btnsForModl);
                        $('#chqEx').focus();

                    }

                }


                $(document).on('change', '.payRecvType', function() {
                    $('.required').val('');
                    $('.procesCls_row1').css({
                        'background': '#FFF',
                        'color': '#000'
                    });
                    $('.procesCls_row2').css({
                        'background': '#f9f9f9',
                        'color': '#000'
                    });

                    $('.searchDisplTB').hide();
                    payRecvType = $.trim($('.payRecvType:checked').val());
                    $('.serchTxt').attr('id', 'srch_' + payRecvType);
                    //alert(payRecvType);
                    if (payRecvType === 'Customer') {
                        detail1 = 'Name';
                        detail2 = 'Customer ID';
                        detail3 = 'Address';
                        recpt = $('#getCusNoteNo').val();
                        $('.searchDisplTB tr').css('background', 'rgb(112, 178, 157)');
                    } else if (payRecvType === 'Vendor') {
                        detail1 = 'Name';
                        detail2 = 'Vendor ID';
                        detail3 = 'Address';
                        recpt = $('#getVenNoteNo').val();
                        $('.searchDisplTB tr').css('background', 'rgb(199, 148, 181)');
                    }

                    $('.serchTxt').val('');
                    $('#hiddnID').val('');
                    $('#detailLbl2').text('');
                    $('#detailLbl3').text('');
                    $('#reciptNo').val(recpt);


                    $('#detail1').text(detail1);
                    $('#detail2').text(detail2);
                    $('#detail3').text(detail3);
                    $('.searchDisplTB').fadeIn();

                    $('.serchTxt').focus();

                });


                $(document).on('click', '.ok', function(e) {
                    var btnOn = $(this).data('value');
                    $.unblockUI();

                    if (btnOn == 'serchTxt') {
                        $('.serchTxt').focus();
                    } else if (btnOn == 'save') {
                        save();
                    } else {
                        $('#' + $.trim(btnOn)).focus();
                    }
                    return false;
                });

                function save() {
                    $.blockUI({
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .5,
                            color: '#fff',
                            'z-index': '9999999'
                        }
                    });
                    $('#paymntForm').submit();
                }
            </script>

            <script type="text/javascript">
                $('.cashDate').datetimepicker({
                    language: 'fr',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    minView: 2,
                    forceParse: 0,
                    format: "yyyy-mm-dd",
                    viewMode: "months",
                    minViewMode: "months"
                });

                
            </script>