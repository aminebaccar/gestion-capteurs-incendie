<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Capteur.php';


  $database = new Database();
  $db = $database->connect();
  $capteur = new Capteur($db);
  $data = json_decode(file_get_contents("php://input"));
  $capteur->code_capteur = $data->code_capteur;
  $capteur->etat = $data->etat;
  $capteur->created_at = $data->created_at;
  $capteur->updated_at = $data->updated_at;

  if($capteur->create()) {
    echo json_encode(
      array('message' => 'capteur ajouté')
    );
  } else {
    echo json_encode(
      array('message' => 'capteur pas ajouté')
    );
  }
