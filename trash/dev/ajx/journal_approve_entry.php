<?php
include('path.php');
require_once $path . '../function.php';
require_once $path . '../session_file.php';
require_once $path . 'connection.php';

header('Content-Type: application/json');

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST['jentry_id'], $_POST['action'])) {
        $jentry_id = intval($_POST['jentry_id']);
        $approved_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'system';
        $approved_dateTime = date('Y-m-d H:i:s');

        if ($_POST['action'] === 'approve') {
            $status = 1; // Approved
        } elseif ($_POST['action'] === 'reject') {
            $status = 2; // Rejected
        } else {
            $status = 0; // Pending
        }

        $stmt = $mysqli->prepare("UPDATE jentry SET approved_status = ?, approved_by = ?, approved_dateTime = ? WHERE ID = ?");
        if ($stmt === false) {
            echo json_encode(['status' => 'error', 'msg' => 'Prepare failed: ' . htmlspecialchars($mysqli->error)]);
            exit();
        }
        $stmt->bind_param("issi", $status, $approved_by, $approved_dateTime, $jentry_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'ok', 'new_status' => $status === 1 ? 'Approved' : 'Rejected']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Execute failed: ' . htmlspecialchars($stmt->error)]);
        }
        $stmt->close();
        exit();
    }
}




?>
