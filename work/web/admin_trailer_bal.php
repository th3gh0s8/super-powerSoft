<?php
$title = 'Trial Balance ';
include('includeFile.php');

$from_d	= $_GET['from_d'];
$to_d = $_GET['to_d'];

if ($_GET['com_br'] != 'undefined') {
	$com_br = $_GET['com_br'];
} else {
	$com_br = $br_id;
}

if ($com_br == '') {
	$com_br = $br_id;
}

$_SESSION['f_day'] = $from_d;
$_SESSION['t_day'] = $to_d;
$_SESSION['com_br'] = $com_br;


$reportPrnt = 'tr_bal';
$report_bar = 'trailer_bal';
//$reportslect='cate';
//$report_cusinv='cusinvdet';
//$ItemSearch = 'ItemSearch';
$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');


$sql_brnch = $mysqli->query("SELECT name FROM com_brnches  WHERE ID = '$br_id'");
$res_brnch = $sql_brnch->fetch_row();
$compnyName = $res_brnch[0];


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
		background: #E9F7F7;
		cursor: pointer;
		color: #009999;
	}

	.amountBox,
	.paymntBox {
		width: 80px;
		text-align: right;
	}

	tr {
		border: 0px;
	}

	th {
		border: 0px;
	}

	td {
		border: 0px;
	}


	.blink {
		animation: blink-animation 1s steps(5, start) infinite;
		-webkit-animation: blink-animation 1s steps(5, start) infinite;
	}

	@keyframes blink-animation {
		to {
			visibility: hidden;
		}
	}

	@-webkit-keyframes blink-animation {
		to {
			visibility: hidden;
		}
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
							<?php include('admin_report_bar.php'); ?>
							</br>
							<div id="remove_TTb" class="findexcel">
								<table class="table2 table-striped table-bordered bootstrap-datatable table-hover responsive invoSumryTB2" style="margin-top:30px; width:20%;  margin: 0 auto; border:0px; background-color:transparent;" ;>
									<tr>
										<th style="border:0px; background-color:transparent; text-align:center;"> Trial Balance </th>

									</tr>
									<tr>
										<th style="border:0px; background-color:transparent; text-align:center;"> As at
											<?php echo  date('d-M-Y', strtotime($month . $to_d)); ?> </th>
									</tr>
									<tr>

										<th style="border:0px; background-color:transparent; text-align:center;"> <?php echo $compnyName; ?> </th>

									</tr>
									<tr>
										<th style="border:0px; background-color:transparent; text-align:center; height:5px;"> </th>
									</tr>
								</table>

								<table class="  invoSumryTB" style="margin-top:30px; width:60%;  margin: 0 auto; border:0px; background-color:white;" ;>
									<thead style="background-color: whitesmoke;">
										<tr>
											<td colspan="3"></td>
											<td style="float: right;">
												<button type="button" id="btn_save" class="blink btn btn-primary btn-sm" style="margin-top: 5px;">
													Reload current JOURNAL balance</button>
											</td>
										</tr>
									</thead>
									<thead>
										<tr>

											<th width="12%"></th>
											<th></th>

											<th width="17%">Debit</th>
											<th width="17%">Credit</th>

										</tr>
									</thead>
									<tbody>

										<!--<th width="10%">Ave.Disc %</th>-->

										<?php
										$credit = 0;
										$debit = 0;
										$sub_debit = 0;
										$sub_credt = 0;

										$bg = "background-color:#F5F5F5;";
										$bg2 = "background-color:#DBD8D5;";

										$br_where = '';
										if ($com_br == "View All") {
											$br_where = '';
											$br_where2 = '';
											$br_cus = '';
											$br_jou = '';
										} else {
											$br_where = "WHERE `br_id` = '$com_br'";
											$br_where2 = "AND `br_id` = '$com_br'";
											$br_cus = "AND cusstatement.br_id = '$com_br'";
											$br_jou = "AND `journal`.br_id ='$com_br' ";
										}


										$view_type = $_SESSION['showhide_type'];
										//echo $user_type;
										$showType = "";
										if ($user_type != 'Admin') {
											switch ($view_type) {
												case 'Show':
													$SqlPrinaryBal = $mysqli->query("SELECT SUM(hBalance),SUM(sBalance) FROM `cashbal` $br_where ");
													$PrinaryBal  = $SqlPrinaryBal->fetch_array();
													$PrinaryBalold = $PrinaryBal[1];
													$shwSelct = 'selected';
													$showType = "AND ShowType ='SHOW'";

													break;

												case 'Hide':
													$SqlPrinaryBal = $mysqli->query("SELECT SUM(hBalance),SUM(sBalance) FROM `cashbal` $br_where ");
													$PrinaryBal  =  $SqlPrinaryBal->fetch_array();
													$PrinaryBalold = $PrinaryBal[0];
													$hidSelct = 'selected';
													$showType = "";


													break;
												default:
													$SqlPrinaryBal = $mysqli->query("SELECT SUM(hBalance),SUM(sBalance) FROM `cashbal` $br_where ");
													$PrinaryBal  =  $SqlPrinaryBal->fetch_array();
													$PrinaryBalold = $PrinaryBal[1];
													$shwSelct = 'selected';
													$showType = "AND ShowType ='SHOW'";
											}
										} else {
											$SqlPrinaryBal = $mysqli->query("SELECT SUM(hBalance),SUM(sBalance) FROM `cashbal` $br_where ");
											$PrinaryBal  =  $SqlPrinaryBal->fetch_array();
											$PrinaryBalold = $PrinaryBal[0];
											$hidSelct = 'selected';
											$showType = "";
										}



										function journal($jID, $jBR, $to_d)
										{
											$sqlprtyChq2j_infor = $mysqli->query("SELECT SUM(amount)
			FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID 
			WHERE journal.ID = '" . $jID . "' AND bank_deposit.entryDate <= '$to_d' 
			AND `bank_deposit`.br_id='$jBR' AND status= 'Payment-J' ");

											$party_chq = $sqlprtyChq2j_infor->fetch_array();

											$sqljoreturn2 = $mysqli->query("SELECT SUM(amount)
								  FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
								   WHERE jDueID = '" . $jID . "' AND bank_deposit.entryDate <= '$to_d' AND
								   `bank_deposit`.br_id='$jBR' AND status != '' AND rtnID !='0' ");

											$rst_rtn2 = $sqljoreturn2->fetch_array();

											///derect chq income journal		
											$sqldirct_inforOI = $mysqli->query("SELECT SUM(chqAmount)
			FROM `chq_recieve` LEFT OUTER JOIN journal ON chq_recieve.frmID = journal.ID 
			WHERE journal.ID = '" . $jID . "' AND chq_recieve.entryDate <= '$to_d' 
			AND `chq_recieve`.br_id='$jBR' AND status= 'Journal' ");

											$dirct_chqOI = $sqldirct_inforOI->fetch_array();

											return ($party_chq[0] - ($rst_rtn2[0] + $dirct_chqOI[0]));
										}


										/// Asstes debit ---------------------------------------------------------------------------------------

										$tot_ass = 0;
										echo '<tr>
				<th style="text-align:center;">  ASSETS </th>
				<th colspan="3" style="text-align:left;">  </th>
				 </tr>';

										$qry_recivable_cus = $mysqli->query("SELECT SUM(`InvAmnt`)-SUM(`Paid`) FROM `cusstatement` 
				 WHERE `Date` <= '$to_d' $br_where2 ");
										$exc_recivable_cus = $qry_recivable_cus->fetch_array();
										$recivable_cus = $exc_recivable_cus[0];
										//$tot_ass +=$recivable_cus;
										$show_credt = 0;
										$show_debit = 0;
										if ($recivable_cus > 0) {
											$debit += $recivable_cus;
											$show_debit = $recivable_cus;
											$sub_debit += $recivable_cus;
										} else {
											$credit += (-1 * $recivable_cus);
											$show_credt = (-1 * $recivable_cus);
											$sub_credt += (-1 * $recivable_cus);
										}

										echo '<tr>
				<td >  </td>
				<td ><a href="#" style="color:blue;" class="tradeDebtors"> Recievable </a></td>
				
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right; ' . $bg . ' " > ' . number_format($show_credt, 2) . '</td>
				 </tr>';

										// Stock value --------------------------strat debit----########################################################

										$sql_open_stk = $mysqli->query("SELECT SUM(`NewCost` * `NewQty`) FROM `begitems` $br_where ");
										$open_stk = $sql_open_stk->fetch_array();

										$sql_open_stkAjs = $mysqli->query("SELECT SUM(`NewCost` * `NewQty`) FROM `begitems` $br_where AND `cloud`='delete' ");
										$open_stkAjs = $sql_open_stkAjs->fetch_array();

										$opStk = $open_stk[0];
										$ajsStk = $open_stkAjs[0];
										$begStk = $opStk - $ajsStk;

										/*$sqlAF_BegP = $mysqli->query("SELECT SUM(`QtyRcvd`*`Nprice`) FROM `purchitem` 
									WHERE `Date` <= '$to_d' AND br_id = '$br_id' ");
				$AF_BegP = $sqlAF_BegP->fetch_array();
				
				$sqlAF_BegI = $mysqli->query("SELECT SUM(`Quantity`*`CostPrice`) FROM `invitem` WHERE `Date` <= '$to_d' AND br_id = '$br_id' ");
		$AF_BegI = $sqlAF_BegI->fetch_array(); */

										$stk = $opStk;
										//	echo $stk;
										$show_credt = 0;
										$show_debit = 0;
										if ($stk > 0) {
											$debit += $stk;
											$show_debit = $stk;
											$sub_debit += $stk;
										} else {
											$credit += (-1 * $stk);
											$show_credt = (-1 * $stk);
											$sub_credt += (-1 * $stk);
										}

										//$tot_ass +=$open_stk[0];
										//$debit +=$open_stk[0];


										echo '<tr>
				<td >  </td>
				<td ><a href="#" class="begStock" begStockF="' . $from_dd . '" begStockT="' . $to_dd . '" style="color:blue"> Beginning Stock</a><span style="text-align:center; float:right;"> ' . number_format($begStk, 2) . ' </span>  </td>
				
				<td style="text-align:right; ' . $bg . '" > </td>
				
				<td style="text-align:right; ' . $bg . '" ></td>
				 </tr>';

										echo '<tr>
				<td >  </td>
				<td >Stock Adjustment  <span style="text-align:center; float:right;"> ' . number_format($ajsStk, 2) . ' </span>  </td>
				
				<td style="text-align:right; ' . $bg . '" > </td>
				
				<td style="text-align:right; ' . $bg . '" ></td>
				 </tr>';

										echo '<tr>
				<td >  </td>
				<td > Opening Stock </td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';



										//echo 'swwho '.$showType ;



										// cash in hand

										/* $SqlPrinaryBal = $mysqli->query("SELECT SUM(hBalance + sBalance) FROM `cashbal` WHERE `br_id` = '$br_id'");
				$PrinaryBal  = $SqlPrinaryBal->fetch_array();*/
										//============================================================================================================================================
										$sqlOrdrAdvncOLD = $mysqli->query("SELECT SUM(`paid`+paid_del) FROM `order_tb` WHERE dates  <= '$to_d' $br_where2 " . $showType . " ");

										$OrdrAdvncOLD =  $sqlOrdrAdvncOLD->fetch_array();

										$sql_TotalCashRcvdAmntOLD = $mysqli->query("SELECT  SUM(Paid) FROM `cusstatement` WHERE Date <= '$to_d' $br_where2 
											AND FromDue != 'Due' AND RepID != 'Card' AND RepID != 'Cheque'  and order_id = '' " . $showType . " ");
										$TotalCashRcvdAmntOLD =  $sql_TotalCashRcvdAmntOLD->fetch_array();

										$sql_OrderAdvnceOLD = $mysqli->query("SELECT  SUM(cusstatement.Paid) FROM `cusstatement` JOIN order_tb ON 
										`cusstatement`.order_id = order_tb.order_id WHERE `cusstatement`.`Date` <= '$to_d'
										 $br_cus
										AND FromDue != 'Due' AND RepID != 'Card' AND RepID != 'Cheque'  " . $showType . "");
										$OrderAdvnceOLD =  $sql_OrderAdvnceOLD->fetch_array();

										$sqlJentryD_OLD = $mysqli->query("SELECT SUM(`Debit`)  FROM `jentry` 
								WHERE  Date <= '$to_d' $br_where2 AND jentry_delete != '1'
								AND Bounced IS NULL " . $showType . "");
										$JentryOLDD =  $sqlJentryD_OLD->fetch_array();

										$sqlJentryComiOLDD = $mysqli->query("SELECT SUM(`Debit`)  FROM `jentry` 
								WHERE  Date <= '$to_d' $br_where2 AND jentry_delete != '1' AND 
								Bounced = 'Card' " . $showType . " ");
										//$JentryComiOLDD = $sqlJentryComiOLDD->fetch_array();


										$sql_TotalDueOLD = $mysqli->query("SELECT SUM(`Paid`) FROM `cusstatement` 
									WHERE Date <= '$to_d' $br_where2 AND FromDue = 'Due' AND  RepID NOT LIKE 'C%'
									" . $showType . " ");
										$TotalDueOLD =  $sql_TotalDueOLD->fetch_array();

										$sql_TotalTransOLD = $mysqli->query("SELECT SUM(InvAmnt) FROM `cusstatement` 
									WHERE Date <= '$to_d' $br_where2 AND FromDue != 'Due' AND  RepID ='CTrans' 
									" . $showType . " ");
										$TotalTransOLD =  $sql_TotalTransOLD->fetch_array();



										//2021-10-06 13:03 Edited
										//$OldDbt  = 	$TotalCashRcvdAmntOLD[0] + $TotalDueOLD[0]+ $JentryOLDD[0]+ $JentryComiOLDD[0]+(-$TotalTransOLD[0])+ $OrdrAdvncOLD[0] ;

										$OldDbt  = 	$TotalCashRcvdAmntOLD[0] + $TotalDueOLD[0] + $JentryOLDD[0] + $JentryComiOLDD[0] + $OrdrAdvncOLD[0];

										//=========================================================================================================================================
										$sql_CashVndrStmntPaidOLD = $mysqli->query("SELECT  SUM(`Paid`) 
											 FROM `venstatement` WHERE  Date <= '$to_d' $br_where2 AND FromDue != 'Due' 
											 " . $showType . " ");
										$CashVndrStmntPaidOLD =  $sql_CashVndrStmntPaidOLD->fetch_array();

										$sqlJentryC_OLD = $mysqli->query("SELECT SUM(`Credit`)  FROM `jentry` 
								WHERE  Date <= '$to_d' $br_where2 AND jentry_delete != '1' AND 
								Bounced IS NULL " . $showType . "");
										$JentryOLDC =  $sqlJentryC_OLD->fetch_array();

										$sql_VndrStmntPaidOLD = $mysqli->query("SELECT SUM(`Paid`)
											 FROM `venstatement` WHERE  Date <= '$to_d' $br_where2 AND FromDue = 'Due'
											  AND ByCheque NOT LIKE '%C%' " . $showType . "");
										$VndrStmntPaidOLD = $sql_VndrStmntPaidOLD->fetch_array();

										$sql_TotalTransVenOLD = $mysqli->query("SELECT Sum(InvAmnt) FROM `venstatement` 
									WHERE Date  <= '$to_d' $br_where2 AND FromDue != 'Due' AND  ByCheque ='CTrans'
									" . $showType . " ");
										$TotalTransVenOLD =  $sql_TotalTransVenOLD->fetch_array();


										$OldCrdt = $CardRcvdAmntOLD[0] + $CashVndrStmntPaidOLD[0] + $VndrStmntPaidOLD[0] + $JentryOLDC[0] + (-$TotalTransVenOLD[0]);

										$sql_SalesNote = $mysqli->query("SELECT SUM(InvTot)
										FROM `invoice`
										WHERE invoice.`Date` <= '$to_d' 
										AND br_id = '$br_id' AND `Stype` = 'NOTE'");
										$SalesNote = $sql_SalesNote->fetch_array();

										$TOTALBF_OLD = $OldDbt - $OldCrdt + $PrinaryBalold - $SalesNote[0];


										/*  $qry_cash=$mysqli->query("SELECT SUM( `hBalance` + `sBalance`) FROM `cashbal` where `br_id`='$br_id'");
				 $exc_cash= $qry_cash->fetch_array();
					$cashINhand= $exc_cash[0];*/
										//$tot_ass +=$TOTALBF_OLD;
										//$credit+=$TOTALBF_OLD;

										//credit
										$show_credt = 0;
										$show_debit = 0;
										if ($TOTALBF_OLD < 0) {
											$credit += (-1 * $TOTALBF_OLD);
											$show_credt = (-1 * $TOTALBF_OLD);
											$sub_credt += (-1 * $TOTALBF_OLD);
										} else {
											$debit += $TOTALBF_OLD;
											$show_debit = $TOTALBF_OLD;
											$sub_debit += $TOTALBF_OLD;
										}


										//echo "SELECT SUM( `hBalance` + `sBalance`) FROM `cashbal` where `Date`  <= '$to_d' and `br_id`='$br_id'";


										//==========================================================================================================================






										// journal cash
										echo '
					<tr> <td colspan="4"> &nbsp;</td> </tr>
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > Cash/ASSETS Journal </th>
		
				 </tr>';

										echo '<tr>
				<td > </td>
				<td ><a href="#" style="color:blue;" class="cashInHand" cashInHandAttr = "' . $from_dd . '" cashInHandAttr1 = "' . $to_dd . '"> Day Book Balance </a></td>
				
			
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';

										$qry_cat = $mysqli->query("SELECT `cat_id`, cate FROM `journal` LEFT JOIN journal_cat ON 
				  `journal`.`cat_id`= journal_cat.ID WHERE journal.AccountMode in ('CASH','ASSETS','LONG TERM ASSETS') $br_jou
				  GROUP BY `journal_cat`.`cate` ORDER BY `journal_cat`.`cate` ASC");

										while ($jCat = $qry_cat->fetch_array()) {


											$qry_jnl_cash = $mysqli->query("SELECT `rep_bal`,journal.Description,journal.AccID,
				 journal.br_id,journal.ID FROM  journal 
				 WHERE journal.AccountMode in ('CASH','ASSETS', 'LONG TERM ASSETS') AND `journal`.`cat_id`='$jCat[0]' $br_jou  
				 GROUP BY journal.AccID ORDER BY journal.AccID ASC");

											$count_cash = $qry_jnl_cash->num_rows;
											//echo '<br> cat'.$jCat[1];
											$ii = 0;
											while ($exc_cash2 = $qry_jnl_cash->fetch_array()) {
												

												$jbr = $exc_cash2['br_id'];
												$jID = $exc_cash2['ID'];
												$jcash = $exc_cash2[0];
												// $tot_ass +=$jcash;
												// $debit+=$jcash;

												$show_credt = 0;
												$show_debit = 0;
												if ($jcash > 0) {
													$debit += $jcash;
													$show_debit = $jcash;
													$sub_debit += $jcash;
												} else {
													$credit += (-1 * $jcash);
													$show_credt = (-1 * $jcash);
													$sub_credt += (-1 * $jcash);
												}

                                                $fommatNu = number_format($jcash,2);
												if ($fommatNu != '0.00') {
												    $ii++;
													if ($ii == '1' && $jCat[0] != 0) {
														echo '<tr>
						<td >  </td>
						<th colspan="3" style="color:#136a15;" >' . $jCat[1] . '</th>
						 </tr>';
													}

													echo '<tr>
				<td > </td>
				<td >' . $exc_cash2[1] . ' - ' . $jbr . '</td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_debit,2) . '</td>
				
				<td style="text-align:right;' . $bg . '"> ' . number_format($show_credt,2) . ' </td>
				 </tr>';
												}
											}
										} // journal cash







										// journal LOAN / LEASE
										$qry_jnl_loan = $mysqli->query("SELECT `rep_bal` ,journal.Description,journal.AccID,journal.br_id,
				 journal.ID FROM journal  WHERE 
				  journal.AccountMode='LOAN / LEASE' and `rep_bal` !=0  $br_jou GROUP by journal.AccID ");

										$count_loan = $qry_jnl_loan->num_rows;

										if ($count_loan > 0) {
											echo '
					<tr> <td colspan="4"> &nbsp;</td> </tr>
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > LOAN / LEASE </th>
		
				 </tr>';
										}

										while ($exc_loan = $qry_jnl_loan->fetch_array()) {
											$jbr = $exc_loan['br_id'];
											/*$sqlBGbal_loan = $mysqli->query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE AccID='".$exc_loan[2]."' AND br_id ='$jbr' ");
					$bg_loan=$sqlBGbal_loan->fetch_array();*/


											$jcash = $exc_loan[0];
											// $tot_ass +=$jcash;
											// $debit+=$jcash;

											$show_credt = 0;
											$show_debit = 0;
											if ($jcash > 0) {
												$debit += $jcash;
												$show_debit = $jcash;
												$sub_debit += $jcash;
											} else {
												$credit += (-1 * $jcash);
												$show_credt = (-1 * $jcash);
												$sub_credt += (-1 * $jcash);
											}


											if ($jcash != 0) {
												echo '<tr>
				<td > </td>
				<td >' . $exc_loan[1] . ' - ' . $jbr . ' </td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right;' . $bg . '"> ' . number_format($show_credt, 2) . ' </td>
				 </tr>';
											}
										} // journal LOAN / LEASE



										// journal capital
										$qry_jnl_capi = $mysqli->query("SELECT `rep_bal` ,journal.Description,journal.AccID,journal.br_id, 
				 journal.ID FROM journal WHERE 
				  journal.AccountMode='CAPITAL' and `rep_bal` !=0 $br_jou GROUP by journal.AccID  ");

										$count_capi = $qry_jnl_capi->num_rows;

										if ($count_capi > 0) {
											echo '
					<tr> <td colspan="4"> &nbsp;</td> </tr>
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > CAPITAL</th>
		
				 </tr>';
										}

										while ($exc_capi = $qry_jnl_capi->fetch_array()) {
											$jbr = $exc_capi['br_id'];
											/*$sqlBGbal_capi = $mysqli->query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE AccID='".$exc_capi[2]."' AND br_id ='$jbr' ");
											
					$bg_capi=$sqlBGbal_capi->fetch_array();

					
					$jcash= $exc_capi[0]+$bg_capi[0]+journal($exc_capi[4],$jbr,$to_d);*/

											$jcash = $exc_capi[0];


											// $tot_ass +=$jcash;
											// $debit+=$jcash;

											$show_credt = 0;
											$show_debit = 0;
											if ($jcash > 0) {
												$debit += $jcash;
												$show_debit = $jcash;
												$sub_debit += $jcash;
											} else {
												$credit += (-1 * $jcash);
												$show_credt = (-1 * $jcash);
												$sub_credt += (-1 * $jcash);
											}


											if ($jcash != 0) {
												echo '<tr>
				<td > </td>
				<td >' . $exc_capi[1] . ' - ' . $jbr . ' </td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right;' . $bg . '"> ' . number_format($show_credt, 2) . ' </td>
				 </tr>';
											}
										} // journal capital




										// bank balance strat ###@@@###############

										$qry_bank = $mysqli->query("SELECT `ID`,Bank,BankCODE,BranchCODE,Description,AccID,journal.br_id FROM  journal  
				  WHERE journal.AccountMode='CURRENT ACC' $br_jou
				 OR  journal.AccountMode='SAVING ACC' $br_jou ");

										$count_bank = $qry_bank->num_rows;
										if ($count_bank > 0) {
											echo '
					<tr> <td colspan="4"> &nbsp;</td> </tr>
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > Bank Balance </th>
		
				 </tr>';
										}

										while ($exc_bank = $qry_bank->fetch_array()) {
											$j_id = $exc_bank['ID'];
											$ID03 = $exc_bank['Bank'];
											$ID01 = $exc_bank['BankCODE'];
											$ID02 = $exc_bank['BranchCODE'];
											$jou_id = $exc_bank['AccID'];
											$jbr = $exc_bank['br_id'];


											$sqlBF = $mysqli->query("SELECT Credit,Debit,BranchCODE,journal.AccID,Bank,Bounced FROM `journal` JOIN jentry 
											ON journal.AccID = jentry.AccID AND journal.br_id = jentry.br_id 
											WHERE jentry.Date <= '$to_d' AND jentry.`AccID`='$jou_id' AND jentry.br_id ='$jbr'
											and `jentry_delete` != 1  ");
											$BFCardC = 0;
											$BFCardD = 0;
											$BFC = 0;
											$BFD = 0;
											while ($jbf = $sqlBF->fetch_array()) {

												if ($jbf['Bounced'] == 'Card') {
													$BFCardC += $jbf[1];
													$BFCardD += $jbf[0];
												} else {
													$BFC += $jbf[0];
													$BFD += $jbf[1];

													//echo '1---'.$BFC.'------mm'.$BFD.'</br>';


												}
											}


											$sqlBGbal = $mysqli->query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE `AccID`='$jou_id' and `br_id`='$jbr' ");


											// direct cheque recieved -------------------------------------------------------------------------------------
											$bf_derictChq	= 0;


											$qry_cqe_dir_bl = $mysqli->query("SELECT  SUM(`chqAmount`)
			FROM `chq_recieve` WHERE `frmID`='$j_id' AND rec_form ='DIRECT'  AND `status`= 'Journal' AND
			 `br_id` = '$jbr' AND `entryDate` <= '$to_d'  ");


											while ($exc_cqe_dir_bl = $qry_cqe_dir_bl->fetch_array()) {
												// credit
												$bf_derictChq	=  $bf_derictChq + $exc_cqe_dir_bl[0];
											}
											// direct cheque recieved -------------------------------------------------------------------------------------




											//echo 'ses   fdf';		
											//$bfCount = $sqlBF->num_rows;
											$sqlBankDpositOLDR = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID` >0 AND rtnID > 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND entryDate <= '$to_d' AND `bank_deposit`.br_id='$jbr' 
										AND  `status` NOT Like '%Own-Return%' ");

											$sqlBankDpositOLDD = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID` > 0 AND rcvTbID >0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND entryDate <= '$to_d' AND `bank_deposit`.br_id='$jbr' ");


											$sqlOwnChqIsd = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND chqBID > 0 AND depositDate <= '$to_d' AND rtnID = 0
										 AND status != 'Encash' 
										AND status != 'OwnChqPayment' AND `bank_deposit`.br_id='$jbr' ");


											$sqlOwnChqRtn = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND chqBID > 0 AND entryDate <= '$to_d' AND rtnID != 0
										 AND `bank_deposit`.br_id='$jbr' AND `status` Like '%Own-Return%'  ");

											$BFRChq = $sqlBankDpositOLDR->fetch_array();
											//echo $BFRChq[0];
											$BFDChq = $sqlBankDpositOLDD->fetch_array();
											$OwnChqIsd = $sqlOwnChqIsd->fetch_array();
											$OwnChqRtn = $sqlOwnChqRtn->fetch_array();



											// party cheque  to journal------------------------------------------------------------------
											$sqlprtyChq2j = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID 
										WHERE journal.ID = '$j_id' AND entryDate <= '$to_d' 
										AND `bank_deposit`.br_id='$jbr' AND rtnID ='0' ");
											$BFprtyChq2j = $sqlprtyChq2j->fetch_array();

											//return cheqe
											$sqlprtyChq2j_rtn = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID 
										WHERE journal.ID = '$j_id' AND entryDate <= '$to_d'
										AND `bank_deposit`.br_id='$jbr' AND rtnID !='0'  ");
											$BFprtyChq2j_rtn = $sqlprtyChq2j_rtn->fetch_array();

											$sqljcreturn_bl = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate <= '$to_d'  AND
										 `bank_deposit`.br_id='$jbr' AND rtnID !='0' ");
											$BFjcreturn = $sqljcreturn_bl->fetch_array();
											// party cheque  to journal------------------------------------------------------------------



											// BF journal to journal reisssue return
											$sqlreissuj_bl = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate <= '$to_d'  AND
										 `bank_deposit`.br_id='$jbr' AND rtnID ='0' AND status = 'ReIssue-J' ");
											$BFjreissue = $sqlreissuj_bl->fetch_array();

											// BF journal to vendor paid
											$sqlpaidVn_bl = $mysqli->query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate <= '$to_d'  AND
										 `bank_deposit`.br_id='$jbr' AND rtnID ='0' AND status = 'PAID' ");
											$BFpaidVEN = $sqlpaidVn_bl->fetch_array();



											$BGbal = $sqlBGbal->fetch_array();


											$sqljoreturn = $mysqli->query("SELECT SUM(amount)
								  FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
								  WHERE jDueID = '$j_id' AND bank_deposit.entryDate  <= '$to_d' AND
								   `bank_deposit`.br_id='$jbr' AND status != '' AND rtnID !='0' ");
											$jown_rtn = $sqljoreturn->fetch_array();



											$bfCredit = $BFC + $BFCardC + $BGbal[0] + $BFDChq[0] + $OwnChqRtn[0] + $BFjcreturn[0] + $BFprtyChq2j[0];
											$bfDebit = $BFD + $BFCardD + $BFRChq[0] + $OwnChqIsd[0] + $BFprtyChq2j_rtn[0] + $BFjreissue[0] + $BFpaidVEN[0]
												+ $bf_derictChq + $jown_rtn[0];

											$TTBF = $bfCredit - $bfDebit;
											$bank = $TTBF;
											// get bank balance--------------------------------		


											$show_credt = 0;
											$show_debit = 0;
											//echo $bank;
											if ($bank > 0) {
												$debit += $bank;
												$show_debit = $bank;
												$sub_debit += $bank;
											} else {
												$credit += (-1 * $bank);
												$show_credt = (-1 * $bank);
												$sub_credt += (-1 * $bank);
											}

											//$bank= $exc_bank[0];
											//$tot_ass +=$bank;
											//$debit +=$bank;

											if ($bank != 0) {

												echo '<tr>
				<td > </td>
				<td ><a href="#" style="color:blue;" class="banckJournal" banckJournalAttr="' . $exc_bank['AccID'] . '" journalFrom="' . $from_dd . '" journalTo="' . $to_dd . '">' . $exc_bank['Description'] . '</a> </td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right;' . $bg . '"> ' . number_format($show_credt, 2) . ' </td>
				 </tr>';
											}
										}

										// bank balance end ###@@@###############




										// Stock value --------------------------end----########################################################

										// cheque in hand----------------------------------------------------------------------------

										/*$qry_chq_reciv=$mysqli->query("SELECT SUM(chqAmount) FROM `chq_recieve` WHERE br_id = '$br_id'  AND `cashDate`  <= '$to_d' 
				    ");
					
				 $exc_chq_reciv= $qry_chq_reciv->fetch_array();
					$chq_reciv= $exc_chq_reciv[0];
					
					 $qry_chq_deposit=$mysqli->query("SELECT SUM(amount) FROM `bank_deposit` WHERE 
										  status='Deposit'   AND br_id = '$br_id'  AND `depositDate`  <= '$to_d'  ");
				 $exc_chq_deposit= $qry_chq_deposit->fetch_array();
					$chq_deposit= $exc_chq_deposit[0];
					
					$chg_inHand=$chq_reciv-$chq_deposit;*/


										$sqlFindChq = $mysqli->query("SELECT `cusID`, `refNo`, `chqNo`, `ownerType`, `cashDate`, `chqAmount`, `status` ,ID,
					userID ,entryDate,status,frmID,br_id
									FROM `chq_recieve`  Where `entryDate`  <= '$to_d' $br_where2 ");

										while ($FindChq = $sqlFindChq->fetch_array()) {

											$sqlDepositChq = $mysqli->query("SELECT `rcvTbID` FROM `bank_deposit` WHERE `rcvTbID` = '$FindChq[7]'  
					AND br_id = '$FindChq[br_id]' AND entryDate <= '$to_d'");
											$DepositChq = $sqlDepositChq->fetch_array();

											if ($DepositChq[0] != $FindChq[7]) {
												$chg_inHand += $FindChq[5];
											}
										}

										//$tot_ass +=$chg_inHand;
										//$debit +=$chg_inHand;;

										$show_credt = 0;
										$show_debit = 0;
										if ($chg_inHand > 0) {
											$debit += $chg_inHand;
											$show_debit = $chg_inHand;
											$sub_debit += $chg_inHand;
										} else {
											$credit += (-1 * $chg_inHand);
											$show_credt = (-1 * $chg_inHand);
											$sub_credt += (-1 * $chg_inHand);
										}


										//echo $chq_reciv.' cheque '.$chq_deposit;

										echo '<tr>
				<td > </td>
				<td ><a href="#" style="color:blue;" class="chequeInHand"> Cheque In Hand</a></td>
				
				<td style="text-align:right;' . $bg . '"  > ' . number_format($show_debit, 2) . '</td>
			
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';


										// cheque in hand----------------------------------------------------------------------------

										// deriect cheque --------------------------------------------------------------------------

										$qry_drict = $mysqli->query("SELECT sum(`chqAmount`) FROM `chq_recieve` WHERE `rec_form`='DIRECT' AND `cusID` !=''  $br_where2
				 AND `entryDate` <= '$to_d' ");
										$rst_derict = $qry_drict->fetch_array();

										$drct_chq = $rst_derict[0];

										$show_credt = 0;
										$show_debit = 0;
										if ($$drct_chq < 0) {
											$debit += (-1 * $drct_chq);
											$show_debit = (-1 * $drct_chq);
											$sub_debit += (-1 * $drct_chq);
										} else {
											$credit += $drct_chq;
											$show_credt = $drct_chq;
											$sub_credt += $drct_chq;
										}


										//echo $chq_reciv.' cheque '.$chq_deposit;

										echo '<tr>
				<td > </td>
				<td > Direct Cheque</td>
				
				<td style="text-align:right;' . $bg . '"  > ' . number_format($show_debit, 2) . '</td>
			
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';


										// end deriect cheque --------------------------------------------------------------------------





										// Assets sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________

										echo '<tr>
				
				<th > </th>
				<th style="text-align: right; color:#D11518;" > Sub Total </th>
				<th style="text-align: right; color:#D11518; " > ' . number_format($sub_debit, 2) . ' </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_credt, 2) . '</th>
				 </tr>';

										$sub_credt = 0;
										$sub_debit = 0;
										// Assets sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________


										// income debit -----------------------------------------------------------------------------------------------
										$tot_income = 0;
										echo '<tr>
				<th style="text-align:center;"> INCOME </th>
				<th colspan="3">  </th>
				 </tr>';

										/*$sqlBF_Sales = $mysqli->query("SELECT SUM(invitem.Sprice*Quantity)
											FROM `invitem`
											WHERE invitem.`Date` <= '$to_d' 
											AND invitem.br_id = '$br_id' ");*/

										$sqlBF_Sales = $mysqli->query("SELECT SUM(InvTot)
											FROM `invoice`
											WHERE invoice.`Date` <= '$to_d' 
											AND br_id = '$br_id' AND `Stype` NOT IN('Balance', 'NOTE')");
										$BF_Sales = $sqlBF_Sales->fetch_array();

										$sqlBF_invDis = $mysqli->query("SELECT SUM(Sdisc) FROM invoice WHERE `Date` <= '$to_d'  AND br_id = '$br_id' AND 
											Stype != 'Balance' AND ChqNo = ''");
										$BF_invDis = $sqlBF_invDis->fetch_array();

										$sal = $BF_Sales[0];

										$show_credt = 0;
										$show_debit = 0;
										if ($sal < 0) {
											$debit += (-1 * $sal);
											$show_debit = (-1 * $sal);
											$sub_debit  += (-1 * $sal);
										} else {

											$credit += $sal;
											$show_credt = $sal;
											$sub_credt += $sal;
										}

										$sql_OrderAdvnce = $mysqli->query("SELECT SUM(cusstatement.Paid) FROM `cusstatement` JOIN order_tb ON 
										`cusstatement`.order_id = order_tb.order_id WHERE cusstatement.Date <= '$to_d' AND cusstatement.br_id = '$br_id' 
										AND FromDue != 'Due' AND RepID != 'Card' AND RepID != 'Cheque'");
										$OrderAdvnce = $sql_OrderAdvnce->fetch_array();

										$sqlOrdrAdvnc = $mysqli->query("SELECT SUM(`paid`) FROM `order_tb` WHERE dates <= '$to_d' AND br_id = '$br_id' AND cloud != 'DELETED'");
										$OrdrAdvnc = $sqlOrdrAdvnc->fetch_array();


										$advanceAmount = $OrdrAdvnc[0] - $OrderAdvnce[0];
										$sub_credt += $advanceAmount;
										$credit += $advanceAmount;
										echo '<tr>
				<td > </td>
				<td ><a style="cursor:pointer; color:blue;" class="daySales" salesDate = "BETWEEN \'' . $from_dd . '\' AND \' ' . $to_dd . '\'"> Total Sales </a></td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';

										echo '<tr>
				<td > </td>
				<td > Total Advance </td>
				
				<td style="text-align:right; ' . $bg . '" > 0.00</td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($advanceAmount, 2) . ' </td>
				 </tr>';


										// journal income
										$qry_jnl_income = $mysqli->query("SELECT `rep_bal`,journal.Description,journal.AccID,journal.br_id, 
				 journal.ID FROM journal  WHERE 
				  journal.AccountMode='OTHER INCOME' and `rep_bal` !='0' $br_jou GROUP by journal.AccID ");

										$count_jou = $qry_jnl_income->num_rows;
										if ($count_jou > 0) {
											echo '
					<tr> <td colspan="4"> &nbsp;</td> </tr>
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > Journal Income </th>
		
				 </tr>';
										}

										while ($exc_jincome = $qry_jnl_income->fetch_array()) {
											$jbr = $exc_jincome['br_id'];

											/* $sqlBGbal_jincome = $mysqli->query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE AccID='".$exc_jincome[2]."' AND br_id ='$jbr' ");
					$bg_jincome=$sqlBGbal_jincome->fetch_array();
					
				
					$jincome= $exc_jincome[0]+$bg_jincome[0]+journal($exc_jincome[4],$jbr,$to_d);*/

											$jincome = $exc_jincome[0];

											// $tot_income +=$jincome;
											// $credit+=$jincome;

											//credit---
											$show_credt = 0;
											$show_debit = 0;
											if ($jincome > 0) {
												$debit += $jincome;
												$show_debit = $jincome;
												$sub_debit +=  $jincome;
											} else {
												$credit += (-1 * $jincome);
												$show_credt = (-1 * $jincome);
												$sub_credt += (-1 * $jincome);
											}

											if ($jincome != 0) {
												echo '<tr>
				<td> </td>
				<td ><a href="#" style="color:blue;" class="banckJournal" banckJournalAttr="' . $exc_jincome['AccID'] . '" journalFrom="' . $from_dd . '" journalTo="' . $to_dd . '">' . $exc_jincome[1] . ' - ' . $jbr . ' </a></td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right; ' . $bg . '"> ' . number_format($show_credt, 2) . ' </td>
				 </tr>';
											}
										} // journal income


										// INCOME sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________

										echo '<tr>
				<th style="text-align: right;" > </th>
				<th style="text-align: right; color:#D11518; " > Sub Total </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_debit, 2) . ' </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_credt, 2) . '</th>
				 </tr>';

										$sub_credt = 0;
										$sub_debit = 0;
										//  INCOME  sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________



										// liablities credit ----------------------------------------------------------------------------------------------- 
										$liblity = 0;
										echo '<tr>
				<th style="text-align:center;"> LIABILITIES </th>
				<th colspan="3">  </th>
				 </tr>';


										$qry_payable_ven = $mysqli->query("SELECT SUM(`InvAmnt`)-SUM(`Paid`) FROM `venstatement` 
				 WHERE `Date` <= '$to_d' $br_where2 ");


										$exc_payable_ven = $qry_payable_ven->fetch_array();
										$payable_ven = $exc_payable_ven[0];
										// $liblity +=$payable_ven;
										//$credit +=$payable_ven;

										//credit---
										$show_credt = 0;
										$show_debit = 0;
										if ($payable_ven < 0) {
											$debit += (-1 * $payable_ven);
											$show_debit = (-1 * $payable_ven);
											$sub_debit += (-1 * $payable_ven);
										} else {
											$credit += $payable_ven;
											$show_credt = $payable_ven;
											$sub_credt += $payable_ven;
										}

										echo '<tr>
				<td > </td>
				<td ><a href="#" style="color:blue;" class="creditors" creditorsFrom="' . $from_d . '" creditorsTo="' . $to_d . '"> Payable </a></td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
		
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';

										//own cheque in hand #######################################

										$qry_ownHand = $mysqli->query("SELECT SUM(`amount`) FROM `bank_deposit` WHERE `entryDate` <= '$to_d' 
				 AND `depositDate` > '$to_d' $br_where2 AND `venID` !='0' AND `rtnID` = '0'  AND `chqBID` != '0' ");
										$rst_ownHand = $qry_ownHand->fetch_array();

										/*echo "SELECT SUM(`amount`) FROM `bank_deposit` WHERE `entryDate` <= '$to_d' 
				 AND `depositDate` > '$to_d' AND `br_id` = '$br_id' AND `venID` !='0' AND `rtnID` = '0' ";*/

										$credit += $rst_ownHand[0];
										$show_credt = $rst_ownHand[0];
										$sub_credt += $rst_ownHand[0];
										echo '<tr>
				<td > </td>
				<td > Own Cheque In Hand </td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format(0, 2) . '</td>
		
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';

										// journal liblilityis #####################################

										$qry_jnl_libli = $mysqli->query("SELECT `rep_bal`,journal.Description,journal.AccID,journal.br_id,
				 journal.ID  FROM journal  WHERE 
				  journal.AccountMode IN('LIABILITES', 'CURRENT LIABILITES', 'NON-CURRENT LIABILITES') AND `rep_bal` !='0' $br_jou OR journal.AccountMode IN('LIABILITIES', 'CURRENT LIABILITES', 'NON-CURRENT LIABILITES')
				  and `rep_bal` !='0' $br_jou  GROUP by journal.AccID  ");



										$count_libli = $qry_jnl_libli->num_rows;

										if ($count_libli > 0) {
											echo '
					<tr> <td colspan="4"> &nbsp; </td> </tr>
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > Journal Liabilites</th>
		
				 </tr>';
										}

										while ($exc_libli = $qry_jnl_libli->fetch_array()) {
											$jbr = $exc_libli['br_id'];

											/* $sqlBGbal_libli = $mysqli->query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE AccID='".$exc_libli[2]."' AND br_id ='$jbr' ");
					$bg_libli=$sqlBGbal_libli->fetch_array();
					
					
					$jexepensive= $exc_libli[0]+$bg_libli[0]+journal($exc_libli[4],$jbr,$to_d);*/

											$jexepensive = $exc_libli[0];
											// $tot_expensive +=$jexepensive;
											// $debit+=$jexepensive;

											//debit---
											$show_credt = 0;
											$show_debit = 0;
											if ($jexepensive > 0) {
												$debit += $jexepensive;
												$show_debit = $jexepensive;
												$sub_debit += $jexepensive;
											} else {
												$credit += (-1 * $jexepensive);
												$show_credt = (-1 * $jexepensive);
												$sub_credt += (-1 * $jexepensive);
											}

											if ($jexepensive != 0) {

												echo '<tr>
				<td > </td>
				<td >' . $exc_libli[1] . ' - ' . $jbr . ' </td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td  style="text-align:right; ' . $bg . '"> ' . number_format($show_credt, 2) . ' </td>
				 </tr>';
											}
										}



										// libility sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________

										echo '<tr>
				<th style="text-align: right; " >  </th>
				<th style="text-align: right; color:#D11518;" > Sub Total </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_debit, 2) . ' </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_credt, 2) . '</th>
				 </tr>';

										$sub_credt = 0;
										$sub_debit = 0;
										//  libility  sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________




										// expensive credit ------------------------------------------------------------------------------------	

										$tot_expensive = 0;
										echo '<tr>
				<th style="text-align:center;"> EXPENSES </th>
				<th colspan="3"> </th>
				 </tr>';



										$qry_purchase = $mysqli->query("SELECT SUM(`Total`) FROM `purchase` 
				 WHERE `Date` <= '$to_d' $br_where2 ");
										$exc_prchase = $qry_purchase->fetch_array();
										$prchase = $exc_prchase[0];
										//$tot_expensive +=$prchase;
										//$debit+=$prchase;

										//debit---
										$show_credt = 0;
										$show_debit = 0;
										if ($prchase > 0) {
											$debit += $prchase;
											$show_debit = $prchase;
											$sub_debit += $prchase;
										} else {
											$credit += (-1 * $prchase);
											$show_credt = (-1 * $prchase);
											$sub_credt += $prchase;
										}


										echo '<tr>
				<td > </td>
				<td > <a style="cursor:pointer; color:blue;" class="dayPurch" dayPurch = "BETWEEN \'' . $from_dd . '\' AND \' ' . $to_dd . '\'">Total Purchase </a></td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td style="text-align:right;' . $bg . '" > ' . number_format($show_credt, 2) . ' </td>
				 </tr>';





										// journal expe
										$qry_jnl_exepensive = $mysqli->query("SELECT `rep_bal` ,journal.Description,journal.AccID,journal.br_id,journal.ID
				   FROM journal  WHERE 
				 journal.AccountMode='EXPENSES' and `rep_bal` !='0'  $br_jou GROUP by journal.AccID  ");

										$count_exp = $qry_jnl_exepensive->num_rows;

										if ($count_exp > 0) {
											echo '
					<tr> <td colspan="4"> &nbsp; </td> </tr>
					
					
					<tr>
				<td >  </td>
				<th colspan="3" style="color:#5380E0;" > Journal Expenses</th>
		
				 </tr>';
										}

										while ($exc_jexepensive = $qry_jnl_exepensive->fetch_array()) {
											$jbr = $exc_jexepensive['br_id'];
											/*$sqlBGbal_jexepensive = $mysqli->query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE AccID='".$exc_jexepensive[2]."' AND br_id ='$jbr' ");
					$bg_jexepensive=$sqlBGbal_jexepensive->fetch_array();
					
					
					$jexepensive= $exc_jexepensive[0]+$bg_jexepensive[0]+journal($exc_jexepensive[4],$jbr,$to_d);*/

											$jexepensive = $exc_jexepensive[0];

											// $tot_expensive +=$jexepensive;
											// $debit+=$jexepensive;

											//debit---
											$show_credt = 0;
											$show_debit = 0;
											if ($jexepensive > 0) {
												$debit += $jexepensive;
												$show_debit = $jexepensive;
												$sub_debit += $jexepensive;
											} else {
												$credit += (-1 * $jexepensive);
												$show_credt = (-1 * $jexepensive);
												$sub_credt += (-1 * $jexepensive);
											}

											if ($jexepensive != 0) {
												echo '<tr>
				<td > </td>
				<td ><a href="#" style="color:blue;" class="banckJournal" banckJournalAttr="' . $exc_jexepensive['AccID'] . '" journalFrom="' . $from_dd . '" journalTo="' . $to_dd . '">' . $exc_jexepensive[1] . ' - ' . $jbr . ' </a></td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($show_debit, 2) . '</td>
				
				<td  style="text-align:right; ' . $bg . '"> ' . number_format($show_credt, 2) . ' </td>
				 </tr>';
											}
										}

										$sqlJentryComiOLDC = $mysqli->query("SELECT SUM(`Credit`)  FROM `jentry` 
                        								WHERE  Date <= '$to_d' $br_where2 AND jentry_delete != '1' AND 
                        								Bounced = 'Card' " . $showType . " ");
										$JentryComiOLDC = $sqlJentryComiOLDC->fetch_array();
										$sub_debit += $JentryComiOLDC[0];
										$debit += $JentryComiOLDC[0];

										echo '<tr>
				<td > </td>
				<td >Bank Charges </td>
				
				<td style="text-align:right; ' . $bg . '" > ' . number_format($JentryComiOLDC[0], 2) . '</td>
				
				<td  style="text-align:right; ' . $bg . '"> 0.00 </td>
				 </tr>';
										// expensive sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________

										echo '<tr>
				<th style="text-align: right;" >  </th>
				<th style="text-align: right; color:#D11518;" > Sub Total </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_debit, 2) . ' </th>
				<th style="text-align: right; color:#D11518;" > ' . number_format($sub_credt, 2) . '</th>
				 </tr>';

										$sub_credt = 0;
										$sub_debit = 0;
										//  expensive  sub total --------------------@@@@@@@@@@@@@@@@@@@@@@@@@@@@@_______________________

										// echo $debit .' d-c '.$credit;
										//Total ============----------------------------============================

										//$tot_credt=$tot_expensive+ $liblity;
										//$tot_debit=$tot_ass+ $tot_income;

										echo '<tr>
				<th style="text-align:right;  ' . $bg2 . '"  >  </th>
				<th style="text-align:right; ' . $bg2 . '"  > - Grand Total   </th>
				
				<th style="text-align:right;' . $bg2 . '" > ' . number_format($debit, 2) . '</th>
				
				<th style="text-align:right;' . $bg2 . '" > ' . number_format($credit, 2) . ' </th>
				 </tr>';

										//}
										//}
										?>
									</tbody>
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

			<script type="text/javascript">
				$('#tr_bal').click(function() {
					var vlu = $('#cus_id').val();
					var f_date = $('#from_d').val();
					var t_date = $('#to_d').val();
					//alert(vlu);
					//alert('' +invID);
					window.open("print/prnt_trial_bal.php?ITEM=" + vlu + "&FDATE=" + f_date + "&TDATE=" + f_date + "", "myWindowName", "width=595px, height=842px");
				});

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

				$(document).on('click', '#btn_save', function() {

					$(this).hide();
					var from_d = "<?php echo $from_d; ?>";
					var to_d = "<?php echo $to_d; ?>";
					$.ajax({
						url: '../satements/New_JournalReport.php',
						data: {
							'from_d': from_d,
							'to_d': to_d
						},
						type: 'get',
						dataType: '',
						success: function(data) {

							location.reload();

						}
					});
				});

				
			</script>

			<!--date picker files-->

			<?php include('AdminJava.php'); ?>