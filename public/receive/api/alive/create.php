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
    $server_key="AAAAqCBLa70:APA91bGPrS55v7alAoFdrBmi8_ZIb-qPkAyuAxZya7MWDkcIKlzYl0RiP4HmZCx8UtYw5YeeTOwb1Kfq0iYPN8tf1MJ7zC9Zf7c-lam4faaYpQT2KPqlpQTGNoP_i0CyN5AkxEBZ66xs"; // get this from Firebase project settings->Cloud Messaging
    $user_token=""; // Token generated from Android device after setting up firebase
    $title="Pas de signal";
    $n_msg="Il n'existe pas du signal, capteur: ".$alive->capteur;

    $ndata = array('title'=>$title,'body'=>$n_msg);

    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array();
    $fields['data'] = $ndata;

    $fields['to'] = $user_token;
    $headers = array(
      'Content-Type:application/json',
      'Authorization:key='.$server_key
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
      die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
  }
