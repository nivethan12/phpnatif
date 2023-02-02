<?php

use Faker\factory;
require_once 'vendor/autoload.php'


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = 'facture';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE facture";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Create table clients
$sql = "CREATE TABLE clients (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    nom VARCHAR(30) NOT NULL
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table clients created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
    // Create table factures
    $sql = "CREATE TABLE factures (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    client_id INT(6) UNSIGNED NOT FULL,
    montant INT(6) UNSIGNED NOT FULL,
    payee boolean NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id)
    )";
    
    if ($conn->query($sql) === TRUE) {
        echo "Table factures created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
    $faker = Faker\Factory::create();

    // Insert data into clients table
for ($i = 0; $i < 10; $i++) {
    $nom = $faker->lastName;
    $sql = "INSERT INTO clients (nom)
    VALUES ('$nom')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully into clients table";
    } else {
        echo "Error inserting data: " . $conn->error;
    }
}

$sql = "SELECT COUNT(*) FROM clients";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["nom"];
    }
} else {
    echo "0 results";
}


for ($i = 0; $i < $number_of_invoices; $i++) {
    $montant = $faker->randomFloat(2, 0, 1000);
    $client_id = $faker->numberBetween(1, 10);
    $payee = $faker->randomElement(array(0, 1));
    $sql = "INSERT INTO factures (montant, client_id, payee)
    VALUES ('$montant', '$client_id', '$payee')";
    if ($conn->query($sql) === TRUE) {
        echo "Facture créee";
    } else {
        echo "Erreur la facture n'est pas créee: " . $conn->error;
    }
}
    $conn->close();
    ?>




