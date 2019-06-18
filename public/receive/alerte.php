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
 
 //fetch groupe of $capteur
 $sqlg = 'SELECT parent from capteurs where id='.$capteur;
 $resg = $conn->query($sqlg);
 $rowg = $resg->fetch_assoc();
 $groupe = $rowg['parent'];
	  
 //fetch etab of groupe
 $sqle = 'SELECT etab from capteurs where id ='.$groupe;
 $rese = $conn->query($sqle);
 $rowe=$rese->fetch_assoc();
 $etab = $rowe['etab'];
	  
 //fetch code_capteur from $capteur
 $sqlc = 'SELECT code_capteur from capteurs where id ='.$capteur;
 $resc = $conn->query($sqlc);
 $rowc=$resc->fetch_assoc();
 $code_capteur = $rowc['code_capteur'];
 
 //fetch date of last alert
 $sqll = 'SELECT historiques.created_at from historiques inner join capteurs on (capteurs.id=historiques.capteur) where parent = (select id from capteurs where etab ='.$etab.') and historiques.capteur = '.$capteur.' order by historiques.id DESC';
 $resl = $conn->query($sqll);
 $rowl = $resl->fetch_assoc();
 $date = $rowl['created_at'];
 
 //calculate minutes between time now and last alert
 $dif = (time()-date("U",strtotime($date)))/60;

 if($dif>60){
 //insert alert line into historiques table
 $sql= "INSERT INTO historiques (evenement, capteur, img, created_at)
 VALUES ('" . $data->evenement ."', ".$capteur.", '". $data->img ."','". $data->created_at."')";
 
 //check if query executed successfully
  if (mysqli_query($conn, $sql)) {
    echo "alerte ajouté avec succès";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
 
 ///////////////////////SMS API /////////////////
 $credential = [
      'clientId' => 'SG0PMZxffgBKmI3YEveil3LAtKtQVxCY',
      'clientSecret' => 'ITjYt1ENgZUxHc99'
      ];
      $osms = new Osms\Osms($credential);
      $token = $osms->getTokenFromConsumerKey();
	  
      $query = 'SELECT distinct telephone
        FROM users inner join capteurs on (users.etab='.$etab.') inner join historiques on (capteurs.id=historiques.capteur)
        where historiques.capteur='.$capteur;
	  $resq = $conn->query($query);
      while($rowq = $resq->fetch_assoc())
      {
         $osms->sendSMS('tel:+21693233173', 'tel:+216' . $rowq['telephone'], "Capteur ".$code_capteur. " est en incendie", 'GCI');
      }
  ///////////////////////SMS API /////////////////

  ///////////////////////////////////PUSH NOTIFICATION/////////////////////////

    $content = array(
        "en" => 'Capteur '.$code_capteur. ' est en incendie'
        );

    $fields = array(
        'app_id' => "a9e53700-31c3-4189-b2fc-5fbbc4634949",
	      'filters' => array(array("field" => "tag", "key" => "etab", "relation" => "=", "value" => $etab)),
        'data' => array("foo" => "bar"),
        'large_icon' =>"ic_launcher_round.png",
		'big_picture' => $data->img,
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
 else
 { echo "une alerte par heure";}

?>