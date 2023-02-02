<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "facture";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        // Get all clients
        $sql = "SELECT * FROM clients";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $clients = array();
            while($row = $result->fetch_assoc()) {
                $clients[] = $row;
            }
            echo json_encode($clients);
        } else {
            echo "0 results";
        }
        break;
    default:
        // Not supported
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}

$conn->close();