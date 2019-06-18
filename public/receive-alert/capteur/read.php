<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Capteur.php';

  $database = new Database();
  $db = $database->connect();

  $capteur = new Capteur($db);

  $result = $capteur->read();

  $num = $result->rowCount();

  if($num > 0) {
        $cap_arr = array();
        $cap_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $cap_item = array(
            'id' => $id,
            'code_capteur' => $code_capteur,
            'etat' => $etat,
            
            'created_at' => $created_at,
            'updated_at' => $updated_at
          );

          array_push($cap_arr['data'], $cap_item);
        }

        echo json_encode($cap_arr['data']);

  } else {
        echo json_encode(
          array('message' => 'aucun capteur trouvé')
        );

  }
