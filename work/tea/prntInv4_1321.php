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
	$duplct = 'COPY';
}
$com_id = trim($_SESSION['COM_ID']);
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
			padding: 2px;
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
			margin: 0px;
			padding: 2px;
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
			padding: 2px;
		}

		.delv_det td {
			border: none;
		}

		.secndTbHead {
			margin: 0px;
			padding: 2px;
			text-align: left;
			font-weight: normal;
			font-size: 12px;

		}


		@media print {

			@page {
				size: auto;
				margin-top: 0mm;
				margin-bottom: 5mm;
				margin-top: 40px;
			}

			body {
				font-size: 10px;
				font-family: Verdana, Geneva, sans-serif;
				margin: 1px;
			}
		}

		table {
			border-collapse: collapse;
			width: 100%;
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

				$sql_com = $mysqli->query("SELECT name, tel, fax, address, vat_no, fullName, invoiceText, brImg, email  FROM com_brnches WHERE ID='$br_id'");
				$res_com = $sql_com->fetch_array();

				$sql_inv = $mysqli->query("SELECT invoice.Date, invoice.NowTime , invoice.ID, invoice.order_id, invoice.CusID, invoice.RepID, invoice.br_id, invoice.br_id, RcvdAmnt, cusPaid, 
						   invoice.InvTot, Balance, invoice.Sdisc, purchNo, vat_percnt, vat_no, invoice.Location, invoice.ShowType, cusstatement.settlment_date, invoice.ID as invTb FROM invoice LEFT JOIN cusstatement ON 
						   invoice.InvNO  = cusstatement.InvNo  
						   WHERE invoice.InvNO ='$INVNO' AND invoice.br_id = '$br_id' ORDER BY invoice.InvNO DESC LIMIT 1");
				$inv = $sql_inv->fetch_array();
				$payText = '';
				$balText = '';
				if ($inv['cusPaid'] > $inv['InvTot']) {
					$balText = $inv['cusPaid'] - $inv['InvTot'];
				} else {
					$balText = $inv['Balance'];
				}
				if ($inv['Balance'] == 0) {
					$payText = '&nbsp;&nbsp;(Cash Bill)';
				} else {
					$payText = '&nbsp;&nbsp;(Credit Bill)';
				}
				$invID = $inv['ID'];
				$sql_qtyItm = $mysqli->query("SELECT SUM(Quantity) FROM invitem WHERE InvNo = '$INVNO' AND br_id = '$br_id'");
				$invTotItm = $sql_qtyItm->fetch_array();

				if ($res_com['brImg'] != '') {
					$image = '<img src="https://' . $_SERVER['HTTP_HOST'] . '/Home/new/images/logo/' . $res_com['brImg'] . '?1" style="width: 10%; " />';
				}



				if ($inv['ShowType'] == 'HIDE') {
					$heading = '<h2 style="color: #991531; text-align:center; margin-bottom: 0px; margin-right: 0px; font-size: 30px; font-family: \'Times New Roman\', Times, serif;">' . $res_com['fullName'] . '</h2>';
				} else {
					$heading = '<h2 style="color: #991531; text-align:center; margin-bottom: 0px; margin-right: 0px; font-size: 30px; font-family: \'Times New Roman\', Times, serif;">' . $res_com['name'] . '</h2>';
				}


				$cus_id = trim($inv['CusID']);
				$invDate = $inv[0];
				$mnth = substr($invDate, 5, 2);
				$mnth = month_crt($mnth);

				$newDate = date_format(date_create($invDate), 'd Y');

				$sql_cusName =  $mysqli->query("SELECT cusName, Address, TelNo, vatNo FROM custtable WHERE CustomerID = '$cus_id'");
				$res_cusName = $sql_cusName->fetch_array();

				$time = date_create($inv[1]);
				$time = date_format($time, 'H:i:s');

				$purchNo = (trim($inv[13]) !== '') ? 'Purchase #: ' . $inv[13] . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' : '';
				$repDet = $inv['RepID'];

				$faxMessage = ($res_com[2] == '') ? '' : ' &nbsp;/&nbsp; FAX: ' . $res_com[2];
				$duedays_text = '';

				if ($inv['settlment_date'] != '0000-00-00' && $inv['settlment_date'] != '1970-01-01') {
					$settlementDt = date_create($inv['settlment_date']);
					$invDateDt = date_create($inv[0]);
					$creditDays = date_diff($invDateDt, $settlementDt);
					$dueDays = $creditDays->format("%a");

					if ($dueDays == 0) {
						if ($inv['Balance'] == 0) {
							$duedays_text = 'Cash';
						}
					} else {
						$duedays_text = 'Credit: ' . $dueDays . ' days';
					}
				} else {
					$duedays_text = 'Cash';
				}


				echo '<table border="1" style="width:100%" class="delv_det">
					<tr>
						<td style="width:15%; border-top:1px solid #000; border-left:1px solid #000;"><b>&nbsp;' . $duplct . '</b></td>
						<td style="width:60%; border-top:1px solid #000; text-align:center;"><u><b></b></u></td>
						<td style="width:15%; border-top:1px solid #000; border-right:1px solid #000;"></td>
					</tr>
				</table>';
				echo '<table border="1" style="width:100%" class="delv_det">
				<tr>
					<td colspan="2" style="text-align:center; border-left:1px solid #000; border-right:1px solid #000;">' . $image . '</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:center;border-left:1px solid #000; border-right:1px solid #000;">' . $heading . '</td>
				</tr>
			<tr>
				<td colspan="2" align="center" style="border-left:1px solid #000; border-right:1px solid #000;"> 
					<span style="color:#991531; font-size:12px" >  ' . $res_com['address'] . '</span>					
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" style="border-left:1px solid #000; border-right:1px solid #000;"> 
					<span style="color:#991531; font-size:12px" > Tel  ' . $res_com[1] . ' ' . $faxMessage . ' / Email: ' . $res_com['email'] . '</span>					
				</td>
			</tr>';


				$cusVat = $res_cusName['vatNo'] != '' ? '<br>Cus Vat: ' . $res_cusName['vatNo'] : '';

				echo '
												
		  </table>
		  ';
				echo '<table border="1" style="width:100%" class="delv_det;">
							<tr>
								<td style="width:49%; border-top:1px solid #000; border-right:1px solid #000; border-left:1px solid #000;" rowspan="3">
									<b>&nbsp;Customer Details:<br>&nbsp;&nbsp;&nbsp;&nbsp;' . $res_cusName[0] . '<br>&nbsp;&nbsp;&nbsp;&nbsp;' . $res_cusName[2] . '<br>&nbsp;&nbsp;&nbsp;&nbsp;' . $inv['Location'] . '</b>
								</td>
								<td style="width:21%; border-top:1px solid #000;" rowspan="3">
								&nbsp;Invoice No<br>&nbsp;Date<br>&nbsp;Time
								</td>
								<td style="width:30%; border-top:1px solid #000; border-right:1px solid #000;" rowspan="3">
								: ' . $INVNO . ' ' . $payText . '<br>: ' . $inv['Date'] . '<br>: ' . $inv['NowTime'] . '
								</td>
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
		echo '<div id="Person-' . $INVNO . '" class="box">
        <div class="box-header" style="height:auto">
        </div>
        <div class="box-content box-table">
        <table class="" border="0px"  style="width:100%">
               <tr>
    <th style="border-left:1px solid #000; width:10px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">S.N</th>
		    <th style="width:50px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Code</th>
    <th colspan="2" style="width:300px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Description Of Goods</th>
    <th style="width:30px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Qty</th>
    <th style="width:30px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Unit</th>
    <th style="width:70px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">List Price</th>
    <th style="width:50px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Discount</th>
    <th style="width:70px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Price</th>
    <th style="width:80px; text-align:center; border-top:2px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Amount</th>
</tr>


            <tbody>
            
            ';
		$lineNo = 1;

		$tot = $inv['InvTot'];
		$rec = $inv['RcvdAmnt'];
		$blnc = $inv['Balance'];
		$qtyTot = 0;
		$imeLst = '';
		$sql_outStnd = $mysqli->query("SELECT SUM(Balance) FROM invoice WHERE CusID = '$cus_id' AND invoice.br_id = '$br_id' ");
		$res_outStnd = $sql_outStnd->fetch_array();
		$sql_itm = $mysqli->query("SELECT * FROM invitem  WHERE InvNO='$INVNO' AND br_id = '$br_id'  ORDER BY ID ASC");
		// $sql_itm = $mysqli->query("SELECT * FROM invitem  LIMIT 29");
		$itemCount = $sql_itm->num_rows;
		while ($itm = $sql_itm->fetch_array()) {
			$imeLst = '';
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
				$height = ($lin_No > 31) ? 'height:43;' : 'height:43;';
				echo '
				<tr>
					<td colspan="10" style="padding: 0;">';
		?>
				<?php
				$previewLink = shortUrl($_SERVER['HTTP_HOST'] . "/x/i.php?i=" . urlencode(base64_encode($inv['invTb'] . "||XP||" . $com_id)));
				$qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$previewLink}&size=80x80";
				?>
				<!-- Totals Table -->
				<table style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; border:1px solid #000; border-bottom:none;">
					<tr>
						<th style="border-left:1px solid #000; width:10px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th colspan="2" style="width:300px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; ">Total Qty</th>
						<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "><?php echo $invTotItm[0]; ?> </th>
						<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:70px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Grand Total</th>
						<th style="width:80px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">
							<?php echo number_format($inv['InvTot'], 2); ?>
						</th>
					</tr>
					<tr>
						<td colspan="10" style="border:1px solid #000; padding:6px; font-weight:bold; font-size:10px;">
							LKR <?php echo strtoupper(numberToWords($inv['InvTot'])); ?> ONLY
						</td>
					</tr>

					<tr>
						<th style="border-left:1px solid #000; width:10px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th colspan="2" style="width:300px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:70px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Paid</th>
						<th style="width:80px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">
							<?php echo number_format($inv['cusPaid'], 2); ?>
						</th>
					</tr>

					<tr>
						<th colspan="4" style="width:300px; text-align:left; border-top:1px solid #000; border-bottom:1px solid #000;">
							Total Outstanding: <?php echo number_format($res_outStnd[0], 2); ?>
						</th>
						<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000;"></th>
						<th style="width:70px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Balance</th>
						<th style="width:80px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">
							<?php echo number_format($balText, 2); ?>
						</th>
					</tr>


				</table>


				<!-- Terms and Signature Section -->
				<table style="width:100%; border-collapse:collapse; border:1px solid #000; border-top:none; font-family:Arial, sans-serif; font-size:13px;">
					<tr>
						<!-- Terms & Conditions with QR on top right -->
						<td style="width:65%; vertical-align:top; padding:6px; border:1px solid #000; border-top:none; position:relative;">
							<div style="display:flex; justify-content:space-between; align-items:flex-start;">
								<div>
									<strong>Terms &amp; Conditions</strong><br>
									E.&amp; O.E.<br>
									1. All mobile phone sales are on a cash basis only.<br>
									2. Accessories purchases are allowed on a 1 month credit basis.<br>
									3. All cheques should be written in favor of "<b>Y5 Hut</b>".
								</div>
								<div style="text-align:center; margin-left:10px;">
									<img src="<?php echo $qrImageUrl; ?>" alt="QR Code" style="display:block; margin:0 auto;" />
									<small style="display:block; text-align:center;">Scan for invoice&nbsp;&nbsp;&nbsp;</small>
								</div>
							</div>
							<div><?php echo xpowerDetail()['invoiceFooter'] ?></div>
						</td>

						<!-- Signatures -->
						<td style="width:35%; vertical-align:top; padding:6px; border:1px solid #000; border-top:none; position:relative; height:120px;">
							<!-- Receiver Signature -->
							<div style="font-weight:bold; padding-bottom:5px;">Receiver’s Signature :</div>
							<div style="border-bottom:1px solid #000; margin-bottom:20px;"></div> <!-- Line below receiver -->

							<!-- For Y5HUT Accessories -->
							<div style="text-align:center; font-weight:bold; padding-bottom:10px;">For <?php echo $res_com['name'] ?></div>

							<!-- Authorised Signatory at bottom center -->
							<div style="position:absolute; bottom:6px; left:50%; transform:translateX(-50%); text-align:center; font-weight:bold;">
								Authorised Signatory
							</div>
						</td>
					</tr>
				</table>


		<?php
				echo '</td>
				</tr>
				<tr>
                <td colspan="9" style="' . $height . '"></td>				                
             </tr>	
			 ';
				echo '
			 <tr>
    <th style="border-left:1px solid #000; width:10px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">S.N</th>
		    <th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Code</th>
    <th colspan="2" style="width:300px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Description Of Goods</th>
    <th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Qty</th>
    <th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Unit</th>
    <th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">List Price</th>
    <th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Discount</th>
    <th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Price</th>
    <th style="width:80px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Amount</th>
</tr>

					
                </tr>
			';
			}


			$itemWarr = $itemtableDet['warranty'] != '' ? $itemtableDet['warranty'] : '';
			$warnty   = trim($itm['warrenty']) != '' ? '- ' . $itm['warrenty'] . '' : '';

			$itemExDet = '';
			if ($itemWarr != '' || $warnty != '') {
				$itemExDet = '<br>' . $itemWarr . ' ' . $warnty;
			}

			$lineBold = '';
			if ($res_fixedPrice['qty'] <= $res_fixedPrice['reorder2'] && $res_fixedPrice['reorder2'] != 0) {
				$lineBold = 'style="font-weight:bold;"';
			}

			$itmDescription = $itm['Description'] . $itemExDet;

			$qry_ime = $mysqli->query("SELECT `imei`, `itmColor` FROM `pur_imei_items` WHERE `inv_id`='$invID' and `itm_code`='" . $itm['ItemNo'] . "' and `br_id`='$br_id' ");
			$imeiCount = $qry_ime->num_rows;

			if ($imeiCount == TRUE) {
				while ($imes = $qry_ime->fetch_array()) {
					$imNo++;
					$imeLst .= $imes[0] . ' (' . $imes[1] . '), ';
				}
			}
			$imeLst1 = $imeLst != '' ? '<br> - ' . $imeLst : '';
			$disVal = '';
			$priceVal = '';
			if ($itm['mysql_db'] == 'D' || $itm['mysql_db'] == '') {
				$disVal = number_format($disPer) . '%';
				$priceVal = ($fixedPrice / 100) * (100 - $disPer);
			} else if ($itm['mysql_db'] == 'C' || $itm['mysql_db'] == 'Q') {
				$disVal = number_format((($fixedPrice * $qty) / 100 * $disPer) / $qty, 2);
				$priceVal = $fixedPrice - $disVal;
			}

			echo '<tr ' . $lineBold . '>
    <td style="vertical-align:top; border-left:1px solid #000; text-align:center;">' . $lineNo++ . '</td>
	    <td align="center" style="vertical-align:top; border-left:1px solid #000; ">' . $itm['ItemNo'] . '</td>
    <td colspan="2" style="vertical-align:top; border-left:1px solid #000; ">' . $itmDescription . ' ' . substr($imeLst1, 0, -2) . '</td>
    <td align="center" style="vertical-align:top; border-left:1px solid #000; ">' . $qty . '</td>
    <td align="center" style="vertical-align:top; border-left:1px solid #000; ">' . $itm['Unit'] . '</td>
    <td align="right" style="vertical-align:top; border-left:1px solid #000; ">' . numFormt2($fixedPrice) . '</td>
    <td align="right" style="vertical-align:top; border-left:1px solid #000; ">' . $disVal . '</td>
    <td align="right" style="vertical-align:top; border-left:1px solid #000; ">' . numFormt2($priceVal) . '</td>
    <td align="right" style="vertical-align:top; border-left:1px solid #000; border-right:1px solid #000;">' . numFormt2($finTot) . '</td>
</tr>';

			$qtyTot += $qty;
$desCount = strlen($itmDescription);
$imeiCount = strlen($imeLst1);
$brLines = substr_count($itmDescription, '<br>') + substr_count($imeLst1, '<br>');
$sumLen = $imeiCount + $desCount;

if ($sumLen > 35) {

    // sumLen triggered, so increment once
    $lin_No++;
    $i++;

} else if ($brLines > 0) {

    // sumLen not triggered, so apply brLines count
    $lin_No += $brLines;
    $i += $brLines;
}


			$lin_No++;
			$i++;



			if ($lin_No == 33 && $i >= 33) {
				$i = 1;
				$newHeader = true;
			} else {

				if ($i == 44) {
					$i = 1;
					$newHeader = true;
				}
			}
		}

		if ($itemCount < 28) {
			while ($i <= 23) {
				echo '<tr>
    <td style="border-left:1px solid #000; ">&nbsp;</td>
	    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td colspan="2" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>';

				$i++;
			}
		} else if ($itemCount > 28 && $i != 1) {
			while ($i <= 44) {
				echo '<tr>
    <td style="border-left:1px solid #000; ">&nbsp;</td>
	    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td colspan="2" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; ">&nbsp;</td>
    <td align="right" style="border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>';

				$i++;
			}
		}
		echo '
			</tbody>
		</table>';



		if (trim($inv['vat_percnt']) > 0) {
			$vatPer = trim($inv['vat_percnt']);
			$vatAmnt = ($tot * $vatPer)  /  (100 + $vatPer);

			$comVatNo = (trim($res_com['vat_no']) !== '') ? trim($res_com['vat_no']) : ' - ';
			$cusVatNo = (trim($inv['vat_no']) !== '') ? trim($inv['vat_no']) : ' - ';
		} else {
			$disBord = 'border-bottom:1px solid #000;';
		}

		$invDiscnt = ($inv['Sdisc'] > 0) ?  '(' . numFormt2($inv['Sdisc']) . ')' :  numFormt2($inv['Sdisc']);

		?>

		<?php
		$previewLink = shortUrl($_SERVER['HTTP_HOST'] . "/x/i.php?i=" . urlencode(base64_encode($inv['invTb'] . "||XP||" . $com_id)));
		$qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$previewLink}&size=80x80"; // smaller QR
		?>
		<!-- Grand Total Table -->
		<!-- Totals Table -->
		<table style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif; font-size:14px; border:1px solid #000; border-bottom:none;">
			<tr>
				<th style="border-left:1px solid #000; width:10px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th colspan="2" style="width:300px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000;">Total Qty</th>
				<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "><?php echo $qtyTot ?></th>
				<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:70px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Grand Total</th>
				<th style="width:80px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;"><?php echo number_format($tot, 2) ?></th>
			</tr>
			<tr>
				<td colspan="10" style="border:1px solid #000; font-weight:bold; font-size:10px;">LKR <?php echo strtoupper(numberToWords($tot)); ?> ONLY</td>
			</tr>
			<tr>
				<th style="border-left:1px solid #000; width:10px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th colspan="2" style="width:300px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:70px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Paid</th>
				<th style="width:80px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;"><?php echo number_format($inv['cusPaid'], 2) ?></th>
			</tr>
			<tr>
				<th colspan="4" style="width:300px; text-align:left; border-top:1px solid #000; border-bottom:1px solid #000; ">Total Outstanding: <?php echo number_format($res_outStnd[0], 2) ?></th>
				<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:30px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:70px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:50px; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; "></th>
				<th style="width:70px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">Balance</th>
				<th style="width:80px; text-align:right; border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;"><?php echo number_format($balText, 2) ?></th>
			</tr>


		</table>

		<!-- Terms and Signature Section -->
		<table style="width:100%; border-collapse:collapse; border:1px solid #000; border-top:none; font-family:Arial, sans-serif; font-size:13px;">
			<tr>
				<!-- Terms & Conditions with QR on top right -->
				<td style="width:65%; vertical-align:top; padding:6px; border:1px solid #000; border-top:none; position:relative;">
					<div style="display:flex; justify-content:space-between; align-items:flex-start;">
						<div>
							<strong>Terms &amp; Conditions</strong><br>
							E.&amp; O.E.<br>
							1. All mobile phone sales are on a cash basis only.<br>
							2. Accessories purchases are allowed on a 1 month credit basis.<br>
							3. All cheques should be written in favor of "<b>Y5 Hut</b>".
						</div>
						<div style="text-align:center; margin-left:10px;">
							<img src="<?php echo $qrImageUrl; ?>" alt="QR Code" style="display:block; margin:0 auto;" />
							<small style="display:block; text-align:center;">Scan for invoice&nbsp;&nbsp;&nbsp;</small>
						</div>
					</div>
					<div><?php echo xpowerDetail()['invoiceFooter'] ?></div>
				</td>

				<!-- Signatures -->
				<td style="width:35%; vertical-align:top; padding:6px; border:1px solid #000; border-top:none; position:relative; height:120px;">
					<!-- Receiver Signature -->
					<div style="font-weight:bold; padding-bottom:5px;">Receiver’s Signature :</div>
					<div style="border-bottom:1px solid #000; margin-bottom:20px;"></div> <!-- Line below receiver -->

					<div style="text-align:center; font-weight:bold; padding-bottom:10px;">For <?php echo $res_com['name'] ?></div>

					<!-- Authorised Signatory at bottom center -->
					<div style="position:absolute; bottom:6px; left:50%; transform:translateX(-50%); text-align:center; font-weight:bold;">
						Authorised Signatory
					</div>
				</td>
			</tr>
		</table>




		<?php
		echo '
		<!-- Grand Total Row -->


</div>
</div>';



		?>

	</div>




</body>

</html>