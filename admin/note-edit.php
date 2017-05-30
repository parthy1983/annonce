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
$commentaire = $membre = $annonce = $avis = '';

if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	if (empty($membre1)) {
		$errors['membre1'] = 'Le membr1 est obligatoire';
	}

	if (empty($membre2)) {
		$errors['membre2'] = 'membre2 est obligatoire';
	}

	if (empty($note)) {
		$errors['note'] = "note est obligatoire";
	}


	if (empty($avis)) {
		$errors['avis'] = "Avis est obligatoire";
	}


	if (empty($errors)) {
		if (isset($_GET['	id_note'])) {
			$query = 'UPDATE note SET membre_id1 = :membre_id1 , membre_id2 = :membre_id2, note = :note, avis = :avis  WHERE 	id_note = :id_note';
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':membre_id1', $membre1, PDO::PARAM_INT);
			$stmt->bindParam(':membre_id2', $membre2, PDO::PARAM_INT);
			$stmt->bindParam(':note', $note, PDO::PARAM_INT);
			$stmt->bindParam(':avis', $avis, PDO::PARAM_STR);
			$stmt->bindParam(':id_note', $_GET['id_note'], PDO::PARAM_INT);
		} else {
		echo 	$query = 'INSERT INTO note(membre_id1,membre_id2,note,avis,date_enregistrement) VALUES (:membre_id,:membre_id2,:note,avis,now())';
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':membre_id1', $membre1, PDO::PARAM_INT);
			$stmt->bindParam(':membre_id2', $membre2, PDO::PARAM_INT);
			$stmt->bindParam(':note', $note, PDO::PARAM_INT);
			$stmt->bindParam(':avis', $avis, PDO::PARAM_STR);
		}

		if ($stmt->execute()) {
			//echo "exec";
			$message = isset($_GET['id_note'])
				? 'La note a bien été modifiée'
				: 'La note a bien été créée'
			;
			setFlashMessage($message);
			header('Location: notes.php');
			die;
		} else {
			$errors['bdd'] = 'Une erreur est survenue';
		}
	}
} elseif (isset($_GET['id_note'])) {
	// si on a reçu un id dans l'url, on est en modification
	// on va chercher la catégorie en bdd
	$query = 'SELECT * FROM note WHERE id_note = ' . $_GET['id_note'];
	$stmt = $pdo->query($query);
	$note = $stmt->fetch();

	if (empty($note)) {
		// redirection si l'id ne correspond à aucune catégorie
		setFlashMessage($message);
		header('Location: notes.php');
		die;
	}

	extract($note);
	$membre1 = $note['membre_id1'];
	$membre2 = $note['membre_id2'];
	//$photoActuelle = $annonce['photo'];
	//$commentaire = $commentaire['commentaire'];
}


// requête pour remplir le select des membres
$query = 'SELECT * FROM membre ORDER BY id_membre';
$stmt = $pdo->query($query);
$membres = $stmt->fetchAll();


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
															Note
                        </h2>
												<p class="text-center">

													<a href="commentaire-edit.php"><?php if (isset($_GET['id_commentaire'])) {echo 'Modification';} else {echo 'Nouvelle';}?> note</a>
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

													<div class="form-group <?php displayErrorClass('membre1', $errors); ?>">
														<label class="control-label">membre 1</label>
														<select class="form-control" name="membre1">
															<option value="">Choisissez...</option>
															<?php
															foreach ($membres as $mem) :
																$selected = ($mem['id_membre'] == $membre1)
																	? 'selected'
																	: ''
																;
															?>
																<option value="<?= $mem['id_membre']; ?>" <?= $selected; ?>><?= $mem['email']; ?></option>
															<?php
															endforeach;
															?>
														</select>
														<?php displayErrorMsg('membre1', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('membre2', $errors); ?>">
														<label class="control-label">membre 2</label>
														<select class="form-control" name="membre2">
															<option value="">Choisissez...</option>
															<?php
															foreach ($membres as $mem) :
																$selected = ($mem['id_membre'] == $membre2)
																	? 'selected'
																	: ''
																;
															?>
																<option value="<?= $mem['id_membre']; ?>" <?= $selected; ?>><?= $mem['email']; ?></option>
															<?php
															endforeach;
															?>
														</select>
														<?php displayErrorMsg('membre2', $errors); ?>
													</div>


													<div class="form-group <?php displayErrorClass('note', $errors); ?>">
														<label class="control-label">Note</label>
														<select class="form-control" name="note">
															<option value="">Choisissez...</option>
															<option value="1">star 1</option>
															<option value="2">star 2</option>
															<option value="3">star 3</option>
															<option value="4">star 4</option>
															<option value="5">star 5</option>
														</select>
														<?php displayErrorMsg('note', $errors); ?>
													</div>



										<div class="form-group <?php displayErrorClass('avis', $errors); ?>">
														<label class="control-label">Avis</label>
														<input class="form-control" type="text" name="avis" value="<?= $avis; ?>">
														<?php displayErrorMsg('avis', $errors); ?>
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
