<?php
include('path.php');
require_once $path . '../connection_log.php';
require_once $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';
include('../function.php');

$action = $_POST['action'];

if ($action == 'loadCompleteIssues') {
    $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date('Y-m-d');
    $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : date('Y-m-d');

    $result = $mysqli->query("SELECT * FROM issue_tb WHERE issueStatus = 'Completed' AND chk_date BETWEEN '$fromDate' AND '$toDate'");
    $issueArray = [];

    if ($result) {
        while ($issDet = $result->fetch_assoc()) {
            $salesRepID = $issDet['responsible_agent'];

            $sqlSalesRepResult = $mysqli->query("SELECT Name FROM salesrep WHERE ID = '$salesRepID'");
            $repRow = $sqlSalesRepResult->fetch_assoc();
            
            // Get developer reply info
            $sql_issue_replyDev = $mysqli->query("SELECT reply_user_id, reply_comment  FROM `issue_reply` WHERE issue_tb = '$issDet[ID]' AND replyBy = 'Developer' ORDER BY `ID` DESC");
            if($sql_issue_replyDev->num_rows == true){
                $issue_replyDev = $sql_issue_replyDev->fetch_array();
                $devName = uIDQry($issue_replyDev['reply_user_id']);
                $devComment = $issue_replyDev['reply_comment'];
            }

             // Get agent reply info
             $sql_issue_replyAgent = $mysqli->query("SELECT reply_comment FROM `issue_reply` WHERE issue_tb = '$issDet[ID]' AND replyBy = 'Agent' ORDER BY `ID` DESC");
             if($sql_issue_replyAgent->num_rows == true){
                 $issue_replyAgent = $sql_issue_replyAgent->fetch_array();
                 $agentComment = $issue_replyAgent['reply_comment'];
             }
            
            $solvedName = loadSolvedPerson($mysqli, $issDet['chk_uID']);

            $issDet['DeveloperName'] = isset($devName) ? $devName : '';
            $issDet['solvedName'] = isset($solvedName) ? $solvedName : '';
            $issDet['salesRepName'] = isset($repRow['Name']) ? $repRow['Name'] : '';

            $issDet['DeveloperComment'] = isset($devComment) ? $devComment : '';
            $issDet['AgentComment'] = isset($agentComment) ? $agentComment : '';



            $sqlCusName = $mysqli->query("SELECT cusName FROM custtable WHERE ID = $issDet[cusID]");
            $cusRow = $sqlCusName->fetch_assoc();

            $issDet['cusName'] = isset($cusRow['cusName']) ? $cusRow['cusName'] : '';
            $issueArray[] = $issDet;
        }
    }

    echo json_encode(['issueDet' => $issueArray]);
}

// if ($action == 'loadSummeryIssues') {
//     $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date('Y-m-d');
//     $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : date('Y-m-d');

//     $sql="
//         SELECT 
//             t1.responsible_agent,
//             t1.priorityLevel,
//             COUNT(CASE WHEN t1.rDate BETWEEN '$fromDate' AND '$toDate' THEN 1 END) AS total_issues,
//             COUNT(CASE WHEN t1.issueStatus = 'Completed' AND t1.rDate BETWEEN '$fromDate' AND '$toDate' THEN 1 END) AS solved_issues,
//             COUNT(CASE WHEN t1.issueStatus = 'Completed' AND t1.chk_date BETWEEN '$fromDate' AND '$toDate' THEN 1 END) AS total_solved_all
//         FROM issue_tb t1
//         GROUP BY t1.responsible_agent
//         HAVING total_issues != 0;
//     ";

//     $queryResult = $mysqli->query($sql);
//     $issueCountArray = [];

//     while ($row = $queryResult->fetch_assoc()) {
//         $nameGet = $mysqli->query("SELECT Name FROM salesrep WHERE ID = '$row[responsible_agent]'");
//         $nameLoad = $nameGet->fetch_assoc();
//         $row['solvedName'] = $nameLoad['Name'];

//         $issueCountArray[] = $row;
//     }

//     echo json_encode(['issueCntDet' => $issueCountArray]);
// }

if ($action == 'loadSummeryIssues') {
    $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date('Y-m-d');
    $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : date('Y-m-d');

    $sql = "
        SELECT 
            it.responsible_agent,
            sr.Name AS solvedName,
            COUNT(CASE WHEN it.rDate BETWEEN '$fromDate' AND '$toDate' THEN 1 END) AS total_issues,
            COUNT(CASE WHEN it.issueStatus = 'Completed' AND it.rDate BETWEEN '$fromDate' AND '$toDate' THEN 1 END) AS solved_issues,
            COUNT(CASE WHEN it.issueStatus = 'Completed' AND it.chk_date BETWEEN '$fromDate' AND '$toDate' THEN 1 END) AS total_solved_all,
            COUNT(CASE 
                WHEN it.issueStatus = 'Completed' 
                    AND it.chk_date BETWEEN '$fromDate' AND '$toDate'
                    AND it.chk_uID = su.id 
                    AND su.repID = sr.RepID 
                THEN 1 
            END) AS completed_by_responsible,
            COUNT(CASE 
                WHEN it.issueStatus = 'Completed' 
                    AND it.chk_date BETWEEN '$fromDate' AND '$toDate'
                    AND (it.chk_uID != su.id OR su.repID != sr.RepID)
                THEN 1 
            END) AS completed_by_others
        FROM issue_tb it
        LEFT JOIN salesrep sr ON it.responsible_agent = sr.ID
        LEFT JOIN sys_users su ON it.chk_uID = su.id
        GROUP BY it.responsible_agent
        HAVING total_issues != 0
    ";

    $queryResult = $mysqli->query($sql);
    $issueCountArray = [];

    while ($row = $queryResult->fetch_assoc()) {
        
        $issueCountArray[] = $row;
    }

    echo json_encode(['issueCntDet' => $issueCountArray]);
}
