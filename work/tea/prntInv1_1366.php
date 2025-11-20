<?php
include('path.php');
require_once  $path . '../function.php';
require_once $path . '../session_file.php'; //include($path.'../.php');
require_once $path . 'connection.php';

if (isset($_GET['BID_PRINT'])) {
    $INVNO = $_GET['BID_PRINT'];
    if (isset($_GET['duplct'])) {
        $duplct = '<span style="font-size:12px"> Duplicate </span>';
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
            border-bottom: 2px solid black;
            border-top: 1px solid black;
            margin: 0px;
            padding: 2px;
            padding-right: 2px;
            background-color: #cccccc;
            text-align: left;
        }



        table tr.odd {
            background-color: #AAAAAA;
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
                size: auto;
                margin: 5mm 0mm 0mm 0mm;
                margin-left: -2px;
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

    // echo '<div class="" style="height:auto;width:100%; ' . $mw . ' " align="left">';

    if ($com_id == 1362) {
        echo '<div style="height:auto;width:90%; margin:0 auto;" align="center">';
    } else {
        echo '<div class="" style="height:auto;width:100%; ' . $mw . ' " align="left">';
    }

    $sql_com = $mysqli->query("SELECT name, tel, fax, address, email, invoiceText, fullName, web_comdetail_eng, brImg FROM com_brnches WHERE ID='$br_id'");
    $res_com = $sql_com->fetch_array();
    $mw = '';

    $sql_invDet = $mysqli->query("SELECT Time,Balance,invoice.Location, invoice.Date, cusName,custtable.Address,custtable.TelNo, invoice.RepID, InvTot, RcvdAmnt,
                                    Sdisc ,cusPaid ,invoice.CusID, invoice.ID as invTb, invoice.vat_percnt
                                    FROM invoice LEFT JOIN custtable ON 
                                    invoice.CusID = custtable.CustomerID WHERE InvNO='$INVNO' AND invoice.br_id = '$br_id' ");
    $res_invDet = $sql_invDet->fetch_array();

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
    <table border="0" style="width:100%" class="compnTb">
       	<tr>
			<td colspan="2"><div align="center">' . $duplct . '</div></td>                
        </tr>
        <tr>
        
	    <tr>
            <td colspan="2"><div align="center"> <h1 style="margin-bottom:0px; font-size: 20px;">' . $res_com['fullName'] . $res_com['web_comdetail_eng'] . ' ' . $ERRORhtml . '</h1> </div></td>                            
        </tr>
        <tr>
            <td colspan="2"><div align="center"> ' . $res_com['address'] . ' </div> </td>                            
        </tr> 
        <tr>
            <td colspan="2"><div align="center"> ' . $res_com['email'] . ' </div> </td>                            
        </tr>        
        <tr>
            <td colspan="2"><div align="center"> Tel-' . $res_com['tel'] . ' </div> </td>                            
        </tr>
        <tr>
            <td colspan="2"><div align="center"> <strong>&nbsp;</strong></div> </td>                            
        </tr>
	</table>';



    $cus_id = $res_invDet['CusID'];

    $note = (trim($res_invDet['Location']) != '' && $unitNote != '') ? $res_invDet['Location'] . '&nbsp; / &nbsp; ' : $res_invDet['Location'];

    if ($com_id == 320) {

        echo ' <table border="0" style="width:100%" class="billDet">   
     			
        <tr>
            <td width="70px">Salesman : ' . $res_invDet['RepID'] . ' </td>
             <td width="5px"> </td>
            
            <td width="110px" style="text-align:right;"> Invoice No. : ' . $INVNO . '</td>                                    
        </tr>
   
		 <tr>
            <td>  <span style="text-transform: capitalize;font-weight:bold"> ' . $res_invDet['cusName'] . '</span> 
			</td>
			
			 <td width="5px"> </td>
            <td width="110px" style="text-align:right;">Date : ' . $res_invDet['Date'] . ' ' . $res_invDet['Time'] . '</td>  
                                      
        </tr>
		
        <tr><td colspan="3">&nbsp;</td></tr>						                       						
    </table>';
    } else {

        echo ' <table border="0" style="width:100%" class="billDet">   
        <tr>
            <td valign="top"> <strong>CUSTOMER</strong>
            <td width="5px"> :&nbsp;</td>
            <td>  
                <span style="text-transform: capitalize;font-weight:bold"> ' . $res_invDet['cusName'] . '</span>
            </td>                           
        </tr>';

        if ($res_invDet['Address'] != '') {
            echo '<tr>
              <td width="70px" valign="top">Address  </td>
              <td width="5px" valign="top"> :&nbsp;</td>
              <td width="110px"> ' . $res_invDet['Address'] . '</td>
          </tr>';
        }
        if ($res_invDet['TelNo'] != '' && $com_id != 363) {
            echo '<tr>
              <td width="70px" valign="top">Tel.No </td>  
              <td width="5px"> :&nbsp;</td>                                
              <td width="110px"> ' . $res_invDet['TelNo'] . ' </td>
          </tr>';
        }

        $sql_Uname = $mysqli->query("SELECT salesrep.Name FROM salesrep WHERE salesrep.RepID  = '$res_invDet[RepID]' AND br_id='$br_id'");
        $fnRepNAME = $sql_Uname->fetch_array();
        $fnRepName = $fnRepNAME[0];
        echo '<tr>
            <td width="70px">Salesman</td>
             <td width="5px"> :&nbsp;</td>
            <td width="110px">' . $fnRepName . ' </td>  
        </tr>
        <tr>
            <td>Invoice No.</td>
            <td width="5px"> :&nbsp;</td>
            <td>' . $INVNO . '</td>
	     </tr>';


        echo '<tr>
                <td>Date</td>
                <td width="5px"> :&nbsp;</td>
                <td>' . $res_invDet['Date'] . ' ' . $res_invDet['Time'] . '</td>
        </tr>
        <tr><td colspan="3">&nbsp;</td></tr>						                       						
    </table>';
    }

    ?>


    <div class="">
        <table class="descTb" border="0px" style="width:100%">
            <thead>
                <?php
                //$com_id=320;

                
              if (trim($com_id) == 320) {
                    echo  ' <tr>
                        <th style="width:55px">Code</th>
                        <th style="width:105px"><div align="right">Qty</div></th>
                        <th style="width:60px"><div align="right">Rate</div></th>
                        <th style="width:60px"><div align="right">Disc</div></th>					             
                        <th style="width:85px"><div align="right">Value</div></th>					
                    </tr>';
                } else {
                    echo  ' <tr>
                        <th style="width:55px">Code</th>
                        <th style="width:105px"><div align="right">Rate</div></th>					
                        <th style="width:60px"><div align="right">Qty</div></th>
                        <th style="width:60px"><div align="right">Disc</div></th>
                        <th style="width:85px"><div align="right">Value</div></th>					
                    </tr>';
                } 

                ?>
            </thead>
            <tbody>
                <?php
                $sql_itm = $mysqli->query("SELECT ItemNO, Description, Quantity, Sprice, DiscPrcnt, DiscValue , UnitNo, Unit, diff_inv, warrenty
									FROM invitem  WHERE InvNO='$INVNO' AND br_id = '$br_id' ORDER BY ID ASC");
                $dis_tot = 0;
                $i = 0;
                while ($res_itm = $sql_itm->fetch_array()) {
                    $i++;
                    $qty = $res_itm['Quantity'];
                    $qty = (trim($res_itm['UnitNo']) == 2) ? numFormt2($qty * $res_itm['diff_inv']) : $qty;
                    $price = $res_itm['DiscValue'] / $qty;

                    if (trim($res_itm['DiscPrcnt']) > 0) {
                        $fixedPrice = ($res_itm['DiscPrcnt'] != 100) ? ($res_itm['Sprice'] / (100 - $res_itm['DiscPrcnt']) * 100) : 0;
                    } else {
                        $fixedPrice = $res_itm['Sprice'];
                    }

                    $tot1 = $qty * $fixedPrice;
                    $finTot = $tot1 * (100 - $res_itm['DiscPrcnt']) / 100;
                    $dis_tot += $tot1 - $finTot;

                    $qry_itm = $mysqli->query("SELECT `Location`,XWord FROM `itemtable` WHERE `ItemNO` ='" . $res_itm['ItemNO'] . "' ");
                    $itmNms = $qry_itm->fetch_array();

                    $sql_fixedPrice = $mysqli->query("SELECT sale_pr, salse_pr2, `qty`, `reorder2` FROM br_stock WHERE itm_code='" . $res_itm['ItemNO'] . "' AND br_id='$br_id' ");
                    $res_fixedPrice = $sql_fixedPrice->fetch_array();

                    $xword = str_replace("\\", "", $itmNms['XWord']);

                    
                    $discountAmount = numFormt2($fixedPrice - ($res_itm['DiscValue'])) ; 

                    if (trim($com_id) == 320) {


                        echo '
        	<tr>
                <td valign="top" style="font-size:12px;" >' . $res_itm['ItemNO'] . ' </td>
                <td colspan="4" > &nbsp; 
				<span style="font-size:12px; font-family:araliya; text-transform: none;" > ' . $xword . ' </span> </td>
        	</tr>';

                    echo '<tr>
                            <td>&nbsp; </td>
                            <td><div align="right" style="font-size:12px;" >' . $qty . ' </div></td>   
                            <td><div align="right" style="font-size:12px;">' . numFormt2($fixedPrice) . '</div></td>
                            <td><div align="right" style="font-size:12px;">' . numFormt2($fixedPrice)- numFormt2($res_itm['DiscValue']) . '</div></td>  
                            <td><div align="right" style="font-size:12px;">' . numFormt2($res_itm['DiscValue']) . '</div></td>
                        </tr>';
                    } else {

                        $lineBold = '';
                        if ($res_fixedPrice['qty'] <= $res_fixedPrice['reorder2'] && $res_fixedPrice['reorder2'] != 0) {
                            $lineBold = 'style="font-weight:bold;"';
                        }

                        echo '
        	<tr ' . $lineBold . '>';
                        if (trim($com_id) == 378) {
                            echo '
				  <td colspan="4"> ' . $i . '] ' . $res_itm['ItemNO'] . ' - ' . $xword . ' </td>';
                            echo '</tr>';
                            $dis = '';
                            if ($res_itm['DiscPrcnt'] != 0) {
                                $dis = $res_itm['DiscPrcnt'] . '% &nbsp;';
                            }

                            echo '<tr>
                 
				<td colspan="2"><div align="right">' . numFormt2($fixedPrice) . ' </div></td>  
                <td> <div align="right">' . $qty . ' </div></td>                         
                <td><div align="right"> <span style="text-align:left;"> ' . $dis . ' </span> ' . numFormt2($res_itm['DiscValue']) . '</div></td>
             </tr>';
                        } else {
                            $remarksVal = '';
                            if ($res_itm['warrenty'] != '') {
                                $remarksVal = "Remarks: " . $res_itm['warrenty'];
                            }


                            echo '<td valign="top">' . $res_itm['ItemNO'] . '</td>
				   <td colspan="3">' . $res_itm['Description'] . ' </td>';

                            echo '</tr>';


                            echo '<tr>
                                    <td><div align="right" style="text-align: left;">' . $remarksVal . ' </div> </td> 
                                    <td><div align="right">' . numFormt2($fixedPrice) . ' </div></td>  
                                    <td><div align="right">' . $qty . '  </div></td>
                                    <td><div align="right">' . numFormt2($fixedPrice - ($res_itm['DiscValue'])) . '</div></td>
                                    <td><div align="right">' . numFormt2($res_itm['DiscValue']) . '</div></td>
                                </tr>';
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="8">&nbsp; </td>
                </tr>
                <tr height="3px">
                    <td colspan="8" style="border:1px solid #000;border-left:none;border-right:none"> </td>
                </tr>
            </tbody>
        </table>
        <?php



        if (trim($com_id) == 320) {

            echo  '</br> <table border="0" class="finTb"  style="float:right;">    	
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Total </td>
            <td width="85px"><div align="right"> ' . numFormt2($res_invDet['InvTot']) . ' </div> </td>
        </tr>
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Received</td>
            <td width="85px"><div align="right">  ' . numFormt2($res_invDet['cusPaid']) . ' </div> </td>
        </tr>
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Balance </td>
            <td width="85px"><div align="right">  ' . numFormt2($res_invDet['InvTot'] - $res_invDet['cusPaid']) . '  </div> </td>
        </tr>
    </table>';
        } else {

            $cashType = ($res_invDet['cusPaid'] != 0) ? 'Cash' : 'Credit';

            echo  '</br> <table border="0" class="finTb" style="float:right;">  
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Inv Type </td>
            <td width="85px"><div align="right"> ' . $cashType . ' </div> </td>
        </tr>
    	<tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Inv.Discount </td>
            <td width="85px"><div align="right"> ' . numFormt2($res_invDet['Sdisc']) . ' </div> </td>
        </tr>
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Item.Discount </td>
            <td width="85px"><div align="right"> ' . numFormt2($dis_tot) . ' </div> </td>
        </tr>
        
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px" style="font-weight:bold; font-size:12px;">Total </td>
            <td width="85px"><div align="right" style="font-weight:bold; font-size:12px;"> ' . numFormt2($res_invDet['InvTot']) . ' </></div> </td>
        </tr>
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Received</td>
            <td width="85px"><div align="right">  ' . numFormt2($res_invDet['cusPaid']) . ' </div> </td>
        </tr>
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Balance </td>
            <td width="85px"><div align="right">  ' . numFormt2($res_invDet['InvTot'] - $res_invDet['cusPaid']) . '  </div> </td>
        </tr>
        <tr><td>&nbsp;</td></tr>';

            $sql_isUnitInfo = $mysqli->query("SELECT ID FROM optiontb WHERE opertionName='UnitInfor' AND optionPath ='Y' AND br_id='$br_id'");
            $isUnitInfo = $sql_isUnitInfo->num_rows;
            if ($isUnitInfo == true) {
                $unitNote = '';
                $seprater = '';
                $sql_unit = $mysqli->query("SELECT Unit, sum(Quantity) FROM invitem WHERE InvNo = '$INVNO' AND br_id = '$br_id'GROUP BY Unit ");
                while ($res_unit = $sql_unit->fetch_()) {
                    //$unitNote .= $seprater.''.$res_unit[0].' => '.$res_unit[1]; $seprater = ' &nbsp;|&nbsp; ';
                }
            }
            $note = (trim($res_invDet['Location']) != '' && $unitNote != '') ? $res_invDet['Location'] . '&nbsp; / &nbsp; ' : $res_invDet['Location'];


            $blnc = $res_invDet['Balance'];
            $sql_outStnd = $mysqli->query("SELECT SUM(Balance) FROM invoice WHERE CusID = '$cus_id' AND invoice.br_id = '$br_id' ");
            $res_outStnd = $sql_outStnd->fetch_array();

            if ($res_outStnd[0] != 0) {
                $outTot =  numFormt2($res_outStnd[0] - $blnc);
                echo '
          <tr>
              <td width="110px">&nbsp;  </td>
              <td width="135px">Outstanding Balance </td>
              <td width="85px"><div align="right">' . $outTot . '</td>
          </tr>';
            }


            echo '
        <tr>
            <td width="110px">&nbsp;  </td>
            <td width="135px">Total Balance</td>
            <td width="85px"><div align="right">' . numFormt2($res_outStnd[0]) . '</td>
        </tr>';
            if (trim($com_id) == 378) {
                echo '
          <tr>
            <td width="110px">&nbsp;  </td>
              <td width="135px">Checked By  </td>
              <td align="right" style="border-bottom:1px dashed #000" valign="bottom" >    </td>  
          </tr>
          ';
            }
            echo '  <tr>
          <td width="110px">&nbsp;  </td>
          <td width="110px">NOTE</td>
          <td width="85px"><div align="right">' . $note . ' ' . $unitNote . '</td>
          </tr>
    </table>
    <center>
    <img src="img/1366_qr.jpg" width="50%" height="auto">
    <center>
    
    ';

    
        }
        if ($com_id == 860) {
            echo '<hr/>
	        <p style="text-align:center; font-weight:bold;">RETRUN CANNOT BE ACCEPTED</p>	';
        } else {
            if ($res_com['invoiceText'] != '') {
                echo '
	        <hr/>
	        <p style="text-align:center; font-weight:bold;">' . $res_com['invoiceText'] . '</p>	
	     ';
            } else {
                echo '<p style="text-align:center; font-size:13px; font-weight:bold;"> Thank you come again.</p>
                ';
            }
        }
        echo'
        <table>
        <tr><td colspan="3" style="margin-top:30px;font-size:8px;">' . xpowerDetail()['invoiceFooter'] . ' </td>
        </tr></table>';

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
    if (trim($com_id) != 264 && trim($com_id) != 279 && trim($com_id) != 006 && trim($com_id) != 1217) {
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