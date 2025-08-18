<?php
session_start();
include ('../../function.php');
include ('../connection.php');
include ('../../session_file.php');
$br_id = $_SESSION['br_id'];

$rdate = date('Y-m-d');
$btn = $_POST['btn'];

$data['detail'] = '';

if($btn == 'DaySalesChart'){
    $monthNames = '';
    $slAmntYear = ''; $rcAmntYear = '';
	$year =  date("Y");
	
	for($m = 1; $m <= 12; $m++){
		$sql_sales = mysql_query("SELECT SUM(`InvTot`) FROM `invoice` 
					WHERE br_id ='$br_id' AND YEAR(`Date`)='$year' AND MONTH(Date) = '$m' ORDER BY Date DESC");
		$sales = mysql_fetch_array($sql_sales);
		
		$sql_recieved = mysql_query("SELECT SUM(`Paid`) FROM `cusstatement` 
					WHERE br_id ='$br_id' AND YEAR(`Date`)='$year' AND MONTH(Date) = '$m' ORDER BY Date DESC");
		$recieved = mysql_fetch_array($sql_recieved);
		
		$slAmnt = (!empty($sales[0]))? $sales[0]:'0';
		$rcAmnt = (!empty($recieved[0]))? $recieved[0]:'0';
		
		$monthNames .= "'".date('F', mktime(0, 0, 0, $m, 10))."',";
		$slAmntYear .= $slAmnt.",";
		$rcAmntYear .= $rcAmnt.",";
	}

    $data['detail'] .= "
            <script>
            var ctx = document.getElementById('chart_div').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [".substr($monthNames, 0, -1)."],
                    datasets: [
                        {
                          label: 'Sales',
                          data: [$slAmntYear],
                          borderColor: 'pink',
                          fill: false,
                        },
                        {
                          label: 'Collection',
                          data: [$rcAmntYear],
                          borderColor: 'blue',
                          fill: false,  
                            
                        }
                      ]
                },
                options: {
                    responsive: true,
                    plugins: {
                      legend: {
                        position: 'top',
                      },
                      title: {
                        display: true,
                        text: 'Daily Sales & Due Recieve'
                      }
                      
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function (value) {
                                    return numeral(value).format('0,0');
                                }
                            }
                        }]
                    },
                    tooltips: {
                          callbacks: {
                              label: function(tooltipItem, data) {
                                  return numeral(tooltipItem.yLabel).format('0,0');
                              }
                          },
                      },
                        
                  },
            });
    </script>
    ";
    
    $data['showClass'] = 'ajaxResult';
    echo json_encode($data);
    
}

if($btn == 'load_chq_In_Hand_graph'){
    $monthNames = [];
    $slAmnt = '';
    $thisYear = date('Y');

    $currentMonth = new DateTime('first day of this month');
    $currentMonthName = $currentMonth->format('F');

    $data = [];
    $ownData = [];
    $labels = [];
    $chqNos = [];
    $chqAmnt = [];
    $customerNames = [];

    $own_chqNos = [];
    $own_chqAmnt = [];
    $own_customerNames = [];
    $labelKey = 0;
    for ($i = 0; $i < 3; $i++) {
        $month = clone $currentMonth;
        $monthNumber = $month->format('m');
        $monthName = $month->format('F');

        $weeksInMonth = intval($month->format('W'));
        $dateTotals = [];
        for ($j = 1; $j <= 4; $j++) {
            $labels[] = "$monthName Week $j";

            if($j == 1){
                $fromD = $thisYear.'-'.$monthNumber.'-01';
                $toD = $thisYear.'-'.$monthNumber.'-07';
            }
            if($j == 2){
                $fromD = $thisYear.'-'.$monthNumber.'-08';
                $toD = $thisYear.'-'.$monthNumber.'-14';
            }
            if($j == 3){
                $fromD = $thisYear.'-'.$monthNumber.'-15';
                $toD = $thisYear.'-'.$monthNumber.'-21';
            }
            if($j == 4){
                $fromD = $thisYear.'-'.$monthNumber.'-22';
                $toD = $thisYear.'-'.$monthNumber.'-31';
            }
         
            $sqlFindChq2 = $mysqli->query("SELECT SUM(`chqAmount`) AS `chqAmount`
                FROM `chq_recieve` WHERE cashDate BETWEEN '$fromD' AND '$toD' AND br_id = '$br_id' AND ID NOT IN 
                (SELECT rcvTbID FROM bank_deposit WHERE br_id = '$br_id')");
            
                $FindChq2 = $sqlFindChq2->fetch_array();
                $chqAmount = $FindChq2['chqAmount'];
                
                if($chqAmount != 0){
                    $data[] =$chqAmount;
                }else{
                    $data[] = 1;
                }


            // own cheques start
            $sqlFindOwnChq = $mysqli->query("SELECT SUM(`amount`) AS `amount`
                FROM `bank_deposit` WHERE depositDate BETWEEN '$fromD' AND '$toD' AND `chqBID`!= 0 AND br_id = '$br_id'");

                $FindOwnChq2 = $sqlFindOwnChq->fetch_array();
                $ownChqAmount = $FindOwnChq2['amount'];
                
                if($ownChqAmount != 0){
                    $ownData[] =$ownChqAmount;
                }else{
                    $ownData[] = 1;
                }
            // own cheques end

            $sqlFindChq = $mysqli->query("SELECT `chqNo`, `cashDate`, `chqAmount`, `status`, frmID 
                FROM `chq_recieve` WHERE cashDate BETWEEN '$fromD' AND '$toD' AND br_id = '$br_id' AND ID NOT IN 
                (SELECT rcvTbID FROM bank_deposit WHERE br_id = '$br_id')");

            while ($FindChq = $sqlFindChq->fetch_array()) {
                if ($FindChq['status'] == 'Journal') {
                    $sqlCusDtls1 = $mysqli->query("SELECT Description FROM `journal` WHERE ID = '$FindChq[frmID]' ");
                    $type = '( Journal )';
                } else {
                    $sqlCusDtls1 = $mysqli->query("SELECT cusName FROM `custtable` WHERE ID = '$FindChq[frmID]'");
                }

                $CusDtls1 = $sqlCusDtls1->fetch_array();
                $customerName = $CusDtls1[0];
                $chqNos[$labelKey][] = $FindChq['chqNo'];
                $chqAmnt[$labelKey][] = $FindChq['chqAmount'];
                $customerNames[$labelKey][] = $customerName;
            }


            // own cheques start
            $sqlFindOwnChq2 = $mysqli->query("SELECT `chqNo`, `amount`,`venID`
                FROM `bank_deposit` WHERE depositDate BETWEEN '$fromD' AND '$toD' AND `chqBID`!= 0 AND br_id = '$br_id'");
            
            while ($FindownChq2 = $sqlFindOwnChq2->fetch_array()) {

                $sqlVenDtls2 = $mysqli->query("SELECT `CompanyName` FROM `vendor` WHERE ID = '$FindownChq2[venID]' ");
                $VenDtls2 = $sqlVenDtls2->fetch_array();

                $own_chqNos[$labelKey][] = $FindownChq2['chqNo'];
                $own_chqAmnt[$labelKey][] = $FindownChq2['amount'];
                $own_customerNames[$labelKey][] = $VenDtls2['CompanyName'];
            }
            // own cheques end

            $labelKey++;
            if($j == 4){
                $currentMonth->modify("+1 month");
            }
        }
    }

    $chqNosString = json_encode($chqNos);
    $customerNamesString = json_encode($customerNames);
    $chqAmntString = json_encode($chqAmnt);
    $labelsString = json_encode($labels);
    $dataString = json_encode($data);
    $ownDataString = json_encode($ownData);

    // own cheques
    $own_chqNosString = json_encode($own_chqNos);
    $own_customerNamesString = json_encode($own_customerNames);
    $own_chqAmntString = json_encode($own_chqAmnt);
    

    $data['detail'] .= "
        <script>
            var ctx = document.getElementById('chart_div_chqInHand').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: $labelsString,
                    datasets: [{
                        label: 'Cheque In Hand',
                        data: $dataString,
                        chqNos: $chqNosString,
                        customerNames: $customerNamesString,
                        chqAmnt: $chqAmntString,
                        borderColor: 'green',
                        fill: false,
                    },
                    {
                        label: 'Own Cheques',
                        data: $ownDataString,
                        chqNos: $own_chqNosString,
                        customerNames: $own_customerNamesString,
                        chqAmnt: $own_chqAmntString,
                        borderColor: 'blue',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Daily Collection'
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function (value) {
                                    return numeral(value).format('0,0');
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                var value = tooltipItem.yLabel;
                                var chqNos = data.datasets[tooltipItem.datasetIndex].chqNos[tooltipItem.index];
                                var customerNames = data.datasets[tooltipItem.datasetIndex].customerNames[tooltipItem.index];
                                var chqAmnt = data.datasets[tooltipItem.datasetIndex].chqAmnt[tooltipItem.index];
                                var tooltipLabel = [];

                                if (label) {
                                    tooltipLabel.push(label + ': ' + numeral(value).format('0,0'));
                                }
                                
                                for (var i = 0; i < chqNos.length; i++) {
                                    tooltipLabel.push('Chq No: ' + chqNos[i] + ' | Customer : ' + customerNames[i] + ' | ' + numeral(chqAmnt[i]).format('0,0'));
                                }

                                return tooltipLabel;
                            }
                        }
                    }
                }
            });
        </script>
    ";

    $data['showClass'] = 'chqInHandAjaxResult';
    echo json_encode($data);

}

if($btn == 'ActivationBarChart'){
    $monthNames = '';
    $dataset = '';
	$year =  date("Y");
	
	$sql_brnches = mysql_query("SELECT ID, name FROM com_brnches WHERE offDays = 'Active'");
	$colorArray = array("", "#6196cc", "pink", "yellow");
	while($brnches = mysql_fetch_array($sql_brnches)){
	    $activationCountYear = '';
	    $br_idd = $brnches['ID'];
    	for($m = 1; $m <= 12; $m++){
    		$sql_activationCount = mysql_query("SELECT `ID` FROM `pur_imei_items` WHERE `Active` = 'YES' AND MONTH(`active_date`) = '$m' AND YEAR(`active_date`)='$year' AND br_id ='$br_idd'");
    		$activationCountG = mysql_num_rows($sql_activationCount);
    		
    		$activationCount = (!empty($activationCountG))? $activationCountG:'0';
    		$activationCountYear .= $activationCount.",";
    		
    		if($br_idd == '1'){
    		    $monthNames .= "'".date('F', mktime(0, 0, 0, $m, 10))."',";
    		}
    	}
    	
    	$branchName = "'".$brnches['name']."'";
    	$colorName = "'".$colorArray[$brnches['ID']]."'";
    	
    	$dataset .= "
    	    {
                label: $branchName,
                data: [$activationCountYear],
                borderColor: $colorName,
                backgroundColor: $colorName,
            },
    	";

	}

    $data['detail'] .= "
            <script>
            var ctx = document.getElementById('activationChartDiv').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [".substr($monthNames, 0, -1)."],
                    datasets: [
                        ".$dataset." 
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                      legend: {
                        position: 'top',
                      },
                      title: {
                        display: true,
                        text: 'Mobile Phone Activation Chart'
                      },
                    }
                  },
            });
    </script>
    ";
    
    $data['showClass'] = 'ActivationBarChart';
    echo json_encode($data);
    
}

if($btn == 'PayrollAttendance'){
    $attendTb = '';
    $myDate = $_POST['dateSelect'];
    
    $shMonth = date('m', strtotime($myDate));
    $shYear = date('Y', strtotime($myDate));
   
    $SQstf = $mysqli->query("SELECT *, `staff_attendanceexcel`.`ID` AS 'shuja' FROM `staff_attendanceexcel` JOIN `salesrep` ON `staff_attendanceexcel`.`repTbID`=`salesrep`.ID  
                                WHERE `staff_attendanceexcel`.`dates`='$myDate'  AND `salesrep`.br_id='$br_id' AND salesrep.payroll_active = 'YES'  GROUP BY `repTbID` ORDER BY staff_attendanceexcel.`ID` ASC");
    if($SQstf->num_rows == true){
        $i=0;
        while($keyD = $SQstf->fetch_assoc()){
            
            $i++;
            $ID = $keyD['shuja'];
            $rName = $keyD['Name'];
            $rDate = $keyD['dates'];
            $rOnDuty = $keyD['on_duty'];
            $rOffDuty = $keyD['off_duty'];
            $rInTime = $keyD['in_time'];
            $rOutTime = $keyD['out_time'];
            $rAbsent = $keyD['absent'];
            $rRepTbID = $keyD['repTbID'];
            $inIMG = $keyD['loginPic'];
            $outIMG = $keyD['logoutPic'];
            
            $sql_staffInfo = $mysqli->query("SELECT ID, salary_type, salary FROM staff_infor WHERE repTb = $rRepTbID");
            $staffInfo = $sql_staffInfo->fetch_assoc();
            
            $TimeColorCSS = '';
            
            $unixInTime = strtotime($rInTime);
            $unixOnDuty = strtotime($rOnDuty);
            
            if($unixInTime > $unixOnDuty){
              $TimeColorCSS = 'color:red;';
           }else if(($unixInTime < $unixOnDuty) && $unixInTime != '00:00:00' ){
                $TimeColorCSS = 'color:green;';
            }
            
            $TimeColorCSS = '';
            $unixInTime = strtotime($rInTime);
            $unixOnDuty = strtotime($rOnDuty);
            
            if($unixInTime > $unixOnDuty){
                $TimeColorCSS = 'color:red;';
            }else if(($unixInTime < $unixOnDuty) && $rInTime != '00:00:00' ){
                $TimeColorCSS = 'color:green;';
            }

            ///////////////Get Leave Type///////////////////
            $rLeaveType = '';
            $leaveSQL = $mysqli->query("SELECT * FROM `staff_attendance` WHERE `repTb`='$rRepTbID' AND `absent_date`='$rDate' AND `leave_type`!='Allowance' AND `br_id`='$br_id' ");
            $vleaveSQL = $leaveSQL->num_rows;

            if($vleaveSQL == true){
                $ResRowleave = $leaveSQL->fetch_assoc();
                $rLeaveType = $ResRowleave['leave_type'];
            }

            $rLoginForm = $keyD['loginForm'];
            $rLogoutForm = $keyD['logoutForm'];


            if($rAbsent == 'YES'){
                $attendTb .= '<tr title="'.$rDate.'">';
            }else{
                $attendTb .= '<tr title="'.$rDate.'" style="background-color:#b1f1eb;">';
            }
            
            $cssSty = '';
            if(($inIMG || $outIMG) != ''){
                $cssSty = 'style="background-color:#4ff10c;"';
            }
            
            if($inIMG == ''){
               $inIMG = 'https://cdn.pixabay.com/photo/2016/11/14/17/39/person-1824144_960_720.png';
            }
                
            if($outIMG == ''){
                $outIMG = 'https://cdn.pixabay.com/photo/2016/11/14/17/39/person-1824144_960_720.png';
            }
            
            $checkoutTime = ($rOutTime == '00:00:00' || $rOutTime == '838:59:59')? $rInTime: $rOutTime;
            $d1 = new DateTime($rDate ." ".$rInTime);
            $d2 = new DateTime($rDate ." ".$checkoutTime);
            $interval = $d1->diff($d2);
            $diffInSeconds = $interval->s;
            $diffInMinutes = $interval->i;
            $diffInHours   = $interval->h;
            
            $attendTb .= '
                <tr>
                <td '.$cssSty.' attName="'.$rName.'" attImgIn="'.$inIMG.'" attImgOut="'.$outIMG.'" class="modaltdclick">'.$rName.' </td>
                <td width="150px"> <img src="'.$inIMG.'" style="width:34px; height:34px" /> - <img src="'.$outIMG.'" style="width:34px; height:34px" /> </td>
                <td> '.$rOnDuty.'</td>
                <td> '.$rOffDuty.'</td>
                <td> '.$rInTime.'</td>
                <td> '.$rOutTime.'</td>
                <td>'.$diffInHours.' hours '.$diffInMinutes.' minutes</td> 
                ';
            '</tr>';

        }
        
    }

    $data['attendTb'] = $attendTb;
    echo json_encode($data);
}

if($btn == 'DashTiles'){
    $sql_sold = $mysqli->query("SELECT SUM(Quantity) AS QtyTot, SUM(invitem.Sprice*diff_inv*Quantity) AS discTot, SUM(CostPrice*Quantity) AS costTot FROM invitem JOIN invoice ON invitem.invID = invoice.ID WHERE invitem.br_id = '$br_id' AND invitem.Date = '$rdate'");
    $sold = $sql_sold->fetch_array();
    $profLoss = $sold['discTot'] - $sold['costTot'];


    $divBy = $sold['QtyTot'] == '0' || $sold['QtyTot'] == null ? '1' : $sold['QtyTot'];
    $avgSale = $invoiceTotal['invoiceTotal'] / $divBy;

    $divBy1 = $sold['costTot'] == '0' || $sold['costTot'] == null ? '0' : $sold['costTot'];
    $percent = $profLoss * 100 / ($divBy1);

    $qry_Csales1 = $mysqli->query("SELECT SUM(Paid) FROM `cusstatement` 
    WHERE  
    br_id = '$br_id' 
    AND FromDue != 'Due' 
    AND Date = '$rdate' 
    AND RepID NOT IN ('Cheque', 'Card')");

    $tot_Csales1 = $qry_Csales1->fetch_array();


    $qry_cardSale1 = $mysqli->query("SELECT SUM(cusstatement.Paid) FROM `invoice` JOIN cusstatement ON `invoice`.ID=cusstatement.invID  and `invoice`.`Date`=cusstatement.Date
                                        WHERE `invoice`.`Stype` != 'Balance' AND cusstatement.FromDue!='Due'
                                        AND `invoice`.`br_id`='$br_id' AND `invoice`.`Date`='$rdate' AND cusstatement.RepID='Card' 
                                    ");
    $tot_cardSale1 = $qry_cardSale1->fetch_array();

    $sql_creditSales = $mysqli->query("SELECT SUM(InvTot), SUM(RcvdAmnt)
                FROM `invoice` 
                WHERE `Date` = '$rdate'
                AND br_id = '$br_id' AND `Stype` != 'Balance' AND InvNO NOT LIKE 'NOTE-%'  
                 ");
    $creditSales = $sql_creditSales->fetch_array();
    $diff = $creditSales[0] - $creditSales[1];
    
    $htmlTiles['showClass'] = 'dashTiles';
    $htmlTiles['detail'] = '
        <div class="col-md-3 col-sm-3 col-xs-3 soldQty">
            <div class="boxSahd count_box" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Sold Qty</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($sold['QtyTot'], 2) . '</span>
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="boxSahd count_box" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Cash Sales.</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($tot_Csales1[0], 2) . '</span>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="boxSahd count_box" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Card Sales.</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($tot_cardSale1[0], 2) . '</span>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="boxSahd count_box" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Credit Sales.</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($diff, 2) . '</span>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-4 totCost" style="cursor:pointer; margin-top: 15px;">
            <div class="boxSahd count_box" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Tot. Cost</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($sold['costTot'], 2) . '</span>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-4 col-xs-4" style="cursor:pointer; margin-top: 15px;">
            <div class="boxSahd count_box grossProfit" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Gross Profit</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($profLoss, 2) . '</span>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-4" style="margin-top:15px;">
            <div class="boxSahd count_box" style="background-color:#ff4848; padding:10px; border-radius:5px; text-align:center;">
                <div style="color:white; font-size: 14px;">Percent.</div>
                <span style="font-size:23px; font-weight: bold;color:white;">' . number_format($percent, 2) . '%</span>
            </div>
        </div>
    ';
    echo json_encode($htmlTiles);
}
?>