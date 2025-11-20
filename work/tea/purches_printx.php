<?php
include('path.php');
require_once  $path.'../function.php';
require_once $path.'../session_file.php';//include($path.'../.php');
require_once $path.'connection.php';


if(isset($_GET['BID_PRINT'])){
	$P_NO = $_GET['BID_PRINT'];
	if(isset($_GET['duplct'])){
		$duplicte= 'GOODS RECEIVE NOTE (GRN - Duplicate)';
	}
}
else{
	$P_NO =$_SESSION['P_NO'];
//$P_NO ='P-270';
$duplicte= 'GOODS RECEIVE NOTE (GRN)';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Sheet</title>

<style>
table{
  border: 0px solid black;
  border-spacing: 0px;
}

table thead tr{
  font-family: Arial, monospace;
  font-size: 14px;
}

table thead tr th{
  border-bottom: 2px solid black;
  border-top: 1px solid black;
  margin: 0px;
  padding: 2px;
  background-color: #cccccc;
  text-align:left;
}

table tr {
  font-family: arial, monospace;
  color: black;
  font-size:12px;
  background-color: white;
}

table tr.odd {
  background-color: #AAAAAA;
}

table tr td, th{
  //border-bottom: 1px solid black;
  padding: 2px;
  padding-right: 10px;
}

.delv_det  td{
	border:none;	
}


table{
  border: 0px solid black;
  border-spacing: 0px;
}

table thead tr{
  font-family: Arial, monospace;
  font-size: 14px;
}

table thead tr th{
  border-bottom: 2px solid black;
  border-top: 1px solid black;
  margin: 0px;
  padding: 2px;
  background-color: #cccccc;
  text-align:left;
  font-weight: normal;
  font-size:12px;
}

table tr {
  font-family: arial, monospace;
  color: black;
  font-size:12px;
  background-color: white;
}

table tr.odd {
  background-color: #AAAAAA;
}

table tr td, th{
  //border-bottom: 1px solid black;
  padding: 2px;
  padding-right: 10px;
}

.delv_det  td{
	border:none;	
}

} 
</style>



</head>

<body onload="window.print() ">


<div align="center" style="width:100%">
<?php
$sql_com= $mysqli->query("SELECT * FROM `com_brnches` WHERE `ID`='".$br_id."'");
	$res_com = $sql_com->fetch_array();
	
   // echo '<h2 style="margin-bottom:0px">'.$res_com['comp_name'].' ' .$duplct.'</h2>';
    echo '<h4 style="margin-bottom:0px">'.$res_com['name'].' ' .$duplct.'</h4>';
	
	  echo $res_com['address'].'<br />
		 Tel : '.$res_com['tel'].' &nbsp;&nbsp; Fax : '.$res_com['fax'].' &nbsp;&nbsp; E- Mail : '.$res_com['email'].' </br>';
		 echo $duplicte;
		 ?>
  </div></br>

<div align="center" style="width:100%"	> 

</div>	
<div id="print_tbl" >   
<div id="Person" class="box">
    <div class="box-header" style="height:auto;width:100%" align="left">
                                       
    <?php
	$sql_P_no= $mysqli->query("SELECT * FROM `purchase` WHERE `P_No`='$P_NO' AND br_id = '$br_id' ");
//	`Balance`, `P_No`, `CQnumb`, `CQorCASH`, `Date`, `Discount`, `ExchangeOrder`, `ItemMark`, `Location`, `Paid`, `RefNo`, `ShowType`, `Term`, `Time`, `Total`, `TrChgs`, `VehNo`, `VendorID`, `ID`, `cloud`, `mysql_db`, `dueDate`, `Pass, vatPercnt, vatVal
	$P_N = $sql_P_no->fetch_array();	
	
	$vndr_id = $P_N['VendorID'];
	
	$sql_VndrInfo = $mysqli->query("SELECT `CompanyName`,`Address`, `Telno`, `VendorID` FROM `vendor` 					
						WHERE  ID = '$vndr_id'");
	$VndrInfo = $sql_VndrInfo->fetch_array();
	
	$sql_userInfo = $mysqli->query("SELECT `log_tb_id`, `user_name`, repID FROM `sys_users` WHERE `log_tb_id` = '$P_N[user_id]' AND br_id = '$br_id' ");			
	$userInfo = $sql_userInfo->fetch_array();
	
	$sql_rep_name = $mysqli->query("SELECT  `Name` FROM `salesrep` WHERE `RepID`='$userInfo[repID]' AND br_id = '$br_id'");
	$rep_name = $sql_rep_name->fetch_array();
	
	$mnth = date_format(date_create($P_N['Date']), 'm'); 	
	$mnth  = month_crt($mnth);
	
	$newDate = date_format(date_create($P_N['Date']), 'd Y');

	
	//echo '&nbsp;&nbsp;&nbsp;'.$odr[1];
	$time = date_create($P_N['Time']);
	$time = date_format($time , 'H:i:s');
	

	echo '<table border="0" style="width:100%" class="delv_det">
			<tr>
				<td> 
					<span style="text-transform: capitalize">'.$VndrInfo[0].' ('.$VndrInfo['VendorID'].') </span></br>';
					if($VndrInfo[1] == TRUE || $VndrInfo['2']== TRUE ){
					echo $VndrInfo[1].' / '.$VndrInfo['2'];
					}
				echo'</td>
				<td align="right"> '.$mnth .'  ' .$newDate.' &nbsp;&nbsp;&nbsp;'.$time.' </td>
			</tr>			
			<tr>
				<td> Ref Invoice No : '.$P_N['RefNo'].' </td>
				<td align="right"> GRN No : &nbsp;&nbsp;'.$P_NO.' </td>
			</tr>						
			
		  </table>';		 
	?>						
                                       			
    </div>                                    					
</div> 

<?php	



$i = 1;
$dis_tot = 0;
//echo '<img src="images/loading45.gif"  id="img_load_edit"/> ';
			
echo '<div>
        <div class="box-header" style="height:auto">
        </div>
        <div class="box-content box-table">
        <table class="" border="1px"  style="width:100%">
            <thead>
                <tr>
					<th width="5%"> No</th>
					<th width="8%">Item No</th>
					<th width="28%">Item Name</th>
					<th width="13%"> <div align="right">Cost (Rs) </div></th>
					<th width="6%"> <div align="right">Qty </div></th>	
					<th width="5%"> <div align="right">Dis % </div></th>					
					<th width="10%"> <div align="right">Total (Rs)</div></th>										
                </tr>
            </thead>
            <tbody>'; 
			
        $sql_itm = $mysqli->query("SELECT * FROM purchitem WHERE  P_No ='$P_NO' AND br_id = '$br_id' ORDER BY ID ASC");
        while($itm = $sql_itm->fetch_array()){	
        $ItemNo = $itm['ItemNo'];
		$sql_ItmInfo = $mysqli->query("SELECT ItemNO,Description,Sprice Stock FROM itemtable where ItemNO= '$ItemNo'");
		$ItmInfo = $sql_ItmInfo->fetch_array();
		$pric = $itm['Nprice'];
		$qty = $itm['QtyRcvd'];
		$i_total = $pric * $qty;
		$disPrct = $itm['disPrct'];
		$disPrice = $itm['disPrice'];
		$pric = $pric + $disPrice ;
		//,disPrct, disPrice 
		
        echo'<tr>
				<td>'.$i++.'</td>
                <td>'.$itm['ItemNo'].'</td>
                <td>'.$ItmInfo[1].' '.$itm['ItemMark'].' </td>
				<td align="right">'. number_format( $pric  ,2 ).'</td>
                <td align="right">'. $qty .'</td>  
				<td align="right">'. number_format( $disPrct ,2).'</td>              
				<td align="right">'. number_format( $i_total ,2).'</td>
             </tr>';
            }	
            
            
		echo '
		</tbody>
		<table style="width: 100%;">
		<tbody>
		<tr>
				<td rowspan="1" colspan="4">&nbsp;</td>				
				<td colspan="2" style="border-bottom:1px solid;"> </td>
				<td  align="right" style="border-bottom:1px solid;"> </td>
			  </tr>';
			  $sql_isVat = $mysqli->query("SELECT optionPath FROM optiontb WHERE opertionName='PHVAT' AND optionPath='YES'
												  AND br_id='$br_id'");
				$isVatCount = $sql_isVat->num_rows;
				$sql_paidTot = $mysqli->query("SELECT SUM(Paid) FROM venstatement WHERE br_id ='$br_id' AND P_No = '$P_NO'");
				$paidTot = $sql_paidTot->fetch_assoc()[0];
						//<!-- VAT -->
                         $tax = $P_N['vatPercnt'];
						 $taxVal = $P_N['vatVal'] ;
						
			if($P_N['disVal'] != 0){
			    	echo '<tr>
        				<td colspan="4" align="left"></td>
        			  	<td colspan="2">Discount</td>
        				<td  align="right" style=""> 
        					'. number_format( $P_N['disVal'] ,2 ).' 
        				</td>
        			  </tr>';
			}
		
			  
		echo '<tr>
				<td colspan="4" align="left"> Invoiced By : &nbsp;&nbsp; '.$rep_name[0].' </td>
			  	<td colspan="2"> <strong>Invoice Total</strong> </td>
				<td  align="right" style=""> 
					'. number_format( $P_N['Total']-$taxVal ,2 ).' 
				</td>
			  </tr>';
			   if($isVatCount > 0){
			  echo '<tr>
				<td colspan="4" align="left"></td>
			  	<td colspan="2"> <strong>Tex ( '.$tax.'% )</strong> </td>
				<td  align="right" style=""> 
					'. number_format($taxVal ,2 ).' 
				</td>
			  </tr>';
			   }

			   // Get total quantity
$sql_total_qty = $mysqli->query("SELECT SUM(QtyRcvd) AS totalQty FROM purchitem WHERE P_No = '$P_NO' AND br_id = '$br_id'");
$totalQty = $sql_total_qty->fetch_assoc()['totalQty'];
		echo '<tr>
			  	<td colspan="4"> 
					Checked By &nbsp;&nbsp; 
					...........................................................
				</td>		
				<td colspan="2"> Qty </td>
				<td  align="right"> '. number_format( $totalQty,2 ).' </td>
			  </tr>';
		echo '<tr>
			  	<td colspan="4"> 
					Checked By &nbsp;&nbsp; 
					...........................................................
				</td>		
				<td colspan="2"> Paid </td>
				<td  align="right"> '. number_format( $paidTot+$P_N['Paid'],2 ).' </td>
			  </tr>';		 

		echo '<tr>
			  	<td colspan="4"> 
					Good received in good condition  &nbsp;&nbsp;  
					.............................................
				</td>		
				<td colspan="2"> Balance</td>
				<td style="text-align:right;border-top:1px solid;border-bottom-style:double;">
				'. number_format( ($P_N['Total']- $P_N['Paid']),2 ).' </td>
			  </tr>';		 
			 			  			  			  			   
		echo'
			</tbody>
		</table>
</div>
</div>';



?>

</div>

<div style="margin-top:20px;font-size:12px">
Software by POWERSOFT - 0722 693 693
</div>

</body>
</html>