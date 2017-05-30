<?php
include 'include/init.php';
if (isset($_POST['titre']) && isset($_POST['contenu'])) {

	$titre = $_POST['titre'];
  $contenu = $_POST['contenu'];


//consolo.log($titre);
   $query = 'INSERT INTO ajax_categorie(categorie,contenu,membre_id) VALUES (:titre,:contenu)';

  			$stmt = $pdo->prepare($query);
  			$stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
  			$stmt->bindParam(':contenu', $contenu, PDO::PARAM_STR);
        $stmt->bindParam(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);


  		if ($stmt->execute()) {
  			$message = "categorie a bien ajouté";
  			}
        else {
          $message = "categorie n'a pas ajouté";
        }
        echo json_encode($message);

        //echo json_encode($query);
}
?>
