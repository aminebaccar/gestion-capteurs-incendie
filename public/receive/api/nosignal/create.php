<?php

  include_once '../../config/Database.php';
  include_once '../../models/Historique.php';
  require __DIR__.'/vendor/autoload.php';



  $database = new Database();
  $db = $database->connect();
  $historique = new Historique($db);
  $query1 = 'SELECT capteur, created_at
             FROM alive
             WHERE id IN (
                          SELECT MAX(id)
                          FROM alive
                          GROUP BY capteur
                         )';
  $stmt1 = $historique->getConn()->prepare($query1);
  $stmt1->execute();
  while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){

  $last1 = $row1['created_at'];
  $lasttime1 = (time()-strtotime($last1))/60;
echo $lasttime1;
echo $row1['capteur'];
  $historique->evenement = "Pas de signal";
  $historique->capteur = $row1['capteur'];
  $historique->consulte = null;
  $historique->created_at = $row1['created_at'];

  if($lasttime1>2){

    $query0 = 'SELECT created_at
      FROM historiques
      order by id desc
      limit 1';
    $stmt0 = $historique->getConn()->prepare($query0);
    $stmt0->execute();
    $row0 = $stmt0->fetch(PDO::FETCH_ASSOC);
    $last = $row0['created_at'];
    echo $last;
    $lasttime = strtotime($last);

    $minutes = strtotime($historique->created_at) - $lasttime / 60;
    echo " BONJOUR   ".$minutes;
    if($minutes > 60)
    {
    if($historique->create()) {
      echo json_encode(
        array('message' => 'historique ajouté')
      );
      echo "mawdhou3";
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
        $osms->sendSMS('tel:+21693233173', 'tel:+216' . $row['telephone'], "Capteur ".$historique->capteur. " n'a pas de signal", 'Baccar');
      }

      }
      else {
        echo json_encode(
          array('message' => 'historique pas ajouté')
        );
      }

}

}

// last alive signal

}
