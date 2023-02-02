<?php

use PDO;
use PDOException;

//Se connecter à la base de données
try{
    $connection = new PDO('mysql:host=localhost;dbname=Facturation', 'metarar22', 'root');
    }
    catch (PDOException $erreur){
        die('Erreur: ' . $erreur->getMessage());
    }

$request_method = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

switch($request_method)
{
  case 'GET':
    if(!empty($_GET["Client_id"]))
    {
      // Récupérer une seule facture par l'ID
      $id = ($_GET["Client_id"]);
      getClient($id);
    }
    else
    {
      // Récupérer toutes les factures
      getAllClient();
    }
    break;

  case 'POST':
    //Ajouter une Facture
    addClient();
    break;
  
  case 'DELETE';
  //Supprimer une facture
    deleteClient();
    break;

  default:
    // Requête invalide
    header("Method Not Allowed");
    break;
  
}

//Extraire toutes les factures
function getAllClient(){
  global $connection;
  $sql = "SELECT * FROM Client";
  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($result);
}   


//Extraire une seule facture
function getClient($Client_id){
  global $connection;
  $sql = "SELECT * FROM Client WHERE Client_id = $Client_id";
  $stmt = $connection->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($result);
}   

//Ajouter une facture
function addClient(){
  global $connection;  
  $Client_id = $_POST["Client_id"];
  $Client_name = $_POST["Client_name"];
  $Client_adress = $_POST["Client_adress"];
  
  try{
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO Client(Client_id, Client_name, Client_adress) VALUES('$Client_id', '$Client_name', '$Client_adress')";
    $connection->exec($sql);
    echo "Insertion réussie";
    }catch (PDOException $erreur){
      die('Erreur: ' . $erreur->getMessage());

}
}

function deleteClient(){
  global $connection;
  $Client_id = $_GET['Client_id'];
  $sql = "DELETE FROM Client WHERE Client_id= :Client_id";
  $stmt = $connection->prepare($sql);
  $stmt->bindParam(':Client_id', $Client_id, PDO::PARAM_INT);
  if ($stmt->execute()){
    echo 'Client deleted';
  }
  
}
