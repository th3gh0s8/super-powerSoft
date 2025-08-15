=<?php
$title = 'Item Sales Category Summary';
include ('includeFile.php');

//unset ($_SESSION['ReportPath']);
//include ('../side.php');


$from_d	= $_GET['from_d'] ;
$to_d = $_GET['to_d'];  
$report_sale = 'report_salesman123';
$cusANDrep = 'report_cusANDrep';
if($_GET['sales_id'] != 'undefined'){
	
	$sales_id = $_GET['sales_id'];
	$sales_name = $_GET['sl_name'];
}
else{$sales_id ='View All'; $sales_name='View All';}

//echo $itm_id.' 000';
$_SESSION['f_day']= $from_d;
$_SESSION['t_day']= $to_d;
$_SESSION['sl_id']= $sales_id;
$_SESSION['sl_name']= $sales_name;

$cus_id = $mysqli->real_escape_string($_GET['cus_id']);
$reportPrnt = 'itm_cat';
$reportslect='cate';
//$report_cusinv='cusinvdet';
//$ItemSearch = 'ItemSearch';
$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');



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

  
		<?php include ('daily_report_bar.php'); ?>
        
   </br>
   
    <div id="ajaxRespon" style="width:98%; ">                
  		 <div id="remove_TTb" class="findexcel" style="margin-left:34px;"> 
    		<table class="table table-striped table-bordered bootstrap-datatable table-hover responsive invoSumryTB"
             style="margin-top:30px; width: 100%; margin-left: 0; margin-right: 0; ";>
                <thead>
                    <tr>
                        <th>Category </th>
                        <th>Item No</th>
                        <th>Item Name</th>
                        <th>No of INV</th>
                        <th>No of CUS</th>
                        <th>Quantity</th>
                        <th>Ave.Sales Price</th>
                        <th>Free QTY</th>
                        <th>Actual Price</th>
                        <th>Total Value</th>
                        <th>Type</th>
                        <th>Brand</th>
                        <th>Supplier</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
        
      		  <?php
			
			$paidTT=0;
			$balTT=0;
			$invTT =0;
			
			$sql_cusDet = $mysqli->query("SELECT ID FROM custtable WHERE CustomerID = '$cus_id'");
			$cusDet = $sql_cusDet->fetch_array();
			$cusTb = $cusDet['ID'];
				// category option -----------------------
			  $sql_c_u_p = $mysqli->query("SELECT CatID FROM itemtable Group by CatID ORDER by `CatID` ASC ");
			  
			  $sum_qty=0;
					$sum_price=0;
					$sum_val=0;
				$sum_fre=0;
											
		  while($c_u_p = $sql_c_u_p->fetch_array())
		 {
			
			$cat=$c_u_p[0];
			if($cat == '')
			{
			$cat2 = 'None';
			}
			else
			{$cat2=$cat;}
			
			$cat=$mysqli->real_escape_string($cat);
			
			$cus_wh="";
				if ($cus_id == 'View All'){
					$cus_wh='';
					}
					else{
						$cus_wh="AND invoice.cusTbID='".$cusTb."' ";
						}
				
				
			$rep_wh='';
			$cusID_Qry = ($cus_id != 'View All')?"AND invoice.cusTbID = '$cusTb'":"";
				 if($sales_id != 'View All' )
				  {
					 $rep_wh="AND RepID ='$sales_id'";
						   $qry_inv="SELECT SUM(`Quantity`), SUM(`Quantity` / `invitem`.`DiscValue`),SUM(`invitem`.`DiscValue`)
						    ,`DiscPrcnt`,invitem.`Description`,`invitem`.`ItemNo`,`invitem`.`ItemID`, itemtable.Type, itemtable.XWord, itemtable.Vendor
						    FROM `invitem`  JOIN itemtable ON `invitem`.`ItemID` = itemtable.ID
							JOIN invoice ON `invitem`.`InvID` = invoice.ID 
							WHERE `invitem`.`br_id`='$br_id' AND RepID ='$sales_id'  
							AND `invitem`.`Date` BETWEEN '$from_d' AND '$to_d'
						    AND itemtable.`CatID`='$cat' AND `invitem`.`Sprice` != 0 $cusID_Qry GROUP BY itemtable.ID ";
							 $qry_due=$mysqli->query($qry_inv);
							 
				 
					  }
				  else
				  { 
				 		$rep_wh="";
					   $qry_inv="SELECT SUM(`Quantity`), SUM(`Quantity` / `invitem`.`DiscValue`),SUM(`invitem`.`DiscValue`)
					   ,`DiscPrcnt`,invitem.`Description`,`invitem`.`ItemNo`,`invitem`.`ItemID`, itemtable.Type, itemtable.XWord, itemtable.Vendor
						 FROM `invitem`  JOIN itemtable ON `invitem`.`ItemID` = itemtable.ID 
						 JOIN invoice ON `invitem`.`InvID` = invoice.ID 
						WHERE `invitem`.`br_id`='$br_id'  AND `invitem`.`Date` BETWEEN '$from_d' AND '$to_d'
						 AND itemtable.`CatID`='$cat' AND `invitem`.`Sprice` !=0 $cusID_Qry GROup BY itemtable.ID ";
					
							 $qry_due=$mysqli->query($qry_inv);
							 
							 
					
					}
					
					//echo $qry_inv;
					
					 $row_count=$qry_due->num_rows;
			 
			 if($row_count >0)
			 {
			 	echo'
					<tr>
						<th colspan="14" style="background-color:#ADE5F7;">'.$cat2.'</th>
						
						 </tr>';
			 }
					
					$paid=0;
					$m;
					
				//	echo $qry_inv;
					
					$tot_qty=0;
					$tot_price=0;
					$tot_val=0;
					$tot_fre=0;
					
			  while($due = $qry_due->fetch_array()){
				  
				  if($sales_id != 'View All' )
				  {
							  $qry_fre="SELECT SUM(`Quantity`) FROM `invitem` JOIN invoice ON `invitem`.`InvID` = invoice.ID 
						WHERE `invitem`.`br_id`='$br_id'  AND `invitem`.`Date` BETWEEN '$from_d' AND '$to_d'
						 AND `invitem`.`ItemID`='".$due['ItemID'] ."' AND `invitem`.`Sprice` =0  AND RepID ='$sales_id'  $cusID_Qry ";
				  }
				  else{
					  	  $qry_fre="SELECT SUM(`Quantity`) FROM `invitem` JOIN invoice ON `invitem`.`InvID` = invoice.ID 
						WHERE `invitem`.`br_id`='$br_id'  AND `invitem`.`Date` BETWEEN '$from_d' AND '$to_d'
						 AND `invitem`.`ItemID`='".$due['ItemID'] ."' AND `invitem`.`Sprice` =0  $cusID_Qry ";
					}
					
					 $qry_inv_fre=$mysqli->query($qry_fre);
				  $free_qty=$qry_inv_fre->fetch_array();
				  $tot_fre +=$free_qty[0];
				  $sum_fre += $free_qty[0];
				  
						$tot_qty=$tot_qty+$due[0];
						$val=$due[2] ;
						$tot_price= $due[0] == 0? 0: $due[2] / $due[0];
						$tot_val=$tot_val + $val;
						
						$sum_qty=$sum_qty+$due[0];
						$sum_val=$sum_val+ $due[2] ;
						
						$sql_vendorDet = $mysqli->query("SELECT CompanyName FROM vendor WHERE ID = '$due[Vendor]'");
						$vendorDet = $sql_vendorDet->fetch_array();
						
						$sql_br_stock = $mysqli->query("SELECT qty FROM br_stock WHERE itm_id = '".$due['ItemID']."' AND br_id = '$br_id'");
						$br_stockDet = $sql_br_stock->fetch_array();
						
						$qry_inv= $mysqli->query("SELECT `invitem`.ID FROM `invitem` JOIN invoice ON `invitem`.`InvID` =invoice.ID
                                                    WHERE `ItemID`='".$due['ItemID']."' 
                                                    AND `invitem`.`br_id`='$br_id'  AND `invitem`.`Date` BETWEEN '$from_d' AND '$to_d' $rep_wh $cusID_Qry
                                                    group by `invitem`.`InvID`");
						$noINV= $qry_inv->num_rows;
						
						$qry_cus= $mysqli->query("SELECT invitem.ID FROM `invitem` JOIN invoice ON `invitem`.`InvID` =invoice.ID 
                                                    WHERE `ItemID`='".$due['ItemID']."' AND `invitem`.`br_id`='$br_id' AND `invoice`.`br_id`='$br_id'
                                                    AND `invitem`.`Date` BETWEEN '$from_d' AND '$to_d' $rep_wh $cusID_Qry
                                                    group by `cusTbID`");
						$noCUS= $qry_cus->num_rows;
						
						if($due[0] < 0)
						{
						
							    echo'
								 <tr>
									<td style=" color:#F25C33;" > '.$cat2.' </td>
									<td style=" color:#F25C33; text-align: left;">'.$due['ItemNo'].'</td>
									<td style=" color:#F25C33; text-align: left;">'.$due['Description'].'</td>
									<td style=" color:#F25C33;">'.$noINV.'</td>
									<td style=" color:#F25C33;">'.$noCUS.'</td>
									 <td style="text-align:right; font; color:#F25C33;">'.number_format($due[0],2).'</td>
									<td style="text-align:right; color:#F25C33;" >'.number_format($due[2] / $due[0],2).'</td>
									<td style="text-align:right; font; color:#F25C33;">'.number_format($free_qty[0],2).'</td>
									<td style="text-align:right; color:#F25C33;" >'.number_format($due[2] / ($due[0]+$free_qty[0]),2).'</td>
									<td style="text-align:right; color:#F25C33;" >'.number_format($val,2).'</td>
									<td style=" color:#F25C33;">'.$due['Type'].'</td>
									<td style=" color:#F25C33;">'.$due['XWord'].'</td>
									<td style=" color:#F25C33;">'.$vendorDet['CompanyName'].'</td>
									<td style=" color:#F25C33;">'.$br_stockDet['qty'].'</td>
									</tr>';
						}
						else
						{
						    
						    $ddT = ($due[0]+$free_qty[0]) == 0? 0: $due[2] / ($due[0]+$free_qty[0]);
						    $ddm = $due[0] == 0? 0: $due[2] / $due[0];
							 echo'
								 <tr>
									<td>  '.$cat2.'</td>
									<td style="text-align: left;">  '.$due['ItemNo'].'</td>
									<td style="text-align: left;">'.$due['Description'].' </td>
									<td>'.$noINV.'</td>
									<td>'.$noCUS.'</td>
									 <td style="text-align:right;">'.number_format($due[0],2).'</td>
									<td style="text-align:right;" >'.number_format($ddm,2).'</td>
									<td style="text-align:right;">'.number_format($free_qty[0],2).'</td>
									<td style="text-align:right; " >'.number_format($ddT,2).'</td>
									 <td style="text-align:right;" >'.number_format($val,2).'</td>
									<td>'.$due['Type'].'</td>
									<td>'.$due['XWord'].'</td>
									<td>'.$vendorDet['CompanyName'].'</td>
									<td>'.$br_stockDet['qty'].'</td>
									</tr>';
							}
								  
							
						}
						
						
						
						 if($row_count >=1)
			 {
			
				echo'
					<tr >
					<td colspan="5" style="text-align:right; background:#D1C1BC; ">TOTAL</td>
			<td style="text-align:right; background:#D1C1BC">'.number_format($tot_qty,2).'</td>
            <td style="text-align:right; background:#D1C1BC"> </td>
			<td style="text-align:right; background:#D1C1BC">'.number_format($tot_fre,2).'</td>
            <td style="text-align:right; background:#D1C1BC"> </td>
			<td style="text-align:right; background:#D1C1BC">'.number_format($tot_val,2).'</td>
			<td style="text-align:right; background:#D1C1BC" colspan="4"> </td>
						 </tr>'; 
						 
						 echo '<tr> <td colspan="12"> </td> </tr>';
			 }
						
		 }
						
						/*$rcount=$qry_due->num_rows;
						
						  if($rcount == '0')
						   {
							   
							   echo'
									<tr class="success" style="border:none;">
										  <td colspan="5"> No Record .............. </td>
										 
									  </tr>';
							   }*/
						
								/*$invTTt = $invTT + $due[3];
								$paidTTt =$paidTT + $due[5];
								$balTTt =$balTT + $due[4];	*/
						
						 
		 echo'  </tbody>';
		 
		echo'<tfoot>
			<tr bgcolor="#D1C1BC">		
			<td colspan="5" style="text-align:right; background:#D1C1BC; ">Grand TOTAL</td>
			<td style="text-align:right; background:#D1C1BC">'.number_format($sum_qty,2).'</td>
            <td style="text-align:right; background:#D1C1BC"></td>
			<td style="text-align:right; background:#D1C1BC">'.number_format($sum_fre,2).'</td>
            <td style="text-align:right; background:#D1C1BC"></td>
			<td style="text-align:right; background:#D1C1BC">'.number_format($sum_val,2).'</td>
		<td colspan="4"> </td>
			</tr>
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
<?php include ('daily_script.php'); ?>   
  
    <script>
	//var vl = $('#TYPE').val();
//alert(vl);
	$('#itm_cat').click(function(){
			var vlu = $('#cus_id').val();
			var f_date = $('#from_d').val();
			var t_date = $('#to_d').val();
		//alert(vlu);
		//alert('' +invID);
		window.open("print/new_itm_cat_print.php?ITEM="+vlu+"&FDATE="+f_date+"&TDATE="+f_date+"" , "myWindowName","width=595px, height=842px");	
						
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
