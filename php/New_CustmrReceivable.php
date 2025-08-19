<?php


$title = 'Customer Receivable';
include('includeFile.php');

//unset ($_SESSION['ReportPath']);
//include ('../side.php');

$serialReport = 'invLoad';
$from_d	= $_GET['from_d'];
$to_d = $_GET['to_d'];
$cus_id = $_GET['cus_id'];

if ($_GET['cus_name'] != 'undefined') {
	$cus_name = $_GET['cus_name'];
}
//$cus_id	= ($cus_id == '' || $cus_id != true)? $cus_id : 'View All';

//echo $_GET['due_frm'].' 000 '.$_GET['due_to'];

$due_frm = ($_GET['due_frm'] == '') ? 0 : $_GET['due_frm'];
$due_to = ($_GET['due_to'] == '') ? 0 : $_GET['due_to'];

$_SESSION['due_frm'] = $due_frm;
$_SESSION['due_to'] = $due_to;
$_SESSION['f_day'] = $from_d;
$_SESSION['t_day'] = $to_d;
//$_SESSION['cus_id']= $cus_id;



$reportPrnt = 'cusRcvble';
$report_cus = 'cus_age';
//$ItemSearch = 'ItemSearch';
$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');

/*$mysqluser= mysql_query("SELECT `ID`,`CustomerID` FROM `custtable` WHERE `ID`='$cus_id'");
$resltuser= mysql_fetch_array($mysqluser);
$cus_code=$resltuser[1];

if($cus_id == 'View All')
{ $cus_code=$cus_id;}*/
//echo 'dds '.$cus_code;

$_SESSION['cus_id'] = $cus_id;


?>


<style>
	#ags1 {
		float: left;
		width: 40%;

	}

	#ags2 {
		float: right;
		width: 40%;
		margin-right: 20%;
		//margin-top:-2.1111115898989789%;

	}

	#ags3 {
		float: left;
		width: 50%;

	}

	#ags4 {
		float: right;
		width: 40%;
		margin-right: 10%;
		//margin-top:-2.1111115898989789%;

	}

	#ags5 {
		float: right;
		width: 20%;
		margin-right: 20%;
		//margin-top:-2.1111115898989789%;

	}


	#ags6 {
		float: left;
		width: 100%;
		margin-right: ;
		//margin-top:-2.1111115898989789%;

	}

	.controls {
		width: 60%;

	}

	.control-group {
		padding-left: 3%;
		padding-right: 3%;
		padding-top: ;


	}

	.control-group input[type="text"],
	input[type="email"],
	select {
		width: 100%;
		height: 2.5%;
		background-color: rgba(255, 255, 204, 1);

	}

	.control-label {
		width: 10%;

	}

	.bilDetUl li {
		//background:#0066CC;
		list-style: none;
		float: left;
		margin-left: 10px;
		width: auto;
	}

	.ui-autocomplete {
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

	#ajax_img_lod,
	#ajax_img_lod_chq {
		display: none;
	}

	.bilDetLoad {
		display: none;
	}

	.bilDetCont {
		margin-left: -50px;

	}

	.bilDetCont input[type='text'],
	select {

		height: 28px;
		font-size: 12px;
		display: block;
		width: 100%;
		// height: 34px;
		padding: 6px 3px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
		-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;

	}

	.searhBtn {
		margin-top: 18px;
		padding: 3px 10px;
	}

	.norml {
		font-weight: normal;
	}




	.floatSales {
		float: left;
		width: 18%;

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







<!--
<div class=" row">        
<div class="box col-md-12" >
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><i class="glyphicon glyphicon-user"></i> Daily Report</h2>
    
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i
                        class="glyphicon glyphicon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
<div class="box-content" style="width:99%; padding-left:1.5%; padding-right::0.5%;">
<div class="row">-->


<?php include('New_report_bar.php'); ?>

</br>

<div id="ajaxRespon" style="width:95%; ">
	<div id="remove_TTb" class="findexcel" style="margin-left:34px;">

		<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive invoSumryTB"
			style="margin-top:30px" ;>
			<thead>
				<tr>
					<th width="8%">Date </th>
					<th>Customer Name</th>
					<th>Customer Address</th>
					<th width="10%">Invoice No</th>
					<th width="10%">Rep Name</th>
					<th width="10%">Rep Code</th>
					<th width="12%">Settlement</th>

					<th>Puchase No</th>
					<th>Note</th>
					<th width="10%">Invoice Total </th>
					<th width="10%">Paid</th>
					<th width="10%">Balance</th>
					<th width="10%">Age (days)</th>
				</tr>
			</thead>
			<tbody>


				<?php

				$paidTT = 0;
				$balTT = 0;
				$invTT = 0;


				if ($cus_id != 'View All') {
					$sql_cus_det = $xdata->query("SELECT `custtable`.`ID`,`CustomerID`,`cusName`,`custtable`.Address,TelNo, custtable.due_days FROM `custtable` 
			JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID`
			 Where invoice.`br_id` ='$br_id' and `custtable`.`ID`='$cus_id' group by invoice.`CusID`
			  ORDER BY `custtable`.`cusName` ASC ");
				} else {
					$sql_cus_det = $xdata->query("SELECT `custtable`.`ID`,`CustomerID`,`cusName`,`custtable`.Address ,TelNo, custtable.due_days FROM `custtable` 
			JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID`
			 Where invoice.`br_id` ='$br_id' group by invoice.`CusID` ORDER BY `custtable`.`cusName` ASC  ");
				}



				while ($cus_id_qry = $sql_cus_det->fetch_array()) {
					$cusID = $cus_id_qry['CustomerID'];
					$cusIDTb = $cus_id_qry['ID'];
					$cusName = $cus_id_qry['cusName'];
					$cusAdress = $cus_id_qry['Address'];
					$cusAdress_tel = $cus_id_qry['TelNo'];
					$cus_dueDays = $cus_id_qry['due_days'];

					$cuspaidTT = 0;
					$cusbalTT = 0;
					$cusinvTT = 0;

					if ($due_frm == '0' && $due_to == '0') {
						$qry_br = "SELECT `invoice`.`Date`,InvNo,CusID,InvTot,Balance,(InvTot-Balance), Stype, 
				  DATEDIFF (CAST(CURRENT_TIMESTAMP AS DATE),`invoice`.`Date`),Location,purchNo, repTbID FROM
				   `invoice` 
			   WHERE  `Balance` <> 0 and `invoice`.cusTbID='$cusIDTb'   
			   and invoice.`br_id`='$br_id'  
			   ORDER BY `invoice`.`Date` ASC";
					} else {
						$qry_br = "SELECT `invoice`.`Date`,InvNo,CusID,InvTot,Balance,(InvTot-Balance), Stype, 
				  DATEDIFF (CAST(CURRENT_TIMESTAMP AS DATE),`invoice`.`Date`),Location,purchNo, repTbID FROM
				   `invoice` 
			   WHERE  `Balance` <> 0 and `invoice`.cusTbID='$cusIDTb'   
			   and invoice.`br_id`='$br_id' AND DATEDIFF (CAST(CURRENT_TIMESTAMP AS DATE),`invoice`.`Date`) Between '$due_frm' AND '$due_to' 
			   ORDER BY `invoice`.`Date` ASC";
					}

					// echo $cus_id.'78787<br />'.$qry_br;
					$qry_due = $xdata->query($qry_br);
					// } 

					$no_row = $qry_due->num_rows;

					if ($no_row >= 1) {
						echo ' <tr>
									<th style="text-align:left; background:#F3E6F7;" colspan="10"><span style="color:crimson">' . $cusID . ' - ' . $cusName . '</span> | ' . $cusAdress . ' | ' . $cusAdress_tel . '</th>	
									<th style="text-align:right; background:#F3E6F7;" colspan="2">' . $cus_dueDays . ' Days</th>	
								</tr>';
					}


					$paid = 0;

					while ($due = $qry_due->fetch_array()) {
						$sql_repName = $mysqli->query("SELECT Name, RepID FROM salesrep WHERE br_id='$br_id' AND ID = '$due[repTbID]'");
						$repName = $sql_repName->fetch_array();
						$sql_cusState = $mysqli->query("SELECT settlment_date FROM cusstatement WHERE InvNo = '$due[1]' AND br_id = '$br_id'");
						$cusState = $sql_cusState->Fetch_array();
						$due1 = $cusState[0] == '0000-00-00' ? 'CASH' : $cusState[0];

						$itm_count = $itm_count + 1;
						$dif = $itm_count % 2;

						if ($due[6] == 'Balance') {
							$paid = 0;
							$due[5] = 0;
						} else {
							$paid = $due[5];
						}


						echo '
										  <tr >
											<td style="text-align:left;">' . $due[0] . ' </td>
									<td style="text-align:left;">' . $cusID . '</td>
									<td style="text-align:left;">' . $cusAdress . '</td>
									 <td style="text-align:left;"><a style="cursor:pointer; color:blue;" class="click_invDetail" value="' . $due[1] . '">' . $due[1] . '</a></td>
									 <td style="text-align:left;">' . $repName[0] . '</td>
									 <td style="text-align:left;">' . $repName[1] . '</td>
									 <td style="text-align:left;">' . $due1 . '</td>

									    <td style="text-align:left;">' . $due[9] . '</td>
									  <td style="text-align:left;">' . $due[8] . '</td>
									  <td style="text-align:right;">' . number_format($due[3], 2) . ' </td>
									   <td style="text-align:right;" >' . number_format($paid, 2) . '</td>
									  <td style="text-align:right;" >' . number_format($due[4], 2) . '</td>
									   <td style="text-align:right;">' . $due[7] . '</td>
									  </tr>';


						$invTT += $due[3];
						$paidTT += $due[5];
						$balTT += $due[4];

						$cusinvTT += $due[3];
						$cuspaidTT += $due[5];
						$cusbalTT += $due[4];
					}

					if ($no_row >= 1) {
						echo ' <tr>
									<th style="text-align:right; background:#DFEBF0;" colspan="9">Customer Total</th>
									<th style="text-align:right; background:#DFEBF0;" >' . number_format($cusinvTT, 2) . '</th>
									<th style="text-align:right; background:#DFEBF0;" >' . number_format($cuspaidTT, 2) . '</th>
									<th style="text-align:right; background:#DFEBF0;">' . number_format($cusbalTT, 2) . '</th>
									<th style="text-align:right; background:#DFEBF0;" ></th>
										</tr> 
								<tr> <th lcolspan="12"></th></tr>';
					}
				}
				/*$invTTt = $invTT + $due[3];
								$paidTTt =$paidTT + $due[5];
								$balTTt =$balTT + $due[4];	*/


				echo '  </tbody>';

				echo '<tfoot>
			<tr bgcolor="#D1C1BC">		
			<td colspan="9" style="text-align:right;">TOTAL</td>
			<td style="text-align:right;">' . number_format($invTT, 2) . '</td>
            <td style="text-align:right;">' . number_format($paidTT, 2) . '</td>
			<td style="text-align:right;">' . number_format($balTT, 2) . '</td>
			<td></td>
			</tr>
		</tfoot>';
				//}
				//}
				?>
		</table>
	</div>
</div>
</div>
</div>
</div>

<!--/span-->



<div class="box-content" align="center">
	<ul class="ajax-loaders" style="display:none">
		<li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>
	</ul>
</div>








</div>
<!-- content ends -->
</div>


<?php include($path . 'footer.php'); ?>
<?php include('statment_script.php'); ?>


<script>
	//var vl = $('#TYPE').val();
	//alert(vl);
	$('#cusRcvble').click(function() {
		var vlu = $('#cus_id').val();
		var f_date = $('#from_d').val();
		var t_date = $('#to_d').val();
		//alert(vlu);
		//alert('' +invID);
		window.open("print/New_CustmrReceivable_prnt.php?ITEM=" + vlu + "&FDATE=" + f_date + "&TDATE=" + f_date + "", "myWindowName", "width=595px, height=842px");

	});



	$('#invLoad').click(function() {
		var vlu = $('#cus_id').val();
		if (vlu != 'View All') {
			var f_date = $('#from_d').val();
			var t_date = $('#to_d').val();
			//alert(vlu);
			//alert('' +invID);
			window.open("print/New_CustmrReceivable_inv.php?cus_id=" + vlu + "&fDate=" + f_date + "&tDate=" + t_date + "", "myWindowName", "width=595px, height=842px");
		} else {
			alert('Please select a customer!')
		}

	});
</script>

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
</script>
<script type="text/javascript">
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
</script>