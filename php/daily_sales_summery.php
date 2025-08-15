<?php
$title = 'Daily Sales Summery';
include('includeFile.php');

//include ('userAuthntictionReport.php');
//unset ($_SESSION['ReportPath']);
//include ('../side.php');


$from_d	= $_GET['from_d'];
$to_d = $_GET['to_d'];
$cus_id = $_GET['cus_id'];
$cus_area2 = $_GET['cus_area'];


if ($_GET['print_type'] != 'undefined') {
	$print_type = $_GET['print_type'];
} else {
	$print_type = "sal_rep";
}

$report_sale = '';

/*if( $_GET['view_type'] != 'undefined'){
$view_type= $_GET['view_type']; 	
}
else
{ $view_type= 'View All';
	}*/
//echo 'type '.$view_type;

if ($_GET['sales_id'] != 'undefined') {
	$sales_id = $_GET['sales_id'];
} else {
	$sales_id = 'View All';
}

$_SESSION['f_day'] = $from_d;
$_SESSION['t_day'] = $to_d;
$_SESSION['sl_id'] = $sales_id;
$_SESSION['cus_id'] = $cus_id;
$_SESSION['print_type'] = $print_type;
$_SESSION['cus_area'] = $cus_area2;


$reportPrnt = 'salesReport';
$report_cus_area = '';

//echo $cus_id;
//die;

//$today=$_SESSION['today'];

$from_d	= ($from_d != '') ? $from_d : date('Y-m-d');
$to_d	= ($to_d != '') ? $to_d : date('Y-m-d');
//$sales_id	= ($sales_id != '')? $sales_id : 'View All';		

$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');

//echo $from_d.''.$to_d.''.$sales_id;	 
$from_ddd = $from_dd;
$to_ddd = $to_dd;
//echo $from_ddd.' | '.$to_ddd.' | '.$sales_id;


$view_type = $_SESSION['showhide_type'];
//echo 'ddf' .$view_type;

$report_sale_print = 'report_salesman_print';

$showType = "";


if ($user_type != "Admin") {

	switch ($view_type) {
		case 'Show':
			$shwSelct = 'selected';
			$showType = "AND ShowType ='SHOW'";
			$bar = "account_report_bar.php";

			break;

		case 'Hide':
			//echo 'hide12'; 
			$hidSelct = 'selected';
			//$showType= "AND ShowType ='HIDE'";
			$showType = "";
			$bar = "daily_report_bar.php";

			break;
			/*	
		case 'View All': echo 'View All ﻿ff';
		 	$viwSelct = 'selected';
			break;*/

		default:
			$shwSelct = 'selected';
			$showType = "AND ShowType ='SHOW'";
			$bar = "account_report_bar.php";
	}
} else {
	$hidSelct = 'selected';
	//$showType= "AND ShowType ='HIDE'";
	$showType = "";
	$bar = "daily_report_bar.php";
}

?>

<style>
	.floatSales {
		float: left;
		width: 21%;

	}

	input[type='text'],
	input[type='number'],
	select {
		//height: 28px;
		padding: 2px 2px 2px 5px;
	}

	q #list {
		list-style: none;
		font-family: 'PT Sans', Verdana, Arial, sans-serif;
		min-width: 150px;
		height: auto;
		color: #666;
		padding-top: 3px;
		padding-bottom: 3px;
		padding-left: 15px;
		border-bottom: 1px solid #cdcdcd;
		transition: background-color .3s ease-in-out;
		-moz-transition: background-color .3s ease-in-out;
		-webkit-transition: background-color .3s ease-in-out;
		text-transform: uppercase;

	}

	#list:hover {
		background: #7F7F7F;
		border: 1px solid rgba(0, 0, 0, 0.2);
		cursor: pointer;
		color: #fff;
	}

	#list:hover a {
		color: #fff;
		text-decoration: none;
	}

	.hilight {
		color: #333333;
		text-transform: uppercase;
		font-weight: bold;
	}

	.invoSumryTB tr:nth-child(even):hover td,
	tbody tr.odd:hover td {
		background: #DFD;
		cursor: pointer;
		color: #009999
	}

	.amountBox,
	.paymntBox {
		width: 80px;
		text-align: right;
	}
</style>


<?php include($bar); ?>
</br>
<div id="remove_TTb" class="findexcel" style="width: 80%; margin:0 auto;">

	
	<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive footerTotalTbl" style="width:100%; margin: 0;">
	    <thead>
	        <tr>
	            <th>CASH INVOICE AMOUNT</th>
	            <th>CREDIT ADVANCE AMOUNT</th>
	            <th>CASH RECEIPT</th>
	            <th>SALE RETURN</th>
	            <th>TOTAL AMOUNT</th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php

	        $from_ddd = date_format(date_create($from_d), 'Y-m-d');
	        $to_ddd = date_format(date_create($to_d), 'Y-m-d');
	        
			$sql_cash = $mysqli->query("
			    SELECT SUM(RcvdAmnt) as cashInvoice
			    FROM invoice
			    WHERE Date BETWEEN '$from_ddd' AND '$to_ddd'
			    AND br_id = '$br_id'
			    AND invType != 'RTN'
			    AND InvTot = RcvdAmnt
			");
			$cashInvoiceTotal = $sql_cash->fetch_array()['cashInvoice'];

			$sql_credit = $mysqli->query("
			    SELECT SUM(RcvdAmnt) as creditPaid
			    FROM invoice
			    WHERE Date BETWEEN '$from_ddd' AND '$to_ddd'
			    AND br_id = '$br_id'
			    AND invType != 'RTN'
			    AND InvTot != RcvdAmnt
			");
			$creditPaidTotal = $sql_credit->fetch_array()['creditPaid'];


	        $sql_sales_nwreport = $mysqli->query("
	            SELECT SUM(cus.Paid) as cusPaid
	            FROM cusstatement cus
	            WHERE FromDue = 'Due'
	            AND Date BETWEEN '$from_ddd' AND '$to_ddd'
	        ");

			$row_cashReceiptTotal = $sql_sales_nwreport->fetch_array();
	        $cashReceiptTotal = $row_cashReceiptTotal['cusPaid'];

	        $sql_sales_nwreport = $mysqli->query("
	            SELECT SUM(InvTot) as returnTotal
	            FROM invoice inv  
	            JOIN custtable ON inv.cusTbID = custtable.ID
	            WHERE inv.Date BETWEEN '$from_ddd' AND '$to_ddd'
	            AND inv.br_id = '$br_id' AND inv.invType = 'RTN'
	        ");
            $row_salesReturnTotal = $sql_sales_nwreport->fetch_array();
	        $salesReturnTotal = $row_salesReturnTotal['returnTotal'];
	        
	        
	        $grandTotal = $cashInvoiceTotal + $creditPaidTotal + $salesReturnTotal;
	        ?>
	    </tbody>
	   	<tfoot>
	        <tr>
	            <td style='text-align: right;'><?php echo number_format($cashInvoiceTotal, 2); ?></td>
	            <td style='text-align: right;'><?php echo number_format($creditPaidTotal, 2); ?></td>
	            <td style='text-align: right;'><?php echo number_format($cashReceiptTotal, 2); ?></td>
	            <td style='text-align: right;'><?php echo number_format($salesReturnTotal, 2); ?></td>
	            <td style='text-align: right; font-weight: bold;'><?php echo number_format($grandTotal, 2); ?></td>
	            
	        </tr>
	    </tfoot>

	</table>


	
	<h2>CASH INVOICE INFORMATION </h2>
	<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive footerTotalTbl" style="width:100%; margin: 0;">
	    <thead>
	        <tr>
	            <th>Invoice NO</th>
	            <th>Date</th>
	            <th>Amount</th>
	        </tr>
	    </thead>
	    <tbody>
	    	
	        <?php

	        $cashInvoiceTotal = 0;
	        $sql_sales_nwreport = $mysqli->query("
	            SELECT InvNO, inv.Date, inv.InvTot, inv.RcvdAmnt
	            FROM invoice inv  
	            JOIN custtable ON inv.cusTbID = custtable.ID
	            WHERE inv.Date BETWEEN '$from_ddd' AND '$to_ddd'
	            AND inv.br_id = '$br_id' AND inv.invType != 'RTN'
	            AND RcvdAmnt != 0
	            ORDER BY inv.Date ASC, inv.ID ASC
	        ");
	        $totalAmount = 0;
	        while ($res_sales_nw = $sql_sales_nwreport->fetch_array()) {
	            $s_d = date_format(date_create($res_sales_nw['Date']), 'Y-m-d');
	            
	            $cashInvoiceTotal += $res_sales_nw['RcvdAmnt'];

	            echo "<tr>
	                <td><a style='color:blue; cursor:pointer;' class='click_invDetail' value='" . htmlspecialchars($res_sales_nw['InvNO']) . "'>" . htmlspecialchars($res_sales_nw['InvNO']) . "</a> </td>
	                <td>" . htmlspecialchars($s_d) . "</td>
	                <td style='text-align: right;'>" . htmlspecialchars(number_format($res_sales_nw['RcvdAmnt'], 2)) . "</td>
	                
	            </tr>";
	        }
	        ?>
	    </tbody>
	    <tfoot>
	        <tr>
	            <th colspan="2" style="text-align: right;">Total:</th>
	            <th style="text-align: right;"><?php echo number_format($cashInvoiceTotal, 2); ?></th>
	            
	        </tr>
	    </tfoot>
	</table>

	<h2>CREDIT INVOICE</h2>
	<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive footerTotalTbl" style="width:100%; margin: 0;">
	    <thead>
	        <tr>
	            <th>Invoice NO</th>
	            <th>Date</th>
	            <th>Amount</th>
	            <th>Paid Amount</th>
	            <th>Balance Amount</th>
	        </tr>
	    </thead>
	    <tbody>
	        <?php
	        $sql_sales_nwreport = $mysqli->query("
	            SELECT inv.InvNO, inv.Date, inv.InvTot, inv.Balance, SUM(inv.InvTot-RcvdAmnt) as creditInvoice
	            FROM invoice inv  
	            JOIN custtable ON inv.cusTbID = custtable.ID
	            WHERE inv.Date BETWEEN '$from_ddd' AND '$to_ddd'
	            AND inv.br_id = '$br_id' AND inv.invType != 'RTN'
	            GROUP BY inv.InvNO HAVING creditInvoice != 0
	            ORDER BY inv.Date ASC, inv.ID ASC
	        ");

			$creditPaidTotal = 0;
			while ($res_sales_nw = $sql_sales_nwreport->fetch_array()) {
			    $s_d = date_format(date_create($res_sales_nw['Date']), 'Y-m-d');

			    $paid = $res_sales_nw['InvTot'] - $res_sales_nw['creditInvoice'];
			    $creditPaidTotal += $paid;

			    echo "<tr>
			        <td><a style='color:blue; cursor:pointer;' class='click_invDetail' value='" . htmlspecialchars($res_sales_nw['InvNO']) . "'>" . htmlspecialchars($res_sales_nw['InvNO']) . "</a> </td>
			        <td>" . htmlspecialchars($s_d) . "</td>
			        <td>" . htmlspecialchars($res_sales_nw['InvTot']) . "</td>
			        <td>" . htmlspecialchars($paid) . "</td>
			        <td>" . htmlspecialchars($res_sales_nw['creditInvoice']) . "</td>
			    </tr>";
			}

	        ?>
	    </tbody>
	    <tfoot>
	        <tr>
	            <th colspan="3" style="text-align: right;">Total:</th>
	            <th style="text-align: right;"><?php echo number_format($creditPaidTotal, 2); ?></th>
	            
	        </tr>
	    </tfoot>
	</table>

	<h2>CASH RECEIPT INFORMATION</h2>
	<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive footerTotalTbl" style="width:100%; margin: 0;">
	    <thead>
	        <tr>
	            <th>Receipt NO</th>
	            <th>Date</th>
	            <th>Amount</th>
	        </tr>
	    </thead>
	    <tbody>
	        <?php
	        $sql_receive = $mysqli->query("
	            SELECT cus.ReceiptNo, cus.Date, cus.Paid
	            FROM cusstatement cus
	            WHERE FromDue = 'Due'
	            AND Date BETWEEN '$from_ddd' AND '$to_ddd'
	            ORDER BY Date ASC
	        ");

	        $totalAmount = 0;
	        while ($res = $sql_receive->fetch_array()) {
	            $s_d = date_format(date_create($res['Date']), 'Y-m-d');
	            $totalAmount += $res['Paid'];

	            echo "<tr>
	                <td>{$res['ReceiptNo']}</td>
	                <td>{$s_d}</td>
	                <td style='text-align: right;'>" . number_format($res['Paid'], 2) . "</td>
	            </tr>";
	        }
	        ?>
	    </tbody>
	    <tfoot>
	        <tr>
	            <th colspan="2" style="text-align: right;">Total:</th>
	            <th style="text-align: right;"><?php echo number_format($totalAmount, 2); ?></th> 
	        </tr>
	    </tfoot>
	</table>


	<h2>SALES RETUN INFORMATION</h2>
	<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive footerTotalTbl" style="width:100%; margin: 0;">
	    <thead>
	        <tr>
	            <th>Return NO</th>
	            <th>Date</th>
	            <th>Amount</th>
	        </tr>
	    </thead>
	    <tbody>
	        <?php
	        $sql_sales_nwreport = $mysqli->query("
	            SELECT inv.InvNO, inv.Date, inv.InvTot, inv.RcvdAmnt
	            FROM invoice inv  
	            JOIN custtable ON inv.cusTbID = custtable.ID
	            WHERE inv.Date BETWEEN '$from_ddd' AND '$to_ddd'
	            AND inv.br_id = '$br_id' AND inv.invType = 'RTN'
	            ORDER BY inv.Date ASC, inv.ID ASC
	        ");

	        
	        $salesReturnTotal = 0;
	        while ($res_sales_nw = $sql_sales_nwreport->fetch_array()) {
	            $s_d = date_format(date_create($res_sales_nw['Date']), 'Y-m-d');
	            
	            $salesReturnTotal += $res_sales_nw['InvTot'];


	            echo "<tr>
	                <td><a style='color:blue; cursor:pointer;' class='click_invDetail' value='" . htmlspecialchars($res_sales_nw['InvNO']) . "'>" . htmlspecialchars($res_sales_nw['InvNO']) . "</a> </td>
	                <td>" . htmlspecialchars($s_d) . "</td>
	                <td style='text-align: right;'>" . htmlspecialchars(number_format($res_sales_nw['InvTot'], 2)) . "</td>
	                
	            </tr>";
	        }
	        ?>
	    </tbody>
	    <tfoot>
	        <tr>
	            <th colspan="2" style="text-align: right;">Total:</th>
	            <th style="text-align: right;"><?php echo number_format($salesReturnTotal, 2); ?></th>
	            
	        </tr>
	    </tfoot>
	</table>
</div>

</div>
</div>
</div>

<!--/span-->


<!-- ajax content load -->
</div>






<!-- content ends -->
</div>


<?php include($path . 'footer.php'); ?>

<script type="text/javascript">

	$('.from_d').datetimepicker({
		language: 'fr',
		weekStart: 1,
		todayBtn: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});

	$('.to_d').datetimepicker({
		language: 'fr',
		weekStart: 1,
		todayBtn: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
	});
	$('#salesReport').click(function() {
		var invID = $('').val();

		//alert('' +invID);
		window.open("print/daily_sales_summery_print.php", "myWindowName", "width=595px, height=842px");

	});
</script>
<?php include('daily_script.php'); ?>