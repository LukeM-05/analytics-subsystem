<?php
// 1. Check if we are running locally on XAMPP
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $servername = "localhost";
    $username = "root";       // Default XAMPP user
    $password = "";           // Default XAMPP password is blank!
    $dbname = "your_database_name"; // CHANGE THIS to your actual DB name
} 
// 2. Otherwise, we must be on the live Google Cloud VM!
else {
    $servername = "localhost"; 
    $username = "root";             // Or whatever your VM MySQL user is
    $password = "your_vm_password"; // CHANGE THIS to your VM database password
    $dbname = "MakeItAll"; // CHANGE THIS to your actual DB name
}

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Database connection failed.'); 
}
?>