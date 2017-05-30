<?php
/*
Page d'ajout de catégorie :
- un formulaire avec un champ nom
- contrôles : non vide, taille inférieure ou égal à 50 caractères, unique en bdd
- si pas d'erreur : insert en bdd
*/
include '../include/init.php';
//adminSecurity();

$errors = [];
$civilite = $nom = $prenom = $email = $mdp = $confirmation_mdp = $pseudo = $telephone = $statut = '';


if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);
if (!isset($_GET['id_membre'])) { // start of update validation

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

} // end of update validation
	if (empty($errors)) {
		if (isset($_GET['id_membre'])) {

			//echo $query = 'UPDATE membre SET pseudo = :pseudo ,mdp = :mdp ,nom = :nom ,prenom = :prenom ,telephone = :telephone ,email = :email ,civilite = :civilite , statut = :statut  WHERE id_membre = :id_membre';
			echo $query = 'UPDATE membre SET statut = :statut  WHERE id_membre = :id_membre';
			$stmt = $pdo->prepare($query);
	/*		$stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
			$stmt->bindParam(':mdp', sha1($_POST['mdp']), PDO::PARAM_STR);
			$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
			$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
			$stmt->bindParam(':telephone', $telephone, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':civilite', $civilite, PDO::PARAM_STR); */
			$stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
			$stmt->bindParam(':id_membre', $_GET['id_membre'], PDO::PARAM_INT);
		} else {
			echo $query = 'INSERT INTO membre'
 			. '(pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement)'
 			. 'VALUES(:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, statut:statut, "0", now())'
 		;
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
			$stmt->bindValue(':mdp', sha1($_POST['mdp']), PDO::PARAM_STR);
			$stmt->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
			$stmt->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
			$stmt->bindParam(':telephone', $_POST['telephone'], PDO::PARAM_STR);
			$stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
			$stmt->bindParam(':statut', $statut, PDO::PARAM_STR);
			$stmt->bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);
		}

		if ($stmt->execute()) {
			//echo "exec";
			$message = isset($_GET['id_membre'])
				? 'La membre a bien été modifiée'
				: 'La membre a bien été crée'
			;
			setFlashMessage($message);
			header('Location: membres.php');
			die;
		} else {
			echo "errors";
			$errors['bdd'] = 'Une erreur est survenue';
		}
	}
} elseif (isset($_GET['id_membre'])) {
	// si on a reçu un id dans l'url, on est en modification
	// on va chercher la catégorie en bdd
	 $query = 'SELECT * FROM membre WHERE id_membre = ' . $_GET['id_membre'];
	$stmt = $pdo->query($query);
	$membre = $stmt->fetch();

	if (empty($membre)) {
		// redirection si l'id ne correspond à aucune catégorie
		setFlashMessage($message);
		header('Location: membres.php');
		die;
	}

	$pseudo = $membre['pseudo'];
	$nom = $membre['nom'];
	$prenom = $membre['prenom'];
	$telephone = $membre['telephone'];
	$email = $membre['email'];
	$civilite = $membre['civilite'];
	$statut = $membre['statut'];

}
include 'include/adminTop.php';
//include '../layout/top.php';
?>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include 'include/sideMenubar.php';  ?>
            <!-- /.navbar-collapse -->

        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
															Gestion des membres
                        </h2>
												<p class="text-left">

													<a href="membre-edit.php"><?php if (isset($_GET['id_membre'])) {echo 'Modification';} else {echo 'Nouvelle';}?> membre</a>
												</p>
												<?php
												if (!empty($errors)) :
												?>
													<div class="alert alert-danger" role="alert">
														<strong>
														<?= (isset($errors['bdd']))
															? $errors['bdd']
															: 'Le formulaire contient des erreurs';
														?>
														</strong>
													</div>
												<?php
												endif;
												?>
												<div class="row">

													<div class="col-md-12">

												<form method="post">
													<?php	if (!isset($_GET['id_membre'])) { ?>
													<div class="form-group <?php displayErrorClass('pseudo', $errors); ?>">
														<label class="control-label">Pseudo</label>
														<input class="form-control" type="text" name="pseudo" value="<?= $pseudo; ?>" placeholder="Votre pseudo">
														<?php displayErrorMsg('pseudo', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('mdp', $errors); ?>">
														<label class="control-label">Mod de passe</label>
														<input class="form-control" type="password" name="mdp" value="<?= $mdp; ?>" placeholder="Votre mod de passe">
														<?php displayErrorMsg('mdp', $errors); ?>
													</div>
													<div class="form-group <?php displayErrorClass('confirmation_mdp', $errors); ?>">
														<label class="control-label">Retype mod de pass</label>
														<input class="form-control" type="password" name="confirmation_mdp" value="<?= $confirmation_mdp; ?>" placeholder="Retype votre mod de passe">
														<?php displayErrorMsg('confirmation_mdp', $errors); ?>
													</div>


														<div class="form-group <?php displayErrorClass('nom', $errors); ?>">
															<label class="control-label">Nom</label>
															<input class="form-control" type="text" name="nom" value="<?= $nom; ?>" placeholder="Votre nom">
															<?php displayErrorMsg('nom', $errors); ?>
														</div>
													<div class="form-group <?php displayErrorClass('prenom', $errors); ?>">
														<label class="control-label">Prenom</label>
														<input class="form-control" type="text" name="prenom" value="<?= $prenom; ?>" placeholder="Votre prenom">
														<?php displayErrorMsg('prenom', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('email', $errors); ?>">
														<label class="control-label">Email</label>
														<input class="form-control" type="text" name="email" value="<?= $email; ?>" placeholder="Votre email">
														<?php displayErrorMsg('email', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('telephone', $errors); ?>">
														<label class="control-label">Telephone</label>
														<input class="form-control" type="text" name="telephone" value="<?= $telephone; ?>" placeholder="Votre telephone">
														<?php displayErrorMsg('telephone', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('civilite', $errors); ?>">
														<label class="control-label">Civilite</label>
														<select class="form-control" name="civilite">
															<option value="">Civilite</option>
															<option value="f" <?php if($civilite == 'f') { echo 'selected'; } ?>>Madame</option>
															<option value="h" <?php if($civilite == 'h') { echo 'selected'; } ?>>Monsieur</option>
														</select>
														<?php displayErrorMsg('civilite', $errors); ?>
													</div>
													<?php } ?>
													<div class="form-group <?php displayErrorClass('statut', $errors); ?>">
														<label class="control-label">Statut</label>
														<select class="form-control" name="statut">
															<option value="1" <?php if($statut == '1') { echo 'selected'; } ?>>Admin</option>
															<option value="0" <?php if($statut == '0') { echo 'selected'; } ?>>User</option>
														</select>
														<?php displayErrorMsg('statut', $errors); ?>
													</div>

													<div class="text-center">
														<button type="submit" class="btn btn-primary">Enregistrer</button>
													</div>
												</form>
											</div>

                    </div>
                </div>

                <!-- /.row -->

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php
 include 'include/adminTop.php';
 ?>
