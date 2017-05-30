<?php
include 'include/init.php';

// faire un formulaire avec email et mot de passe, obligatoires.
$errors = [];
$email = $mdp = '';

if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	if (empty($_POST['email'])) {
		$errors['email'] = "L'email est obligatoire";
	}

	if (empty($_POST['mdp'])) {
		$errors['mdp'] = 'Le mot de passe est obligatoire';
	}

	if (empty($errors)) {
		/*
		aller chercher en bdd un utilisateur qui a l'email et le mot de passe qui corespondent
		et afficher un message d'erreur si on n'en trouve pas
		*/
		$query = 'SELECT * FROM membre WHERE email = :email AND mdp = :mdp';

		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindValue(':mdp', sha1($mdp), PDO::PARAM_STR);
		$stmt->execute();

		$membre = $stmt->fetch();

		if (!empty($membre)) {
			unset($membre['mdp']); // juste pour ne pas le stocker en session
			$_SESSION['membre'] = $membre;

			header('Location: index.php'); // redirection vers la page d'accueil
			die; // arr�te l'ex�cution du script
		} else {
			$errors['connexion'] = 'Email ou mot de passe incorrect';
		}
	}
}

include 'layout/top.php';
if (!empty($errors)) :
?>
	<div class="alert alert-danger" role="alert">
	<strong>
	<?= (isset($errors['connexion']))
		? $errors['connexion']
		: 'Le formulaire contient des erreurs';
	?>
	</strong>
	</div>
<?php
endif;
?>

								<div align="center">
                <button type="button" name="login" id="login" class="btn btn-success" data-toggle="modal" data-target="#loginModal">Login</button>
                </div>



<?php
include 'layout/bottom.php';
?>
