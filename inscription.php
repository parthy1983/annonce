<?php
include 'include/init.php';

// les traitements ICI.
$errors = [];
$civilite = $nom = $prenom = $email = $mdp = $confirmation_mdp = $pseudo = $telephone = '';

if (!empty($_POST)) {
	sanitizePost();
//var_dump($_POST);
	extract($_POST); // http://php.net/manual/fr/function.extract.php

	if (empty($_POST['pseudo'])) { // pseudo validation
		$errors['pseudo'] = 'Le pseudo est obligatoire';
	}
	if (empty($_POST['mdp'])) { // mod de pass validation
		$errors['mdp'] = 'Le mot de passe est obligatoire';
		} elseif (strlen($_POST['mdp']) < 6) {
		$errors['mdp'] = 'Le mot de passe doit faire au moins 6 caractères';
	} elseif ($_POST['mdp'] != $_POST['confirmation_mdp']) {
		$errors['confirmation_mdp'] = 'Le mot de passe et sa confirmation ne sont pas identique';
	}
	if (empty($_POST['nom'])) { // nom validation
			$errors['nom'] = 'Le nom est obligatoire';
		}
	if (empty($_POST['prenom'])) { // prenom validation
			$errors['prenom'] = 'Le prenom est obligatoire';
		}

		if (empty($_POST['email'])) { // email validation
			$errors['email'] = "L'email est obligatoire";
		} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "L'email n'est pas valide";
		} else {
			$query = 'SELECT COUNT(*) FROM membre WHERE email=' . $pdo->quote($_POST['email']);
			$stmt = $pdo->query($query);
			$nbMembre = $stmt->fetchColumn();

			if (0 != $nbMembre) {
				$errors['email'] = "Un utilsateur existe déjà avec cette adresse email";
			}
		}

		if (empty($_POST['telephone'])) { // prenom validation
				$errors['telephone'] = 'Les numero de telephone est obligatoire';
			}

	if (empty($_POST['civilite'])) { //civilite validation
		$errors['civilite'] = 'La civilité est obligatoire';
	}


	if (empty($errors)) {
		echo  $query = 'INSERT INTO membre'
			. '(pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement)'
			. 'VALUES(:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, 0, now())'
		;

		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$stmt->bindValue(':mdp', sha1($_POST['mdp']), PDO::PARAM_STR);
		$stmt->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
		$stmt->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
		$stmt->bindParam(':telephone', $_POST['telephone'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
		$stmt->bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);


		if ($stmt->execute()) {
			$success = true;
		} else {
			$errors['bdd'] = 'Une erreur est survenue';
		}
	}
}

include 'layout/top.php';

if (!empty($success)) :
?>
	<div class="alert alert-success" role="alert">
	<strong>Votre compte est créé.</strong>
	</div>
<?php
endif;

if (!empty($errors)) :
?>
	<div class="alert alert-danger" role="alert">
	<strong>Le formulaire contient des erreurs</strong>
	</div>
<?php
endif;
?>
<!--
- Faire un formulaire "bootstrap"  en méthode POST pour l'inscription utilisateur :
Tous les champs sauf l'id et le role
mdp en champ password, civilité en select et adresse en textarea
faire l'insert en bdd si retour de post
Pour le mot de passe inserer sha1($_POST['mdp'])
- ajouter un champ confirmation_mdp de type password et affichier un message d'erreur si le mdp n'est pas le même dans les 2 champs
- vérifier que l'email n'existe pas en bdd => requête select count avec condition sur l'email
-->
<?php
// si on ne veut plus afficher le formulaire quand l'inscription s'est bien passée
if (empty($_POST) || empty($success)) :
?>

<div class="row">
  <div class="col-md-3"></div><!-- leftside -->
	<div class="col-md-6"> <!-- taille de form de regisration est col-md-6 -->

		<form method="post">
			<div class="form-group text-center">
		    <label for="exampleInputPassword1"><h3>S'inscrire</h3></label>

		  </div>
			<div class="form-group <?php displayErrorClass('pseudo', $errors); ?>">
				<input class="form-control" type="text" name="pseudo" value="<?= $nom; ?>" placeholder="Votre pseudo">
				<?php displayErrorMsg('pseudo', $errors); ?>
			</div>
			<div class="form-group <?php displayErrorClass('mdp', $errors); ?>">
				<input class="form-control" type="password" name="mdp" value="<?= $mdp; ?>" placeholder="Votre mod de passe">
				<?php displayErrorMsg('mdp', $errors); ?>
			</div>
			<div class="form-group <?php displayErrorClass('confirmation_mdp', $errors); ?>">
				<input class="form-control" type="password" name="confirmation_mdp" value="<?= $confirmation_mdp; ?>" placeholder="Retype votre mod de passe">
				<?php displayErrorMsg('confirmation_mdp', $errors); ?>
			</div>

			<form method="post">
				<div class="form-group <?php displayErrorClass('nom', $errors); ?>">
					<input class="form-control" type="text" name="nom" value="<?= $nom; ?>" placeholder="Votre nom">
					<?php displayErrorMsg('nom', $errors); ?>
				</div>
			<div class="form-group <?php displayErrorClass('prenom', $errors); ?>">
				<input class="form-control" type="text" name="prenom" value="<?= $prenom; ?>" placeholder="Votre prenom">
				<?php displayErrorMsg('prenom', $errors); ?>
			</div>
			<div class="form-group <?php displayErrorClass('email', $errors); ?>">
				<input class="form-control" type="text" name="email" value="<?= $email; ?>" placeholder="Votre email">
				<?php displayErrorMsg('email', $errors); ?>
			</div>

			<div class="form-group <?php displayErrorClass('telephone', $errors); ?>">
				<input class="form-control" type="text" name="telephone" value="<?= $telephone; ?>" placeholder="Votre telephone">
				<?php displayErrorMsg('telephone', $errors); ?>
			</div>

			<div class="form-group <?php displayErrorClass('civilite', $errors); ?>">
				<select class="form-control" name="civilite">
					<option value="">Civilite</option>
					<option value="h" <?php if($civilite == 'f') { echo 'selected'; } ?>>Madame</option>
					<option value="f" <?php if($civilite == 'h') { echo 'selected'; } ?>>Monsieur</option>
				</select>
				<?php displayErrorMsg('civilite', $errors); ?>
			</div>
			<div class="text-center">
				<button type="submit" class="btn btn-primary">Valider</button>
			</div>
		</form>
</div>

  <div class="col-md-3"></div><!-- A Drite -->
</div>



<?php
endif;

include 'layout/bottom.php';
?>
