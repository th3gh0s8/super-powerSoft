<?php
include('path.php');
require_once  $path . '../function.php';
require_once $path . '../session_file.php'; //include($path.'../.php');
require_once $path . 'connection.php';
$source_from = $_POST['source_from'];
$cusType = $_POST['cusType'];
$cusDob = $_POST['cusDob'];
$custID = trim($_POST['custID']);
$cname = $_POST['cname'];
$address = $_POST['address'];
$creditLmt = $_POST['creditLmt'];
$disLevl = $_POST['disLevl'];
$telphone = $_POST['telphone'];
$fax = $_POST['fax'];
$cusEmail = $_POST['cusEmail'];
$moblNo = $_POST['moblNo'];
$othrName = $_POST['othrName'];
$salRep = $_POST['salRep'];
$createDate = $_POST['createDate'];
$cusDis = $_POST['cusDis'];
$cus_area = $_POST['area_name'];
$cus_price = $_POST['txt_price'];
$vat_no = $_POST['txt_Vno'];
$bk_det = $_POST['txt_BKdet'];
$dueDays = $_POST['dueDays'];
if ($_POST['cus_deal_typ2'] != '') {
	$cus_deal_typ2 = implode(",", $_POST['cus_deal_typ2']);
}

$starPoint = $_POST['txt_starP'];
$cusRemarks = $_POST['cusRemarks'];
$yearEst = $_POST['yearEst'];
if ($_POST['businessF'] != '') {
	$businessF = implode(",", $_POST['businessF']);
}

$introBy = $_POST['introBy'];

$district = $_POST['district'];
$city = $_POST['city'];
$createDate = date("Y-m-d", strtotime($createDate));
$active = ($_POST['active'] == 'YES') ? 'YES' : 'NO';
$Dcode = ($_POST['Dcode'] == '') ? $custID : $_POST['Dcode'];


$sql_approveCustomer = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
				 `user_id` ='$user_id' AND `page_title` ='control_cusCreate' AND `user_rights`.`br_id`='$br_id'");

$sql_approveCusOpt = $mysqli->query("SELECT `opertionName`, `optionPath` FROM `optiontb` WHERE `opertionName` = 'APPROVE CUSTOMER' AND optionPath = 'YES'");
if ($sql_approveCustomer->num_rows == TRUE || $sql_approveCusOpt->num_rows == TRUE) {
	$active = 'APPROVE';
}

$owner = $_POST['txt_owner'];
$owner_dob = $_POST['txt_owner_bod'];
$pur_offi = $_POST['txt_pur_office'];

$date = date('Y-m-d');
$time = date('h:i:s');

$query = $mysqli->query("SELECT * FROM custtable  WHERE CustomerID = '$custID'");
$count = $query->num_rows;

if ($count > 0) {
	echo 'This Customer ID is already exist ' . $custID;
} else {

	$sql_ins = $mysqli->query("INSERT INTO custtable (CustomerID, cusName, CustType, dealerCode, Address, BegInvNo, rep_id, CreditLimit, DiscLevel, Date, DOB, 
							EmailNo, FaxNo, MobNo, OtherName, TelNo, recordDate, recordTime, userID, cloud, mysql_db,area,br_id,cus_price,vatNo,bank_det,Active2,owner,owner_dob,pur_officer,
							due_days,new_cus_type,`cus_starPoint`, `districtName`, `cityName`, `cusRemarks`,  y_estbl, business_field, introduced_by, backup, source_from) 
							VALUES ( '$custID', '$cname', 
							'$cusType', '$Dcode', '$address', '', '$salRep[0]', '$creditLmt', '$disLevl', '$createDate', '$cusDob', '$cusEmail', '$fax', '$moblNo', 
							'$othrName', '$telphone', '$date', '$time', '$user_id', 'NEW', 'WEB','$cus_area','$br_id','$cus_price','$vat_no','$bk_det','$active','$owner','$owner_dob','$pur_offi',
							'$dueDays','$cus_deal_typ2','$starPoint', '$district', '$city', '$cusRemarks', '$yearEst', '$businessF', '$introBy', '$cusDis', '$source_from')");

	if ($sql_ins) {

		$HidnID = $mysqli->insert_id;
		// $sql_deleteContact = $mysqli->query("DELETE FROM customer_contactDet WHERE cusTb='$HidnID' AND br_id = '$br_id'");
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



		$rghts = $mysqli->query("SELECT * FROM `pages` WHERE `path` = 'create_cusFixRep' AND `userRights` = 'Y' ");
		$rhts_count = $rghts->num_rows;

		if ($rhts_count > 0) {

			$qry_route = $mysqli->query('SELECT max(`routeNo`) FROM `repcustomize`');
			$res_route = $qry_route->fetch_assoc();
			$routeNo = ($res_route[0] == '') ? 0 : $res_route[0];
			$routeNo = $routeNo + 1;
			$refNo = 'Rot-' . $routeNo;
			foreach($salRep as $salesKey => $salesTb){
				$salRep1 = $salRep[$salesKey];

			$qry_insertRep = $mysqli->query("INSERT INTO `repcustomize`(`RefNO`, `routeNo`, `br_id`, `cus_id`, `rep_id`, `route`,
			 `user_id`, `recordDate`, `recordTime`, `cloud`,`status`) 
			 VALUES ('$refNo','" . $routeNo . "','$br_id','$HidnID','$salRep1','','$user_id','$date','$time','Update','Active')");
			}
		}


		$_SESSION['succsess_msg'] = 'Customer create Process Done ! ';
		$msg = 'Ok';
	} else {
		$msg = "Error in customer create process!";
	}

	echo $msg;
}
