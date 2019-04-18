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

///////////////////////////////////PUSH NOTIFICATION/////////////////////////

    $content = array(
        "en" => 'Capteur '.$historique->capteur. 'est en incendie'
        );

		$q = 'SELECT etab from capteurs where code_capteur='.$historique->capteur.' limit 1';
		$st = $historique->getConn()->prepare($q);
		$st->execute();
		$e = $st->fetch(PDO::FETCH_ASSOC);

    $ourouru = 'SELECT id from etablissements where nom like " '.$e['etab'].' " limit 1';
    $oro = $historique->getConn()->prepare($ourouru);
    $oro->execute();
    $ror=$oro->fetch(PDO::FETCH_ASSOC);


    $fields = array(
        'app_id' => "a9e53700-31c3-4189-b2fc-5fbbc4634949",
	      'filters' => array(array("field" => "tag", "key" => "etab", "relation" => "=", "value" => $ror['id'])),
        'data' => array("foo" => "bar"),
        'large_icon' =>"ic_launcher_round.png",
        'contents' => $content
    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic OGMwNjg1OWMtNzhjMi00NjYxLWJhZDEtODliNjM1YmYwODY2'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

$return["allresponses"] = $response;
$return = json_encode( $return);
print("\n\nJSON received:\n");
print($return);
print("\n");


///////////////////////////////////PUSH NOTIFICATION/////////////////////////

    }
    else {
      echo json_encode(
        array('message' => 'historique pas ajouté')
      );
    }
}
