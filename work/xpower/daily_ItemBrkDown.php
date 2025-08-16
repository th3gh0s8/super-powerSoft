<?php
$title = 'Item Break Down Report';
include('includeFile.php');

$from_d	= urldecode($_GET['from_d']);
$to_d =  urldecode($_GET['to_d']);

$from_d = date_format(date_create($from_d), 'Y-m-d');
$to_d = date_format(date_create($to_d), 'Y-m-d');

$to_ddd = date('Y-m-d', strtotime('+1 day', strtotime($to_d)));

$from_x = DateTime::createFromFormat("Y-m-d", "$from_d");
$to_x = DateTime::createFromFormat("Y-m-d", "$to_ddd");

$periodInterval = new DateInterval("P1D"); // 1-day, though can be more sophisticated rule
$period = new DatePeriod($from_x, $periodInterval, $to_x);


$ItemNmm =  urldecode($_GET['ItemNm']);
if (urldecode($_GET['ItemNm']) != 'undefined') {
	$ItemNm = urldecode($_GET['ItemNm']);
	$ItemId =  urldecode($_GET['ItemId']);
}

$QuryOpenningStock = ''; $QuryOpenningStockinternal_itm = ''; $breakdownlocqry = ''; $internalaltrItemLocQry='';
if (isset($_GET['location'])) {
	$locationVal = $_GET['location'];
	if ($locationVal != "ViewAll" && $locationVal != 'undefined' && $locationVal != "hideLoc") {
	     
	    $qry_locaDet = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$locationVal' AND br_id='$br_id'");
		$locaDet = $qry_locaDet->fetch_array();
	    
	    if($locaDet['cloud'] == 'Main'){
	        $QuryOpenningStock = "AND itm_location IN('$locationVal', '')";
    		$QuryOpenningStockinternal_itm = "AND internal_itm.itm_location IN('$locationVal', '')";
    		$internalaltrItemLocQry = "AND internaltr_itm.itm_location IN('$locationVal', '')";
    		$breakdownlocqry = " AND location IN('$locationVal', '')";
	    }else{
	        $QuryOpenningStock = "AND itm_location = '$locationVal'";
    		$QuryOpenningStockinternal_itm = "AND internal_itm.itm_location = '$locationVal'";
    		$internalaltrItemLocQry = "AND internaltr_itm.itm_location = '$locationVal'";
    		$breakdownlocqry = " AND location = '$locationVal'";
	    }
		
	}
}

$reportPrnt = 'ItemSearchPnt';
$ItemSearch = 'ItemSearch';
$locationFilter = 'true';
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
		/* margin-top:-2.1111115898989789%; */

	}

	#ags3 {
		float: left;
		width: 50%;

	}

	#ags4 {
		float: right;
		width: 40%;
		margin-right: 10%;
		/* margin-top:-2.1111115898989789%; */

	}

	#ags5 {
		float: right;
		width: 20%;
		margin-right: 20%;
		/* margin-top:-2.1111115898989789%; */

	}


	#ags6 {
		float: left;
		width: 100%;
		/* margin-right:; */
		/* margin-top:-2.1111115898989789%; */

	}

	.controls {
		width: 60%;

	}

	.control-group {
		padding-left: 3%;
		padding-right: 3%;
		/* padding-top:;	 */


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
		/* background:#0066CC; */
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
		/* height: 34px; */
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
		/* height: 28px; */
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

	tfoot .tfootH:hover {
		background-color: #FFFF66;
	}
</style>




<?php include('daily_report_bar.php'); ?>

</br>

<div id="ajaxRespon" style="width:100%">
	<div id="remove_TTb">
	<input type="text" id="repFilter" placeholder="Filter by Rep" class="form-control" style="margin-bottom: 10px; width: 200px; float:right; margin-right:190px;">
		<table class="table table-striped table-bordered bootstrap-datatable responsive invoSumryTB breakdownSummaryTbl" style="margin-top:30px" ;>
			<thead>
				<tr>
					<th width="10%">Invoice No</th>
					<th width="10%">Ref No</th>
					<th width="10%">Date</th>
					<th width="10%">Time</th>
					<th>Customer / Vendor</th>
					<th>Note</th>
					<th>Good In</th>
					<th>Good Out</th>
					<th>Damage / Expired</th>
					<th>Sold Qty</th>
					<th>Sold Value</th>
					<th>Amount</th>
					<th>Status</th>
					<th>Rep</th>
					<th>Driver</th>
			</thead>
			<tbody>
				<?php
				if ($ItemId != '') {
					$sqlItemNo = $mysqli->query("SELECT ID, ItemNO FROM `itemtable` WHERE ItemNO = '$ItemId' ");
					$ItemNo = $sqlItemNo->fetch_array();
					//echo $ItemNo[0];

					$itmTb = $ItemNo[0];

					$itmTbId = $ItemNo[1];

					$sqlAManufOLD = $mysqli->query("SELECT SUM(`manufQty`) FROM `assigned_manufacture`
		 						WHERE  itmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date < '$from_d'");
					$AManufOLD = $sqlAManufOLD->fetch_array();

					$sqlASS_D_SManufOLD = $mysqli->query("SELECT SUM(qty) FROM `assemble_itm` 
		 						WHERE  AitmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date  < '$from_d' AND status ='DELIVERED' AND stock_status != 'Damage'");
					$ASS_D_ManufOLD = $sqlASS_D_SManufOLD->fetch_array();

					$sqlASS_R_SManufOLD = $mysqli->query("SELECT SUM(qty) FROM `assemble_itm` 
		 						WHERE  AitmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date   < '$from_d' AND status !='DELIVERED' AND stock_status != 'Damage'");
					$ASS_R_ManufOLD = $sqlASS_R_SManufOLD->fetch_array();
                    
                    $sqlASS_D_SManufOLD_damage = $mysqli->query("SELECT SUM(qty) FROM `assemble_itm` 
		 						WHERE  AitmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date  < '$from_d' AND status ='DELIVERED' AND stock_status = 'Damage'");
					$ASS_D_ManufOLD_damage = $sqlASS_D_SManufOLD_damage->fetch_array();

					$sqlASS_R_SManufOLD_damage = $mysqli->query("SELECT SUM(qty) FROM `assemble_itm` 
		 						WHERE  AitmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date   < '$from_d' AND status !='DELIVERED' AND stock_status = 'Damage'");
					$ASS_R_ManufOLD_damage = $sqlASS_R_SManufOLD_damage->fetch_array();
					
					$sqlTPuch = $mysqli->query("SELECT SUM(`QtyRcvd`) FROM `purchitem` 
			  						WHERE Date < '$from_d' AND itm_id = '$itmTb' AND br_id = '$br_id' AND Damaged ='Purchase' $QuryOpenningStock OR 
									 Date < '$from_d' AND itm_id = '$itmTb' AND br_id = '$br_id' AND Damaged = 'Exchange' $QuryOpenningStock");
					$TPuch = $sqlTPuch->fetch_array();

					$sqlTSales = $mysqli->query("SELECT  SUM(`Quantity`)  FROM `invitem` 
			  						WHERE Date < '$from_d' AND itemID = '$itmTb' AND br_id = '$br_id' AND itmType != 'Damaged' 
									AND itmType != 'Expired' $QuryOpenningStock ");
					$TSales = $sqlTSales->fetch_array();

					$sqlTPuchD = $mysqli->query("SELECT SUM(`QtyRcvd`) FROM `purchitem` 
			  						WHERE Date < '$from_d' AND itm_id = '$itmTb' AND br_id = '$br_id' AND Damaged ='Damaged' $QuryOpenningStock OR 
									 Date < '$from_d' AND itm_id = '$itmTb' AND br_id = '$br_id' AND Damaged = 'Expired' $QuryOpenningStock");
					$TPuchD = $sqlTPuchD->fetch_array();

					$sqlTSalesD = $mysqli->query("SELECT  SUM(-1*Quantity)  FROM `invitem` 
			  						WHERE Date < '$from_d' AND itemID = '$itmTb' AND br_id = '$br_id' AND itmType = 'Damaged' $QuryOpenningStock");
					$TSalesD = $sqlTSalesD->fetch_array();
					
					$sqlTSalesE = $mysqli->query("SELECT  SUM(-1*Quantity)  FROM `invitem` 
			  						WHERE Date < '$from_d' AND itemID = '$itmTb' AND br_id = '$br_id' AND itmType = 'Expired' $QuryOpenningStock");
					$TSalesE = $sqlTSalesE->fetch_array();

					$sqlBfBegining = $mysqli->query("SELECT  SUM(`NewQty`), SUM(`damageQty`), SUM(`expiredQty`) FROM `begitems` 
									WHERE `Date` < '$from_d'  AND ItemID = '$ItemNo[0]' AND br_id = '$br_id' $QuryOpenningStock");
                    
					$sqlTransbIN = $mysqli->query("SELECT SUM(internaltr_itm.qty) FROM `internal` 
					                    JOIN internaltr_itm ON internal.ID = internaltr_itm.internalID
			  							WHERE internaltr_itm.itmID = '$ItemNo[0]' AND R_Date < '$from_d' AND toBr ='$br_id' AND internaltr_itm.t_itmType IN ('','Issue','Exchange') $internalaltrItemLocQry");
					$TransbIN = $sqlTransbIN->fetch_array(); //frmBr

					/*$sqlTransbOUT = $mysqli->query("SELECT SUM(internaltr_itm.qty) FROM `internal` JOIN internaltr_itm 
			  							ON internal.ID = internaltr_itm.internalID 
			  							WHERE internaltr_itm.itmID = '$ItemNo[0]' AND R_Date < '$from_d' AND frmBr ='$br_id' AND internaltr_itm.t_itmType IN ('','Issue','Exchange') $internalaltrItemLocQry");
			  		$sqlTransbOUT = $mysqli->query("SELECT SUM(latest_record.qty) FROM `internal_itm`
											JOIN (
                                                SELECT internalID, MAX(R_Date) AS max_R_Date, br_id, internaltr_itm.qty
                                                FROM internaltr_itm
                                                GROUP BY internalID
                                            ) AS latest_record ON internal_itm.internalID = latest_record.internalID
    			  							WHERE internal_itm.itmID = '$ItemNo[0]' AND max_R_Date < '$from_d' AND internal_itm.br_id ='$br_id' $QuryOpenningStockinternal_itm");*/
			  		$sqlTransbOUT = $mysqli->query("SELECT SUM(internaltr_itm.qty) FROM `internaltr_itm` JOIN (
                                                SELECT internal_itm.internalID, br_id, internal_itm.itmID, itm_location
                                                FROM internal_itm
                                                GROUP BY internal_itm.internalID
                                            ) AS internal_itm ON internaltr_itm.internalID = internal_itm.internalID
											JOIN internal ON internal.ID = internaltr_itm.internalID
    			  							WHERE internaltr_itm.itmID = '$ItemNo[0]' AND R_Date < '$from_d' AND internal.frmBr ='$br_id' $QuryOpenningStockinternal_itm");
			  							
					$TransbOUT = $sqlTransbOUT->fetch_array();

					$qrybg_str_in = $mysqli->query("SELECT  sum(`Quantity`) FROM `stk_dlv_item` JOIN stk_dlv ON
					   `stk_dlv_item`.`deliver_id`=stk_dlv.ID
			    WHERE `ItemNo`='$ItemId' AND stk_dlv.inv_br_id='$br_id' AND `stk_dlv_item`.`Date` < '$from_d'  ");
					$bg_str_in = $qrybg_str_in->fetch_array();

					$qrybg_str_out = $mysqli->query("SELECT  sum(`Quantity`) FROM `stk_dlv_item` JOIN stk_dlv ON `stk_dlv_item`.`deliver_id`=stk_dlv.ID 
			    WHERE `ItemNo`='$ItemId' AND stk_dlv.br_id='$br_id' AND `stk_dlv`.`dlv_date` < '$from_d' ");

					$excbg_str_out = $qrybg_str_out->fetch_array();

					$BfBegining = $sqlBfBegining->fetch_array();
					
					$sql_locationTransfersIN = $mysqli->query("SELECT SUM(in_qty) FROM `itm_break_down` WHERE itm_id = '$ItemNo[0]' AND date < '$from_d' 
					                                            AND formName = 'Location Transfer' AND br_id = '$br_id' $breakdownlocqry");
                    $loctrin = $sql_locationTransfersIN->fetch_array();

                    $sql_locationTransfersout = $mysqli->query("SELECT SUM(out_qty) FROM `itm_break_down` WHERE itm_id = '$ItemNo[0]' AND date < '$from_d' 
					                                            AND formName = 'Location Transfer' AND br_id = '$br_id' $breakdownlocqry");
                    $loctrout = $sql_locationTransfersout->fetch_array();
					
					$OpeningBE = ($BfBegining[1] + $BfBegining[2] + $TSalesD[0] + $TSalesE[0]) + $TPuchD[0] - $ASS_D_ManufOLD_damage[0] + $ASS_R_ManufOLD_damage[0];
					$Opening = $TPuch[0] + $BfBegining[0] - $TSales[0] - $TransbOUT[0] + $TransbIN[0] + $AManufOLD[0] - $ASS_D_ManufOLD[0] + $ASS_R_ManufOLD[0] - $excbg_str_out[0] + $bg_str_in[0] - $loctrout[0] + $loctrin[0];


					echo '
					<tr>
						<td style="text-align:left; font-weight:bold; "  colspan="5">Item &nbsp;-' . $ItemId . ' - ' . $ItemNm . '</td>
						<td style="text-align:right;"  colspan="3">Damage+Expired Stock</td>
						<td style="text-align:right;font-weight:bold; ">' . number_format($OpeningBE, 2) . '</td>
						<td style="text-align:right;"  colspan="3">Opening Stock</td>
						<td style="text-align:right;font-weight:bold;" class="Opening_Stock">' . number_format($Opening, 2) . '</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';



					//echo'asas';
					//==============================================================================================================================
					$totSTR_in = 0;
					$totSTR_out = 0;
					$TsaleOut2 = 0;
					$Bgstckothr2 = 0;
					$tINPH = 0;
					$ATmanuIN = 0;
					$tOUTPH = 0;
					$tDamgedPH = 0;

					$TtrOUT = 0;
					$TtrIN = 0;
					
					$TmanuOUT = 0;$TmanuIN=0;
                    $TmanuOUTD = 0;$TmanuIND=0;
                    
					$TsaleIn = 0;
					$TsaleOthr = 0;
					$TsaleOut = 0;
					$saleValue = 0;
					$totAmountSum = 0;

					$Bgstckothr = 0;
					$Bgstck = 0;
					
					$Tcount = 0;
					// date looop ###############################$

					foreach ($period as $date) { //DAY LOOP
						//echo $date->format("Y-m-d") , PHP_EOL.'</br>';
						$dateBy  = $date->format("Y-m-d");


						$sqlBegining = $mysqli->query("SELECT `NewQty`,`damageQty`,`expiredQty`,Date,`recodeTime`, remarks, itm_location FROM `begitems` 
									WHERE `Date`  ='$dateBy'   AND ItemID = '$ItemNo[0]' AND br_id = '$br_id' $QuryOpenningStock");
						$Bqty1 = 0;
						$Bqty2 = 0;
						
						while ($Begining = $sqlBegining->fetch_array()) {

							$qry_location2 = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$Begining[itm_location]' AND br_id='$br_id'");
							$locti2 = $qry_location2->fetch_array();

							//if($Begining[0] > 0 ){
							$Bqty1 = $Begining[0];
							$BSalesType = 'Begining Stock';
							$Bqty2 = $Begining[1] + $Begining[2];
							//}

							echo '
					<tr>
						<td></td>
						<td>' . $locti2['name'] . '</td>
						<td>' . $Begining[3] . '</td>
						<td>' . $Begining[4] . '</td>
						<td style="text-align:left;">Beginning Stock</td>
						<td style="text-align:left;">' . $Begining['remarks'] . '</td>
						<td style="text-align:right;" class="good_in">' . number_format($Bqty1, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format($Bqty2, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">Beginning Stock</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
							$Bgstck += $Bqty1;
							$Bgstckothr += $Bqty2;
						}



						//========================= stock ajaustment =====================================================================						
						$sqlajust = $mysqli->query("SELECT  `itm_id`, `itm_code`, `stk`, `damaged`, `expired`, `recordDate`, `br_id`,
			   (`damaged` +`expired`) as 'tot_demage' FROM 
			  `stock_ajust_tb` WHERE `itm_code` ='$ItemId' AND `br_id`='$br_id' AND recordDate  ='$dateBy'   ");

						while ($ajust = $sqlajust->fetch_array()) {


							echo '
					<tr>
						<td></td>
						<td></td>
						<td>' . $ajust['recordDate'] . '</td>
						<td style="text-align:left;"></td>
						<td style="text-align:left;"  colspan="2">-</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;" class="good_in">' . number_format($ajust['stk'], 2) . '</td>
						<td style="text-align:right;">' . number_format($ajust['tot_demage'], 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">Adjustment</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
							$TsaleOut2 += $ajust['stk'];
							$Bgstckothr2 += $ajust['tot_demage'];
						}


                        if ($user_type != 'Admin') {
                            $cost_rht = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
                        				 `user_id` ='$user_id' AND `page_title` ='control_Show Cost' AND `user_rights`.`br_id`='$br_id'");
                            $count_cost_rht = $cost_rht->num_rows;
                        } else {
                            $count_cost_rht = '1';
                        }

						//=============================================================================================================================						
						$sqlPuch = $mysqli->query("SELECT `P_No`, `RefNo`, `Date`, `ItemNo`,`QtyRcvd`, `VendID`,Damaged,Nprice, imeis, ItemMark, itm_location FROM `purchitem` 
			  						WHERE Date  ='$dateBy' AND ItemNo = '$itmTbId' AND br_id = '$br_id'  $QuryOpenningStock");
                        
						//$Puch[4] = 0;
						while ($Puch = $sqlPuch->fetch_array()) {

							$sqlVndrNm = $mysqli->query("SELECT `CompanyName` FROM `vendor` WHERE `ID` = '$Puch[5]' ");
							$VndrNm = $sqlVndrNm->fetch_array();

							$sqlPurTime = $mysqli->query("SELECT  `recordTime`, dscrpn_note FROM `purchase` WHERE `P_No`='$Puch[0]' and `br_id`='$br_id'");
							$PurTime = $sqlPurTime->fetch_array();

							$descriptionNote = $PurTime['dscrpn_note'] == '' ? '' : ' - ' . $PurTime['dscrpn_note'];
							if($count_cost_rht == 1){
							    $price = $Puch['Nprice'];
							}else{
							    $price = '-';
							}
							

							$qry_location2 = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$Puch[itm_location]' AND br_id='$br_id'");
							$locti2 = $qry_location2->fetch_array();

							if ($Puch['Damaged'] == 'Purchase') {
								echo '
					<tr>
						<td><a class="click_purch_dtls" value="'.$Puch[0].'" style="color:blue; cursor:pointer;">' . $Puch[0] . '</a></td>
						<td>' . $Puch[1] . ' ' . $Puch['imeis'] . ' ' . $locti2['name'] . '</td>
						<td>' . $Puch[2] . '</td>
						<td>' . date('H:i:s', strtotime($PurTime[0])) . '</td>
						<td style="text-align:left;">' . $VndrNm[0] . '</td>
						<td style="text-align:left;">' . $Puch['ItemMark'] . ' '.$Puch['itm_location'].' ' . $descriptionNote . '</td>
						<td style="text-align:right;" class="good_in">' . number_format($Puch['QtyRcvd'], 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format($price, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">Purchase</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
								$tINPH += $Puch['QtyRcvd'];
							} elseif ($Puch['Damaged'] == 'Exchange') {
								echo '
					<tr>
						<td>' . $Puch[0] . '</td>
						<td>' . $Puch[1] . ' ' . $Puch['imeis'] . ' ' . $locti2['name'] . '</td>
						<td>' . $Puch[2] . '</td>
						<td>' . date('H:i:s', strtotime($PurTime[0])) . '</td>
						<td style="text-align:left;">' . $VndrNm[0] . '</td>
						<td style="text-align:left;">' . $Puch['ItemMark'] . ' '.$Puch['itm_location'].' ' . $descriptionNote . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;" class="good_out">' . number_format(abs($Puch[4]), 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format($price, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">Purchase RTN</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
								$tOUTPH += $Puch[4];
								//	echo $tOUTPH.'fafa';
							} else {
								echo '
					<tr>
						<td>' . $Puch[0] . '</td>
						<td>' . $Puch[1] . ' ' . $Puch['imeis'] . ' ' . $locti2['name'] . '</td>
						<td>' . $Puch[2] . '</td>
						<td>' . date('H:i:s', strtotime($PurTime[0])) . '</td>
						<td style="text-align:left;">' . $VndrNm[0] . '</td>
						<td style="text-align:left;">' . $Puch['ItemMark'] . ' ' . $descriptionNote . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format($Puch[4], 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format($price, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">Purchese (' . $Puch['Damaged'] . ')</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
								$tDamgedPH += $Puch[4];
							}
						}
						// echo $tINPH.'----</br>';
						//=============================================================================================================================						
						$sqlTrans = $mysqli->query("SELECT intnl_No, internaltr_itm.qty as totqty, `frmBr`, `toBr`,`R_Date`,
						internaltr_itm.itmID,recdTime,internal.ID, internal_itm.itm_location as trLoc, internaltr_itm.itm_location as atLoc, internal.driverNm
						            FROM `internal` 
						            JOIN internaltr_itm ON internal.ID = internaltr_itm.internalID
						            LEFT JOIN internal_itm ON internal.ID = internal_itm.internalID
			  						WHERE internaltr_itm.itmID = '$ItemNo[0]' AND internaltr_itm.R_Date  ='$dateBy' 
			  						AND (frmBr = '$br_id' $QuryOpenningStockinternal_itm || toBr = '$br_id' $internalaltrItemLocQry)
			  						AND internaltr_itm.t_itmType IN ('','Issue','Exchange') GROUP BY internaltr_itm.ID");

						while ($Trans = $sqlTrans->fetch_array()) {
							$trOUT = 0;
							$trIN = 0;
							if ($Trans['frmBr'] == $br_id) {
								$sql_brnch1 = $mysqli->query("SELECT name FROM com_brnches  WHERE ID = '$Trans[toBr]'");
								$res_brnch1 = $sql_brnch1->fetch_array();
								$trOUT = $Trans['totqty'];
								$topic = 'Transfer to ' . $res_brnch1[0];
								$TtrOUT += $trOUT;
								$type = 'Transfer';
								
								$qry_location2 = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$Trans[trLoc]' AND br_id='$br_id'");
							    $locti2 = $qry_location2->fetch_array();
							} elseif ($Trans['toBr'] == $br_id) {
								$sql_brnch2 = $mysqli->query("SELECT name FROM com_brnches  WHERE ID = '$Trans[frmBr]'");
								$res_brnch2 = $sql_brnch2->fetch_array();
								$trIN = $Trans['totqty'];
								$topic = 'Transfer From ' . $res_brnch2[0];
								$TtrIN += $trIN;
								$type = 'Attachment';
								
								$qry_location2 = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$Trans[atLoc]' AND br_id='$br_id'");
							    $locti2 = $qry_location2->fetch_array();
							}

							$qry_trPr = $mysqli->query("select *  from internal_itm where internalID='" . $Trans['ID'] . "' 
				  and itmNo  = '$ItemId'  ");
							$rst_trPr = $qry_trPr->fetch_array();
							
							$trPrice = $rst_trPr['price'];

							echo '
					<tr>
						<td>' . $Trans[0] . '</td>
						<td>'.$locti2['name'].'</td>
						<td>' . $Trans['R_Date'] . '</td>
						<td>' . date('H:i:s', strtotime($Trans['recdTime'])) . '</td>
						<td style="text-align:left;" colspan="2">' . $topic . '</td>
						<td style="text-align:right;" class="good_in">' . number_format($trIN, 2) . '</td>
						<td style="text-align:right;" class="good_out">' . number_format($trOUT, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format($trPrice, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">' . $type . '</td>
						<td style="text-align:left;"></td>
						<td>'.$Trans['driverNm'].'</td>

					</tr>';
							//$tPH += $Puch[4];
						}
                        
                        
						//Assamble Item=============================================================================================================================	
						 $manuDamage = '0';
						$sqlManuf = $mysqli->query("SELECT qty,Date,status,manuTbID,rTime, stock_status FROM `assemble_itm` 
		 						WHERE  AitmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date  ='$dateBy'");
						while ($Manuf = $sqlManuf->fetch_array()) {
							$manuIN = 0;
							$manuOUT = 0;

							if ($Manuf['status']  == 'DELIVERED') {
								$getBatch = $mysqli->query("SELECT `batchNo` FROM `manufacture_itm` WHERE ID = '$Manuf[manuTbID]' AND `br_id` = '$br_id'");
								$Batch = $getBatch->fetch_array();
								
								if($Manuf['stock_status'] == 'Damage'){
								    $manuDamage = $Manuf[0];
								    $TmanuOUTD -= $Manuf[0];
								    
								}else{
								    $manuOUT = $Manuf[0];
								    $TmanuOUT += $Manuf[0];
								}
								
								$type = 'Manuf. Deliver';
								
								$topic = 'Issued for Manufacture';
								$ID = $Batch[0];
							} else {
								$getBatch2 = $mysqli->query("SELECT `batchNo` FROM `manufacture_itm` 
					 						WHERE ID  = (SELECT `rtnID` FROM `manufacture_itm` WHERE ID = '$Manuf[manuTbID]' AND `br_id` = '$br_id')");
								$Batch = $getBatch2->fetch_array();
								
								if($Manuf['stock_status'] == 'Damage'){
								    $manuDamage = $Manuf[0];
								    $TmanuIND -= $Manuf[0];
								    
								}else{
								    $manuIN = $Manuf[0];
								    $TmanuIN += $Manuf[0];
								}
								
								$type = 'Manuf. Return';
								
								$topic = 'Manufacture Item Return';
								$ID = $Batch[0];
							}



							echo '<tr>
						<td></td>
						<td>' . $ID . '</td>
						<td>' . $Manuf['Date'] . '</td>
						<td>' . date('H:i:s', strtotime($Manuf['rTime'])) . '</td>
						<td style="text-align:left;" colspan="2">' . $topic . '</td>
						<td style="text-align:right;" class="good_in">' . number_format($manuIN, 2) . '</td>
						<td style="text-align:right;" class="good_out">' . number_format($manuOUT, 2) . '</td>
						<td style="text-align:right;">' . number_format($manuDamage, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">' . $type . ' '.$Manuf['stock_status'].'</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
						}

						//Manuf.Assigned Item ====================================================================================================	
						// $TmanuOUT = 0;$TmanuIN=0;
						
						$sqlAManuf = $mysqli->query("SELECT `manufQty`  , `manuTbID`, Date,rTime FROM `assigned_manufacture`
		 						WHERE  itmID = '$ItemNo[0]' AND br_id = '$br_id'  AND Date ='$dateBy'");
						while ($Manuf = $sqlAManuf->fetch_array()) {
							//$manuIN = 0;$manuOUT=0;
							$getBatch = $mysqli->query("SELECT `batchNo` FROM `manufacture_itm` WHERE ID = '$Manuf[manuTbID]' AND `br_id` = '$br_id'");
							$Batch = $getBatch->fetch_array();
							$AmanuIN = $Manuf[0];
							$type = 'Build Item';
							$ATmanuIN += $Manuf[0];
							$topic = 'Manuf. Completed Item ';
							$ID = $Batch[0];



							echo '<tr>
						<td></td>
						<td>' . $ID . '</td>
						<td>' . $Manuf['Date'] . '</td>
						<td>' . date('H:i:s', strtotime($Manuf['rTime'])) . '</td>
						<td style="text-align:left;"  colspan="2">' . $topic . '</td>
						<td style="text-align:right;" class="good_in">' . number_format($AmanuIN, 2) . '</td>
						<td style="text-align:right;" class="good_out">' . number_format($xx, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;"></td>
						<td style="text-align:left;">' . $type . '</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
						}
						//===========================================================================================================================================

						//=============================================================================================================================				 
						
						$sqlSales = $mysqli->query("SELECT  `InvNo`, `Date`, `Quantity`,  `Sprice`, `DiscPrcnt`, `DiscValue`, `itmType`,Pass, repTbID2, cusTbID2, warrenty, invID, itm_location, diff_inv, Unit  FROM `invitem` 
			  						WHERE Date  ='$dateBy'  AND itemID = '$itmTb' AND br_id = '$br_id' $QuryOpenningStock");
						while ($Sales = $sqlSales->fetch_array()) {
							/*$sqlCusNm = $mysqli->query("SELECT `cusName` ,invType,`invoice`.`Time`,`invoice`.`repTbID` 
						FROM custtable JOIN invoice ON custtable.`ID` = invoice.`cusTbID`  
												WHERE InvNO ='$Sales[0]' AND invoice.br_id = '$br_id'");
						$CusNm = mysql_fetch_array($sqlCusNm);*/

							$sqlCusNm = $mysqli->query("SELECT `cusName` FROM custtable WHERE ID ='$Sales[cusTbID2]'");
							$CusNm = $sqlCusNm->fetch_array();

							$dlvBr = $Sales['Pass'];
							$store = '';
							if ($dlvBr != '') {

								if ($dlvBr != $br_id) {
									$store = 'Other branch';
								}
							}

							$sql_invoiceDet = $mysqli->query("SELECT Location, NowTime FROM invoice WHERE ID ='$Sales[invID]' AND invoice.br_id = '$br_id'");
							$invoiceDet = $sql_invoiceDet->fetch_array();
							$invDescription = $invoiceDet['Location'] == '' ? '' : ' - ' . $invoiceDet['Location'];

							$qry_rep = $mysqli->query("SELECT `Name` FROM `salesrep` WHERE `ID`='$Sales[repTbID2]'");
							$RepNM = $qry_rep->fetch_array();
                            
                            if($Sales['diff_inv'] != 1){
                                $qty_second_unit = $Sales[2]*$Sales['diff_inv']." ".$Sales['Unit'];
                            }else{
                                $qty_second_unit = '';
                            }
							$qty1 = 0;
							$qty2 = 0;
							$cout = 0;
							$value = 0;
							$qty3 = 0;
							if ($Sales[6] != '') {
								if ($Sales[6] == 'Damaged' || $Sales[6] == 'Expired') {
									$qty1 = -$Sales[2];
									$SalesType = ($Sales[6] == 'Damaged') ? 'Return Damage' : 'Return Expired';
								} else {
									if ($Sales[6] == 'Exchange') {
										$qty3 = $Sales[2];
										$value = $Sales[3];
										$cout = 1;
										$SalesType = 'Return Exchange';
									} else {
										$qty3 =  $Sales[2];
										$value = $Sales[3];
										$cout = 1;
										$SalesType = 'Return Issue';
									}
								}
							} else {
								$qty3 = $Sales[2];
								$SalesType = 'Invoice';
								$value = $Sales[3];
								$cout = 1;
							}
							$cout = $qty3;
							$toamn = $value * $qty3;

							$qry_location2 = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$Sales[itm_location]' AND br_id='$br_id'");
							$locti2 = $qry_location2->fetch_array();

							echo '
					<tr>
						<td><a style="color:blue; cursor:pointer;" class="click_invDetail" value="' . $Sales[0] . '">' . $Sales[0] . '</a></td>
						<td>' . $store . ' ' . $locti2['name'] . '</td>
						<td>' . $Sales[1] . '</td>
						<td>'.$invoiceDet['NowTime'].'</td>
						<td style="text-align:left;">' . $CusNm[0] . '</td>
						<td style="text-align:left;">' . $Sales['warrenty'] . ' ' . $invDescription . '</td>
						<td style="text-align:right;">' . number_format($qty2, 2) . '</td>
						<td style="text-align:right;">'.$qty_second_unit.'</td>
						<td style="text-align:right;">' . number_format($qty1, 2) . '</td>
						<td style="text-align:right;" class="good_out">' . number_format($qty3, 2) . '</td>
						<td style="text-align:right;">' . number_format($value, 2) . '</td>
						<td style="text-align:right;">' . number_format($toamn, 2) . '</td>
						<td style="text-align:left;">' . $SalesType . '</td>
						<td style="text-align:left;">' . $RepNM[0] . '</td>
						<td></td>
					</tr>';


							$TsaleIn += $qty2;
							$TsaleOthr += $qty1;
							$TsaleOut += $qty3;
							$saleValue += $toamn;
							$Tcount += $cout;
							$totAmountSum += $toamn;
						}


						// store delivery Start -----------------------------------------------------------------------------


						$qry_str_in = $mysqli->query("SELECT  `Quantity`,`stk_dlv_item`.`deliver_id`,`stk_dlv`.`dlv_date`,`stk_dlv_item`.`InvNo`
			  ,`stk_dlv`.CusID,`stk_dlv`.`record_time` FROM `stk_dlv_item` JOIN stk_dlv ON `stk_dlv_item`.`deliver_id`=stk_dlv.ID 
			    WHERE `ItemNo`='$ItemId' AND stk_dlv.inv_br_id='$br_id' AND `stk_dlv_item`.`Date`='$dateBy' ");
						while ($exc_str_in = $qry_str_in->fetch_array()) {
							$CusNO2 = $exc_str_in['CusID'];
							$dlv_qty = $exc_str_in['Quantity'];
							$SalesType = 'Stock transfer from store';

							echo '
					<tr>
						<td></td>
						<td>' . $exc_str_in['deliver_id'] . '</td>
						<td>' . $exc_str_in['dlv_date'] . '</td>
						<td>' . date('H:i:s', strtotime($exc_str_in['record_time'])) . '</td>
						<td style="text-align:left;" colspan="2">' . CusName($CusNO2) . '</td>
						<td style="text-align:right;" class="good_in">' . number_format($dlv_qty, 2) . '</td>
						<td style="text-align:right;"></td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:left;">' . $SalesType . '</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
							$totSTR_in += $dlv_qty;
						}


						$qry_str_out = $mysqli->query("SELECT  `Quantity`,`stk_dlv_item`.`deliver_id`,`stk_dlv`.`dlv_date`,`stk_dlv_item`.`InvNo`
			  ,`stk_dlv`.CusID,`stk_dlv`.`record_time` FROM `stk_dlv_item` JOIN stk_dlv ON `stk_dlv_item`.`deliver_id`=stk_dlv.ID 
			    WHERE `ItemNo`='$ItemId' AND stk_dlv.br_id='$br_id' AND `stk_dlv`.`dlv_date`='$dateBy' ");

						while ($exc_str_out = $qry_str_out->fetch_array()) {
							$CusNO2 = $exc_str_out['CusID'];
							$dlv_qty2 = $exc_str_out['Quantity'];
							$SalesType = 'Store item delivery';

							echo '
					<tr>
						<td>' . $exc_str_out['InvNo'] . '</td>
						<td>' . $exc_str_out['deliver_id'] . '</td>
						<td>' . $exc_str_out['dlv_date'] . '</td>
						<td>' . date('H:i:s', strtotime($exc_str_out['record_time'])) . '</td>
						<td style="text-align:left;" colspan="2">' . CusName($CusNO2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;" class="good_out">' . number_format($dlv_qty2, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:right;">' . number_format(0, 2) . '</td>
						<td style="text-align:left;">' . $SalesType . '</td>
						<td style="text-align:left;"></td>
						<td></td>
					</tr>';
							$totSTR_out += $dlv_qty2;
						}
						if($locationVal != 'hideLoc'){
							$sql_locationTransfers = $mysqli->query("SELECT ref_no, in_qty, out_qty, sales_pr, cost_pr, location, remarks, date, recordTime FROM `itm_break_down` WHERE itm_id = '$itmTb' AND date = '$dateBy' AND formName = 'Location Transfer' AND br_id = '$br_id' $breakdownlocqry");

							while ($locationTransfers = $sql_locationTransfers->fetch_array()) {
								$SalesType = 'Location Transfers';
								
								$qry_location2 = $mysqli->query("SELECT `location`,`name`, cloud FROM `itm_location` WHERE location = '$locationTransfers[location]' AND br_id='$br_id'");
								$locti2 = $qry_location2->fetch_array();
								
								$soldQty = $locationTransfers['in_qty'] == 0? $locationTransfers['out_qty']: $locationTransfers['in_qty'];
								echo '
						<tr>
							<td>' . $locationTransfers['ref_no'] . '</td>
							<td>' . $locti2['name'] . '</td>
							<td>' . $locationTransfers['date'] . '</td>
							<td>' . date('H:i:s', strtotime($locationTransfers['recordTime'])) . '</td>
							<td style="text-align:left;" colspan="2">' . $locationTransfers['remarks'] . '</td>
							<td style="text-align:right;" class="good_in">' . number_format($locationTransfers['in_qty'], 2) . '</td>
							<td style="text-align:right;" class="good_out">' . number_format($locationTransfers['out_qty'], 2) . '</td>
							<td style="text-align:right;">' . number_format(0, 2) . '</td>
							<td style="text-align:right;">' . number_format($soldQty, 2) . '</td>
							<td style="text-align:right;">' . number_format($locationTransfers['sales_pr'], 2) . '</td>
							<td style="text-align:right;">' . number_format($soldQty*$locationTransfers['sales_pr'], 2) . '</td>
							<td style="text-align:left;">' . $SalesType . '</td>
							<td style="text-align:left;"></td>
							<td></td>
						</tr>';
								$totSTR_out += $locationTransfers['out_qty'];
								$totSTR_in += $locationTransfers['in_qty'];
							}
						}
				    
						
					} /// end date loop


					//============================================================================================================================

					$sqlOdrItem = $mysqli->query("SELECT SUM(`qty`) FROM `order_item` JOIN order_tb ON order_item.order_id = order_tb.order_id
			  							WHERE item_no = '$ItemId' AND order_item.br_id = '$br_id' AND order_tb.cloud != 'DELETED'");
					$OdrItem = $sqlOdrItem->fetch_array();

					$sqlNwItem = $mysqli->query("SELECT SUM(`d_qty`) FROM `nw_qty_tb` WHERE itm_no = '$ItemId' AND br_id = '$br_id' ");
					$NwItem  = $sqlNwItem->fetch_array();
					$TotodrQyt  = $OdrItem[0] - $NwItem[0];

					$sqlTranssck = $mysqli->query("SELECT  SUM(qty) FROM `internal` JOIN internal_itm 
			  							ON internal.ID = internal_itm.internalID WHERE itmID = '$ItemNo[0]' 
										AND frmBr = '$br_id' $QuryOpenningStockinternal_itm");
					$Transsck  = $sqlTranssck->fetch_array();
					$sqlNwTranssck = $mysqli->query("SELECT SUM(internaltr_itm.qty) FROM `internaltr_itm` JOIN (
                                                SELECT internal_itm.internalID, br_id, internal_itm.itmID, itm_location
                                                FROM internal_itm
                                                GROUP BY internal_itm.internalID
                                            ) AS internal_itm ON internaltr_itm.internalID = internal_itm.internalID
											JOIN internal ON internal.ID = internaltr_itm.internalID
    			  							WHERE internaltr_itm.itmID = '$ItemNo[0]' AND internal.frmBr ='$br_id' $QuryOpenningStockinternal_itm");
					$NwTranssck  = $sqlNwTranssck->fetch_array();
					$TotTrnsQyt = $Transsck[0] - $NwTranssck[0];

					echo '  </tbody>';
					$TcountT = ($Tcount == 0) ? 1 : $Tcount;
					//$totActualStck = ($totActualStck != 0) ? $totActualStck : 0.00;
					$totActualStck = 0.00;
					$TotIN = $TsaleIn + $tINPH + $Bgstck + $TtrIN + $totSTR_in + $TmanuIN + $ATmanuIN;
					$TotOUT = $TsaleOut;
					$TotTrans = $TtrOUT + $TsaleOut2 + $totSTR_out + $TmanuOUT + abs($tOUTPH);
					$valueTot = $saleValue / $TcountT;
					$TotOthr = $TsaleOthr + $Bgstckothr + $Bgstckothr2 + $tDamgedPH + $TmanuOUTD + $TmanuIND;
					$EndINg = $Opening + $TotIN - $TotOUT - $TotTrans;
					$Actual =  $EndINg - $TotodrQyt - $TotTrnsQyt;
                
					echo '<tfoot class ="tfootH">
							<tr bgcolor="#DFD">	
								<td style="text-align:right;" colspan="6">Total</td>
								<td style="text-align:right;font-weight:bold; ">' . number_format($TotIN, 2) . '</td>
								<td style="text-align:right;font-weight:bold; ">' . number_format($TotTrans, 2) . '</td>
								<td style="text-align:right;font-weight:bold; ">' . number_format($TotOthr, 2) . '</td>
								<td style="text-align:right;font-weight:bold; ">' . number_format($TotOUT, 2) . '</td>
								<td style="text-align:right;"></td>
								<td style="text-align:right;font-weight:bold;color:red;">' . number_format($totAmountSum, 2) . '</td>
								<td style=" font-weight:bold; text-align:right;">' . number_format(($TotIN + $TotTrans - $TotOUT), 2) . '</td>
								<td style="text-align:left;"></td>
								<td></td>
								<td></td>
								
							</tr>
							<tr bgcolor="#FFFF66"  >		
								<td style="text-align:right;" colspan="3">Average Sales Price</td>
								<td style="text-align:right;">' . number_format($valueTot, 2) . '</td>
								<td style="text-align:right;" colspan="2">Reserve Transfer Stock</td>
								<td style="text-align:right;cursor:pointer; color: blue;" class="reserveStock" itmtb="'.$ItemNo[0].'" itmlocation="'.$locationVal.'">' . number_format($TotTrnsQyt, 2) . '</td>
								<td style="text-align:right;">Reserve Order Stock</td>
								<td style="text-align:right;">' . number_format($TotodrQyt, 2) . '</td>
								<td style="text-align:right;">Actual Stock</td>
								<td style="text-align:right;">' . number_format($Actual, 2) . '</td>
								<td style="text-align:right;">Ending Stock</td>
								<td style="font-weight:bold; text-align:right;">' . number_format($EndINg, 2) . '</td>
								<td style="text-align:left;"></td>
								<td></td>
								<td></td>
																
							</tr>	
								
					</tfoot>';
				}
				?>
		</table>
	</div>
</div>
</div>
</div>
</div>

<!--/span-->
<?php //echo $Opening.'-'.$TotIN.'-'.$TotOUT.'-'.$Bgstck; 
?>


<div class="box-content" align="center">
	<ul class="ajax-loaders" style="display:none">
		<li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>
	</ul>
</div>



	<!-- ajax content load -->
</div>






</div>
<!-- content ends -->
</div>


<?php include($path . 'footer.php'); ?>
<?php include('daily_script.php'); ?>

<script>
	$('#ItemSearchPnt').click(function() {
		var fDate = $('#from_d').val();
		var tDate = $('#to_d').val();
		var ItemNm = $('#ItemSearch').val();
		var ItemId = $('#Itemresult').val();
		//alert('' +invID);
		window.open("print/ItemBrkDownPrnt.php?fDate=" + fDate + "&tDate=" + tDate + "&ItemNm=" + ItemNm + "&ItemId=" + ItemId + "", "myWindowName", "width=595px, height=842px");

	});
	$(document).on('change', '.selectLocation', function() {
		var url = window.location.href;
		var splitUrl = url.split('&location')[0];
		if ($(this).val() != '') {
			window.location.href = splitUrl + "&location=" + $(this).val() + ""
		} else {
			window.location.href = splitUrl + "&location=ViewAll"
		}
	})

	var params = new window.URLSearchParams(window.location.search);
	if (params.get('location') != null) {
		$('.selectLocation').val(params.get('location'))
	} else if (params.get('location') == 'ViewAll') {
		$('.selectLocation').val(params.get('location'))
	}
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

	$(document).ready(function () {
        $("#repFilter").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".invoSumryTB tbody tr").filter(function () {
                $(this).toggle($(this).find("td:nth-child(14)").text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
    
    $(document).ready(function () {
        const $table = $(".breakdownSummaryTbl");
    
        // Add "Running Stock" to header
        $table.find("thead tr").append('<th>Running Stock</th>');
    
        // Filter only valid data rows (exclude totals, summary, etc.)
        const $validRows = $table.find("tr").filter(function () {
            const tds = $(this).find("td");
            const date = tds.eq(2).text().trim();
            const time = tds.eq(3).text().trim();
            const hasDate = /^\d{4}-\d{2}-\d{2}$/.test(date);
            const hasTime = /^\d{2}:\d{2}:\d{2}$/.test(time);
            return hasDate && hasTime;
        });
    
        // Extract and sort rows by datetime
        const sortedRows = $validRows.map(function () {
            const $tds = $(this).find("td");
            const datetime = new Date(`${$tds.eq(2).text().trim()}T${$tds.eq(3).text().trim()}`);
            return { $row: $(this), datetime };
        }).get().sort((a, b) => a.datetime - b.datetime);
    
        // Remove existing rows from table
        $validRows.remove();
    
        // Insert sorted rows back into table body and calculate running stock
        let runningStock = parseFloat($('.Opening_Stock').text()) || 0;
    
        sortedRows.forEach(({ $row }) => {
            let goodIn = parseFloat($row.find('.good_in').text().replace(/,/g, '')) || 0;
            let goodOut = parseFloat($row.find('.good_out').text().replace(/,/g, '')) || 0;

            runningStock += goodIn - goodOut;
    
            $row.append(`<td>${runningStock.toFixed(2)}</td>`);
            $table.append($row);
        });
    });
</script>