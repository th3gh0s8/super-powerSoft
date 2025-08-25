<?php
$title = 'Journal Statement';
include ('includeFile.php');

//unset ($_SESSION['ReportPath']);
//include ('../side.php');

/*
mysql_query("UPDATE `jentry` SET `jentry_delete`='0',`mysql_db`='jDelUpdate' WHERE `ReceiptNo` in (SELECT ReceiptNo FROM cusstatement Where br_id='$br_id' AND  `RepID` ='CJournal' group by ReceiptNo)
 AND br_id='$br_id' AND ReceiptNo !=0 AND `cloud` != 'del_rcpt' ");
 */
 

$from_d	= $_GET['from_d'] ;
$to_d = $_GET['to_d'];  
$jou_id =$_GET['jou_id'];
if($_GET['jou_name'] != 'undefined'){
$jou_name =$_GET['jou_name'];
}
//$cus_id	= ($cus_id == '' || $cus_id != true)? $cus_id : 'View All';

//echo $cus_id.'000';
$_SESSION['f_day']= $from_d;
$_SESSION['t_day']= $to_d;
$f_date=$from_d;
$t_date=$to_d;
$_SESSION['jou_id']= $jou_id;
$_SESSION['jou_name']= $jou_name;

$reportPrnt = 'jouStat';
$report_jou='jou_stat';
//$ItemSearch = 'ItemSearch';
$from_d = date_format(date_create($from_d), 'Y-m-d');
$to_d = date_format(date_create($to_d), 'Y-m-d');

$to_ddd = date('Y-m-d', strtotime('+1 day', strtotime($to_d)) );

$from_x = DateTime::createFromFormat("Y-m-d","$from_d");
$to_x = DateTime::createFromFormat("Y-m-d","$to_ddd");

$periodInterval = new DateInterval( "P1D" ); // 1-day, though can be more sophisticated rule
$period = new DatePeriod( $from_x, $periodInterval, $to_x );



?>


<style>
#ags1 {
	float:left;
	width:40%;
	
}
#ags2{
	float:right;
	width:40%;
	margin-right:20%;
	//margin-top:-2.1111115898989789%;
	
}
#ags3 {
	float:left;
	width:50%;
	
}
#ags4{
	float:right;
	width:40%;
	margin-right:10%;
	//margin-top:-2.1111115898989789%;
	
}
#ags5{
	float:right;
	width:20%;
	margin-right:20%;
	//margin-top:-2.1111115898989789%;
	
}


#ags6{
	float:left;
	width:100%;
	margin-right:;
	//margin-top:-2.1111115898989789%;
	
}

.controls {
	 width:60%;
	
}
.control-group {
	padding-left:3%;
	padding-right:3%;
	padding-top:;	
	
	
}
.control-group input[type="text"] ,input[type="email"], select{
	width:100%;
	height:2.5%;
	background-color:rgba(255,255,204,1);
	
}
.control-label{
	width:10%;
	
}
.bilDetUl li{
	//background:#0066CC;
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
 // height: 34px;
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




.floatSales{ 
	float:left;
	width:18%;

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
  
        
       

 

<!--
<div class=" row">        
<div class="box col-md-12" >
    <div class="box-inner">
        <div class="box-header well" data-original-title="">
            <h2><i class="glyphicon glyphicon-user"></i> Daily Report</h2>
    
            <div class="box-icon">
                <a href="#" class="btn btn-minimize btn-round btn-default"><i
                        class="glyphicon glyphicon-chevron-up"></i></a>
                <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
            </div>
        </div>
<div class="box-content" style="width:99%; padding-left:1.5%; padding-right::0.5%;">
<div class="row">-->

  
		<?php include ('New_report_bar.php'); ?>
        
   </br>
   
   
   
   
   
   
    <div id="ajaxRespon" style="width:95%; ">                
  		 <div id="remove_TTb" style="margin-left:34px; margin-top:-50px; padding-bottom:10px;"> 
    		<table class="table  table-bordered bootstrap-datatable table-hover  responsive invoSumryTB"
             style="margin-top:30px";>
                <thead>
                <tr>
                  	<th width="10%" style="text-align:left;">Date </th>
                    <th width="30%" style="text-align:left;">Particulars</th>
                    <th width="5%" style="text-align:left;">Voucher No/Chq ref</th>
                    <th width="10%" style="text-align:left;">Debit </th>
                     <th width="10%" style="text-align:left;">Credit</th>
                    <th width="10%" style="text-align:left;">Balance</th>
                 
                    </tr>
                </thead>
                <tbody>
        
       
      		  <?php
			
				$bf_balance =0;
				$p_balance= 0;
				$p_balance2= 0;
				$paid_sum=0;
				$inv_sum=0;
				$chq_sum=0;
				$bg_bal2=0;
				$from_d2=$from_d;
				$dayJd=0;
				$dayJc=0;
				$dayChqd = 0;
				$dayChqc=0;
				$dayChqdOwn = 0;
				$dayChqcOwn=0;
				$sum_party_chq2j=0;
				$sum_party_chq2j_rcv=0;
				$sum_party_chq2jrtn=0;
				$sum_party_chq2jrtn_bk=0;
				$sum_jown_retun=0;
				$sum_VenPaid=0;
				
				//get journl ID
				$j_id;
				 $qry_jou=mysql_query("SELECT `ID`,Bank,BankCODE,BranchCODE FROM `journal`  WHERE `AccID`='$jou_id' and `br_id`='$br_id'  ");
				 
						 while($exc_jou = mysql_fetch_array($qry_jou)){
							 $j_id= $exc_jou['ID'];
							 $bankNO= $exc_jou['Bank'];
							  $ID03=$exc_jou['Bank'];
							$ID01=$exc_jou['BankCODE'];
							$ID02=$exc_jou['BranchCODE'];
						 }
					//get journl ID ------------------- end
				
				
				
					$sqlBF= mysql_query("SELECT Credit,Debit,BranchCODE,journal.AccID,Bank,Bounced FROM `journal` JOIN jentry 
											ON journal.AccID = jentry.AccID AND journal.br_id = jentry.br_id 
											WHERE jentry.Date < '$f_date' AND jentry.`AccID`='$jou_id' AND jentry.br_id ='$br_id'
											and `jentry_delete` != 1 AND (Bounced IS NULL OR Bounced !='Own Cheque' AND InvoicedSMS !='ACCU_JOURNAL') ");
						$BFCardC=0;
						$BFCardD=0;
						$BFC=0;$BFD=0;					
						while($jbf=mysql_fetch_array($sqlBF)){
							
								if($jbf['Bounced'] == 'Card'){
									$BFCardC+=$jbf[1];
									$BFCardD+=$jbf[0];
								}
								else{
									$BFC+=$jbf[0];
									$BFD+=$jbf[1];
									
									//echo '1---'.$BFC.'------mm'.$BFD.'</br>';
									
									
									}
							}
				//echo $BF.' bf '.$BFCard;
				
				
				/*$sqlBFcARD= mysql_query("SELECT SUM(Debit)-SUM(Credit),BranchCODE,journal.AccID,Bank FROM `journal` JOIN jentry 
											ON journal.AccID = jentry.AccID AND journal.br_id = jentry.br_id 
											WHERE jentry.Date < '$f_date' AND  jentry.`AccID`='$jou_id' AND jentry.br_id ='$br_id'
											AND Bounced = 'Card' and `jentry_delete` !='1' ");
											
				  $sqldopsite= mysql_query("SELECT SUM(Credit)-SUM(Debit),BranchCODE,journal.AccID,Bank FROM `journal` JOIN jentry 
				  ON journal.AccID = jentry.AccID AND journal.br_id = jentry.br_id 
				  WHERE jentry.Date < '$f_date' AND jentry.`AccID`='$jou_id' AND jentry.br_id ='$br_id'
				  and `jentry_delete` !='1'  AND Bounced = 'Deposited444'  ");*/
											
					$sqlBGbal = mysql_query("SELECT SUM(`hBegBal` + `sBegBal`) FROM `journal` 
											WHERE `AccID`='$jou_id' and `br_id`='$br_id' ");
											
			
		// direct cheque recieved -------------------------------------------------------------------------------------
			 $bf_derictChq	= 0;
			
			
			$qry_cqe_dir_bl=mysql_query("SELECT  SUM(`chqAmount`)
			FROM `chq_recieve` WHERE `frmID`='$j_id' AND rec_form ='DIRECT'  AND `status`= 'Journal' AND
			 `br_id` = '$br_id' AND `entryDate` < '$f_date'  ");

				 
						 while($exc_cqe_dir_bl = mysql_fetch_array($qry_cqe_dir_bl)){
							 // credit
							 $bf_derictChq	=  $bf_derictChq + $exc_cqe_dir_bl[0]; 
							 
						 }
			// direct cheque recieved -------------------------------------------------------------------------------------
			
											
											
									
									//echo 'ses   fdf';		
					//$bfCount = mysql_num_rows($sqlBF);
					$sqlBankDpositOLDR = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID` >0 AND rtnID > 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND entryDate < '$f_date' AND `bank_deposit`.br_id='$br_id' 
										AND  `status` NOT Like '%Own-Return%' ");
										
					$sqlBankDpositOLDD = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID` > 0 AND rcvTbID >0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND entryDate < '$f_date' AND `bank_deposit`.br_id='$br_id' ");
					
						
					$sqlOwnChqIsd = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND chqBID > 0 AND depositDate < '$f_date' AND rtnID = 0 AND status != 'Encash' 
										AND status != 'OwnChqPayment' AND `bank_deposit`.br_id='$br_id' ");
										
										
					$sqlOwnChqRtn = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND chqBID > 0 AND depositDate < '$f_date' AND rtnID != 0
										 AND `bank_deposit`.br_id='$br_id' AND `status` Like '%Own-Return%'  ");
									
							$BFRChq =mysql_fetch_array($sqlBankDpositOLDR);
							//echo $BFRChq[0];
					$BFDChq =mysql_fetch_array($sqlBankDpositOLDD);
					$OwnChqIsd = mysql_fetch_array($sqlOwnChqIsd);
					$OwnChqRtn = mysql_fetch_array($sqlOwnChqRtn);
							
						
						
						// party cheque  to journal------------------------------------------------------------------
							$sqlprtyChq2j = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID 
										WHERE journal.ID = '$j_id' AND entryDate < '$f_date' 
										AND `bank_deposit`.br_id='$br_id' AND rtnID ='0' ");
							$BFprtyChq2j = mysql_fetch_array($sqlprtyChq2j);
							
							//return cheqe
							$sqlprtyChq2j_rtn = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID 
										WHERE journal.ID = '$j_id' AND entryDate < '$f_date' 
										AND `bank_deposit`.br_id='$br_id' AND rtnID !='0'  ");
							$BFprtyChq2j_rtn = mysql_fetch_array($sqlprtyChq2j_rtn);
							
						$sqljcreturn_bl = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate < '$f_date'  AND
										 `bank_deposit`.br_id='$br_id' AND rtnID !='0' ");
						$BFjcreturn=mysql_fetch_array($sqljcreturn_bl);	
						// party cheque  to journal------------------------------------------------------------------
						
						
						
						// BF journal to journal reisssue return
						$sqlreissuj_bl = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate < '$f_date'  AND
										 `bank_deposit`.br_id='$br_id' AND rtnID ='0' AND status = 'ReIssue-J' ");
						$BFjreissue=mysql_fetch_array($sqlreissuj_bl);
						
						// BF journal to vendor paid
						$sqlpaidVn_bl = mysql_query("SELECT SUM(amount)
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate < '$f_date'  AND
										 `bank_deposit`.br_id='$br_id' AND rtnID ='0' AND status = 'PAID' ");
						$BFpaidVEN=mysql_fetch_array($sqlpaidVn_bl);
							
					
						
							$BGbal = mysql_fetch_array($sqlBGbal);	
							
							
							$sqljoreturn = mysql_query("SELECT SUM(amount)
								  FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
								  WHERE jDueID = '$j_id' AND bank_deposit.entryDate < '$f_date' AND
								   `bank_deposit`.br_id='$br_id' AND status != '' AND rtnID !='0' ");	
						   $jown_rtn=mysql_fetch_array($sqljoreturn);		
						   //$jown_rtn Uncommented due to issue of 430 2024-06-20	Own cheque return -2450557083250	259,580.00 Refer issue no: 17837
						   
					//$BFdeposit = mysql_fetch_array($sqldopsite);
					
	
				
					
					
				
				/*$bfCredit=$BFC+$BFCardC+$BGbal[0]+$BFDChq[0]+$OwnChqRtn[0]+$BFjcreturn[0]+$BFprtyChq2j[0];
				$bfDebit=$BFD+$BFCardD+$BFRChq[0]+$OwnChqIsd[0]+$BFprtyChq2j_rtn[0]+$BFjreissue[0]+$BFpaidVEN[0]
						+$bf_derictChq  ;*/
						
				//echo 'own r '.$OwnChqRtn[0];
				//echo '</br>'.$BFC;
				//echo  '</br>'.$BFRChq[0]; 
						
				$bfCredit=$BFC+$BFCardC+$BGbal[0]+$BFDChq[0]+$OwnChqRtn[0]+$BFjcreturn[0]+$BFprtyChq2j[0]+$BFjreissue[0];
				
				//$bfDebit=$BFD+$BFCardD+$BFRChq[0]+$OwnChqIsd[0]+$BFprtyChq2j_rtn[0]+$BFpaidVEN[0]+$bf_derictChq+$jown_rtn[0]; Edit on 2022-04-28 17.00
				$bfDebit=$BFD+$BFCardD+$BFRChq[0]+$OwnChqIsd[0]+$BFprtyChq2j_rtn[0]+$bf_derictChq+$jown_rtn[0];
					
					$TTBF= $bfCredit- $bfDebit;
					$bf_balance=$TTBF ;
					$p_balance=$bf_balance;
				
				// get B/F ------------------------------------------------------------------------
				
				
			
						//$bf_balance=$bf_balance+ $bg_bal2;
							
			// cus/ven cheque balance --------------------------------------------------------------------------------------
						 
						 
						 	echo '  <tr bgcolor="#D1C1BC">
									<td style="text-align:left;"> </td>
									  <td style="text-align:left;"> B/F </td>
									  <td style="text-align:left;">  </td>
									   <th width="10%" style="text-align:right;">  </th>
										 <th width="10%" style="text-align:right;">  </th>
										<th style="text-align:right;">'.number_format($bf_balance,2).'</th>
									  </tr> ';
						 
						 
				// journal blance  ----------------------------------------------------------------------------- end
						 
				// get B/F ------------------------------------------------------------------------
				
				
				
				
				
				
				// Date loop	
			
				foreach($period as $date){//DAY LOOP
   			//echo $date->format("Y-m-d") , PHP_EOL.'</br>';
   			$dateBy  = $date->format("Y-m-d") ;
			//echo "one".$dateBy."<br>";
			
			// direct cheque recieved -------------------------------------------------------------------------------------
			
			
			$qry_cqe_dir=mysql_query("SELECT `frmID`, `chqNo`, `rec_form`, `cashDate`, `chqAmount`, `status`,entryDate,`refNo` 
			FROM `chq_recieve` WHERE `frmID`='$j_id' AND `rec_form` ='DIRECT' AND `status`= 'Journal' AND
			 `br_id` = '$br_id' AND `entryDate`='$dateBy'  ");

				 
						 while($exc_cqe_dir = mysql_fetch_array($qry_cqe_dir)){
							 
							  //$inv_credit=$exc_cqe_dir['chqAmount'];
							   $inv_debit=$exc_cqe_dir['chqAmount'];
							$dChq_sum=$dChq_sum+$inv_debit;
							$deb_cf=$dChq_sum;
							
							$p_balance=($p_balance-$inv_debit);
						//Check Balance Sheet
							 
							 	echo	'  <tr class="success">
                  	<td  style="text-align:left;">'.$exc_cqe_dir['entryDate'].' </td>
                    <td style="text-align:left;"> Direct Cheque Recieved-Jounal('.$exc_cqe_dir['chqNo'].'  )</td>
                    <td  style="text-align:left;">'.$exc_cqe_dir['refNo'].'</td>
                    <th   style="text-align:right; background:#DED1BD;" >'.number_format(0,2).' </th>
                     <th style="text-align:right; background:#D3D8E0;">'.number_format($exc_cqe_dir['chqAmount'],2).'</th>
                    <th style="text-align:right;">'.number_format( $p_balance,2).'</th>
                 
                    </tr>';
							 
							 
							 
						 }
			
			// direct cheque recieved -------------------------------------------------------------------------------------
			
			
			// cheque delails###-----------------------------------------------------------------------------------------------------------------------
				##ChqDeposit
			$sqlBankDposit = mysql_query("SELECT bank_deposit.`br_id`, `directJStatus`, `chqNo`, `amount`, `depositDate`,rcvTbID,rtnID,entryDate,
										chqBID,`chqRefNo`,`bank_deposit`.ID,`bank_deposit`.status,`venID`,`cusID`,rtnOption
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND entryDate ='$dateBy' AND chqBID = 0 AND `bank_deposit`.br_id='$br_id' 
										  ");
			
			
				
				while($BankDposit = mysql_fetch_array($sqlBankDposit)){
					
					//echo $BankDposit['ID'].'/</br>';
					$CChq = 0;$DChq=0;
					$bg="background:#95C5DE;";
					//echo $BankDposit['status'].'</br>';
					
					$sqlCusDt= mysql_query("SELECT cusName FROM `custtable` WHERE ID = '".$BankDposit['cusID']."'");
					$cusName=mysql_fetch_array($sqlCusDt);
					
					if($BankDposit['status'] != 'Encash' && $BankDposit['status'] != 'OwnChqPayment' )
					{
					
						if($BankDposit['rcvTbID'] > 0  ){
							$DChq = $BankDposit['amount'];
							$des = 'Cheque Deposit ';
							$p_balance=$p_balance+$DChq;
						
						}
					
					if($BankDposit['rtnID'] > 0 && $BankDposit['chqBID'] == 0  ){
						$CChq = $BankDposit['amount'];
						$des = 'Cheque Return';
						$p_balance=$p_balance-$CChq;
									
					}
					
						echo '  <tr class="success">
									<td style="text-align:left;"> '.$BankDposit['entryDate'].'</td>
							<td style="text-align:left;"> '.$des.' ('. $BankDposit['chqNo'] .') DPD-'.$BankDposit['depositDate'].' ('.$cusName[0].')
												'.$BankDposit['rtnOption'].' </td>
									  <td style="text-align:left;"> '.$BankDposit['chqRefNo'].' </td>
									   <th   style="text-align:right; background:#DED1BD;" > 
									   '.number_format($DChq,2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" >
										 '.number_format($CChq,2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).' </th>
									  </tr> ';
					
				
				$dayChqd += $DChq;
				$dayChqc += $CChq;
					}
					
					
				}
			
			// own cheque strat ######################################################%%%%%%%%%%%%%%%%%%%%	
				
			$sqlBankDpositOwn = mysql_query("SELECT bank_deposit.`br_id`, `directJStatus`, `chqNo`, `amount`,
			 `depositDate`,rcvTbID,rtnID,entryDate,
										chqBID,`bank_deposit`.ID,`chqRefNo`,`bank_deposit`.status,`venID`,`cusID`
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND chqBID > 0 AND `depositDate` ='$dateBy' 
										AND `bank_deposit`.br_id='$br_id' AND rtnID = 0 ");
			
			
				
				while($BankDpositOwn = mysql_fetch_array($sqlBankDpositOwn)){
					$CChqOwn = 0;$DChqOwn=0;
					$bg="background:#DCF5D7;";
					//echo '/'.$BankDpositOwn['status'].'/</br>';
					
					$sqlvend = mysql_query("SELECT `CompanyName` FROM `vendor` WHERE ID = '".$BankDpositOwn['venID']."' ");
					$venName=mysql_fetch_array($sqlvend);
					
					if($BankDpositOwn['status'] != 'Encash' && $BankDpositOwn['status'] != 'OwnChqPayment' )
					{
				
						$CChqOwn = $BankDpositOwn['amount'];
						$des = 'Own Cheque';
							$p_balance=$p_balance-$CChqOwn;
					
					echo '  <tr class="success">
									<td style="text-align:left;"> '.$BankDpositOwn['depositDate'].'</td>
						 <td style="text-align:left;"> '.$des.' ('. $BankDpositOwn['chqNo'] .') Entry Date ('.$BankDpositOwn['entryDate'].') '.$venName[0].' </td>
									  <td style="text-align:left;"> '.$BankDpositOwn['chqRefNo'].' </td>
									   <th   style="text-align:right; background:#DED1BD;" > 
									   '.number_format($DChqOwn,2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" >
										 '.number_format($CChqOwn,2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).'</th>
									  </tr> ';
				$dayChqdOwn += $DChqOwn;
				$dayChqcOwn += $CChqOwn;
				
					} // end if
				
				}
				
				// own cheque return ###############################################
				$sqlBankOwnReturn = mysql_query("SELECT bank_deposit.`br_id`, `directJStatus`, `chqNo`, `amount`,
			 `depositDate`,rcvTbID,rtnID,entryDate,
										chqBID,`bank_deposit`.ID,`chqRefNo`,`bank_deposit`.status,`bank_deposit`.`venID`,`cusID`
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.jourID = journal.ID 
										WHERE `jourID`!= 0 AND bnkCode= '$ID01' AND bnkBrCode='$ID02'
										and bank = '$ID03' AND chqBID > 0 AND depositDate ='$dateBy' 
										AND `bank_deposit`.br_id='$br_id' AND rtnID != 0 ");
			
			
				
				while($BankOwnReturn = mysql_fetch_array($sqlBankOwnReturn)){
					$CChqOwn = 0;$DChqOwn=0;
					$bg="background:#DCF5D7;";
					//echo '/'.$BankOwnReturn['venID'].'/</br>';
					
					$sqlvend2 = mysql_query("SELECT `CompanyName` FROM `vendor` WHERE ID = '".$BankOwnReturn['venID']."' ");
					$venName2=mysql_fetch_array($sqlvend2);
					
					if($BankOwnReturn['status'] != 'Encash' && $BankOwnReturn['status'] != 'OwnChqPayment' )
					{
					
					
						$DChqOwn = $BankOwnReturn['amount'];
						$des = 'Own Cheque Return';
							$p_balance=$p_balance+$DChqOwn;

					
					echo '  <tr class="success">
									<td style="text-align:left;"> '.$BankOwnReturn['depositDate'].'</td>
									<td style="text-align:left;"> '.$des.' ('. $BankOwnReturn['chqNo'] 
									.') DPD-'.$BankOwnReturn['depositDate'].' '.$venName2[0].' </td>
									  <td style="text-align:left;"> '.$BankOwnReturn['chqRefNo'].' </td>
									   <th   style="text-align:right; background:#DED1BD;" > 
									   '.number_format($DChqOwn,2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" >
										 '.number_format($CChqOwn,2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).' </th>
									  </tr> ';
					
				
				
				$dayChqdOwn += $DChqOwn;
				$dayChqcOwn += $CChqOwn;
				
					} // end if
				
				}
				
				
	// own cheque strat ######################################################%%%%%%%%%%%%%%%%%%%%
				
			// cheque delails###---------------------------------------------------------------------------
					 
				// get details journal ####################################%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					
			$sqlBank = mysql_query("SELECT
									 journal.AccID,journal.`br_id`,journal.`Description`,jentry.Description,`AccountMode`,
									 `BankCODE`,`BranchCODE` ,Credit,Debit, Bank ,jentry.Date,VNo,Bounced,jentry.ID,jentry.`AccName`,
									 ReceiptNo,entryType
									FROM `journal` JOIN jentry ON journal.AccID = jentry.AccID AND journal.br_id = jentry.br_id
									WHERE jentry.`AccID`='$jou_id' AND jentry.br_id='$br_id' AND jentry.Date='$dateBy' AND `jentry_delete` !='1'
									AND (Bounced IS NULL OR Bounced !='Own Cheque' AND InvoicedSMS !='ACCU_JOURNAL')  ORDER BY jentry.VNo  ASC " );
									
				$bg='';
						
			while($Bank = mysql_fetch_array($sqlBank)){
			    if($Bank['VNo'] != 0){
			        $sql_secondJour = mysql_query("SELECT AccName FROM jentry WHERE VNo= '$Bank[VNo]' AND ID != '$Bank[ID]' AND br_id='$br_id' ");
    				if(mysql_num_rows($sql_secondJour) == TRUE){
    				    $secondJour = mysql_fetch_array($sql_secondJour);
    				    $secondJournal = " - ".$secondJour['AccName'];
    				}else{
    				    $secondJournal = " - Cash on hand";
    				}
			    }else{
			        $secondJournal = "";
			    }
				
				
				if($Bank['Bounced'] == 'Card' || $Bank['entryType'] == 'DUE_JOURNAL_VEN55'){
					$bg='background:#DEC1F5';
					
					$credit=$Bank['Credit'];
					$debit=$Bank['Debit'];
					$dayJd += $Bank['Debit'];
				$dayJc += $Bank['Credit'];
					$p_balance=$p_balance+$debit-$credit;
					
					echo '  <tr class="success">
									<td style="text-align:left;"> '.$Bank[10].'</td>
									  <td style="text-align:left;"> '.$Bank['AccName'] .' '.$secondJournal.' ('. $Bank['Description'] .') </td>
									  <td style="text-align:left;"> '.$Bank['VNo'].' </td>
									   <th   style="text-align:right; background:#DED1BD;" > 
									   '.number_format($Bank['Debit'],2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" >
										 '.number_format($Bank['Credit'],2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).' </th>
									  </tr> ';
				
				}
				else{
					$bg='';
					$credit=$Bank['Debit'];
					$debit=$Bank['Credit'];
					$dayJc += $Bank['Debit'];
				$dayJd += $Bank['Credit'];
					$p_balance=$p_balance+$debit-$credit;
					
					$stutas='';
					$recpt_no=$Bank['ReceiptNo'];
					if($Bank['entryType'] == 'DUE_JOURNAL' || $Bank['entryType'] == 'DUE_JOURNAL_CUS'  )
					{
						
						if($Bank['Credit'] != 0 ){
						
					$qry_cusName=mysql_query("SELECT cusName FROM `cusstatement` JOIN custtable ON 
					`cusstatement`.`cusID` = custtable.CustomerID 
					 WHERE `cusstatement`.`br_id`='$br_id' AND `ReceiptNo`='$recpt_no'");
					 $exc_cusName=mysql_fetch_array($qry_cusName);
					 $stutas= 'Payment to '.$exc_cusName[0].' : Receipt No-'.$recpt_no; 
						}
						else{ 	$stutas=$Bank['Description']; }
					}
					else
					{
					$stutas=$Bank['Description'];
					}
					
				   if ($Bank['entryType'] == 'DUE_JOURNAL_VEN'){
				       $stutas=$Bank['Description'].'-Vendor payment';
				   }
					//Check Balance Sheet
						echo '  <tr class="success">
									<td style="text-align:left;"> '.$Bank[10].'</td>
									  <td style="text-align:left;"> '.$Bank['AccName'] .' '.$secondJournal.' <b>('. $stutas .')</b> </td>
									  <td style="text-align:left;"> '.$Bank['VNo'].' </td>
									   <th   style="text-align:right; background:#DED1BD;" > 
									   '.number_format($Bank['Credit'],2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" >
										 '.number_format($Bank['Debit'],2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).'</th>
									  </tr> ';
					
				
				}
				//$dayJc += $Bank['Debit'];
				//$dayJd += $Bank['Credit'];
		}
				// get details journal card
				
				
				
				
				
				
				// get details accural journal  ####################################%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					
			$sqlBankAcu = mysql_query("SELECT
									 journal.AccID,journal.`br_id`,journal.`Description`,jentry.Description,`AccountMode`,
									 `BankCODE`,`BranchCODE` ,Credit,Debit,jentry.ID, Bank ,jentry.Date,VNo,Bounced,jentry.ID,jentry.`AccName`,
									 ReceiptNo,entryType
									FROM `journal` JOIN jentry ON journal.AccID = jentry.AccID AND journal.br_id = jentry.br_id
									WHERE jentry.`AccID`='$jou_id' AND jentry.br_id='$br_id' AND jentry.Date='$dateBy' AND `jentry_delete` !='1'
									AND  Bounced in ('Own Cheque') AND InvoicedSMS ='ACCU_JOURNAL'  ORDER BY jentry.VNo  ASC " );
									
				$bg='';
						
			while($BankAcu = mysql_fetch_array($sqlBankAcu)){
				
					$bg='';
					$credit=$BankAcu['Debit'];
					$debit=$BankAcu['Credit'];
					$dayJc += $BankAcu['Debit'];
				$dayJd += $BankAcu['Credit'];
					$p_balance=$p_balance+$debit-$credit;
					
					$stutas='';
					$recpt_no=$BankAcu['ReceiptNo'];
					
					$stutas=$BankAcu['Description'];
					
					
					
						echo '  <tr class="success">
									<td style="text-align:left;"> '.$BankAcu[11].'</td>
									  <td style="text-align:left;"> '.$stutas .' ('.$BankAcu['Bounced'].') </td>
									  <td style="text-align:left;"> '.$BankAcu['VNo'].' </td>
									   <th   style="text-align:right; background:#DED1BD;" > 
									   '.number_format($BankAcu['Credit'],2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" >
										 '.number_format($BankAcu['Debit'],2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).'</th>
									  </tr> ';
					
				
				
				//$dayJc += $Bank['Debit'];
				//$dayJd += $Bank['Credit'];
		}
				// get details journal accral
				
				
				
				
				// party cheque  to journal------------------------------------------------------------------
				
				
							$sqlprtyChq2j_infor = mysql_query("SELECT amount,journal.Description,bank_deposit.entryDate
																,chqNo,status,cusID,rtnOption FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID WHERE journal.ID = '$j_id' AND bank_deposit.entryDate ='$dateBy' AND `bank_deposit`.br_id='$br_id' AND `bank_deposit`.cloud !='ACCU_JOURN' ");
									
						while ($prtyChq2j_infor=mysql_fetch_array($sqlprtyChq2j_infor))
						{
							//echo $prtyChq2j_infor['status'];
							$prtyChq2j=0;
							$prtyChq2j_debit=0;
							$stutas='';
							if($prtyChq2j_infor['status'] == 'C-Return-J' || $prtyChq2j_infor['status'] =='J-Return-J' ){
								$stutas="Party Cheque Return ";
								$prtyChq2j=$prtyChq2j_infor[0];
								$sum_party_chq2jrtn +=$prtyChq2j;
								//$deb_cf=$deb_sum;
							
							$p_balance=($p_balance-$prtyChq2j);
								
							}
							else{
									$stutas="Party Cheque to Jounal";
								 	$prtyChq2j_debit  =$prtyChq2j_infor[0];
									$sum_party_chq2j +=$prtyChq2j_debit;
									//$deb_cf=$deb_sum;
									$p_balance=($p_balance+$prtyChq2j_debit);
								}
							
								
						$sqlCusDt= mysql_query("SELECT cusName FROM `custtable` WHERE ID = '".$BankDposit['cusID']."'");
					$cusName=mysql_fetch_array($sqlCusDt);
							 
							 	echo	'  <tr class="success">
                  	<td  style="text-align:left;">'.$prtyChq2j_infor['entryDate'].' </td>
                    <td style="text-align:left;"> '.$stutas.'('.$prtyChq2j_infor['chqNo'].' ) '.$cusName[0].''.$prtyChq2j_infor['rtnOption'].'</td>
                    <td  style="text-align:left;">'.$prtyChq2j_infor['refNo'].'</td>
                    <th   style="text-align:right; background:#DED1BD;" >'.number_format($prtyChq2j_debit,2).' </th>
                     <th style="text-align:right; background:#D3D8E0;">'.number_format($prtyChq2j,2).'</th>
                    <th style="text-align:right;">'.number_format( $p_balance,2).'</th>
                 
                    </tr>';
							 
						
						}
					// party cheque  to journal------------------------------------------------------------------

					// party cheque  to journal received SHIM------------------------------------------------------------------
				
				
							$sqlprtyChq2j_rcv = mysql_query("SELECT amount,journal.Description,bank_deposit.entryDate
																,chqNo,status,cusID FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.j_paymentID = journal.ID WHERE journal.ID = '$j_id' AND bank_deposit.entryDate ='$dateBy' AND `bank_deposit`.br_id='$br_id' AND `bank_deposit`.cloud ='ACCU_JOURN' AND status = 'Payment-J' ");
									
						while ($prtyChq2j_rcv =mysql_fetch_array($sqlprtyChq2j_rcv))
						{
							//echo $prtyChq2j_infor['status'];
							$prtyChq2j_chqrcv =0;
							$prtyChq2j_debit_rcv=0;
							$stutas='';
						
									$stutas ="Party Cheque Recieved";
								 	$prtyChq2j_debit_rcv  =$prtyChq2j_rcv[0];
									$sum_party_chq2j_rcv +=$prtyChq2j_debit_rcv;
									//$deb_cf=$deb_sum;
									$p_balance=($p_balance + $prtyChq2j_debit_rcv);
							
							
								
						$sqlCusDt= mysql_query("SELECT cusName FROM `custtable` WHERE ID = '".$BankDposit['cusID']."'");
					$cusName=mysql_fetch_array($sqlCusDt);
							 
							 	echo	'  <tr class="success">
                  	<td  style="text-align:left;">'.$prtyChq2j_rcv['entryDate'].' </td>
                    <td style="text-align:left;"> '.$stutas.'('.$prtyChq2j_rcv['chqNo'].' ) '.$cusName[0].'</td>
                    <td  style="text-align:left;">'.$prtyChq2j_rcv['refNo'].'</td>
                    <th   style="text-align:right; background:#DED1BD;" >'.number_format($prtyChq2j_debit_rcv,2).' </th>
                     <th style="text-align:right; background:#D3D8E0;">'.number_format($prtyChq2j_chqrcv,2).'</th>
                    <th style="text-align:right;">'.number_format( $p_balance,2).'</th>
                 
                    </tr>';
							 
						
						}
					// party cheque  to journal received SHIM------------------------------------------------------------------
					
					
					
					
					// journal farsan recive chq return------------------------------------------------------------------
				
				//Check Balance Sheet
							$sqljcreturn = mysql_query("SELECT amount,journal.Description,bank_deposit.entryDate,chqNo,status
										FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
										WHERE journal.ID = '$j_id' AND bank_deposit.entryDate ='$dateBy' AND
										 `bank_deposit`.br_id='$br_id' AND rtnID !='0' ");
									
						while ($jcreturn=mysql_fetch_array($sqljcreturn))
						{
							//echo $prtyChq2j_infor['status'];
							$stutas="vfgdfg";
							if($jcreturn['status'] == 'Return-Journal'  ){
								
								$stutas="Return from bank";
								}
								
							else if	 ($jcreturn['status'] == 'J-Return-J' )
							{
							$stutas='Return from journal';
							
							}
						
								  $prtyChq2j_debit=$jcreturn[0];
							$sum_party_chq2jrtn_bk +=$prtyChq2j_debit;
							//$deb_cf=$deb_sum;
							
							$p_balance=($p_balance+$prtyChq2j_debit);						
							 
							 	echo	'  <tr class="success">
                  	<td  style="text-align:left;">'.$jcreturn['entryDate'].' </td>
                    <td style="text-align:left;"> '.$stutas.'('.$jcreturn['chqNo'].'  )</td>
                    <td  style="text-align:left;">'.$jcreturn['refNo'].'</td>
                    <th   style="text-align:right; background:#DED1BD;" >'.number_format($prtyChq2j_debit,2).' </th>
                     <th style="text-align:right; background:#D3D8E0;">'.number_format($prtyChq2j,2).'</th>
                    <th style="text-align:right;">'.number_format( $p_balance,2).'</th>
                 
                    </tr>';
								
							 
						
						}
					// journal recive chq return------------------------------------------------------------------
				
			
			// journal to journal issuss chq return------------------------------------------------------------------
				
						$sum_reissTOj=0;
				
					  $sqljcreturn = mysql_query("SELECT amount,journal.Description,bank_deposit.entryDate,chqNo,status
								  FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
								  WHERE journal.ID = '$j_id' AND bank_deposit.entryDate ='$dateBy' AND
								   `bank_deposit`.br_id='$br_id' AND rtnID ='0' AND status != 'PAID' ");//SHIM adedd AND status != 'PAID'
									
						while ($jcreturn=mysql_fetch_array($sqljcreturn))
						{
							//echo $prtyChq2j_infor['status'];
							$stutas="";
							if ($jcreturn['status'] == 'PAID'){
							$stutas="Paid to Vendor ";
								  $Venpaid_credit=$jcreturn[0];
							$sum_VenPaid +=$Venpaid_credit;
							//$deb_cf=$deb_sum;
							
							$p_balance=($p_balance - $Venpaid_credit);	
							}
							else if($jcreturn['status'] == 'ReIssue-J'){
							$stutas="Reissue To Journal ";
								  $reissTO_credit=$jcreturn[0];
							$sum_reissTOj +=$reissTO_credit;
							//$deb_cf=$deb_sum;
							
							$p_balance=($p_balance + $reissTO_credit);	
							}
							
							if($stutas !=''){
													
							 
							 	echo	'  <tr class="success">
                  	<td  style="text-align:left;">'.$jcreturn['entryDate'].' </td>
                    <td style="text-align:left;"> '.$stutas.'('.$jcreturn['chqNo'].'  )</td>
                    <td  style="text-align:left;">'.$jcreturn['refNo'].'</td>
                    <th   style="text-align:right; background:#DED1BD;" >'.number_format($reissTO_credit,2).' </th>
                     <th style="text-align:right; background:#D3D8E0;">'.number_format($Venpaid_credit,2).'</th>
                    <th style="text-align:right;">'.number_format( $p_balance,2).' </th>
                 
                    </tr>';
							}
							 
						
						}
					// journal recive chq return------------------------------------------------------------------
					
					
					// journal to journal own chq return------------------------------------------------------------------
				
						
				
					  $sqljoreturn = mysql_query("SELECT amount,journal.Description,bank_deposit.entryDate,chqNo,status
								  FROM `bank_deposit` LEFT OUTER JOIN journal ON bank_deposit.directJID = journal.ID 
								  WHERE jDueID = '$j_id' AND bank_deposit.entryDate ='$dateBy' AND
								   `bank_deposit`.br_id='$br_id' AND status != '' AND rtnID !='0' ");
									
						while ($joreturn=mysql_fetch_array($sqljoreturn))
						{
							//echo $prtyChq2j_infor['status'];
							$stutas="";
							if ($joreturn['status'] == 'Own-Return-AccJ'){
							$stutas=" Own cheque return (Accrual journal)";
							}
							else if($joreturn['status'] == 'Own-Return-J'){
							$stutas=" Own cheque return";
							}else if ($joreturn['status'] == 'C-Return'){
							$stutas=" Customer cheque return";
							}
							
							if($stutas !=''){
								  $ownRTn_credit=$joreturn[0];
							$sum_jown_retun +=$ownRTn_credit;
							//$deb_cf=$deb_sum;
							
							$p_balance=($p_balance -$ownRTn_credit);						
							 
							 	echo	'  <tr class="success">
                  	<td  style="text-align:left;">'.$joreturn['entryDate'].' </td>
                    <td style="text-align:left;"> '.$stutas.' -'.$joreturn['chqNo'].' </td>
                    <td  style="text-align:left;">'.$joreturn['refNo'].'</td>
                    <th   style="text-align:right; background:#DED1BD;" >'.number_format(0,2).' </th>
                     <th style="text-align:right; background:#D3D8E0;">'.number_format($ownRTn_credit,2).'</th>
                    <th style="text-align:right;">'.number_format( $p_balance,2).'</th>
                 
                    </tr>';
							}
							 
						
						}
					// journal to journal own chq  return------------------------------------------------------------------
					
					
					
				
			
				
						}
				// Date loop
				$dayD = $dayJd + $dayChqd + $dayChqdOwn+$sum_party_chq2j+$sum_party_chq2j_rcv+$sum_party_chq2jrtn_bk+$sum_reissTOj ;
			$dayC = $dayJc + $dayChqc + $dayChqcOwn+$sum_party_chq2jrtn+$sum_VenPaid+$dChq_sum+$sum_jown_retun;
				
							echo '<tr bgcolor="#D1C1BC">		
						<td style="text-align:left;"> </td>
					  <td style="text-align:left;"> Total </td>
					  <td style="text-align:left;">  </td>
					   <th style="text-align:right;border-top:1px solid;border;border-bottom-style:double; background:#DED1BD;">
					    '.number_format($dayD,2).'  </th>
						 <th style="text-align:right;border-top:1px solid;border;border-bottom-style:double;
						  background:#D3D8E0;">
						  '.number_format($dayC,2).' </th>
						<th style="text-align:right;"> </th>
						</tr>';
						
						
						
							echo '<tr bgcolor="#D1C1BC">		
						<td style="text-align:left;"> </td>
					  <td style="text-align:left;"> C/F </td>
					  <td style="text-align:left;">  </td>
					   <th style="text-align:right;border-top:1px solid;border;border-bottom-style:double; background:#DED1BD;">
					     </th>
						 <th style="text-align:right;border-top:1px solid;border;border-bottom-style:double;
						  background:#D3D8E0;"> </th>
						<th style="text-align:right;">'.number_format($p_balance,2).' </th>
						</tr>';
						
						
									 
					 echo'  </tbody>';
		 
	 echo'<tfoot>
			
			
		</tfoot>';
	//}
	//}
	?> 
			</table>
            
        
            
    	</div>
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

<div  id="mainLoadInvoSumry">


    <!-- ajax content load -->        
</div>


            

  

</div>
    <!-- content ends -->
    </div>
	
    
    <?php include ($path.'footer.php'); ?>
<?php include ('statment_script.php'); ?> 
    
    <script>
	//var vl = $('#TYPE').val();
//alert(vl);
	$('#jouStat').click(function(){
			var vlu = $('#jou_id').val();
			var f_date = $('#from_d').val();
			var t_date = $('#to_d').val();
		//alert(vlu);
		//alert('' +invID);
		window.open("print/New_JournalStatment_prnt.php?ITEM="+vlu+"&FDATE="+f_date+"&TDATE="+t_date+"" , "myWindowName","width=595px, height=842px");	
						
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
	
	$(".jou_id2").keyup(function(){
	
	var jouID = $('.jou_id2').val();
	autoTypeNo2=1 ;
	autoTypeNo1=0 ;
	
	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'ajx/get_jacc.php',
				dataType: "json",
				method: 'post',
				data: {
				 // ID: request.term,
				  accID : jouID  
				},
				 success: function( data ) {
					 response( $.map( data, function( item ) {
					 	var code = item.split("|");
						if(code[0] == 'Login Please'){
							window.location = '../login.php';										
						}
						return {
							label: code[1] + ' - ' + code[0],
							value: code[autoTypeNo1],
							data : item
						}
					}));
				}
			});
		},
		autoFocus: true,	      	
		minLength: 0,
		select: function( event, ui ) {
			var names = ui.item.data.split("|");						
			id_arr = $(this).attr('id');
	  		id = id_arr.split("_");
			//itemSearchEnables(thisRow);
			
				 $('#jou_id').val(names[1]);
				// $('#jornal_2').val(names[0]);
				 
			
			
		}		      	
	});
	
	});
	
});

</script>

