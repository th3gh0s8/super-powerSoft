<?php
$title = 'Top Sales Item Report';
include ('includeFile.php');
//unset ($_SESSION['ReportPath']);
//include ('../side.php');


$from_d	= $_GET['from_d'] ;
$to_d = $_GET['to_d'];  
//$sales_id =$_GET['sales_id'];
//echo date('h:i:s');

$_SESSION['f_day']= $from_d;
$_SESSION['t_day']= $to_d;
//$_SESSION['sl_id']= $sales_id;
if($_GET['ItemNm'] != 'undefined' ){
$ItemNm =$_GET['ItemNm']; 
$ItemId = $_GET['ItemId']; 
}else{$ItemNm ='View All'; 
}
//$ItemSearch = 'ItemSearch';
$reportPrnt = 'itm_cost';
//$ItemSearch = 'ItemSearch';
$from_dd = date_format(date_create($from_d), 'Y-m-d');
$to_dd = date_format(date_create($to_d), 'Y-m-d');

$tod=date('Y-m-d');
$new_date= date('Y-m-d',strtotime($tod. "-30 days"));
//echo $new_date; 

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

  
		<?php include ('stock_main_bar.php'); ?>
        
   </br>


   
    <div id="ajaxRespon" class=" col-sm-12"  style="width:100%; margin-top:-30px;">    
    
		 <div class="box-content" align="center" >
         <h5> <?php echo $title; ?> </h5>
          <h6> <?php echo 'From '. $from_d.' To '.$to_d ; ?> </h6>
		    <ul class="ajax-loaders" style="display:none">
		        <li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>                                   
		    </ul>                
		</div>             
  		 <div id="remove_TTb"> 
         
    		<table class="table table-striped table-bordered bootstrap-datatable table-hover datatable responsive invoSumryTB"  style="width:70%; margin-left:15%; margin-right:15%;">
                <thead>
                  <tr>
                  	<th  style="text-align:right;" colspan="7">Search Here </th>
                    <th colspan="2" > 
                    <input type="text" name="txt_search" id="txt_search" class="txt_search" style="color:#000;"
                     placeholder="Search by Name or Item" />
                    </th>
                   
                    </tr>
                
                <tr>
                <th> </th>
                  	<th width="10%">Item </th>
                    <th width="35%">Description</th>
                     <th width="20%">Category</th>
                     <th width="20%">Extra Category</th>
                     <th width="10%">Rate</th>

                    <th width="10%"> Sales Qty </th>
                    <th width="10%"> Value </th>

                    <th width="10%">Stock Qty</th>

                    </tr>
                </thead>
                <tbody>
        
       
      		  <?php
			
			
		$qry_sale=mysql_query("SELECT SUM(`Quantity`) AS a, SUM(invitem.Sprice * `Quantity` * diff_inv) avgSprice, `itm_code`,`itm_id`,`qty`,itm_id, `Date`, invitem.diff_inv, invitem.Sprice FROM `invitem` RIGHT OUTER JOIN `br_stock` ON `invitem`.`itemID` = br_stock.itm_id AND `invitem`.`br_id` = br_stock.br_id WHERE `br_stock`.`br_id`='$br_id' 
		AND `invitem`.Date BETWEEN '$from_d' AND '$to_d' GROUP BY itm_id ORDER BY `a` DESC");



				$n=0;		$totalAmnt = 0;
			  while($rst_sale=mysql_fetch_array($qry_sale)){
				  $n++;
				  $itm_code=$rst_sale['itm_code'];
				  $itm_id=$rst_sale['itm_id'];
				  $bg='';
				   $stutas='price';
				  if($rst_sale[0] == 0){
					  $bg='color:red;';
					 $stutas='cost';
					  }
				  
				  $qry_itmTB=mysql_query("SELECT Description,MinSale,CatID,Sprice, XWord FROM `itemtable`   WHERE ID='".$itm_id."'");
				  $itmTB=mysql_fetch_array($qry_itmTB);
					 	
						echo'<tr  class="TRsearch" data-value="'.$stutas.'|'.$itm_code.'|'.$itmTB['Description'].'|'.$itmTB['CatID'].' "  >
						<td style="text-align:right; " >'.$n.'</td>
						<td style="text-align:left; " >'.$itm_code.'</td>
						<td style="text-align:left;  ">'.$itmTB['Description'].' </td>
						<td style="text-align:left;  ">'.$itmTB['CatID'].'</td>
						<td style="text-align:left;  ">'.$itmTB['XWord'].'</td>
						<td style="text-align:right;  ">'.number_format($itmTB['Sprice'], 2).'</td>

						<td style="text-align:right; '.$bg.'  ">'.number_format($rst_sale[0] ,2).'</td>
						
						<td style="text-align:right; '.$bg.'  ">'.number_format(($rst_sale['avgSprice']) ,2).'</td>


						<td  style="text-align:right; '.$bg.' ">'.number_format($rst_sale['qty'] ,2).'</td>	
						</tr>';
					    
					    $totalAmnt += $rst_sale['avgSprice'];
					
						}
						
						//SELECT * FROM Table1 WHERE * NOT IN (SELECT * FROM Table2)
			$qry_sale2=mysql_query("SELECT `itm_code`,`itm_id`,`qty`, invitem.diff_inv FROM `br_stock` WHERE `br_stock`.`br_id`='$br_id' AND
			 itm_id NOT IN (SELECT `itemID` FROM `invitem` WHERE `invitem`.Date BETWEEN '$from_d' AND '$to_d' AND `br_id`='$br_id') ");
			
		
						
			  while($rst_sale2=mysql_fetch_array($qry_sale2)){
				  $n++;
				  //echo $n;
				  $itm_code=$rst_sale2['itm_code'];
				  $itm_id=$rst_sale2['itm_id'];
				  $bg='';
				   $stutas='price';
				  if($rst_sale[0] == 0){
					  $bg='color:red;';
					 $stutas='cost';
					  }
				  
				  $qry_itmTB2=mysql_query("SELECT Description,MinSale,CatID,Sprice, XWord FROM `itemtable`   WHERE ID='".$itm_id."'");
				  $itmTB2=mysql_fetch_array($qry_itmTB2);
					 	$tt = $itmTB2['Sprice']*0;
						echo'<tr  class="TRsearch" data-value="'.$stutas.'|'.$itm_code.'|'.$itmTB2['Description'].'|'.$itmTB2['CatID'].' "  >
						<td style="text-align:right; " >'.$n.'</td>
						<td style="text-align:left; " >'.$itm_code.'</td>
						<td style="text-align:left;  ">'.$itmTB2['Description'].'</td>
						<td style="text-align:left;  ">'.$itmTB2['CatID'].'</td>
						<td style="text-align:left;  ">'.$itmTB2['XWord'].'</td>
						<td style="text-align:right;  ">'.number_format($itmTB2['Sprice'], 2).'</td>
						<td style="text-align:right; '.$bg.'  ">'.number_format(0 ,2).'</td>
						
						<td style="text-align:right; '.$bg.'  ">'.number_format($tt,2).'</td>

						<td  style="text-align:right; '.$bg.' ">'.number_format($rst_sale2['qty'] ,2).'</td>	
						</tr>';
					
					
						}
							
						
						
						
						
			
						 
		 echo'  </tbody>';
		
	?> 
	    <tfoot>
	        <tr>
	            <td colspan="7">Total</td>
	            <td style="text-align: right;"><?php echo number_format($totalAmnt, 2); ?></td>
	            <td></td>
	        </tr>
	    </tfoot>
			</table>

			



    	</div>
    </div>
    </div>
    </div>
    </div>



<!--/span-->
    


 

<div  id="mainLoadInvoSumry">


    <!-- ajax content load -->        
</div>


            

  

</div>
    <!-- content ends -->
    </div>
    
     <?php include ($path.'footer.php'); ?>
    <?php include ('stock_script.php'); ?>  
    
    <script>
	//var vl = $('#TYPE').val();
//alert(vl);
	$('#itm_cost').click(function(){
			var vlu = $('#TYPE').val();
			var f_date = $('#from_d').val();
			var t_date = $('#to_d').val();
		//alert(vlu);
		//alert('' +invID);
		window.open("print/stock_top_sales_print.php?ITEM="+vlu+"&FDATE="+f_date+"&TDATE="+t_date+"" , "myWindowName","width=595px, height=842px");	
						
	});
	
	$(document).on('keyup', '#txt_search', function(){
	var srchKey = $(this).val();
	srchKey = srchKey.toUpperCase();
	
	$('.removTR').remove();
	existCount = 0;
	rowCount = $('#invSumrRowCount').val();
	$('.TRsearch').show();
	
	
	$('.TRsearch').each(function() {
       
	   	var thisDataVal =  $(this).attr('data-value');
		thisDataVal = thisDataVal.toUpperCase();
		
		if(thisDataVal.indexOf(srchKey) != -1){
			existCount++;
		}else{
			$(this).hide();
		}
		
    });
	
	
	if( existCount == 0 ){
		$('.invSummryTB').append('<tr class="removTR"> <td colspan="6">No records </td> </tr>');
	}
	
	$('#lblRowCont').text('Showing '+ existCount +' of '+ $('#invSumrRowCount').val() +' entries')

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
