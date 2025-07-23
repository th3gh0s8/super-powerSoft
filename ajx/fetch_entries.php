<?php
include('path.php');
require_once $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';

// Function to get the count of entries by status
function getEntryCount($mysqli, $br_id, $status) {
    $query = "SELECT COUNT(*) AS count FROM jentry WHERE `br_id`=? AND jentry_delete = 0 AND approved_status = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $br_id, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['count'];
}

// Handle different AJAX requests
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'fetch_entries':
            $status = isset($_GET['status']) ? $_GET['status'] : 'pending';
            $fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : null;
            $toDate = isset($_GET['to_date']) ? $_GET['to_date'] : null;

            $query = "
            SELECT
                Date AS transaction_date,
                IFNULL((SELECT AccName FROM jentry AS j2 WHERE j2.VNo = j1.VNo AND j2.Debit != 0 LIMIT 1), 'cash on hand') AS from_journal,
                IFNULL((SELECT AccName FROM jentry AS j3 WHERE j3.VNo = j1.VNo AND j3.Credit != 0 LIMIT 1), 'cash on hand') AS to_journal,
                Description,
                IFNULL(Credit, Debit) AS amount,
                userID,
                recodDate,
                ID, approved_status
            FROM jentry AS j1
            WHERE `br_id`=? AND jentry_delete = 0 ";

            if ($status === 'pending') {
                $query .= "AND approved_status = 0";
            } elseif ($status === 'approved') {
                $query .= "AND approved_status = 1";
            } elseif ($status === 'rejected') {
                $query .= "AND approved_status = 2";
            }

            if ($fromDate && $toDate) {
                $query .= " AND Date BETWEEN ? AND ?";
            }

            $query .= " ORDER BY Date DESC LIMIT 100";

            $stmt = $mysqli->prepare($query);

            if ($fromDate && $toDate) {
                $stmt->bind_param("iss", $br_id, $fromDate, $toDate);
            } else {
                $stmt->bind_param("i", $br_id);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['transaction_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['from_journal']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['to_journal']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                    echo "<td style='text-align:right;'>" . number_format($row['amount'], 2) . "</td>";
                    echo "<td>" . htmlspecialchars($row['userID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['recodDate']) . "</td>";
                    echo "<td>";
                    if ($status === 'pending') {
                        echo "<button type='button' class='btn btn-success btn-xs ajax-approve-btn' data-id='" . $row['ID'] . "' data-action='approve'>Approve</button>";
                        echo "<button type='button' class='btn btn-danger btn-xs ajax-approve-btn' data-id='" . $row['ID'] . "' data-action='reject'>Reject</button>";
                    } else {
                        echo $status === 'approved' ? "<span class='label label-success'>Approved</span>" : "<span class='label label-danger'>Rejected</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No entries found.</td></tr>";
            }
            break;

        case 'get_entry_counts':
            $pendingCount = getEntryCount($mysqli, $br_id, 0);
            $approvedCount = getEntryCount($mysqli, $br_id, 1);
            $rejectedCount = getEntryCount($mysqli, $br_id, 2);

            echo json_encode([
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'rejected' => $rejectedCount
            ]);
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}
?>
