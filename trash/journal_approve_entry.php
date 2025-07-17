<?php
$title = 'Approve Journal Entry';
$pageRights = 'journal_approve_entry';
include('path.php');

include('includeFile.php');

//echo 'br id '.$br_id;
if(isset($_POST['deletebt'])){
	$jornlID = $_POST['jornlID'];
	$ent_key = $_POST['ent_key'];
	$v_no = $_POST['vou_no'];
	//echo 'v no '. $v_no;
	//die;
	$date = date('Y-m-d');
	$time = date('h:i:s');
	
	
	
$v_no = ($v_no == '' )? '0':$v_no;	
if($v_no != '0'){
	
	$sql_upje = $mysqli->query("UPDATE `jentry` SET `jentry_delete`='1' WHERE `VNo` ='$v_no' and `br_id`='$br_id'");

	 
	
	if($sql_upje){
		
		$sql_up = $mysqli->query("INSERT INTO `deletdetil`( `br_id`, `fomName`, `tablName`, `tblID`, `userID`, `recordDate`,
	 `recordTime`, `Cloud`) VALUES ('$br_id','Jounal Entry','jentry','$v_no','$user_id','$date','$time','New')");
	 
		$_SESSION['succsess_msg'] = 'Journal Entry Delete Process Done ! ';		
		redirect('journal_Entry.php');
		die();					
	}else{
		$_SESSION['error_msg'] = 'Error in journal entry Delete Process !';	
		redirect('journal_Entry.php');					
		die();
	}
	
}

	
}


$_SESSION['ReportPath'] = 'Report/';
$newFolder='new/';


$page_rights='No';

if ($user_type == "Admin" )
	{
		$page_rights='Yes';
	}
else
{

	$urights_qry=$mysqli->query("SELECT  `user_rights`.`br_id`, `user_rights`.`user_id`, `user_rights`.`page_id` FROM
	 `user_rights` Join pages ON pages.ID= `user_rights`.`page_id` WHERE 
	 `user_rights`.`br_id`='$br_id' AND `user_id`='$user_id' AND page_title ='control_EntryEdit'");


	while ($urights = $urights_qry->fetch_array()){
		//echo 'fdfd '. $urights[2];
		$page_rights='Yes';
	
}

}
 
$sql_getPrintPage = $mysqli->query("SELECT `PrintNm` FROM `all_print_type` WHERE `Form` = 'Journal' AND `br_id`='$br_id'");
if($sql_getPrintPage->num_rows == TRUE){
    $getPrintPage = $sql_getPrintPage->fetch_array();
    $JournalPrintPage = $getPrintPage['PrintNm'];
}else{
    $JournalPrintPage = 'fr_jprint';
}

?>

<input type="text" name="rgt_edit" class="boxb rgt_edit" id="rgt_edit" value="<?php echo $page_rights; ?>" hidden
    border="0px" />


<style>
.jstBlnkTB {
    margin-top: 100px;
}

.custmTB {
    overflow-y: scroll;
}

.custmTB tr:nth-child(even):hover td,
tbody tr.odd:hover td {
    background: #DFD;
    cursor: pointer;
    color: #009999
}

.custmCretTB tr:nth-child(odd) td {
    background-color: #fbfbfb
}

/*odd*/
.custmCretTB tr:nth-child(even) td {
    background-color: #e8ecee
}

/* even*/

.custmCretTB tr:nth-child(even):hover td,
.custmCretTB tr:nth-child(odd):hover td {
    background: #DFD;
    cursor: pointer;
    color: #009999
}

/* hovering */


#ajax_img_lod,
#ajax_img_lod_cusDetil {
    display: none;

}

.ajaxContent {}

/***************   STYLE FOR AUTOCOMPLETE DROPDOWN ***********/
.ui-autocomplete {
    max-height: 150px;
    min-width: 170px;
    background: #CCC;
    overflow-y: auto;
    overflow-x: hidden;
}


.ui-autocomplete::-webkit-scrollbar {
    width: 12px;
}

.ui-autocomplete::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.ui-autocomplete::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
}

/*************** END OF  STYLE FOR AUTOCOMPLETE DROPDOWN ***********/


input[type='text'],
input[type='number'],
input[type='email'],
input[type='tel'],
select {
    padding: 2px 2px 2px 5px;
    height: 25px;
}

.reqireLbl {
    color: #F00
}

FIELDSET {
    margin: 8px;
    border: 1px solid silver;
    padding: 8px;
    border-radius: 4px;
}

LEGEND {
    padding: 2px;
}

.joinDate {}

.errConfrmHaed {
    //height: 20px;
    margin: 9px;
    border: 1px solid #aaaaaa;
    background: #cccccc;
    border-radius: 4px;
    padding: 4px;
    color: #fff
        /*tomato*/
    ;
    font-size: 14px;
    font-weight: bold;
}

.blockUIClosBtn {
    padding: 2px 10px 2px 10px;
    margin: 14px 0 10px 0
}

.gndlbl {
    font-size: 10px
}

input[type="email"] {
    text-transform: lowercase;
}

#cardDetil {
    display: none
}

.boxx {
    width: 100%;
}

.boxd {
    width: 100%;
}

.boxh {
    width: 100px;
}

.boxb {
    width: 100%;
    border: none;
}

.btns {
    color: #825D19;
    background-color: #825D19;
    /* height:30px; */
    padding-left: 10px;
    padding-right: 10px;

}

.lod_img {
    margin-top: 0px;
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


            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $title; ?></h3>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h2><i class="fa fa-align-left"></i> Journal<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <div class="box-content">


                                        <div class="box-content lod_img" align="center">
                                            <ul class="ajax-loaders" style="display:none">
                                                <li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>
                                            </ul>
                                        </div>


                                        <!-- Start Modal of warning -->
                                        <div class="modal " id="myModal2" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">×</button>
                                                        <h3 style="margin:0">
                                                            <div id="ermsgHead"> </div>
                                                        </h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="chqMsgContent"> </div>
                                                    </div>
                                                    <div class="modal-footer myModlModal"> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end of Modal of warning -->


                                        <form action="#" method="Post" name="jentry_form" id="jentry_form"
                                            class="jentry_form" autocomplete="off">

                                            <?php 
		$qry_vno = $mysqli->query("SELECT MAX(VNo) FROM `jentry` where br_id= '$br_id'  AND VNo != '0' ORDER BY VNo DESC LIMIT 01  ");
		//echo "SELECT MAX(`VNo`) FROM `jentry` where br_id= '$br_id' ";
	  $ecu_vno = $qry_vno->fetch_array();
	 $vur_no= $ecu_vno[0];
	 if ($vur_no < 10 )
	 {$vur_no= 9;} 
	 $var_no=$vur_no+1;
	 ?>

                                            <div class="col-sm-12">
                                                <div class="col-sm-7">
                                                    <input type="text" name="ent_key" id="ent_key"
                                                        class="ent_key hiddnCls" style=" height:30px;" hidden />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label> Voucher No x </label>
                                                    <input type="number" name="vou_no" id="vou_no" class="vou_no"
                                                        style=" height:30px;" value="<?php echo trim($var_no);?>"
                                                        autofocus />
                                                </div>

                                                <div class="col-sm-2">
                                                    <label> Date </label>

                                                    <?php
            if ($user_type == 'Admin' || $user_type == 'SuperAdmin' )
					{ 
          echo ' <div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px;">
                        <div  align="left" class="col-sm-10 input-append date dpk_date" 		
                        data-date="" data-date-format="yyyy-mm-dd" 
                        data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                        <input size="16" type="text" name="bil_date" id="bil_date" 
                        value="'. date("Y-m-d").'" 
                        required readonly 
                         class="form-control dpk_date456" style="width:100px;height:30px"/>
                        <span class="add-on" style=""><i class="icon-th"></i></span>
                        </div>
                    </div> ';
					
					}
					else
					{
						
						$rht_date=$mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
				 `user_id` ='$user_id' AND `page_title` ='control_Control Invoice Date' AND `user_rights`.`br_id`='$br_id'");
						
						$count_rht=$rht_date->num_rows;
						//echo $count_rht;
						
						if($count_rht <= 0)
						{
						
							$rqst_date= $_SESSION['CRT_DATE'];
							//echo 'date'. $rqst_date;
							
							if($rqst_date != '')
							{
							$bill_date=$rqst_date;
							}
							else
							{
							$bill_date=date('Y-m-d');
							}
							
							 echo ' <div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px;">
                        <div  align="left" class="col-sm-10 input-append date dpk_date2" 		
                        data-date="" data-date-format="yyyy-mm-dd" 
                        data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                        <input size="16" type="text" name="bil_date" id="bil_date" 
                        value="'. $bill_date .'" 
                        required readonly title="You can not change date"
                         class="form-control dpk_date456" style="width:100px;height:30px"/>
                        <span class="add-on" style=""><i class="icon-th"></i></span>
                        </div>
                   		 </div> ';
						
					}
					else
					{
					 echo ' <div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px;">
                        <div  align="left" class="col-sm-10 input-append date dpk_date" 		
                        data-date="" data-date-format="yyyy-mm-dd" 
                        data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                        <input size="16" type="text" name="bil_date" id="bil_date" 
                        value="'. date("Y-m-d").'" 
                        required readonly 
                         class="form-control dpk_date456" style="width:100px;height:30px"/>
                        <span class="add-on" style=""><i class="icon-th"></i></span>
                        </div>
                    </div> ';
					
					}
					
					
					
					}
					
					
			?>

                                                </div>

                                            </div>

                                            <div class="col-sm-12">
                                                <br />
                                            </div>

                                            <!-- jentry details-->

                                            <div class="jdet">
                                                <div class="jdet2">


                                                    <table
                                                        class="table  table-bordered bootstrap-datatable  responsive table-hover custmTB2">
                                                        <thead>
                                                            <tr>
                                                                <th width="6%"></th>
                                                                <th style=" width:28%;">Account ID</th>
                                                                <th width="27%">Description</th>
                                                                <th width="20%" style="text-align:right;">Debit</th>
                                                                <th width="20%" style="text-align:right;">Credit</th>

                                                                <th width="20%" hidden></th>

                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        <tr style="display:none;" id="importDiv">
                                                        <td></td>
                                                                <td><input type="text" name="lcNo" id="lcNo" class="lcNo" style="width:100%;" placeholder="Enter LC No" /></td>
                                                                <td colspan="5"></td>
                                                            </tr>
                                                            <tr style="background-color:#E3C3B8;">
                                                                <td>
                                                                    <input type="text" name="accno1" class="boxb"
                                                                        id="accno1" readonly border="0px" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="jornal_1" id="jornal_1"
                                                                        class="jornal_1 jornal boxd"
                                                                        value="Cash on hand account" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="jdesc1" id="jdesc1"
                                                                        placeholder="Type a description" class="boxd" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="debit1" id="debit1"
                                                                        placeholder="000" class="boxx"
                                                                        onkeypress="return IsNumeric(event)"
                                                                        style="text-align:right;" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="credit1" id="credit1"
                                                                        placeholder="000" class="boxx"
                                                                        onkeypress='return IsNumeric(event)'
                                                                        style="text-align:right;" />
                                                                </td>
                                                                <td hidden>
                                                                    <input type="text" name="acctype1"
                                                                        class="boxh hiddnCls" id="acctype1" hidden />
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="jent_inc1"
                                                                        class="boxh jent_inc1 hiddnCls" id="jent_inc1"
                                                                        readonly />
                                                                </td>
                                                                <td hidden>
                                                                    <input type="text" name="j_id1"
                                                                        class="boxh j_id1 hiddnCls" id="j_id1" readonly
                                                                        style="width:0px;" />
                                                                </td>

                                                                <td>
                                                                    <input type="checkbox" title="Tick here to SHOW" class="j_showcheck" />
                                                                    <input type="hidden" name="j_show_hide1"
                                                                        class="boxh j_show_hide1 j_showcheckBox hiddnCls"
                                                                        id="j_show_hide1" readonly
                                                                        style="width:100px;" />
                                                                </td>


                                                            </tr>
                                                            

                                                            <tr style="background-color:#B8E3D3;">
                                                                <td>
                                                                    <input type="text" name="accno2" class="boxb"
                                                                        id="accno2" readonly border="0px" />
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="jornal_2" id="jornal_2"
                                                                        class="boxd jornal2"
                                                                        value="Cash on hand account" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="jdesc2" id="jdesc2"
                                                                        class="boxd" placeholder="Type a description" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="debit2" id="debit2"
                                                                        class="boxx" placeholder="000"
                                                                        onkeypress='return IsNumeric(event)'
                                                                        style="text-align:right;" />
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="credit2" id="credit2"
                                                                        class="boxx" placeholder="000"
                                                                        onkeypress='return IsNumeric(event)'
                                                                        style="text-align:right;" />
                                                                </td>
                                                                <td hidden>
                                                                    <input type="text" name="acctype2"
                                                                        class="boxh hiddnCls" id="acctype2" hidden />
                                                                </td>

                                                                <td>
                                                                    <input type="text" name="jent_inc2"
                                                                        class="boxh jent_inc2 hiddnCls" id="jent_inc2"
                                                                        readonly />
                                                                </td>
                                                                <td hidden>
                                                                    <input type="text" name="j_id2"
                                                                        class="boxh j_id2 hiddnCls" id="j_id2" readonly
                                                                        style="width:0px;" />
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" title="Tick here to SHOW" class="j_showcheck" />
                                                                    <input type="hidden" name="j_show_hide2"
                                                                        class="boxh j_show_hide2 j_showcheckBox hiddnCls"
                                                                        id="j_show_hide2" readonly
                                                                        style="width:100px;" />
                                                                </td>

                                                            </tr>


                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <!-- jentry details-->

                                            <!-- footer body -->
                                            <div class="col-sm-12 previousDetails" style="margin-left:15px; display:none;">

                                                <div class="col-sm-3" style="text-align:right; ">

                                                    <label style="margin-top:5px;"> Total Expenditure </label>

                                                </div>
                                                <div class="col-sm-3">
                                                    <label> Last Month </label>
                                                    <input type="text" name="lst_mon" class="lst_mon hiddnCls"
                                                        id="lst_mon" readonly />

                                                </div>

                                                <div class="col-sm-3">
                                                    <label> Current Month </label>
                                                    <input type="text" name="cur_mon" class="cur_mon hiddnCls"
                                                        id="cur_mon" readonly />

                                                </div>

                                                <div class="col-sm-3">
                                                    <label> Budget Amount </label>

                                                    <input type="text" name="bug_amount" class="bug_amount hiddnCls"
                                                        id="bug_amount" readonly />

                                                </div>
                                            </div>
                                            <!-- footer body -->

                                            <div style="text-align:right; margin-top:80px; margin-right:30px;">







                                                <button class="btns  btn-xs saveData" type="button">
                                                    <a class="button button-green"> <i
                                                            class="glyphicon glyphicon-floppy-saved"></i> Save </a>
                                                </button>
                                                <button class="btns  btn-xs updatebt" type="button">
                                                    <a class="button button-green"> <i
                                                            class="glyphicon glyphicon-check"></i> Update </a> </button>
                                                <button class="btns  btn-xs deletebt" type="submit" name="deletebt"
                                                    id="deletebt">
                                                    <a class="button button-green"> <i
                                                            class="glyphicon glyphicon-trash"></i> Delete </a> </button>
                                                <input type="hidden" id="shwType" name="shwType" value="SHOW" />
                                                <input type="checkbox" name="chk_show" id="chk_show" class="chk_show"
                                                    value="SHOW" hidden />
                                            </div>




                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Start of warning -->
            <div id="creatCusMsg" style="display:none;">
                <div class="errConfrmHaed"> Warning ! </div>
                <span style="color:#F00" id="responseSpan"> </span>
                <br />

                <button type="button" class="btn btn-default blockUIClosBtn" style="" />Ok</button>
            </div>
            <!--end of warning -->

            <!-- /page content -->
            <?php include($path.'footer.php')?>

            <script>
            
            $(document).on('click', '.j_showcheck', function(evt) {
                $('.j_showcheck').each(function(){
                    
                    if($(this).prop('checked') == true){
                        $(this).parent().find('.j_showcheckBox').val('SHOW');
                    }else{
                        $(this).parent().find('.j_showcheckBox').val('HIDE');
                    }
                })
                updateShowHide();
            });
            
            function updateShowHide(){
                $('.j_showcheckBox').each(function(){
                    var showValue = $(this).val();
                    
                    if(showValue == 'SHOW'){
                        $(this).parent().find('.j_showcheck').prop('checked', true);
                    }else{
                        $(this).parent().find('.j_showcheck').prop('checked', false);
                    }
                })
            }
            
            $(document).ready(function() {

                var rgt_edit = $('.rgt_edit').val();
                if (rgt_edit == 'No') {


                    // alert('fd '+ evt.keycode);
                    $('.saveData').prop('disabled', false);
                    $('.saveData').css('background', '#825D19');

                    $('.updatebt').prop('disabled', true);
                    $('.updatebt').css('background', '#D4D4D4');

                    $('.deletebt').prop('disabled', true);
                    $('.deletebt').css('background', '#D4D4D4');

                }
                //alert (rgt_edit);

            });

            $("input[type='text']").on("click", function() {
                $(this).select();
            });

            /*$('body').on('keypress','input',function (evt) {
            	
            	if (evt.keyCode == 13) {		
            		
            		iname = $(this).cla
            		if (iname !== 'Submit') {
            			var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
            			var index = fields.index(this);
            			if (index > -1 && (index + 1) < fields.length) {
            				
            				//alert(index);
            						if(index == 10 )
            						{
            						//alert('index 13');
            						//fields.eq(index + 2).focus();
            						fields.eq(15).focus();
            						}
            						else if( index == 18)
            						{
            							fields.eq(26).focus();
            							}
            						else
            						{
            						fields.eq(index + 1).focus();
            						}
            				
            			}
            			return false;
            		}			
            		
            	}
            });*/


            $('body').on('keypress', 'input', function(evt) {
                if (evt.keyCode == 13) {

                    iname = $(this).cla
                    if (iname !== 'Submit') {
                        var fields = $(this).parents('form:eq(0),body').find(
                            'button, input, textarea, select, checkbox');
                        var index = fields.index(this);
                        x = 1;
                        isHiddn = true;
                        while (isHiddn == true) {

                            if (fields.eq(index + x).hasClass('hiddnCls')) {
                                x++;
                            } else {
                                isHiddn = false;
                                fields.eq(index + x).focus();
                            }
                            //fields.eq(index + 1).focus();
                        } //alert(index);

                        return false;
                    }

                }
            });



            $('body').on('click', '.journalID', function() {
                var jornlID = $(this).attr('value');
                $('# CreateFrm').remove();
                $('#ajax_img_lod_cusDetil').show();
                $.ajax({
                    url: 'ajx/jornalEdit.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        AccID: jornlID
                    },
                    success: function(data) {
                        $('#ajax_img_lod_cusDetil').hide();
                        $('.ajaxContent').html(data);
                    }
                });
            });


            // conform yes

            $(document).on('click', '.yes', function() {
                $('#myModal2').modal("hide");
                setTimeout($.unblockUI, 1);

                var v_no = $('.vou_no').val();
                window.open("print/<?php echo $JournalPrintPage; ?>.php?v_no=" + v_no + "", "myWindowName",
                    "width=595px, height=842px");
                window.location = 'journal_Entry.php';

            });


            // conform no

            $(document).on('click', '.no', function() {
                $('#myModal2').modal("hide");
                setTimeout($.unblockUI, 1);
                window.location = 'journal_Entry.php';

            });



            //save code
            $(document).on('click', '.saveData', function() {
                var count = 0;
                //alert('save');



                if ($('#vou_no').val() == '') {
                    alert('Input validation alert', 'Voucher number can not be empty..');
                    $('#vou_no').focus();
                } else if ($('#jornal_1').val() == '') {
                    alert('Input validation alert', 'Acc ID can not be empty..');
                    $('#jornal_1').focus();
                } else {
                    jornalSave();
                }



            });

            //update code
            $(document).on('click', '.updatebt', function() {
                var count = 0;
                //alert('save');
                if ($('#vou_no').val() == '') {
                    alert('Input validation alert', 'Voucher number can not be empty..');
                    $('#vou_no').focus();
                } else if ($('#jornal_1').val() == '') {
                    alert('Input validation alert', 'Acc ID can not be empty..');
                    $('#jornal_1').focus();
                } else {
                    jornalUpdate();
                }



            });


            function ValidateBank() {
                var bank = $.trim($('#bank').val());
                var bankBrn = $.trim($('#bankBrn').val());
                var bankErr = 0;
                if (bank.length != 4) {
                    bankErr++;
                }

                if (bankBrn.length != 3) {
                    bankErr++;
                }

                return bankErr;

            }

            function bankNotValid() {
                $('.blockUIClosBtn').data("value", "repMail");
                $('#responseSpan').html('Bank not valid');
                $.blockUI({
                    message: $('#creatCusMsg')
                });
                $('.blockMsg').css({
                    'background': '#fff',
                    'border-radius': '10px',
                    'border': '#fff 3px',
                    'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
                    'background-clip': 'padding-box'
                });
            }
            /*
            $(document).on('click', '.updateRep', function(){
            	
            	var HiddnID = $('#jorIDHiddn').val() ;
            	var count = 0;
            	$( ':input[required]', '#jornalCreateFrm' ).each( function () {
            		
            		if ( this.value.trim() !== '' ) {									
            			count++;										
            		}else{		
            			$(this).focus();
            			return false;
            		}
            		
            	});

            		
            	
            	if( HiddnID.trim() !== '' ){		
            		
            		if(count == 2){	
            			
            			var expnType = $('#accMode').val();
            			
            			if(expnType === 'SAVING ACC' || expnType === 'CURRENT ACC') {
            				
            				if ( ValidateBank() == 0){ 				
            					jornalSave();
            						
            				}else{				
            					bankNotValid();
            				}
            				
            				
            			}		
            			else{
            				jornalSave();
            			}	
            		
            		}
            		
            		
            	}else{
            		
            		$('#responseSpan').html('Please select a valide Sales Rep ');						
            		$.blockUI({ message: $('#creatCusMsg') });
            		$('.blockMsg').css({
            				'background' : '#fff',						
            				'border-radius': '10px',
            				'border' : '#fff 3px',
            				'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
            				'background-clip': 'padding-box'
            			}
            		);		
            		
            	}
            });*/


            $(document).on('click', '.blockUIClosBtn', function(e) {
                setTimeout($.unblockUI, 300);
                if ($(this).data("value") == "repMail") {
                    $('#repMail').focus();
                }
            });


            $(document).on('change', '#accMode', function(e) {
                $('#cardDetil').hide();
                $('#trBudjet').hide();

                var expnType = $(this).val();

                if (expnType == "CURRENT ACC") {
                    $('#cardDetil').show();
                } else if (expnType == "SAVING ACC") {
                    $('#cardDetil').show();
                } else if (expnType == 'EXPENSES') {
                    $('#trBudjet').show();
                }
            });


            $(document).on('click', ':input', function() {
                $(this).select();
                //alert('selected');
            });




            function jornalSave() {
                /*$.blockUI({ css: { 
                	border: 'none', 
                	padding: '15px', 
                	backgroundColor: '#000', 
                	'-webkit-border-radius': '10px', 
                	'-moz-border-radius': '10px', 
                	opacity: .5, 
                	color: '#fff' } 
                });*/

                $('.saveData').prop('disabled', true);
                $('.saveData').css('background', '#D4D4D4');

                $.ajax({
                    url: 'ajx/jentrySave.php',
                    data: $('#jentry_form').serialize(),
                    type: 'POST',
                    success: function(data) {
                        if (data.trim() == 'Login Please') {
                            window.location = '../login.php';
                        }
                        if (data.trim() == 'Ok') {


                            $('#ermsgHead').html('Conformation!');
                            $('#chqMsgContent').html('Do you want print?');
                            $('#myModal2').modal('show');
                            $('.modal-dialog').css('width', '350');
                            var btnsForModl =
                                '<input type="button" class="btn btn-success  btn-xs yes" value="yes" id="yesFocusID" ';
                            btnsForModl += 'data-dismiss="modal" /> ';
                            btnsForModl +=
                                '<input type="button" class="btn btn-success  btn-xs no" value="No" data-dismiss="modal" />';
                            $('.myModlModal').html(btnsForModl);
                            $('#yesFocusID').focus();

                            /*	var answer = confirm("Do you want to print?")
                            	if (answer){
                            		   //some code
                            		  // alert('yes');
                            		  var v_no = $('.vou_no').val();
                            		 window.open("print/fr_jprint.php?v_no="+v_no+"" , "myWindowName","width=595px, height=842px");
                            		  window.location = 'journal_Entry.php';
                            					  
                            	}
                            	else{
                            			//some code
                            			//alert('no');
                            			window.location = 'journal_Entry.php';
                            	}*/
                            //window.location = 'journal_Entry.php';
                        } else {
                            $('#responseSpan').html(data.trim());
                            $.blockUI({
                                message: $('#creatCusMsg')
                            });
                            $('.blockMsg').css({
                                'background': '#fff',
                                'border-radius': '10px',
                                'border': '#fff 3px',
                                'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
                                'background-clip': 'padding-box'
                            });
                        }
                    }
                });
            }


            function showChnag() {
                var typ = $('#shwType').val();

                if (typ === 'SHOW') {
                    $('#shwType').val('HIDE');
                } else {
                    $('#shwType').val('SHOW');
                }
            }

            $(window).bind('keydown', function(event) {
                if (event.ctrlKey || event.metaKey) {
                    switch (String.fromCharCode(event.which).toLowerCase()) {
                        case 's':
                            event.preventDefault();
                            showChnag();
                            break;

                    }
                }
            });



            //update function

            function jornalUpdate() {
                /*$.blockUI({ css: { 
                	border: 'none', 
                	padding: '15px', 
                	backgroundColor: '#000', 
                	'-webkit-border-radius': '10px', 
                	'-moz-border-radius': '10px', 
                	opacity: .5, 
                	color: '#fff' } 
                });*/

                // $('.updatebt').prop('disabled', true);

                $.ajax({
                    url: 'ajx/jentryEdit.php',
                    data: $('#jentry_form').serialize(),
                    type: 'POST',
                    success: function(data) {
                        if (data.trim() == 'Login Please') {
                            window.location = '../login.php';
                        }
                        if (data.trim() == 'Ok') {


                            $('#ermsgHead').html('Conformation!');
                            $('#chqMsgContent').html('Do you want print?');
                            $('#myModal2').modal('show');
                            $('.modal-dialog').css('width', '350');
                            var btnsForModl =
                                '<input type="button" class="btn btn-success  btn-xs yes" value="yes" id="yesFocusID" /> ';
                            btnsForModl +=
                                '<input type="button" class="btn btn-success  btn-xs no" value="No" data-dismiss="modal" />';
                            $('.myModlModal').html(btnsForModl);
                            $('#yesFocusID').focus();

                            /*	var answer = confirm("Do you want to print?")
                            if (answer){
                            		   //some code
                            		  // alert('yes');
                            		  var v_no = $('.vou_no').val();
                            		 window.open("print/fr_jprint.php?v_no="+v_no+"" , "myWindowName","width=595px, height=842px");
                            		  window.location = 'journal_Entry.php';
                            					  
                            	}
                            	else{
                            			//some code
                            			//alert('no');
                            			window.location = 'journal_Entry.php';
                            	}*/
                        } else {
                            $('#responseSpan').html(data.trim());
                            $.blockUI({
                                message: $('#creatCusMsg')
                            });
                            $('.blockMsg').css({
                                'background': '#fff',
                                'border-radius': '10px',
                                'border': '#fff 3px',
                                'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
                                'background-clip': 'padding-box'
                            });
                        }
                    }
                });
            }


            //update function


            //load j account

            $(document).on('keyup', '.jornal , .jornal2', function(evt) {
                //$('.saveData').prop('disabled', false);
                //  $('.saveData').css('background', '#825D19');
                //var thisRow = $(this).data('value');
                //var cID = $('#cusHiddnID').val();
                //console.log('row  '+thisRow);
                var v = this.id;
                var valu = $('#' + v).val();

                if (evt.keyCode == 13) {

                } else {

                    if (v == 'jornal_1') {
                        //alert (v+' s '+valu);
                        $('#accno1').val('');
                    } else if (v == 'jornal_2') {
                        $('#accno2').val('');
                        //alert (v+' s '+valu); 
                    }

                }

                if (event.which != 13) {
                    //itemSearchDisables(thisRow);
                }
                autoTypeNo2 = 1;
                autoTypeNo1 = 0;

                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: 'ajx/get_jacc.php',
                            dataType: "json",
                            method: 'post',
                            data: {
                                // ID: request.term,
                                accID: valu
                            },
                            success: function(data) {
                                response($.map(data, function(item) {
                                    var code = item.split("|");
                                    var journalNm = code[1]+" - "+code[0];
                                    if (code[0] == 'Login Please') {
                                        window.location = '../login.php';
                                    }
                                    return {
                                        label: journalNm,
                                        value: code[0],
                                        data: item
                                    }
                                }));
                            }
                        });
                    },
                    autoFocus: true,
                    minLength: 0,
                    select: function(event, ui) {
                        var names = ui.item.data.split("|");
                        id_arr = $(this).attr('id');
                        id = id_arr.split("_");
                        //itemSearchEnables(thisRow);
                        if (v == "jornal_1") {
                            $('#jornal_1').val(names[0]);
                            // $('#jornal_2').val(names[0]);
                            //$('#acctype2').val(names[2]);
                            $('#acctype1').val(names[2]);
                            $('#accno1').val(names[1]);
                            // $('#accno2').val(names[1]);
                            $('#bug_amount').val(names[3]);
                            $('#cur_mon').val(names[4]);
                            $('#lst_mon').val(names[5]);
                            $('#j_show_hide1').val(names[6]);
                            showhideLC();
                            
                            if(names[7] == 1){
                               $('.previousDetails').hide(); 
                            }else{
                                $('.previousDetails').show(); 
                            }
                        } else if (v == "jornal_2") {
                            $('#jornal_2').val(names[0]);
                            $('#acctype2').val(names[2]);
                            $('#accno2').val(names[1]);
                            $('#j_show_hide2').val(names[6]);
                            // $('#bug_amount').val(names[3]);
                            // $('#jornal_2').css('color', '#0CCC0F');
                            //alert(v);2
                        }
                        
                        updateShowHide();
                    }
                });

            });

            function showhideLC(){
                var jourType = $('#jornal_1').val();
                if(jourType == 'IMPORTS'){
                    $('#importDiv').show()
                }else{
                    $('#importDiv').hide()
                }
            }

            // load detail
            function chk_baranch() {
                $('.jdet2').remove();
                var vou_no = $('#vou_no').val();
                var rgt_edit = $('.rgt_edit').val();

                //alert (vou_no);
                $.ajax({
                    'url': 'ajx/get_jbody.php',
                    method: 'post',
                    'data': {
                        item: vou_no,
                        rgt_edit: rgt_edit
                    },
                    success: function(data) {
                        //$('#ajaxloaderUserUpdate').hide();
                        $('.jdet').html(data);
                        $('.ajax-loaders').hide();
                    }
                })



            }



            // load details

            $(document).on('keyup', '#jdesc1, #credit1,#debit1,#credit2,#debit2', function(evt) {

                // $('.saveData').prop('disabled', false);
                // $('.saveData').css('background', '#825D19');

                if (evt.keyCode == 13) {

                } else {

                    var v = this.id;
                    var valu = $('#' + v).val();
                    if (v == 'jdesc1') {
                        $('#jdesc2').val(valu);
                    } else if (v == 'credit1') {
                        $('#debit2').val(valu);
                        $('#credit2').val('');
                        $('#debit1').val('');
                        $('#ent_key').val('1-c');
                        $('#jent_inc1').val('Decrease');
                        $('#jent_inc2').val('Increase');
                    } else if (v == 'debit1') {
                        $('#credit1').val('');
                        $('#debit2').val('');
                        $('#credit2').val(valu);
                        $('#ent_key').val('1-d');
                        $('#jent_inc1').val('Increase');
                        $('#jent_inc2').val('Decrease');
                    } else if (v == 'credit2') {
                        $('#debit1').val(valu);
                        $('#credit1').val('');
                        $('#debit2').val('');
                        $('#ent_key').val('2-c');
                        $('#jent_inc2').val('Decrease');
                        $('#jent_inc1').val('Increase');
                    } else if (v == 'debit2') {
                        $('#credit2').val('');
                        $('#debit1').val('');
                        $('#credit1').val(valu);
                        $('#ent_key').val('2-d');
                        $('#jent_inc2').val('Increase');
                        $('#jent_inc1').val('Decrease');
                    }

                    //alert(v+' id '+valu);
                }

            });




            $(document).on('keyup', '#vou_no', function(evt) {

                //$(".vou_no").keyup(function(evt){

                //var thisRow = $(this).data('value');
                //var cID = $('#cusHiddnID').val();
                //console.log('row  '+thisRow);
                var v = this.id;
                var valu = $('#' + v).val();

                if (evt.keyCode != 13) {
                    // alert('fd '+ evt.keycode);
                    $('.saveData').prop('disabled', false);
                    $('.saveData').css('background', '#825D19');

                    $('.updatebt').prop('disabled', true);
                    $('.updatebt').css('background', '#D4D4D4');

                    $('.deletebt').prop('disabled', true);
                    $('.deletebt').css('background', '#D4D4D4');
                }
                // $(".saveData").button("disable"); 


                autoTypeNo2 = 1;
                autoTypeNo1 = 0;

                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: 'ajx/get_jentry.php',
                            dataType: "json",
                            method: 'post',
                            data: {
                                // ID: request.term,
                                accID: valu
                            },
                            success: function(data) {

                                response($.map(data, function(item) {
                                    var code = item.split("|");
                                    if (code[0] == 'Login Please') {
                                        window.location = '../login.php';
                                    }
                                    return {
                                        label: code[autoTypeNo1],
                                        value: code[autoTypeNo2],
                                        data: item
                                    }
                                }));
                            }
                        });
                    },
                    autoFocus: true,
                    minLength: 0,
                    select: function(event, ui) {
                        var names = ui.item.data.split("|");
                        id_arr = $(this).attr('id');
                        id = id_arr.split("_");
                        //itemSearchEnables(thisRow);
                        $('.ajax-loaders').show();
                        $('#vou_no').val(names[1]);
                        $('#bil_date').val(names[3]);

                        if (names[2] == 'HIDE') {
                            $(".chk_show").attr('checked', 'checked'); // checked
                            //alert(names[2]);
                            //alert ('br all');

                        } else {
                            $(".chk_show").removeAttr("checked");
                        }
                        chk_baranch();
                        // $('#jornal_2').val(names[0]);

                        var rgt_edit = $('.rgt_edit').val();
                        if (rgt_edit == 'No') {

                            // alert('fd '+ evt.keycode);
                            $('.saveData').prop('disabled', false);
                            $('.saveData').css('background', '#825D19');

                            $('.updatebt').prop('disabled', true);
                            $('.updatebt').css('background', '#D4D4D4');

                            $('.deletebt').prop('disabled', true);
                            $('.deletebt').css('background', '#D4D4D4');

                        } else {

                            $('.saveData').prop('disabled', true);
                            $('.saveData').css('background', '#D4D4D4');

                            $('.updatebt').prop('disabled', false);
                            $('.updatebt').css('background', '#825D19');

                            $('.deletebt').prop('disabled', false);
                            $('.deletebt').css('background', '#825D19');
                        }
                        updateShowHide();
                        showhideLC();
                    }
                });

            });
            </script>



            <script type="text/javascript">
            $('.dpk_date').datetimepicker({
                language: 'fr',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                minView: 2,
                forceParse: 0,
                format: "yyyy-mm-dd",
                viewMode: "months",
                minViewMode: "months"
            });

            </script>
