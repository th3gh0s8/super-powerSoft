<?php
session_start();


// --- Handle Approve/Reject Actions ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['jentry_id'], $_POST['action'])) {
    $jentry_id = intval($_POST['jentry_id']);
    $action = ($_POST['action'] === 'approve') ? 'Approved' : 'Rejected';
    $approved_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'system';
    $approved_dateTime = date('Y-m-d H:i:s');

    $stmt = $mysqli->prepare("UPDATE jentry SET approved_status = ?, approved_by = ?, approved_dateTime = ? WHERE ID = ?");
    $stmt->bind_param("sssi", $action, $approved_by, $approved_dateTime, $jentry_id);
    $stmt->execute();
    $stmt->close();

    // Optional: Set flash messages
    $_SESSION['flash'] = "Journal entry $action successfully!";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// --- Fetch Journal Entries ---
$query = "
SELECT
Date AS transaction_date,
(SELECT AccName FROM jentry AS j2 WHERE j2.ID = j1.ID AND j2.Debit > 0 LIMIT 1) AS from_journal,
(SELECT AccName FROM jentry AS j3 WHERE j3.ID = j1.ID AND j3.Credit > 0 LIMIT 1) AS to_journal,
Description,
IFNULL(Debit, Credit) AS amount,
userID,
recodDate,
ID, approved_status
FROM jentry AS j1
WHERE jentry_delete = 0
GROUP BY j1.ID
ORDER BY Date DESC
LIMIT 100
";
$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Journal Entries Approval</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
<style>
.custmTB2 th, .custmTB2 td { vertical-align: middle !important; }
.flash-message { margin: 10px 0; }
</style>
</head>
<body>
<div class="container">
<h2>Journal Entries Approval</h2>

<?php if (!empty($_SESSION['flash'])): ?>
<div class="alert alert-success flash-message">
<?php echo htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
</div>
<?php endif; ?>

<table class="table table-bordered bootstrap-datatable responsive table-hover custmTB2">
<thead>
<tr>
<th>Date</th>
<th>From Journal</th>
<th>To Journal</th>
<th>Description</th>
<th style="text-align:right;">Amount</th>
<th>User</th>
<th>Recoded Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
<td><?php echo htmlspecialchars($row['transaction_date']); ?></td>
<td><?php echo htmlspecialchars($row['from_journal']); ?></td>
<td><?php echo htmlspecialchars($row['to_journal']); ?></td>
<td><?php echo htmlspecialchars($row['Description']); ?></td>
<td style="text-align:right;"><?php echo number_format($row['amount'], 2); ?></td>
<td><?php echo htmlspecialchars($row['userID']); ?></td>
<td><?php echo htmlspecialchars($row['recodDate']); ?></td>
<td>
<?php if ($row['approved_status'] != 'Approved' && $row['approved_status'] != 'Rejected'): ?>
<form method="post" action="" style="display:inline;">
<input type="hidden" name="jentry_id" value="<?php echo $row['ID']; ?>">
<input type="hidden" name="action" value="approve">
<button type="submit" class="btn btn-success btn-xs">Approve</button>
</form>
<form method="post" action="" style="display:inline;">
<input type="hidden" name="jentry_id" value="<?php echo $row['ID']; ?>">
<input type="hidden" name="action" value="reject">
<button type="submit" class="btn btn-danger btn-xs">Reject</button>
</form>
<?php elseif ($row['approved_status'] == 'Approved'): ?>
<span class="label label-success">Approved</span>
<?php elseif ($row['approved_status'] == 'Rejected'): ?>
<span class="label label-danger">Rejected</span>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr>
<td colspan="8">No journal entries found.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
</body>
</html>
<?php $mysqli->close(); ?>
