<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

	$servername = "api.tangorythm.com";
	$username = "sdiuser";
	$password = "Sdi2019user";
	$dbname = "sdi";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
  $data = json_decode(file_get_contents("php://input"));
  $e = $data->event_type;
  $to      = 'mohamedaminebaccar@gmail.com';
$subject = 'Paypal';
$message = $e;


mail($to, $subject, $message);



?>
