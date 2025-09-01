<?php
include('path.php');
require_once $path . '../connection_log.php';
require_once $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';
include('../function.php');

include('../imageUp.php');

$action = $_POST['action'];

if ($action == 'loadCus') {
    $sql_cus_count = $mysqli->query("SELECT ID, br_id, CustomerID, cusName, TelNo, MobNo, EmailNo, Active2 FROM custtable WHERE br_id='$br_id' ORDER BY ID DESC");

    $cusArray = [];
    $today = new DateTime(); // Get today's date

    while ($sqlRow = $sql_cus_count->fetch_assoc()) {
        $inactiveCol = ($sqlRow['Active2'] === 'NO') ? 'style="color: burlywood;"' : '';

        $cusDet = cusDet($sqlRow['CustomerID'], "0");
        $expDates = '';
        $expStyle = '';

        foreach ($cusDet['branch'] as $cd) {
            $expDateObj = DateTime::createFromFormat('Y-m-d', $cd['expire_date']);

            if ($expDateObj) {
                $diffDays = $today->diff($expDateObj)->days;
                $isPast = $expDateObj < $today;

                // Set color based on expiration date
                if ($isPast) {
                    $expStyle = 'class="badge bg-danger"'; // Expired
                } elseif ($diffDays <= 21) {
                    $expStyle = 'class="badge bg-warning text-dark"'; // Expiring in 7 Days
                }
            }

            $expDates .= "<span $expStyle>" . $cd['br_code'] . ': ' . $cd['expire_date'] . "</span><br/>";
        }
        $expDates = rtrim($expDates, '<br/>');

        $sqlRow['inactiveStyle'] = $inactiveCol;
        $sqlRow['expDates'] = $expDates;
        $cusArray[] = $sqlRow;
    }
    echo json_encode(['cusDet' => $cusArray]);
}

if ($action == 'loadBranchDropdown') {
    $comIDD = $_POST['comIDD'];
    $brIDD = $_POST['brIDD'];

    $result = CusDet($comIDD, $brIDD);
    $branchArray = [];
    foreach ($result['branch'] as $cd) {
        $branchArray[] = [
            'ID' => $cd['ID'],
            'name' => $cd['name'],
            'br_code' => $cd['br_code'],
        ];
    }
    echo json_encode(['branches' => $branchArray]);
}

if ($action == 'insertLogData') {
    $logType = $_POST['logType'];
    $CUSID = $_POST['CUSID']; // Ensure correct case
    $call_date = $_POST['call_date']; // Direct assignment if already YYYY-MM-DD
    $cName = $_POST['cName'];
    $cNumber = $_POST['cNumber'];
    $dInformation = $_POST['dInformation'];
    $rDate = date('Y-m-d');
    $rTime = date('H:i:s');
    $logID = $_POST['logID'];
    $branchNoLog = $_POST['branchNoLog'];

    $response = [
        'status' => 'error',
        'message' => ''
    ];

    if (empty($logID)) {
        // Insert new record
        $sql_insert = $mysqli->query("
            INSERT INTO web_cus_call 
            (mobile, cusID, cus_name, remark, issue, call_date, rdate, rtime, user_id, br_id, repID, status) 
            VALUES 
            ('$cNumber', '$CUSID', '$cName', '$logType', '$dInformation', '$call_date', '$rDate', '$rTime', '$user_id', '$branchNoLog', '', 'Pending')
        ");

        if ($sql_insert) {
            if (!empty($_POST['issue_type'])) {
                $result = insertOrUpdateIssue($mysqli, $_POST, $user_id);
            }
            $response['status'] = 'success';
            $response['message'] = 'Data inserted successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Insertion failed: ' . $mysqli->error;
        }
    } else {
        // Update existing record
        $sql_update = $mysqli->query("
            UPDATE web_cus_call 
            SET mobile = '$cNumber', cusID = '$CUSID', cus_name = '$cName', remark = '$logType', issue = '$dInformation', call_date = '$call_date', rdate = '$rDate', rtime = '$rTime', user_id = '$user_id', br_id = '$branchNoLog', repID = '', status = 'Updated' 
            WHERE ID = '$logID'
        ");

        if ($sql_update) {
            if (!empty($_POST['issue_type'])) {
                $result = insertOrUpdateIssue($mysqli, $_POST, $user_id);
            }
            $response['status'] = 'success';
            $response['message'] = 'Data updated successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Update failed: ' . $mysqli->error;
        }
    }
    echo json_encode($response);
}

if ($action == 'loadTable1') {
    $cusValue = $_POST['cusValue'];
    $sql = "SELECT issue_tb.*, salesrep.Name AS agent_name 
        FROM issue_tb 
        LEFT JOIN salesrep 
        ON issue_tb.responsible_agent = salesrep.ID 
        WHERE cusID = '$cusValue'";
    $result = $mysqli->query($sql);
    $conDet = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $conDet[] = $row;
        }
    }
    echo json_encode(array('conDet' => $conDet));
}

function generateTicketNumber($mysqli)
{
    $query = "SELECT ticketNo FROM issue_tb ORDER BY ID DESC LIMIT 1";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $latestTicket = (int)$row['ticketNo'];
        $newNumber = $latestTicket + 1;
    } else {
        $newNumber = 10000;
    }

    return str_pad($newNumber, 5, '0', STR_PAD_LEFT);
}

if ($action == 'getIssue') {
    $issueID = $_POST['issueID'];
    $sql = "SELECT * FROM issue_tb WHERE ID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $issueID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Issue not found']);
    }
    exit;
}

if ($action == 'getLog') {
    $logID = $_POST['logID'];
    $sql = "SELECT * FROM web_cus_call WHERE ID = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $logID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Issue not found']);
    }
    exit;
}

if ($action == 'loadLogData') {
    $cusId = $_POST['cusId'];
    $sqlLogs = $mysqli->query("SELECT web_cus_call.*, custtable.cusName AS customer_name FROM web_cus_call 
    LEFT JOIN custtable 
        ON web_cus_call.cusID = custtable.ID
    WHERE cusID='$cusId'");
    $cusLogArray = [];
    while ($rowLogs = $sqlLogs->fetch_assoc()) {
        $cusLogArray[] = $rowLogs;
    }
    echo json_encode(['logDet' => $cusLogArray]);
}

// Example usage:
if ($action == 'insertData') {
    $result = insertOrUpdateIssue($mysqli, $_POST, $user_id);
    echo json_encode($result);
}

function insertOrUpdateIssue($mysqli, $data, $user_id)
{
    $issueType = isset($data['issueType']) ? $data['issueType'] : '';
    $branchNo = isset($data['branchNo']) ? $data['branchNo'] : '';
    $priorityLevel = isset($data['priorityLevel']) ? $data['priorityLevel'] : '';
    $contactName = isset($data['contactName']) ? $data['contactName'] : '';
    $contactNumber = isset($data['contactNumber']) ? $data['contactNumber'] : '';
    $description = isset($data['description']) ? $data['description'] : '';
    $responsibleAgent = isset($data['responsibleAgent']) ? $data['responsibleAgent'] : '';
    $cid = isset($data['cid']) ? $data['cid'] : '';
    $issueID = isset($data['issueID']) ? $data['issueID'] : '';
    $issueSection = isset($data['issueSection']) ? $data['issueSection'] : '';

    $ticketNo = generateTicketNumber($mysqli);
    $rDateTime = date('Y-m-d H:i:s');
    $rDate = date('Y-m-d');
    $rTime = date('H:i:s');

    $response = [
        'status' => 'error',
        'message' => '',
        'imageUpload' => true,
        'voiceUpload' => true
    ];

    if (empty($issueID)) {
        // Insert new issue
        $sql_insert = $mysqli->query("INSERT INTO issue_tb (cusID, type, category, section, br_id, ticketNo, priorityLevel, contact_person, contact_number, responsible_agent, complaint, issueStatus, rDate, rTime) VALUES ('$cid', 'NO', '$issueType', '$issueSection', '$branchNo', '$ticketNo','$priorityLevel', '$contactName', '$contactNumber', '$responsibleAgent', '$description', 'Pending', '$rDate', '$rTime')");

        if ($sql_insert) {
            $lastInsertId = $mysqli->insert_id;
            $mysqli->query("INSERT INTO issue_history (issueTb, status, ref_status, user_id, rDateTime) VALUES ('$lastInsertId', 'new issue', 'issue', '$user_id', '$rDateTime')");

            $response['status'] = 'success';
            $response['message'] = 'Data inserted successfully';
            $response['issueID'] = $lastInsertId;
        } else {
            $response['message'] = 'Data insertion failed';
        }
    } else {

        $archiveResult = archiveIssueBeforeDelete($mysqli, $issueID, 'Edited');
        // Update existing issue
        $sql_update = $mysqli->query("UPDATE issue_tb SET category='$issueType', section='$issueSection', br_id='$branchNo', priorityLevel='$priorityLevel', contact_person='$contactName', contact_number='$contactNumber', responsible_agent='$responsibleAgent', complaint='$description' WHERE ID='$issueID'");

        if ($sql_update) {
            $mysqli->query("INSERT INTO issue_history (issueTb, status, ref_status, user_id, rDateTime) VALUES ('$issueID', 'updated', 'issue', '$user_id', '$rDateTime')");

            $response['status'] = 'success';
            $response['message'] = 'Issue updated successfully';
            $response['issueID'] = $issueID;
        } else {
            $response['message'] = 'Issue update failed';
        }
    }

    if ($response['status'] === 'success' && !empty($_FILES['file']['tmp_name'][0])) {
        $rfnsTb = $response['issueID'];
        $successUploads = [];

        foreach ($_FILES['file']['tmp_name'] as $index => $tmpName) {
            $originalName = $_FILES['file']['name'][$index];
            $size = $_FILES['file']['size'][$index];

            // Get file extension
            $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            // Generate a unique name
            $imageName = $rfnsTb . '_issue_' . $index;

            // Upload file
            $profileUpload = uploadImage($rfnsTb, $originalName, $tmpName, $size, $imageName, 'Issue');

            // Determine record type
            if ($fileExtension === 'pdf') {
                $recordType = 'PDF';
            } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi', 'webm'])) {
                $recordType = 'Video';
            } else {
                $recordType = 'Image';
            }

            // Call saveRecord with proper type
            saveRecord($profileUpload['success'], $profileUpload['imageName'], $rDate, $rTime, $branchNo, $rfnsTb, $ticketNo, $user_id, $recordType);

            if ($profileUpload['success'] == false) {
                $response['imageUpload'][] = [
                    'image' => $originalName,
                    'status' => false,
                    'message' => "File not uploaded - " . $profileUpload['showMessage']
                ];
            } else {
                $successUploads[] = $profileUpload['imageName'];
            }
        }

        if (count($successUploads) > 0) {
            $response['imageUpload'][] = [
                'status' => true,
                'uploaded' => $successUploads
            ];
        }
    }


    if ($response['status'] === 'success' && isset($_FILES['voice_note']) && !empty($_FILES['voice_note']['tmp_name'])) {
        $rfnsTb = $response['issueID'];
        $originalName = $_FILES['voice_note']['name'];
        $tmpName = $_FILES['voice_note']['tmp_name'];
        $size = $_FILES['voice_note']['size'];

        // Get file extension
        $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // Generate unique name
        $voiceName = $rfnsTb . '_voice_note';

        // Upload voice note (reuse your uploadImage function or create a similar one)
        $uploadResult = uploadImage($rfnsTb, $originalName, $tmpName, $size, $voiceName, 'Voice');

        // Call saveRecord with type = 'Voice'
        $recordType = 'Voice';
        saveRecord($uploadResult['success'], $uploadResult['imageName'], $rDate, $rTime, $branchNo, $rfnsTb, $ticketNo, $user_id, $recordType);

        if ($uploadResult['success'] == false) {
            $response['voiceUpload'][] = [
                'file' => $originalName,
                'status' => false,
                'message' => "Voice note not uploaded - " . $uploadResult['showMessage']
            ];
        } else {
            $response['voiceUpload'][] = [
                'status' => true,
                'uploaded' => $uploadResult['imageName']
            ];
        }
    }
    return $response;
}
