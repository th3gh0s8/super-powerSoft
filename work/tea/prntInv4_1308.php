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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
				margin-top: 0mm;
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

				// $sql_com = $mysqli->query("SELECT name, tel, fax, address, vat_no, fullName, invoiceText  FROM com_brnches WHERE ID='$br_id'");
				// $res_com = $sql_com->fetch_array();

	$sql_com = $mysqli->query("SELECT name, tel, fax, address, vat_no, fullName, brImg, email, web_email, invoiceText FROM com_brnches WHERE ID='$br_id'");
	$res_com = $sql_com->fetch_array();

    $logo_path_prefix = '/Home/new/images/logo/'; 
    $logo_html = ''; 
    if (!empty($res_com['brImg'])) {
        $full_logo_path = $logo_path_prefix . $res_com['brImg'];
        $logo_html = '<img src="' . $full_logo_path . '" alt="Logo" style="max-width: 150px; height: 100;">';
    }
    


				$sql_inv = $mysqli->query("SELECT invoice.Date, invoice.NowTime , invoice.ID, invoice.order_id, invoice.CusID, invoice.RepID, invoice.br_id, invoice.br_id, RcvdAmnt, cusPaid, 
						   invoice.InvTot, Balance, invoice.Sdisc, purchNo, vat_percnt, vat_no, invoice.Location, invoice.ShowType, cusstatement.settlment_date FROM invoice LEFT JOIN cusstatement ON 
						   invoice.InvNO  = cusstatement.InvNo  
						   WHERE invoice.InvNO ='$INVNO' AND invoice.br_id = '$br_id' ORDER BY invoice.InvNO DESC LIMIT 1");
				$inv = $sql_inv->fetch_array();


	// 			echo '<table style="width:100%; margin-top:10px; border-collapse:collapse;">
    //     <tr>
    //         <td style="width:15%;"></td>';

	// 			if ($inv['ShowType'] == 'HIDE') {
	// 				echo '<td style="width:60%; text-align:center; vertical-align:top;">
    //         <h2 style="margin:0; font-size:30px; font-family:sans-serif;">' . $res_com['fullName'] . '</h2>
    //       </td>';
	// 			} else {
	// 				echo '<td style="width:60%; text-align:center; vertical-align:top;">
    //         <h2 style="margin:0; font-size:30px; font-family:sans-serif;">' . $res_com['name'] . '</h2>
    //       </td>';
	// 			}

	// 			echo '<td style="width:15%; text-align:right; vertical-align:top;">' . $duplct . '</td>
    //     </tr>
    //   </table>';


				$cus_id = trim($inv['CusID']);
				$invDate = $inv[0];
				$mnth = substr($invDate, 5, 2);
				$mnth = month_crt($mnth);

				$newDate = date_format(date_create($invDate), 'Y-m-d');


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

				$invID = $inv['ID'];
// --- Social Media Section using Font Awesome ---
$social_media_html = '
<div style="margin-top:1px; font-size:13px; text-align:center;">
    <div> <i class="fab fa-facebook" style="color:#1877F2; margin-right:6px;"></i> computer zone </div>
    <div style="margin-top:1px;"> <i class="fab fa-instagram" style="color:#E4405F; margin-right:6px;"></i> tcomputer zone </div>
</div>';

echo '
<table style="width:100%;">
    <tr>
        <td style="width:20%; text-align:center;">
            ' . $logo_html . '
            ' . $social_media_html . '
        </td>
        <td style="width:70%; text-align:right;">
            <span style="font-size: 25px; font-weight: bold;">' . $res_com['fullName'] . '</span><br>
            <span style="font-size: 14px;">' . nl2br($res_com['address']) . '</span><br>
            <span style="font-size: 14px;">Contact No :  ' . $res_com[1] . ' ' . $faxMessage . '</span><br>
			<span style="font-size: 14px;">Email : ' . $res_com['email'] . '</span><br>
			<span style="font-size: 14px;"> ' . $res_com['web_email'] . '</span>
			
            
        </td>
    </tr>
</table>';


				echo '<table border="1" style="width:100%" class="delv_det">
				<td colspan="2" align="center" style="border-top:1px solid black;"> 
			
				';
				if ($res_com['vat_no'] != '') {
					echo '
				<tr>
				<td colspan="2" align="center"> 
					<span style="font-size:12px">VAT No: ' . $res_com['vat_no'] . '</span>					
				</td>
			</tr>
				';
				}
				if (trim($inv['vat_percnt']) > 0 || (trim($res_cusName['vatNo']) !== '' && trim($res_cusName['vatNo']) !== '0')) {
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
				}

// Prepare Customer VAT display
$cusVat = $res_cusName['vatNo'] != '' ? '<br><strong>Cus VAT:</strong> ' . $res_cusName['vatNo'] : '';

// Find Sales Person Name
$salesPerson = FindRepName('RepID', $repDet, $br_id)['Name'];

// Get Outstanding Balance
$sql_outStnd = $mysqli->query("SELECT SUM(Balance) FROM invoice WHERE CusID = '$cus_id' AND invoice.br_id = '$br_id'");
$res_outStnd = $sql_outStnd->fetch_array();
$outstandingBal = numFormt2($res_outStnd[0]);

// Split layout: Left = Customer Details, Right = Invoice Details
echo '
<tr>



	<td style="width:60%; vertical-align:top; padding:5px; line-height:1.2;">
    <h4 style="margin:0 0 2px 0; padding:0; font-size:14px;">Customer Details</h4>
    <span style="font-size:15px; text-transform:capitalize; line-height:1.2;">
        ' . $res_cusName[0] . '
    </span><br>
    <span style="line-height:1.2;"> ' . $res_cusName[1] . '<br></span>
    <span style="line-height:1.2;">' . $res_cusName[2] . '</span>
     ' . $cusVat . '
</td>


<td style="width:40%; vertical-align:top; padding:2px; text-align:left;">
    <table style="width:100%;  font-size:13px;">
        <tr>
            <td style="width:40%; padding:3px;"></td>
            <td style="width:5%; padding:3px;"></td>
            <td style="padding:3px;">' . $duedays_text . '</td>
        </tr>
        <tr>
            <td style="padding:3px;">Invoice No</td>
            <td style="padding:3px;">:</td>
            <td style="padding:3px;">' . $INVNO . '</td>
        </tr>
        <tr>
            <td style="padding:3px;">Date</td>
            <td style="padding:3px;">:</td>
            <td style="padding:3px;"> ' . $newDate . '  ' . $time . '</td>
        </tr>

        <tr>
            <td style="padding:3px;">Cashier</td>
            <td style="padding:3px;">:</td>
            <td style="padding:3px;">' . $salesPerson . '</td>
        </tr>
        <tr>
            <td style="padding:3px;">Total Due</td>
            <td style="padding:3px;">:</td>
            <td style="padding:3px;">' . $outstandingBal . '</td>
        </tr>
    </table>
</td>

</tr>
';

echo '</table>';

		// 		$cusVat = $res_cusName['vatNo'] != '' ? '<br>Cus Vat: ' . $res_cusName['vatNo'] : '';

		// 		echo '
		// 	<tr>
		// 		<td> 
		// 			<span style="text-transform: capitalize;font-size:15px">' . $res_cusName[0] . ' </span>
		// 			&nbsp;&nbsp;&nbsp; ' . $res_cusName[1] . '&nbsp;&nbsp;&nbsp; ' . $res_cusName[2] . ' ' . $cusVat . '
		// 		</td>
		// 		<td align="right">' . $duedays_text . '</td>
		// 	</tr>			
		// 	<tr>
		// 		<td align="left"> Invoice No  &nbsp;&nbsp;' . $INVNO . ' </td>
		// 		<td align="right" colspan=""> ' . $purchNo . ' ' . $mnth . '  ' . $newDate . ' &nbsp;&nbsp;&nbsp;' . $time . '&nbsp;</td>								
		// 	</tr>									
		//   </table>';
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
		// echo '<div id="Person-' . $INVNO . '" class="box">
        // <div class="box-header" style="height:auto">
        // </div>
        // <div class="box-content box-table">
        // <table class="" border="0px"  style="width:100%">
        //     <thead>
        //         <tr>
		// 			<th style="width:5%">#</th>
        //             <th colspan="2" style="width:40%">product</th>
        //             <th style="width:25%">Warrenty </th>
		// 			<th style="width:10%"><div style="text-align:right;padding-right:6px">Qty</div></th>
		// 			<th style="width:10%"><div style="text-align:right;padding-right:6px">Unit price</div></th>
				
		// 			<th style="width:10%"><div style="text-align:right;padding-right:10px">Amount</div></th>					
        //         </tr>
        //     </thead>
        //     <tbody>
            
        //     ';

		echo '
<table class="invoice-table" border="1" cellspacing="0" cellpadding="4" style="width:100%; border-collapse:collapse; margin-top:10px;">
<thead style="background-color:#f0f0f0;">
    <tr style="border-bottom:1px solid #000;">
        <th style="width:5%; text-align:center;">#</th>
        <th colspan="2" style="width:40%; text-align:left;">Product</th>
        <th style="width:25%; text-align:left;">Warranty</th>
        <th style="width:10%; text-align:right;">Qty</th>
        <th style="width:10%; text-align:right;">Unit Price</th>
        <th style="width:10%; text-align:right;">Amount</th>
    </tr>
</thead>
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

			$warnty = (trim($itm['warrenty']) != '') ? ' [ ' . $itm['warrenty'] . ' ]' : '';
			$lineBold = '';
			if ($res_fixedPrice['qty'] <= $res_fixedPrice['reorder2'] && $res_fixedPrice['reorder2'] != 0) {
				$lineBold = 'style="font-weight:bold;"';
			}

			$itemType = (trim($itemtableDet['Type']) != '') ? '  ' . $itemtableDet['Type'] : '';

			$itmDescription = $itm['Description'] . $warnty . $itemType;

			$itemTableWarranty = isset($itemtableDet['warranty']) ? $itemtableDet['warranty'] : '';


			$qry_ime = $mysqli->query("SELECT `imei`, `itmColor` FROM `pur_imei_items` WHERE `inv_id`='$invID' and `itm_code`='" . $itm['ItemNo'] . "' and `br_id`='$br_id' ");
			$imeiCount = $qry_ime->num_rows;

			if ($imeiCount == TRUE) {
				while ($imes = $qry_ime->fetch_array()) {
					$imNo++;
					$imeLst .= $imes[0] . ' (' . $imes[1] . '), ';
				}
			}
			$imeLst1 = $imeLst != '' ? ' - ' . $imeLst : '';
			$disVal = '';
			$priceVal = '';
			if ($itm['mysql_db'] == 'D' || $itm['mysql_db'] == '') {
				$disVal = number_format($disPer) . '%';
				$priceVal = ($fixedPrice / 100) * (100 - $disPer);
			} else if ($itm['mysql_db'] == 'C' || $itm['mysql_db'] == 'Q') {
				$disVal = number_format((($fixedPrice * $qty) / 100 * $disPer) / $qty, 2);
				$priceVal = $fixedPrice - $disVal;
			}

echo '
<tr>
    <td style="text-align:center;">' . $lin_No . '</td>
    <td colspan="2" style="text-align:left;">' . $itm['ItemNo'] . ' - ' . htmlspecialchars($itm['Description']) . ' ' . $itemType . '' . substr($imeLst1, 0, -2) . '</td>
    <td style="text-align:left;">' . $itemTableWarranty . '</td>
    <td style="text-align:right;">' . $qty . '</td>
    <td style="text-align:right;">' . numFormt2($fixedPrice) . '</td>
    <td style="text-align:right;">' . numFormt2($finTot) . '</td>
</tr>
';

			$lin_No++;
			$i++;

			if ($lin_No == 10 && $i >= 10) {
				$i = 1;
				$newHeader = true;
			} else {

				if ($i == 19) {
					$i = 1;
					$newHeader = true;
				}
			}
		}

if ($itemCount < 1) {
            while ($i <= 1) {
                echo '<tr>
                <td colspan="7" style="border-bottom: none;">&nbsp;</td> 
               </tr>';
                $i++;
            }
        } else if ($itemCount > 4 && $i != 1) {
            while ($i <= 25) {
                echo '<tr>
                <td colspan="7" style="border-bottom: none; border-top: none;">&nbsp;</td> 
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
		// echo '
		// 	</tbody>
		// </table>
		// <table border="0" style="width:100%">
		//   <tr style="border:1px solid #000">
		// 	<td width="97px" style="border-top:1px solid #000;">Sales Person  </td>	
		// 	<td width="20px"  style="border-top:1px solid #000;"> : </td>
		// 	<td style="border-top:1px solid #000;"> ' . FindRepName('RepID', $repDet, $br_id)['Name'] . ' </td>					
		// 	<td width="130px"  style="border-top:1px solid #000;" align="right">  Discount:  ' . numFormt2($dis_tot) . ' </td>
		// 	<td align="right" width="100px"  style="border-top:1px solid #000;"> Inv.Discount </td>
		// 	<td align="right" width="100px" style="padding-right:10px;' . $disBord . ' border-top:1px solid #000"> ' . $invDiscnt . '</td>
		//   </tr>';


		// if (trim($inv['vat_percnt']) > 0 || (trim($res_cusName['vatNo']) !== '' && trim($res_cusName['vatNo']) !== '0')) {
		// 	$vatt = 100 + $inv['vat_percnt'];
		// 	$vatAmnt = ($tot * $inv['vat_percnt'])  /  ($vatt);
		// 	echo '
		//   <tr >
		// 	<td colspan="4" width="" >&nbsp;</td>
		// 	<td align="right" width="100px"  > VAT  &nbsp; ' . $inv['vat_percnt'] . '% </td>
		// 	<td align="right" width="100px" style="padding-right:10px;border-bottom:1px solid #000"> 
		// 		' . numFormt2($vatAmnt) . '
		// 	</td>
		//   </tr>';
		// }


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

// $tot is the final invoice total (InvTot)
// $inv['Sdisc'] is the total invoice discount applied

// Calculate the Subtotal (Total before the invoice-level discount Sdisc)
$subtotal_before_discount = $tot + $inv['Sdisc'];

// Calculate the Invoice Discount Percentage
// Ensure $subtotal_before_discount is not zero to prevent division by zero error
$discount_percentage = 0;
if ($subtotal_before_discount > 0) {
    $discount_percentage = ($inv['Sdisc'] / $subtotal_before_discount) * 100;
}
// Format the percentage to 2 decimal places
// $discount_percentage = number_format($discount_percentage, 2);


echo '

<tfoot style="border-top:1px solid #000; background-color:#f9f9f9;">
    <tr>
        
        <td colspan="3" style="width:50%;">&nbsp;</td>
        <td style="width:15%; font-weight:bold; text-align:right;">Total Qty</td>
        <td style="width:10%; text-align:right; font-weight:bold;">' . $itemCount . '</td>
        <td style="width:10%; text-align:right; font-weight:bold;">Subtotal</td>
        <td style="width:10%; text-align:right; font-weight:bold;">' . numFormt2($subtotal_before_discount) . '</td>
    </tr>
<tr style="background-color:#f9f9f9;">
    <td  colspan="5">&nbsp;</td>
    <td style="text-align:right; font-weight:bold;">Dis ' . $discount_percentage . '%</td>
    <td style="text-align:right; font-weight:bold;">' . numFormt2($inv['Sdisc']) . '</td>
</tr>
    
    <tr style="background-color:#e6e6e6; border-top:1px solid #000;">
        <td colspan="5">&nbsp;</td>
        <td style="text-align:right; font-weight:bold; border-left:1px solid #000; ">Total</td>
        <td style="text-align:right; font-weight:bold; border-left:1px solid #000; ">' . numFormt2($tot) . '</td>
    </tr>
</tfoot>
</table>
';

// --- NEW CODE BLOCK STARTS HERE ---
// Inserted code to display the invoice text centered.
if (!empty($res_com['invoiceText'])) {
echo '
<div style="width:100%; margin-top:10px; text-align:center; font-size:12px; font-weight:bold;">
    ' . nl2br($res_com['invoiceText']) . '
</div>
';
}



echo '
<!-- Warranty / Notice Section -->
<div style="width:100%; margin-top:5px; font-size:10px; line-height:1.4; text-align:justify;">
    <strong>Warranty (Return to Base)</strong><br>
The warranty covers only manufacturing defects. damage or defects due to other causes such as negligence, improper , operation power fluctuation , lightning or other natural disasters or accident , etc.. are not included under this warranty. repairs or replacement necessitated by such causes are not covered by the warranty and will be subject to change for labour ,time & material.<br>
No warranty for cartages , power adaptors, keyboard , mouse, speakers, physical damages & chip burns. warranty on any parts will be subject to the availability of the model at the time of claim. in the event the said model is not available. it will be replaced by a substitute model with a different payment or without additional payment.<br>
the computer zone pvt ltd will not take any responsibility for retrieving data that has been lost in media due to mishandling or virus infection.<br> 
A cheque should be drawn in favour of THE COMPUTER ZONE PVT LTD
</div>

<!-- Signature Table -->
<table border="0" style="width:100%; margin-top: 40px; text-align:center;">
<tr>
    <td style="width:30%; text-align:center; padding-top:30px;">
        <div style="border-top:1px dashed #000; width:80%; margin:0 auto;"></div>
        <div>Prepared by</div>
    </td>

    <td style="width:30%; text-align:center; padding-top:30px;">
        <div style="border-top:1px dashed #000; width:80%; margin:0 auto;"></div>
        <div>Authorised by</div>
    </td>

    <td style="width:30%; text-align:center; padding-top:30px;">
        <div style="border-top:1px dashed #000; width:80%; margin:0 auto;"></div>
        <div>Received By</div>
    </td>
</tr>

<tr>
    <td colspan="3" style="font-size:8px; padding-top:10px; text-align:center;">
        ' . xpowerDetail()['invoiceFooter'] . '
    </td>
</tr>
</table>
';





// 		echo '
// 		  <tr>
// 			<td valign="bottom" >Outstanding bal</td>	
// 			<td valign="bottom" > : </td>
// 			<td>' . numFormt2($res_outStnd[0]) . '</td>					
// 			<td> &nbsp;</td>
// 			<td  align="right" valign="bottom" ></td>
// 			<td  align="right"></td>
// 		  </tr>	
// 		  <tr height="35px">
// 			<td valign="bottom" >Approved By  </td>	
// 			<td valign="bottom" > : </td>
// 			<td align="right" style="border-bottom:1px dashed #000" valign="bottom" >    </td>					
// 			<td> &nbsp;</td>
// 			<td  align="right" valign="bottom" > <strong>Invoice Total</strong> </td>
// 			<td  align="right" style="padding-right:10px;border-bottom:1px solid #000" valign="bottom" > ' . numFormt2($tot) . ' </td>
// 		  </tr>	
// 		  <tr>
// 		  	<td colspan="4" valign="top" style="font-size:10px"> NOTE: ' . $note . ' ' . $unitNote . '</td>
// 			<td  align="right">Received </td>
// 			<td  align="right" style="padding-right:10px;" > ' . numFormt2($inv['cusPaid']) . ' </td>
// 		  </tr>
// 		  <tr>
// 		  	<td colspan="4">' . nl2br($res_com['invoiceText']) . '</td>
// 			<td  align="right">Balance </td>
// 			<td  align="right" style="padding-right:10px;" > (' . numFormt2($tot -  $inv['cusPaid']) . ') </td>
// 		  </tr>	
		  
// 		  <tr>
// 		  	<td colspan="6" style="margin-top:3px;font-size:8px;">' . xpowerDetail()['invoiceFooter'] . '</td>
// 		  </tr>
// 		</table>
// </div>
// </div>';



		?>

	</div>




</body>

</html>