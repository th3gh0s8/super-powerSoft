<?php
$title = 'Cheque Report';
include('includeFile.php');

$title = 'Cheque In Hand Report';

$from_d	= $_GET['from_d'];
$to_d = $_GET['to_d'];
$sales_id = $_GET['sales_id'];

$_SESSION['f_day'] = $from_d;
$_SESSION['t_day'] = $to_d;
$_SESSION['sl_id'] = $sales_id;

$reportPrnt = 'salesReport';
//$ItemSearch = 'ItemSearch';
$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');


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


</head>

<body class="nav-sm">
	<div class="container body">
		<div class="main_container">




			<?php
			include($path . 'side.php');
			include($path . 'mainBar.php');
			?>
			<div class="right_col" role="main">

				<h2><i class="glyphicon glyphicon-user"></i> <?php echo $title; ?></h2>

				<div class="box-content2" style="width:99%; padding-left:1.5%; padding-right::0.5%;">
					<div class="row" style="background-color:#D5D3E8;">

						<div class="form-group" style="margin-bottom:; margin-left:;width:100%;">
							<?php include('chq_report_bar.php'); ?>
							</br>
							<div id="remove_TTb" class="findexcel">
								<table id="searchTable" class="table table-striped table-bordered responsivef invoSumryTB" style="margin-top:30px; margin-left: 4%; ">
									<thead>
										<tr>
											<th width="10%">Date </th>
											<th>Ref No</th>
											<th>Customer ID</th>
											<th>Customer</th>
											<th>Address</th>
											<th>Chq No</th>
											<th>Account No</th>
											<th>Amount</th>
											<th>Deposit Date</th>
											<th>Salesrep</th>
											<th>User</th>
										</tr>
									</thead>
									<tbody>


										<?php
										$sqlFindChq = $mysqli->query("SELECT `cusID`, `refNo`, `chqNo`, `ownerType`, `cashDate`, `chqAmount`, `status` ,ID,userID ,entryDate,status,frmID, accountNo
									FROM `chq_recieve` WHERE  br_id = '$br_id' ");

										while ($FindChq = $sqlFindChq->fetch_array()) {

											$sqlDepositChq = $mysqli->query("SELECT `rcvTbID` FROM `bank_deposit` WHERE `rcvTbID` = '$FindChq[7]'  AND br_id = '$br_id' ");
											$DepositChq = $sqlDepositChq->fetch_array();

											if ($DepositChq[0] != $FindChq[7]) {

												if ($FindChq['status'] == 'Journal') {
													$sqlCusDtls1 = $mysqli->query("SELECT Description, AccountMode FROM `journal` WHERE ID = '$FindChq[frmID]' ");
													$type = '( Journal )';
												} else {
													$sqlCusDtls1 = $mysqli->query("SELECT cusName, Address FROM `custtable` WHERE CustomerID = '$FindChq[0]'");
												}
												$sql_cusID = $mysqli->query("SELECT CustomerID FROM `custtable` WHERE CustomerID = '$FindChq[0]'");
												$cusID = $sql_cusID->fetch_assoc()['CustomerID'];

												$CusDtls1 = $sqlCusDtls1->fetch_array();

												$sql_RepID = $mysqli->query("SELECT Name FROM `salesrep`JOIN sys_users 
											ON `salesrep`.RepID = sys_users.RepID 
											WHERE sys_users.`id` = '$FindChq[userID]'");
												$RepID = $sql_RepID->fetch_array();

												$sql_salesrep = $mysqli->query("SELECT `repTbID` FROM `invoice` JOIN `cusstatement` ON `invoice`.ID = `cusstatement`.`invID` 
					                                    WHERE `ReceiptNo` = '$FindChq[refNo]' AND `cusstatement`.`br_id`='$br_id'");
												$salesrepDet = $sql_salesrep->fetch_array();

												$part1 = substr($FindChq['chqNo'], 0, 6);
												$part2 = substr($FindChq['chqNo'], 6, 4);
												$part3 = substr($FindChq['chqNo'], 10, 3);

												echo '<tr>
						<td style="text-align:left;  " >' . $FindChq['entryDate'] . '</td>
						<td style="text-align:left;  " >' . $FindChq['refNo'] . '</td>
						<td style="text-align:left;  " >' . $cusID . '</td>
						<td style="text-align:left;  ">' . $CusDtls1[0] . '' . $type . '</td>
						<td style="text-align:left;  ">' . $CusDtls1[1] . '</td>
						<td style="text-align:left;  ">' . $part1 . '-'.$part2.'-'.$part3.'</td>
						<td style="text-align:left;  ">' . $FindChq['accountNo'] . '</td>
						<td style="text-align:right;  ">' . number_format($FindChq['chqAmount'], 2) . '</td>
						<td style="text-align:left;  "><span style="color:#FFF;">#</span>' . $FindChq['cashDate'] . '</td>
						<td style="text-align:left;">' . FindRepName("ID", $salesrepDet['repTbID'], $br_id)['Name'] . '</td>
						<td style="text-align:left;">' . $RepID[0] . '</td>
						</tr>';
												$total_nw += $FindChq['chqAmount'];
											}
										}
										echo '  </tbody>';
										echo '
	<tfoot style=" background:#FFFF66; border-top:2px solid;">
		<tr>	
			
            <td colspan="7" style=" text-align:right; font-weight:5px; font-size:13px;">Total</td>
            <td style="text-align:right;border-top:1px solid;border-bottom-style:double;">' . number_format($total_nw, 2) . '</td>
			<td></td>
			<td></td>
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

				<!--/span-->



				<div class="box-content" align="center">
					<ul class="ajax-loaders" style="display:none">
						<li><img src="../daily/img/ajax-loaders/ajax-loader-8.gif" /></li>
					</ul>
				</div>

				<div id="mainLoadInvoSumry">


					<!-- ajax content load -->
				</div>






			</div>
			<!-- content ends -->


			<?php include($path . 'footer.php'); ?>

			<script>
				$('#salesReport').click(function() {
					var vlu = $('#TYPE').val();
					var f_date = $('#from_d').val();
					var t_date = $('#to_d').val();
					//alert(vlu);
					//alert('' +invID);
					window.open("print/chq_HandInChq_print.php?ITEM=" + vlu + "&FDATE=" + f_date + "&TDATE=" + f_date + "", "myWindowName", "width=595px, height=842px");

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

			<!--date picker files-->

			<?php include('chequeJava.php'); ?>