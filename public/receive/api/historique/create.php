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
	  $credential = [
		'clientId' => 'SG0PMZxffgBKmI3YEveil3LAtKtQVxCY',
		'clientSecret' => 'ITjYt1ENgZUxHc99'
	  ];
	  $osms = new Osms\Osms($credential);
    $token = $osms->getTokenFromConsumerKey();


    $query = 'SELECT distinct telephone
      FROM users inner join capteurs on (users.etab=capteurs.etab) inner join historiques on (capteurs.code_capteur=historiques.capteur)
      where historiques.capteur='.$historique->capteur;
    $stmt = $historique->getConn()->prepare($query);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $osms->sendSMS('tel:+21693233173', 'tel:+216' . $row['telephone'], "Capteur ".$historique->capteur. " est en incendie", 'Baccar');
    }



    }
    else {
      echo json_encode(
        array('message' => 'historique pas ajouté')
      );
    }
}
