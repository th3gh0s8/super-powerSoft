<?php
$title = 'Item Create';

$pageRights = 'create_item';
include('path.php');

if (isset($_POST['hiddenDown'])) {

    include($path . 'connection.php');

    header('Content-Type: application/excel; ');
    header('Content-Disposition: attachment; filename=itemTB.csv');
    $output2 = fopen("php://output", "w");
    fputcsv($output2, array('ItemNO', 'Description', 'sale_pr', 'Taxt', 'Vendor'));
    $query2 = "SELECT `ItemNO`,`Description`,`sale_pr`,`Taxt`,`Vendor` FROM `itemtable` JOIN barcodes join br_stock ON `itemtable`.`ID` 
	  =barcodes.itmTbID and br_stock.itm_id=`itemtable`.ID where br_stock.br_id='$br_id' group by `itemtable`.`ItemNO`";
    $result2 = $mysqli->query($query2);
    while ($row2 = $result2->fetch_array()) {
        fputcsv($output2, $row2);
    }
    fclose($output2);
    header("Refresh:0");
    die;
}


if (isset($_POST['hiddenDownBC'])) {

    include($path . 'connection.php');

    header('Content-Type: application/excel; ');
    header('Content-Disposition: attachment; filename=barcodeTB.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('ItemID', 'BarCode', 'BarCode2', 'Date', 'InvNo', 'Status', 'RepID', 'mysql_db'));
    $query = "SELECT CONCAT('C-',ItemID),BarCode,BarCode2,Date,InvNo,Status,RepID,mysql_db FROM barcodes";
    $result = $mysqli->query($query);
    while ($row = $result->fetch_array()) {
        fputcsv($output, $row);
    }
    fclose($output);

    echo 'Itemtablefar
	  ';
    $output2 = fopen("php://output", "w");
    $query2 = "SELECT  CONCAT('C-',`ItemNO`),`Description`,`sale_pr`,`R1`,`Vendor`,CatID,`itemtable`.Date,`itemtable`.ID 
	  FROM `itemtable` JOIN barcodes join br_stock ON `itemtable`.`ID` 
	  =barcodes.itmTbID and br_stock.itm_id=`itemtable`.ID where br_stock.br_id='$br_id' group by `itemtable`.`ItemNO`,`itemtable`.`ID`  ";
    $result2 = $mysqli->query($query2);
    while ($row2 = $result2->fetch_array()) {
        fputcsv($output2, $row2);
    }
    fclose($output2);

    // echo 'ok done';
    header("Refresh:0");
    die;
}

include('includeFile.php');


$_SESSION['DB_ID'] = '';

//include($path.'../xdataDB.php');

if (isset($_SESSION['print_functn'])) {
    $windLodFunc = $_SESSION['print_functn'];
    unset($_SESSION['print_functn']);
}
//echo 'notpostback';
//	unset($itm_no2);




$date = date('Y-m-d');
$db_name2 = $_SESSION['DB'];
$itm_no2 = $_POST['itm_no2'];
$itm_no2 = trim($itm_no2);


$at_id = $_POST['at_id'];
$at_id = trim($at_id);

$itm_name = $_POST['itm_name'];
$itm_name = trim($itm_name);
$itm_name = str_replace('|', '', $itm_name);
$itm_name = $mysqli->real_escape_string($itm_name);

$warranty = $mysqli->real_escape_string($_POST['txt_wnty']);
$com_cat = $_POST['com_cat'];
$com_cat = $mysqli->real_escape_string(trim($com_cat));
$itm_type = $_POST['itm_type'];
$itm_type = $mysqli->real_escape_string(trim($itm_type));
$ex_cate = $mysqli->real_escape_string($_POST['ex_cate']);
$ex_cate = $mysqli->real_escape_string(trim($ex_cate));
$vendor_id = $_POST['vendor_id'];

$ven_name = $_POST['ven_name'];

$per_carton = $_POST['per_carton'];
$mesure1 = $_POST['mesure1'];
$sprice1 = $_POST['sprice1'];
$cost1 = $_POST['cost1'];
$mesure2 = $_POST['mesure2'];

$br_show = $_POST['br_show'] == 'br_show' ? $_POST['br_show'] : 'br_hide';
$minPer = $_POST['minPer'] == 'minPer' ? $_POST['minPer'] : 'minPerHide';
$updCostPr = $_POST['updCostPr'] == 'updCostPr' ? $_POST['updCostPr'] : 'updCostPrHide';
$updSalePr = $_POST['updSalePr'] == 'updSalePr' ? $_POST['updSalePr'] : 'updSalePrHide';

$sprice2 = $_POST['sprice2'];
$cost2 = $_POST['cost2'];
$m_price = $_POST['m_price'];
$i_disco = $_POST['i_disco'];
$m_stock = $_POST['m_stock'];

$r_oder = $_POST['r_oder'];
$location = $_POST['location'];
//$b_stock = $_POST['b_stock'];
$com_section = $_POST['com_section'];
$com_section2 = $_POST['com_section2'];
//$bil_date = $_POST['bil_date'];
$bil_date = date('Y-m-d');

$warehouse = $_POST['warehouse'];
$rebate = $_POST['rebate'];
$non_stock = $_POST['non_stock'];
$manu_itm = $_POST['manu_itm'];
$ch_active = $_POST['ch_active'];
$ch_imei = $_POST['ch_imei'];
$ch_sirial = $_POST['ch_sirNo'];
$ex_description = $_POST['ex_description'];
$commis = $_POST['commis'];
$due_day = $_POST['due_day'];

$nbt = $_POST['txt_nbt'];
$vat = $_POST['txt_vat'];

$lvl_1 = $_POST['lvl_1'];
$lvl_2 = $_POST['lvl_2'];
$lvl_3 = $_POST['lvl_3'];
$lvl_4 = $_POST['lvl_4'];
$lvl_5 = $_POST['lvl_5'];




$cost3 = $_POST['cost3'];
$rht_disc = $_POST['chk_disc'];
if ($rht_disc == 'NO') {
    $rht_disc2 = 'NO';
} else {
    $rht_disc2 = 'YES';
}
$ch_active2 = '0';
$rebate2 = '0';
$non_stock2 = '0';
$manu_itm2 = '0';
$p_disc = $_POST['p_disc'];
$wlCash_price = $_POST['wCash_price'];
$wlCredit_price = $_POST['wCredit_price'];
$bldPer = $_POST['txt_bItmPer'];
$com_id = $_SESSION['COM_ID'];

$web_price = $_POST['web_price'];
$blk_item = $_POST['chk_block'];
if ($blk_item == 'NO') {
    $blk_item = 'NO';
} else {
    $blk_item = 'YES';
}
$blk_zstk = $_POST['zero_blk'];
if ($blk_zstk == 'NO') {
    $blk_zstk = 'NO';
} else {
    $blk_zstk = 'YES';
}

$dbNm = $_SESSION['DB'];


$date = date("Y-m-d");
$time = date("h:i:sa");

if ($ch_active == 'ch_active') {
    $ch_active2 = '1';
} else {
    $ch_active2 = '0';
}
if ($rebate == 'rebate') {
    $rebate2 = '1';
} else {
    $rebate2 = '0';
}
if ($non_stock == 'non_stock') {
    $non_stock2 = '1';
} else {
    $non_stock2 = '0';
}
if ($manu_itm == 'manu_itm') {
    $manu_itm2 = '1';
} else {
    $manu_itm2 = '0';
}



function save_bcode($itmID, $date, $itm_no2, $br_id, $user_id)
{

    global $mysqli;

    $no_brcode = $_POST['no_bcode'];
    $del_barcode = $mysqli->query("DELETE FROM `barcodes` WHERE `itmTbID`='$itmID' AND br_id='$br_id'");

    for ($r = 1; $r <= $no_brcode; $r++) {
        $barCode = $_POST['barcode_' . $r];
        if ($barCode != '') {

            $qry_chkBRcode = $mysqli->query("SELECT ID FROM `barcodes` WHERE `BarCode`='$barCode' AND br_id='$br_id'");
            $count_BRcode = $qry_chkBRcode->num_rows;

            if ($count_BRcode <= 0) {

                $qry_brcode = $mysqli->query("INSERT INTO `barcodes`(`BarCode`, `Date`, `ItemID`, `br_id`, `cloud`, `mysql_db`,itmTbID,userID) 
						VALUES ('$barCode','$date','$itm_no2','$br_id','item create','web','$itmID','$user_id')");
            } else {
                echo '</br>Already exists ' . $barCode;
            }
        }
    }
}



$img_avlable;
function img_save()
{
    $target_dir2 = "../img_items/" . $_SESSION['DB'];
    $target_dir = "../img_items/" . $_SESSION['DB'] . "/";
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_name = $_FILES['fileToUpload']['name'];
    $uploadOk = 1;
    $imageFileType = pathinfo($file_name, PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image

    if (!file_exists($target_dir2)) {
        mkdir($target_dir2, 0777, true);
    }

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {


        /* $ch = curl_init($file_tmp);
							$fp = fopen($target_dir.$_POST['itm_no2'].'.jpg', 'wb');
							curl_setopt($ch, CURLOPT_FILE, $fp);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_exec($ch);
							curl_close($ch);
							fclose($fp); */

        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $_POST['itm_no2'] . '.jpg');
        //	echo "File is an image - " . $check["mime"] . ".";

        //	echo $file_name.' go erewr '.$target_dir.$_POST['itm_no2'].'.jpg';
        //	die;
        //$img_avlable="yes";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        //$img_avlable="no";
        $uploadOk = 0;
        //die;
    }
}



if ($itm_no2 != '' && !empty($itm_no2)) {

    if (isset($_POST['bt_update2'])) {

        //die;

        /*	echo '<script> alert ("bt image"); </script>';*/
        if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) {
        } else {
            img_save();
        }


        $qry_item = $mysqli->query("SELECT * FROM `itemtable` WHERE `ItemNO`='$itm_no2'");
        $itm_det = $qry_item->fetch_array();
        $itm_cont = $qry_item->num_rows;

        if ($itm_cont > 0) {

            $qry_deleteTB = $mysqli->query("INSERT INTO `delete_itemtable`
(`ItemNO`, `Description`, `Sprice`, `Cost`, `Stock`, `Damaged`, `Expired`, `Date`,
 `CatID`, `Cost2`, `Diff`, `ItemDisc`, `MinSale`, `Sprice2`, `Unit`, `Unit2`, `Vendor`,
 `cloud`, `rht_disco`, `due_day`, `comm_per`, `nbt`, `vat`, `purchase_dis`,
 `user_id`, `br_id`, `D1`, `D2`, `D3`)
VALUES (
 '" . $mysqli->real_escape_string($itm_det['ItemNO']) . "',
 '" . $mysqli->real_escape_string($itm_det['Description']) . "',
 '" . $mysqli->real_escape_string($itm_det['Sprice']) . "',
 '" . $mysqli->real_escape_string($itm_det['Cost']) . "',
 '" . $mysqli->real_escape_string($itm_det['Stock']) . "',
 '" . $mysqli->real_escape_string($itm_det['Damaged']) . "',
 '" . $mysqli->real_escape_string($itm_det['Expired']) . "',
 '" . $mysqli->real_escape_string(date('Y-m-d')) . "',
 '" . $mysqli->real_escape_string($itm_det['CatID']) . "',
 '" . $mysqli->real_escape_string($itm_det['Cost2']) . "',
 '" . $mysqli->real_escape_string($itm_det['Diff']) . "',
 '" . $mysqli->real_escape_string($itm_det['ItemDisc']) . "',
 '" . $mysqli->real_escape_string($itm_det['MinSale']) . "',
 '" . $mysqli->real_escape_string($itm_det['Sprice2']) . "',
 '" . $mysqli->real_escape_string($itm_det['Unit']) . "',
 '" . $mysqli->real_escape_string($itm_det['Unit2']) . "',
 '" . $mysqli->real_escape_string($itm_det['Vendor']) . "',
 'Update',
 '" . $mysqli->real_escape_string($itm_det['rht_disco']) . "',
 '" . $mysqli->real_escape_string($itm_det['due_day']) . "',
 '" . $mysqli->real_escape_string($itm_det['comm_per']) . "',
 '" . $mysqli->real_escape_string($itm_det['nbt']) . "',
 '" . $mysqli->real_escape_string($itm_det['vat']) . "',
 '" . $mysqli->real_escape_string($itm_det['p_disc']) . "',
 '" . $mysqli->real_escape_string($user_id) . "',
 '" . $mysqli->real_escape_string($br_id) . "',
 '" . $mysqli->real_escape_string($cost1) . "',
 '" . $mysqli->real_escape_string($cost3) . "',
 '" . $mysqli->real_escape_string($sprice1) . "'
)");

            //get_value();
            //echo 'update';
            //echo 'br _count '.$_SESSION['br_coun']; `POrder`='$r_oder', `ReOrder`='$m_stock',
            $qry = "UPDATE `itemtable` SET `Description`= '$itm_name', `Sprice`='$sprice1', `Cost`='$cost1', `Stock`='0'
				, `Damaged`='0', `Expired`='0', `Active`='$ch_active2', `Assembly`='$manu_itm2', `Bags`='0', `Date`='$bil_date'
				,  `CatID`='$com_cat', `Cost2`='$cost3',  `Diff`='$cost2', `ItemDisc`='$i_disco', `Location`='$location'
				, `MinSale`='$m_price', `Ncost`='0', `nonSTK`='$non_stock2', `PerPack`='$per_carton', 
				  `POrder`='$r_oder',`Rebate`='$rebate2', `ReOrder`='$m_stock',
				 `Section`='$com_section',`Section2`='$com_section2',
				 `Sprice2`='$sprice2', `Taxt`='$ex_description',
				 `Type`='$itm_type', `Unit`='$mesure1'
				, `Unit2`='$mesure2', `Vendor`='$vendor_id', `XWord`='$ex_cate', `cloud`='update', `mysql_db`='web' 
				, `desSearch`='$itm_no2 $itm_name $com_cat', `warehouse` = '$warehouse', `rht_disco`='$rht_disc2',
				comm_per='$commis',due_day='$due_day',`nbt`='$nbt', vat='$vat',purchase_dis='$p_disc',`warranty` ='$warranty',
				`web_price`='$web_price',`web_active` = '$blk_item', `web_zero_stk` = '$blk_zstk',`wl_cash_price` ='$wlCash_price'
				 ,`wl_credit_price` = '$wlCredit_price',backup='$com_id',rht_serial='$ch_sirial' where `ItemNO`= '$itm_no2' ";



            // echo 'sfsd '.$mysqli;
            $sql_itm_up = $mysqli->query($qry);

            $brLocateID = $_POST['brLocateID'];
            $brLocateNm = $_POST['brLocateNm'];

            foreach ($brLocateID as $index => $bb) {
                $bbrr = $brLocateID[$index];
                $bbnn = $brLocateNm[$index];
                $mysqli->query("UPDATE `br_stock` SET `br_area` = '$bbnn' where br_id = '$bbrr' AND `itm_code` = '$itm_no2' ");
                // echo "UPDATE `br_stock` SET `br_area` = '$bbnn' where br_id = '$bbrr' AND `itm_code` = '$itm_no2' ";
            }
            //	die;	


            if ($sql_itm_up) {

                // insert branch stock--------------------------------------

                $itm_no2 = trim($itm_no2);
                $sql_user3 = $mysqli->query(" SELECT ID FROM `itemtable` where `ItemNO`= '$itm_no2' ");

                $itm_ids = $sql_user3->fetch_array();
                $item_id = $itm_ids['ID'];



                if (isset($_POST['chk_br'])) {
                    foreach ($_POST['chk_br'] as $ch_br_id) {


                        save_bcode($item_id, $date, $itm_no2, $ch_br_id, $user_id);

                        $sql_user2 = $mysqli->query(" SELECT `br_id`, `itm_id`, `itm_code`, `qty`, `damaged`, `expired`,
						  `cost_pr`, `sale_pr`, `cloud` FROM `br_stock` WHERE `itm_id`='$item_id' and `br_id`='$ch_br_id' ");
                        $num_rows2 = $sql_user2->num_rows;
                        //echo 'no row-'.$item_id;
                        //die;

                        if ($num_rows2 == 0) {

                            $qry_stk3 = "INSERT INTO `br_stock`(`br_id`, `itm_id`, `itm_code`, `cost_pr`,
								  `sale_pr`,`salse_pr2` ,`cost_pr2`,`diff`,reorder2,POrder,cloud,mysql_db,itm_name
								  ,priLV1,priLV2,priLV3,priLV4,priLV5,`wl_cash_price`,`wl_credit_price`,cat,item_search,
								  `bweb_price`,bweb_active,bweb_zero_stk,dbName,backup,br_area, `imeiSerial`,manu_cost_per, showHide ) VALUES 
						 ('$ch_br_id','$item_id','$itm_no2','$cost1','$sprice1','$sprice2','$cost3','$cost2','$m_stock',
						 '$r_oder','NEW','itm_save','$itm_name','$lvl_1','$lvl_2','$lvl_3','$lvl_4','$lvl_5','$wlCash_price',
						 '$wlCredit_price','$com_cat','$itm_no2 $itm_name $com_cat','$web_price','$blk_item','$blk_zstk'
						 ,'$dbNm','$com_id','$location','$ch_imei','$bldPer', '$br_show')";
                            $sql_stk_up = $mysqli->query($qry_stk3);
                        } else {
                            if ($minPer == 'minPer') {
                                $minStockQry = ", reorder2='$m_stock',POrder='$r_oder'";
                            } else {
                                $minStockQry = "";
                                
                                if ($br_id == $ch_br_id) {
                                    $minStockQry = ", reorder2='$m_stock',POrder='$r_oder'";
                                }
                            }
                            
                            if ($updCostPr == 'updCostPr') {
                                $updCostPrQry = ", cost_pr='$cost1',`cost_pr2`='$cost3',`diff`='$cost2'";
                            } else {
                                $updCostPrQry = "";
                                
                                if ($br_id == $ch_br_id) {
                                    $updCostPrQry = ", cost_pr='$cost1',`cost_pr2`='$cost3',`diff`='$cost2'";
                                }
                            }
                            
                            if ($updSalePr == 'updSalePr') {
                                $updSalePrQry = ", sale_pr='$sprice1', salse_pr2='$sprice2'";
                            } else {
                                $updSalePrQry = "";
                                
                                if ($br_id == $ch_br_id) {
                                    $updSalePrQry = ", sale_pr='$sprice1', salse_pr2='$sprice2'";
                                }
                            }

                            $qry_stk2 = "UPDATE `br_stock` SET cloud= 'UPDATE',mysql_db='itm_update',
                                            itm_name='$itm_name',priLV1='$lvl_1',priLV2='$lvl_2',priLV3='$lvl_3',
                                            priLV4='$lvl_4',priLV5='$lvl_5',`wl_cash_price` ='$wlCash_price',`wl_credit_price` = '$wlCredit_price',`bweb_price`='$web_price',`bweb_active` = '$blk_item',
                                            `bweb_zero_stk` = '$blk_zstk',cat='$com_cat',item_search='$itm_no2 $itm_name $com_cat' ,br_area='$location',
                                            imeiSerial='$ch_imei',manu_cost_per='$bldPer', showHide='$br_show' $minStockQry $updCostPrQry $updSalePrQry
                                            WHERE `itm_id`='$item_id' and `br_id`='$ch_br_id' ";
                            $sql_stk_up = $mysqli->query($qry_stk2);
                        }
                    }
                }
            }


            // insert branch stock--------------------------------------


            $brLocateID = $_POST['brLocateID'];
            $brLocateNm = $_POST['brLocateNm'];

            foreach ($brLocateID as $index => $bb) {
                $bbrr = $brLocateID[$index];
                $bbnn = $brLocateNm[$index];
                $mysqli->query("UPDATE `br_stock` SET `br_area` = '$bbnn' where br_id = '$bbrr' AND `itm_code` = '$itm_no2' ");
            }


            $_SESSION['succsess_msg'] = 'Record save successfully ! ';
            redirect('create_item.php');
            die;
        } else {
            $_SESSION['succsess_msg'] = 'Record unable to save ! ';
            // echo "Record couldn't able to insert";
            redirect('create_item.php');
            die;
        }
    }
    //update  ----------------------------------




    //delete  ----------------------------------
    if (isset($_POST['bt_delete'])) {
        //echo'delete';
        $sql_ck_item = $mysqli->query("SELECT `ItemNo` FROM `invitem` WHERE `ItemNo`='$itm_no2' ");

        $num_rows2 = $sql_ck_item->num_rows;
        //echo 'no row-'.$num_rows2;

        $sql_ck_stk = $mysqli->query("SELECT SUM(`qty`) FROM `br_stock` WHERE `itm_code`='$itm_no2' ");

        $chk_stk = $sql_ck_stk->fetch_array();
        $stk_count = $num_rows2 + $chk_stk[0];

        if ($stk_count == 0) {

            $qry_item2 = $mysqli->query("SELECT * FROM `itemtable` WHERE `ItemNO`='$itm_no2' ");
            $itm_det = $qry_item2->fetch_array();

            $qry_deleteTB2 = $mysqli->query("INSERT INTO `delete_itemtable`( `ItemNO`, `Description`, `Sprice`, `Cost`, `Stock`,
			 `Damaged`, `Expired`,`Date`, `CatID`, `Cost2`,  `Diff`,
			  `ItemDisc`, `MinSale`, `Sprice2`, `Unit`, `Unit2`, `Vendor`,`cloud`,rht_disco,due_day,comm_per
			  ,`nbt`,vat,purchase_dis,`user_id`,`br_id`) 
			VALUES('" . $itm_det['ItemNO'] . "','" . $itm_det['Description'] . "','" . $itm_det['Sprice'] . "','" . $itm_det['Cost'] . "',
			'" . $itm_det['Stock'] . "','" . $itm_det['Damaged'] . "','" . $itm_det['Expired'] . "','" . date('y-m-d') . "',
			'" . $itm_det['CatID'] . "','" . $itm_det['Cost2'] . "','" . $itm_det['Diff'] . "'
			,'" . $itm_det['ItemDisc'] . "','" . $itm_det['MinSale'] . "','" . $itm_det['Sprice2'] . "','" . $itm_det['Unit'] . "',
			'" . $itm_det['Unit2'] . "','" . $itm_det['Vendor'] . "','Delete','" . $itm_det['rht_disco'] . "',
			'" . $itm_det['due_day'] . "','" . $itm_det['comm_per'] . "','" . $itm_det['nbt'] . "','" . $itm_det['vat'] . "',
			'" . $itm_det['p_disc'] . "','" . $user_id . "','$br_id')");



            $qry = "UPDATE `itemtable` SET `itm_delete`='1'  WHERE `ItemNO`='$itm_no2' ";

            //echo $qry;
            $sql_itm_del = $mysqli->query($qry);

            //$sql_update = $mysqli->query(" UPDATE `tbl_customer` SET `email`='$email_id' WHERE `id`=' $u_id' ",$dbh1);

            if ($sql_itm_del) {
                //  echo 'u id : ' .$u_id. '<br> email id : ' .$email_id. ' <br> email type'.$mail_type;
                $_SESSION['succsess_msg'] = 'Record delete successfully ! ';
                // echo "Record couldn't able to insert";
                redirect('create_item.php');
                die;
            } else {
                $_SESSION['succsess_msg'] = 'Record unable to delete ! ';
                // echo "Record couldn't able to delete";
                echo "<script> alert ('Record unable to delete !'); </script>";
                redirect('create_item.php');
                die;
            }
        } else {
            echo "<script> alert ('This Item can not delete. Total Stock " . $chk_stk[0] . "  !..'); </script>";
            redirect('create_item.php');
            die;
        }


        //exit;
    }
    //delete  ----------------------------------


    //save  ----------------------------------
    if (isset($_POST['bt_save'])) {


        $itm_no2 = str_ireplace('/', '-', $itm_no2);
        $itm_no2 = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $itm_no2);
        $itm_no2 = $mysqli->real_escape_string($itm_no2);


        // echo '<br/> rebate '.$rebate2. '<br/> manu item '.$manu_itm2.'<br/> non stock '.$non_stock2. '<br/> active '.$ch_active2 ;
        // image upload
        if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) {
        } else {

            img_save();
        }
        // image upload

        $sql_ck_item = $mysqli->query("SELECT `ItemNO` FROM `itemtable` where `ItemNO`='$itm_no2' ");

        $num_rows = $sql_ck_item->num_rows;
        //echo 'no row-'.$num_rows;

        if ($num_rows >= 1) {
            echo "<script> alert ('Item id already exists!..'); </script>";
            redirect('create_item.php');
            die;
        } else {


            //get_value();
            $qry = "INSERT INTO `itemtable`( `ItemNO`, `Description`, `Sprice`, `Cost`, `Stock`,
			 `Damaged`, `Expired`, `Active`, `Assembly`, `Bags`, `Date`, `CatID`, `Cost2`,  `Diff`,
			  `ItemDisc`, `Location`, `MinSale`, `Ncost`, `nonSTK`, `PerPack`, `POrder`
			, `Rebate`, `ReOrder`, `Section`,`Section2`, `Sprice2`, `Taxt`, `Type`, `Unit`, `Unit2`, `Vendor`, `XWord`,
			 `cloud`, `mysql_db`,`desSearch`,`warehouse`,rht_disco,due_day,comm_per,`nbt`,vat,purchase_dis,`warranty`,
			 `web_price`,`web_active`, `web_zero_stk`,`wl_cash_price`,`wl_credit_price`,backup,user_id,`br_id`
			 ,rht_serial ) 
			VALUES('$itm_no2','$itm_name','$sprice1','$cost1','0','0','0','$ch_active2','$manu_itm2','0','$bil_date'
			,'$com_cat','$cost3','$cost2','$i_disco','$location','$m_price','0','$non_stock2','$per_carton','$r_oder',
			'$rebate2','$m_stock','$com_section','$com_section2','$sprice2','$ex_description',
			'$itm_type','$mesure1','$mesure2',
			'$vendor_id','$ex_cate','new','web','$itm_no2 $itm_name $com_cat','$warehouse','$rht_disc2',
			'$due_day','$commis','$nbt','$vat','$p_disc','$warranty','$web_price','$blk_item','$blk_zstk','$wlCash_price',
			'$wlCredit_price','$com_id','$user_id','$br_id','$ch_sirial')";



            $sql_itm = $mysqli->query($qry);
            // remove unwanted letter +++++_+_+_+_+_+_+_+_+_+_+__+_+________________+_+_+_+_+_

            $sql_des = $mysqli->query(" SELECT *  FROM `itemtable` WHERE `Description` LIKE '%''%'");

            while ($re = $sql_des->fetch_array()) {

                $itm_des = $re['Description'];
                $itm_id = $re['ID'];

                $new_des = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $itm_des);

                //$new_des=$mysqli->real_escape_string($itm_des);
                //$new_des=str_replace("\\", '/', $itm_des);
                //echo '<br>'.$itm_des.' - '.$new_des;



                $qry = "UPDATE `itemtable` SET `Description`='" . $new_des . "' WHERE ID =" . $itm_id . " ";
                //echo '</br>'. $qry;

                /////$qry_ec = $mysqli->query($qry);

                //die;


            }
            // remove unwanted letter +++++_+_+_+_+_+_+_+_+_+_+__+_+________________+_+_+_+_+_



            //	$lid = mysql_insert_id();

            //$sql_update = $mysqli->query(" UPDATE `tbl_customer` SET `email`='$email_id' WHERE `id`=' $u_id' ",$dbh1);

            if ($sql_itm) {

                // insert branch stock--------------------------------------
                $sql_lid = $mysqli->query("SELECT MAX(ID) FROM `itemtable` WHERE `ItemNO`='$itm_no2'");
                $res_lid2 = $sql_lid->fetch_array();
                $lid = $res_lid2[0];



                if (isset($_POST['chk_br'])) {

                    foreach ($_POST['chk_br'] as $ch_br_id) {

                        save_bcode($lid, $date, $itm_no2, $ch_br_id, $user_id);
                        //echo $ch_br_id;
                        $sql_user22 = $mysqli->query(" SELECT `br_id`, `itm_id`, `itm_code`, `qty`, `damaged`, `expired`,
						  `cost_pr`, `sale_pr`, `cloud` FROM `br_stock` WHERE `itm_id`='$lid' and `br_id`='$ch_br_id' ");
                        $num_rows22 = $sql_user22->num_rows;

                        if ($num_rows22 == 0) {

                            $qry_stk4 = "INSERT INTO `br_stock`(`br_id`, `itm_id`, `itm_code`, `cost_pr`,
								  `sale_pr`,`salse_pr2` ,`cost_pr2`,`diff`,reorder2,POrder,cloud,mysql_db,itm_name
								  ,priLV1,priLV2,priLV3,priLV4,priLV5,`wl_cash_price`,`wl_credit_price`,cat,item_search,
								  `bweb_price`,bweb_active,bweb_zero_stk,dbName,backup,`manu_cost_per`, showHide, imeiSerial) VALUES   
						 ('$ch_br_id','$lid','$itm_no2','$cost1','$sprice1','$sprice2','$cost3','$cost2','$m_stock',
						 '$r_oder','NEW','itm_save','$itm_name','$lvl_1','$lvl_2','$lvl_3','$lvl_4','$lvl_5','$wlCash_price',
						 '$wlCredit_price','$com_cat','$itm_no2 $itm_name $com_cat','$web_price','$blk_item','$blk_zstk'
						 ,'$dbNm','$com_id','$bldPer', '$br_show', '$ch_imei')";

                            $sql_stk_up = $mysqli->query($qry_stk4);
                        }
                    }
                } else {
                    $sql_user22 = $mysqli->query(" SELECT `br_id`, `itm_id`, `itm_code`, `qty`, `damaged`, `expired`,
					                                    `cost_pr`, `sale_pr`, `cloud` FROM `br_stock` WHERE `itm_id`='$lid' and `br_id`='$br_id' ");
                    $num_rows22 = $sql_user22->num_rows;

                    if ($num_rows22 == 0) {

                        $qry_stk4 = "INSERT INTO `br_stock`(`br_id`, `itm_id`, `itm_code`, `cost_pr`,
							  `sale_pr`,`salse_pr2` ,`cost_pr2`,`diff`,reorder2,POrder,cloud,mysql_db,itm_name
							  ,priLV1,priLV2,priLV3,priLV4,priLV5,`wl_cash_price`,`wl_credit_price`,cat,item_search,
							  `bweb_price`,bweb_active,bweb_zero_stk,dbName,backup,`manu_cost_per`, showHide, imeiSerial ) VALUES   
					 ('$br_id','$lid','$itm_no2','$cost1','$sprice1','$sprice2','$cost3','$cost2','$m_stock',
					 '$r_oder','NEW','itm_save','$itm_name','$lvl_1','$lvl_2','$lvl_3','$lvl_4','$lvl_5','$wlCash_price',
					 '$wlCredit_price','$com_cat','$itm_no2 $itm_name $com_cat','$web_price','$blk_item','$blk_zstk'
					 ,'$dbNm','$com_id','$bldPer', '$br_show', '$ch_imei')";

                        $sql_stk_up = $mysqli->query($qry_stk4);
                    }
                }

                // insert branch stock--------------------------------------

                $mysqli->query("UPDATE `br_stock` SET `itm_id`=(Select ID FROM itemtable WHERE ItemNO=`br_stock`.`itm_code` limit 1) WHERE `itm_id` ='0'");
                $_SESSION['succsess_msg'] = 'Record save successfully ! ';
                redirect('create_item.php');
                die;
            } else {
                $_SESSION['error_msg'] = 'Record unable to save ! ';
                // echo "Record couldn't able to insert";
                redirect('create_item.php');
                die;
            }
        }


        // <th><input type="hidden" name="brLocateID[]" ><input type="text" name="brLocateNm[]" > </th>

        $_SESSION['error_msg'] = 'Record unable to save ! ';
        // echo "Record couldn't able to insert";
        redirect('create_item.php');
        die;
    }
    //save  ----------------------------------



}
$showCost = '';
$cost_rht = $mysqli->query("SELECT * FROM `user_rights` JOIN pages ON `user_rights`.`page_id`= pages.ID WHERE
				 `user_id` ='$user_id' AND `page_title` ='control_Show Cost' AND `user_rights`.`br_id`='$br_id'");
                 if($cost_rht->num_rows > 0 || $user_type == 'Admin'){
                    $showCost = 'Yes';
                 }else{
                    $showCost = 'No';
                 }

?>







<style>
    /* 17/11/2025 status filter start */
    .status-filter-group {
        display:flex;
        text-align: right;
        justify-content: flex-end;
        padding: 5px 10px 5px 0;
        margin-bottom: 25px !important;
    }

    .status-filter-group label.activesr-radio-inline {
        display: inline-block;
        vertical-align: middle;
        position: relative;
        padding-left: 28px;
        margin-right: 15px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #555;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .status-filter-group label.activesr-radio-inline input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .status-filter-group label.activesr-radio-inline .checkmark {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 18px;
        width: 18px;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 50%;
        transition: all 0.2s ease;
    }

    .status-filter-group label.activesr-radio-inline:hover input ~ .checkmark {
        background-color: #f5f5f5;
    }

    .status-filter-group label.activesr-radio-inline input:checked ~ .checkmark {
        background-color: #26B99A;
        border-color: #1E947B;
    }

    .status-filter-group label.activesr-radio-inline .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .status-filter-group label.activesr-radio-inline input:checked ~ .checkmark:after {
        display: block;
    }

    .status-filter-group label.activesr-radio-inline .checkmark:after {
        top: 5px;
        left: 5px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
    }
    /* 17/11/2025 status filter end */
    @font-face {
        font-family: Dinesh;
        src: url(../Invoice/print/Logo/Info_Dinesh.ttf);
    }

    legend {
        text-align: left;
    }

    #inputarea1 {
        margin: 0 auto;
        /* border-style: solid;
    border-width: 2px; */
        text-align: center;
        width: 100%;
        padding-top: 15px;
        padding-bottom: 15px;
        height: auto;
        float: left;


    }

    #side2 {
        margin: 0 auto;
        /* border-style: solid;
    border-width: 2px; */
        text-align: center;
        width: 40%;
        padding-top: 15px;
        padding-bottom: 15px;
        height: auto;
        float: right;

    }

    #side2:after {
        clear: both;
        content: "";
        display: table;
    }

    .body_wrraper:after {
        clear: both;
        content: "";
        display: table;
    }


    label {
        /*width:160px; */
        text-align: left;
        float: left;
        padding-top: 1px;
        font-weight: normal;
        font-family: sans-serif;
        font-size: 14px;
    }

    .text_box {
        width: 100%;
        margin-bottom: 6px;
        float: left;
    }

    #bt {
        background: #6D9C5F;
        color: #0C0D0C;
        width: 120px;
        float: right;
        margin-bottom: 6px;
    }


    #bt:hover {
        background-color: #B4EBA4;
    }


    #com_box {
        font-size: 10px;
    }

    #unit {
        background-color: #F3F5F2;
        height: auto;
        width: 96%;
        margin-left: 2%;
        padding-top: 0%;
        padding-bottom: 0%;
    }

    #unit:after {
        clear: both;
        content: "";
        display: table;
    }

    #text_box2 {
        height: 35px;
        margin-bottom: 3px;
    }


    #txt_area {
        width: auto;
    }

    .box-content {}

    #itmList {}


    .ui-autocomplete {
        cursor: pointer;
        height: 120px;
        overflow-y: scroll;
    }

    #c_box {
        float: left;
    }


    /* button style */
    .sbt {
        background: #1abb9c;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 14px;
        border-radius: 17px;
        font-weight: bold;
        border: unset;
    }

    .button-green {
        color: #28168C;
        background: none;
        border: unset;
        color: white;
        font-size: 13px;
        font-family: sans-serif;
        border-top: unset;
        text-shadow: unset;
    }

    @charset "UTF-8";

    .profile-user-img {
        width: 100%;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        padding: 0;
    }

    .avatar-upload {
        position: relative;
        max-width: 100%;
        margin: auto;
        margin-bottom: 20px;
    }

    .avatar-upload .avatar-edit {
        position: absolute;
        right: -10px;
        z-index: 1;
        top: 10px;
    }

    .avatar-upload .avatar-edit input {
        display: none;
    }

    .avatar-upload .avatar-edit input+label {
        display: inline-block;
        width: 34px;
        height: 34px;
        margin-bottom: 0;
        border-radius: 10px;
        background: white;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 25%);
        cursor: pointer;
        font-weight: normal;
        transition: all 0.2s ease-in-out;
    }

    .avatar-upload .avatar-edit input+label:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }

    .avatar-upload .avatar-edit input+label:after {
        content: "";
        font-family: "FontAwesome";
        color: #337ab7;
        position: absolute;
        left: 0;
        right: 0;
        text-align: center;
        line-height: 34px;
        margin: auto;
    }

    .input-container {
        position: relative;
    }

    .input-container input {
        padding-right: 30px;
        /* Add padding to the right for the character count span */
    }



    /*************** END OF  STYLE FOR AUTOCOMPLETE DROPDOWN ***********/
    /* Apply word-break styling to table cells */
table#employee_grid td {
    word-break: break-all; /* Forces words to break at any point */
    white-space: normal;   /* Allows text to wrap within the cell */
}

</style>



<style>
    #ags1 {
        float: left;
        width: 40%;

    }

    #ags2 {
        float: right;
        width: 40%;
        margin-right: 20%;
        margin-top: -2.1111115898989789%;

    }

    #ags3 {
        float: left;
        width: 50%;

    }

    #ags4 {
        float: right;
        width: 40%;
        margin-right: 10%;
        margin-top: -2.1111115898989789%;

    }

    #ags5 {
        float: right;
        width: 20%;
        margin-right: 20%;
        margin-top: -2.1111115898989789%;

    }


    #ags6 {
        float: left;
        width: 100%;
        margin-top: -2.1111115898989789%;

    }

    .controls {
        width: 60%;

    }

    .control-group {
        padding-left: 3%;
        padding-right: 3%;


    }

    .control-label {
        width: 10%;

    }

    .bilDetUl li {
        background: #0066CC;
        list-style: none;
        float: left;
        margin-left: 10px;
        width: auto;
    }


    #ajax_img_lod,
    #ajax_img_lod_chq {
        display: none;
    }

    .bilDetLoad {
        display: none;
    }

    .bilDetCont {
        margin-left: -50px;

    }

    .bilDetCont input[type='text'],
    select {

        height: 28px;
        font-size: 12px;
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 3px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;

    }

    .searhBtn {
        margin-top: 18px;
        padding: 3px 10px;
    }

    .norml {
        font-weight: normal;
    }

    #list {
        list-style: none;
        font-family: 'PT Sans', Verdana, Arial, sans-serif;
        min-width: 150px;
        height: auto;
        color: #666;
        padding-top: 3px;
        padding-bottom: 3px;
        padding-left: 15px;
        border-bottom: 1px solid #cdcdcd;
        transition: background-color .3s ease-in-out;
        -moz-transition: background-color .3s ease-in-out;
        -webkit-transition: background-color .3s ease-in-out;
        text-transform: uppercase;

    }

    #list:hover {
        background: #7F7F7F;
        border: 1px solid rgba(0, 0, 0, 0.2);
        cursor: pointer;
        color: #fff;
    }

    #list:hover a {
        color: #fff;
        text-decoration: none;
    }

    .hilight {
        color: #333333;
        text-transform: uppercase;
        font-weight: bold;
    }

    .invoSumryTB tr:nth-child(even):hover td,
    tbody tr.odd:hover td {
        background: #DFD;
        cursor: pointer;
        color: #009999
    }

    .amountBox,
    .paymntBox {
        width: 80px;
        text-align: right;
    }

    .dataTables_length {
        width: 100px;
    }

    #itm-loaders {
        display: none;
    }

    #panel,
    #flip {
        text-align: center;
        border: solid 1px #c3c3c3;
    }

    #panel {

        display: none;
        min-height: 200px;

    }

    .dz-message {
        margin-left: 10px;
        margin-bottom: 10px;
    }

    fieldset {
        border: 0;
        margin: 8px;
        border-right: 1px solid silver;
        border-left: 1px solid silver;
        padding: 8px;
        border-radius: 4px;
    }

    .exCatD {
        text-align: left;
        position: absolute;
        z-index: 9999;
        background-color: white;
        width: 93%;
    }

    .exCatD1:hover {
        background-color: #C0C0C0;
        cursor: pointer;
        font-weight: bold;
    }

    .exCatD1 {
        padding: 2px;
    }

    .exCatD11:hover {
        background-color: #C0C0C0;
        cursor: pointer;
        font-weight: bold;
    }

    .exCatD11 {
        padding: 2px;
    }
</style>


<!--<script src="../js/dropzone.js"></script>  
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css"> -->

</head>

<body class="nav-sm">
    <div class="container body">
        <div class="main_container">
            <?php
            include($path . 'side.php');
            include($path . 'mainBar.php');
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

                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h2><i class="fa fa-align-left"></i> Item Create Form<small></small></h2>
                                    <?php
                                    if ($user_type == 'Admin') {
                                        //echo '<a id="itm_del" style="float:right;" href="#" class="btn btn-danger  btn-default itm_del"> <i class="fa fa-trash"></i> Delete All Items</a>';
                                    }
                                    ?>
                                    <a id="itm_bulk" style="float:right;" href="create_item_all.php" class="btn btn-edit  btn-default itm_bulk"> <i class="glyphicon glyphicon-qrcode"></i> Bulk Items Create</a>
                                    <a style="float:right;" target="_BLANK" href="scale_price_txt.php" class="btn btn-edit  btn-default"> <i class="glyphicon glyphicon-qrcode"></i> Download Scale Price</a>
                                    <a href="edit_item.php" style="float:right;" class="btn btn-edit  btn-default"> <i class="glyphicon glyphicon-edit"></i> Edit Items </a>
                                    <a id="flip" href="#" style="float:right;" class="btn btn-edit  btn-default"> <i class="glyphicon glyphicon-edit"> </i> Edit Price/Cost</a>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <!-- body conten -->
                                    <div class="box-content">

                                        <!-- body wrapper start -->
                                        <div class="body_wrraper">


                                            <!-- Item price and cost edit all branch ------------------------------------------------------------------------------>

                                            <!--<div id="flip">Click to slide the panel down or up</div>-->

                                            <div id="panel" class="pan">
                                                <!--Hello world! -->


                                                <div class="box-content lod_img" align="center">
                                                    <ul class="ajax-loaders3" style="display:none;">
                                                        <li><img src="../img/ajax-loaders/ajax-loader-8.gif" /></li>
                                                    </ul>
                                                </div>

                                                <!-- branch item table -->


                                                <div class="form-group floatSales2 col-sm-5" style="">

                                                    <label style=""> Category </label>
                                                    <select name="com_cat" id="com_cat" class="com_cat" tabindex="2">
                                                        <option value="price_dif" selected>Price Different</option>
                                                        <option value="cost_dif">Cost Different</option>
                                                    </select>


                                                </div>
                                                <div class="col-sm-5"> <label> &nbsp; </label> </br> </div>

                                                <div id="close" class="close col-sm-2">
                                                    <label> &nbsp; </label> <i class="glyphicon glyphicon-remove">
                                                        <h4 style="color:red;"> Close </h4>
                                                    </i>

                                                </div>
                                                </br>

                                                <div id="tb1" style="width:100%;">
                                                    <div id="tb2" style="width:100%;">




                                                    </div>
                                                    <!--tb2-->
                                                </div>
                                                <!--tb1-->



                                            </div>



                                            <!-- Item price and cost edit all branch---------------------------------------------------------------------------->


                                            <!-- body inputarea strat-->
                                            <div id="inputarea1">




                                                <form action="" method="Post" class="dropzone" name="itm_form" style="border: 0px;" id="itm_form" enctype="multipart/form-data" autocomplete="off">

                                                    <!-- row start--------------------------------------------------------------------------------------------------------->
                                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                                        <img src="../img/ajax-loaders/ajax-loader-1.gif" id="itm-loaders" style="float:left; width:30px;" />
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-6 col-xs-6">

                                                            <?php


                                                            $qry_lst = $mysqli->query("SELECT ii.`ItemNO`,ii.`Description`,ii.`Sprice`,ii.`Date` FROM `itemtable` ii JOIN br_stock bb ON ii.ID = bb.itm_id 
                                                                                        WHERE bb.br_id = '$br_id' ORDER BY bb.`ID` DESC Limit 1");
                                                            $lst_itm = $qry_lst->fetch_array();

                                                            $sql_lastBilled = $mysqli->query("SELECT Date FROM invitem WHERE br_id = '$br_id' AND ItemNo = '$lst_itm[ItemNO]' ORDER BY ID DESC LIMIT 01");
                                                            $lastBilled = $sql_lastBilled->fetch_assoc()['Date'];

                                                            $sql_lastPurch = $mysqli->query("SELECT Date FROM purchitem WHERE br_id = '$br_id' AND ItemNo = '$lst_itm[ItemNO]' ORDER BY ID DESC LIMIT 01");
                                                            $lastPurch = $sql_lastPurch->fetch_assoc()['Date'];

                                                            echo '<span style="text-align:left;"><p style="margin-top:-15px; color:#C94D0C; font-size:15px;" lastIns="'.$lst_itm['ItemNO'].'" class="lastIns"> <u><b>Last Insert Item</b></u><br> Code : ' . $lst_itm[0] . '&nbsp;&nbsp;&nbsp;&nbsp; Name : ' . $lst_itm[1] . '<br> Price:' . $lst_itm[2] . '&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    Last Invoiced Date: ' . $lst_itm[3] . ' <br><br> <span id="lastBilled"></span> &nbsp;&nbsp;&nbsp;&nbsp; <span id="lastPurchased"></span><br><span id="createdDate"></span></span></p>
                                                                    ';
                                                            ?>
                                                        </div>


                                                        <div class="col-sm-6 col-md-6 col-xs-6">

                                                            <button type=" submit" class="bt_img" id="bt_img" name="bt_img" hidden>
                                                                image
                                                            </button>





                                                            <button type="submit" class="sbt bt_update2" id="bt_update2" name="bt_update2" disabled style="background: rgb(212, 212, 212); border-radius:5px; float:right; display:none;">
                                                                <a class="button button-green"> <i class="glyphicon glyphicon-check"></i>
                                                                    <strong>Update</strong> </a>
                                                            </button>

                                                            <button type="button" class="sbt bt_delete" id="bt_delete" name="bt_delete" style="border-radius:5px; float:right; background-color:#d02020; display:none;">
                                                                <a class="button button-green"> <i class="glyphicon glyphicon-trash"></i>
                                                                    <strong>Delete</strong> </a>
                                                            </button>

                                                            <button type="submit" class="sbt bt_save" id="bt_save" name="bt_save" style="border-radius:5px; float:right;">
                                                                <a class="button button-green"> <i class="glyphicon glyphicon-floppy-saved"></i>
                                                                    <strong>Save</strong> </a>
                                                            </button>

                                                            <button type="BUTTON" class="sbt bt_down" id="bt_down" name="bt_down" hidden>
                                                                <a class="button button-green"> <i class="glyphicon glyphicon-download"></i>
                                                                    <strong>Item TB</strong> </a>
                                                            </button>
                                                            <br>

                                                        </div>
                                                    </div>

                                                    <br><br>

                                                        <div class="row">
                                                            <div class="form-group col-sm-3 col-md-3 col-xs-12">
                                                                <label>Select Category</label>
                                                                <div style="position: relative;">
                                                                    <input id="com_cat" type="text" list="itmList" name="com_cat" class="form-control txt-auto com_cat charKey" placeholder="" style="font-size:14px;">
                                                                    <!--<span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <br><br>
                                                    <fieldset>
                                                        <legend style="width:auto;border-bottom:0px;font-size:16px;font-weight:bold;margin-bottom:0px;">
                                                            General Details</legend>
                                                        <div class="row">
                                                            <div class="form-group col-sm-2 col-md-2 col-xs-12">
                                                                <label style="margin-top:-4px;"> <input type="checkbox" name="at_id" id="at_id" class="at_id" value="at_id">
                                                                    <input type="checkbox" name="copy_barcode" id="copy_barcode" title="This is copy the same Item Code as barcode">
                                                                    Item No </label>
                                                                <input id="itm_no2" type="text" fixedCode="<?php echo $fixCode; ?>" list="itmList" name="itm_no2" class="chaBlock form-control txt-auto stock TxtID charKey fixCodes" placeholder="" style="font-size:14px;" autofocus required onkeyup="syncBarcode();" > 
                                                                <span class="charCount " style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                            </div>

                                                            <div class="form-group col-sm-7 col-md-7 col-xs-12">
                                                                <label>Item Name</label>
                                                                <div style="position: relative;">
                                                                    <input id="itm_name" type="text" name="itm_name" class="form-control itm_name charKey" placeholder="" style="text-transform: none;" required>
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-sm-3 col-md-3 col-xs-12">
                                                                <label>Category</label>
                                                                <div style="position: relative;">
                                                                    <input id="com_cat" type="text" list="itmList" name="com_cat" class="form-control txt-auto com_cat charKey" placeholder="" style="font-size:14px;">
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label>1<sup>st</sup> Unit</label>
                                                                <div style="position: relative;">
                                                                    <input id="mesure1" type="text" name="mesure1" class="form-control txt-auto mesure1 charKey" onClick="this.select();" placeholder="" list="lst_unit1">

                                                                    <datalist id="lst_unit1" size="11">
                                                                        <?php

                                                                        $query = $mysqli->query("SELECT DISTINCT `Unit` FROM `itemtable`   ");
                                                                        while ($row = $query->fetch_array()) {
                                                                            $unit = $row['Unit'];
                                                                            echo ' <option value="' . $unit . '">';
                                                                        }

                                                                        ?>

                                                                    </datalist>
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>

                                                            </div>

                                                                <div class="form-group col-md-4 col-sm-4 col-xs-12 showCost">
                                                                    <label>Cost</label>
                                                                    <input type="text" name="cost1" class="form-control cost1 text_box" placeholder="0" 
                                                                        onkeypress='return IsNumeric(event)' 
                                                                        onClick="this.select();" 
                                                                        onkeyup="calculateProfit();"  style="text-align:right;">
                                                                    <div id="profitDisplay" style="font-weight:bold; margin-top: 5px; color: #28a745; font-size: 13px; text-align: right;"></div>
                                                                </div>
                                                                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                    <label>Sales Price</label>
                                                                    <input type="text" name="sprice1" class="form-control sprice1 text_box" placeholder="0" 
                                                                        onkeypress='return IsNumeric(event)' 
                                                                        onClick="this.select();" 
                                                                        onkeyup="calculateProfit();"  style="text-align:right;">
                                                                </div>

                                                                <script>
                                                                function calculateProfit() {
                                                                    // 1. Get Values
                                                                    var cost = parseFloat(document.getElementsByName('cost1')[0].value) || 0;
                                                                    var price = parseFloat(document.getElementsByName('sprice1')[0].value) || 0;

                                                                    // 2. Calculate Profit Amount
                                                                    var profit = price - cost;

                                                                    // 3. Calculate Profit Percentage (based on cost)
                                                                    var percentage = 0;
                                                                    if (cost !== 0) {
                                                                        percentage = (profit / cost) * 100;
                                                                    } else if (profit > 0) {
                                                                        // Handle case where cost is 0 but there is a profit (e.g., free item sold for 50)
                                                                        percentage = Infinity; // Or set to a high value like 1000000 to represent a massive return
                                                                    }
                                                                    
                                                                    // 4. Update Display
                                                                    var profitDisplay = document.getElementById('profitDisplay');
                                                                    
                                                                    if (!isNaN(profit) && isFinite(percentage)) {
                                                                        // Format the output string
                                                                        var outputText = 'Profit: ' + profit.toFixed(2) + ' (' + percentage.toFixed(2) + '%)';
                                                                        
                                                                        profitDisplay.textContent = outputText;
                                                                        profitDisplay.style.color = profit >= 0 ? 'green' : 'red';
                                                                    } else if (percentage === Infinity) {
                                                                        // Special case for cost=0, profit > 0
                                                                        profitDisplay.textContent = 'Profit: ' + profit.toFixed(2) + ' (Infinite %!)';
                                                                        profitDisplay.style.color = 'green';
                                                                    } else {
                                                                        // Handle invalid numbers
                                                                        profitDisplay.textContent = '';
                                                                    }
                                                                }

                                                                function syncBarcode() {
                                                                    var itemNoInput = document.getElementById('itm_no2');
                                                                    var barcodeInput = document.getElementById('barcode_1');
                                                                    var copyCheckbox = document.getElementById('copy_barcode');

                                                                    if (copyCheckbox.checked) {
                                                                        barcodeInput.value = itemNoInput.value;
                                                                    }
                                                                }

                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                    var itemNoInput = document.getElementById('itm_no2');
                                                                    var barcodeInput = document.getElementById('barcode_1');
                                                                    var copyCheckbox = document.getElementById('copy_barcode');
                                                                    var costInput = document.getElementsByName('cost1')[0];
                                                                    var priceInput = document.getElementsByName('sprice1')[0];

                                                                    if (costInput) costInput.addEventListener('input', calculateProfit);
                                                                    if (priceInput) priceInput.addEventListener('input', calculateProfit);

                                                                    copyCheckbox.addEventListener('change', function() {
                                                                        if (this.checked) {
                                                                            barcodeInput.value = itemNoInput.value;
                                                                        } else {
                                                                            barcodeInput.value = '';
                                                                        }
                                                                    });
                                                                });
                                                                </script>





                                                        </div>
                                                        <label hidden>Vendor ID </label>
                                                        <input id="vendor_id" type="hidden" name="vendor_id" value="0" class="txt_sty vendor_id hiddnCls" tabindex="100" data-skip-on-tab="true">

                                                    </fieldset>
                                                    <fieldset>
                                                        <legend style="width:auto;border-bottom:0px;font-size:16px;font-weight:bold;margin-bottom:0px;">
                                                            Product Hierarchy</legend>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label>Type </label>
                                                                <div style="position: relative;">
                                                                    <input id="text_box" type="text" name="itm_type" class="form-control  itm_type charKey" placeholder="">
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                                <div id="typeVal" class="exCatD"></div>
                                                            </div>


                                                            <?php
                                                            $sfont = '';
                                                            $com_id = trim($_SESSION['COM_ID']);
                                                            if ($com_id == 320) {
                                                                $sfont = 'font-family:Dinesh;';
                                                            }

                                                            ?>


                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label id="ven_id" for="ven_id">Vendor Name</label>
                                                                <div style="position: relative;">
                                                                    <input id="ven_name" type="text" name="ven_name" class="form-control ven_name charKey" placeholder="">
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">

                                                                <label> Section </label>
                                                                <div style="position: relative;">
                                                                    <input id="com_section" type="text" list="itmList" name="com_section" class="charKey form-control txt-auto com_section" placeholder="" style="font-size: 10px;">
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label>Extra Category </label>
                                                                <div style="position: relative;">
                                                                    <input id="text_box" type="text" name="ex_cate" class="charKey form-control ex_cate" style="text-transform: none; <?php echo $sfont; ?> " placeholder="">
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                                <div id="extraCatDiv" class="exCatD"></div>
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label> Section-2 </label>
                                                                <select id="com_section2" name="com_section2" class="form-control txt-auto com_section2" style="font-size: 14px;">
                                                                    <option></option>
                                                                    <?php
                                                                    $sql_itemLocation = $mysqli->query("SELECT location, name FROM itm_location WHERE br_id='$br_id'");
                                                                    while ($itemLocation = $sql_itemLocation->fetch_assoc()) {
                                                                        echo '
                                                                        <option value="' . $itemLocation['location'] . '">' . $itemLocation['name'] . '</option>
                                                                        ';
                                                                    }
                                                                    /*
                                                                    $qry_section = $mysqli->query("SELECT `path` FROM `pages` WHERE `page_title`= 'control_Section'");
                                                                    while ($rst_section = $qry_section->fetch_array()) {
                                                                        echo '<option value="' . $rst_section[0] . '" > ' . $rst_section[0] . ' </option>';
                                                                    }*/
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label> location </label>
                                                                <div style="position: relative;">
                                                                    <input id="text_box" type="text" name="location" class="form-control location hiddnCls charKey" placeholder="" readonly>
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                    <fieldset>
                                                        <legend style="width:auto;border-bottom:0px;font-size:16px;font-weight:bold;margin-bottom:0px;">
                                                            Price & Units</legend>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-xsm-4 col-xs-12">

                                                                <label>2<sup>nd</sup> Unit</label>
                                                                <input id="mesure2" type="text" name="mesure2" class="form-control txt-auto mesure2 text_box " placeholder="" style="font-size: 10px;  " list="lst_unit" />
                                                                <datalist id="lst_unit" size="11">
                                                                    <?php

                                                                    $query = $mysqli->query("SELECT DISTINCT `Unit` FROM `itemtable`   ");
                                                                    while ($row = $query->fetch_array()) {
                                                                        $unit = $row['Unit'];
                                                                        echo ' <option value="' . $unit . '">';
                                                                    }

                                                                    ?>

                                                                </datalist>


                                                            </div>

                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label>Sales price 2</label>

                                                                <input id="sprice2" type="text" name="sprice2" class="form-control sprice2 text_box" style="text-align:right;" placeholder="0" onClick="this.select();" onkeypress='return IsNumeric(event)'>
                                                            </div>

                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">

                                                                <label>Per Qty</label>

                                                                <input id="cost2" placeholder="Per Qty" height="25px" type="text" onkeypress='return IsNumeric(event)' onClick="this.select();" name="cost2" class="form-control cost2 text_box" style="text-align:right;">

                                                                <!--  <textarea id="text_box"  name="cost2" class="txt_sty"placeholder="0" >  </textarea> -->
                                                                <input id="cost3" class="cost3 hiddnCls" name="cost3" hidden>


                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label>Wl.Sale Cash Price </label>
                                                                <input id="text_box" type="text" name="wCash_price" class="form-control wCash_price text_box" placeholder="0" onkeypress='return IsNumeric(event)' onClick="this.select();" style="text-align:right;">
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label>Wl.Sale Credit Price </label>
                                                                <input id="text_box" type="text" name="wCredit_price" class="form-control wCredit_price text_box" placeholder="0" onkeypress='return IsNumeric(event)' onClick="this.select();" style="text-align:right;">
                                                            </div>
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label> Min.Sale Price </label>

                                                                <input id="m_price" type="text" name="m_price" class="form-control m_price text_box hiddnCls" onkeypress="return IsNumeric(event)" placeholder="0" onClick="this.select();" style=" text-align:right;">

                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label> <input type="checkbox" name="chk_disc" id="chk_disc" class="chk_disc hiddnCls" value="NO" style="font-size:9px;" title="Disable Discount"> Inv.Discount %
                                                                </label>
                                                                <input id="i_disco" type="text" onKeyPress="return IsNumeric(event)" name="i_disco" class="form-control i_disco text_box hiddnCls" placeholder="0" onClick="this.select();" style=" text-align:right;">
                                                            </div>


                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label> Pur.Discount % </label>
                                                                <input id="p_disc" type="text" onKeyPress="return IsNumeric(event)" name="p_disc" class="form-control p_disc hiddnCls" placeholder="0" onClick="this.select();" style="text-align:right;">
                                                            </div>


                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label> Min.Stock Level </label>
                                                                <input id="m_stock" type="text" onKeyPress="return IsNumeric(event)" name="m_stock" class="form-control m_stock hiddnCls" placeholder="0" onClick="this.select();" style="text-align:right;">
                                                            </div>
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12" style="margin:0 auto ;">
                                                                <label> Per.Order </label>
                                                                <input id="text_b1ox" type="text" web_showwa onKeyPress="return IsNumeric(event)" name="r_oder" class="form-control r_oder hiddnCls" onClick="this.select();" placeholder="0" style="text-align:right;">
                                                            </div>



                                                        </div>
                                                    </fieldset>
                                                    <fieldset>
                                                        <legend style="width:auto;border-bottom:0px;font-size:16px;font-weight:bold;margin-bottom:0px;">
                                                            Other Details</legend>
                                                        <div class="row">

                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label> Commis </label>
                                                                <input id="text_box" type="text" name="commis" class="form-control commis hiddnCls" placeholder="" onkeypress="return IsNumeric(event)">
                                                            </div>

                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label> Due Day </label>
                                                                <input id="text_box" type="text" name="due_day" class="form-control due_day hiddnCls" placeholder="" onkeypress="return IsNumeric(event)">
                                                            </div>
                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label>Per.Carton(Bundel)</label>
                                                                <input id="text_box" type="text" name="per_carton" class="form-control per_carton" placeholder="0" onkeypress='return IsNumeric(event)' style="text-align:right;">
                                                            </div>

                                                            <div class="form-group col-md-3 col-sm-3 col-xs-12">
                                                                <label> Warranty </label>
                                                                <div style="position: relative;">
                                                                    <input id="txt_wnty" type="text" name="txt_wnty" class="form-control txt_wnty hiddnCls charKey">
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label> NBT % </label>
                                                                <input id="text_box" type="text" name="txt_nbt" class="form-control txt_nbt hiddnCls" placeholder="" onkeypress="return IsNumeric(event)">
                                                            </div>

                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label> VAT % </label>
                                                                <input id="text_box" type="text" name="txt_vat" class="form-control  txt_sty due_day hiddnCls" placeholder="" onkeypress="return IsNumeric(event)">
                                                            </div>


                                                            <div class="form-group col-md-4 col-sm-4 col-xs-12">
                                                                <label> Build item %</label>
                                                                <input id="txt_bItmPer" type="text" name="txt_bItmPer" class="form-control txt_bItmPer hiddnCls" onKeyPress="return IsNumeric(event)" maxlength="2">
                                                            </div>
                                                        </div>
                                                        <div class="row" style="display: flex; justify-content: space-around; flex-wrap:wrap;">
                                                            <div> <label id="c_box" class="checkbox-inline warehouse  chk_type">
                                                                    <input type="checkbox" name="warehouse" id="warehouse" class="warehouse " value="YES">
                                                                    Warehouse </label> </div>

                                                            <div>
                                                                <label id="c_box" class="checkbox-inline rebate  chk_type"><input type="checkbox" name="rebate" id="rebate" class="rebate hiddnCls" value="rebate">
                                                                    Rebate/Discount</label>
                                                            </div>
                                                            <div> <label id="c_box" class="checkbox-inline non_stock chk_type"><input type="checkbox" name="non_stock" id="non_stock" class="non_stock hiddnCls " value="non_stock">
                                                                    Non-Stock</label> </div>
                                                            <div> <label id="c_box" class="checkbox-inline manu_itm chk_type"><input type="checkbox" name="manu_itm" id="manu_itm" class="manu_itm hiddnCls " value="manu_itm">
                                                                    Manufacturing </label> </div>
                                                            <div> <label id="c_box" class="checkbox-inline ch_active chk_type"><input type="checkbox" name="ch_active" id="ch_active" class="ch_active hiddnCls " value="ch_active">Inactive</label> </div>

                                                            <div> <label id="c_box" class="checkbox-inline ch_sirNo chk_type"><input type="checkbox" name="ch_sirNo" id="ch_sirNo" class="ch_sirNo hiddnCls " value="YES" title="Serial No is compulsory"> Serial
                                                                    No</label> </div>
                                                            <div> <label id="c_box" class="checkbox-inline ch_imei chk_type"><input type="checkbox" name="ch_imei" id="ch_imei" class="ch_imei hiddnCls " value="YES">
                                                                    Imei</label> </div>
                                                        </div>
                                                        <br>

                                                        <div class="row">
                                                            <div class="form-group col-md-10 col-sm-10 col-xs-12">
                                                                <label>Item Description</label>
                                                                <div style="position: relative;">
                                                                    <textarea class="form-control ex_description charKey" style="width: 100%;" rows="5" name="ex_description" id="txt_area"> </textarea>
                                                                    <span class="charCount" style="background-color:#9c9fe5; padding:2px; color:white; border-radius:50%; width:23px; height:23px; position: absolute; top: 73%; right: 5px; transform: translateY(-50%);">0</span>
                                                                </div>
                                                            </div>
                                                            <div class="row col-md-2 col-sm- col-xs-12">
                                                                <label>&nbsp;</label>
                                                                <div class="avatar-upload">
                                                                    <div class="avatar-edit">
                                                                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="fileToUpload" class="imageUpload fileToUpload col-xs-12" />
                                                                        <label for="imageUpload"></label>
                                                                    </div>
                                                                    <div class="avatar-preview">

                                                                        <img class="profile-user-img img-responsive img-box col-xs-12" id="imagePreview" src="/Home/img_items/no_pic.jpg" alt="item image" style="border-radius:4px; height: 111px;">
                                                                    </div>
                                                                </div>



                                                            </div>
                                                        </div>


                                                        <!-- check box -->
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-7">
                                                                <label> Price Level <input type="radio" name="chk_price" value="priceCls" ID="chk_price" class="rdb_price" checked /> &nbsp;
                                                                    &nbsp;</label>
                                                                <label> Section/Location <input type="radio" name="chk_price" value="iLocateCls" ID="itmLocationFaz" class="rdb_price" /> &nbsp; <br>
                                                                    &nbsp;</label>
                                                                <label> Barcode <input type="radio" name="chk_price" value="bcodeCls" ID="chk_bcode" class="rdb_price" />
                                                                </label>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-12">

                                                            <div class="col-md-12 col-sm-12 col-xs-12 row">
                                                                <div class="bcodeCls barcode hidCls row" style="display:none; width:100%">
                                                                    <div class="col-md-12">
                                                                        <input type="hidden" name="no_bcode" id="no_bcode" value="1" />
                                                                        <input type="text" name="barcode_1" class="barcode_1 txt_barcode col-md-4 col-sm-4 col-xs-12" id="barcode_1" style="margin: 5px 20px 0 0; border-radius: 5px;height:30px;border:1px solid rgba(0,0,0,0.1);" placeholder=" Barcode 1" />

                                                                        &nbsp; &nbsp; <input type="button" class="bt_bcode col-md-2 col-sm-2 col-xs-12 btn btn-info" value="Add Barcode" style="height:30px; margin-top:5px" />
                                                                    </div>
                                                                    <?php
                                                                    if ($user_type == 'Admin') {
                                                                        echo '
                                                                        <div style="text-align:center;" class="col-md-5">
                                                                        <a href="#" class="CopyItmCode" id="CopyItmCode"><i class="fa fa-copy"></i> &nbsp;Copy item code as barcode</a>
                                                                    </div>
                                                                        ';
                                                                    }
                                                                    ?>

                                                                </div>


                                                                <div class="iLocateCls hidCls" style="display:none;">
                                                                    <table class="table  table-bordered bootstrap-datatable table-hover  responsive ">
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th> Branch </th>
                                                                            <th> Location </th>
                                                                        </tr>


                                                                        <?php
                                                                        $brTrialQry = "";
                                                                        if($com_id == '001'){
                                                                            $brTrialQry = " AND ID = '$br_id'";
                                                                        }
                                                                        
                                                                        $qry_location = $mysqli->query("SELECT br_area FROM `br_stock` where br_area != '' group by br_area");
                                                                        $loc_list = '';
                                                                        while ($rst_location = $qry_location->fetch_array()) {
                                                                            $loc_list .= '<option value="' . $rst_location['br_area'] . '"> ' . $rst_location['br_area'] . '</option>';
                                                                        }

                                                                        $brnm = $mysqli->query("select * from com_brnches WHERE 1=1 $brTrialQry");
                                                                        $t = 1;
                                                                        while ($b = $brnm->fetch_array()) {
                                                                            echo '
                                                                            <tr>
                                                                        <th>' . $t++ . '</th>
                                                                            <th>' . $b['name'] . '</th>
                                                                            <th><input type="hidden" name="brLocateID[]" value ="' . $b['ID'] . '" ><input type="text" name="brLocateNm[]" style="border-radius:5px;border:1px solid rgba(0,0,0,0.1); width:100%" 
                                                                            list="loclst" >
                                                                            <datalist id="loclst">' . $loc_list;

                                                                            echo '</datalist></th>
                                                                        </tr>
                                                                            ';
                                                                        }

                                                                        ?>

                                                                    </table>

                                                                </div>

                                                                <div class="col-md-12 col-sm-12 col-xs-12 hidCls price_lvl priceCls">
                                                                    <table class="table  table-bordered bootstrap-datatable table-hover  responsive" style="border:1px solid rgba(0,0,0,0.1); width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th width="100px"> </th>
                                                                                <th> Level 1 </th>
                                                                                <th> Level 2 </th>
                                                                                <th> Level 3 </th>
                                                                                <th> Level 4 </th>
                                                                                <th> Level 5 </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <th> Dis % </th>

                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvlDis_1" id="lvlDis_1" class="lvlDis_1 lvlDis" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvlDis_2" id="lvlDis_2" class="lvlDis_2 lvlDis" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvlDis_3" id="lvlDis_3" class="lvlDis_3 lvlDis" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvlDis_4" id="lvlDis_4" class="lvlDis_4 lvlDis" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvlDis_5" id="lvlDis_5" class="lvlDis_5 lvlDis" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th> Price </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvl_1" id="lvl_1" class="lvl_1 lvl" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvl_2" id="lvl_2" class="lvl_2 lvl" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvl_3" id="lvl_3" class="lvl_3 lvl" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvl_4" id="lvl_4" class="lvl_4 lvl" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                                <th> <input type="text" style="width:100%; border:1px solid rgba(0,0,0,0.1);border-radius:5px" name="lvl_5" id="lvl_5" class="lvl_5 lvl" value="0" onkeypress='return IsNumeric(event)' onClick="this.select();"> </th>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <!-- check box -->
                                                            <?php
                                                            $hd_br = '';
                                                            if ($user_type == 'User') {
                                                                if ($user_view == 'Show') {

                                                                    $hd_br = 'display:none;';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </fieldset>


                                                    <fieldset style=" <?php echo $hd_br; ?> ">
                                                        <div class="branch">
                                                            <legend style="width:auto;border-bottom:0px;font-size:16px;font-weight:bold;margin-bottom:0px;">
                                                                Click the branch
                                                                name to copy other branch.</legend>



                                                            <div class="row">
                                                                <div class="col-sm-3">

                                                                    <label id="c_box" class="checkbox-inline rebate">
                                                                        <input type="checkbox" name="br_all" id="br_all" class="br_all hiddnCls " value="br_all">
                                                                        All </label>
                                                                </div>


                                                                <?php

                                                                $sql_branch = $mysqli->query(" SELECT `ID`,`name`  FROM `com_brnches` WHERE 1=1 $brTrialQry ORDER BY `com_brnches`.`name` ASC ");
                                                                $br_count = '0';

                                                                while ($branch = $sql_branch->fetch_array()) {
                                                                    $br_count = $sql_branch->num_rows;
                                                                    $_SESSION['br_coun'] = $br_count;
                                                                    $br_i++;

                                                                    $branch_id = $branch[0];
                                                                    $branch_name = $branch[1];


                                                                    if ($br_id == $branch_id) {
                                                                        //echo 'br coun '.$branch_id. ' i '.$br_id;
                                                                        echo '  <div class="col-sm-2 col-md-2"> <label id="c_box" class="checkbox-inline rebate" style="font-size:9px;">
                        <input type="checkbox" name="chk_br[]" id="chk_br" class="chk_br hiddnCls" value="' . $branch_id . '" checked />
                         ' . $branch_name . '  </label>  </div>';
                                                                    } else {
                                                                        echo '  <div class="col-sm-2 col-md-2"> <label id="c_box" class="checkbox-inline rebate" style="font-size:9px;">
                        <input type="checkbox" name="chk_br[]" id="chk_br" class="chk_br hiddnCls" value="' . $branch_id . '" />
                         ' . $branch_name . ' </label>  </div>';
                                                                    }

                                                                    //echo '<option value="'.$branch_id.'"   data-id="'.$branch_name.'"  > '.$branch_name.'</option>';

                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-sm-6">

                                                                    <label id="all_box" class="checkbox-inline">
                                                                    <input type="checkbox" name="minPer" id="minPer" class="minPer" value="minPer">
                                                                    <span style="font-size:11px;">Click here to save Min.Stock level & Per Order to All above checked branches </span></label>
                                                                    
                                                                    <label id="all_box" class="checkbox-inline" style="margin: 0;">
                                                                    <input type="checkbox" name="updCostPr" id="updCostPr" class="updCostPr" value="updCostPr">
                                                                    <span style="font-size:11px;">Click here to save Cost Price to all above checked branches </span></label>
                                                                    
                                                                    <label id="all_box" class="checkbox-inline" style="margin: 0;">
                                                                    <input type="checkbox" name="updSalePr" id="updSalePr" class="updSalePr" value="updSalePr">
                                                                    <span style="font-size:11px;">Click here to save Sales Price to all above checked branches </span></label>
                                                            </div>
                                                            
                                                            
                                                        </div>


                                                    </fieldset>

                                                    <div class="col-sm-2" style="margin-top:10px;">

                                                        <label id="c_box" class="checkbox-inline">
                                                            <input type="checkbox" name="br_show" id="br_show" class="br_show" value="br_show">
                                                            <span style="font-size:11px;">Show</span> </label>
                                                    </div>

                                                    <div class="col-sm-12">


                                                        <!-- submit button-->
                                                        <div class="col-sm-12"> &nbsp;
                                                            <div id="web_inf" class="web_inf" style=" display:none; border-radius:8px; background:#f9fafc; height:55px; ">

                                                                <div class="col-sm-3">
                                                                    <label id="LBweb_price">Web Price</label>
                                                                    <input id="web_price" type="TEXT" name="web_price" class="txt_sty web_price" placeholder="">
                                                                </div>
                                                                <div class="col-sm-5">

                                                                    <label id="LBweb_pr" style="width:100%;">&nbsp;
                                                                    </label>

                                                                    <label id="LBweb_price" style="padding-right:10px;">Do Not Show &nbsp;
                                                                        <input type="CHECKBOX" name="chk_block" id="chk_block" class="chk_block" value="NO" />
                                                                    </label>
                                                                    &nbsp; &nbsp;
                                                                    <label id="LBweb_price" style="">| Do Not Show
                                                                        Zero(0) Stock Items &nbsp;
                                                                        <input id="zero_blk" type="CHECKBOX" name="zero_blk" class="zero_blk" value="NO">
                                                                    </label>

                                                                </div>
                                                                <div class="col-sm-3">

                                                                </div>

                                                            </div>

                                                        </div>


                                                        <!-- submit button-->

                                                    </div>




                                                </form>



                                            </div>
                                            <!-- body inputarea end-->

                                            <!-- body side2 strat-->
                                            <div id="side2">



                                            </div>
                                            <!-- body side2 end-->

                                        </div>
                                        <!-- body wrapper end-->

                                    </div>
                                    <!-- body conten -->

                                </div>
                            </div>
                        </div>


                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h2><i class="fa fa-align-left"></i> Item List<small></small></h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">

                                    <!-- body conten -->
                                    <div class="box-content">

                                        <!-- table search -->

<div class="form-group status-filter-group" style="margin-bottom: 20px;">
    <label class="activesr-radio-inline">All
        <input type="radio" name="statusFilter" value="all" checked>
        <span class="checkmark"></span>
    </label>
    <label class="activesr-radio-inline">Active
        <input type="radio" name="statusFilter" value="active">
        <span class="checkmark"></span>
    </label>
    <label class="activesr-radio-inline">Inactive
        <input type="radio" name="statusFilter" value="inactive">
        <span class="checkmark"></span>
    </label>
</div>

                                        <div class="load_itm">

                                            <table id="employee_grid" class="table table-striped table-bordered bootstrap-datatable responsive table-hover tblnth col-md-12 col-xs-12 col-sm-12" style="width: 100%;">
                                                <thead>
                                                    <tr>

                                                        <th width="10px">Item No</th>
                                                        <th>Item name</th>
                                                        <th width="10px">Category</th>
                                                        <th width="10px">Price</th>
                                                        <th width="10px">Stock</th>

                                                    </tr>
                                                </thead>

                                            </table>

                                        </div>


                                        <!-- image ----------------------------------------------------------------------------------->
                                        <input type="hidden" id="db_name" name="db_name" value="<?php echo $db_name; ?>" class="db_name" />

                                        <!--- Image ---------------------------------------------------------------------------------->

                                        <!--table -->

                                    </div>
                                    <!-- body conten -->

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

            <!-- passowrd modal start -->
            <div class="modal" tabindex="-1" role="dialog" id="passwordModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Enter your password for confirmation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="confPassword" id="confPassword" class="form-control confPassword" placeholder="Enter your password">
                            <span style="color:red;">Data cannot be restored!</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger confPasswordBtn">Confirm</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- password modal end -->


            <!-- /page content -->
            <?php include($path . 'footer.php') ?>
            <!-- content ends -->



            <script>
                $(document).on('change', ".imageUpload", function(data) {
                    var imageFile = data.target.files[0];
                    var reader = new FileReader();
                    reader.readAsDataURL(imageFile);
                    reader.onload = function(evt) {

                        $("#imagePreview").attr("src", evt.target.result);
                        $("#imagePreview").hide();
                        $("#imagePreview").fadeIn(650);
                    };
                });


                $('.bt_update2').hide();
                $('.bt_delete').hide();

                function checkSize(max_img_size) {
                    //alert('ok');
                    var input = document.getElementById("fileToUpload");
                    // check for browser support (may need to be modified)
                    if (input.files && input.files.length == 1) {
                        if (input.files[0].size > max_img_size) {
                            alert("The file must be less than " + (max_img_size / 1024 / 1024) + "MB");
                            return false;
                        }
                    }

                    return true;
                }

                $(document).on('click', '.web_show', function() {
                    $('#web_inf').show(1000);
                    $('.bt_web').addClass('web_hide');
                    $('.bt_web').removeClass('web_show');
                });

                $(document).on('click', '.web_hide', function() {
                    $('#web_inf').hide(1000);
                    $('.bt_web').addClass('web_show');
                    $('.bt_web').removeClass('web_hide');
                });

$(document).ready(function() {

    var itemTable = $('#employee_grid').DataTable({
        responsive: {
            details: {
                type: 'column'
            }
        },
        "bProcessing": true,
        "serverSide": true,
        "ajax": {
            url: "ajx/load_items2.php",
            type: "post",
            "data": function(d) {
                d.statusFilter = $('input[name="statusFilter"]:checked').val();
            },
            error: function() {
                $("#employee_grid_processing").css("display", "none");
            }
        }
    });

    $('input[name="statusFilter"]').on('change', function() {
        itemTable.draw();
    });

});

                $(document).on('click', '.load_bt', function() {

                    var ky_word = $('.keyword').val();

                    //alert (itm_no);
                    $.ajax({
                        'url': 'ajx/load_items.php',
                        method: 'post',
                        'data': {
                            word: ky_word
                        },
                        success: function(data) {
                            if (data != '') {
                                $('.load_itm').html('');
                                $('.load_itm').html(data);
                            }
                        }
                    })

                });

                $(document).on('click', '.bt_bcode', function() {
                    var no = parseInt($('#no_bcode').val()) + 1;
                    //alert(no);
                    $('.bt_bcode').before('<input type="text" name="barcode_' + no +
                        '" id="barcode_' + no + '" class="txt_barcode barcode_' + no +
                        '  col-md-4 col-xs-12 col-sm-4" style="margin:5px 20px 0 0; border-radius: 5px;height:30px;border:1px solid rgba(0,0,0,0.1);" placeholder=" Barcode ' +
                        no + '" > &nbsp; &nbsp;');
                    $('#no_bcode').val(no);
                    $('#barcode_' + no).focus();
                });

                $(document).on('click', '.rdb_price', function() {
                    var ID = $(this).val();
                    $('.hidCls').css('display', 'none');
                    $('.' + ID).css('display', 'block');
                });


                $('body').on('keypress', 'input', function(evt) {
                    $('#typeVal').hide();
                    $('#extraCatDiv').hide();
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


                $(document).ready(function() {
                    // get barcode
                    function get_barcode() {

                        var itm_no = $('#itm_no2').val();

                        //alert (itm_no);
                        $.ajax({
                            'url': 'ajx/get_barcode.php',
                            method: 'post',
                            'data': {
                                item: itm_no
                            },
                            success: function(data) {
                                if (data != '') {
                                    $('.barcode').html('');
                                    $('.barcode').html(data);
                                }
                            }
                        })

                    }

                    function iLocateCls() {

                        var itm_no = $('#itm_no2').val();

                        //alert (itm_no);
                        $.ajax({
                            'url': 'ajx/get_iLocateCls.php',
                            method: 'post',
                            'data': {
                                item: itm_no
                            },
                            success: function(data) {
                                if (data != '') {
                                    $('.iLocateCls').html('');
                                    $('.iLocateCls').html(data);
                                }
                            }
                        })

                    }


                    // branch checked
                    function chk_baranch() {
                        $('.branch2').remove();
                        var itm_no = $('#itm_no2').val();

                        //alert (itm_no);
                        $.ajax({
                            'url': 'ajx/get_chk_branch.php',
                            method: 'post',
                            'data': {
                                item: itm_no
                            },
                            success: function(data) {
                                $('#ajaxloaderUserUpdate').hide();
                                $('.branch').html(data);
                            }
                        })
                    }


                    // item id
                    $('.stock').keyup(function() {
                        //alert('OK')
                        $("#rebate").prop("checked", false);
                        $("#non_stock").prop("checked", false);
                        $("#manu_itm").prop("checked", false);
                        $("#ch_active").prop("checked", false);
                        $("#ch_imei").prop("checked", false);
                        $('#itm-loaders').show();

                        var stk = $('#itm_no2').val();

                        autoTypeNo = 0, autoTypeNo1 = 2;
                        //$(this).autocomplete({
                        //	source: function( request, response ) {
                        $.ajax({
                            url: 'ajx/get_itm_no.php',
                            //dataType: "json",
                            method: 'post',
                            data: {
                                TYPE: stk

                            },
                            success: function(data) {
                                // response( $.map( data, function( item ) {
                                var code = data.split('|');
                                //alert('OK '+code[2] );
                                var itm = document.getElementsByName('itm_no2')[0].value;
                                if (code[2] == stk) {
                                    //alert('ok');
                                    //$('#itm-loaders').hide();
                                    $('#itm_no2').css('color', '#0CCC0F');
                                } else if (code[2] != stk) {
                                    //alert(code[2]);
                                    $('#itm_no2').css('color', 'red');
                                }

                                $('#itm-loaders').hide();

                                //}));
                            }
                        });
                        //}

                    });

                    //recall itm id
                    function itm_det(stk) {

                        //alert ('itm det');
                        //alert('OK');
                        var img_path = '<?php echo $_SESSION['DB']; ?>';
                        $("#rebate").prop("checked", false);
                        $("#non_stock").prop("checked", false);
                        $("#manu_itm").prop("checked", false);
                        $("#ch_active").prop("checked", false);
                        $("#warehouse").prop("checked", false);
                        $("#chk_disc").prop("checked", false);

                        $('#itm-loaders').show();
                        $.ajax({
                            url: 'ajx/get_itm_no.php',
                            method: 'post',
                            data: {
                                TYPE: stk

                            },
                            success: function(data) {
                                var showCost = <?php echo json_encode($showCost); ?>;
                                if (showCost == 'Yes') {
                                    $('.showCost').show();
                                } else {
                                    $('.showCost').hide();
                                }

                                var code = data.split('|');

                                //alert('OK inside');
                                $('#itm-loaders').hide();
                                $('.sprice1').val(code[3]);
                                $('#itm_name').val(code[1]);
                                $('.cost1').val(code[4]);
                                $('.itm_type').val(code[28]);
                                $('.ex_cate').val(code[32]);
                                $('#vendor_id').val(code[31]);

                                //alert('|'+code[35]+'|');
                                $('#ven_name').val(code[34]);
                                //alert(code[33]);
                                /*document.getElementById('vendor_id').value=val(names[31]);*/

                                //	$('#cat_id').val(code[13]);
                                $('.per_carton').val(code[21]);
                                $('.mesure1').val(code[29]);
                                $('.mesure2').val(code[30]);
                                $('.sprice2').val(code[26]);
                                $('.cost2').val(code[15]);
                                $('.m_price').val(code[18]);

                                $('.i_disco').val(code[16]);
                                $('.dpk_date').val(code[11]);
                                $('#bil_date').val(code[11]);


                                $('.m_stock').val(code[24]);
                                $('.r_oder').val(code[22]);
                                $('.location').val(code[17]);
                                //$('.b_stock').val(code[12]);
                                $('.com_section').val(code[25]);
                                $('.ex_description').val(code[27]);
                                $('.com_cat').val(code[13]);
                                $('#cost3').val(code[14]);


                                if (code[23] == '1') {
                                    $("#rebate").prop("checked", true);
                                }
                                if (code[20] == '1') {
                                    $("#non_stock").prop("checked", true);
                                }
                                if (code[9] == '1') {
                                    $("#manu_itm").prop("checked", true);
                                }
                                if (code[8] == '1') {
                                    $("#ch_active").prop("checked", true);
                                }

                                if (code[35] == 'YES') {
                                    $("#warehouse").prop("checked", true);
                                }
                                //$('.ch_active').val(names[8]);
                                //alert(code[36]);
                                if (code[36] == 'NO') {
                                    $("#chk_disc").prop("checked", true);
                                    $('#i_disco').attr('readonly', true);
                                }

                                var price = code[3];;

                                $('.lvl_1').val(parseFloat(code[37]).toFixed(2));

                                $('.lvl_2').val(parseFloat(code[38]).toFixed(2));
                                $('.lvl_3').val(parseFloat(code[39]).toFixed(2));
                                $('.lvl_4').val(parseFloat(code[40]).toFixed(2));
                                $('.lvl_5').val(parseFloat(code[41]).toFixed(2));
                                $('.lvlDis_1').val(lvl_dis(code[37], code[3]).toFixed(2));
                                $('.lvlDis_2').val(lvl_dis(code[38], code[3]).toFixed(2));
                                $('.lvlDis_3').val(lvl_dis(code[39], code[3]).toFixed(2));
                                $('.lvlDis_4').val(lvl_dis(code[40], code[3]).toFixed(2));
                                $('.lvlDis_5').val(lvl_dis(code[41], code[3]).toFixed(2));

                                $('.commis').val(code[42]);
                                $('.due_day').val(code[43]);

                                $('.txt_nbt').val(code[44]);
                                $('.txt_vat').val(code[45]);
                                $('.p_disc').val(code[46]);
                                $('.txt_wnty').val(code[47]);
                                $('.web_price').val(code[48]);
                                $('#lastBilled').text("Last Billed: " + code[58]);
                                $('#lastPurchased').text("Last Purchased: " + code[59]);
                                $('#createdDate').text("Created Date: " + code[11]);
                                if (code[57] == 'br_show') {
                                    $('#br_show').prop('checked', true)
                                } else {
                                    $('#br_show').prop('checked', false)
                                }

                                if (code[49] == 'NO') {
                                    $("#chk_block").prop("checked", true);
                                }
                                if (code[50] == 'NO') {
                                    $("#zero_blk").prop("checked", true);
                                }

                                var itm_no = code[2];

                                $('#itm_no2').css('color', '#0CCC0F');

                                $('.wCash_price').val(code[51]);
                                $('.wCredit_price').val(code[52]);
                                $('#com_section2').val(code[53]);
                                $('#txt_bItmPer').val(code[56]);
                                //reload_vend();
                                if (code[54] == 'YES') {
                                    $("#ch_sirNo").prop("checked", true);
                                }

                                if (code[55] == 'YES') {
                                    $("#ch_imei").prop("checked", true);
                                }

                                $('#imagePreview')
                                    .attr('src', '../img_items/' + img_path + '/' + itm_no +
                                        '.jpg?rand=<?php echo rand(); ?>');


                                $('#imagePreview').error(function() {
                                    //  alert('Image does not exist !!');

                                    $('#imagePreview')
                                        .attr('src',
                                            'https://powersoftt.com/Home/img_items/no_pic.jpg');
                                });
                                calculateProfit();
                                // reader.readAsDataURL(input.files[0]);

                                $('.charKey').each(function() {
                                    charCount($(this));
                                });
                            }

                        });
                        chk_baranch();
                        get_barcode();
                        iLocateCls();

                    }
                    //recall itm id

                    //itm id


                    //check discount-------------
                    $(document).on('change', '#chk_disc', function() {

                        if ($(this).is(':checked')) {
                            $('#i_disco').val('0');
                            $('#i_disco').attr('readonly', true);

                        } else {
                            $('#i_disco').attr('readonly', false);

                        }


                    });


                    //check all baranch-------------
                    $(document).on('change', '#br_all', function() {


                        if ($(this).is(':checked')) {
                            $('input[id=chk_br]:checkbox').prop("checked", $(this).is(':checked'));
                            // $(this).attr('checked', 'checked');
                            //alert ('br all');
                            //$(".chk_br").attr('checked', 'checked');  // checked
                        } else {
                            $(".chk_br").removeAttr("checked");
                        }


                    });


                    $('#at_id').click(function() {
                        if (this.checked) {
                            // alert('OK inside');
                            var at_id = $('#at_id').val();
                            $.ajax({
                                url: 'ajx/get_itm_id.php',
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
                                    $('#itm_no2').val(id);

                                    $('.charKey').each(function() {
                                        charCount($(this));
                                    });

                                }

                            });

                        }else{
                            $('#itm_no2').val(''); 
                            $('.charKey').each(function() {
                                        charCount($(this));
                                    });
                        }

                    });

                    // get id


                    //category

                    $('.com_cat').keyup(function() {
                        //alert('OK')
                        autoTypeNo = 0, autoTypeNo1 = 2;
                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: 'ajx/get_category.php',
                                    dataType: "json",
                                    method: 'post',
                                    data: {
                                        TYPE: request.term
                                    },
                                    success: function(data) {
                                        response($.map(data, function(item) {
                                            var code = item.split("|");

                                            var tinput = document
                                                .getElementsByName(
                                                    'com_cat')[0].value
                                            if (code[2] == tinput) {
                                                //alert('ok');

                                                $('#com_cat').css(
                                                    'color',
                                                    '#0CCC0F');
                                            } else if (code[2] !=
                                                tinput) {
                                                //alert(code[2]);
                                                $('#com_cat').css(
                                                    'color', 'red');
                                            }

                                            return {


                                                label: code[autoTypeNo],
                                                value: code[
                                                    autoTypeNo1],
                                                data: item
                                            }
                                        }));
                                    }
                                });
                            },
                            autoFocus: false,
                            minLength: 0,
                            select: function(event, ui) {
                                var names = ui.item.data.split("|");
                                id_arr = $(this).attr('id');
                                //id = id_arr.split("_");

                                $('#cat_id').val(names[0]);
                                //$('#com_cat').val(names[1]);
                                $('#com_cat').css('color', '#0CCC0F');

                            }

                        });
                    });

                    // category

                    // get vendor

                    $('.ven_name').keyup(function() {
                        //alert('OK')
                        var cusID = $('.ven_name').val();
                        autoTypeNo = 0,
                            autoTypeNo1 = 1;
                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: 'ajx/VndrSch.php',
                                    dataType: "json",
                                    method: 'post',
                                    data: {
                                        Name: cusID
                                    },
                                    success: function(data) {
                                        response($.map(data, function(item) {
                                            var code = item.split("|");
                                            return {

                                                label: code[0],
                                                value: code[autoTypeNo],
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
                                //id = id_arr.split("_");

                                $('#vendor_id').val(names[4]);


                            }

                        });
                    });

                    // unit

                    $(".mesure11, .mesure22").keyup(function() {
                        //alert('OK')


                        var v = this.id;


                        autoTypeNo = 0, autoTypeNo1 = 2;

                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: 'ajx/get_unit.php',
                                    dataType: "json",
                                    method: 'post',
                                    data: {
                                        TYPE: request.term
                                    },
                                    success: function(data) {
                                        response($.map(data, function(item) {
                                            var code = item.split("|");

                                            //color change
                                            if (v == "mesure1") {
                                                var itm = document
                                                    .getElementsByName(
                                                        'mesure1')[0]
                                                    .value
                                                if (code[0] == itm) {
                                                    //alert('ok');
                                                    $('#mesure1').css(
                                                        'color',
                                                        '#0CCC0F');
                                                } else if (code[0] !=
                                                    itm) {
                                                    //alert(code[2]);
                                                    $('#mesure1').css(
                                                        'color',
                                                        'red');
                                                }
                                                // $('#mesure1').css('color', 'red');
                                                //alert(v);
                                            } else if (v == "mesure2") {

                                                var itm = document
                                                    .getElementsByName(
                                                        'mesure2')[0]
                                                    .value
                                                if (code[0] == itm) {
                                                    //alert('ok');
                                                    $('#mesure2').css(
                                                        'color',
                                                        '#0CCC0F');
                                                } else if (code[0] !=
                                                    itm) {
                                                    //alert(code[2]);
                                                    $('#mesure2').css(
                                                        'color',
                                                        'red');
                                                }

                                            }
                                            //color change

                                            return {
                                                label: code[autoTypeNo],
                                                value: code[
                                                    autoTypeNo1],
                                                data: item
                                            }
                                        }));
                                    }
                                });
                            },
                            autoFocus: false,
                            minLength: 0,
                            select: function(event, ui) {
                                var names = ui.item.data.split("|");
                                id_arr = $(this).attr('id');
                                //id = id_arr.split("_");

                                if (v == "mesure1") {
                                    $('#mesure1').val(names[0]);
                                    $('#mesure1').css('color', '#0CCC0F');
                                    //alert(v);
                                } else if (v == "mesure2") {
                                    $('#mesure2').val(names[0]);
                                    $('#mesure2').css('color', '#0CCC0F');
                                    //alert(v);
                                }

                                //$('#ven_name').val(names[1]);


                            }

                        });
                    });
                    //unit 


                    // section

                    $(".com_section").keyup(function() {
                        //alert('OK')

                        $('#com_section').css('color', 'red');

                        autoTypeNo = 0, autoTypeNo1 = 2;

                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: 'ajx/get_section.php',
                                    dataType: "json",
                                    method: 'post',
                                    data: {
                                        TYPE: request.term
                                    },
                                    success: function(data) {
                                        response($.map(data, function(item) {
                                            var code = item.split("|");

                                            //color
                                            var itm = document
                                                .getElementsByName(
                                                    'com_section')[0]
                                                .value
                                            if (code[0] == itm) {
                                                //alert('ok');
                                                $('#com_section').css(
                                                    'color',
                                                    '#0CCC0F');
                                            } else if (code[0] != itm) {
                                                //alert(code[2]);
                                                $('#com_section').css(
                                                    'color', 'red');
                                            }
                                            //color

                                            return {
                                                label: code[autoTypeNo],
                                                value: code[
                                                    autoTypeNo1],
                                                data: item
                                            }
                                        }));
                                    }
                                });
                            },
                            autoFocus: false,
                            minLength: 0,
                            select: function(event, ui) {
                                var names = ui.item.data.split("|");
                                id_arr = $(this).attr('id');
                                //id = id_arr.split("_");


                                $('#com_section').val(names[0]);
                                //$('#ven_name').val(names[1]);
                                $('#com_section').css('color', '#0CCC0F');


                            }

                        });
                    });
                    //section 


                    // calculation
                    $(document).on('keyup', '#cost2', function() {
                        var cost2 = $('#cost2').val();
                        var cost1 = $('.cost1').val();
                        var price1 = $('.sprice1').val();
                        $('.sprice2').val('');
                        $('.cost3').val('0');
                        if (cost2 > 0) {
                            nwprice = price1 / cost2;
                            nwcost = cost1 / cost2;
                            $('.sprice2').val(nwprice);
                            $('.cost3').val(nwcost);
                        }
                    });


                    // calculation

                    $(document).on('click', '.lastIns', function() {
                        $('.bt_save').show();
                        $('.bt_save').html('<a class="button button-green"> <i class="glyphicon glyphicon-floppy-saved"></i> <strong>Save as New Item</strong> </a>');
                        $('.bt_update2').show();
                        $('.bt_delete').show();
                        var itm_no = $(this).attr('lastIns')
                        //alert(itm_no);
                        $('#itm_no2').val(itm_no);
                        $('.bt_update2').prop('disabled', false);
                        $('.bt_update2').css('background', '#84DB85');
                        itm_det(itm_no);
                    });

                    $(document).on('click', '.inv_dtls', function() {
                        $('.bt_save').show();
                        $('.bt_save').html('<a class="button button-green"> <i class="glyphicon glyphicon-floppy-saved"></i> <strong>Save as New Item</strong> </a>');
                        $('.bt_update2').show();
                        $('.bt_delete').show();
                        var itm_no = $(this).attr('value');
                        //alert(itm_no);
                        $('#itm_no2').val(itm_no);
                        $('.bt_update2').prop('disabled', false);
                        $('.bt_update2').css('background', '#84DB85');
                        itm_det(itm_no);
                    });
                });

                function saveClick() {

                    var txtval = document.forms["itm_form"]["itm_no2"].value;
                    if (txtval == "") {
                        alert('Item number can not be empty');
                    }

                }

                function val_pcart(evt) {
                    var theEvent = evt || window.event;
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                    var regex = /[0-9]|\./;
                    if (!regex.test(key)) {
                        theEvent.returnValue = false;
                        if (theEvent.preventDefault) theEvent.preventDefault();
                    }
                }


                $(document).ready(function() {
                    $("#flip").click(function() {
                        // $(".pan").slideToggle("slow");
                        $("#inputarea1").hide();
                        $("#itm_tb1").hide();
                        $(".ajax-loaders3").show();
                        $(".pan").slideDown("slow");
                        $('.mtb').css('width', '90%');
                        var cat = $('.com_cat').val();

                        $('#tb2').load('ajx/br_item_load.php?cat=' + cat + '');
                        $(this).trigger("pagecreate");




                    });

                    $('#com_cat').change(function() {
                        $(".ajax-loaders3").show();
                        var cat = $('.com_cat').val();

                        $('#tb2').load('ajx/br_item_load.php?cat=' + cat + '');
                        $(this).trigger("pagecreate");
                    });



                });


                $(document).ready(function() {
                    $(".close").click(function() {
                        // $(".pan").slideToggle("slow");
                        $("#inputarea1").show();
                        $(".pan").slideUp("slow");
                        location.reload();
                    });
                });




                // price level calculation ##############################################################

                function lvl_dis(lvl, price) {
                    if (parseFloat(lvl) != 0) {
                        var dif = parseFloat(price) - parseFloat(lvl);
                        var dis = parseFloat(dif) / parseFloat(price) * 100;
                    } else {
                        dis = 0;
                    }
                    return (dis);
                }

                $(document).on('keyup', '.lvl', function() {
                    var val = $(this).val();
                    var price = $('.sprice1').val();
                    var id = this.id;
                    var id2 = id.split('_');
                    //alert(id2[1]);
                    var dif = 0;
                    var dis = 0;
                    if (val != '') {
                        dif = parseFloat(price) - parseFloat(val);
                        dis = parseFloat(dif) / parseFloat(price) * 100;
                    }
                    //alert(dis);
                    $('.lvlDis_' + id2[1]).val(dis.toFixed(2));
                });


                $(document).on('keyup', '.lvlDis', function() {
                    var val = $(this).val();
                    var price = $('.sprice1').val();
                    var id = this.id;
                    var id2 = id.split('_');
                    //alert(id2[1]);
                    var dis = 0;
                    var nprice = 0;
                    if (val != '') {
                        dis = parseFloat(val) / 100 * parseFloat(price);
                        nprice = parseFloat(price) - parseFloat(dis);
                    }
                    //alert(dis);
                    $('.lvl_' + id2[1]).val(nprice.toFixed(2));
                });


                $(document).on('click', '#bt_down', function() {

                    $('.hiddenLoad').remove();
                    $('.hiddenLoad2').remove();
                    var hidden = '<input type="hidden" name="hiddenDown" value="yes" class="hiddenLoad"/>';
                    $('#bt_down').after(hidden);
                    $('#itm_form').submit();



                });


                $(document).on('click', '#bt_downBC', function() {

                    $('.hiddenLoad').remove();
                    $('.hiddenLoad2').remove();
                    var hidden = '<input type="hidden" name="hiddenDownBC" value="yes" class="hiddenLoad2"/>';
                    $('#bt_down').after(hidden);
                    $('#itm_form').submit();



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


                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#imagePreview')
                                .attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $('body').on('drop', '.cls_img', function(e) {
                    var file = e.originalEvent.dataTransfer.files[0];
                });

                $(document).on('click', '.bt_delete', function() {

                    if ($(this).attr('type') == 'button') {
                        if (confirm('Are you sure that your want to delete this item?')) {
                            $(this).attr('type', 'submit');
                            $(this).click();
                        }
                    }


                });

                $(document).on('click', '.itm_del', function() {
                    if (confirm('Every Invoices, Recievables, Outsanding, Purchases and all related details will be removed from the system and cannot be restored. Do you want to confirm?')) {
                        $('#passwordModal').modal('show');
                    }
                });

                $(document).on('click', '.confPasswordBtn', function() {
                    var confPassword = $('.confPasswordBtn').val();
                    $.ajax({
                        type: "POST",
                        url: "ajx/deleteAll.php",
                        data: {
                            'confPasswordcode': confPassword,
                            'btn': 'confBtn'
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res.status == 200) {
                                $('#passwordModal').modal('hide');
                                location.reload()
                            } else {
                                $('#passwordModal').modal('hide');
                                alert(res.message)
                            }
                        }
                    });

                });

                $(document).on('click', '.CopyItmCode', function() {

                    if (confirm("Are you sure that you wanted to make yuur item codes as barcodes?")) {
                        $.ajax({
                            type: "POST",
                            url: "ajx/itemcodeToBarcode.php",
                            dataType: "json",
                            success: function(res) {
                                if (res.status == 200) {
                                    location.reload()
                                }
                            }
                        });
                    }

                });

                $(document).on('keyup', '.ex_cate', function() {
                    var thisVal = $(this).val();
                    if (thisVal === '') {
                        $('#extraCatDiv').html('');
                        return; // Exit the function if the value is empty
                    }
                    $('#extraCatDiv').show();
                    $.ajax({
                        type: "POST",
                        url: "ajx/ex_cat_show.php",
                        data: {
                            'thisValcode': thisVal,
                            'btn': 'cat_btn'
                        },
                        dataType: "json",
                        success: function(res) {
                            if (res != '') {
                                $('#extraCatDiv').html(res);
                            }
                        }
                    });
                });

                $(document).on('click', '.exCatD1', function() {
                    var thisText = $(this).text()
                    $('.ex_cate').val(thisText)
                    $('#extraCatDiv').hide();


                });

                $(document).ready(function() {
                    $('.charKey').each(function() {
                        charCount($(this));
                    });

                    $(document).on('keyup', '.charKey', function() {
                        charCount($(this));
                    });


                });

                function charCount(inputElement) {
                    var thisVal = inputElement.val();
                    var charCount = thisVal.length;
                    inputElement.closest('div').find('.charCount').text(charCount);
                }

                $(document).on('keyup', '.itm_type', function() {
                    var thisVal = $(this).val();
                    $('#typeVal').show();
                    if (thisVal === '') {
                        $('#typeVal').html('');
                        return; // Exit the function if the value is empty
                    }
                    $.ajax({
                        type: "POST",
                        url: "ajx/typeAjx.php",
                        data: {
                            'btn': 'typeBtn',
                            'typecode': thisVal
                        },
                        dataType: "json",
                        success: function(res) {
                            $('#typeVal').html(res)
                        }
                    });

                });

                $(document).on('click', '.exCatD11', function() {
                    var thisText = $(this).text()
                    $('.itm_type').val(thisText)
                    $('#typeVal').hide();
                    $('.itm_type').focus();


                });

                $(document).on('keyup', '.sprice1', function() {
                    var sprice1 = parseFloat($(this).val()); // Convert to a number
                    var cost1 = parseFloat($('.cost1').val()); // Convert to a number
                    $('.costError').hide();

                    // Check if both values are valid numbers before making the comparison
                    if (!isNaN(cost1) && !isNaN(sprice1)) {
                        if (cost1 > sprice1) {
                            $('.cost1').css('background-color', 'rgba(255, 0, 0, 0.3)'); 
                            $('.cost1').after(`<span class="costError" style="color:red;">Cost price is higher than sales price</span>`)
                        } else {
                            $('.cost1').css('background-color', ''); 
                            $('.costError').hide();
                        }
                    } else {
                        $('.cost1').css('background-color', ''); // Reset if input is not valid
                        $('.costError').hide();
                    }
                });
                
            </script>