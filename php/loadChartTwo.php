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
        <div class="col-lg-2 col-sm-12">
            <div class="dash-widget">
                <div class="dash-widgetimg">
                    <span><img src="./icons/dash1.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="' . number_format($sold['QtyTot'], 2) . '">' . number_format($sold['QtyTot'], 2) . '</span></h5>
                    <h6>Sold Qty</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <div class="dash-widget dash1">
                <div class="dash-widgetimg">
                    <span><img src="./icons/dash2.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="' . number_format($tot_Csales1[0], 2) . '">' . number_format($tot_Csales1[0], 2) . '</span></h5>
                    <h6>Cash Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <div class="dash-widget dash2">
                <div class="dash-widgetimg">
                    <span><img src="./icons/dash3.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="' . number_format($tot_cardSale1[0], 2) . '">' . number_format($tot_cardSale1[0], 2) . '</span></h5>
                    <h6>Card Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <div class="dash-widget dash3">
                <div class="dash-widgetimg">
                    <span><img src="./icons/dash4.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="' . number_format($diff, 2) . '">' . number_format($diff, 2) . '</span></h5>
                    <h6>Credit Sales</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <div class="dash-widget dash3">
                <div class="dash-widgetimg">
                    <span><img src="./icons/Calculator.svg" alt="img"></span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="' . number_format($sold['costTot'], 2) . '">' . number_format($sold['costTot'], 2) . '</span></h5>
                    <h6>Total Cost</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-sm-12">
            <div class="dash-widget dash3">
                <div class="dash-widgetimg">
                    <span>' . number_format($percent, 2) . '%</span>
                </div>
                <div class="dash-widgetcontent">
                    <h5><span class="counters" data-count="' . number_format($profLoss, 2) . '">' . number_format($profLoss, 2) . '</span></h5>
                    <h6>Gross Profit</h6>
                </div>
            </div>
        </div>
    ';


    // Add raw values for AJAX usage:
    $htmlTiles['soldQty']     = $sold['QtyTot'];
    $htmlTiles['grossProfit'] = $profLoss;
    $htmlTiles['percent']     = $percent;
    $htmlTiles['cashSales']   = $tot_Csales1[0];
    $htmlTiles['cardSales']   = $tot_cardSale1[0];
    $htmlTiles['creditSales'] = $diff;
    $htmlTiles['totalCost']   = $sold['costTot'];
    $htmlTiles['message'] = "Hello, this is a debug message from PHP! Sold Qty: ";




    $sqlTotals = $mysqli->query("
         SELECT 
                SUM(InvTot) AS invTT,
                SUM(InvTot - Balance) AS paidTT,
                SUM(Balance) AS balTT
            FROM `invoice`
            WHERE `Balance` <> 0
            AND `br_id` = '$br_id'
           
        ");


        while ( $totals = $sqlTotals->fetch_array()) {
            $invTT += $totals['invTT'];
            $paidTT += $totals['paidTT'];
            $balTT += $totals['balTT'];
            
        }

        
   

        $htmlTiles['balTT'] = "Rs " .number_format($balTT,2);






    

    echo json_encode($htmlTiles);

    // return JSON to AJAX
    //echo json_encode($profLoss);
    //echo json_encode($sold['QtyTot']);
    
    


            
}



?>