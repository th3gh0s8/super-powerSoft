<?php
include('path.php');
require_once  $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';
if (isset($_GET['BID_PRINT'])) {
	$INVNO = $_GET['BID_PRINT'];
} else {
	$INVNO = $_SESSION['INV_ID'];
}

if (isset($_GET['duplct'])) {
	$duplct = '<span style="font-weight:bold; font-size:12px">Duplicate </span>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Invoice Print Sheet Normal</title>

	<style>
		@font-face {
			font-family: araliya;
			src: url(Logo/DL-Araliya.TTF);
		}

		table {
			border: 0px solid black;
			border-spacing: 0px;
		}

		table thead tr {
			font-family: Arial, monospace;
			font-size: 14px;
		}

		table thead tr th {
			border-bottom: 2px solid black;
			border-top: 1px solid black;
			margin: 0px;
			padding: 2px;
			background-color: #cccccc;
			text-align: left;
		}

		table tr {
			font-family: arial, monospace;
			color: black;
			font-size: 12px;
			background-color: white;
		}

		table tr.odd {
			background-color: #AAAAAA;
		}

		table tr td,
		th {
			//border-bottom: 1px solid black;
			padding: 2px;
			padding-right: 10px;
		}

		.delv_det td {
			border: none;
		}


		table {
			border: 0px solid black;
			border-spacing: 0px;
		}

		table thead tr {
			font-family: Arial, monospace;
			font-size: 14px;
		}

		table thead tr th {
			border-bottom: 2px solid black;
			border-top: 1px solid black;
			margin: 0px;
			padding: 2px;
			background-color: #cccccc;
			text-align: left;
			font-weight: normal;
			font-size: 12px;
		}

		table tr {
			font-family: arial, monospace;
			color: black;
			font-size: 12px;
			background-color: white;
		}

		table tr.odd {
			background-color: #AAAAAA;
		}

		table tr td,
		th {
			//border-bottom: 1px solid black;
			padding: 2px;
			padding-right: 10px;
		}

		.delv_det td {
			border: none;
		}

		.secndTbHead {
			border-bottom: 2px solid black;
			border-top: 1px solid black;
			margin: 0px;
			padding: 2px;
			background-color: #cccccc;
			text-align: left;
			font-weight: normal;
			font-size: 12px;

		}


		@media print {

			@page {
				size: auto;
				margin-top: 100px;
				margin-bottom: 5mm;
			}

			body {
				font-size: 10px;
				font-family: Verdana, Geneva, sans-serif;
				margin: 1px;
			}
		}
	</style>
</head>

<body onload="window.print() ">
	<div align="center" style="width:100%"> <?php echo $duplicte ?> </div>

	<div align="center" style="width:100%">
	</div>
	<div id="print_tbl">
		<div id="Person" class="box">
			<div class="box-header" style="height:auto;width:100%" align="left">

				<?php
				//mysql_set_charset('utf8');

				

				$sql_com = $mysqli->query("SELECT name, tel, fax, address, vat_no, fullName, invoiceText  FROM com_brnches WHERE ID='$br_id'");
				$res_com = $sql_com->fetch_array();

				$sql_inv = $mysqli->query("SELECT invoice.Date, invoice.NowTime , invoice.ID, invoice.order_id, invoice.CusID, invoice.RepID, invoice.br_id, invoice.br_id, RcvdAmnt, cusPaid, 
						   invoice.InvTot, Balance, invoice.Sdisc, purchNo, vat_percnt, vat_no, invoice.Location, invoice.ShowType, cusstatement.settlment_date FROM invoice LEFT JOIN cusstatement ON 
						   invoice.InvNO  = cusstatement.InvNo  
						   WHERE invoice.InvNO ='$INVNO' AND invoice.br_id = '$br_id' ORDER BY invoice.InvNO DESC LIMIT 1");
				$inv = $sql_inv->fetch_array();


				/*echo '<table style="width:100%; margin-top:10px; border-collapse:collapse;">
        <tr>
            <td style="width:15%;"></td>';

				if ($inv['ShowType'] == 'HIDE') {
					echo '<td style="width:60%; text-align:center; vertical-align:top;">
            <h2 style="margin:0; font-size:30px; font-family:sans-serif;">' . $res_com['fullName'] . '</h2>
          </td>';
				} else {
					echo '<td style="width:60%; text-align:center; vertical-align:top;">
            <h2 style="margin:0; font-size:30px; font-family:sans-serif;">' . $res_com['name'] . '</h2>
          </td>';
				}

				echo '<td style="width:15%; text-align:right; vertical-align:top;">' . $duplct . '</td>
        </tr>
      </table>';*/


				$cus_id = trim($inv['CusID']);
				$invDate = $inv[0];
				$mnth = substr($invDate, 5, 2);
				//$mnth = month_crt($mnth);

				$newDate = date_format(date_create($invDate), 'd Y');

				$sql_cusName =  $mysqli->query("SELECT cusName, Address, TelNo, vatNo FROM custtable WHERE CustomerID = '$cus_id'");
				$res_cusName = $sql_cusName->fetch_array();

				$time = date_create($inv[1]);
				$time = date_format($time, 'H:i:s');

				$purchNo = (trim($inv[13]) !== '') ? 'Purchase #: ' . $inv[13] . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '';
				$repDet = $inv['RepID'];

				$faxMessage = ($res_com[2] == '') ? '' : ' &nbsp;/&nbsp; FAX: ' . $res_com[2];
				$duedays_text = '';

	// Check if settlement date is valid
if ($inv['settlment_date'] != '0000-00-00' && $inv['settlment_date'] != '1970-01-01') {
    $settlementDt = date_create($inv['settlment_date']);
    $invDateDt = date_create($inv['invoice_date']); // assuming $inv[0] was invoice date
    $creditDays = date_diff($invDateDt, $settlementDt);
    $dueDays = (int)$creditDays->format("%a");

    if ($dueDays == 0 && $inv['Balance'] == 0) {
        $duedays_text = 'Cash';
    } else {
        $duedays_text = 'Credit ';
    }
} else {
    // If settlement date is invalid or missing
    $duedays_text = 'Cash';
}



				/*echo '<table border="1" style="width:100%" class="delv_det">
			<tr>
				<td colspan="2" align="center"> 
					<span style="font-size:12px" >  ' . $res_com['address'] . '</span>					
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center"> 
					<span style="font-size:12px" > Tel  ' . $res_com[1] . ' ' . $faxMessage . '</span>					
				</td>
			</tr>';
				if ($res_com['vat_no'] != '') {
					echo '
				<tr>
				<td colspan="2" align="center"> 
					<span style="font-size:12px">VAT No: ' . $res_com['vat_no'] . '</span>					
				</td>
			</tr>
				';
				}
				if ($res_cusName['vatNo'] != '' || $res_cusName['vatNo'] != '') {
					echo '
			        <tr>
        				<td colspan="2" align="center"> 
        					<span style="text-transform: capitalize;font-size:15px; text-align:center; font-weight:bold;">VAT INVOICE </span>
        				</td>
        			</tr>
			    ';
				} else {
					echo '
			        <tr>
        				<td colspan="2" align="center"> 
        					<span style="text-transform: capitalize;font-size:15px; text-align:center; font-weight:bold;">INVOICE </span>
        				</td>
        			</tr>
			    ';
				}*/
				$cusVat = $res_cusName['vatNo'] != '' ? '<br>Cus Vat: ' . $res_cusName['vatNo'] : '';

				echo '<table style="width:100%; margin-top:10px; border-collapse:collapse;">
				<!--
			<tr>
				<td> 
					<span style="text-transform: capitalize;font-size:15px">' . $res_cusName[0] . ' </span>
					&nbsp;&nbsp;&nbsp; ' . $res_cusName[1] . '&nbsp;&nbsp;&nbsp; ' . $res_cusName[2] . ' ' . $cusVat . '
				</td>
				<td align="right">' . $duedays_text . '</td>
			</tr>	-->		
			<tr>
				
				<td width="15%"></td>
				<td align="left"  colspan="0"> 

				

				
					 ' . $res_cusName[0] . ' <br>' . $res_cusName[2] . ' <br>' . $res_cusName[1] . ' 

					</td>

	
				<td width="65%"></td>

				<td align="left" colspan="0" width="100%" >' . $mnth . '&nbsp;'. $newDate .' <br>' . $INVNO . '</td>

				<td width="10%"></td>
				
				<!-- TODO: have to impliment payment type -->
				<td align="left" colspan="0" width="100%"> ' . $purchNo . ' '. $duedays_text . '' . $time . '</td>	
											
			</tr>
												
		  </table>';
				?>

			</div>
		</div>

		<?php



		$i = 1;
		$j = 1;
		$lin_No = 1;
		$dis_tot = 0;
		$isSerial = 0;
		$newHeader = false;

		echo '
		<!--<div id="Person-' . $INVNO . '" class="box">
        <div class="box-header" style="height:auto">
        </div>
        <div class="box-content box-table">
		-->
        <table class="" border="0px"  style="width:100%">
            <!--<thead>
                <tr>
					<th style="width:10px">Nos</th>
                    <th style="width:100px">Code</th>
                    <th colspan="2" style="width:300px">Description </th>
					<th style="width:30px"><div style="text-align:right;padding-right:6px">Qty</div></th>
					<th style="width:30px"><div style="text-align:right;padding-right:6px">Unit</div></th>
                    <th style="width:70px"><div style="text-align:right;padding-right:10px">Rate</div></th>	
					<th style="width:50px"><div style="text-align:right;padding-right:10px">Dis %</div></th>			
					<th style="width:80px"><div style="text-align:right;padding-right:10px">Amount</div></th>					
                </tr>
            </thead>-->

			<br><br>
            <tbody>
            
            ';



		$tot = $inv['InvTot'];
		$rec = $inv['RcvdAmnt'];
		$blnc = $inv['Balance'];


		$sql_itm = $mysqli->query("SELECT * FROM invitem  WHERE InvNO='$INVNO' AND br_id = '$br_id'  ORDER BY ID ASC");
		$itemCount = $sql_itm->num_rows;
		while ($itm = $sql_itm->fetch_array()) {
			($itm['warrenty'] != '') ? $isSerial += 1 : '';

			$sql_fixedPrice = $mysqli->query("SELECT sale_pr, salse_pr2, `qty`, `reorder2` FROM br_stock WHERE itm_code='" . $itm['ItemNo'] . "' AND br_id='$br_id' ");
			$res_fixedPrice = $sql_fixedPrice->fetch_array();

			$sql_itemtableDet = $mysqli->query("SELECT * FROM itemtable WHERE ItemNO = '" . $itm['ItemNo'] . "'");
			$itemtableDet = $sql_itemtableDet->fetch_array();

			$pric = $itm['Sprice'];
			$disPer = $itm['DiscPrcnt'];
			$qty = $itm['Quantity'];

			$qty = (trim($itm['UnitNo']) == 2) ? round($qty * $itm['diff_inv']) : $qty;
			if (trim($itm['DiscPrcnt']) > 0) {
				$fixedPrice = ($itm['DiscPrcnt'] != 100) ? (($itm['Sprice'] / (100 - $itm['DiscPrcnt'])) * 100) : 0;
			} else {
				$fixedPrice = $itm['Sprice'];
			}

			$tot1 = $qty * $fixedPrice;
			$finTot = $tot1 * (100 - $disPer) / 100;
			$dis_tot += $tot1 - $finTot;

			if ($newHeader == true) {
				$newHeader = false;
				$height = ($lin_No > 31) ? 'height:130px' : 'height:130px';
				echo '<tr>
                <td colspan="7" style="' . $height . '"></td>				                
             </tr>	
			 ';
			}

			/*
		<tr>
			<th style="width:10px;" class="secndTbHead">No</th>
			<th style="width:100px" class="secndTbHead">Code</th>
			<th colspan="2" style="width:300px" class="secndTbHead">Description </th>			
			<th style="width:30px" class="secndTbHead">Qty</th>
			<th style="width:30px" class="secndTbHead">Unit</th>
			<th style="width:70px" class="secndTbHead"><div align="center">Rate</div></th>	
			<th style="width:50px" class="secndTbHead"><div align="center">Dis %</div></th>			
			<th style="width:80px" class="secndTbHead"><div align="center">Amount</div></th>					
		 </tr>
	    */
			$warnty = (trim($itm['warrenty']) != '') ? ' [ ' . $itm['warrenty'] . ' ]' : '';
			$lineBold = '';
			if ($res_fixedPrice['qty'] <= $res_fixedPrice['reorder2'] && $res_fixedPrice['reorder2'] != 0) {
				$lineBold = 'style="font-weight:bold;"';
			}

			$itemType = (trim($itemtableDet['Type']) != '') ? ' - ' . $itemtableDet['Type'] : '';

			$itmDescription = $itm['Description'] . $warnty . $itemType;

			echo '<tr ' . $lineBold . '>
				<td  style="width:5px" align="right" >' . $lin_No . ' </td>
                <td  style="width:50px" >' . $itm['ItemNo'] . '</td>
                <td  style="width:300px"colspan="2" align="left" >  ' . substr($itmDescription, 0, 50) . '</td>
                <td  style="width:30px"align="center">' . $qty . '</td>
                <!--<td  style="width:30px"align="right">' . $itm['Unit'] . '</td>-->
                <td  style="width:70px"align="right">' . numFormt2($fixedPrice) . '</td>
				<td  style="width:70px"align="right">' . numFormt2($finTot) . '</td>
             </tr>';

			$lin_No++;
			$i++;

			if ($lin_No == 14 && $i >= 14) {
				$i = 1;
				$newHeader = true;
			} else {

				if ($i == 19) {
					$i = 1;
					$newHeader = true;
				}
			}
		}

		if ($itemCount < 9) {
			while ($i <= 9) {
				echo '<tr>
                <td colspan="8">&nbsp;</td>				
             </tr>';
				$i++;
			}
		} else if ($itemCount > 9 && $i != 1) {
			while ($i <= 9) {
				echo '<tr>
                <td colspan="8">&nbsp;</td>				
             </tr>';
				$i++;
			}
		}

		$sql_outStnd = $mysqli->query("SELECT SUM(Balance) FROM invoice WHERE CusID = '$cus_id' AND invoice.br_id = '$br_id' ");
		$res_outStnd = $sql_outStnd->fetch_array();

		if (trim($inv['vat_percnt']) > 0) {
			$vatPer = trim($inv['vat_percnt']);
			$vatAmnt = ($tot * $vatPer)  /  (100 + $vatPer);

			$comVatNo = (trim($res_com['vat_no']) !== '') ? trim($res_com['vat_no']) : ' - ';
			$cusVatNo = (trim($inv['vat_no']) !== '') ? trim($inv['vat_no']) : ' - ';
		} else {
			$disBord = 'border-bottom:1px solid #000;';
		}

		$invDiscnt = ($inv['Sdisc'] > 0) ?  '(' . numFormt2($inv['Sdisc']) . ')' :  numFormt2($inv['Sdisc']);
		/*echo '
			</tbody>
		</table>
		<table border="0" style="width:100%">
		  <tr style="border:1px solid #000">
			<td width="97px" style="border-top:1px solid #000;">Sales Person  </td>	
			<td width="20px"  style="border-top:1px solid #000;"> : </td>
			<td style="border-top:1px solid #000;"> ' . FindRepName('RepID', $repDet, $br_id)['Name'] . ' </td>					
			<td width="130px"  style="border-top:1px solid #000;" align="right">  Discount:  ' . numFormt2($dis_tot) . ' </td>
			<td align="right" width="100px"  style="border-top:1px solid #000;"> Inv.Discount </td>
			<td align="right" width="100px" style="padding-right:10px;' . $disBord . ' border-top:1px solid #000"> ' . $invDiscnt . '</td>
		  </tr>';


		if (trim($inv['vat_percnt']) > 0 || $res_cusName['vatNo'] != '' || $res_cusName['vatNo'] != '') {
			$vatt = 100 + $inv['vat_percnt'];
			$vatAmnt = ($tot * $inv['vat_percnt'])  /  ($vatt);
			echo '
		  <tr >
			<td colspan="4" width="" >&nbsp;</td>
			<td align="right" width="100px"  > VAT  &nbsp; ' . $inv['vat_percnt'] . '% </td>
			<td align="right" width="100px" style="padding-right:10px;border-bottom:1px solid #000"> 
				' . numFormt2($vatAmnt) . '
			</td>
		  </tr>';
		}*/


		$sql_isUnitInfo = $mysqli->query("SELECT ID FROM optiontb WHERE opertionName='UnitInfor' AND optionPath ='Y' AND br_id='$br_id'");
		$isUnitInfo = $sql_isUnitInfo->num_rows;
		if ($isUnitInfo == true) {
			$unitNote = '';
			$seprater = '';
			$sql_unit = $mysqli->query("SELECT unit, sum(Quantity) FROM invitem WHERE InvNo = '$INVNO' AND br_id = '$br_id'GROUP BY Unit ");
			while ($res_unit = $sql_unit->fetch_array()) {
				$unitNote .= $seprater . '' . $res_unit[0] . ' => ' . $res_unit[1];
				$seprater = ' &nbsp;|&nbsp; ';
			}
		}
		$note = (trim($inv['Location']) != '' && $unitNote != '') ? $inv['Location'] . '&nbsp; / &nbsp; ' : $inv['Location'];

		echo '
		</tbody>
		</table>
		<table border="0" style="width:100%">
		  
		  <tr>
			
			<td  align="right" style="padding-right:10px;"> ' . numFormt2($tot) . ' </td>
		  </tr>	
		  <tr>
		  	
			<td  align="right" style="padding-right:10px;" > ' . numFormt2($inv['cusPaid']) . ' </td>
		  </tr>
		  <tr>
		  	
			<td  align="right" style="padding-right:10px;" > (' . numFormt2($tot -  $inv['cusPaid']) . ') </td>
		  </tr>	
		  <!--
		  <tr>
		  	<td colspan="6" style="margin-top:3px;font-size:8px;">' . xpowerDetail()['invoiceFooter'] . '</td>
		  </tr>-->
		</table>
</div>
</div>';



		?>

	</div>




</body>

</html>