<?php
include('path.php');
require_once $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';




$status = isset($_GET['status']) ? $_GET['status'] : 'pending';

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

$query .= " ORDER BY Date DESC LIMIT 100";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $br_id);
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




?>
