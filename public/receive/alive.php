<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  require_once __DIR__.'/vendor/autoload.php';
  
	$servername = "api.tangorythm.com";
	$username = "sdiuser";
	$password = "Sdi2019user";
	$dbname = "sdi";

$conn = mysqli_connect($servername, $username, $password, $dbname);

//check connection status
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

  $data = json_decode(file_get_contents("php://input"));
 
 //fetch capteur
 $c = 'SELECT id FROM capteurs WHERE code_capteur = '.$data->capteur;
 $res = $conn->query($c);
 $row = $res->fetch_assoc();
 $capteur = $row['id'];
 
 //insert alert line into historiques table
 $sql= "INSERT INTO alive (created_at, capteur)
 VALUES ('" . $data->created_at ."', ".$capteur.")";
 
 //check if query executed successfully
  if (mysqli_query($conn, $sql)) {
    echo "alive ajouté avec succès";
	
	$sqlp= 'update capteurs set etat = "fonctionnant" where id = '.$row['id'];
 
 //check if query executed successfully
  if (mysqli_query($conn, $sqlp)) {
    echo "état capteur mis a jour avec succès";
} else {
    echo "Error: " . $sqlp . "<br>" . mysqli_error($conn);
}
	
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}