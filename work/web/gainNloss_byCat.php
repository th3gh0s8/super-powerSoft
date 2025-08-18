<?php


$title = 'Gain & Loss by Category';
	include ('includeFile.php');
	$report_sale = 'rep_target';

	$from_d = isset($_GET['from_d']) ? $_GET['from_d'] : date('Y-m-d');
	$to_d   = isset($_GET['to_d']) ? $_GET['to_d'] : date('Y-m-d');
	$sales_id = isset($_GET['sales_id']) ? $_GET['sales_id'] : '';
	$catType = isset($_GET['catType']) ? $_GET['catType'] : 'Category';
	$br_id = isset($_GET['com_br']) ? $_GET['com_br'] : '1'; // default branch


	$_SESSION['f_day']= $from_d;
	$_SESSION['t_day']= $to_d;
	$_SESSION['sl_id']= $sales_id;
	$_SESSION['catType']= $catType;
	//$ItemSearch = 'ItemSearch';
	$reportPrnt = 'GainLoss';

	$mysqli->query("UPDATE `invitem` SET `diff_inv` = '1' WHERE `diff_inv` = '0' ");
	$mysqli->query("UPDATE `invitem` SET `diff_inv` = '1' WHERE `UnitNo` = '1' ");		

	$from_d	= ($from_d != '')? $from_d : date('Y-m-d');
	$to_d	= ($to_d != '')? $to_d : date('Y-m-d');

	$from_dd = date_format(date_create($from_d), 'Y-m-d');
	$to_dd = date_format(date_create($to_d), 'Y-m-d');

	if($catType == 'Category'){
		$CatT = 'GROUP BY CatID';
	}else if($catType == 'SubCategory'){
		$CatT = 'GROUP BY itemtable.`XWord`';
	}else if($catType == 'Vendor'){
		$CatT = 'GROUP BY itemtable.`Vendor`';
	}else if($catType == 'Invoice'){
		$CatT = 'GROUP BY invitem.`InvNo`';
	}

	if($sales_id == 'View All'){
		$sql_CAT = $mysqli->query("SELECT CatID, itemtable.`XWord`, itemtable.`Vendor`, invitem.`InvNo`
								FROM `invitem` JOIN itemtable ON `invitem`.ItemNo = itemtable.ItemNo
						 		WHERE invitem.`Date` BETWEEN '$from_dd' AND '$to_dd' AND invitem.br_id = '$br_id' AND itemtable.nonSTK = 0
						 		$CatT");
	}else{
		$sql_CAT = $mysqli->query("SELECT CatID, itemtable.`XWord`, itemtable.`Vendor`, invitem.`InvNo`
								FROM `invitem` JOIN itemtable ON `invitem`.ItemNo = itemtable.ItemNo
								JOIN `invoice` ON `invitem`.`invID`  = `invoice`.`ID`
						 		WHERE invitem.`Date` BETWEEN '$from_dd' AND '$to_dd' AND invitem.br_id = '$br_id' AND itemtable.nonSTK = 0
						 		AND RepID = '$sales_id'  $CatT");
	}
	$report_sale    = 'CategoryType';
	$report_saleRep = 'rep_target';
	
	

?>
<style>
	.floatSales{ 
		float:left;
		width:21%;

	}
	input[type='text'], input[type='number'], select{
		
		padding: 2px 2px 2px 5px;	
	}
	#list{
		list-style:none;
		font-family: 'PT Sans', Verdana, Arial, sans-serif;
		min-width:150px;
		height:auto;
		color:#666;	
		padding-top:3px;
		padding-bottom:3px;
		padding-left: 15px;
		border-bottom: 1px solid #cdcdcd;
		transition: background-color .3s ease-in-out;
		-moz-transition: background-color .3s ease-in-out;
		-webkit-transition: background-color .3s ease-in-out;
		text-transform:uppercase;
		
	}
	#list:hover {
		background:#7F7F7F;	
		border: 1px solid rgba(0, 0, 0, 0.2);
		cursor:pointer;
		color:#fff;
	}
	#list:hover a{
		color:#fff;
		text-decoration:none;
	}

	.hilight{
		color:#333333;
		text-transform:uppercase;
		font-weight:bold;
	}
	.invoSumryTB tr:nth-child(even):hover td, tbody tr.odd:hover td {
		background:#DFD; 
		cursor:pointer;
		color:#009999
	}
	.amountBox, .paymntBox{
		width:80px;	
		text-align:right;
		
	}
	.bilDetUl li{
		
		list-style:none;
		float:left;	
		margin-left:10px;
		width:auto;
	}
	.ui-autocomplete{
		max-height:150px;
		min-width:170px;
		background:#CCC;
		overflow-y: auto;
		overflow-x: hidden;
	}
	.ui-autocomplete::-webkit-scrollbar {
	    width: 12px;
	}
	.ui-autocomplete::-webkit-scrollbar-track {
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
	    border-radius: 10px;
	}
	.ui-autocomplete::-webkit-scrollbar-thumb {
	    border-radius: 10px;
	    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
	}
	#ajax_img_lod, #ajax_img_lod_chq{
		display:none;
	}
	.bilDetLoad{
		display:none;	
	}
	.bilDetCont{
		margin-left:-50px;
	}
	.bilDetCont  input[type='text'], select{
	  height: 28px;
	  font-size: 12px;
	  display: block;
	  width: 100%;
	 
	  padding: 6px 3px;
	  font-size: 14px;
	  line-height: 1.42857143;
	  color: #555;
	  background-color: #fff;
	  background-image: none;
	  border: 1px solid #ccc;
	  border-radius: 4px;
	  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	  box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	  -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
	  -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	  transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
	.searhBtn {
	  margin-top: 18px;
	  padding: 3px 10px;
	}
	.norml{
		font-weight:normal;	
	}
</style>

</head>
<body class="nav-sm">
	<div class="container body">
  		<div class="main_container">
  			<?php 
				include($path.'side.php');
				include($path.'mainBar.php');
			?>
			<div class="right_col" role="main">
				<h2><i class="glyphicon glyphicon-user"></i> <?php echo $title; ?></h2>
				<div class="box-content2" style="width:99%; padding-left:1.5%; padding-right:0.5%;">
					<div class="row" style="background-color:#D5D3E8;" >
						<div class="form-group" style="width:100%;">
							<?php include ('admin_report_bar.php'); ?>
								</br>
							<div id="remove_TTb" class="findexcel">
								<table class="table table-striped table-bordered bootstrap-datatable  responsive invoSumryTB" style="margin-top:30px";>
									<thead>
    									<tr>
    										<?php
    											$CatT12 = 'Category';
    											if($catType == 'Category'){
													$CatT12 = 'Category';
													// $Ca2 = 
												}else if($catType == 'SubCategory'){
													$CatT12 = 'SubCategory';
												}else if($catType == 'Vendor'){
													$CatT12 = 'Vendor';
												}else if($catType == 'Invoice'){
													$CatT12 = 'Invoice';
												}
    										?>
								            <th width="10%"><?php echo $CatT12?></th>
								          <!--   <th width="10%">Sub Category</th>
								            <th width="10%">Vendor</th>
								            <th>Invoice no</th> -->
								            <?php 
									            if($CatT12 == 'Invoice'){
									            	echo'<th>SalesRep</th>';
									        	}
								        	?>
								            <th>Item Name</th>
								            <th>Stock</th>
								            <th>Qty</th>
								            <th>Sold</th>
											<th>Cost</th>
								            <th>Sales Val</th>
								        	<th>Cost Val</th>
								            <th>Gain / Loss</th>
								            <th>Item %</th>
								            <th>Total %</th>
											<th>Profit %</th>
								        </tr>
    								</thead>
									<?php
    								echo'<tbody>';
										$sql_GDTT = $mysqli->query("SELECT (CostPrice*Quantity)/diff_inv,Sprice*Quantity,Quantity
																FROM `invitem` WHERE invitem.`Date` BETWEEN '$from_dd' 
																AND '$to_dd' AND invitem.br_id = '$br_id' ");
										$ps = 0; $ms = 0;$pc = 0 ;$mc = 0 ;//$GDSwTT= 0;$GDCOSTT =0;$GDBALTT=0;$GDTTPER = 0;
										
										while($GDTT = $sql_GDTT->fetch_array()){
											if($GDTT[2] > 0){
												$ps += floatval($GDTT[1]);
												$pc += floatval($GDTT[0]);
											}else{
												$ms += -floatval($GDTT[1]);
												$mc += -floatval($GDTT[0]);
											}
												$ttc = floatval($pc) - floatval($mc);
												$tts = floatval($ps) - floatval($ms);
												$tt = floatval($tts) - floatval($ttc);
										}
										$ad= 0;	
											// echo 'sddddddddddddddddddddd';
										while($CAT = $sql_CAT->fetch_row()){

											if($catType == 'Category'){
												$CatT3 = "AND CatID = '$CAT[0]'";
												$cType = 'GROUP BY CatID';
											}else if($catType == 'SubCategory'){
												$CatT3 = "AND `itemtable`.`XWord` = '$CAT[1]'";
												$cType = 'GROUP BY itemtable.`XWord`';
											}else if($catType == 'Vendor'){
												$CatT3 = "AND Vendor = '$CAT[2]'";
												$cType = 'GROUP BY itemtable.`Vendor`';
											}else if($catType == 'Invoice'){
												$CatT3 = "AND invitem.`InvNo` = '$CAT[3]'";
												$cType = 'GROUP BY invitem.`InvNo`';
											}
											$CATT = ($CAT[0] == TRUE)? $CAT[0] : 'NONE';
											$SubCat = ($CAT[1] == TRUE)? $CAT[1] : 'NONE';

											$Tqty = 0;	$TSales = 0; $TqtyXsales = 0;
											if($sales_id != 'View All'){
												$Rep = "AND invoice.RepID = '$sales_id'"; 
											}else{
												$Rep = "";
											}
											$sql_GnL = $mysqli->query("SELECT invitem.`ItemNo`, invitem.`Description`, invitem.itemID
																	FROM `invitem` JOIN itemtable 
																	ON `invitem`.itemID = itemtable.ID
																	JOIN `invoice` 
																	ON `invitem`.`invID`  = `invoice`.`ID`
																 	WHERE invitem.`Date` BETWEEN '$from_dd' 
																 	AND '$to_dd' $CatT3 AND invitem.br_id = '$br_id'
																 	$Rep AND itemtable.nonSTK = 0
																    GROUP BY `invitem`.ItemNo");
											// echo ("SELECT invitem.`ItemNo`, itemtable.`Description`
											// 						FROM `invitem` JOIN itemtable 
											// 						ON `invitem`.ItemNo = itemtable.ItemNo
											// 						JOIN `invoice` 
											// 						ON `invitem`.`invID`  = `invoice`.`ID`
											// 					 	WHERE invitem.`Date` BETWEEN '$from_dd' 
											// 					 	AND '$to_dd' $CatT3 AND invitem.br_id = '$br_id'
											// 					 	$Rep
											// 					    GROUP BY `invitem`.ItemNo");
		
											$RWGnL = $sql_GnL->num_rows;
											$RwGnL = $RWGnL + 1 ;
												$getVendor = $mysqli->query("SELECT * FROM `vendor` WHERE br_id = '$br_id' 
																		  AND ID = '$CAT[2]'");
												$venRow = $getVendor->fetch_array();
												$vendorName = $venRow['CompanyName'];
    											if($catType == 'Category'){
													$CatT1 = $CATT;
													// $Ca2 = 
												}else if($catType == 'SubCategory'){
													$CatT1 = $SubCat;
												}else if($catType == 'Vendor'){
													$CatT1 = $vendorName;
												}else if($catType == 'Invoice'){
													$CatT1 = $CAT[3];
												}
											echo'
									        <tr>
									            <td rowspan="'.$RwGnL.'">'.$CatT1.'</td>';
									            if($catType == 'Invoice'){ $rr = '9';
									        	}else{$rr = '8';}
											    echo'<td colspan="'.$rr.'" hidden></td>
											</tr>';
											$TItmPer =0;$Tbalnc =0;$TTcst =0;$TTsl =0; 
											$sub2Per=0;$subPer=0;$GDPERTT=0;$Tbalnc2 = 0;
											
											while($GnL = $sql_GnL->fetch_array()){
												$sql_GnLd = $mysqli->query("SELECT SUM(`Quantity`), SUM(CostPrice*Quantity), SUM(invitem.Sprice*diff_inv*Quantity) , itemtable.`XWord`, itemtable.`Vendor`,invoice.RepID
													FROM `invitem` JOIN itemtable 
													ON `invitem`.itemID = itemtable.ID
													JOIN `invoice` ON `invitem`.`invID`  = `invoice`.`ID`
													WHERE invitem.`Date` BETWEEN '$from_dd'
													AND '$to_dd' $CatT3 AND invitem.itemID = '$GnL[2]'
													$Rep AND invitem.br_id = '$br_id' AND itemtable.nonSTK = 0");
												$GnLd = $sql_GnLd->fetch_array();

												$sql_items1 = $mysqli->query("SELECT SUM(invitem.CostPrice), SUM(invitem.DiscValue/invitem.Quantity)
				FROM `invitem` 
				JOIN itemtable ON invitem.ItemNo = itemtable.ItemNo
				WHERE invitem.itemID = '$GnL[2]' $CatT3
													 AND invitem.br_id = '$br_id' AND itemtable.nonSTK = 0");
				$itesmVal = $sql_items1->fetch_array();
				
						 $costVal = $itesmVal[0];
						 $salesVal = $itesmVal[1]; 
						 $percentage = number_format(($costVal != 0) ? ((floatval($salesVal)-floatval($costVal)) / floatval($costVal)) * 100 : 0,2);
												
												
												
												$sql_brstock = $mysqli->query("SELECT qty FROM br_stock WHERE itm_id = '$GnL[2]' AND br_id = '$br_id'");
												$brstock = $sql_brstock->fetch_array();
												
												$Tbalnc = 0;
												$QTY = $GnLd[0];

												if($QTY > 0){
													$clr   = '';
													$SL = 0;
													$CST = 0;
													if($GnLd[2] > 0 || $QTY >0 || $GnLd[1]){
														$SL       = 1*floatval($GnLd[2])/floatval($QTY);
														$CST      = 1*floatval($GnLd[1])/floatval($QTY);
													}
													$Tsl   = $GnLd[2];
													$Tcst  = $GnLd[1];
													$balnc = $Tsl - $Tcst;

													$ItmPer   = ($Tcst == 0) ? 0:100*floatval($balnc)/floatval($Tcst) ;
													$TTsl    += floatval($Tsl);
													$TTcst   += floatval($Tcst);
													$Tbalnc  += floatval($balnc);
													$Tbalnc2 += floatval($balnc);
													$TItmPer += floatval($ItmPer);
													$subPer   = 100*floatval($Tbalnc)/floatval($tt);
												}else{
													$clr      = 'red';
													$SL = 0;
													$CST = 0;
													if($GnLd[2] > 0 || $QTY >0 || $GnLd[1]){
														$SL       = -1*floatval($GnLd[2])/floatval($QTY);
														$CST      = -1*floatval($GnLd[1])/floatval($QTY);
													}
													$Tsl      = -floatval($GnLd[2]);
													$Tcst     = -floatval($GnLd[1]);
													$balnc    = $Tsl - $Tcst;
													$ItmPer   =  ($Tcst == 0) ? 0: (-100*floatval($balnc))/floatval($Tcst);
													$TTsl    += -floatval($Tsl);
													$TTcst   += -floatval($Tcst);
													$Tbalnc  += floatval($balnc);
													$Tbalnc2 += floatval($balnc);
													$TItmPer += floatval($ItmPer);
													$subPer   = -100*floatval($Tbalnc)/floatval($tt);
												}
								//if($sales_id != 'View All'){
								// 	$rrID = $GnLd['RepID'];
								// }else{

								// }
								$repName = $mysqli->query("SELECT Name FROM salesrep WHERE RepID = '".$GnLd['RepID']."'");
								//echo 'WWWWW'.("SELECT Name FROM salesrep WHERE RepID = '".$GnLd['RepID']."'");
								$RName = $repName->fetch_array();
								$RName = $RName[0];
											            // <td>'.$SubCat.'</td>
											            // <td>'.$vendorName.'</td>
											            // <td>'.$CAT[3].'</td>
												if($QTY > 0){
													echo'
													<tr style="color:'.$clr.';">
														';
														if($catType == 'Invoice'){
															echo'<td>'.$RName.'</td>';
														}
											            echo'
											            <td>'.$GnL[0].' - '.$GnL[1].'</td>
											            <td>'.$brstock['qty'].'</td>
														<td style="text-align:right;">'.number_format($QTY,2).'</td>
														<td style="text-align:right;">'.number_format($SL,2).'</td>
														<td style="text-align:right;">'.number_format($CST,2).'</td>
														<td style="text-align:right;">'.number_format($Tsl,2).'</td>
														<td style="text-align:right;">'.number_format($Tcst,2).'</td>
														<td style="text-align:right;">'.number_format($balnc,2).'</td>
														<td style="text-align:right;">'.number_format(floatval($ItmPer),2).'%</td>
														<td style="text-align:right;">'.number_format($subPer,2).'%</td>
														<td style="text-align:right;">'.number_format(floatval($percentage),2).'%</td>
											        </tr>';
													//$GDTTPER += 100*$Tbalnc/$GDBALTT;
													$sub2Per += $subPer;
												}
														// <td>'.$SubCat.'</td>
											   //          <td>'.$vendorName.'</td>
											   //          <td>'.$CAT[3].'</td>
												else{
													echo'<tr style="color:'.$clr.';">';
														if($catType == 'Invoice'){
															echo'<td>'.$RName.'</td>';
														}
											            echo'<td>'.$GnL[0].' - '.$GnL[1].'</td>
											            <td>'.$brstock['qty'].'</td>
														<td style="text-align:right;">'.number_format(-1*$QTY,2).'</td>
														<td style="text-align:right;">'.number_format($SL,2).'</td>
														<td style="text-align:right;">'.number_format($CST,2).'</td>
														<td style="text-align:right;">'.number_format(-1*$Tsl,2).'</td>
														<td style="text-align:right;">'.number_format(-1*$Tcst,2).'</td>
														<td style="text-align:right;">'.number_format(-1*$balnc,2).'</td>
														<td style="text-align:right;">'.number_format($ItmPer,2).'%</td>
														<td style="text-align:right;">'.number_format(-1*$subPer,2).'%</td>
																												<td style="text-align:right;">'.number_format(-1*$percentage,2).'%</td>
											        </tr>';	
													//$GDTTPER += 100*$Tbalnc/$GDBALTT;
													$sub2Per += $subPer; 
												}
											}
											$ttprct = ($TTcst == 0 ) ? 0:100*($TTsl-$TTcst)/$TTcst;
											if($catType == 'Invoice'){ $rr = '7';
									        	}else{$rr = '6';}
											echo'<tr  style="color:'.$clr.'">
											    <td colspan="'.$rr.'" style="color:#E6D3D3;text-align:right;">
											    	Total Gain/Loss for Category
											    </td>
												<td style="background-color:#75E3AE; text-align:right; ">
													'.number_format($TTsl,2).'
												</td>
												<td style="background-color:#75E3AE; text-align:right; ">
													'.number_format($TTcst,2).'
												</td>
												<td style="background-color:#75E3AE; text-align:right;" >
													'.number_format($TTsl-$TTcst,2).'
												</td>
												<td style="background-color:#75E3AE; text-align:right; ">
													'.number_format($ttprct,2).'%
												</td>
												<td style="background-color:#75E3AE; text-align:right;" >
													'.number_format($sub2Per,2).'%
												</td>
																								<td style="background-color:#75E3AE; text-align:right;" ></td>
											</tr>';
											//$GDPERTT += $TItmPer;
											$GDTTPER += floatval($sub2Per);
											$GDSLTT  += floatval($TTsl);
											$GDCOSTT += floatval($TTcst);
											$ad = 0;
											if($GDSLTT > 0){
												$ad       =  $GDCOSTT > 0 ? 100*(floatval($GDSLTT)-floatval($GDCOSTT))/floatval($GDCOSTT): 0 ;
											}
											$final   += floatval($sub2Per);
										}
									echo'</tbody>';
									echo'<tfoot>
										<tr bgcolor="#DFD">		
											<td  style="background-color:#42A8E4; text-align:right;" colspan="'.$rr.'">
												GRAND TOTAL
											</td>
											<td style="background-color:#42A8E4; text-align:right;"><b>
												'.number_format($GDSLTT,2).'</b>
											</td>
											<td style="background-color:#42A8E4; text-align:right;"><b>
												'.number_format($GDCOSTT,2).'</b>
											</td>
											<td style="background-color:#42A8E4; text-align:right;"><b>
												'.number_format($GDSLTT-$GDCOSTT,2).'</b></td>
											<td style="background-color:#42A8E4; text-align:right;"><b>
												'.number_format($ad,2).'%</b>
											</td>
											<td style="background-color:#42A8E4; text-align:right;"><b>
												'.number_format($final,2).'%</b>
											</td>
																						<td style="background-color:#42A8E4; text-align:right;"><b></td>
										</tr>
									</tfoot>';
									?> 
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="box-content" style="align-items: center" >
				    <ul class="ajax-loaders" style="display:none">
				        <li><img src="../daily/img/ajax-loaders/ajax-loader-8.gif" /></li>                                   
				    </ul>                
				</div> 
				<div  id="mainLoadInvoSumry">
				</div>
			</div>
		</div>
	</div>
</body>
<!-- content ends -->
<?php include ($path.'footer.php'); ?>    
<script type="text/javascript">    
	$('.from_d').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	
	$('.to_d').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });	
</script>
<?php include ('AdminJava.php'); ?>   
<script>
	$('#GainLoss').click(function(){
		var invID = $('').val();
		window.open("print/gainNloss_print.php" , "myWindowName","width=595px, height=842px");	
	});
</script>
