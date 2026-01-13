<?php

include('path.php');
require_once  $path.'../function.php';
require_once $path.'../session_file.php';//include($path.'../.php');
require_once $path.'connection.php';
///if(!empty($_POST['type'])){
	$data = array();
	$name = $_POST['TYPE'];
	//$RADIO = $_POST['TT'];
//	echo $radio;
//if ( $name != ''){

	//$query = $mysqli->query("SELECT `CatDesc`, `CatID` FROM `category` WHERE CatDesc LIKE '%$name%' OR `CatID` LIKE '%$name%'");
	$query = $mysqli->query("SELECT DISTINCT `CatID` FROM `itemtable` JOIN br_stock ON br_stock.itm_id = itemtable.ID WHERE `CatID` LIKE '%$name%' AND br_stock.br_id = '$br_id'");
	//echo $name.' | '.$type;	//echo $name.' | '.$type;
$num_res = $query->num_rows;	
if ($num_res > 0 ){	
	
	while ($row = $query->fetch_assoc()) {
		$name = $row['CatID'];
		array_push($data, $name);
	}
}
else{
		$no_recode = " | No record";
		array_push($data, $no_recode);
	}
	echo json_encode($data);exit;


?>