<?php
$title = 'New Customer';
$pageRights = 'create_Customer';
include('path.php');
include('includeFile.php');

$type = '';
$chk = '';
$type = $_POST['laodsubmit'];

$sql_RepControlRight = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
    				 `user_id` ='$user_id' AND `page_title` ='control_Rep_Control' AND `user_rights`.`br_id`='$br_id'");
$RepControlCount = $sql_RepControlRight->num_rows;

if ($RepControlCount == true) {
    $sql_cus = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE br_id='$br_id' AND userID='$user_id' ORDER BY custtable.ID");
    $sql_cusActive = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE br_id='$br_id' AND userID='$user_id' AND Active2 = 'YES'");
    $sql_cusInActive = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE br_id='$br_id' AND userID='$user_id' AND Active2 = 'NO'");
    $chk = '';
} else {
    if ($type == 'ALL') {
        $sql_cus = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable ORDER BY custtable.ID");
        $sql_cusActive = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE Active2 = 'YES'");
        $sql_cusInActive = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE Active2 = 'NO'");
        $chk = 'checked';
    } else {
        $sql_cus = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE br_id='$br_id' ORDER BY custtable.ID");
        $sql_cusActive = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE br_id='$br_id' AND Active2 = 'YES'");
        $sql_cusInActive = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address, Active2 FROM custtable WHERE br_id='$br_id' AND Active2 = 'NO'");
        $chk = '';
    }
}

$sql_approveCustomer = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
		                                    `user_id` ='$user_id' AND `page_title` ='control_cusCreate' AND `user_rights`.`br_id`='$br_id'");
$hideField = '';
$approveCust = FALSE;
$count_approveCustomer = $sql_approveCustomer->num_rows;

$sql_approveCusOpt = $mysqli->query("SELECT `opertionName`, `optionPath` FROM `optiontb` WHERE `opertionName` = 'APPROVE CUSTOMER' AND optionPath = 'YES' AND `br_id`='$br_id'");
if ($sql_approveCusOpt->num_rows == TRUE || $sql_approveCustomer->num_rows == TRUE) {
    $approveCust = TRUE;
}


if ($approveCust == TRUE) {
    $hideField = 'style="display:none;"';
    $active = 'APPROVE-UPDATE';
}

if (isset($_POST['custIDHidn'])) {
    $HidnID = trim($_POST['custIDHidn']);

    if ($HidnID != '') {
        $custID = $_POST['custID'];
        $cname = $_POST['cname'];
        $Dcode = $_POST['Dcode'];
        $address = $_POST['address'];
        $creditLmt = $_POST['creditLmt'];
        $disLevl = $_POST['disLevl'];
        $telphone = $_POST['telphone'];
        $fax = $_POST['fax'];
        $cusEmail = $_POST['cusEmail'];
        $moblNo = $_POST['moblNo'];
        $othrName = $_POST['othrName'];
        $cusDob = $_POST['cusDob'];

        $salRep = $_POST['salRep'];
        $source_from = $_POST['source_from'];

        $createDate = $_POST['createDate'];
        $cus_area = $_POST['area_name'];
        $cus_price = $_POST['txt_price'];
        $vat_no = $_POST['txt_Vno'];
        $bk_det = $_POST['txt_BKdet'];
        $dueDays = $_POST['dueDays'];
        $billtobill = $_POST['billtobill'];
        if(isset($_POST['cus_deal_typ2'])){
            $cus_deal_typ2 = implode(",", $_POST['cus_deal_typ2']);
        }else{
            $cus_deal_typ2 = '';
        }
        
        $starPoint = $_POST['txt_starP'];
        $owner = $_POST['txt_owner'];
        $owner_dob = $_POST['txt_owner_bod'];
        $pur_offi = $_POST['txt_pur_office'];
        $cusRemarks = $_POST['cusRemarks'];
        $yearEst = $_POST['yearEst'];
        if(isset($_POST['businessF'])){
            $businessF = implode(",", $_POST['businessF']);
        }else{
            $businessF = '';
        }
        $introBy = $_POST['introBy'];
        $cusType = $_POST['cusType'];
        $cusDis = $_POST['cusDis'];



        $district = $_POST['district'];
        $city = $_POST['city'];

        if ($active != 'APPROVE-UPDATE') {
            $active = ($_POST['active'] == 'YES') ? 'YES' : 'NO';
        }

        $Dcode = ($_POST['Dcode'] == '') ? $telphone : $_POST['Dcode'];
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $sql_up = $mysqli->query("UPDATE custtable SET cusName='$cname', CustType='', dealerCode='$Dcode', Address='$address', rep_id='$salRep[0]',
        						   CreditLimit='$creditLmt', DiscLevel='$disLevl', Date='$createDate', DOB='',EmailNo='$cusEmail', FaxNo='$fax', 
        						   MobNo='$moblNo', OtherName='$othrName', TelNo='$telphone', recordDate='$date', recordTime='$time',
        						    userID='$user_id', cloud='Updated',area='$cus_area',br_id='$br_id',cus_price='$cus_price', vatNo='$vat_no'
        						   ,bank_det='$bk_det',Active2='$active',owner='$owner',owner_dob='$owner_dob',pur_officer='$pur_offi',due_days = '$dueDays',new_cus_type = '$cus_deal_typ2'
        						   , `cus_starPoint` ='$starPoint', `districtName` ='$district', `cityName` ='$city', cusRemarks = '$cusRemarks', y_estbl='$yearEst', business_field='$businessF', introduced_by ='$introBy', CustType = '$cusType', backup='$cusDis', DOB = '$cusDob', source_from = '$source_from', billtobill='$billtobill' WHERE ID='$HidnID'");

        if ($sql_up) {

            $sql_deleteContact = $mysqli->query("DELETE FROM customer_contactDet WHERE cusTb='$HidnID' AND br_id = '$br_id'");
            $cTitleArr = $_POST['cTitleArr'];
            $cNameArr = $_POST['cNameArr'];
            $cNoArr = $_POST['cNoArr'];
            $cDesignationArr = $_POST['cDesignationArr'];
            $cEmailArr = $_POST['cEmailArr'];
            $cDobArr = $_POST['cDobArr'];
            $cRemarksArr = $_POST['cRemarksArr'];
            if ($cTitleArr != '') {
                foreach ($cTitleArr as $key => $tb) {
                    $cTitleArr1 = $cTitleArr[$key];
                    $cNameArr1 = $cNameArr[$key];
                    $cNoArr1 = $cNoArr[$key];
                    $cDesignationArr1 = $cDesignationArr[$key];
                    $cEmailArr1 = $cEmailArr[$key];
                    $cDobArr1 = $cDobArr[$key];
                    $cRemarksArr1 = $cRemarksArr[$key];
                    $rDateT = date('Y-m-d H:i:s');
                    $sql_cntact = $mysqli->query("INSERT INTO customer_contactDet (br_id, cusTb, nameTitle, contactName, contactNo, designation, contactDOB, contactEmail, remarks, rDateTime, user_id) 
													VALUES ('$br_id', '$HidnID', '$cTitleArr1', '$cNameArr1', '$cNoArr1', '$cDesignationArr1', '$cDobArr1', '$cEmailArr1', '$cRemarksArr1', '$rDateT', '$user_id')");
                }
            }
            if ($salRep != '') {
                $qry_route = $mysqli->query('SELECT max(`routeNo`) FROM `repcustomize`');
                $res_route = $qry_route->fetch_array();
                $routeNo = ($res_route[0] == '') ? 0 : $res_route[0];
                $routeNo = $routeNo + 1;
                $refNo = 'Rot-' . $routeNo;

                $rghts = $mysqli->query("SELECT * FROM `pages` WHERE `path` = 'create_cusFixRep' AND `userRights` = 'Y' ");
                $rhts_count = $rghts->num_rows;

                // if ($rhts_count > 0 || $user_type == 'Admin') {
                    $actv_no = $mysqli->query("UPDATE `repcustomize` SET `status`='NO' where `cus_id`='$HidnID' ");
                    foreach ($salRep as $salesKey => $salesTb) {
                        if ($salRep[$salesKey] != '') {
                            $salRep1 = $salRep[$salesKey];
                            $qry_rep = $mysqli->query("SELECT * FROM `repcustomize` WHERE `cus_id`='$HidnID' AND `rep_id`='$salRep1'");
                            $num_rep = $qry_rep->num_rows;
                            if ($num_rep == 0) {
                                $qry_insertRep = $mysqli->query("INSERT INTO `repcustomize`(`RefNO`, `routeNo`, `br_id`, `cus_id`, `rep_id`, `route`,
                                `user_id`, `recordDate`, `recordTime`, `cloud`,`status`) 
                                VALUES ('$refNo','" . $routeNo . "','$br_id','$HidnID','$salRep1','','$user_id','$date','$time','Update','Active')");
                            } else {
                                $actv_no1 = $mysqli->query("UPDATE `repcustomize` SET `status`='Active' WHERE `cus_id`='$HidnID' AND `rep_id`='$salRep1'");
                            }
                        }
                    }
                // }
            }

            $_SESSION['succsess_msg'] = 'Customer update Process Done ! ';
            redirect('create_Customer.php');
            die();
        } else {
            $_SESSION['error_msg'] = 'Error in Customer update Process !';
            redirect('create_Customer.php');
            die();
        }
    }
}


$sql_cusLast = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address FROM custtable ORDER BY CustomerID DESC LIMIT 01");
$cusLast = $sql_cusLast->fetch_array();

$sql_cusLastDet = $mysqli->query("SELECT CustomerID, cusName, TelNo, Address FROM custtable ORDER BY ID DESC LIMIT 01");
$cusLastDet = $sql_cusLastDet->fetch_array();


$sql_selectRight = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
    				 `user_id` ='$user_id' AND `page_title` ='control_autoID' AND `user_rights`.`br_id`='$br_id'");
$RightCount = $sql_selectRight->num_rows;


if ($RightCount == true || $approveCust == TRUE) {
    if ($sql_cusLast->num_rows == TRUE) {
        if (is_numeric($cusLast[0])) {
            $autoID = $cusLast[0] + 1;
            $idDisabe = 'style="pointer-events: none;"';
        } else {
            $autoID = '';
            $idDisabe = '';
        }
    } else {
        $autoID = '1000';
        $idDisabe = 'style="pointer-events: none;"';
    }
} else {
    $autoID = '';
    $idDisabe = '';
}
?>

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<style>
    .nav1 {
        color: black;
        /* Default font color */
        transition: color 0.3s ease;
        border: 1px solid silver;
        height: 30px;
        font-size: 15px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        /* Horizontal centering */
        align-items: center;
        /* Vertical centering */

    }

    .bootstrap-select .dropdown-toggle,
    .bootstrap-select .dropdown-toggle:focus {
        height: 30px;
        /* Adjust the desired height here */
        padding: 5px;
        width: 87%;
    }

    .bootstrap-select .dropdown-menu {
        max-height: 200px;
        /* Adjust the maximum height of the dropdown menu */
        overflow-y: auto;
    }

    .center-div {
        paddign-left: 10px;
    }


    .nav1:hover {
        background-color: #30a4e7;
        color: white;

    }

    .navText:hover {
        color: white;
    }

    .navText {
        text-decoration: none;
    }

    .nav:hover .navText {
        color: white;
        /* Font color on hover */
    }

    .select2 {
        width: 100% !important;
    }

    .hidden {
        display: none;
    }
</style>

</head>

<body class="nav-sm">
    <form action="create_Customer.php" method="post" id="cusCreate" autocomplete="off">
        <div class="container body">
            <div class="main_container">
                <?php
                include($path . 'side.php');
                include($path . 'mainBar.php');
                ?>

                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3><?php echo $title; ?></h3>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div class="x_panel">

                                    <div class="x_title">
                                        <h2><i class="fa fa-align-left"></i> Customer Details <small></small></h2>
                                        <?php
                                        $invCusBlock = 'NO';
                                        $qry_CusBlock = $mysqli->query("SELECT `ID`, `br_id`, `opertionName`, `optionPath`, `report_name`, `order`, `backup` FROM `optiontb` 
                                        WHERE `opertionName`='Only Branch Customers' AND optionPath = 'YES' ");
                                        if ($qry_CusBlock->num_rows > 0) {
                                            $invCusBlock = 'YES';
                                        }

                                        if ($hideField == '') {
                                            if ($invCusBlock == 'NO') {
                                                echo '<input style="float:right;" title="All Customer" type="checkbox" class="cus_all" ID="cus_all" name="cus_all" value="cus_all" ' . $chk . '/>';
                                            }
                                        }
                                        ?>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <div class="box-content">
                                            <?php

                                            $qry_lst = $mysqli->query("SELECT `customerID`, `cusName`, `cus_price`, `Date`, ID FROM `custtable` WHERE br_id = '$br_id' ORDER BY `ID` DESC LIMIT 1");
                                            $lst_itm = $qry_lst->fetch_array();
                                            
                                            echo '
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <p style="color:#C94D0C; font-size:14px;">
                                                            <b><u>Last Created Customer in this branch</u></b> <br> 
                                                            Code : <b> ' . $lst_itm[0] . ' </b>
                                                            Customer Name : <b>' . $lst_itm[1] . '</b> <br>
        		                                            Created Date: <b>' . $lst_itm[3] . ' </b>
        		                                        </p>
		                                            </div>';
		                                            
		                                            if($showOtherBranches == true){
                                                        $sql_chkOtherBR = $mysqli->query("SELECT `customerID`, `cusName`, `cus_price`, `Date` FROM `custtable` WHERE br_id != '$br_id' LIMIT 1");
                                                        if($sql_chkOtherBR->num_rows == true){
                                                            $sql_chkFullBR = $mysqli->query("SELECT `customerID`, `cusName`, `cus_price`, `Date`, ID FROM `custtable` ORDER BY `ID` DESC LIMIT 1");
                                                            $otherBRdet = $sql_chkFullBR->fetch_array();
                                                            
                                                            if($otherBRdet['ID'] != $lst_itm['ID']){
                                                                echo '        
                		                                            <div class="col-md-5">
                                                                        <p style="color:#c9a80c; font-size:14px;">
                                                                            <b><u>Last Created Customer in full company</u></b> <br> 
                                                                            Code : <b> ' . $otherBRdet[0] . ' </b>
                                                                            Customer Name : <b>' . $otherBRdet[1] . '</b> <br>
                        		                                            Created Date: <b>' . $otherBRdet[3] . ' </b>
                        		                                        </p>
                		                                            </div>
                		                                        ';
                                                            }
                                                            
                                                        }
		                                            }
                                                    
		                                    echo '</div>';
                                            ?>
                                            <table id="example" class="table table-striped table-bordered bootstrap-datatable responsive custmTB" style="width:100%">
                                                <thead>
                                                    <?php


                                                    $totCus = $sql_cus->num_rows;
                                                    $totcusActive = $sql_cusActive->num_rows;
                                                    $totcusInActive = $sql_cusInActive->num_rows;

                                                    echo '<tr>
                                                                <th colspan="5">No. Of Customers: ' . $totCus . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                Active Customers: ' . $totcusActive . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                                                In-Active Customers: ' . $totcusInActive . '</th>
                                                        </tr>';
                                                    ?>

                                                    <tr>
                                                        <th width="10%">Cus ID</th>
                                                        <th width="30%">Customer Name</th>
                                                        <th width="15%">Telephone</th>
                                                        <th width="45%">Address</th>
                                                        <th width="45%">Dealer #</th>
                                                        <th width="45%"></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="x_panel">

                                    <div class="x_title">
                                        <h2><i class="fa fa-align-left"></i> New Customer <small></small></h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <ul class="nav nav-tabs" style="margin-bottom:25px;">
                                        <li class="active"><a style="border:1px solid silver;" data-toggle="tab" href="#home"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Basic</a></li>
                                        <li><a style="border:1px solid silver;" data-toggle="tab" href="#menu1"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Contact</a></li>
                                        <li><a style="border:1px solid silver;" data-toggle="tab" href="#menu2"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Extra</a></li>
                                    </ul>



                                    <div class="tab-content">
                                        <div class="x_content tab-pane fade in active" id="home">

                                            <div class="box-content ajaxContent">
                                                <div align="center"> <img src="../img/ajax-loaders/ajax-loader-5.gif" id="ajax_img_lod_cusDetil" /> </div> <!-- NEW -->
                                                <div class="form-group" <?php echo $hideField; ?>>
                                                    <label> <input type="checkbox" name="at_id" id="at_id" class="at_id" value="at_id"> Customer ID</label>
                                                    <label class="reqireLbl"> * [
                                                        <?php echo $cusLastDet[0] ?>
                                                        ]</label>
                                                    <img src="../img/ajax-loaders/ajax-loader-1.gif" id="ajax_img_lod" />
                                                    <input type="hidden" id="custIDHidn" class="custIDHidn" name="custIDHidn" />
                                                    <input type="text" fixedCode="<?php echo $fixCode; ?>" class="form-control customerID chaBlock fixCodes" name="custID" value="<?php echo $autoID ?>" required <?php echo $idDisabe ?> />
                                                </div>
                                                <div class="form-group ">
                                                    <label>Name</label>
                                                    <label class="reqireLbl"> * </label>
                                                    <img src="../img/ajax-loaders/ajax-loader-1.gif" id="ajax_img_lod" />
                                                    <input type="text" class="form-control customerName" name="cname" required />
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>District</label>
                                                        <label class="reqireLbl"> * </label>
                                                        <select class="form-control district" name="district">
                                                            <option selected>Select District</option>
                                                            <?php
                                                            $sql_getDistrict = $mysqli->query("SELECT district FROM web_regions GROUP BY district");
                                                            while ($getDistrict = $sql_getDistrict->fetch_array()) {
                                                                echo '<option>' . $getDistrict['district'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>City</label>
                                                        <label class="reqireLbl"> * </label>
                                                        <select class="form-control city" name="city">
                                                            <option selected>Select City</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group ">
                                                    <label>Address</label>
                                                    <label class="reqireLbl"> * </label>
                                                    <input type="text" name="address" class="form-control address" required />
                                                </div>
                                                <div class="form-group ">
                                                    <label>Area/Type</label>
                                                    <input class="form-control input-sm length area_name" type="text" id="area_name" name="area_name" list="area_nam">

                                                    <datalist id="area_nam">
                                                        <?php
                                                        $qry_area = $mysqli->query("SELECT distinct `area` FROM `custtable`");
                                                        while ($exc_qry = $qry_area->fetch_array()) {
                                                            echo '<option value="' . $exc_qry[0] . '">' . $exc_qry[0] . '</option>';
                                                        }
                                                        ?>
                                                    </datalist>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Credit Limit</label>
                                                        <input type="number" class="form-control cashTxt" style="text-align:right " name="creditLmt" />
                                                    </div>

                                                    <div class="form-group col-md-3" <?php echo $hideField; ?>>
                                                        <label>Due Days</label>
                                                        <input type="number" class="form-control dueDays" style="text-align:right " name="dueDays" />
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3" <?php echo $hideField; ?>>
                                                        <label>Bill to Bill</label>
                                                        <input type="number" class="form-control billtobill" style="text-align:right " name="billtobill" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>SMS Mobile</label>
                                                    <label class="reqireLbl"> * </label>
                                                    <input type="tel" name="telphone" class="form-control telphone" placeholder="0771234567, 07712355478" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" title="Add multiple numbers with comma" required />
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Fax</label>
                                                        <input type="tel" name="fax" class="form-control fax" placeholder="021 243 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12" />
                                                    </div>
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Email</label>
                                                        <input type="email" id="cusEmail" class="form-control cusEmail" name="cusEmail" placeholder="exsample@alax.lk" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" />
                                                    </div>
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Year of Establishment</label>
                                                        <input type="number" id="yearEst" class="form-control yearEst" name="yearEst" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Field of Business</label>
                                                        <select name="businessF[]" id="businessF" class="selectpicker businessF" data-live-search="true" multiple>
                                                            <option value="Electronics">Electronics</option>
                                                            <option value="Cosmetics">Cosmetics</option>
                                                            <option value="Baby Items">Baby Items</option>
                                                            <option value="Phone Accessories">Phone Accessories</option>
                                                            <option value="Fashion and Apparel">Fashion and Apparel</option>
                                                            <option value="Home and Kitchen Appliances">Home and Kitchen Appliances</option>
                                                            <option value="Sports and Fitness Equipment">Sports and Fitness Equipment</option>
                                                            <option value="Books and Stationery">Books and Stationery</option>
                                                            <option value="Automotive Parts and Accessories">Automotive Parts and Accessories</option>
                                                            <option value="Health and Wellness Products">Health and Wellness Products</option>
                                                            <option value="Pet Supplies">Pet Supplies</option>
                                                            <option value="Jewelry and Accessories">Jewelry and Accessories</option>
                                                            <option value="Toys and Games">Toys and Games</option>
                                                            <option value="Home Décor and Furnishings">Home Décor and Furnishings</option>
                                                            <option value="Outdoor and Camping Gear">Outdoor and Camping Gear</option>
                                                            <option value="Art and Craft Supplies">Art and Craft Supplies</option>
                                                            <option value="Food and Beverage Products">Food and Beverage Products</option>
                                                            <option value="Office Supplies and Equipment">Office Supplies and Equipment</option>
                                                            <option value="Musical Instruments">Musical Instruments</option>
                                                            <option value="Gardening Tools and Supplies">Gardening Tools and Supplies</option>-->
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Salesman </label>
                                                        <select name="salRep[]" id="salRepID" class="form-control salRepID selectpicker" data-live-search="true" multiple style="padding-top: 4px;">
                                                            <option></option>';
                                                            <?php
                                                            $sql_slRep = $mysqli->query("SELECT ID, Name FROM salesrep WHERE `br_id`='$br_id' ");
                                                            while ($slRep = $sql_slRep->fetch_array()) {
                                                                echo '<option value="' . $slRep['ID'] . '">' . $slRep['Name'] . '</option>';
                                                            }
                                                            ?>
                                                            echo '
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>DIscount %</label>
                                                        <input type="number" class="form-control cusDis" style="text-align:right " name="cusDis" />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Dealer Code</label>
                                                        <input type="text" name="Dcode" class="form-control Dcode" placeholder="00001" title="Type Dealer Code" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Customer Type</label>
                                                        <select type="text" name="cusType" class="form-control cusType" title="Type Dealer Code">
                                                            <option value="customer">Customer</option>
                                                            <option value="dealer">Dealer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-check" <?php echo $hideField; ?>>
                                                    <input type="checkbox" class="form-check-input active" style="text-align:right " name="active" id="active" value="YES" checked />
                                                    <label class="form-check-label">Active</label>

                                                </div>
                                                <div class="form-group">
                                                    <label>Remarks</label>
                                                    <textarea name="cusRemarks" class="form-control cusRemarks" />
                                                    </textarea>
                                                </div>






                                            </div>
                                        </div>
                                        <div class="x_content tab-pane fade" id="menu1">

                                            <div class="box-content ajaxContent">
                                                <div align="center"> <img src="../img/ajax-loaders/ajax-loader-5.gif" id="ajax_img_lod_cusDetil" /> </div>
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <label>Title</label>
                                                        <select name="cTitle" id="cTitle" class="form-control cTitle">
                                                            <option value="Mr">Mr</option>
                                                            <option value="Mrs">Mrs</option>
                                                            <option value="Ms">Ms</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-9">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control cName" id="cName" name="cName" />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Contact No</label>
                                                        <input type="text" class="form-control cNo" id="cNo" name="cNo" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Designation</label>
                                                        <select name="cDesignation" id="cDesignation" class="form-control cDesignation">
                                                            <option value="Director">Director</option>
                                                            <option value="Partner">Partner</option>
                                                            <option value="Accountant">Accountant</option>
                                                            <option value="Staff">Staff</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Email</label>
                                                        <input type="text" class="form-control cEmail" id="cEmail" name="cEmail" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>DOB</label>
                                                        <input type="date" class="form-control cDob" id="cDob" name="cDob" />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-md-10">
                                                        <label>Remarks</label>
                                                        <input type="text" class="form-control cRemarks" id="cRemarks" name="cRemarks" />
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>&nbsp;</label>
                                                        <input type="button" value="Add" class="btn btn-success btn-xs addContact" id="addContact" />
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Name</th>
                                                                <th>Contact</th>
                                                                <th>Email</th>
                                                                <th>Designation</th>
                                                                <th>DOB</th>
                                                                <th>Remarks</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="contactTable">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="x_content tab-pane fade" id="menu2">

                                            <div class="box-content ajaxContent">
                                                <div align="center"> <img src="../img/ajax-loaders/ajax-loader-5.gif" id="ajax_img_lod_cusDetil" /> </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Telephone</label>
                                                        <input type="text" name="moblNo" class="form-control moblNo" placeholder="011 773 5467" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12" title="Ten digits code" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Business Type</label>
                                                        <select name="cus_deal_typ2[]" id="cus_deal_typ2" class="cus_deal_typ2 selectpicker" data-live-search="true" multiple>
                                                            <option value="Retail">Retail</option>
                                                            <option value="Wholesale">Wholesale</option>
                                                            <option value="Distribution">Distribution</option>
                                                            <option value="Manufacture">Manufacture</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>DOB</label>
                                                        <input type="date" name="cusDob" class="form-control cusDob" id="cusDob">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Discount Level</label>
                                                        <select name="disLevl" id="discnLevl" class="form-control discnLevl">
                                                            <option> None</option>
                                                            <option value="Level 1">Level 1</option>
                                                            <option value="Level 2">Level 2</option>
                                                            <option value="Level 3">Level 3</option>
                                                            <option value="Level 4">Level 4</option>
                                                            <option value="Level 5">Level 5</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Joined Date</label>
                                                        <div class="controls" style="margin-bottom: 40px;margin-left: -10px; ">
                                                            <div align="left" class="col-sm-10 input-append date datePicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">

                                                                <input size="16" type="text" name="createDate" id="createDate" class="form-control createDate" value="<?php echo date('Y-m-d') ?>" readonly class="form-control" style="width:130%; border-radius: 5px; background-color:#fff; height:30px" />
                                                                <span class="add-on"><i class="icon-th"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="cusSource">Customer Source</label>
                                                            <input type="text" id="source_from" name="source_from" list="source_from-list" Class="form-control">
                                                            <datalist id="source_from-list">
                                                                <?php
                                                                    $sql_src = $mysqli->query("SELECT source_from FROM custtable WHERE br_id = '$br_id' GROUP BY source_from");
                                                                    while($sorc = $sql_src->Fetch_assoc()){
                                                                        echo '<option value="'.$sorc['source_from'].'">';
                                                                    }
                                                                ?>
                                                                
                                                            </datalist>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Introduced By</label>
                                                        <select name="introBy" id="introBy" class="selectpicker form-control introBy" data-live-search="true">
                                                            <option> None</option>
                                                            <?php
                                                            $sql_custoemrs = $mysqli->query("SELECT ID, cusName FROM custtable WHERE br_id = '$br_id'");
                                                            while ($customers = $sql_custoemrs->fetch_assoc()) {
                                                                echo '
                                                                <option value="' . $customers['ID'] . '">' . $customers['cusName'] . '</option>
                                                                ';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12 hidden" <?php echo $hideField; ?>>
                                                        <label>Price</label>
                                                        <input type="number" class="form-control txt_price" name="txt_price" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Cus.VAT</label>
                                                        <input type="checkbox" class="form-check-input chk_vat" style="margin-left:10px; vertical-align: middle;" name="chk_vat" />
                                                        <input type="text" class="form-control txt_Vno" name="txt_Vno" placeholder="VAT NO" hidden />
                                                    </div>
                                                    <div class="form-group col-md-6" <?php echo $hideField; ?>>
                                                        <label>Star Points %</label>
                                                        <input type="number" class="form-control txt_starP" name="txt_starP" placeholder="Star Points" />
                                                    </div>
                                                </div>
                                                <div class="form-group " <?php echo $hideField; ?>>
                                                    <label>Bank Details</label>
                                                    <input type="text" class="form-control txt_BKdet" name="txt_BKdet" placeholder="Bank Details" />
                                                </div>
                                                <div class="form-group hidden">
                                                    <label>Owner Name</label>
                                                    <input type="text" class="form-control txt_owner" name="txt_owner" placeholder="Owner Name" />
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 hidden">
                                                        <label>Owner NIC</label>
                                                        <input type="text" name="othrName" class="form-control ownerNIC" />
                                                    </div>
                                                    <div class="form-group col-md-6 hidden">
                                                        <label>Owner Date of Birth</label>
                                                        <input type="date" class="form-control txt_owner_bod" name="txt_owner_bod" />
                                                    </div>
                                                </div>
                                                <div class="form-group hidden" <?php echo $hideField; ?>>
                                                    <label>Pur.Officer Name</label>
                                                    <input type="text" class="form-control txt_pur_office" name="txt_pur_office" placeholder="Purchase Officer Name" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align:right">
                                        <button class="btn btn-success btn-xs saveData" type="button">Save</button>
                                        <button class="btn btn-danger btn-xs deleteCus" type="button" style="display:none;">Delete</button>
                                        <button class="btn btn-success btn-xs updateCus" type="button" style="display:none;">Update</button>
                                        <?php
                                        if ($hideField == '') {
                                            echo '<button class="btn btn-success btn-xs addBlnc" style="display:none;" type="button" >Add Balance</button>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </form>

    <!-- Start Modal of Beginning Balance -->
    <div class="modal" id="balncModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3 id='begBlncH3'> Beginning Balance </h3>
                </div>
                <form action="" method="post" id="begBancForm" />
                <div class="modal-body">
                    <p align="center">

                    <table class="table table-striped table-bordered custmCretTB">
                        <tbody>

                            <tr>
                                <td>Type</td>
                                <td>
                                    <select class="TypeBeg" name="TypeBeg">
                                        <option>Cash</option>
                                        <option>Cheque Return</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="myBrgTyp"></td>
                            </tr>


                            <tr>
                                <td>Date </td>
                                <td>
                                    <div class="controls" style="padding-top:0px;margin-bottom:5px;margin-left:-15px">
                                        <div align="left" class="col-sm-10 input-append date datePicker" data-date="" data-date-format="yyyy-mm-dd" data-link-field="bil_date" data-link-format="yyyy-mm-dd">
                                            <input size="16" type="text" name="blncDate" id="" value="<?php echo date('Y-m-d') ?>" required readonly class="form-control" style="width:80px; border-radius: 0px;" />
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>Customer ID </td>
                                <td>
                                    <input type="text" id="custIDHidnBal" name="custIDHidnBal" readonly value="" />
                                    <input type="hidden" id="nameHiddn" name="nameHiddn" value="" />

                                </td>
                            </tr>

                            <tr>
                                <td>Salesman </td>
                                <td>
                                    <select class="salsRep" name="SLMAN" id="SLMAN" style="padding-top: 4px;" />
                                    <option value=""></option>
                                    <?php
                                    $sql_slman = $mysqli->query("SELECT ID, Name, RepID FROM salesrep WHERE br_id='$br_id' ");
                                    while ($slman = $sql_slman->fetch_array()) {
                                        echo '<option value="' . $slman['ID'] . ',' . $slman['RepID'] . '">' . $slman['Name'] . '</option>';
                                    }
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Dealer Code </td>
                            </tr>

                            <tr>
                                <td>Ref. No</td>
                                <td>
                                    <input type="text" name="refNo" id="refNo" required /><br>
                                    <span style="color:red; display:none;" id="quotationDiv">Quotation marks not allowed.</span>

                                </td>
                            </tr>

                            <tr>
                                <td>Amount</td>
                                <td>
                                    <input type="number" name="blncAmnt" id="blncAmnt" style="text-align:right" required />

                                    <?php
                                    // $hideopt_qry = $mysqli->query("SELECT  `HideOption` FROM `optioncus` WHERE `br_id`='$br_id'");
                                    // $hideopt_arr = $hideopt_qry->fetch_array();
                                    // $hideopt = $hideopt_arr[0];

                                    $sql_isHidn =  $mysqli->query("SELECT HideOption FROM optioncus WHERE br_id='$br_id'");
                                    $res_isHidn = $sql_isHidn->fetch_array();
                                    //$isHid = (trim($res_isHidn[0]) === 'N') ? 'checked' : '';

                                    $swHD_rht = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
                                    `user_id` ='$user_id' AND `page_title` ='control_Control INV Show/Hide' AND `user_rights`.`br_id`='$br_id'");
                                    $count_swHD_rht = $swHD_rht->num_rows;

                                    $invShow = '';
                                    if ($user_type == 'Admin' || $count_swHD_rht > 0) {
                                        $invShow = ' ';
                                    } else {
                                        $invShow = ' hidden ';
                                    }

                                    if (trim($res_isHidn[0]) === 'N') {
                                        if ($view_type == 'Show') {
                                            $isHid = 'checked';
                                        } else {
                                            $isHid = '';
                                        }
                                    } else {
                                        $isHid = (trim($res_isHidn[0]) == 'S') ? 'checked' : '';
                                    }

                                    //                 if ($hideopt == 'N') {
                                    //                     echo '<label id="c_box" class="checkbox-inline rebate">
                                    // 			<input type="checkbox" name="chk_show" id="chk_show" class="chk_show" value="SHOW" checked />
                                    //  </label>';
                                    //                 } else {
                                    //                     echo '<label id="c_box" class="checkbox-inline rebate">
                                    // 			<input type="checkbox" name="chk_show" id="chk_show" class="chk_show" value="SHOW"  />
                                    //  </label>';
                                    //                 }


                                    ?>
                                    <label id="c_box" class="checkbox-inline rebate">
                                        <input type="checkbox" name="chk_show" id="chk_show" class="chk_show" value="SHOW" <?php echo $isHid;
                                                                                                                            echo $invShow;  ?> />
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" name="" id="procBtn">Proceed</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--end of Modal of Beginning Balance -->

    <!-- Start of warning -->
    <div id="creatCusMsg" style="display:none;">
        <div class="errConfrmHaed"> Warning ! </div>
        <span style="color:#F00" id="responseSpan"> </span>
        <br />

        <button type="button" class="btn btn-default blockUIClosBtn" />Ok</button>
    </div>
    <!--end of warning -->



    <div class="mybody" style="display:none">
        <table class="table">
            <tr>
                <td colspan="2">
                    Journal
                    <input type="radio" class="radiotyp" id="typeSearchIDJ" name="typeSearchT" value="Journal" checked />
                    Vendor
                    <input type="radio" class="radiotyp" id="typeSearchIDV" name="typeSearchT" value="Vendor" />

                </td>
            </tr>
            <tr class="typeSearchIDJ ssearchtype">
                <td>Journal</td>
                <td>
                    <select class="TypeBegJ" name="TypeBegJ">
                        <?php
                        $get_jouenal = $mysqli->query("SELECT Description, journal.ID, Bank FROM journal JOIN branch ON
                                         journal.BranchCODE = branch.BrCode WHERE BankCODE != ''  
                                         AND  journal.br_id='$br_id' AND journal.BankCODE = branch.BCode");

                        while ($v = $get_jouenal->fetch_array()) {
                            echo '<option  value="' . $v['ID'] . '">' . $v['Bank'] . ' - ' . $v['Description'] . '</option>';
                            # code...
                        }

                        ?>
                    </select>

                </td>
            </tr>

            <tr class="typeSearchIDV ssearchtype" style="display:none">
                <td>Vendor</td>
                <td>

                    <select class="TypeBegV" name="TypeBegV">
                        <?php
                        $get_Vendor = $mysqli->query("SELECT `ID`, `VendorID`, `CompanyName` From vendor ");
                        while ($v = $get_Vendor->fetch_array()) {
                            echo '<option  value="' . $v['ID'] . '">' . $v['VendorID'] . ' - ' . $v['CompanyName'] . '</option>';
                            # code...
                        }

                        ?>
                    </select>

                </td>
            </tr>
        </table>
    </div>
    </div>
    </div>
    <?php include($path . 'footer.php') ?>
    <script type="text/javascript">
        $('.selectpicker').select2();

        $('.datePicker').datetimepicker({
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

    <script>
        $(document).ready(function() {
            loadTable();
        });

        function loadTable() {
            if ($('.cus_all').is(':checked')) {
                var chkOption = 'ALL';
            } else {
                var chkOption = 'BR';
            }
            $('#example').DataTable().destroy();
            $('#example').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                    }
                },
                "bProcessing": true,
                "serverSide": true,
                "ajax": {
                    url: "ajx/loadDataTable.php", // json datasource
                    type: "post",
                    data: {
                        'chk': chkOption,
                    },

                    error: function() { // error handling code

                    }

                }

            });
        }
    </script>


    <script>
        $('body').on('keypress', 'input', function(evt) {
            if (evt.keyCode == 13) {

                iname = $(this).cla
                if (iname !== 'Submit') {
                    var fields = $(this).parents('form:eq(0),body').find('button, input, textarea, select');
                    var index = fields.index(this);
                    if (index > -1 && (index + 1) < fields.length) {
                        fields.eq(index + 1).focus();
                    }
                    return false;
                }

            }
        });


        $(document).on('click', '.chk_vat', function() {
            if ($(".chk_vat").is(':checked')) {
                $('.txt_Vno').show();
            } else {
                $('.txt_Vno').hide();
                $('.txt_Vno').val('');
            }


        });

        // cus_all
        $('body').on('click', '.cus_all', function() {
            loadTable();
        });

        $('body').on('click', '.custDetil', function() {
            $('.send_mail').removeClass('disabled');
            $('.send_mail').addClass('disabled');
            var cusID = $(this).attr('value');
            $('#ajax_img_lod_cusDetil').show();
            $.ajax({
                url: 'ajx/custmerEdit.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    cus: cusID,
                    btn: 'LoadData'
                },
                success: function(data) {
                    $('#ajax_img_lod_cusDetil').hide();

                    $('.custIDHidn').val(data.cusDetail.ID);
                    $('.customerID').val(data.cusDetail.CustomerID);
                    $('.customerName').val(data.cusDetail.cusName);
                    $('#source_from').val(data.cusDetail.source_from)
                    $('.cusDob').val(data.cusDetail.DOB);
                    $('.cusDis').val(data.cusDetail.backup);
                    $('.address').val(data.cusDetail.Address);
                    $('.area_name').val(data.cusDetail.area);
                    $('.cashTxt').val(data.cusDetail.CreditLimit);
                    $('.dueDays').val(data.cusDetail.due_days);
                    $('.billtobill').val(data.cusDetail.billtobill);
                    $('.discnLevl').val(data.cusDetail.DiscLevel);
                    $('.telphone').val(data.cusDetail.TelNo);
                    $('.fax').val(data.cusDetail.FaxNo);
                    $('.cusEmail').val(data.cusDetail.EmailNo);

                    $('.Dcode').val(data.cusDetail.dealerCode);
                    $('.moblNo').val(data.cusDetail.MobNo);

                    $('.createDate').val(data.cusDetail.Date);
                    $('.ownerNIC').val(data.cusDetail.OtherName);
                    $('.txt_price').val(data.cusDetail.cus_price);
                    $('.txt_Vno').val(data.cusDetail.vatNo);
                    $('.txt_starP').val(data.cusDetail.cus_starPoint);
                    $('.txt_BKdet').val(data.cusDetail.bank_det);
                    $('.txt_owner').val(data.cusDetail.owner);
                    $('.txt_owner_bod').val(data.cusDetail.owner_dob);
                    $('.txt_pur_office').val(data.cusDetail.pur_officer);
                    $('.district').val(data.cusDetail.districtName);
                    $('.cusRemarks').val(data.cusDetail.cusRemarks);
                    $('.cusType').val(data.cusDetail.CustType);
                    $('.introBy').val(data.cusDetail.introduced_by).trigger('change');

                    $('.yearEst').val(data.cusDetail.y_estbl);
                    var business_fields = data.cusDetail.business_field;

                    if (business_fields !== null) {
                        var business_field = business_fields.split(',');
                        $('.businessF').val(business_field).trigger("change");
                    }
                    $('.salRepID').val('');
                    var valuesToAdd = data.repId;
                    var $select = $('#salRepID');
                    var currentValues = $select.val() || [];
                    valuesToAdd.forEach(function(rep) {
                        currentValues.push(rep.rep_id);
                    });
                    $select.val(currentValues);
                    $select.trigger('change');


                    var new_cus_types = data.cusDetail.new_cus_type;
                    if (new_cus_types !== null) {
                        var new_cus_type = new_cus_types.split(',');
                        $('.cus_deal_typ2').val(new_cus_type).trigger('change');
                    }


                    $('#contactTable').html('')
                    data.contact.forEach(function(item) {
                        $('#contactTable').append(`
            <tr>
                <td>` + item.nameTitle + `<input type="hidden" value="` + item.nameTitle + `" name="cTitleArr[]" id="cTitleArr" class="cTitleArr"></td>
                <td>` + item.contactName + `<input type="hidden" value="` + item.contactName + `" name="cNameArr[]" id="cNameArr" class="cNameArr"></td>
                <td>` + item.contactNo + `<input type="hidden" value="` + item.contactNo + `" name="cNoArr[]" id="cNoArr" class="cNoArr"></td>
                <td>` + item.designation + `<input type="hidden" value="` + item.designation + `" name="cDesignationArr[]" id="cDesignationArr" class="cDesignationArr"></td>
                <td>` + item.contactEmail + `<input type="hidden" value="` + item.contactEmail + `" name="cEmailArr[]" id="cEmailArr" class="cEmailArr"></td>
                <td>` + item.contactDOB + `<input type="hidden" value="` + item.contactDOB + `" name="cDobArr[]" id="cDobArr" class="cDobArr"></td><td></td>
                <td>` + item.remarks + `<input type="hidden" value="` + item.remarks + `" name="cRemarksArr[]" id="cRemarksArr" class="cRemarksArr"></td>
                <td><i class="fa fa-trash contactDelete" style="color:red; cursor:pointer;"></i> | <i class="fa fa-edit editContact" cRemarks="` + item.remarks + `" cDob="` + item.contactDOB + `" cEmail="` + item.contactEmail + `" cDesignation="` + item.designation + `" cNo="` + item.contactNo + `" cName="` + item.contactName + `" cTitle="` + item.nameTitle + `" style="color:blue; cursor:pointer;"></i></td>
            </tr>
            `);
                    })

                    loadCity(data.cusDetail.cityName);

                    if (data.cusDetail.Active2 == 'YES') {
                        $('.active').prop("checked", true);
                    } else {
                        $('.active').prop("checked", false);
                    }

                    if (data.cusDetail.vatNo != '') {
                        $('.txt_Vno').show();
                        $('.chk_vat').prop("checked", true);
                    } else {
                        $('.txt_Vno').hide();
                        $('.chk_vat').prop("checked", false);
                    }

                    $('.saveData').hide();
                    $('.addBlnc').show();
                    $('.updateCus').show();
                    $('.deleteCus').show();

                    setTimeout(function() {
                        if ($.trim($('#ordEmail').val()) !== '') {
                            if (ValidateEmail($.trim($('#ordEmail').val())) == true) {
                                $('.send_mail').removeClass('disabled');
                            }

                        }
                    }, 100);
                }
            });
        });

        $(document).on('change', '.district', function() {
            loadCity('');
        });

        function loadCity(citySelect) {
            var district = $('.district').val();

            if (district != '') {
                $.ajax({
                    url: 'ajx/custmerEdit.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        district: district,
                        btn: 'LoadCity',
                        citySelect: citySelect
                    },
                    success: function(data) {
                        $('.city').html(data.cityHtml);
                    }
                });
            }
        }

        $(document).on('click', '.saveData', function() {
            var count = requFiledValidte();
            if (count == 5) {

                var cusMail = $('#cusEmail').val();
                if ($.trim(cusMail) !== '') {

                    if (ValidateEmail($.trim(cusMail)) == true) {
                        saveCus();
                    } else {
                        emailFail();
                    }

                } else {
                    saveCus();
                }

            }

        });


        $(document).on('click', '.radiotyp', function() {
            var id = $(this).attr('id');
            $('.ssearchtype').css('display', 'none');
            $('.' + id).css('display', 'table-row');

        });

        $(document).on('change', '.TypeBeg', function() {

            $('.myBrgTyp').html('');
            if ($(this).val() != 'Cash') {
                var mybody = $('.mybody').html();
                $('.myBrgTyp').html(mybody);
                $('.ssearchtype').css('display', 'none');
                $('.typeSearchIDJ').css('display', 'table-row');
            }


        });



        $(document).on('click', '.updateCus', function() {
            var count = requFiledValidte();
            var cusHiddnID = $('#custIDHidn').val();
            if (cusHiddnID.trim()) {

                if (count == 5) {
                    var cusMail = $('#cusEmail').val();
                    if ($.trim(cusMail) !== '') {

                        if (ValidateEmail($.trim(cusMail)) == true) { //$.trim(cusMail)				
                            $('#cusCreate').submit();
                        } else {
                            emailFail();
                        }

                    } else {
                        $('#cusCreate').submit();
                    }
                }

            } else {

                $('#responseSpan').html('Please select a valid Customer');
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
        });


        $(document).on('click', '.blockUIClosBtn', function(e) {
            setTimeout($.unblockUI, 300);
            if ($(this).data("value") == "cusMail") {
                $('#cusEmail').focus();
            } else if ($(this).data("value") == "refNo") {
                $('#balncModal').modal("show");
                $('#refNo').focus();
            }

        });

        $(document).on('focus ', ':input', function() {
            $(this).select();
        });

        function emailFail() {
            $('.blockUIClosBtn').data("value", "cusMail");
            $('#responseSpan').html('Email address does not valid');
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

        function saveCus() {
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });

            $.ajax({
                url: 'ajx/custmerSave.php',
                data: $('#cusCreate').serialize(),
                type: 'POST',
                success: function(data) {
                    if (data.trim() == 'Ok') {
                        window.location = 'create_Customer.php';
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

        function requFiledValidte() {
            var countValid = 0;
            $(':input[required]', '#cusCreate').each(function() {
                if (this.value.trim() !== '') {
                    countValid++;
                } else {
                    $(this).focus();
                    $(this).css('border', '1px solid red');
                    return false;
                }
            });
            return countValid;
        }

        function ValidateEmail(email) {
            var expr =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            return expr.test(email);
        }

        $(document).on('click', '.addBlnc', function() {
            $('#balncModal').modal("show");
            $('#begBlncH3').html('Beginning Balance  - ' + $('.customerName').val());
            $('#custIDHidnBal').val($('.customerID').val());
            $('#nameHiddn').val($('.customerName').val());
            $('#refNo').focus();
        });

        /*
        $(document).on('click', '.Qr_allPrint', function() {
            var Start = $.trim($('#Start').val());
            var End = $.trim($('#End').val());
            if (Start.length != 0 && End.length != 0) {
                alert(Start.length);
                window.open("myQR/php/?php echo $print ?>?Start=" + Start + "&&End=" + End, "myWindowName",
                    "width=595px, height=842px");
            } else {
                alert('Please type Row Start & End ...');
            }

        });*/


        $(document).on('click', '#procBtn', function() {
            var countValid = 0;
            $(':input[required]', '#begBancForm').each(function() {
                if (this.value.trim() !== '') {
                    countValid++;
                } else {
                    $(this).focus();
                    return false;
                }
            });

            if (countValid == 3) {
                $.blockUI({
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });

                $.ajax({
                    url: 'ajx/custmerBalnc.php',
                    data: $('#begBancForm').serialize(),
                    type: 'POST',
                    success: function(data) {
                        if (data.trim() == 'Ok') {
                            window.location = 'create_Customer.php';
                        } else {
                            $('#balncModal').modal("hide");
                            $('.blockUIClosBtn').data("value", "refNo");
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

        });




        $(document).on('click', '.send_mail', function() {


            //alert('gfbnhhnclick');
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });

            $.ajax({
                url: 'ajx/send_link.php',
                data: $('#cusCreate').serialize(),
                type: 'POST',
                success: function(data) {
                    if (data.trim() == 'Ok') {
                        window.location = 'create_Customer.php';
                    } else {

                        $('.blockUIClosBtn').data("value", "cusAcnt");
                        $('#responseSpan').html(data.trim());
                        $.blockUI({
                            message: $('#creatCusMsg')
                        });
                        $('.blockMsg').css({
                            'background': '#fff',
                            'border-radius': '10px',
                            'border': '#fff 3px',
                            'box-shadow': '0 3px 7px rgba(0, 0, 0, 0.3)',
                            'backgrsend_linkound-clip': 'padding-box'
                        });
                    }
                }
            });


        });

        /*
        $(document).on('click', '#GnrtQR', function() {
            var customerID = $('.customerID').val();

            window.open("myQR/php/<?php echo $print; ?>?customerID=" + customerID, "myWindowName",
                "width=595px, height=842px");
        });*/

        var d_array = [{
                month: '01',
                days: 31
            },
            {
                month: '02',
                days: 29
            },
            {
                month: '03',
                days: 31
            },
            {
                month: '04',
                days: 30
            },
            {
                month: '05',
                days: 31
            },
            {
                month: '06',
                days: 30
            },
            {
                month: '07',
                days: 31
            },
            {
                month: '08',
                days: 31
            },
            {
                month: '09',
                days: 30
            },
            {
                month: '10',
                days: 31
            },
            {
                month: '11',
                days: 30
            },
            {
                month: '12',
                days: 31
            },
        ];

        $(document).on('keyup', '.ownerNIC', function() {

            var nicNumber = $('.ownerNIC').val();

            if (nicNumber.length === 10) {
                var year = nicNumber.substr(0, 2);
                year = '19' + year;
                var days = nicNumber.substr(2, 3);
            } else if (nicNumber.length === 12) {
                var year = nicNumber.substr(0, 4);
                var days = nicNumber.substr(4, 3);
            }

            var dayList = days;
            var month = '';

            for (var i = 0; i < d_array.length; i++) {
                if (d_array[i]['days'] < dayList) {
                    dayList = dayList - d_array[i]['days'];
                } else {
                    month = d_array[i]['month'];
                    break;
                }
            }

            var day = ('0' + dayList).slice(-2);
            var bday = year + '-' + month + '-' + day;
            var todayYear = '<?php echo date('Y'); ?>';
            var maximumYear = parseFloat(todayYear) - parseFloat(70);
            var minimumYear = parseFloat(todayYear) - parseFloat(17);
            if (typeof year !== 'undefined' && year > maximumYear && year < minimumYear) {
                $('.txt_owner_bod').val(bday);
            }

        });

        $(document).on('click', '.deleteCus', function() {
            if (confirm('Aru you sure that you wanted to delete this customer?')) {
                var formData = new FormData($('#cusCreate')[0]);
                formData.append("ajaxType", "deleteCus");

                $.ajax({
                    type: "POST",
                    url: "ajx/custmerEdit.php",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.status == 200) {
                            location.reload();
                        } else {
                            alert(res.message);
                        }

                    }
                });
            }


        });

        $(document).ready(function() {
            $("#refNo").on("keypress", function(event) {
                var keycode = event.keyCode || event.which;
                if (keycode === 34 || keycode === 39) { // 34 is the keycode for double quotation mark, 39 is the keycode for single quotation mark
                    event.preventDefault();
                    $('#quotationDiv').show()
                } else {
                    $('#quotationDiv').hide()
                }
            });
        });

        $(document).on('click', '#contactDiv', function() {
            $('#contactDiv1').show()
            $('#basicDiv1').hide()
            $('#extraDiv1').hide()

        });
        $(document).on('click', '#extraDiv', function() {
            $('#extraDiv1').show()
            $('#basicDiv1').hide()
            $('#contactDiv1').hide()

        });
        $(document).on('click', '#basicDiv', function() {
            $('#basicDiv1').show()
            $('#extraDiv1').hide()
            $('#contactDiv1').hide()

        });

        $(document).on('click', '.addContact', function() {

            var cTitle = $('#cTitle').val();
            var cName = $('#cName').val();
            var cNo = $('#cNo').val();
            var cDesignation = $('#cDesignation').val();
            var cEmail = $('#cEmail').val();
            var cDob = $('#cDob').val();
            var cRemarks = $('#cRemarks').val();
            if (cName != '') {
                $('#contactTable').append(`
            <tr>
                <td>` + cTitle + `<input type="hidden" value="` + cTitle + `" name="cTitleArr[]" id="cTitleArr" class="cTitleArr"></td>
                <td>` + cName + `<input type="hidden" value="` + cName + `" name="cNameArr[]" id="cNameArr" class="cNameArr"></td>
                <td>` + cNo + `<input type="hidden" value="` + cNo + `" name="cNoArr[]" id="cNoArr" class="cNoArr"></td>
                <td>` + cDesignation + `<input type="hidden" value="` + cDesignation + `" name="cDesignationArr[]" id="cDesignationArr" class="cDesignationArr"></td>
                <td>` + cEmail + `<input type="hidden" value="` + cEmail + `" name="cEmailArr[]" id="cEmailArr" class="cEmailArr"></td>
                <td>` + cDob + `<input type="hidden" value="` + cDob + `" name="cDobArr[]" id="cDobArr" class="cDobArr"></td><td></td>
                <td>` + cRemarks + `<input type="hidden" value="` + cRemarks + `" name="cRemarksArr[]" id="cRemarksArr" class="cRemarksArr"></td>
                <td><i class="fa fa-trash contactDelete" style="color:red; cursor:pointer;"></i> | <i class="fa fa-edit editContact" cRemarks="` + cRemarks + `" cDob="` + cDob + `" cEmail="` + cEmail + `" cDesignation="` + cDesignation + `" cNo="` + cNo + `" cName="` + cName + `" cTitle="` + cTitle + `" style="color:blue; cursor:pointer;"></i></td>
            </tr>
            `);
                $('#cTitle').val('');
                $('#cName').val('');
                $('#cNo').val('');
                $('#cDesignation').val('');
                $('#cEmail').val('');
                $('#cDob').val('');
                $('#cRemarks').val('');
            } else {
                alert("At least the Name is required!");
            }



        });

        $(document).on('click', '.contactDelete', function() {
            $(this).parent().parent().remove()

        });

        $(document).on('keyup', '.telphone', function() {
            var contact = $(this).val();
            var thisBox = $(this);
            $('.telphone').css('background-color', '');

            $.ajax({
                type: "POST",
                url: "ajx/contactAjx.php",
                data: {
                    'btn': 'contactBtn',
                    'contactcode': contact
                },
                dataType: "json",
                success: function(res) {
                    if (res.status == 200 && res.status != '') {
                        $('.telphone').css('background-color', '#FFE4C4');
                    } else {
                        $('.telphone').css('background-color', '');
                    }
                }
            });
        });

        $(document).on('click', '.editContact', function() {
            var cTitle = $(this).attr('cTitle');
            var cName = $(this).attr('cName');
            var cNo = $(this).attr('cNo');
            var cDesignation = $(this).attr('cDesignation');
            var cEmail = $(this).attr('cEmail');
            var cDob = $(this).attr('cDob');
            var cRemarks = $(this).attr('cRemarks');

            $('#cTitle').val(cTitle);
            $('#cName').val(cName);
            $('#cNo').val(cNo);
            $('#cDesignation').val(cDesignation);
            $('#cEmail').val(cEmail);
            $('#cDob').val(cDob);
            $('#cRemarks').val(cRemarks);

            $(this).parent().parent().remove()



        });

        var customerSources = ["Online", "Referral", "Walk-in", "Social Media", "Advertisement"];

        // Initialize autocomplete
        $(document).ready(function() {
            $("#cusSource").autocomplete({
                source: customerSources
            });
        });

        $('#at_id').click(function() {
                        if (this.checked) {
                            // alert('OK inside');
                            var at_id = $('#at_id').val();
                            $.ajax({
                                url: 'ajx/get_cus_id.php',
                                method: 'post',
                                data: {
                                    // TYPE: request.term
                                    item: at_id
                                },
                                success: function(data) {
                                    //  response( $.data( data, function( item ) {
                                    //alert('OK inside' + data);
                                    var code = data.split('|');
                                    //alert('OK inside');
                                    var id = code[1];
                                    $('.customerID').val(id);

                                }

                            });

                        }else{
                            $('.customerID').val('');
                        }

                    });
    </script>