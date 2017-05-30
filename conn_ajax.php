<?php
include 'include/init.php';
	//extract($_POST);$message['con']
  $message[] = '';
if (isset($_POST['email']) && isset($_POST['mdp']) ) {
  /*
  aller chercher en bdd un utilisateur qui a l'email et le mot de passe qui corespondent
  et afficher un message d'erreur si on n'en trouve pas
  */
  $query = 'SELECT * FROM membre WHERE email = :email AND mdp = :mdp';

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
  $stmt->bindValue(':mdp', sha1($_POST['mdp']), PDO::PARAM_STR);
  $stmt->execute();

  $membre = $stmt->fetch();

  if (!empty($membre)) {
    unset($membre['mdp']); // juste pour ne pas le stocker en session
    $_SESSION['membre'] = $membre;
    $message['con'] = 1;
    //$message = "yes";
    //header('Location: index.php'); // redirection vers la page d'accueil
    //die; // arr�te l'ex�cution du script
  } else {
    $message['con'] = 0;
  }
  echo json_encode($message['con']);
}
?>
