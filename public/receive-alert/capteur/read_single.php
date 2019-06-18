<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Capteur.php';
  $database = new Database();
  $db = $database->connect();
  $capteur = new Capteur($db);

  $capteur->id = isset($_GET['id']) ? $_GET['id'] : die();

  $capteur->read_single();

  $capteur_arr = array(
    'id' => $capteur->id,
    'code_capteur' => $capteur->code_capteur,
    'etat' => $capteur->etat,
    'etab' => $capteur->etab,
    'created_at' => $capteur->created_at,
    'updated_at' => $capteur->updated_at
  );

  print_r(json_encode($capteur_arr));
