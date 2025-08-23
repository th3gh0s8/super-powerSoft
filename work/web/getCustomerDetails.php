<?php
include('path.php');
include($path . 'connection.php');

if (isset($_POST['customerID'])) {
    $customerID = $_POST['customerID'];
    
    // Query to get customer details
    $query = $mysqli->query("SELECT ID, CustomerID, cusName, Address, TelNo, MobNo 
                            FROM custtable 
                            WHERE CustomerID = '$customerID'");
    
    if ($query && $query->num_rows > 0) {
        $customer = $query->fetch_assoc();
        
        echo json_encode([
            'status' => 'success',
            'ID' => $customer['ID'],
            'cusName' => $customer['cusName'],
            'Address' => $customer['Address'],
            'TelNo' => $customer['TelNo'],
            'MobNo' => $customer['MobNo']
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Customer not found'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Customer ID not provided'
    ]);
}
?>