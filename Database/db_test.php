<?php
$servername = "localhost";
$username = "team06"; // The user you created in MySQL
$password = "password123"; // The password you set

// Create connection
$conn = new mysqli($servername, $username, $password);
// This is a test commit from VS Code over SSH
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "<h1>Database Connection Successful!</h1>";
echo "<p>PHP is now communicating with MySQL on your GCP VM.</p>";
?>
