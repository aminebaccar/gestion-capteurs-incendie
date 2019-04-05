<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Historique.php';
  require __DIR__.'/vendor/autoload.php';



  $database = new Database();
  $db = $database->connect();
  $historique = new Historique($db);
  $data = json_decode(file_get_contents("php://input"));
  $historique->evenement = $data->evenement;
  $historique->capteur = $data->capteur;
  $historique->consulte = null;
  $historique->created_at = $data->created_at;
  $historique->updated_at = $data->updated_at;

  $query0 = 'SELECT created_at
    FROM historiques
    order by created_at desc
    limit 1';
  $stmt0 = $historique->getConn()->prepare($query0);
  $stmt0->execute();
  $row0 = $stmt0->fetch(PDO::FETCH_ASSOC);
  $last = $row0['created_at'];
  $lasttime = strtotime($last);

  $minutes = abs(strtotime($historique->created_at) - $lasttime) / 60;
  if($minutes > 60)
{
  if($historique->create()) {
    echo json_encode(
      array('message' => 'historique ajouté')
    );

    }
    else {
      echo json_encode(
        array('message' => 'historique pas ajouté')
      );
    }
}
