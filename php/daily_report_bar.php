<style>
#barMain{
	//margin-top:0%;
	margin-bottom::200px;
	//width:100%;	
}
#detailBar{
	margin-top:10px;
	margin-bottom: 10px;
	
	width:120%;	
	margin-left:2%;
	
}

#but {
	color:rgba(102,102,102,1);
	margin-right::20px;
	margin-top:0.4%;
	float:left;
	background-color:#CCC;	
	
}
#but a {
	color:rgba(102,102,102,1);
	margin-right::20px;
	float:left;	
	
}
#dd{
	color:#F00;	
}
.btn  {
	font-size:11px;
	height:28px;	
}

.stock3{
	font-size:9px;
	width:10px;
	}
	.print_type
	{
		position: relative;
    display: block;
    overflow: hidden;
    padding: 0 0 0 8px;
    height: 25px;
    border: 1px solid #aaa;
    border-radius: 5px;
    background-color: #fff;
    background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(20%, #ffffff), color-stop(50%, #f6f6f6), color-stop(52%, #eeeeee), color-stop(100%, #f4f4f4));
    background: -webkit-linear-gradient(top, #ffffff 20%, #f6f6f6 50%, #eeeeee 52%, #f4f4f4 100%);
		}
	
	.table,remove_TTb
	{
	background-color:#FFF;
	width:80%;
	margin-left:10%; 
    margin-right:10%;
	}
	.datatable{
		width:80%;
	margin-left:10%; 
    margin-right:10%;
		}
		
		body{
		text-align:center;
		}
	  
	  table thead{
		  background-color:#313161;
		  color:#FFF;
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
	text-align:left;
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

.ui-autocomplete-input{
	
	}
#branchID{
 display:inline;	
}

#white_bg{
    background: white;
    padding: 22px;
	width:100%; 
	border-radius:40px;	
}
	
</style>


</head>
  <body class="nav-sm">
    <div class="container body">
      <div class="main_container">
      
     
<?php 
include($path.'side.php');
include($path.'mainBar.php');
?>
 <div class="right_col" role="main">
        
            <h2 style="text-align:center;"><i class="glyphicon glyphicon-list-alt"></i> <?php echo $title; ?></h2>

<div class="box-content2" style="width:99%; padding-left:1.5%; padding-right::0.5%;">
<div class="row" style="background-color:#D5D3E8;" >

<div class="form-group" style="margin-bottom:; margin-left:;width:100%;">
		<form action="search_report.php" method="POST"  >
        		         <?php 
		 

		 $getRights = mysql_query("SELECT optionPath FROM `optiontb` WHERE `opertionName` = 'All Branch Report' ORDER BY `ID` DESC");
		 $MultipleJournalBranch = mysql_fetch_array($getRights);
		 
		 if($MultipleJournalBranch[0] == 'YES'){ 
		$get_optn_allBranch = mysql_query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID 
										WHERE `user_id` ='$user_id' AND `page_title` ='control_AllBRREPORT' AND `user_rights`.`br_id`='$br_id'" ); 
		 $rowUs = mysql_num_rows($get_optn_allBranch);
		 
			if($rowUs > 0 || $user_type == 'Admin'){
				 $br_id= ($_GET['myBR'] == '') ? $br_id:$_GET['myBR'];
				$_SESSION['myBR']=$br_id;
		 //echo $br_id.'- brvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv';
		echo'<div class="col-md-12" >
        <label> Select Branch  </label> 
        <select id="branchID" name="branchID" style="width:30%" >';
		
			$getBr = mysql_query("SELECT ID , name FROM `com_brnches`");
			while($branchID = mysql_fetch_array($getBr)){
					if($branchID[0] == $br_id){	
					echo'<option value="'.$branchID[0].'" selected  >'.$branchID[1].'</option>';	
					}else{
						echo'<option value="'.$branchID[0].'" >'.$branchID[1].'</option>';	
					}
			}
		
		echo'</select>
       </div>'; 
			}else{
				echo '<input type="hidden" name=branchID"" id="branchID" value="'.$br_id.'" >' ;
				unset($_SESSION['myBR']);	
			}
	   
	   
		}else{
		echo '<input type="hidden" name=branchID"" id="branchID" value="'.$br_id.'" >' ;
		unset($_SESSION['myBR']);	
		}
	   ?>
        		
        
   			 <div class="barMain2" style="margin-left:2%;margin-top:03px; width:100%">      
            <div id="bar">
            <?php
			
		$get_indiUser = mysql_query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID 
										WHERE `user_id` ='$user_id' AND `page_title` ='control_user_report' AND `user_rights`.`br_id`='$br_id'");
		 $rowIndiUser = mysql_num_rows($get_indiUser);
			
		 $br_id2 = $_SESSION['br_id'];
			
			if($user_type == 'Admin' || $user_type == 'SuperAdmin' )
			{
					$chqLK=mysql_query("SELECT report_pages.ID,report_pages.linkID, report_pages.reportPath, report_pages.reportTitle
FROM report_pages
WHERE report_pages.barID =  '1' AND `hides` ='No' AND report_pages.userRights = 'Y'
ORDER BY  `report_pages`.`linkID` ASC ");

				 /*$chqLK= mysql_query("SELECT `report_rights`.`br_id`, `user_id`, `report_id`, `stutes`, `view_stutes`,
					 `slct_com`,
					 `duf_val`,report_pages.linkID,report_pages.reportPath,report_pages.reportTitle FROM `report_rights` 
					 JOIN report_pages 
					 ON report_rights.report_id=report_pages.masterID 
					 WHERE `report_rights`.br_id= '$br_id' AND report_pages.barID='1' AND report_pages.userRights = 'Y'
					 ORDER BY `report_pages`.`linkID` ASC ");*/
				
				
				
				}
			else
			{
			
             $chqLK= mysql_query("SELECT report_pages.ID,`report_rights`.`br_id`, `user_id`, `report_id`, `stutes`, `view_stutes`,
					 `slct_com`,
					 `duf_val`,report_pages.linkID,report_pages.reportPath,report_pages.reportTitle FROM `report_rights` 
					 JOIN report_pages 
					 ON report_rights.report_id=report_pages.ID 
					 WHERE `report_rights`.br_id= '$br_id2' AND report_pages.`hides` ='No' AND `user_id`= '$user_id' AND report_pages.barID='1' 
					 ORDER BY `report_pages`.`linkID` ASC ");
			}
					 
					while($linkresult=mysql_fetch_array($chqLK))
					{
						
				 echo'<div id="but"><a class="ajax-link link'.$linkresult['ID'].'" id="link'.$linkresult['ID'].'" href="#"
				  data-value="'.$linkresult['reportPath'].'.php" >	 
                    &nbsp; '.$linkresult['reportTitle'].' &nbsp;  </a>	|</div>';
					
					}
					
					?>
            		
            		
            </div>
            </div>
            </br></br>
            
            <div class="col-sm-12" style="padding-buttom:10px;">
            <div id="detailBar2" class="" >
            
             
             <div class="col-sm-3">
			
			   <?php
		
		if($report_month== 'report_month' ){
								
								echo '  <label style="text-align:left; width:100%;"> Months </label>
         <select name="com_mon" id="com_mon" data-placeholder="Select one..." 
							class="com_mon " style="display:initial; padding-buttom:0px; width:50%; border-radius:5px;" tabindex="2">';
			
			
			 echo  '          
               <option value="1" >January</option>
               <option value="2" >February</option>
               <option value="3" >March</option>
               <option value="4" >April</option>
               <option value="5" >May</option>
               <option value="6" >June</option>
               <option value="7" >July</option>
               <option value="8" >August</option>
               <option value="9" >September</option>
               <option value="10" >October</option>
               <option value="11" >November</option>
               <option value="12" >December</option>
    
               
           <select>';
		  echo '<input size="16" type="hidden" name="to_d" id="to_d" value="'. $to_d .'" 
                        
                         class="form-control">';
						 
		echo '<input size="16" type="hidden" name="from_d" id="from_d" value="'. $from_d .'" 
                         
                         class="form-control" >';
								
							}else{
             
				echo '<div class="floatSales2 col-sm-6" style="padding-top:3px">
                        <div  align="left" class=" input-append date from_d" 		
                        data-date="" data-date-format="yyyy-mm-dd" 
                        data-link-field="bil_date2" data-link-format="yyyy-mm-dd">
                        <p> From<input size="16" type="text" name="from_d" id="from_d" value="'.$from_d.'" 
                        required readonly 
                         class="form-control" ></p>
                        <span class="add-on" style=""><i class="icon-th"></i></span>
                        </div>
                    </div> 
                    <div class="floatSales2 col-sm-6" style="padding-top:3px; margin-left:0px;">
                        <div  align="left" class=" input-append date to_d"		
                        data-date="" data-date-format="yyyy-mm-dd" 
                        data-link-field="bil_date2" data-link-format="yyyy-mm-dd">
                        <p>To<input size="16" type="text" name="to_d" id="to_d" value="'.$to_d.'" 
                        required readonly 
                         class="form-control"></p>
                        <span class="add-on" style=""><i class="icon-th"></i></span>
                        </div>
                    </div>';
							}
                    
					  if($year_rhts == 'YES'){
						echo '&nbsp;  Year &nbsp; <input type="NUMBER" name="txt_year" id="txt_year"
						 class="txt_year" style="width:90px;" value="'.$year.'" min="2014"  /> &nbsp; &nbsp; '; 
					  }
					
					?>
                    
                    </div> 
                    
                    
                    
                    
                    
                      <!--------------------------------------------------item categery -------------------------------->
                  
                     <?php  /*
							if($report_cat == 'report_cat'){
								echo' <div class="form-group floatSales2 col-sm-7" style="margin-top: 18px; text-align: left;"  >';
								
								
								echo '<label> Category </label> &nbsp;';
								
								 echo '<select name="cat_id" id="cat_id" data-placeholder="Choose a Category..." 
							class="chosen-select" style=" padding-buttom:10px; width:450px;" tabindex="2" multiple>';
								
								$qry_cat=mysql_query("SELECT `CatID` FROM `itemtable` group by `CatID`");
								while($rst_cat=mysql_fetch_array($qry_cat)){
									
									if($cat_id == $rst_cat[0]){
									echo'<option  value="'.$rst_cat[0] .'" selected>'.$rst_cat[0] .'</option>';
									}else{
									
									echo'<option  value="'.$rst_cat[0] .'">'.$rst_cat[0] .'</option>';
									}
								}
								
								echo'</select> </div>';
							}
								*/
						?>

			<div class="col-md-2">
						<label>Select a Item Category</label>
						<select name="com_cat" id="com_cat" data-placeholder="Select one..." class="com_cat" style="padding-bottom:0px; width:100%; border-radius:5px; height:30px;" tabindex="2">
							<option value="View All" class="add">View All</option>
							<?php
							$cat_qry = $mysqli->query("SELECT `CatID` FROM itemtable JOIN `br_stock` ON `br_stock`.`itm_id` = itemtable.`ID` WHERE `br_stock`.br_id='$br_id' AND itemtable.Active = 0 GROUP BY `CatID`");
							while ($cat_exc = $cat_qry->fetch_array()) {
								$cat2 = $cat_exc[0];
								if ($cat2 == '') {
									$cat2 = 'None';
								}
								if ($cat_exc[0] == $cat) {
									echo '<option value="' . $cat2 . '" class="cat" selected>' . $cat2 . '</option>';
								} else {
									echo '<option value="' . $cat2 . '" class="cat">' . $cat2 . '</option>';
								}
								
							}
							?>
				</select>
			</div>

						
						
						  <?php 
                    // ********************************return goods report bar************************************** //

                    if($report_sale == 'report_salesman2' ){

                    	echo '<div id="sales_rep" class="col-sm-2" >';

                    	if($user_type == 'Admin'  || $rowIndiUser == FALSE){

							echo'<label > Sales Rep </label></br>
                           		 <select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." class="chosen-select" tabindex="2" style="width:70%;">

                           		 	<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								
								if($cus_rep_qry['RepID']==$sales_id){
										echo'<option value="'.$cus_rep_qry['RepID'].'" selected>'.$cus_rep_qry['Name'].'</option>';
								}else{
									echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
								}
							}
							echo'</select>';
						 }
							else{
									
							$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 						`salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' AND salesrep.br_id = '$br_id' ");
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$slnewrep = $cus_rep_qry['RepID'] == $sales_id?'selected': '';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['RepID'].'" '.$slnewrep.'>'.$cus_rep_qry['Name'].'</option>
								';
								
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != '$cus_rep_qry[reptb]'");
									while($rep = $sql_rep->fetch_assoc()){
									    $slnewrep = $rep['RepID'] == $sales_id?'selected': '';
										echo '<option value="'.$rep['RepID'].'" '.$slnewrep.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
						}
						echo '</div>';

						//////////////////////////////customer select//////////////////////////

						echo '<div id="cus_divRep" class="col-sm-2">  
								<label> Customer Name </label>
                           		 <select name="cus_id" id="cus_id" data-placeholder="Choose a Name..." class="chosen-select" tabindex="2" style="width:100%;">';
                       
									echo'<option value="View All">View All</option>';
							
						$sql_cus_id1 = mysql_query("SELECT `CustomerID`,`cusName`,`custtable`.`ID` FROM `custtable` JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID` Where invoice.`br_id` ='$br_id' group by 						 invoice.`CusID` ");
									
						while ($cus_id_qry1 = mysql_fetch_array($sql_cus_id1)){

							if ($cus_id_qry1['CustomerID']==$cus_id){

								echo'<option value="'.$cus_id_qry1['CustomerID'].'" cusTb="'.$cus_id_qry1['ID'].'" selected>'.$cus_id_qry1['cusName'].'</option>';
							}else{
                        		echo'<option value="'.$cus_id_qry1['CustomerID'].' cusTb="'.$cus_id_qry1['ID'].'"">'.$cus_id_qry1['CustomerID'].' - '.$cus_id_qry1['cusName'].'</option>';
							}
						}
							echo'</select> </div>';
								
						echo' </div>';

						///////////////////type select////////////////////////////////
						echo '<div id="cus_divRep" class="col-sm-2">  
							  <label>Type</label>
							  <select name="type" id="type" data-placeholder="Choose a type..."  tabindex="2" style="width:100%;"  class="chosen-select" >';
						
							  		echo'<option value="View All">View All</option>
							  		<option value="Exchange">Exchange</option>
							  		<option value="Issue">Issue</option>
							  		<option value="Damaged">Damaged</option>
							  		<option value="Expired">Expired</option>
							  </select>

						</div>';

                    }

                    // *******************************end return goods report bar************************************//
                    ?>
						
                    
                    <?php
					if($repName == 'repname'){
						echo '
						<div class="col-sm-2"> 
								<label  style="float:left"> Sales Rep </label></br>';
						    echo'<select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:100%;">';
                       
							//echo'<option  value="'.$sales_id .'">'.$sl_name .'</option>';
				
						
							
							echo'<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT ID ,`RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
									if($cus_rep_qry['ID']==$sales_id)
									{
										echo'<option value="'.$cus_rep_qry['ID'].'" selected>'.$cus_rep_qry['Name'].'</option>';
										}
										else
										{
									
                        			echo'<option value="'.$cus_rep_qry['ID'].'">'.$cus_rep_qry['Name'].'</option>';
										}
									}
									echo'</select>
									</div>
						';
					}
                    	if($report_sale2 == 'report_salesman2'){
					   	echo '
								<div id="sales_rep" class="col-sm-3"> 
								<label  style="float:left"> Sales Rep </label></br>';
                          
						  
						  $sql_count_issuedItem = mysql_query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID 
										WHERE `user_id` ='$user_id' AND `page_title` ='control_RepIssuedItem' AND `user_rights`.`br_id`='$br_id'");
		                    $rgt_count_issuedItem = mysql_num_rows($sql_count_issuedItem);
						  
						  
						  if($user_type == 'Admin' || $rgt_count_issuedItem == TRUE || $rowIndiUser == FALSE){
						    echo'<select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:70%;">';
                       
							//echo'<option  value="'.$sales_id .'">'.$sl_name .'</option>';
				
						
							
							echo'<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT ID ,`RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
									if($cus_rep_qry['ID']==$sales_id)
									{
										echo'<option value="'.$cus_rep_qry['ID'].'" selected>'.$cus_rep_qry['Name'].'</option>';
										}
										else
										{
									
                        			echo'<option value="'.$cus_rep_qry['ID'].'">'.$cus_rep_qry['Name'].'</option>';
										}
									}
									echo'</select>';
							
                    
                   		 }else{
							 
							 
							
                          //echo '<div  class="col-sm-12" style="text-align:left;"> '.$uNAME[0].'</div>';
                          
                          $sql_rep_id = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
							 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
							if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								
								$chkRpSelected = $sales_id == $cus_rep_qry['reptb']? 'selected':'';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['reptb'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>
								';
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != $cus_rep_qry[reptb]");
									while($rep = $sql_rep->fetch_assoc()){
										$chkRpSelected = $sales_id == $rep['ID']? 'selected':'';
										echo '<option value="'.$rep['ID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
							}else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<input type="HIDDEN" value="'.$rep_Aid['ID'].'" class="sales_id" name="sales_id" 
								id="sales_id" />';
							}
							 
						 }
						 echo'</div>';
					   }
									  ?>
                    
                    
                       <!-- sales rep inv ------------------------------------------------------------------------------------------------->
                    
                    	 <?php
							if($report_catTarget == 'report_catTarget' || $report_order == 'report_order' ){
								echo' <div class="form-group floatSales2 col-sm-4" style="margin-top: 18px; text-align: left;"  >';
								
								
								echo '<label> Sales Rep </label> &nbsp;';
							
							if($user_type == 'Admin'  || $rowIndiUser == FALSE){
								
                           echo '<select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" style=" padding-buttom:10px; width:450px;" tabindex="2" >';
                       
							echo'<option  value="'.$sales_id .'">'.$sl_name .'</option>';
				
						
							
							echo'<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' AND `sales_target`='YES'");
							
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
                        			echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
									}
								
								echo'</select>  ';
								
							} else {
								
								$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
							 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
							if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$chkRpSelected = $sales_id == $cus_rep_qry['RepID']? 'selected':'';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['RepID'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>
								';
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != $cus_rep_qry[reptb]");
									while($rep = $sql_rep->fetch_assoc()){
										$chkRpSelected = $sales_id == $rep['RepID']? 'selected':'';
										echo '<option value="'.$rep['RepID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
							}else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<input type="HIDDEN" value="'.$rep_Aid['RepID'].'" class="sales_id" name="sales_id" 
								id="sales_id" />';
							}
								
							}
									
                                     
									echo '  <input type="hidden" id="radiochk" >
									  <input type="hidden" id="nametxt2" class="nametxt2"  value="'.$name2.'">';
								
								echo '</div> ';
						
						     }///else{echo'<option>'.$sales_id.'</option>';}
						?>
                        
              <!-- sales rep inv rep------------------------------------------------------------------------------------------------->
                    
                    
                    
   <!-- customer invoice details --------------------------------------------------------------------------------------->
                    
                    
                    
                    <?php 
					
					
					if ($report_cusinv == 'cusinvdet' ){
					?> 
                         <div class="form-group floatSales2 col-sm-6" style="margin-top: 18px;" >
                         
                         <label> Customer name </label>
                    
             <select name="cus_id" id="cus_id" data-placeholder="Choose a Name..." class="chosen-select" style="width:200px;" 
                            tabindex="2">
                            <?php
						
						
						echo'<option value="View All">View All</option>';
						if($cus_id== "View All"){
							echo'<option value="View All" selected="selected">View All</option>';
						}
						
						echo'<option value="Cash">Cash</option>';
					
					$sql_cus_id = mysql_query("SELECT `CustomerID`,`cusName`,`custtable`.`ID` FROM `custtable` JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID` Where invoice.`br_id` ='$br_id' group by invoice.`CusID` ");
									
						while ($cus_id_qry = mysql_fetch_array($sql_cus_id)){
							if($cus_id_qry[0]== $cus_id){
								echo'<option value="'.$cus_id_qry[0].'" cusTb="'.$cus_id_qry['ID'].'" selected>'.$cus_id_qry[1].'</option>';
								}
                        			echo'<option value="'.$cus_id_qry[0].'" cusTb="'.$cus_id_qry['ID'].'">'.$cus_id_qry[0].' - '.$cus_id_qry[1].'</option>';
									}
								//}
									?>
                        
                          	</select>
                            
                            &nbsp; &nbsp;
                            
                            <?php
							
							if($reportslect =='cate')
							{
							
							?>
                            
                             <label> Item Category </label>
                    
                     <select name="cat_id" id="cat_id" data-placeholder="Choose a Category..." class="chosen-select cat_id" 
                     style="width:200px;" tabindex="2" multiple>
                            <?php
                        $cat_ids = explode(',', $cat_id);
						if(in_array("View All", $cat_ids) || $cat_id == 'null'){
							echo'<option value="View All" selected="selected">View All</option>';
						}else{
						    echo'<option value="View All">View All</option>';
						}  
					
					    $sql_itm_cat2 = mysql_query("SELECT distinct(`CatID`) FROM `itemtable`");
					    
						while ($cus_cat_qry = mysql_fetch_array($sql_itm_cat2)){
						

                            if (in_array($cus_cat_qry[0], $cat_ids)) {
								echo'<option value="'.$cus_cat_qry['0'].'" selected="selected">'.$cus_cat_qry['0'].'</option>';
							}
							else
							{
                        			echo'<option value="'.$cus_cat_qry['0'].'">'.$cus_cat_qry['0'].'</option>';
							}
									
						}
								//}
									?>
                        
                          	</select>
                            
                            <?php } ?>
                         
                     
						 </div>
                          
                          <?php }  ?>
                    
      <!-- customer invoice details --------------------------------------------------------------------------------------->
                    
                    
                    
                    
     <!-- sales rep inv ------------------------------------------------------------------------------------------------->
                    
                    	 <?php
							if($report_salerepinv == 'report_salesrepinv' ){
							
								echo' <div class="form-group floatSales2 col-sm-7" style="margin-top: 18px;"  >';
								
								if($user_type == 'Admin'  || $rowIndiUser == FALSE){
								echo '<label> Sales Rep </label>
                            <select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" style=" padding-buttom:10px;" tabindex="2">';
                       
							echo'<option  value="'.$sales_id .'">'.$sl_name .'</option>';
				
						
							
							echo'<option value="View All">View All</option>';
							
							
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
                        			echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
									}
								
								echo'</select>  ';
								
								
								}else{
									$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
							if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$chkRpSelected = $sales_id == $cus_rep_qry['RepID']? 'selected':'';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['RepID'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>
								';
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != $cus_rep_qry[reptb]");
									while($rep = $sql_rep->fetch_assoc()){
										$chkRpSelected = $sales_id == $rep['RepID']? 'selected':'';
										echo '<option value="'.$rep['RepID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
							}else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<input type="HIDDEN" value="'.$rep_Aid['RepID'].'" class="sales_id" name="sales_id" 
								id="sales_id" />';
							}
									
									
								}
								
								
                                      echo'<input type="radio" name="inlineRadio[]"  id="inlineRadio4" value="inlineRadio4" 
                                      data-type="inlineRadio4" class="stock2"  checked="checked" hidden> ';
									
                                     
									echo '  <input type="hidden" id="radiochk" >
									  <input type="hidden" id="nametxt2" class="nametxt2"  value="'.$name2.'">
									  <label> Invoice no </label>
									  <input type="text" id="TYPE" name="TYPE"  onClick="this.select();" 
                          			class="nametxt" autocomplete="off" value="'.$name2.'" style="width:37%; " />
											';
											
								echo '</div> ';
								
						
						     }///else{echo'<option>'.$sales_id.'</option>';}
						?>
                        
                    <!-- sales rep inv rep------------------------------------------------------------------------------------------------->                          
                    
                    
                    
                    
                    
   					
                    
                    <!-- sales rep item rep ------------------------------------------------------------------------------------------------->
                    
                    	 <?php
						 ///echo 'dsdsfsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd';
							if($report_salerepitm == 'report_salesrepitem' ){
								echo' <div class="form-group floatSales2  col-sm-7 " style="margin-top: 2%;"  >';
								if($user_type == 'Admin'  || $rowIndiUser == FALSE){
								//echo 'dfsddddddddddddddddddddddddd';
								echo '<label> Sales Rep </label>
                            <select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" style="width:35%; padding-buttom:10px;" tabindex="2">';
                       
							echo'<option  value="'.$sales_id .'">'.$sl_name .'</option>';
				
						
							
							echo'<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
                        			echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
									}
								
								echo'</select>  ';
								
								}else{
									$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
							if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$chkRpSelected = $sales_id == $cus_rep_qry['RepID']? 'selected':'';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['RepID'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>
								';
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != $cus_rep_qry[reptb]");
									while($rep = $sql_rep->fetch_assoc()){
										$chkRpSelected = $sales_id == $rep['RepID']? 'selected':'';
										echo '<option value="'.$rep['RepID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
							}else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<input type="HIDDEN" value="'.$rep_Aid['RepID'].'" class="sales_id" name="sales_id" 
								id="sales_id" />';
							}
									
								}
								
							
								
								
                                      echo'<input type="radio" name="inlineRadio[]"  id="inlineRadio5" value="inlineRadio5" 
                                      data-type="inlineRadio5" class="stock2"  checked="checked" hidden> ';
									
                                     
									echo '  <input type="hidden" id="radiochk" >
									  <input type="hidden" id="nametxt2" class="nametxt2"  value="'.$name2.'">
									  <label> Item name </label>
									  <input type="text" id="TYPE" name="TYPE"  onClick="this.select();" 
                          			class="nametxt" autocomplete="off" value="'.$name.'" style="width:37%; " />
											';
											
											
								
								
								
								echo ' </div>';
						
						     }///else{echo'<option>'.$sales_id.'</option>';}
							 
						?>
						
                    
                        
    <!-- sales rep item rep------------------------------------------------------------------------------------------------->                          
                    
                     <?php
					 if($report_sale == 'report_salesman' ){
							echo' <div class="form-group floatSales2  col-sm-3 " style="">'; 
						
						 if($report_sale_print == 'report_salesman_print'){
						 ?>
								
		<!-- print option ----------------------------------------------------------------------------------------->
								
                           <!--     <div id="cus_print" class="col-sm-3">
                                
                                 <label > View Type </label>
                         
     					  <select name="view_type" id="view_type" data-placeholder="Choose a Format..." 
                          class="chosen-select view_type" 
                           tabindex="2" style="width:100%;" >
                           
                           <?php
						//   ;
						  // echo ' <option value="'.$view_type.'"  selected> '.$view_type.' </option>';
						   ?>
                  		  <option value="View All" <?php //echo $viwSelct ?> > View All </option>
                           <option value="Show" <?php //echo $shwSelct ?> > Show </option>
                           <option value="Hide" <?php //echo $hidSelct ?> > Hide </option>
                           
                           
                          </select>
                        	  </div>-->
                                
                                <div id="cus_print" class="col-sm-5">
                                 <label > Search type </label>
                         
     					  <select name="print_type" id="print_type" data-placeholder="Choose a Format..." 
                          class="print_type chosen-select" 
                           tabindex="2" style="width:100%;">
						   <option value="Collected By">Collected By</option>
						   <option value="loggedUser">Logged User</option>
                            <?php
					
             
					$sql_print_cus = mysql_query("SELECT   `opertionName`, `optionPath`, `order` FROM `optiontb`
					 WHERE  br_id = '$br_id' AND `report_name`='sales_report' ORDER BY `optiontb`.`order` ASC ");
					 
					 $type_count=mysql_num_rows($sql_print_cus);
					 
					 if($type_count == '0' )
					 {
						  echo'<option value="sal_rep" selected > Sales Rep Wise </option>'; 
					}
									
						while ($print_cus = mysql_fetch_array($sql_print_cus)){
							  if ($print_cus[1]==$print_type)
							  {
								  echo'<option value="'.$print_cus[1].'" selected >'.$print_cus[0].'</option>';
								  }
							  else
							  {
                        			echo'<option value="'.$print_cus[1].'">'.$print_cus[0].'</option>';
							  }
						}
									
									
									echo '</select> </div>';
	//<!-- print option ----------------------------------------------------------------------------------------->
						 }
						 
								?>
                                
                           
                        
                          	
                            
				
							
							<?php	
							
                     	 	
							 
								echo '
								<div id="sales_rep" class="col-sm-7" style=""> ';
							
							if($user_type == 'Admin'  || $rowIndiUser == FALSE){
								echo'<label > Sales Rep </label></br>
                            <select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:70%;">';
                       
							//echo'<option  value="'.$sales_id .'">'.$sl_name .'</option>';
				
							echo'<option value="View All">View All</option>';
								
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
								
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
									if($cus_rep_qry['RepID']==$sales_id)
									{
										echo'<option value="'.$cus_rep_qry['RepID'].'" selected>'.$cus_rep_qry['Name'].'</option>';
										}
										else
										{
									
                        			echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
										}
									}
									echo'</select>';
							}else{
									$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
						   if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$chkRpSelected = $sales_id == $cus_rep_qry['RepID'] ? 'selected' : '';
								echo '<label> Sales Rep </label></br>';
								$assigned_reptbs = $cus_rep_qry['assigned_reptbs'] == '' ? '""' : ltrim(trim($cus_rep_qry['assigned_reptbs']), ',');
								echo '<select class="sales_id" name="sales_id" id="sales_id">';
								echo '<option value="'.$cus_rep_qry['RepID'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>';
								$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE RepID IN($assigned_reptbs) AND ID !=.$cus_rep_qry[reptb]");
								
								while($rep = $sql_rep->fetch_assoc()){
									$chkRpSelected = $sales_id == $rep['RepID'] ? 'selected' : '';
									echo '<option value="'.$rep['RepID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
								}
								
								echo '</select>';
							}
						}
						else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<input type="HIDDEN" value="'.$rep_Aid['RepID'].'" class="sales_id" name="sales_id" 
								id="sales_id" />';
							}
							}
				
				
									echo '</div>';
									
									
									// user name
									if($report_recipt == 'report_recipt'){
											echo '<div id="user_div" class="col-sm-7">  <label> User Name </label>
                            <select name="user_id" id="user_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:100%;">';
                       
							//echo'<option  value="'.$cus_id .'">'.$sl_name .'</option>';
				
							echo'<option value="View All">View All</option>';
							
						$sql_user_id = mysql_query("SELECT `ID` FROM `sys_users` WHERE `br_id`='$br_id' AND active = 'YES'");
									
								while ($user_id_qry = mysql_fetch_array($sql_user_id)){
									if ($user_id_qry['ID']==$user_ids)
									{
										echo'<option value="'.$user_id_qry['ID'].'" selected>'.
										uIDQry($user_id_qry['ID']).'</option>';
										}
										else
										{
                        			echo'<option value="'.$user_id_qry['ID'].'">'.
									uIDQry($user_id_qry['ID']).'</option>';
										}
									}
									echo'</select> </div>';
								
								echo' </div>';
									}
									
									
									
									
						echo '<div id="cus_div" class="col-sm-4">  <label> Customer Name 2 </label>
                            <select name="cus_id" id="cus_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:100%;">';
                       
							//echo'<option  value="'.$cus_id .'">'.$sl_name .'</option>';
				            
				            echo'<option value="View All">View All</option>';
									
				            if($user_type == 'Admin'  || $rowIndiUser == FALSE){
				                
							
							    $sql_cus_id = mysql_query("SELECT `CustomerID`,`cusName`,`custtable`.`ID` FROM `custtable` JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID` Where invoice.`br_id` ='$br_id' group by invoice.`cusTbID` ");
									
								while ($cus_id_qry = mysql_fetch_array($sql_cus_id)){
									if ($cus_id_qry['CustomerID']==$cus_id)
									{
										echo'<option value="'.$cus_id_qry['CustomerID'].'" cusTb="'.$cus_id_qry['ID'].'" selected>'.$cus_id_qry['cusName'].'</option>';
										}
										else
										{
                        			echo'<option value="'.$cus_id_qry['CustomerID'].'" cusTb="'.$cus_id_qry['ID'].'">'.$cus_id_qry['CustomerID'].' - '.$cus_id_qry['cusName'].'</option>';
										}
								}
				            }else{
				                $sql_rep_id = mysql_query("SELECT salesrep.`ID`  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					            $repDdet = mysql_fetch_array($sql_rep_id);
				                
				                $sql_cus_id = mysql_query("SELECT `CustomerID`,`cusName`,`custtable`.`ID` FROM `custtable` JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID` 
				                                                Where invoice.`br_id` ='$br_id' AND invoice.repTbID = '$repDdet[ID]' GROUP BY invoice.`cusTbID` ");
									
								while ($cus_id_qry = mysql_fetch_array($sql_cus_id)){
									if ($cus_id_qry['CustomerID']==$cus_id)
									{
										echo'<option value="'.$cus_id_qry['CustomerID'].'" cusTb="'.$cus_id_qry['ID'].'" selected>'.$cus_id_qry['cusName'].'</option>';
										}
										else
										{
                        			echo'<option value="'.$cus_id_qry['CustomerID'].'" cusTb="'.$cus_id_qry['ID'].'">'.$cus_id_qry['CustomerID'].' - '.$cus_id_qry['cusName'].'</option>';
										}
								}
				            }
							
									echo'</select> </div>';
								
								echo' </div>';
								
								
						
							?>
                            
                           
                            <?php	
							}
							?>
							
                            
                            
							   
                    <?php 
					if ($ItemSearch == 'ItemSearch'){
					
                        echo'<div class="form-group floatSales2  col-sm-4 " style="">
                            <label>
                             	Item Name
                            </label>';

                          echo' <input type="hidden" id="Itemresult" name="Itemresult"  onClick="this.select();" 
                          	  autocomplete="off" value="'.$ItemId.'"  />
							 <input type="text" id="ItemSearch" name="ItemSearch" style="width:90%"  onClick="this.select();" 
                          	 class="ItemSearch" autocomplete="off" value="'.$ItemNm.'" autofocus="autofocus" />
							
                          					</div>';
					}
					
					if ($locationFilter == 'true'){
					    $sql_locationRights = mysql_query("SELECT ID  FROM `pages` WHERE `path` = 'Good_Transfer/Good_Transfer_Location' AND userRights = 'Y'");
					    if(mysql_num_rows($sql_locationRights) > 0){
					        echo'<div class="form-group floatSales2  col-sm-3 " style="">
                                <label>
                                 	Location
                                </label>';
    
                              echo'<select class="locationfilter"><option value="ViewAll">View All</option>';
							  $optSel1 = $locationVal == 'hideLoc'? "selected":"";
							  echo '
							 		<option '.$optSel1.' value="hideLoc">Hide Location Entries</option> 
							  ';
                                $sql_locationList = mysql_query("SELECT location, name FROM itm_location WHERE br_id = '$br_id'");
                                while($locationList = mysql_fetch_array($sql_locationList)){
                                    $optSel = $locationVal == $locationList['location']? "selected":"";
                                    echo '<option value="'.$locationList['location'].'" '.$optSel.'>'.$locationList['name'].'</option>';
                                }
                              echo '</select>
                              </div>';
					    }
                        
					}
                         ?> 
                         
                         
                       <?php 
					   if($report_filter == 'ItemCategory' ) {
                            echo' <div class="form-group floatSales2  col-sm-4 " style="margin-top: 2%;">
                                <p  style="margin-bottom:1%"> ';
                                
                                        if($RADIO =='inlineRadio0' ){
                                          echo'<input type="radio" name="inlineRadio"  id="inlineRadio0" value="inlineRadio0" 
                                          data-type="inlineRadio0" value="inlineRadio0" class="stock3"  checked="checked"> View All &nbsp;';
    									 }
    									 else{
                                          echo'<input type="radio" name="inlineRadio"  id="inlineRadio0" value="inlineRadio0" 
                                          data-type="inlineRadio0" value="inlineRadio0" class="stock3"   checked="checked" > View All &nbsp;';
    									 }
    									 
                                 	       if($RADIO =='inlineRadio1' ){
                                          echo'<input type="radio" name="inlineRadio"  id="inlineRadio1" value="inlineRadio1" 
                                          data-type="inlineRadio1" value="inlineRadio1" class="stock3"  checked="checked"> Item Name &nbsp;';
    									 }
    									 else{
                                          echo'<input type="radio" name="inlineRadio"  id="inlineRadio1" value="inlineRadio1" 
                                          data-type="inlineRadio1" value="inlineRadio1" class="stock3" > Item Name &nbsp;';
    									 }
                                         
    									 if($RADIO =='inlineRadio3' ){                                     
                                          echo'<input type="radio" name="inlineRadio" id="inlineRadio3" data-type="inlineRadio3" 
                                          class="stock3" value="inlineRadio3" checked="checked"> Category';
    									  }
    									 else{                                     
                                          echo'<input type="radio" name="inlineRadio" id="inlineRadio3" data-type="inlineRadio3" 
                                          class="stock3" value="inlineRadio3" > Category';
    									  } 
    								  echo' 
    								  <input type="hidden" id="RADIO" name="RADIO" value="'.$RADIO.'"  onClick="this.select();" 
                              				 class="stock" autocomplete="off"  />
    								  	 <input type="hidden" id="stockseacher" name="TYPE" value="'.$Wise.'"  onClick="this.select();" 
                              				 class="stock" autocomplete="off"  />
    									  <input type="text" id="TYPE" name="TYPE" value="'.$WiseNm.'"  onClick="this.select();" 
                              				 class="stock" autocomplete="off" style="width:250px;" />
                             				 </p>
    										</div> ';
    					}
									  ?>
                            
                            
                             <?php 
					   if($report_pur == 'report_pur' ) {
                    echo' <div class="form-group floatSales2  col-sm-7 " style="margin-top: 2%;">
                            <p  style="margin-bottom:1%"> ';
                             	       if($ID =='inlineRadio1' ){
                                      echo'<input type="radio" name="inlineRadio[]"  id="inlineRadio1" value="inlineRadio1" 
                                      data-type="inlineRadio1" class="stock"  checked="checked"> Item Name &nbsp;';
									 }else
									 {
										 echo'<input type="radio" name="inlineRadio[]"  id="inlineRadio1" value="inlineRadio1" 
                                      data-type="inlineRadio1" class="stock" checked="checked" > Item Name &nbsp;'; 
									 }
									 
									 
                                     if($ID =='inlineRadio2' ){                                    
                                      echo'<input type="radio" name="inlineRadio[]" id="inlineRadio2" data-type="inlineRadio2" 
                                      class="stock" value="inlineRadio2" checked="checked"> Vendor &nbsp;';
									  }
									  else
									  {
									echo'<input type="radio" name="inlineRadio[]" id="inlineRadio2" data-type="inlineRadio2" 
                                      class="stock" value="inlineRadio2" > Vendor &nbsp;';
										  }
                                     
                                     
									 if($ID =='inlineRadio3' ){                                     
                                      echo'<input type="radio" name="inlineRadio[]" id="inlineRadio3" data-type="inlineRadio3" 
                                      class="stock" value="inlineRadio3" checked="checked"> Category';
									  }
									  else{
									echo'<input type="radio" name="inlineRadio[]" id="inlineRadio3" data-type="inlineRadio3" 
                                      class="stock" value="inlineRadio3"> Category';
										  }
									 
									  echo' <input type="hidden" id="radiochk" >
									  <input type="hidden" id="nametxt2" class="nametxt2" value="'.$name2.'">
									    <input type="hidden" id="sales_id"  value="">
									  		<input type="text" id="TYPE" name="TYPE"  onClick="this.select();" 
                          				 	class="nametxt" autocomplete="off" value="'.$name.'" />
                         				 </p>
										</div> ';
										
										
										
										
					   }
					   
					   
									  ?>
                                    
                                    
                                    <?php  
                                  
                                   
						 if($cusANDrep == 'report_cusANDrep' ){
							echo' <div class="form-group floatSales2  col-sm-4 " style="">'; 
							
						if($user_type == 'Admin'  || $rowIndiUser == FALSE){
							echo '
								<div id="sales_rep" class="col-sm-4" style=""> 
								<label > Sales Rep </label></br>
                            <select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:70%;">';
                
							echo'<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
									if($cus_rep_qry['RepID']==$sales_id)
									{
										echo'<option value="'.$cus_rep_qry['RepID'].'" selected>'.$cus_rep_qry['Name'].'</option>';
										}
										else
										{
                        					echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
			 							}
										
										
									}
									echo'</select>';
									
						 }else{
									$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
							if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$chkRpSelected = $sales_id == $cus_rep_qry['RepID']? 'selected':'';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['RepID'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>
								';
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != $cus_rep_qry[reptb]");
									while($rep = $sql_rep->fetch_assoc()){
										$chkRpSelected = $sales_id == $rep['RepID']? 'selected':'';
										echo '<option value="'.$rep['RepID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
							}else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<input type="HIDDEN" value="'.$rep_Aid['RepID'].'" class="sales_id" name="sales_id" 
								id="sales_id" />';
							}
						 }
							echo'</div>';

						echo '<div id="cus_divRep" class="col-sm-4">  <label> Customer Name</label>
                            <select name="cus_id" id="cus_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:100%;">';
                       
							//echo'<option  value="'.$cus_id .'">'.$sl_name .'</option>';
				
							echo'<option value="View All">View All</option>';
							
							$sql_cus_id1 = mysql_query("SELECT `CustomerID`,`cusName`,`custtable`.`ID` FROM `custtable` JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID` Where invoice.`br_id` ='$br_id' group by invoice.`CusID` ");
									
								while ($cus_id_qry1 = mysql_fetch_array($sql_cus_id1)){
									if ($cus_id_qry1['CustomerID']==$cus_id)
									{
										echo'<option value="'.$cus_id_qry1['CustomerID'].'" cusTb="'.$cus_id_qry1['ID'].'" selected>'.$cus_id_qry1['cusName'].'</option>';
										}
										else
										{
                        			echo'<option value="'.$cus_id_qry1['CustomerID'].'" cusTb="'.$cus_id_qry1['ID'].'">'.$cus_id_qry1['cusName'].'</option>';
										}
									}
									echo'</select> </div>';
								
								echo' </div>';

						}
									
								
								
						
											
							?>
                            
                            
						<?php
						    if($cusANDrep == 'report_cusANDrepNItm' ){
							echo' <div class="form-group floatSales2  col-sm-4 " style="">'; 
							
						if($user_type == 'Admin'  || $rowIndiUser == FALSE){
							echo '
								<div id="sales_rep" class="col-sm-4" style=""> 
								<label > Sales Rep </label></br>
                            <select name="sales_id" id="sales_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:70%;">';
                
							echo'<option value="View All">View All</option>';
							
							$sql_rep_id = mysql_query("SELECT `RepID`,`Name`  FROM `salesrep` WHERE `br_id`= '$br_id' ");
									
								while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
									if($cus_rep_qry['RepID']==$sales_id)
									{
										echo'<option value="'.$cus_rep_qry['RepID'].'" selected>'.$cus_rep_qry['Name'].'</option>';
										}
										else
										{
                        					echo'<option value="'.$cus_rep_qry['RepID'].'">'.$cus_rep_qry['Name'].'</option>';
			 							}
										
										
									}
									echo'</select>';
									
						 }else{
									$sql_rep_id = mysql_query("SELECT `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID='$user_id' ");
					       $num_RepID = mysql_num_rows($sql_rep_id);
						   		 
							if($num_RepID == TRUE){ 
							while ($cus_rep_qry = mysql_fetch_array($sql_rep_id)){
								$chkRpSelected = $sales_id == $cus_rep_qry['RepID']? 'selected':'';
								echo'<label > Sales Rep </label></br>';
								echo'<select class="sales_id" name="sales_id" id="sales_id" />
										<option value="'.$cus_rep_qry['RepID'].'" '.$chkRpSelected.'>'.$cus_rep_qry['Name'].'</option>
								';
									$assigned_reptbs = $cus_rep_qry['assigned_reptbs']==''?'""': $cus_rep_qry['assigned_reptbs'];
									$sql_rep = $mysqli->query("SELECT * FROM salesrep WHERE ID IN($assigned_reptbs) AND ID != $cus_rep_qry[reptb]");
									while($rep = $sql_rep->fetch_assoc()){
										$chkRpSelected = $sales_id == $rep['RepID']? 'selected':'';
										echo '<option value="'.$rep['RepID'].'" '.$chkRpSelected.'>'.$rep['Name'].'</option>';
									}
										echo '
										</select>';
							}
							}else{
							  $sql_rep_Aid = mysql_query("SELECT `salesrep`.ID, `salesrep`.`RepID`,`Name`, assigned_reptbs, salesrep.ID as reptb  FROM `salesrep` JOIN sys_users ON
								 `salesrep`.`RepID` = sys_users.`repID`  WHERE  `sys_users`.ID = '$user_id'");
								$rep_Aid = mysql_fetch_array($sql_rep_Aid);
								echo 'Press Load Button';
								echo'<select hidden class="sales_id" name="sales_id" id="sales_id" />
								        <option value="'.$rep_Aid['RepID'].'" selected>'.$rep_Aid['Name'].'</option>
								     </select>
								    ';
							}
						 }
							echo'</div>';

						echo '<div id="cus_divRep" class="col-sm-6">  <label> Customer Name </label>
                            <select name="cus_id" id="cus_id" data-placeholder="Choose a Name..." 
							class="chosen-select" tabindex="2" style="width:100%;">';
                       
							//echo'<option  value="'.$cus_id .'">'.$sl_name .'</option>';
				
							echo'<option value="View All">View All</option>';
							
							$sql_cus_id1 = mysql_query("SELECT `CustomerID`,`cusName`,`custtable`.`ID` FROM `custtable` JOIN invoice ON `custtable`.`ID`=invoice.`cusTbID` Where invoice.`br_id` ='$br_id' group by invoice.`CusID` ");
									
								while ($cus_id_qry1 = mysql_fetch_array($sql_cus_id1)){
									if ($cus_id_qry1['CustomerID']==$cus_id)
									{
										echo'<option value="'.$cus_id_qry1['CustomerID'].'" cusTb="'.$cus_id_qry1['ID'].'" selected>'.$cus_id_qry1['cusName'].'</option>';
										}
										else
										{
                        			echo'<option value="'.$cus_id_qry1['CustomerID'].'" cusTb="'.$cus_id_qry1['ID'].'">'.$cus_id_qry1['CustomerID'].' - '.$cus_id_qry1['cusName'].'</option>';
										}
									}
									echo'</select> </div>';
								
								echo' </div>';
								
								   echo'<input type="radio" name="inlineRadio[]"  id="inlineRadio5" value="inlineRadio5" 
                                      data-type="inlineRadio5" class="stock2"  checked="checked" hidden> ';
                                      
									echo '  <input type="hidden" id="radiochk" >
									  <input type="hidden" id="nametxt2" class="nametxt2"  value="'.$name2.'">
									  <label> Item name </label>
									  <input type="text" id="TYPE" name="TYPE"  onClick="this.select();" 
                          			class="nametxt" autocomplete="off" value="'.$name.'" style="width:15%; " />
											';

						}
						?>
<?php
					if($report_cus_area == 'report_cus_area' ){
						echo'<div id="cus_print" class="col-sm-2">';
						
						echo '<label>Customer Area</label>
				<select  id="cus_area" data-placeholder="Choose a Name..." class="chosen-select" style="width:150px;"   tabindex="2"> ';


											echo '<option value="View All" >View All</option>';

											$sql_cus_area = mysql_query("SELECT area FROM `custtable` group by area ORDER BY area ASC  ");

											while ($cus_areadet = mysql_fetch_array($sql_cus_area)) {
												$cust_area = $cus_areadet[0];
												if ($cus_areadet[0] == '') {
													$cust_area = 'None';
												}

												$sel = '';
												if ($cus_area2 == $cus_areadet[0]) {
													$sel = 'selected';
												}

												echo '<option value="' . $cus_areadet[0] . '" ' . $sel . '>' . $cust_area . '</option>';
											}
											//}


											echo	'</select>';
									
									
						
						
						
						echo '</div> ';
				
					 }
					 
					?>
					<?php
					 if($Report_stock_cat == 'Stock' ) {
						echo' <div class="form-group floatSales2  col-sm-4 " style="margin-top: 2%;">
								<p  style="margin-bottom:1%"> ';
											if($RADIO =='inlineRadio1' ){
										  echo'<input type="radio" name="inlineRadio"  id="inlineRadio1" value="inlineRadio1" 
										  data-type="inlineRadio1" value="inlineRadio1" class="stock3"  checked="checked"> Item Name &nbsp;';
										 }
										 else{
										  echo'<input type="radio" name="inlineRadio"  id="inlineRadio1" value="inlineRadio1" 
										  data-type="inlineRadio1" value="inlineRadio1" class="stock3"   checked="checked" > Item Name &nbsp;';
										 }
										
										
										 
										 if($RADIO =='inlineRadio3' ){                                     
										  echo'<input type="radio" name="inlineRadio" id="inlineRadio3" data-type="inlineRadio3" 
										  class="stock3" value="inlineRadio3" checked="checked"> Category';
										  }
										 else{                                     
										  echo'<input type="radio" name="inlineRadio" id="inlineRadio3" data-type="inlineRadio3" 
										  class="stock3" value="inlineRadio3" > Category';
										  } 
									  echo' 
									  <input type="hidden" id="RADIO" name="RADIO" value="'.$RADIO.'"  onClick="this.select();" 
											   class="stock" autocomplete="off"  />
										   <input type="hidden" id="stockseacher" name="TYPE" value="'.$Wise.'"  onClick="this.select();" 
											   class="stock" autocomplete="off"  />
										  <input type="text" id="TYPE" name="TYPE" value="'.$WiseNm.'"  onClick="this.select();" 
											   class="stock" autocomplete="off" style="width:250px;" />
											  </p>
											</div> ';
						   }
					?>
                         
                    
                    <div class="form-group floatSales2 col-sm-2" style="margin-top:21px; ">
                        <button  type="button" id="Subpath" class="btn btn-default ajax-link justBtn"  
                         data-value="<?php echo $_GET['va'] ?>" style="margin-top:-4px; ">
                         
                        <i class="glyphicon glyphicon-refresh"></i> <?php //echo $reportPrnt ?>LOAD</button>  
                 		<input type="hidden" value="<?php echo $reportPrnt ?>" id="ordInvHiddn" />
						
                        <button type="button" id="<?php echo $reportPrnt ?>" class="btn btn-default" 
                        style="margin-top:-4px; margin-left:10px">
                        <i class="glyphicon glyphicon-print"></i> <?php //echo $reportPrnt ?>PRINT</button> 
                        
                          <button type="button" class="btn btn-round btn-default Exlbut">
                          <i class="glyphicon glyphicon-download-alt"></i></button>
                        
                                       		
					</div>
                                
             </div>
                 
                 </br> 
                 </div>
    </form>

   
	<script>
$(document).ready(function() {
    $('#com_cat').change(function() {
        var selectedCategory = $(this).val().trim();
        var rows = $('.invoSumryTB tr:gt(0)');

        rows.each(function() {
            var rowCategory = $(this).find('td:eq(0)').text().trim();

            if (selectedCategory === 'View All' || selectedCategory === rowCategory) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

</script>     
            
          
 
    
     
