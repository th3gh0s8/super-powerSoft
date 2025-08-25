<?php
$title = 'Customer Statement';
include ('includeFile.php');

$from_d	= $_GET['from_d'] ;
$to_d = $_GET['to_d'];  
$cus_id =$_GET['cus_id'];
if($_GET['cus_name'] != 'undefined'){
$cus_name =$_GET['cus_name'];
}

$_SESSION['f_day']= $from_d;
$_SESSION['t_day']= $to_d;

$_SESSION['cus_name']= $cus_name;

$reportPrnt = 'cusStat';
$report_cus='cus_stat';
//$ItemSearch = 'ItemSearch';
$from_d = date_format(date_create($from_d), 'Y-m-d');
$to_d = date_format(date_create($to_d), 'Y-m-d');
//$b_date = $from_d->modify('+1 day');

echo $b_date;

$to_ddd = date('Y-m-d', strtotime('+1 day', strtotime($to_d)) );

$from_x = DateTime::createFromFormat("Y-m-d","$from_d");
$to_x = DateTime::createFromFormat("Y-m-d","$to_ddd");

$periodInterval = new DateInterval( "P1D" ); // 1-day, though can be more sophisticated rule
$period = new DatePeriod( $from_x, $periodInterval, $to_x );


$mysqluser= $mysqli->query("SELECT `ID`,`CustomerID`, `Address` FROM `custtable` WHERE `ID`='$cus_id'");
$resltuser= $mysqluser->fetch_array();

$cusTb = $resltuser[0];
$cus_code = $resltuser[1];
$cusAddress = $resltuser[2];
 $sql_brnch = $mysqli->query("SELECT name FROM com_brnches  WHERE ID = '$br_id'");
  $res_brnch = $sql_brnch->fetch_row();
  $compnyName = $res_brnch[0];
//echo 'dds '.$cus_code;

$_SESSION['cus_id']= $cus_code;


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

.row{
	padding: 36px 0px;
	}

</style>
		<?php include ('New_report_bar.php'); ?>
        
   </br>
   
   
   
   
   
   
    <div id="ajaxRespon" style="width:95%; ">                
  		 <div id="remove_TTb" style="background:#FFF;  margin-left:34px; margin-top:-50px; padding-bottom:10px;"> 
    		
             <table class="table2 table-striped table-bordered bootstrap-datatable table-hover responsive invoSumryTB2"
             style="margin-top:30px; width:100%;  margin: 0 auto; border:0px; background-color:transparent;";>
             <tr >
             <th style="border:0px; background-color:transparent; text-align:center;" > Customer Statement </th>
              
              </tr>
              <tr>
              <th style="border:0px; background-color:transparent; text-align:center;" > As at 
			  <?php echo  date('d-M-Y', strtotime($month . $from_d)); ?> To
               <?php echo  date('d-M-Y', strtotime($month . $to_d)); ?> </th>
              </tr>
              <tr>
              
              <th style="border:0px; background-color:transparent; text-align:center;" > <?php echo $cus_code.' - '.$cus_name; ?>  <br /> <?php echo $cusAddress; ?></th>
             
              </tr> 
              <tr> <th style="border:0px; background-color:transparent; text-align:center; height:5px;">  </th>  </tr>
             </table>
            
            <div class="col-sm-12" style="background:#FFF;">
            
            <table class="table  table-bordered bootstrap-datatable table-hover  responsive invoSumryTB" style="margin-top:30px;
                width: 100%; margin-left: 10px;";>
                <thead>
                <tr>
                  	<th width="10%" style="text-align:left;">Date </th>
                    <th width="20%" style="text-align:left;">Particulars</th>
                    <th width="8%" style="text-align:left;">Note</th>
                    <th width="5%" style="text-align:left;">Rcpt No</th>
                    <th width="10%" style="text-align:left;">Debit </th>
                     <th width="10%" style="text-align:left;">Credit</th>
                    <th width="10%" style="text-align:left;">Balance</th>
                 
                    </tr>
                </thead>
                <tbody>
        
       
      		  <?php
			
				//$bf_balance =0;
				$p_balance= 0;
				$p_balance2= 0;
				$paid_sum=0;
				$inv_sum=0;
				$chq_sum=0;
				$from_d2=$from_d;
				
				
					
				
			
			// get B/F
					//$qry_bf="SELECT SUM(`Balance`) FROM `invoice` WHERE `CusID`='$cus_id' and `Date` < '$from_d'
					// and `br_id`='$br_id'  ";
					$qry_bf="SELECT SUM(  `InvAmnt` ) - SUM(  `Paid` ) FROM  `cusstatement` WHERE  `cusTbID`='$cusTb'
					AND  `Date` <  '$from_d' AND  `br_id` =  '$br_id'";

				  $qry_bf2=$mysqli->query($qry_bf);
						 while($exc_bf =  $qry_bf2->fetch_array()){
							
							$itm_count= $itm_count +1;
							$dif =$itm_count % 2;
							
						$bf_balance	= $exc_bf[0];
					
							
							echo '  <tr bgcolor="#D1C1BC">
									<td style="text-align:left;"> </td>
									  <td style="text-align:left;"> B/F </td>
									  <td style="text-align:left;">  </td>
									  <td style="text-align:left;">  </td>
									   <th width="10%"> </th>
										 <th width="10%"> </th>
										<th style="text-align:right;">'.number_format($bf_balance,2).'</th>
									  </tr> ';
							
						 }
				// get B/F
				
				
				
				// Date loop	
			
				$qry_stmDate=$mysqli->query("SELECT `Date` FROM  `cusstatement` WHERE  `cusTbID`='$cusTb'
					AND  `Date` between  '$from_d' and '$to_d' AND  `br_id` =  '$br_id' group by `Date` order by `Date` asc");
			
			while($stmDate=$qry_stmDate->fetch_array()){
			
				//foreach($period as $date){//DAY LOOP
   			//echo $date->format("Y-m-d") , PHP_EOL.'</br>';
   			//$dateBy  = $date->format("Y-m-d") ;
			$dateBy  = $stmDate[0];
			//echo "one".$dateBy."<br>";
			
						 $qry_dt2=$mysqli->query("SELECT `Date`,`InvNO`,`Stype`,`InvTot`,`Balance`,`Location`, `dscrpn_note`, purchNo, RcvdAmnt  FROM `invoice`
						  WHERE `cusTbID`='$cusTb' AND `invoice`.`Date` = '$dateBy' AND `br_id`='$br_id' AND `invoice`.`Stype` != 'Balance' AND InvNO NOT LIKE 'Rtn-%' ");
					 
					  $qry_cussta=$mysqli->query("SELECT `Date`,`InvNo`, `RepID`,`Paid`,`ReceiptNo`,DueNote, Locatoin FROM `cusstatement`
					   WHERE  `cusTbID`='$cusTb' AND `cusstatement`.`Date` ='$dateBy' AND `Paid` != '0' and `br_id`='$br_id' ");
					   
					   
					   $qry_bal=$mysqli->query("SELECT `cusstatement`.`Date`,`cusstatement`.`InvNo`,
					   `cusstatement`.`RepID`,`cusstatement`.`InvAmnt`,`ReceiptNo`,DueNote
					FROM `cusstatement` JOIN `invoice` 
					   ON `cusstatement`.`invID`=`invoice`.`ID`   WHERE `cusstatement`.`cusTbID`='$cusTb' 
					   AND `cusstatement`.`Date` ='$dateBy' AND `cusstatement`.`br_id`='$br_id' 
					   and `FromDue` !='Due' AND `invoice`.`Stype` = 'Balance' ");
					   
					   $mysqli->query("SET SQL_BIG_SELECTS=1");
					      $qry_return=$mysqli->query("SELECT `cusstatement`.`Date`,`cusstatement`.`InvNo`,
					   `cusstatement`.`RepID`,`cusstatement`.`InvAmnt`,`ReceiptNo`,DueNote 
					FROM `cusstatement` JOIN `invoice` 
					   ON `cusstatement`.`invID`=`invoice`.`ID`   WHERE `cusstatement`.`cusTbID`='$cusTb' 
					   AND `cusstatement`.`Date` ='$dateBy' AND `cusstatement`.`br_id`='$br_id' 
					   and `FromDue` !='Due' AND `invoice`.`RepID` IN('Rtn Chq','Re Issue Chq','Order Delete','Rtn Chgs')");
					
				        $stu;
						 while($exc_ret =  $qry_return->fetch_array()){
							$inv_tot=$exc_ret[3];
							if($exc_ret['RepID'] != 'Order Delete'){
							    $stu='Return';
							}
							
                            $inv_sum=$inv_sum+$inv_tot;
                            $p_balance=($bf_balance+$inv_sum)-$paid_sum;
							
							echo '  
                                <tr class="success">
                                <td style="text-align:left;"> '.$exc_ret[0].'</td>
                                
                                <td style="text-align:left;"> '.$exc_ret[1] .' &nbsp; &nbsp; &nbsp; &nbsp; 
                                '. $exc_ret[2] .' '.$stu.' </td>
                                <td style="text-align:left;">'.$exc_ret['DueNote'].'</td>
                                <td style="text-align:left;">  </td>
                                <th style="text-align:right; background:#DED1BD;" > '.number_format($inv_tot,2).' </th>
                                <th style="text-align:right; background:#D3D8E0;" > </th>
                                <th style="text-align:right;" >'.number_format( $p_balance,2).'</th>
                            </tr> ';
						 }
					
					// get details customer bginer balance
					
				 $stu;
						 while($exc_bl =  $qry_bal->fetch_array()){
							 
							
							 
									$inv_tot=$exc_bl[3];
									$stu='Balance';
								
								 
							$inv_sum=$inv_sum+$inv_tot;
							
							
								$p_balance=($bf_balance+$inv_sum)-$paid_sum;
							
							
							echo '  <tr class="success">
									<td style="text-align:left;"> '.$exc_bl[0].'</td>
									
									  <td style="text-align:left;"> '.$exc_bl[1] .' &nbsp; &nbsp; &nbsp; &nbsp; 
									  '. $exc_bl[2] .' '.$stu.' </td>
									<td style="text-align:left;">'.$exc_bl['DueNote'].'</td>
									  <td style="text-align:left;">  </td>
									   <th   style="text-align:right; background:#DED1BD;" > '.number_format($inv_tot,2).' </th>
										 <th  style="text-align:right; background:#D3D8E0;" > </th>
										<th  style="text-align:right;" >'.number_format( $p_balance,2).'</th>
									  </tr> ';
							
						 }
				// get details cus balance
					
					
				
				// get details invoice
    					 while($exc_dt =  $qry_dt2->fetch_array()){
                            $inv_tot=$exc_dt[3];
                            $RcvdAmnt=$exc_dt['RcvdAmnt'];
                            $stu='Invoice';
                            $note=($exc_dt['Location'] != '' || $exc_dt['dscrpn_note'] != '') ? ''.$exc_dt['Location'].' '.$exc_dt['dscrpn_note']:'';
    							
    						$inv_sum=$inv_sum+$inv_tot;
                            $p_balance=($bf_balance+$inv_sum)-$paid_sum;
    						
    						if($RcvdAmnt == $inv_tot){
    						    $credit_status = "Cash";
    						}elseif($RcvdAmnt != 0){
    						    $credit_status = "Partially Cash";
    						}else{
    						    $credit_status = "Credit";
    						}

    						echo '  
                                <tr class="success">
                                <td style="text-align:left;"> '.$exc_dt[0].'</td>
                                
                                <td style="text-align:left;"> <a style="cursor:pointer; color:blue;" class="click_invDetail" value="'.$exc_dt[1].'">'.$exc_dt[1] .'</a>&nbsp; &nbsp; 
                                '.$credit_status.' '.$stu.' '.$exc_dt['purchNo'].' '. $exc_dt[2] .'</td>
                                <td style="text-align:left;">'.$note.' </td>
                                <td style="text-align:left;">  </td>
                                <th style="text-align:right; background:#DED1BD;" > '.number_format($inv_tot,2).' </th>
                                <th style="text-align:right; background:#D3D8E0;" > </th>
                                <th style="text-align:right;" >'.number_format( $p_balance,2).'</th>
                                </tr>
                            ';
    					 }
				// get details invoice
				
				
				// get details cusStatement
				//	echo 'run.............';
				 /* $qry_cussta=$mysqli->query("SELECT `Date`,`InvNo`, `RepID`,`Paid`,`ReceiptNo` FROM `cusstatement` WHERE  `CusID`='$cus_id' AND
					 `cusstatement`.`Date` BETWEEN '$from_d' AND '$to_d' ORDER BY `cusstatement`.`Date` ASC ");*/
					 
						 while($exc_cus =  $qry_cussta->fetch_array()){
							
							$paid=$exc_cus[3];
							$paid_sum= $paid_sum +$paid;
							
							
							$p_balance2=($bf_balance+$inv_sum) - $paid_sum;
							
							$stutas='';
							if ($exc_cus['RepID']=='CJournal')
							{
								$recpt_no=$exc_cus['ReceiptNo'];
								
								if($recpt_no == '0'){
								    $qry_journal=$mysqli->query("SELECT Description FROM `journal` WHERE ID = '$exc_cus[Locatoin]'");
    								$exc_jou= $qry_journal->fetch_array();
    								$stutas=$exc_jou[0].' - Bank';
								}else{
								    $qry_journal=$mysqli->query(" SELECT `AccName` FROM `jentry` where `ReceiptNo`='$recpt_no' AND br_id='$br_id' ");
    								$exc_jou= $qry_journal->fetch_array();
    								$stutas=$exc_jou[0].' - Bank';
								}
								
							}
							else
							{
								$stutas= ($exc_cus[2] == '')? 'Cash ': $exc_cus[2];
							}
							
							$byInvoice = '';
							$sql_chkCashPaid = $mysqli->query("SELECT ID FROM invoice WHERE ID = $exc_cus[invID] AND RcvdAmnt != 0");
							if($sql_chkCashPaid->num_rows == TRUE){
							    $byInvoice = " By Invoice";
							}
							
							echo '  <tr class="success">
									<td style="text-align:left;"> '.$exc_cus[0].'</td>
									  <td style="text-align:left;"> <a style="cursor:pointer; color:blue;" class="click_invDetail" value="'.$exc_cus[1].'">'.$exc_cus[1] .'</a> &nbsp; &nbsp;'
									  . $stutas .' Payment '.$byInvoice.' </td>
									  <td style="text-align:left;">'.$exc_cus['DueNote'].'</td>
									  <td style="text-align:left;"><a class="reciptNo" style="color:blue; cursor:pointer;" recValue="'.$exc_cus[4].'"> '.$exc_cus[4].'  </a></td>
									   <th  style="text-align:right; background:#DED1BD;" >  </th>
										 <th  style="text-align:right; background:#D3D8E0;" > '
										 .number_format($exc_cus[3],2).' </th>
										<th  style="text-align:right;" >'.number_format( $p_balance2,2) .'</th>
									  </tr> ';
							
						 }
				// get details cusStatement
				
				
				
						}
				// Date loop
					$p_balance2=($bf_balance+$inv_sum) - $paid_sum;
				
							echo '<tr bgcolor="#D1C1BC">		
						<td style="text-align:left;"> </td>
					  <td style="text-align:left;">  </td>
					  <td style="text-align:left;">  </td>
					  <td style="text-align:left;">  </td>
					   <th style="text-align:right;border-top:1px solid;border;border-bottom-style:double; background:#DED1BD;">
					    '.number_format($inv_sum,2).'  </th>
						 <th style="text-align:right;border-top:1px solid;border;border-bottom-style:double; background:#D3D8E0;">
						  '.number_format($paid_sum,2).' </th>
						<th style="text-align:right;"> </th>
						</tr>
						
						<tr bgcolor="#D1C1BC">		
						
						<td style="text-align:left;"> </td>
					  <td style="text-align:left;"> C/F </td>
					  <td style="text-align:left;">  </td>
					  <td style="text-align:left;">  </td>
					   <th style="text-align:right;">   </th>
						 <th style="text-align:right;"> '.number_format($inv_sum-$paid_sum, 2).' </th>
						<th style="text-align:right;"> '.number_format($p_balance2,2).' </th>
						</tr>';
									 
					 echo'  </tbody>';
		 
	 echo'<tfoot>
			
			
		</tfoot>';
	//}
	//}
	?> 
			</table>
            
            </div>
            
            <!-- order details-->
            
             <div class="col-sm-12" style="background:#FFF;">
            
            <h4 style="text-align:center;"> Order Details </h4>
            
            <table class="table   bootstrap-datatable table-bordered  table-hover  responsive invoSumryT" style="margin-top:30px; ">
                <thead>
                <tr>
                  	<th width="10%" style="text-align:left;">Date </th>
                    <th width="30%" style="text-align:left;">Order ID/Invoice ID</th>
                    <th width="30%" style="text-align:left;">Sales Rep</th>
                    <th width="10%" style="text-align:left;">Total </th>
                     <th width="10%" style="text-align:left;">Paid</th>
                    <th width="10%" style="text-align:left;">Balance</th>
                    
                 
                    </tr>
                </thead>
                <tbody>
                
                
                
                <?php
                $order_tot=0;
				$order_paid=0;
				$order_bl=0;
                
					$qry_ord="SELECT  `order_id`,  `cus_name`, `sal_rep`, `dates`, `total`, `paid`, `balance` FROM `order_tb` WHERE `cus_id`='$cus_code'
					 and `dates` Between '$from_d' and '$to_d' AND cloud != 'DELETED'
				    and `br_id`='$br_id' ";
					//echo $qry_ord;
				
				  $qry_ord2=$mysqli->query($qry_ord);
					
						 while($exc_ord =  $qry_ord2->fetch_array()){
							$order_tot=$order_tot+ $exc_ord['balance'];
							 $order_bl=$order_tot;
							echo ' <tr class="success">
                  	<th style="text-align:left;">'.$exc_ord['dates'] .'</th>
                    <th style="text-align:left;">'.$exc_ord['order_id'] .' [Order]</th>
                    <th  style="text-align:left;">'.$exc_ord['sal_rep'] .'</th>
                    <th style="text-align:right;">'. number_format( $exc_ord['total'],2) .' </th>
                     <th style="text-align:right;">'.number_format( $exc_ord['paid'],2) .'</th>
                    <th style="text-align:right;">'. number_format( $order_bl,2).'</th>
                    
                 
                    </tr>';
							 
						 }
						 
					?>
                    
                    
                    
                    
                        <?php
                
                
					$qry_ordinv="SELECT  (`InvTot`-`RcvdAmnt`) as Balance, `CusID`, `Date`, `InvNO`, `InvTot`, `RcvdAmnt`, `RepID`, `order_id` FROM
					 `invoice` WHERE CusID='$cus_code' and `Date` Between '$from_d' and '$to_d'  and `br_id`='$br_id' and `order_id` != ''  ";
					//echo $qry_ord;
				
				  $qry_ordinv2=$mysqli->query($qry_ordinv);
					
						 while($exc_ordinv =  $qry_ordinv2->fetch_array()){
							echo ' <tr class="success">
                  	<th style="text-align:left;">'.$exc_ordinv['Date'] .'</th>
                    <th style="text-align:left;">'.$exc_ordinv['order_id'] .' [Order] / '.$exc_ordinv['InvNO'] .' [Invoice] </th>
                    <th  style="text-align:left;">'.$exc_ordinv['RepID'] .'</th>
                    <th style="text-align:right;">'.number_format( $exc_ordinv['InvTot'],2) .' </th>
                     <th style="text-align:right;"></th>
                    <th style="text-align:right;"></th>
                    
                 
                    </tr>';
							 
						 }
						 
					?>
                    
                    
                    
                         <?php
                
                
					$qry_ordpaid="SELECT `cusstatement`.`Date`, `InvAmnt`, `cusstatement`.`InvNo`, `Paid`,invoice.order_id FROM
					 `cusstatement`JOIN invoice on `cusstatement`.`invID`=invoice.ID where cusstatement.FromDue='Due' AND 
					  `cusstatement`.CusID='$cus_code' and `cusstatement`.`Date` Between '$from_d' and '$to_d' 
					   and `cusstatement`.`br_id`='$br_id'  and invoice.order_id != '' ";
					//echo $qry_ordpaid;
				
				  $qry_ordpaid2=$mysqli->query($qry_ordpaid);
					
						 while($exc_ordpaid =  $qry_ordpaid2->fetch_array()){
							 
							 $order_paid=$order_paid+$exc_ordpaid['Paid'];
							 $order_bl=$order_tot-$order_paid;
							 
							echo ' <tr class="success">
                  	<td style="text-align:left;">'.$exc_ordpaid['Date'] .'</td>
                    <td style="text-align:left;">'.$exc_ordpaid['order_id'] .' Due </td>
                    <td  style="text-align:left;"></td>
                    <td style="text-align:right;"> </td>
                     <td style="text-align:right;">'.number_format($exc_ordpaid['Paid'],2) .'</td>
                    <td style="text-align:right;">'.number_format($order_bl,2).'</td>
                    
                 
                    </tr>';
							 
						 }
						 
						 
						 	echo ' <tr bgcolor="#D1C1BC">
                  	<th style="text-align:left;"></th>
                    <th style="text-align:left;"> Balance </th>
                    <th  style="text-align:left;"></th>
                    <th style="text-align:right;"> </th>
                     <th style="text-align:right;"></th>
                    <th style="text-align:right;">'.number_format($order_bl,2).'</th>
                    
                 
                    </tr>';
						 
					?>
                    
                    
                
                 </tbody>
                </table>
            
            
            <div>
            
              <!-- order details ---------------------end  -->
            
            
            
            
            <!-- cheque details ------------------------->
            
            <div class=" chq_det">
            
            <h4 style="text-align:center;"> Cheque Details </h4>
            
            <table class="table   bootstrap-datatable table-bordered  table-hover  responsive invoSumryTB" style="margin-top:30px";>
                <thead>
                <tr>
                  	<th style="text-align:left;">Date </th>
                    <th style="text-align:left;">Chq No</th>
                    <th style="text-align:left;">Bank</th>
                    <th style="text-align:left;">Branch </th>
                    <th style="text-align:left;">Chq Date</th>
                    <th style="text-align:left;">Amount</th>
                    <th style="text-align:left;">Own Type</th>
                    <th style="text-align:left;">Status</th>
                 
                    </tr>
                </thead>
                <tbody>
                
             <?php
                // get details invoice
					//echo 'f date '. $from_d;
					$qry_chkd="
					SELECT recordDate, chqNo, cashDate, chqAmount, ownerType, refNo, ID FROM  `chq_recieve` 
					WHERE  `chq_recieve`.CusId =  '$cus_code' AND  `chq_recieve`.`entryDate` 
					BETWEEN  '$from_d' AND  '$to_d' AND  `br_id` =  '$br_id'";
				//	echo $qry_chkd;
				
				  $qry_chq=$mysqli->query($qry_chkd);
					
						 while($exc_chq = $qry_chq->fetch_array()){
							$chq_no= $exc_chq['1'];
							
							$chq_sum=$chq_sum+$exc_chq['3'];
							$bnk_code = substr($chq_no,6,4);
						
							
							$qry_bk=$mysqli->query("SELECT `BName`,`BAddress3` FROM `bank` WHERE `BCode`='$bnk_code'");
							 while($exc_bk =  $qry_bk->fetch_array() ){
								 $bk_name= $exc_bk['0'];
								 $bk_br= $exc_bk['1'];
							 }
							 
							
							$br_code = substr($chq_no,10,13);
							//echo 'br code'. $br_code .'<br>' ;
						
							
							$qry_bk=$mysqli->query("SELECT `BName`,`BAddress3` FROM `bank` WHERE `BCode`='$bnk_code'");
							 while($exc_bk =  $qry_bk->fetch_array()){
								 $bk_name= $exc_bk['0'];
								
							 }
							 
							 $qry_br=$mysqli->query("SELECT `BrName` FROM `branch` WHERE 
							 `BCode`='$bnk_code' and `BrCode`='$br_code'");
							 while($exc_br =  $qry_br->fetch_array()){
								 $bk_br= $exc_br['0'];
								$bk_br= trim($bk_br, ",");
							 }
							
							$sql_bankDepositDet = $mysqli->query("SELECT status, ID FROM `bank_deposit` WHERE `rcvTbID` = '$exc_chq[ID]'");
							if($sql_bankDepositDet->num_rows == TRUE){
							    $bankDepositDet = $sql_bankDepositDet->fetch_array();
							    
							    $sql_returnDet = $mysqli->query("SELECT ID  FROM `bank_deposit` WHERE `rtnID` = '$bankDepositDet[ID]'");
							    if($sql_returnDet->num_rows == true){
							        $chqStatus = 'Returned';
							    }else{
							        $chqStatus = $bankDepositDet['status'];
							    }
							    
							}else{
							    $chqStatus = 'In Hand';
							}
							
							
							echo '   <tr class="success">
                  	<td width="7%" style="text-align:left;">'.$exc_chq['0'] .' </td>
                    <td width="10%" style="text-align:left;">'.$exc_chq['1'] .'</td>
                    <td width="25%" style="text-align:left;">'.$bk_name.'</td>
                    <td width="30%" style="text-align:left;">'.trim($bk_br,".") .' </td>
                     <td width="10%" style="text-align:left;">'.$exc_chq['2'] .'</td>
                    <td width="10%" style="text-align:right;">'.number_format($exc_chq['3'],2) .'</th>
                    <td width="10%" style="text-align:left;">'.$exc_chq['4'] .'</td>
                    <td width="10%" style="text-align:left;">'.$chqStatus.'</td>
                    </tr>';
							
						 }
						 
						 
						 	echo '   <tr bgcolor="#D1C1BC">
                  	<th width="7%" style="text-align:left;"> </th>
                    <th width="10%" style="text-align:left;"></th>
                    <th width="25%" style="text-align:left;"></th>
                    <th width="30%" style="text-align:left;"> </th>
                     <th width="10%" style="text-align:left;"></th>
                    <th width="10%" style="text-align:right;border-top:1px solid;border;border-bottom-style:double;">
					'.number_format($chq_sum,2) .'</th>
                    <th width="10%" style="text-align:left;"></th>
                    <th width="10%" style="text-align:left;"></th>
                    </tr>';
						 
				?>
                </tbody>
                </table>
            
            
            <div>
            
             <!-- cheque details ------------------------->
    
      <!-- Return cheque details ------------------------->
            
            <div class="chq_det">
            <h4 style="text-align:center;"> Return Cheque Details </h4>
            
            <table class="table   bootstrap-datatable table-bordered  table-hover  responsive invoSumryTB" style="margin-top:30px";>
               <thead>
                <tr>
                  	<th width="10%">Date </th>
                    <th>Ref No</th>
                    <th>Customer</th>  
                    <th>Chq No</th>
                    <th>Account No</th>
                    <th>Amount</th>
                    <th>Paid </th>
                    <th> Balance </th> 
                    <th>Return Charge</th>
                    <th>Deposit Date</th>
                    <th>Bank / Banch</th>
                    <th>Staff</th>
                    </tr>
                </thead>
                <tbody>
                
             	  <?php
			$sqlDpChq2= $mysqli->query("SELECT `chqNo` ,`chqRefNo`, `cusID`, `venID`, `jourID`, `bnkCode`, `bnkBrCode`, `amount`, `chqType`, 
									`depositDate`, `userID`, `status`,directJID,entryDate,rtnOption,rntChqChrg FROM `bank_deposit` 
									WHERE entryDate BETWEEN '$from_d' AND '$to_d' AND br_id = '$br_id' 
									AND status IN ('C-Return', 'C-Return-V') AND `cusID`='$cus_id' ");
			
			$Tot_rtnPaid=0;
			$Tot_rtnBl=0;
			
			while($FindChq = $sqlDpChq2->fetch_array()){
				
					$sql_RepID = $mysqli->query("SELECT Name FROM `salesrep`JOIN sys_users 
											ON `salesrep`.RepID = sys_users .RepID 
											WHERE `log_tb_id` = '$FindChq[userID]'");
					$RepID = $sql_RepID->fetch_array();
					
						$sqlbrNM = $mysqli->query("SELECT bank.BName,branch.BrName
												FROM bank JOIN branch  ON bank.BCode = branch.BCode
												WHERE bank.BCode = '$FindChq[bnkCode]' AND branch.BrCode= '$FindChq[bnkBrCode]' " );
									$brNM = $sqlbrNM->fetch_array();
									
					$qry_acc=$mysqli->query("SELECT `accountNo` FROM `chq_recieve` WHERE `chqNo`='".$FindChq['chqNo']."' AND `br_id`='".$br_id."'");
					$arr_acc=$qry_acc->fetch_array();
					
					$qry_rtnPaid=$mysqli->query("SELECT SUM(`Paid`) FROM `cusstatement` WHERE `InvNo`='Rtn-".$FindChq['chqNo']."' 
					AND `br_id`='".$br_id."'");
					$rtnPaid=$qry_rtnPaid->fetch_array();
					$paid=$rtnPaid[0];
					$rtnBl=$FindChq['amount']-$paid;
					$Tot_rtnBl +=$rtnBl;
					$Tot_rtnPaid += $paid; 
							
						echo'<tr class="success">
						<td style="text-align:left;  " >'.$FindChq['entryDate'].'</td>
						<td style="text-align:left;  " >'.$FindChq['chqRefNo'].'</td>
						<td style="text-align:left;  ">'.$cus_name.''.$type.'</td>
						<td style="text-align:left;  ">'.$FindChq['chqNo'].'</td>
						<td style="text-align:left;  ">'.$arr_acc[0].'</td>
						<td style="text-align:right;  ">'.number_format($FindChq['amount'],2).'</td>
						<td style="text-align:right;  ">'.number_format($paid,2).'</td>
						<td style="text-align:right;  ">'.number_format($rtnBl,2).'</td>
						<td style="text-align:right;  ">'.number_format($FindChq['rntChqChrg'],2).'</td>
						<td style="text-align:left;  ">'.$FindChq['depositDate'].'</td>
						<td style="text-align:left;  ">'.$brNM[0].' - '.$brNM[1].'</td>
						
						<td style="text-align:left;">'.$RepID[0].'</td>
						</tr>';
						$total_nw += $FindChq['amount'];
			}
		 echo'  </tbody>';
		 echo'  </tbody>';
		  echo'
	<tfoot style=" background:#D1C1BC; border-top:2px solid;">
		<tr>	
			
            <th colspan="5" style=" text-align:right; font-weight:5px; font-size:13px;">Total</th>
            <th style="text-align:right;border-top:1px solid;border-bottom-style:double;">'.number_format($total_nw,2).'</th>
			<th style="text-align:right;border-top:1px solid;border-bottom-style:double;">'.number_format($Tot_rtnPaid,2).'</th>
			<th style="text-align:right;border-top:1px solid;border-bottom-style:double;">'.number_format($Tot_rtnBl,2).'</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			
		</tr>
    </tfoot>';
	//}
	//}
	?>
                </table>
            
            
            <div>
            
             
            
            
            
    	</div>
    </div>
    <!-- return cheque details ------------------------->
    
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
    </div>
     </div>
      </div>
      </div>
      
 
    
      <?php include ($path.'footer.php'); ?>
<?php include ('statment_script.php'); ?> 
    
	
    <script>
	//var vl = $('#TYPE').val();
//alert(vl);
	$('#cusStat').click(function(){
			var vlu = $('#cus_id').val();
			var f_date = $('#from_d').val();
			var t_date = $('#to_d').val();
		//alert(vlu);
		//alert('' +invID);
		window.open("print/New_CustmrStatment_prnt.php?ITEM="+vlu+"&FDATE="+f_date+"&TDATE="+t_date+"" , "myWindowName","width=595px, height=842px");	
						
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
