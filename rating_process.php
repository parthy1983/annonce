<?php
include 'include/init.php';
print_r($_POST);

if(isset($_POST['submit']) && !empty($_POST['submit'])) {
    $query = 'INSERT INTO note(membre_id1, membre_id2, note, avis, date_enregistrement) VALUES (:membre_id1,:membre_id2,:note,:avis,now())';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':membre_id1', $_POST['membre_id1'], PDO::PARAM_INT);
    $stmt->bindParam(':membre_id2', $_POST['membre_id2'], PDO::PARAM_INT);
    $stmt->bindParam(':note', $_POST['star'], PDO::PARAM_STR);
    $stmt->bindParam(':avis', $_POST['avis'], PDO::PARAM_STR);
  }

  if ($stmt->execute()) {
    $message = 'Votre avis a bien été envoyé';
    setFlashMessage($message);

  } else {
    $errors['bdd'] = 'Une erreur est survenue';
  }



  //Array ( [star] => 1 [avis] => sfqsf [commentaire] => qsfqsf [submit] => submit [membre_id1] => 6 [membre_id2] => 6 [annonce_id] => 2 )
  if(isset($_POST['commentaire']) && !empty($_POST['commentaire'])){
   $query_com = 'INSERT INTO commentaire(membre_id, annonce_id, commentaire, date_enregistrement) VALUES (:membre_id,:annonce_id,:commentaire,now())';
      $stmt_com = $pdo->prepare($query_com);
      $stmt_com->bindParam(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
      $stmt_com->bindParam(':annonce_id', $_POST['annonce_id'], PDO::PARAM_INT);
      $stmt_com->bindParam(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);

    }

    if ($stmt_com->execute()) {
       $message = 'Votre commentaire a bien été envoyé';
      setFlashMessage($message);
      header('Location: page_description.php?flag=1&id_annonce='.$_POST["annonce_id"]);
      die;


    //  header('Location: page_description.php?id_annonce='.$_POST["annonce_id"]);
      //die;
    } else {
      $errors['bdd'] = 'Une erreur est survenue';
    }



// query pour ajouter de commentaire;


?>
