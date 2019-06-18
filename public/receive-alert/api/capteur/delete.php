<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Capteur.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog capteur object
  $capteur = new Capteur($db);

  // Get raw capteured data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $capteur->id = $data->id;

  // Delete capteur
  if($capteur->delete()) {
    echo json_encode(
      array('message' => 'capteur supprimé')
    );
  } else {
    echo json_encode(
      array('message' => 'capteur pas supprimé')
    );
  }
