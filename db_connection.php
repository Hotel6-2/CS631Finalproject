
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection file

$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP is empty
$dbname = "BankDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
