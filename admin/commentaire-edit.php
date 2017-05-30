<?php
/*
Page d'ajout de catégorie :
- un formulaire avec un champ nom
- contrôles : non vide, taille inférieure ou égal à 50 caractères, unique en bdd
- si pas d'erreur : insert en bdd
*/
include '../include/init.php';
adminSecurity();

$errors = [];
$commentaire = $membre = $annonce1= '';
//print_r($_POST);
//print_r($_GET);
if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	if (empty($commentaire)) {
		$errors['commentaire'] = 'Le commentaire est obligatoire';
	}

	if (empty($membre)) {
		$errors['commentaire'] = 'membre est obligatoire';
	}

	if (empty($annonce1)) {
		$errors['commentaire'] = "l'annonce est obligatoire";
	}

	if (empty($errors)) {
		if (isset($_GET['id_commentaire'])) {
			$query = 'UPDATE commentaire SET membre_id = :membre_id , annonce_id = :annonce_id, commentaire = :commentaire  WHERE 	id_commentaire = :id_commentaire';

			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':membre_id', $membre, PDO::PARAM_INT);
			$stmt->bindParam(':annonce_id', $annonce1, PDO::PARAM_INT);
			$stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
			$stmt->bindParam(':id_commentaire', $_GET['id_commentaire'], PDO::PARAM_INT);
		} else {
			$query = 'INSERT INTO commentaire(membre_id,annonce_id,commentaire,date_enregistrement) VALUES (:membre_id,:annonce_id,:commentaire,now())';
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':membre_id', $membre, PDO::PARAM_INT);
			$stmt->bindParam(':annonce_id', $annonce1, PDO::PARAM_INT);
			$stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
		}

		if ($stmt->execute()) {
			echo "exec";
			//exit;
			$message = isset($_GET['id_commentaire'])
				? 'La commentaire a bien été modifiée'
				: 'La commentaire a bien été créée'
			;
			setFlashMessage($message);
			header('Location: commentaire.php');
			die;
		} else {
			$errors['bdd'] = 'Une erreur est survenue';
		}
	}
} elseif (isset($_GET['id_commentaire'])) {
	// si on a reçu un id dans l'url, on est en modification
	// on va chercher la catégorie en bdd
	 $query = 'SELECT * FROM commentaire WHERE id_commentaire = ' . $_GET['id_commentaire'];

	$stmt = $pdo->query($query);
	$commentaire = $stmt->fetch();

	if (empty($commentaire)) {
		// redirection si l'id ne correspond à aucune catégorie
		setFlashMessage($message);
		header('Location: commentaire.php');
		die;
	}

	//
	echo $membre = $commentaire['membre_id'];
	echo $annonce1 = $commentaire['annonce_id'];
	extract($commentaire);

		//exit;
	//$photoActuelle = $annonce['photo'];
	//$commentaire = $commentaire['commentaire'];
}


// requête pour remplir le select des membres
$query = 'SELECT * FROM membre ORDER BY id_membre';
$stmt = $pdo->query($query);
$membres = $stmt->fetchAll();


	// requête pour remplir le select des annonce
$query_annonce = 'SELECT * FROM annonce ORDER BY id_annonce';
$stmt_annonce = $pdo->query($query_annonce);
$annonces = $stmt_annonce->fetchAll();

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
															Categorie
                        </h2>
												<p class="text-center">

													<a href="commentaire-edit.php"><?php if (isset($_GET['id_commentaire'])) {echo 'Modification';} else {echo 'Nouvelle';}?> catégorie</a>
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

												<form method="post">

													<div class="form-group <?php displayErrorClass('membre', $errors); ?>">
														<label class="control-label">membre</label>
														<select class="form-control" name="membre">
															<option value="">Choisissez...</option>
															<?php
															foreach ($membres as $mem) :
																$selected = ($mem['id_membre'] == $membre)
																	? 'selected'
																	: ''
																;
															?>
																<option value="<?= $mem['id_membre']; ?>" <?= $selected; ?>><?= $mem['email']; ?></option>
															<?php
															endforeach;
															?>
														</select>
														<?php displayErrorMsg('membre', $errors); ?>
													</div>


													<div class="form-group <?php displayErrorClass('annonce', $errors); ?>">
														<label class="control-label">annonce</label>
														<select class="form-control" name="annonce1">

															<option value="">Choisissez...</option>
															<?php
															foreach ($annonces as $annonce) :
																//echo $annonce;
																$selected = ($annonce['id_annonce'] == $annonce1)
																	? 'selected'
																	: ''
																;
															?>

																<option value="<?= $annonce['id_annonce']; ?>" <?= $selected; ?>><?= $annonce['titre']; ?></option>
															<?php
															endforeach;
															?>
														</select>
														<?php displayErrorMsg('annonce1', $errors); ?>
													</div>

										<div class="form-group <?php displayErrorClass('commentaire', $errors); ?>">
														<label class="control-label">commentaire</label>
														<input class="form-control" type="text" name="commentaire" value="<?= $commentaire; ?>">
														<?php displayErrorMsg('commentaire', $errors); ?>
													</div>

													<div class="pull-right">
														<button type="submit" class="btn btn-primary">Valider</button>
													</div>
												</form>

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
