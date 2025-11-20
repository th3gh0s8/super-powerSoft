<?php
include('path.php');
require_once  $path . '../function.php';
require_once $path . '../session_file.php'; //include($path.'../.php');
require_once $path . 'connection.php';

if (isset($_GET['BID_PRINT'])) {
    $INVNO = $_GET['BID_PRINT'];
    if (isset($_GET['duplct'])) {
        $duplct = '<table style="width:100%; margin-top:5px; margin-bottom:5px;">
        <tr>
            <td style="border-top:2px dashed; font-weight:bold !important; text-align: center; font-size:17px !important;">REPRINTED</td>
        </tr>';
    }
} else {
    $INVNO = $_SESSION['INV_ID'];
}
$com_id = trim($_SESSION['COM_ID']);
//$com_id =320;
//unset($_SESSION['INV_ID']);
//$INVNO = 'A-22965';
if ($com_id == 320) {
    $mw = 'margin-left: 0px;';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice Print Sheet</title>

    <style>
        /* POS Printer Font Override */
        body,
        table,
        th,
        
        span,
        div {
font-family: "OCR B Std", "OCR-B", monospace;
            font-size: 12px !important;
            /* Adjust size if needed */
        }

        @font-face {
            font-family: araliya;
            src: url(Logo/DL-Araliya.TTF);
        }

        table {
            border: 0px solid black;
            border-spacing: 0px;
        }

        table tr {
            font-family: Arial, monospace;
            font-size: 12px;
        }

        table tr th {
            border-top: 2px dashed black;
            border-bottom: 2px dashed black;
            margin: 0px;
            padding: 2px;
            padding-right: 2px;
            text-align: left;
        }



        table tr.odd {
            background-color: #AAAAAA;
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

        .billDet td {
            padding-left: 0px;
            padding-right: 0px;
            font-size: 11px;
        }

        .compnTb td {
            font-size: 11px;
        }

        .descTb th {
            font-size: 11px;
        }

        .descTb td {
            font-size: 10px;
        }

        .finTb td {
            font-size: 11px;
        }

        @media print {
            @page {
                margin-top:5px;
                margin-left:10px;
                margin-right:10px;
            }

            body {
                font-size: 12px;
                font-family: Verdana, Geneva, sans-serif;
                //margin: 5px ;	
                //margin-bottom:5px;
                
            }
        }
    </style>
</head>

<body onload="window.print() ">



    <?php

    echo '<div class="" style="height:auto;width:95%; ' . $mw . ' " align="left">';

    $sql_com = $mysqli->query("SELECT name, tel, fax, address, email, invoiceText, fullName, web_comdetail_eng, brImg FROM com_brnches WHERE ID='$br_id'");
    $res_com = $sql_com->fetch_array();
    $mw = '';

    $sql_invDet = $mysqli->query("SELECT Time,Balance,invoice.Location, invoice.Date, cusName,custtable.Address,custtable.TelNo, invoice.RepID, InvTot, RcvdAmnt,
                                    Sdisc ,cusPaid ,invoice.CusID, invoice.opAutoNo, invoice.ID as invTb, invoice.vat_percnt, invoice.Pdisc
                                    FROM invoice LEFT JOIN custtable ON 
                                    invoice.CusID = custtable.CustomerID WHERE InvNO='$INVNO' AND invoice.br_id = '$br_id' ");
    $res_invDet = $sql_invDet->fetch_array();
                    $repDet = $res_invDet['RepID'];

    $sql_invitem = $mysqli->query("SELECT SUM(DiscValue) as totDiscount FROM invitem WHERE invID = '$res_invDet[invTb]' AND br_id='$br_id'");
    $invitem = $sql_invitem->fetch_array();
    $invitemTotal = $invitem['totDiscount'] - $res_invDet['Sdisc'];
    if ($res_invDet['vat_percnt'] > 0) {
        $invitemTotal1 = $invitemTotal / 100 * (100 + $res_invDet['vat_percnt']);
    } else {
        $invitemTotal1 = $invitemTotal;
    }
    $ERRORhtml = '';

    if ((float)number_format($res_invDet['InvTot']) !== (float)number_format($invitemTotal1)) {
        $ERRORhtml = '<span style="color: red; font-weight:bold;">RE-CHECK</span>';
    }

//<div align="center"> <h1 style="margin-bottom:0px; font-size: 25px;">' . $res_com['fullName'] . ' </h1> </div>
    echo '	                                                 
    <table border="0" style="width:100%" class="compnTb">
        <tr>';
        
        if($res_com['brImg'] != ''){
            echo '
            <tr>
        		<td colspan="2"><div align="center"><img src="https://'.$_SERVER['HTTP_HOST'].'/Home/new/images/logo/'.$res_com['brImg'].'?3" style="width: 50%;" /></div></td>                
            </tr>
            ';
        }
        echo '



        <tr>
            <td colspan="2">
                <div align="center">
                    <strong style="font-size: 15px;">' . $res_com['fullName'] . '</strong>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div align="center"><strong> ' . $res_com['address'] . ' </strong></div> </td>                            
        </tr>        
        <tr>
            <td colspan="2"><div align="center"> <strong> Tel-' . $res_com['tel'] . '</strong> </div> </td>                            
        </tr>
        <tr>
            <td colspan="2"><div align="center"> <strong>&nbsp;</strong></div> </td>                            
        </tr>
	</table>';

$formattedReceipt = str_pad($res_invDet['opAutoNo'], 6, '0', STR_PAD_LEFT);


    $cus_id = $res_invDet['CusID'];

    $note = (trim($res_invDet['Location']) != '' && $unitNote != '') ? $res_invDet['Location'] . '&nbsp; / &nbsp; ' : $res_invDet['Location'];

    if ($com_id == 320) {

        echo ' <table border="0" style="width:100%" class="billDet">   
     			
        <tr>
            <td width="70px"><strong>Salesman : ' . $res_invDet['RepID'] . ' </strong></td>
             <td width="5px"> </td>
            
            <td width="110px" style="text-align:right;"><strong> Invoice No. : ' . $INVNO . '</strong></td>                                    
        </tr>
   
		 <tr>
            <td>  <span style="text-transform: capitalize;font-weight:bold"> <strong>' . $res_invDet['cusName'] . '</strong> </span> 
			</td>
			
			 <td width="5px"> </td>
            <td width="110px" style="text-align:right;"> <strong> Date : ' . $res_invDet['Date'] . ' ' . $res_invDet['Time'] . '</strong> </td>  
                                      
        </tr>
		
        <tr><td colspan="3">&nbsp;</td></tr>						                       						
    </table>';
    } else {

        echo ' <table border="0" style="width:100%" class="billDet">   
        <tr>
            <td valign="top"> <strong> C/S:  ' . $res_invDet['cusName'] . ' </strong>
            <td style="text-align:right;">  
                <span style=""><strong> S/M: ' . FindRepName('RepID', $repDet, $br_id)['Name'] . ' </strong> </span>
            </td>                           
        </tr>
        <tr>
            <td valign="top"> <strong>TEL: ' . $res_invDet['TelNo'] . ' </strong>
            <td style="text-align:right;">  
                <span style=""> <strong> INV NO: ' . $INVNO . ' </strong> </span>
            </td>                           
        </tr>						                       						
    </table>
    ' . $duplct . '
    </table>
    ';
    }

    ?>


    <div class="">
        <table class="descTb" border="0px" style="width:100%">
            <thead>
                <?php
                //$com_id=320;
                if (trim($com_id) == 320) {
                    echo  ' <tr>
                <th style="width:55px"><strong>Code</th>
				 <th style="width:105px"><div align="right"><strong>Qty</strong></div></th>
                <th style="width:60px"><div align="right"><strong>Rate</strong></div></th>					             
                <th style="width:85px"><div align="right"><strong>Value</strong></div></th>					
            </tr>';
                } else {

                    echo  ' <tr>
                <th style=" width:55px"><strong>PRODUCT</strong></th>
                <th style="width:105px"><div align="right"><strong>PRICE</strong></div></th>					
                <th style="width:60px"><div align="right"><strong>QTY</strong></div></th>                
                <th style="width:85px"><div align="right"><strong>AMOUNT</strong></div></th>					
            </tr>';
                }

                ?>
            </thead>
            <tbody>
                <?php
                $k = 1;
                
                $sql_itm = $mysqli->query("SELECT ItemNO, Description, Quantity, Sprice, DiscPrcnt, DiscValue , UnitNo, Unit, diff_inv, warrenty, ID
									FROM invitem  WHERE InvNO='$INVNO' AND br_id = '$br_id' ORDER BY ID ASC");
                $dis_tot = 0;
                $i = 0;
                $imeLst='';
                while ($res_itm = $sql_itm->fetch_array()) {
                    $i++;
                    $qty = $res_itm['Quantity'];
                    $qty = (trim($res_itm['UnitNo']) == 2) ? numFormt2($qty * $res_itm['diff_inv']) : $qty;
                    $price = $res_itm['DiscValue'] / $qty;

                    if (trim($res_itm['DiscPrcnt']) > 0) {
                        $fixedPrice = (($res_itm['Sprice'] / (100 - $res_itm['DiscPrcnt'])) * (100));
                    } else {
                        $fixedPrice = $res_itm['Sprice'];
                    }

                    $tot1 = $qty * $fixedPrice;
                    $finTot = $tot1 * (100 - $res_itm['DiscPrcnt']) / 100;
                    $dis_tot += $tot1 - $finTot;

                    

                    $qty = $res_itm['Quantity']; 
                    $tot1 = $qty * $fixedPrice;      // total before discount
                    $finTot = $tot1 * (100 - $res_itm['DiscPrcnt']) / 100; // after discount
                    $discountAmt = $tot1 - $finTot;  // discount amount
                    


                    $qry_itm = $mysqli->query("SELECT `Location`,XWord FROM `itemtable` WHERE `ItemNO` ='" . $res_itm['ItemNO'] . "' ");
                    $itmNms = $qry_itm->fetch_array();

                    $sql_fixedPrice = $mysqli->query("SELECT sale_pr, salse_pr2, `qty`, `reorder2` FROM br_stock WHERE itm_code='" . $res_itm['ItemNO'] . "' AND br_id='$br_id' ");
                    $res_fixedPrice = $sql_fixedPrice->fetch_array();

                    $xword = str_replace("\\", "", $itmNms['XWord']);

                        $lineBold = '';
                        if ($res_fixedPrice['qty'] <= $res_fixedPrice['reorder2'] && $res_fixedPrice['reorder2'] != 0) {
                            $lineBold = 'style="font-weight:bold;"';
                        }

                        echo '
        	<tr ' . $lineBold . '>';
                  
                            $remarksVal = '';
                            if ($res_itm['warrenty'] != '') {
                                $remarksVal = "Remarks: " . $res_itm['warrenty'];
                            }


                            echo '<td colspan="4" valign="top"><strong>' . $k++ . '. ' . $res_itm['Description'] . '</strong> </td>';

                            echo '</tr>';


            //   echo '<tr>
            //     <td><div align="right" style="text-align: left;"><strong>' . $res_itm['ItemNO'] . ' </strong></div> </td> 
			// 	<td><div align="right"><strong>' . numFormt2($fixedPrice) . '</strong></div></td>  
            //     <td><div align="right"><strong>' . $qty . ' </strong> </div></td>                         
            //     <td><div align="right"><strong>' . numFormt2($res_itm['DiscValue']) . '</strong></div></td>
            //  </tr>';

            echo '<tr>
            <td><div align="right" style="text-align: left;"><strong> </strong></div> </td> 
            <td><div align="right"><strong>' . numFormt2($fixedPrice) . '</strong></div></td>  
            <td><div align="right"><strong>' . $qty . ' </strong> </div></td>                         
            <td><div align="right"><strong>' . numFormt2($res_itm['DiscValue']) . '</strong></div></td>
         </tr>';


if (!empty(trim($res_itm['warrenty']))) {
    echo '<tr>
        <td colspan="4"><div align="left"><strong>Remarks: ' . htmlspecialchars($res_itm['warrenty']) . '</strong></div></td>
    </tr>';
}

// // Fetch IMEIs linked to the invoice item
$qry_ime = $mysqli->query("SELECT `imei` FROM `pur_imei_items` WHERE `invitem_tb`='" . $res_itm['ID'] . "' AND `itm_code`='" . $res_itm['ItemNO'] . "' AND `br_id`='$br_id'");
$imeiList = '';
$imNo = 0;

if ($qry_ime->num_rows > 0) {
    while ($ime = $qry_ime->fetch_array()) {
        $imNo++;
        $imeiList .= htmlspecialchars($ime['imei']) . ' / ';
    }
} else {
    // Fallback if no result in first query
    $qry_ime = $mysqli->query("SELECT `imei` FROM `pur_imei_items` WHERE `inv_id`='" . $res_invDet['invTb'] . "' AND `itm_code`='" . $res_itm['ItemNO'] . "' AND `br_id`='$br_id'");
    if ($qry_ime->num_rows > 0) {
        while ($ime = $qry_ime->fetch_array()) {
            $imNo++;
            $imeiList .= htmlspecialchars($ime['imei']) . ' / ';
        }
    }
}

// If there are IMEIs, show them in a new row
if (!empty(trim($imeiList))) {
    echo '<tr>
        <td colspan="4"><div style="font-size:10px;"><strong>IMEI(s):</strong> ' . rtrim($imeiList, ' / ') . '</div></td>
    </tr>';
}





            //  if ($res_itm['DiscPrcnt'] > 0) {
            //     $discountAmt = $tot1 - $finTot; // Total discount amount
            //     echo '<tr>


            //         <td colspan="2"><div align="right" style="text-align: left;"><strong>Promotional Discount</strong></div> </td> 
			// 	<td><div align="right"><strong>' . number_format($res_itm['DiscPrcnt'], 2) . '%</strong></div></td>  
            //     <td><div align="right"><strong>-' . number_format($discountAmt, 2) . ' </strong> </div></td>

            //     </tr>';
            // }
                            $subTot += $res_itm['DiscValue'];
                            $qtyTot += $qty;
                        
                    
                }

                // $sql_cuss = $mysqli->query("SELECT RepID FROM cusstatement WHERE Paid!=0 AND InvNo='$INVNO' AND br_id='$br_id'");
                // $typeText = '';
                // while ($paid = $sql_cuss->fetch_array()) {
                //     if ($paid[0] == '') {
                //         $typeText .= 'Cash ';
                //     }
                //     if ($paid[0] == 'Card') {
                //         $typeText .= ' Card ';
                //     }
                //     if ($paid[0] == 'Cheque') {
                //         $typeText .= ' Cheque ';
                //     }
                //     if ($paid[0] == 'CJournal') {
                //         $typeText .= ' Bank ';
                //     }
                // }

$typeText = '';

$paymentLines = [];

$sql_cuss = $mysqli->query("SELECT RepID, Remarks, Paid FROM cusstatement WHERE Paid != 0 AND InvNo = '$INVNO' AND br_id = '$br_id'");

while ($row = $sql_cuss->fetch_array()) {
    $method = $row['RepID'];
    $remarks = trim($row['Remarks']);
    $paidAmount = number_format($row['Paid'], 2);

    if ($method == '') {
        $paymentLines[] = ['label' => 'Cash', 'amount' => $paidAmount];
    } elseif ($method == 'Card') {
        $masked = $remarks;
        $cardType = 'Card';

        if (!empty($remarks)) {
            $firstChar = strtolower($remarks[0]);
            $numberPart = substr($remarks, 1); // Remove prefix letter

            if ($firstChar === 'v') {
                $cardType = 'Visa Card';
            } elseif ($firstChar === 'm') {
                $cardType = 'Master Card';
            } elseif ($firstChar === 'a') {
                $cardType = 'Amex Card';
            }

            if (ctype_digit($numberPart)) {
                $visibleDigits = strlen($numberPart);
                if ($visibleDigits < 16) {
                    $masked = str_repeat('X', 16 - $visibleDigits) . $numberPart;
                } else {
                    $firstDigit = substr($numberPart, 0, 1);
                    $last4 = substr($numberPart, -4);
                    $middleLength = strlen($numberPart) - 5;
                    $masked = $firstDigit . str_repeat('X', $middleLength) . $last4;
                }
            } else {
                $masked = $numberPart;
            }
        }

        $paymentLines[] = ['label' => $cardType . ' ' . $masked, 'amount' => $paidAmount];
    } elseif ($method == 'Cheque') {
        $paymentLines[] = ['label' => 'Cheque', 'amount' => $paidAmount];
    } elseif ($method == 'CJournal') {
        $paymentLines[] = ['label' => 'Bank', 'amount' => $paidAmount];
    }
}





                ?>

            </tbody>
        </table>
        <table style="width:100%; margin-top:10px;">
            <?php 
            if($res_invDet['Sdisc'] > 0){
                ?>
<tr>
                <td style="width:40%; border-top:2px dashed black; font-size:17px !important; font-weight:bold !important;">SUB TOTAL</td>
                <td style="text-align:center; border-top:2px dashed black;"></td>
                <td style="text-align:right; width:40%; border-top:2px dashed black; font-size:17px !important; font-weight:bold !important;"><?php echo number_format($subTot, 2) ?></td>
            </tr>
            <tr>
                <td style=""><strong>Discount</strong></td>
                <td style=" text-align:center;"><strong><?php echo number_format($res_invDet['Pdisc'], 2) ?>%</strong></td>
                <td style=" text-align:right;"><strong><?php echo number_format($res_invDet['Sdisc'], 2) ?></strong></td>
            </tr>
                <?php
            }else{
                $borderLine = 'border-top:2px dashed black;';
            }
            ?>
            
            <tr>
                <td style="<?php echo $borderLine ?>font-size:17px !important; font-weight:bold !important;">INV TOTAL</td>
                <td style="text-align:center; <?php echo $borderLine ?>"></td>
                <td style="<?php echo $borderLine ?>font-size:17px !important; font-weight:bold !important; text-align:right;">  <?php echo number_format($res_invDet['InvTot'], 2) ?></td>
            </tr>
            <?php 
            if($res_invDet['RcvdAmnt'] > 0){
                ?>
   <?php foreach ($paymentLines as $line): ?>
<tr>
    <td><strong><?php echo $line['label']; ?></strong></td>
    <td></td>
    <td style="text-align:right;"><strong><?php echo $line['amount']; ?></strong></td>
</tr>
<?php endforeach; ?>

                <?php
            }
            $bal = '';
            if($res_invDet['cusPaid']> $res_invDet['InvTot']){
                $bal = $res_invDet['cusPaid'] - $res_invDet['InvTot'];
            }else{
                $bal = $res_invDet['Balance'];
            }
            ?>
            
            <tr>
                <td style=" border-bottom:2px dashed black;"><strong>Balance</strong></td>
                <td style="border-bottom:2px dashed black; text-align:center;"></td>
                <td style=" border-bottom:2px dashed black; text-align:right;"><strong><?php echo number_format($bal, 2) ?></strong></td>
            </tr>
           <tr>
    <td colspan="3" style="padding-top:10px;  !important;">
        <table style="width:100%; font-size:7px; border-collapse:collapse;">
            <tr>
                <td style="text-align:left; font-size:10px ; font-weight:bold !important;">
                    No Of Items : <?php echo $sql_itm->num_rows; ?><br>
                    Print Date : <?php echo date('Y-m-d') ?>
                </td>
                <td style="text-align:right; font-size:10px ; font-weight:bold !important;">
                    QUANTITY: <?php echo number_format($qtyTot, 2) ?><br>
                    Time : <?php echo date('H:i:s') ?>
                </td>
            </tr>
        </table>
    </td>
</tr>

<?php
$totalDiscount = $res_invDet['Sdisc'] + $dis_tot;
if ($totalDiscount > 0) {
?>
    <tr>
        <td colspan="3" style="text-align:center; padding-top:10px; font-size:16px !important; font-weight:bold !important;">
            YOUR TOTAL DISCOUNT <?php echo number_format($totalDiscount, 2) ?>
        </td>
    </tr>
<?php
}
?>
            <tr>
                <td colspan="3" style="text-align:center; padding-top:10px; font-size:8.5px ; font-weight:bold !important;">
                    ------------------------------<br>
                    THANK YOU FOR SHOPPING @  <?php echo $res_com['fullName'] ?><br>
                    ------------------------------
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:center; padding-top:10px; font-size:8.5px ; font-weight:bold !important;">
                    <?php
                        if ($res_com['invoiceText'] != '') {
                            echo '
                            <p style="text-align:center; font-weight:bold;">' . nl2br($res_com['invoiceText']) . '</p>	
                        ';
                        } 
                    ?>
                    <?php 
                        $previewLink = shortUrl($_SERVER['HTTP_HOST']."/x/i.php?i=".urlencode(base64_encode($res_invDet['invTb']."||XP||".$com_id)));
                        $qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?data={$previewLink}&size=100x100";
                    ?>
                    <br>
                    <img src="<?php echo $qrImageUrl; ?>" alt="QR Code" style="margin-bottom:5px;" />
                    <br>
                    <small>Scan to view invoice</small>

                    <br><br>
                    <?php echo xpowerDetail()['invoiceFooter'] ?>
                </td>
            </tr>
        </table>

        <?php




        ?>


        </br>
        <?php
        /*if(trim($com_id) == 378){
        echo '</br> <table  style="text-align:center;  border: 2px solid black; width:100%;" class="delv_det">
          <tr>
        <td > Exchange is possible within 3 month of purchase, Item need to be original condition and accompanied with  the receipt.
        </br> No warranty issued on the OE items purchases
        </br> No warranty issued on the electrical items  </td>
        </tr>
        <tr> 
        <td align="center"> 
        <b> Thank You Come Again. </b>
         <span style="float: right; text-align:right; margin-top:3px;font-size:10px;">
         Software by POWERSOFT - 0722 693 693
         </span> </td>
        </tr>
        
            </table> 
        
         ';
      }*/
        ?>
    </div>

    <?php
    if (trim($com_id) != 264 && trim($com_id) != 279 && trim($com_id) != 006) {
        echo '
        <script type="text/javascript"> 
            window.onload= function () { window.print(); 
            setTimeout(function () {
              window.close();
            }, 10);
               } 
        </script>
        ';
    }
    ?>

</body>

</html>