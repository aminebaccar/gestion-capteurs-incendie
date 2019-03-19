<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Alive.php';


  $database = new Database();
  $db = $database->connect();
  $alive = new Alive($db);
  $data = json_decode(file_get_contents("php://input"));
  $alive->created_at = $data->created_at;
  $alive->capteur = $data->capteur;

  if($alive->create()) {
    echo json_encode(
      array('message' => 'alive ajouté')
    );
  } else {
    echo json_encode(
      array('message' => 'alive pas ajouté')
    );
  }
