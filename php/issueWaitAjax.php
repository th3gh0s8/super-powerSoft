<?php
include('path.php');
require_once $path . '../connection_log.php';
require_once $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';
include('../function.php');

$action = $_POST['action'];
$rDate = date('Y-m-d');
$rTime = date('H:i:s');

if ($action == 'loadAgentComment') {
    $getByID = $mysqli->real_escape_string($_POST['getId']);
    // Agent comments
    $sqlAgentComment = $mysqli->query("SELECT ID AS iid, reply_comment, replyBy, replyTime, replyDate, reply_user_id FROM issue_reply WHERE issue_tb = '$getByID' AND replyBy IN ('Agent', 'Client') AND replyTo IN ('agent','client') ORDER BY replyDate ASC, replyTime ASC");
    $agArray = [];
    while ($agentDet = $sqlAgentComment->fetch_assoc()) {
        $chatPerson = loadSolvedPerson($mysqli, $agentDet['reply_user_id']);
        $agentDet['chatPerson'] = isset($chatPerson) ? $chatPerson : '';
        $agArray[] = $agentDet;
    }
    echo json_encode(['agentComment' => $agArray]);
}

if ($action == 'loadDevComment') {
    $getByID = $mysqli->real_escape_string($_POST['getId']);
    // Agent comments
    $sqlchatComment = $mysqli->query("SELECT ID AS iid, reply_comment, replyBy, replyTime, replyDate, reply_user_id FROM issue_reply WHERE issue_tb = '$getByID' AND replyBy IN ('Agent', 'Developer') AND replyTo IN ('agent','developer') ORDER BY replyDate ASC, replyTime ASC");
    $chatArray = [];
    while ($chatDet = $sqlchatComment->fetch_assoc()) {
        $chatPerson = loadSolvedPerson($mysqli, $chatDet['reply_user_id']);
        $chatDet['chatPerson'] = isset($chatPerson) ? $chatPerson : '';
        $chatArray[] = $chatDet;
    }

    echo json_encode(['chatDet' => $chatArray]);
}

if ($action == 'loadDataByID') {
    $getByID = $mysqli->real_escape_string($_POST['getByID']);
    $cusId = $mysqli->real_escape_string($_POST['cusId']);

    // Issue main details
    $sql_issueCmnt = $mysqli->query("SELECT * FROM issue_tb WHERE ID = '$getByID'");
    $rowDet = $sql_issueCmnt ? $sql_issueCmnt->fetch_assoc() : [];

    // Last request date
    $sqlLastReqDate = $mysqli->query("SELECT chk_date FROM issue_tb WHERE request_new_lead = 1 AND cusID = '$cusId' ORDER BY chk_date DESC LIMIT 1");
    $lastDet = $sqlLastReqDate ? $sqlLastReqDate->fetch_assoc() : null;
    $lastRequestedDate = $lastDet && isset($lastDet['chk_date']) ? $lastDet['chk_date'] : '';

    // Calculate days since last request
    $daysSinceLastRequest = '';
    if ($lastRequestedDate) {
        $lastDate = new DateTime($lastRequestedDate);
        $currentDate = new DateTime();
        $interval = $lastDate->diff($currentDate);
        $daysSinceLastRequest = $interval->days;
    }

    echo json_encode([
        'cmntDet' => $rowDet,
        'did' => $developerId,
        'lastRequestedDate' => $lastRequestedDate,
        'daysSinceLastRequest' => $daysSinceLastRequest
    ]);
}

// save agent comment
if ($action == 'saveComment') {
    $comment  = $_POST['comment'];
    $agID     = $_POST['agID'];
    $devID    = $_POST['devID'];
    $issueID  = $_POST['issueID'];
    $replyBy  = $_POST['replyBy'];
    $agentOption = $_POST['agentOption'];
    $devOption = $_POST['devOption'];

    $replyID = $replyBy === 'Agent' ? $agID : $devID;

    $replyTo = '';
    if ($replyBy === 'Agent' && !empty($agentOption)) {
        $replyTo = $agentOption;
    } elseif ($replyBy === 'Developer' && !empty($devOption)) {
        $replyTo = $devOption;
    }

    $response = [
        'success' => false,
        'message' => ''
    ];


    // INSERT new comment
    $sql_query = "INSERT INTO issue_reply (issue_tb, reply_user_id, replyTime, replyDate, status, reply_comment, replyBy, replyTo) 
                      VALUES ('$issueID', '$user_id', '$rTime', '$rDate', 'Pending', '$comment', '$replyBy', '$replyTo')";


    // else {
    //     // UPDATE existing comment
    //     $sql_query = "UPDATE issue_reply 
    //                   SET issue_tb = '$issueID', reply_user_id = '$user_id', replyTime = '$rTime', replyDate = '$rDate', 
    //                       status = 'Pending', reply_comment = '$comment', replyTo = '$replyTo' 
    //                   WHERE ID = '$replyID' AND replyBy = '$replyBy'";
    // }

    if ($mysqli->query($sql_query)) {
        $response['success'] = true;
        $response['message'] = empty($replyID) ? "$replyBy comment saved successfully" : "$replyBy comment updated successfully";
    } else {
        $response['message'] = "DB Error: " . $mysqli->error;
    }

    echo json_encode($response);
}

if ($action == 'saveallComent') {
    $issueID = $_POST['issueID'];
    $rDateTime = date('Y-m-d H:i:s');
    $newLead = isset($_POST['newLead']) ? 1 : 0;

    $showError = array(
        'success' => false,
        'message' => ''
    );

    $sql_update_issue = $mysqli->query("UPDATE issue_tb SET type='Yes', issueStatus='Completed', request_new_lead='$newLead', chk_uID='$user_id', chk_date='$rDate', chk_time='$rTime' WHERE ID='$issueID'");

    if ($sql_update_issue) {
        $showError['success'] = true;
        $showError['message'] = 'Issue updated succesfully';
    } else {
        $showError['success'] = false;
        $showError['message'] = $mysqli->error;
    }

    if ($showError['success'] == true) {
        $sql_insert = $mysqli->query("INSERT INTO issue_history (issueTb, status, ref_status, user_id, rDatetime) VALUES ('$issueID','Completed','Issue','$user_id',' $rDateTime')");

        $sql_update_issue = $mysqli->query("UPDATE issue_reply SET status='Completed' WHERE issue_tb='$issueID'");
    }
    echo json_encode($showError);
}

if ($action == 'deleteIssue') {
    $getId = intval($_POST['getByID']);
    $rDateTme = date('Y-m-d H:i:s');

    $showError = array(
        'success' => false,
        'showMessage' => ''
    );

    $archiveResult = archiveIssueBeforeDelete($mysqli, $getId, 'Deleted');

    if ($archiveResult === true) {
        saveDeleteHistory($mysqli, $getId, 'Deleted', 0, 'Issue Deleted', $user_id, $rDateTme);

        $sqlDelete = $mysqli->query("DELETE FROM issue_tb WHERE ID = '$getId'");

        if ($sqlDelete) {
            $showError['success'] = true;
            $showError['showMessage'] = 'Successfully Deleted';
        } else {
            $showError['showMessage'] = 'Error while deleting: ' . $mysqli->error;
        }
    } else {
        $showError['showMessage'] = $archiveResult; // returns error string if any
    }

    echo json_encode($showError);
}


function saveDeleteHistory($mysqli, $issueTb, $status, $refId, $refStatus, $userID, $rDateTime)
{
    $sql_save = $mysqli->query(
        "INSERT INTO issue_history (issueTb, status, ref_id, ref_status, user_id, rDatetime) 
        VALUES ('$issueTb', '$status', '$refId', '$refStatus', '$userID', '$rDateTime')"
    );

    if (!$sql_save) {
        // If you want to catch errors
        error_log('Failed to save delete history: ' . $mysqli->error);
    }
}


if ($action == 'loadIssueHistory') {
    $cusId = isset($_POST['cusID']) ? (int)$_POST['cusID'] : null;

    $sql_loadHistory = $mysqli->query("SELECT * FROM issue_tb WHERE cusID = '$cusId'");
    $historyArray = [];
    $today = new DateTime();

    $sqlCusName = $mysqli->query("SELECT cusName FROM custtable WHERE ID = '$cusId'");
    $cusDetName = $sqlCusName ? $sqlCusName->fetch_assoc() : ['cusName' => ''];

    while ($issHisDet = $sql_loadHistory->fetch_assoc()) {

            // Get agent and developer comments
            $agentComment = '';
            $developerComment = '';
            
            // Get latest agent comment
            $sqlAgentComment = $mysqli->query("SELECT reply_comment FROM issue_reply 
                                              WHERE issue_tb = '{$issHisDet['ID']}' AND replyBy = 'Agent' 
                                              ORDER BY replyDate DESC, replyTime DESC LIMIT 1");
            if ($sqlAgentComment && $agentRow = $sqlAgentComment->fetch_assoc()) {
                $agentComment = $agentRow['reply_comment'];
            }
            
            // Get latest developer comment
            $sqlDevComment = $mysqli->query("SELECT reply_comment FROM issue_reply 
                                            WHERE issue_tb = '{$issHisDet['ID']}' AND replyBy = 'Developer' 
                                            ORDER BY replyDate DESC, replyTime DESC LIMIT 1");
            if ($sqlDevComment && $devRow = $sqlDevComment->fetch_assoc()) {
                $developerComment = $devRow['reply_comment'];
            }
            
            // Calculate time taken for completed issues
            $timeTaken = '';
            if ($issHisDet['issueStatus'] === 'Completed' && 
                $issHisDet['chk_date'] && $issHisDet['chk_date'] !== '0000-00-00' &&
                $issHisDet['rDate'] && $issHisDet['rTime']) {
                
                $startDateTime = new DateTime($issHisDet['rDate'] . ' ' . $issHisDet['rTime']);
                $endDateTime = new DateTime($issHisDet['chk_date'] . ' ' . $issHisDet['chk_time']);
                
                $interval = $startDateTime->diff($endDateTime);
                $timeTaken = $interval->format('%a days %h hours');
            }
            
            // Format completion date and time
            $completionDateTime = '';
            if ($issHisDet['chk_date'] && $issHisDet['chk_date'] !== '0000-00-00') {
                $completionDateTime = $issHisDet['chk_date'];
                if ($issHisDet['chk_time'] && $issHisDet['chk_time'] !== '00:00:00') {
                    $completionDateTime .= ' ' . date('h:i A', strtotime($issHisDet['chk_time']));
                }
            }




        $sql_cus_count = $mysqli->query("SELECT ID, br_id, CustomerID, cusName, TelNo, MobNo, EmailNo, Active2 FROM custtable WHERE ID = '{$issHisDet['cusID']}' ORDER BY ID DESC");

        $sDet = $sql_cus_count ? $sql_cus_count->fetch_assoc() : null;

        $cusDet = $sDet ? cusDet($sDet['CustomerID'], "0") : ['branch' => []];
        $expDates = '';
        $expStyle = '';

        foreach ($cusDet['branch'] as $cd) {
            $expDateObj = DateTime::createFromFormat('Y-m-d', $cd['expire_date']);

            if ($expDateObj) {
                $diffDays = $today->diff($expDateObj)->days;
                $isPast = $expDateObj < $today;

                if ($isPast) {
                    $expStyle = 'class="badge bg-danger"'; // Expired
                } elseif ($diffDays <= 21) {
                    $expStyle = 'class="badge bg-warning text-dark"'; // Expiring soon
                } else {
                    $expStyle = 'class="badge bg-success"'; // Valid
                }

                $expDates .= "<span $expStyle>" . $cd['br_code'] . ': ' . $cd['expire_date'] . "</span><br/>";
            }
        }

        // Add the new fields to the history array
        $issHisDet['AgentComment'] = $agentComment;
        $issHisDet['DeveloperComment'] = $developerComment;
        $issHisDet['TimeTaken'] = $timeTaken;
        $issHisDet['CompletionDateTime'] = $completionDateTime;

        $issHisDet['expDates'] = rtrim($expDates, '<br/>');

        
        $historyArray[] = $issHisDet;
    }

    echo json_encode([
        'loadIssueDet' => $historyArray,
        'cusDet' => $cusDetName
    ]);
}

if ($action == 'loadDataartmw') {
    $session = $_POST['session'];
    $rMonth = date('m');
    $rYear = date('Y');
    
    $sql_artm_received = $mysqli->query("SELECT COUNT(ID) as total_issues_count, SUM(TIMESTAMPDIFF(MINUTE, CONCAT(rDate, ' ', rTime), 
                                    IF(chk_date = '0000-00-00' OR chk_time = '00:00:00', NOW(), CONCAT(chk_date, ' ', chk_time)))) AS total_resolution_minutes 
                                    FROM issue_tb WHERE YEAR(rDate) = '$rYear' AND MONTH(rDate) = '$rMonth' AND section = '$session'");
    $artm_received_cal = $sql_artm_received->fetch_assoc();
    $artm_received = ($artm_received_cal['total_resolution_minutes']/$artm_received_cal['total_issues_count']);
    
    echo json_encode(['artmDet' => $artmArray]);
}

function convert_minute_to_dayhours($m){
    $d = floor($m / 1440);
    $r = $m % 1440;
    $h = floor($r / 60);
    $min = $r % 60;
    
    $out = [];
    if ($d) $out[] = "$d days";
    if ($h) $out[] = "$h hours";
    if ($min || !$out) $out[] = "$min minutes";
    
    return implode(', ', $out);
}

if($action == 'loadImages'){
    $imgId = $_POST['imgId'];
    $sqlImages = $mysqli->query("SELECT * FROM web_images WHERE imgID = '$imgId'");
    $imagesArray = [];
    while($imgDet = $sqlImages->fetch_assoc()){
        $imagesArray[] = $imgDet;
    }
    echo json_encode(['imgDet' => $imagesArray]);
}
