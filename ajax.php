<?php
include 'include/init.php';
$resultat = array();
if (isset($_POST['categorie_id'])) {

$categorie_id = $_POST['categorie_id'];

//SELECT Arrivee FROM `tgv` WHERE Depart = BREST
//$query = 'SELECT COUNT(*) FROM membre WHERE email=' . $pdo->quote($_POST['email']);
	$stat_categorie = $pdo->query('SELECT * FROM annonce WHERE categorie_id ='. $categorie_id);


	while($categories = $stat_categorie->fetch(PDO::FETCH_ASSOC)) {
		$resultat[] = $categories['titre'];
	}
  echo json_encode($resultat);
}
?>
