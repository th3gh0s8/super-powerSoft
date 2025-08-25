<?php

$title = 'Rep Wise Receivable by Date';
include ('includeFile.php');
$from_d	= $_GET['from_d'] ;
$to_d = $_GET['to_d'];  

$report_sale = 'report_salesman';
if($_GET['sales_id'] != 'undefined'){
	$sales_id =$_GET['sales_id'];
}
else{$sales_id ='View All';
//$sl_name = 'View All';
}
//echo '12 '.$_SESSION['sl_Nm'];


if($user_type == 'Admin'){	
	if($_GET['sales_id'] != 'undefined'){
		$sales_id =$_GET['sales_id'];
	}else{
		$sales_id ='View All';
	}
}else{
	$sql_Uname11 = mysql_query("SELECT salesrep.Name,salesrep.RepID  FROM `sys_users` JOIN salesrep ON sys_users.`repID` = salesrep.RepID 
				WHERE sys_users.`ID` = '$user_id'");
				
		$uNAME = mysql_fetch_array($sql_Uname11);
		
		$issuedItem=mysql_query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
				 `user_id` ='$user_id' AND `page_title` ='control_Rep_Control' AND `user_rights`.`br_id`='$br_id'");
					$count_issuedItem=mysql_num_rows($issuedItem);
		
		if($count_issuedItem > 0){
		    $sales_id = $uNAME[1];
						/*	$rgt_count_issuedItem ='YES';
						if($_GET['sales_id'] != 'undefined'){
							$sales_id =$_GET['sales_id'];
						}else{
							$sales_id ='View All';
						}	
						*/			
		}
	
}


$_SESSION['f_day']= $from_d;
$_SESSION['t_day']= $to_d;
$_SESSION['sl_id']= $sales_id;

$reportPrnt = 'salesReport';
$from_d	= ($from_d != '')? $from_d : date('Y-m-d');
$to_d	= ($to_d != '')? $to_d : date('Y-m-d');
$from_d = date_format(date_create($from_d), 'Y-m-d');
$to_d = date_format(date_create($to_d), 'Y-m-d');
//echo $from_ddd.' | '.$to_ddd.' | '.$sales_id;

//Date option -----------------------------------------------------------------------------------------------

$datewith;
$datewithcus;

//$dateop=mysql_query("SELECT `optionPath` FROM `optiontb` WHERE `br_id`='$br_id' AND `opertionName`='sales_rep_recieve' ");
//$dateopDT=mysql_fetch_array($dateop);
//echo $dateopDT[0];

//if($dateopDT[0]=="no_date")
//{
	$datewith='';
	$datewithcus='';
	// without date
if($sales_id == 'View All'){
		$sqlFindcus= $xdata->query("SELECT InvNo,cusID,`custtable`.`cusName` FROM invoice JOIN `custtable` ON
		 invoice.cusTbID=`custtable`.`ID`
							WHERE  invoice.br_id = '$br_id' AND invoice.Date between '$from_d' AND '$to_d' AND Balance != '0' GROUP BY cusID ORDER by `custtable`.`cusName` ASC ");
}else{
		$sqlFindcus= $xdata->query("SELECT InvNo,cusID,`custtable`.`cusName` FROM invoice JOIN `custtable` ON
		 invoice.cusTbID=`custtable`.`ID`
							WHERE invoice.br_id = '$br_id' AND RepID = '$sales_id' AND invoice.Date between '$from_d' AND '$to_d' AND Balance != '0'
							 GROUP BY cusID ORDER by `custtable`.`cusName` ASC");
	
}

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
   
   <div id="remove_TTb" class="findexcel">
    <table class="table table-striped table-bordered bootstrap-datatable responsive invoSumryTB" style="margin-top:10px";>
        <thead>
        <tr>
			<th width="30%" >Customer ID / Name</th>
            <th width="8%" >Inv No / Purch No</th>
            <th width="10%" >Invoice Total</th>
            <th width="10%" >Paid </th>
            <th width="10%" >Bal</th>
            <th width="10%" >Curnt.Bal</th>
            <th width="4%" >Age</th>
            <th width="8%" >Date</th>
            <th width="6%">Time</th>
            <th>Sales Rep</th>
			<th>Total SOld Qty</th>
            </tr>
        <tr>
			<th colspan="11">Sales ID / Name : <?php echo $sales_id.' / '.$sl_name ?></th>
            
            
        </tr>
        </thead>
        <tbody>
        
       
        <?php
		$TTat +=0;$TTpd +=0;$TTbl =0; $TTAbl=0; $totQ =0;
		$age=0;
		
		while($Findcus = $sqlFindcus->fetch_array()){
			
			
			
			/*$sqlCusNm = mysql_query("SELECT cusName FROM `custtable` WHERE `CustomerID`= '$Findcus[1]'");
			$CusNm = mysql_fetch_array($sqlCusNm); */
				
			/*$sqlFindRcvRW= mysql_query("SELECT *
							FROM cusstatement JOIN invoice
							ON cusstatement.InvNo = invoice.InvNo WHERE ".$datewith."
							cusstatement.br_id = '$br_id' AND invoice.cusID = '$Findcus[1]'  GROUP BY cusstatement.InvNo");*/
			
			
		if($sales_id == 'View All'){										
	$sqlFindRcv= $xdata->query("SELECT cusstatement.InvNo,cusstatement.cusID,cusstatement.InvAmnt,SUM(cusstatement.Paid),cusstatement.cusTbID, invoice.purchNo
								 FROM cusstatement JOIN invoice
								ON cusstatement.invID =  invoice.ID   WHERE 
								cusstatement.br_id = '$br_id' AND cusstatement.cusID = '$Findcus[1]' AND invoice.Date between '$from_d' AND '$to_d' AND Balance != '0'
								GROUP BY cusstatement.InvNo");
		}else{
			$sqlFindRcv= $xdata->query("SELECT cusstatement.InvNo,cusstatement.cusID,cusstatement.InvAmnt,SUM(cusstatement.Paid),cusstatement.cusTbID, invoice.purchNo
								FROM cusstatement  JOIN invoice
								ON cusstatement.invID =  invoice.ID   WHERE 
								cusstatement.br_id = '$br_id' AND cusstatement.cusID= '$Findcus[1]'
								AND invoice.RepID = '$sales_id' AND invoice.Date between '$from_d' AND '$to_d' AND Balance != '0' GROUP BY cusstatement.InvNo");
		}
		//$FindRcvRW = mysql_num_rows($sqlFindRcv);
		
	//	$FindRcvRWw  = $FindRcvRW + 2 ;
		
	/*	echo "SELECT cusstatement.InvNo,cusstatement.cusID,cusstatement.InvAmnt,SUM(cusstatement.Paid) 
								FROM cusstatement  JOIN invoice
								ON cusstatement.invID =  invoice.ID   WHERE 
								cusstatement.br_id = '$br_id' AND cusstatement.cusID= '$Findcus[1]'
								AND invoice.RepID = '$sales_id' AND Date between '$from_d' AND '$to_d' GROUP BY cusstatement.InvNo";*/
		
	/*	echo'<tr>
		 
			<td style="" rowspan="'.$FindRcvRWw.'">'.$Findcus[1].' | '.$CusNm[0].'</td>
          	<td style="5" hidden>'.$SlmnRcv[0].'</td>
        	
        </tr>';	*/
		 
		
			$Tamount= 0;
			$Tat=0;	
			$Tpd=0;	
			$Tbl=0;
			$contNO=0;
			$inv_date="";
				$inv_time='';
				$TAbl=0;
				$qtyT = 0;
			
			while($SlmnRcv = $sqlFindRcv->fetch_array()){

				$invno=$SlmnRcv[0];
				$cusID=$SlmnRcv['cusTbID'];
				$invTotqry="SELECT InvAmnt,SUM(cusstatement.Paid) 
								 FROM cusstatement WHERE cusstatement.br_id = '$br_id' AND InvNo='$invno' ";
				
				$qryinvTot = $xdata->query($invTotqry);
				$invresult= $qryinvTot->fetch_array();
				$inv_amount=$invresult['InvAmnt'];
				$inv_paid=$invresult[1];
				$act_bl=$inv_amount-$inv_paid;
				
				$bal=$inv_amount-$SlmnRcv[3];
				
				if($bal != "0")
				{
					$contNO++;
					//echo $contNO . '</br>';
					if($contNO == '1')
					{
					echo '<tr> <td style="text-align:left; " >'.$Findcus[1].' | '.$Findcus[2].'</td>';
					}
					else
					{
						echo'<tr> <td> </td>';
					}
					
				
				
				$sqlFindage=$xdata->query("SELECT DATEDIFF (CAST(CURRENT_TIMESTAMP AS DATE),`invoice`.`Date`),`invoice`.`Date`,`Time`,RepID FROM invoice 
				WHERE InvNo='$invno' and br_id='$br_id'");
					
				$invage = $sqlFindage->fetch_array();
		 		$age=$invage[0];
				$inv_date=$invage[1];
				$inv_time=$invage[2];
				
				
				
				
			if($invage['RepID'] == 'Rtn Chq' ||  $invage['RepID'] == 'Rtn Chgs' ){
					
					$qry_rep=mysql_query("SELECT salesrep.Name FROM `repcustomize` JOIN salesrep 
					ON `repcustomize`.`rep_id` =salesrep.ID  WHERE `cus_id`='$cusID' ");
					$rst_rep=mysql_fetch_array($qry_rep);
					$repname=$rst_rep[0];
					
				}else{
				
				$repname=fnRepName($invage['RepID']);
				}
				
		 //if($Findcus[1] == $SlmnRcv[1]){
		 				$sql_invitem = $xdata->query("SELECT SUM(Quantity) FROM invitem WHERE InvNO = '$SlmnRcv[0]'");
				$qtySum = $sql_invitem->fetch_array();
		 echo'
		 
		  	<td style=" ">'.$SlmnRcv[0].' &nbsp; '.$SlmnRcv['purchNo'].'</td>
          	<td style=" text-align:right;">'.number_format($inv_amount,2).'</td>
          	<td style=" text-align:right;">'.number_format($SlmnRcv[3],2).'</td>
          	<td style=" text-align:right;">'.number_format($inv_amount-$SlmnRcv[3], 2).'</td>
			<td style=" text-align:right;">'.number_format($act_bl, 2).'</td>
			<td style=" text-align:right;">'.$age.'</td>
			<td style=" text-align:right;">'.$inv_date.'</td>
			<td style=" text-align:right;">'.$inv_time.'</td>
			<td style=" text-align:right;">'.$repname.'</td>
			<td style=" text-align:right;">'.$qtySum[0].'</td>
			
        </tr>';	
		$Tat += $inv_amount;
		$Tpd += $SlmnRcv[3];
		$Tbl += $inv_amount - $SlmnRcv[3]; 
		$TAbl += $act_bl; 
		$qtyT += $qtySum[0];
		  } // if
		  
		}
		
		if($contNO >0)
		{
		 echo'<tr>
			<th  colspan="11" style="background-color:#DFC36B; text-align:right;" height=20px >      </td>
          	
        </tr>' ;
		}
		
		if($contNO >1)
		{
		echo'<tr>
			<th  colspan="2" style="background-color:#; text-align:right;" > TOTAL</td>
          	<th style="background-color:#75E3AE; text-align:right;">'.number_format($Tat, 2).'</th>
			<th style="background-color:#75E3AE; text-align:right;">'.number_format($Tpd, 2).'</th>
			<th style="background-color:#75E3AE; text-align:right;">'.number_format($Tbl, 2).'</th>
			<th style="background-color:#75E3AE; text-align:right;">'.number_format($TAbl, 2).'</th>
			<th style=" text-align:right;"></th>
			<th style=" text-align:right;"></th>
			<th style=" text-align:right;"></th>
			<th style=" text-align:right;"></th>
			<th style=" text-align:right;">'.$qtyT.'</th>

        </tr>' ;
       
		}
		$TTat += $Tat;
		$TTpd += $Tpd;
		$TTbl += $Tbl;
		$TTAbl += $TAbl;
		$totQ += $qtyT;
		
	}
      echo'  </tbody>';
	echo'<tfoot>
		<tr bgcolor="#DFD">		
			<td></td>
			<td>Total</td>
            <td style="text-align:right;">'.number_format($TTat,2).'</td>
            <td style="text-align:right;">'.number_format($TTpd,2).'</td>
			 <td style="text-align:right;">'.number_format($TTbl,2).'</td>
			 <td style="text-align:right;">'.number_format($TTAbl,2).'</td>
            <td style="text-align:right;"></td>
			   <td style="text-align:right;"></td>
			      <td style="text-align:right;"></td>
			 <td style="text-align:right;"></td>
			 <td style="text-align:right;">'.$totQ.'</td>
		</tr>	
			
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

<div  id="mainLoadInvoSumry">


    <!-- ajax content load -->        
</div>


            

  

</div>
    <!-- content ends -->
    </div>
    
<?php include ($path.'footer.php'); ?>
<?php include ('daily_script.php'); ?> 
    
    <script>

$(document).ready(function() {
 $("#sales_prnt").click(function () {

$("#sales_prnt").attr("disabled", "disabled");
//$("#sales_prnt").removeAttr("disabled"); 
});
   
});
</script>

    
    <script>

	$('#salesReport').click(function(){
		var invID = $('').val();
		
		//alert('' +invID);
		window.open("print/RepWise_RcvDate_Print.php" , "myWindowName","width=595px, height=842px");	
						
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
