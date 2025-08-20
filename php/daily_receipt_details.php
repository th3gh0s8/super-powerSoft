<?php
$title = 'Receipt Details';
include ('includeFile.php');
$cus_id = $_GET['cus_id'];
if ($_GET['print_type'] != 'undefined') {
	$print_type = $_GET['print_type'];
} else {
	$print_type = "sal_rep";
}
// $report_sale = 'report_salesman';
if ($_GET['sales_id'] != 'undefined') {
	$sales_id = $_GET['sales_id'];
} else {
	$sales_id = 'View All';
}
// $reportPrnt = 'salesReport';
$report_sale_print = 'report_salesman_print';
$report_sale = 'report_salesman';
$get_indiUser = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID 
										WHERE `user_id` ='$user_id' AND `page_title` ='control_user_report' AND `user_rights`.`br_id`='$br_id'");
$rowIndiUser = $get_indiUser->num_rows;

if($rowIndiUser == TRUE){
    $report_recipt = '';
}else{
    $report_recipt = 'report_recipt';
}
if($_GET['sales_id'] != 'undefined'){
	
	// $sales_id=$_GET['sales_id'];
}
else{$sales_id ='View All';}

if($_GET['user_ids'] != 'undefined'){
	
	$user_ids=$_GET['user_ids'];
}
else{$user_ids ='View All';}

$from_d	= $_GET['from_d'] ;
$to_d = $_GET['to_d']; 
$reportPrnt = 'receipt';

$_SESSION['f_day']= $from_d;
$_SESSION['t_day']= $to_d;
$_SESSION['user_ids']= $user_ids;
$_SESSION['sl_id'] = $sales_id;
$_SESSION['cus_id'] = $cus_id;

//$today=$_SESSION['today'];

$from_d	= ($from_d != '')? $from_d : date('Y-m-d');
$to_d	= ($to_d != '')? $to_d : date('Y-m-d');

$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');

//echo $from_d.''.$to_d.''.$sales_id;	 
$from_ddd = $from_dd;
$to_ddd = $to_dd;

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

?>

<style>
.floatSales{ 
	float:left;
	width:21%;

}
input[type='text'], input[type='number'], select{
	//height: 28px;
	padding: 2px 2px 2px 5px;	
}q

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

</style>
        
  
		<?php include ('daily_report_bar.php'); ?>
   </br>
    <div id="remove_TTb">
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive invoSumryTB" 
    style="margin: 0 auto;width: 98%;">
        <thead>
        <tr>
            <th width="8%">Date</th>
            <th width="4%">Ref/Inv NO</th>
            <th>Rcpt No</th>
            <th>Note</th>
			<th>Customer ID</th>
            <th>Customer Name</th>
            <th>Cash</th>
            <th>Bank</th>
			<th>Cheque</th>
            <th>Cheques</th>
            <th>Card</th>
            <th>Time</th>
        	<th>Rcpt By</th>
            <th>Rep Name</th>
            <th>Collect By</th>
            <th>Chq No</th>
            <th>Chq Date</th>
            <th>Inv Date</th>
            <th width="7%">Age</th>
            <th></th>
        </tr>
        </thead>
        
       
        <?php
		
$sql_user='';
if($user_ids != 'View All'){
	$sql_user=" AND cusstatement.user_id='".$user_ids."'";
}

$sql_repTb = $mysqli->query("SELECT ID FROM salesrep WHERE RepID = '$sales_id' AND br_id = '$br_id'");
$reptb = $sql_repTb->fetch_assoc();

$reptbb= $reptb['ID'];

$getPrintDtls = $mysqli->query("SELECT `size`, `PrintNm`  FROM `all_print_type` 
WHERE `Form` = 'Due Receivable' AND `status`='Receipt' AND br_id = '$br_id'"); 
$PrintDtls = $getPrintDtls->fetch_array();	
$printNm=$PrintDtls['PrintNm'];
if ($print_type == "sal_rep") {
if($sales_id != 'View All'){
$sql_receive = $mysqli->query("SELECT ReceiptNo,cusstatement.RepID ,invoice.RepID,invoice.Location,DueNote,invoice.Date as i_date,`collector_id`, SUM(cusstatement.`Paid`) as ipaid, cusstatement.cusTbID, invoice.purchNo
						from cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID 
						WHERE cusstatement.`Date` BETWEEN '$from_ddd' AND '$to_ddd'
						AND invoice.repTbID ='$reptbb' AND  FromDue = 'Due'
						AND cusstatement.br_id = '$br_id' AND invoice.br_id = '$br_id' $sql_user 
						GROUP BY ReceiptNo 
						ORDER BY cusstatement.`Date` DESC  ");							

}else{

$sql_receive = $mysqli->query("SELECT ReceiptNo,cusstatement.RepID ,invoice.RepID,invoice.Location,DueNote,invoice.Date as i_date,`collector_id`, SUM(cusstatement.`Paid`) as ipaid, cusstatement.cusTbID, invoice.purchNo
							from cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID 
							WHERE cusstatement.`Date` BETWEEN '$from_ddd' AND '$to_ddd' AND  
							FromDue = 'Due' AND cusstatement.br_id = '$br_id'  AND cusstatement.br_id = '$br_id' $sql_user GROUP BY ReceiptNo 
							ORDER BY cusstatement.`Date` DESC  ");


}
}

if ($print_type == "Collected By") {
	if($sales_id != 'View All'){

		

	$sql_receive = $mysqli->query("SELECT ReceiptNo,cusstatement.RepID ,invoice.RepID,invoice.Location,DueNote,invoice.Date as i_date,`collector_id`, SUM(cusstatement.`Paid`) as ipaid, cusstatement.cusTbID, invoice.purchNo
							from cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID 
							WHERE cusstatement.`Date` BETWEEN '$from_ddd' AND '$to_ddd'
							AND cusstatement.collector_id ='$reptb[ID]' AND  FromDue = 'Due'
							AND cusstatement.br_id = '$br_id' AND invoice.br_id = '$br_id' $sql_user 
							GROUP BY ReceiptNo 
							ORDER BY cusstatement.`Date` DESC  ");							
	
	}else{
	
	$sql_receive = $mysqli->query("SELECT ReceiptNo,cusstatement.RepID ,invoice.RepID,invoice.Location,DueNote,invoice.Date as i_date,`collector_id`, SUM(cusstatement.`Paid`) as ipaid, cusstatement.cusTbID, invoice.purchNo
								from cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID 
								WHERE cusstatement.`Date` BETWEEN '$from_ddd' AND '$to_ddd' AND  
								FromDue = 'Due' AND cusstatement.br_id = '$br_id'  AND cusstatement.br_id = '$br_id' $sql_user GROUP BY ReceiptNo 
								ORDER BY cusstatement.`Date` DESC  ");
	
	
	}
	}

if ($print_type == "sal_cus") {
	if($cus_id != 'View All'){
	
	$sql_receive = $mysqli->query("SELECT ReceiptNo,cusstatement.RepID ,invoice.RepID,invoice.Location,DueNote,invoice.Date as i_date,`collector_id`, SUM(cusstatement.`Paid`) as ipaid, cusstatement.cusTbID, invoice.purchNo
							from cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID 
							WHERE cusstatement.`Date` BETWEEN '$from_ddd' AND '$to_ddd'
							AND invoice.CusID = '$cus_id' AND  FromDue = 'Due'
							AND cusstatement.br_id = '$br_id' AND invoice.br_id = '$br_id' $sql_user 
							GROUP BY ReceiptNo 
							ORDER BY cusstatement.`Date` DESC  ");							
	
	}else{
	
	$sql_receive = $mysqli->query("SELECT ReceiptNo,cusstatement.RepID ,invoice.RepID,invoice.Location,DueNote,invoice.Date as i_date,`collector_id`, SUM(cusstatement.`Paid`) as ipaid, cusstatement.cusTbID, invoice.purchNo
								from cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID 
								WHERE cusstatement.`Date` BETWEEN '$from_ddd' AND '$to_ddd' AND  
								FromDue = 'Due' AND cusstatement.br_id = '$br_id'  AND cusstatement.br_id = '$br_id' $sql_user GROUP BY ReceiptNo 
								ORDER BY cusstatement.`Date` DESC  ");
	
	
	}
	}
$i=0; 
while($res = $sql_receive->fetch_array()){
$i++;
		
		$bankNm = '';
		
		$prt_bt='<a href="javascript:window.open(\'../../due_/print/'.$printNm.'.php?BID_PRINT='.$res[0].'\',\'myWindowName\',\'width=640,height=530\')">
		<button title="Print" class="btn btn-success btn-sm print glyphicon glyphicon-print" id="print" 
		type="button" data-toggle="tooltip" > </button> </a>';
			$sql_user2= '';$sql_user='';
			if($user_ids != 'View All'){
			$sql_user=" AND chq_recieve.userID='".$user_ids."'";
			$sql_user2=" AND cusstatement.user_id='".$user_ids."'";
			}
			
			$pat2 = ",SUM(chqAmount), cusstatement.cusTbID, invoice.repTbID as rt  FROM cusstatement JOIN `chq_recieve` ON ReceiptNo=refNo JOIN invoice ON cusstatement.`invID`=invoice.ID WHERE ReceiptNo= '$res[0]' AND cusstatement.br_id = '$br_id'  AND `chq_recieve`.br_id='$br_id'
						$sql_user $sql_user2 GROUP BY ReceiptNo";
			$pat = "";
			if ($print_type == "sal_rep") {
			if($sales_id != 'View All'){
				$pat = "AND invoice.repTbID ='$reptbb' ";
				$pat2 = ", SUM(cusstatement.`Paid`) ,invoice.RepID as rr, cusstatement.cusTbID, invoice.repTbID as rt FROM cusstatement JOIN `chq_recieve` JOIN invoice ON ReceiptNo=refNo 
						AND cusstatement.`invID`=invoice.ID  WHERE cusstatement.br_id = '$br_id' AND `chq_recieve`.br_id='$br_id' AND refNo= '$res[0]'
						AND invoice.repTbID ='$reptbb' $sql_user  $sql_user2 GROUP BY ReceiptNo   ORDER BY `chq_recieve`.`cashDate` DESC";
			}
		}
		if ($print_type == "Collected By") {
			if($sales_id != 'View All'){
				$pat = "AND cusstatement.collector_id ='$reptb[ID]' ";
				$pat2 = ", SUM(cusstatement.`Paid`) ,invoice.RepID as rr, cusstatement.cusTbID, invoice.repTbID as rt FROM cusstatement JOIN `chq_recieve` JOIN invoice ON ReceiptNo=refNo 
						AND cusstatement.`invID`=invoice.ID  WHERE cusstatement.br_id = '$br_id' AND `chq_recieve`.br_id='$br_id' AND refNo= '$res[0]'
						AND cusstatement.collector_id ='$reptb[ID]' $sql_user  $sql_user2 GROUP BY ReceiptNo   ORDER BY `chq_recieve`.`cashDate` DESC";
			}
		}
		if ($print_type == "sal_cus") {
			if($cus_id != 'View All'){
				$pat = "AND invoice.CusID ='$cus_id' ";
				$pat2 = ", SUM(cusstatement.`Paid`) ,invoice.RepID as rr, cusstatement.cusTbID, invoice.repTbID as rt FROM cusstatement JOIN `chq_recieve` JOIN invoice ON ReceiptNo=refNo 
						AND cusstatement.`invID`=invoice.ID  WHERE cusstatement.br_id = '$br_id' AND `chq_recieve`.br_id='$br_id' AND refNo= '$res[0]'
						AND invoice.CusID ='$cus_id' $sql_user  $sql_user2 GROUP BY ReceiptNo   ORDER BY `chq_recieve`.`cashDate` DESC";
			}
		}
			
			
			if($res['1'] == 'Cheque'){
					$qry = "SELECT cusstatement.`Date`,cusstatement.`InvNo`, `ReceiptNo`, cusstatement.`Name`,
							cusstatement.`Paid`, cusstatement.`NowTime`,  cusstatement.`RepID`, `FromDue`,
							user_id,chq_recieve.cashDate,chq_recieve.chqNo, invID, DueNote as Location $pat2 ";
							//echo $qry;
			}
			elseif($res['1'] == 'Card' ){
				$qry = "SELECT cusstatement.`Date`,cusstatement.`InvNo`, `ReceiptNo`, cusstatement.`Name`,
							cusstatement.`Paid`, cusstatement.`NowTime`,  cusstatement.`RepID`, `FromDue`,
							user_id,invoice.Date AS dd , invoice.`RepID` as rr, cusstatement.cusTbID, invID, invoice.Location, invoice.repTbID as rt, invoice.purchNo
							FROM  cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID  
							WHERE ReceiptNo= '$res[0]' AND cusstatement.br_id = '$br_id' $pat  $sql_user2";
			//
			}else{
			
			$qry = "SELECT cusstatement.`Date`,cusstatement.`InvNo`, `ReceiptNo`, cusstatement.`Name`,
							cusstatement.`Paid`, cusstatement.`NowTime`,  cusstatement.`RepID`, `FromDue`,
							user_id,invoice.Date AS dd , invoice.`RepID` as rr, cusstatement.cusTbID, invID, invoice.Location, invoice.repTbID as rt, invoice.purchNo
							FROM cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID  
							WHERE ReceiptNo= '$res[0]' AND cusstatement.br_id = '$br_id' $pat $sql_user2 ";
			
			}//7=card // 8=cash // 9=cheque
		//	echo $qry.'</br>';
		$get_rst = $mysqli->query($qry);
		
		$CHEQUE_NW = 0;$CARD_NW=0;$CASH_NW=0;$BANK_NW=0;$CHEQUE_NW3 = 0; $CHEQUE_NW2 =0;
		$row = $get_rst->num_rows;
		$diff = 0;
		while($res_receive_nw = $get_rst->fetch_array()){
			$sql_custName = $mysqli->query("SELECT cusName, CustomerID FROM custtable WHERE ID = '$res_receive_nw[cusTbID]'");
			$cusName = $sql_custName->fetch_array();
			    $invoiceDate =   $res_receive_nw['dd'];
			    $paymentDate =   $res_receive_nw['Date'];
			    $today =   strtotime($res['i_date']);
			    $today =   strtotime($res_receive_nw['0']);
			    
				$chq = '';$AgeDate='';$chqTot = $res_receive_nw[11]; $chqTot2 = '';$chqPaid = '';
			if($res['1'] == 'Cheque' ){
			    $today =   strtotime($res['i_date']);
				$CHEQUE_NW = $res['ipaid'];
				$CHEQUE_NW3 = $res_receive_nw['11'];
				$AgeDate = $res_receive_nw['cashDate'];
				$checkAgeDate = $res_receive_nw['cashDate'];
				
				
				$inv='';
				$invD = '';$AgeDate = '';
				$diff = ''; $ageD=''; $age = 0; $datediff = 0;$diffFin=0;
				
				$get_invAgge2 = $mysqli->query("SELECT cusstatement.`Date`, cusstatement.ReceiptNo, cusstatement.Date,chqAmount,SUM(cusstatement.`Paid`) as paidc ,chq_recieve.chqNo,cashDate, cusstatement.InvNO, cusTbID
				                            FROM cusstatement JOIN `chq_recieve` ON ReceiptNo=refNo  
				                            WHERE refNo= '$res_receive_nw[2]' AND  cusstatement.InvNO= '".$res_receive_nw['InvNo']."' AND cusstatement.br_id = '$br_id'  AND `chq_recieve`.br_id='$br_id'	$sql_user $sql_user2 
				                            group by chq_recieve.chqNo,cusstatement.ReceiptNo, InvNo ORDER BY cusstatement.`InvNo` ASC");
				$chq = '';	$diff = '';$chqTot = ''; $chqTot2 = '';
				$AgeDate = '';
				while($invAgge2 = $get_invAgge2->fetch_array()){

				
				    /*$sql_cahsDate = $mysqli->query("SELECT refNo , cashDate FROM chq_recieve WHERE refNo = '$invAgge2[1]'");
                    $cahsDate = mysql_fetch_array($sql_cahsDate);*/
                    
                   $sql_invDDate = $mysqli->query("SELECT Date FROM cusstatement WHERE InvNO= '$invAgge2[7]' AND cusstatement.br_id = '$br_id' ");
                   $invDDate = $sql_invDDate->fetch_array();
                   
                    $chq .= chq_format($invAgge2['chqNo']).'</br>' ;
                    $AgeDate .= $invAgge2['cashDate'].'</br>';
					//$chqTot = number_format($invAgge2['chqAmount'],2);
					$chqTot2 .= number_format($invAgge2['chqAmount'],2).' <br/>';

					$CHEQUE_NW2 += (float)$invAgge2['chqAmount'];


					// if (is_numeric($invAgge2['chqAmount'])) {
					// 	$CHEQUE_NW2 += intval($invAgge2['chqAmount']);
					// }
    				//$today = strtotime($invAgge2[0]);
    				$paymentDate = $invAgge2['cashDate'];
    				
				}
				
				$get_rst2 = $mysqli->query("SELECT cusstatement.`InvNo`, cusstatement.ReceiptNo, cusstatement.Date,DATEDIFF(cusstatement.Date, invoice.Date) AS age, Paid, invoice.Date, invoice.purchNo FROM cusstatement JOIN invoice ON cusstatement.`invID`=invoice.ID  
							WHERE ReceiptNo= '$res_receive_nw[2]' AND cusstatement.br_id = '$br_id' ORDER BY invoice.Date ASC ");
				
				while($nw = $get_rst2->fetch_array()){
					$inv .= '<a style="cursor:pointer; color:blue;" class="click_invDetail" value="'.$nw[0].'">'.$nw[0].'</a></br>';
					$chqPaid .= number_format($nw['Paid'],2).'</br>';
					
					$invD .= $nw[5].'<br>';
					
					$today = strtotime($nw[5]);
    				$age = strtotime($paymentDate);
    				$datediff = $age - $today;
    				$diffFin = round($datediff / (60 * 60 * 24));
					$ageD .= $diffFin.'<br/>';
				}
				
				//echo $diff;
				$repNm = FindRepName("ID", $res_receive_nw['rt'], $br_idd)['Name'];
				
			}elseif($res['1'] == 'Card' ){
				$CARD_NW = $res_receive_nw['Paid'];
				$invD = $res_receive_nw[9];
				$inv = '<a style="cursor:pointer; color:blue;" class="click_invDetail" value="'.$res_receive_nw[1].'">'.$res_receive_nw[1].'</a>';
				$repNm = FindRepName("ID", $res_receive_nw['rt'], $br_idd)['Name'];
			}else{
			    
			    if($res['1'] == 'CJournal'){
			        $sql_bankName = $mysqli->query("SELECT AccName FROM jentry WHERE ReceiptNo= '$res[0]' AND br_id = '$br_id' ");
                    $bankNameDet = $sql_bankName->fetch_array();
                    
                    $bankNm = ' - '.$bankNameDet['AccName'];
                    $BANK_NW = $res_receive_nw['Paid'];
			    }else{
			        $CASH_NW = $res_receive_nw['Paid'];
			    }
				$invD = $res_receive_nw[9];
				$inv = '<a style="cursor:pointer; color:blue;" class="click_invDetail" value="'.$res_receive_nw[1].'">'.$res_receive_nw[1].'</a>';
				$repNm = FindRepName("ID", $res_receive_nw['rt'], $br_idd)['Name'];
			}
			
			if($res['1'] != 'Cheque' ){
    			$showInvDate = ''; 
    			$ageD = ''; 
    			$sql_invDDate = $mysqli->query("SELECT invoice.Date FROM cusstatement JOIN invoice ON invoice.ID = cusstatement.invID 
    			                                    WHERE ReceiptNo= '$res_receive_nw[2]' AND cusstatement.br_id = $br_id AND cusstatement.`invID` = '$res_receive_nw[invID]' GROUP BY cusstatement.invID LIMIT 5");
                while($invDDate = $sql_invDDate->fetch_array()){
                    $showInvDate .= $invDDate['Date']." </br/>";
    				$today = strtotime($invDDate['Date']);
    				$age = strtotime($paymentDate);
    				$datediff = $age - $today;
    				$diffFin = round($datediff / (60 * 60 * 24));
    				$ageD .= $diffFin.'<br/>';
                }
			}
                   
			$qry_coll=$mysqli->query("SELECT `Name` FROM `salesrep` WHERE `ID`='".$res['collector_id']."' ");
			$collNm=$qry_coll->fetch_array();
		echo'
        <tr>
            <td >'.$res_receive_nw[0].'</td>
			<td>'.$inv.'</td>
            <td><a class="reciptNo" style="color:blue; cursor:pointer;" recValue="'.$res_receive_nw[2].'">'.$res_receive_nw[2].'</a></td>
			<td>'.$res_receive_nw['Location'].' | Due '.$res['DueNote'].' '.$res_receive_nw['purchNo'].'</td>
			            <td>'.$cusName[1].'</td>
            <td>'.$cusName[0].'</td>
            <td style="text-align:right;">'.number_format($CASH_NW,2).'</td>
            <td style="text-align:right;">'.number_format($BANK_NW,2).'</td>
            ';
            
            
                echo '<td style="text-align:right;">'.$chqPaid.'</td>';
           
			
			
			 if($chqTot2 == $chqTot){
				$chqNw = floatval($CHEQUE_NW2);
                echo '<td style="text-align:right;">'.number_format($chqNw,2).'</td>';
            }else{
                echo '<td style="text-align:right;">'.$chqTot2.'<b style="border-top: 1px solid;"> '.number_format($CHEQUE_NW2,2).' </b></td>';
            
            }
			
            echo '
			<td style="text-align:right;">'.number_format($CARD_NW,2).'</td>
          	<td>'.$res_receive_nw['NowTime'].'</td>
			<td>'.uIDQry($res_receive_nw['user_id']).'  '.$bankNm.'</td>
			<td>'.$repNm.'</td>
			<td>'.$collNm[0].'</td>
			<td width="400px">'.$chq.'</td>
			<td width="120px">'.$AgeDate.'</td>
			<td width="120px">'.$invD.'</td>
			<td>'.$ageD .'</td>
			<td>'.$prt_bt.'</td>
        </tr>';
        
    		$T_CHEQUE_NW += $CHEQUE_NW;
    		$T_CASH_NW +=$CASH_NW;
    		$T_BANK_NW +=$BANK_NW;
    		$T_CARD_NW += $CARD_NW;
		}

		
		}
			
		
		
		 
      echo'  </tbody>';
			
			
		
	
	echo'<tfoot>
		<tr bgcolor="#DFD">		
			<td></td>
			<td></td>
			<td></td>
			<td></td>
						<td></td>
			<td>Total</td>
			<td style="text-align:right;">'.number_format($T_CASH_NW,2).'</td>
			<td style="text-align:right;">'.number_format($T_BANK_NW,2).'</td>
           	<td style="text-align:right;">'.number_format($T_CHEQUE_NW,2).'</td>
			<td style="text-align:right;">'.number_format($T_CHEQUE_NW,2).'</td>
		   	<td style="text-align:right;">'.number_format($T_CARD_NW,2).'</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr >	
			
    </tfoot>';
	//}
	
	?> 
	</table>
    </div>
    </div>
    </div>
    </div>

<!--/span-->
    


<div class="box-content" align="center" >
    <ul class="ajax-loaders" style="display:none">
        <li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>                                   
    </ul>                
</div> 




            

  

</div>
    <!-- content ends -->
    </div>
    
    <?php include ($path.'footer.php'); ?>
   
   <?php include ('daily_script.php'); ?>   
    
    <script>

	$('#receipt').click(function(){
		var invID = $('').val();
		
		//alert('' +invID);
		window.open("print/prnt_receipt_report.php" , "myWindowName","width=595px, height=842px");	
						
	});
	
</script>
	       
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
</script>
<script type="text/javascript">    
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

<script>

$(document).ready(function() {
 $("#sales_prnt").click(function () {

$("#sales_prnt").attr("disabled", "disabled");
//$("#sales_prnt").removeAttr("disabled"); 
});
   
});
</script>
<!--date picker files-->

