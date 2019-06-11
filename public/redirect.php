<?php
  $idFacture = $_GET['id'];
	$servername = "api.tangorythm.com";
	$username = "sdiuser";
	$password = "Sdi2019user";
	$dbname = "sdi";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "UPDATE factures
SET paie = 1
WHERE id = ".$idFacture."; ";

if (mysqli_query($conn, $sql)) {
    echo "facture archivé avec succès";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
$location = "http://gestioncapteursincendie.herokuapp.com/factures";
header("Location: $location?success=Facture payée avec succès");
?>
