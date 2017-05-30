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
$titre = $cles = '';

if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	if (empty($cles)) {
		$errors['cles'] = 'Les motscles des categories sont obligatoire';
	}

	if (empty($titre)) {
		$errors['titre'] = 'Le titre categorie est obligatoire';
	} elseif (strlen($titre) > 50) {
		$errors['titre'] = 'Le titre categorie ne doit pas faire plus de 50 caractères';
	} else {
		$query = 'SELECT COUNT(*) FROM categorie WHERE titre = ' . $pdo->quote($titre);

		if (isset($_GET['id_categorie'])) {
			$query .= ' AND id_categorie != ' . $_GET['id_categorie'];
		}

		$stmt = $pdo->query($query);

		$nbCategories = $stmt->fetchColumn();

		if ($nbCategories != 0) {
			$errors['titre'] = 'Cette catégorie existe déjà';
		}
	}

	if (empty($errors)) {
		if (isset($_GET['id_categorie'])) {
			$query = 'UPDATE categorie SET titre = :titre , motscles = :cles  WHERE id_categorie = :id_categorie';
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
			$stmt->bindParam(':cles', $cles, PDO::PARAM_STR);
			$stmt->bindParam(':id_categorie', $_GET['id_categorie'], PDO::PARAM_INT);
		} else {
			$query = 'INSERT INTO categorie(titre,motscles) VALUES (:titre,:cles)';
			$stmt = $pdo->prepare($query);
			$stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
			$stmt->bindParam(':cles', $cles, PDO::PARAM_STR);
		}

		if ($stmt->execute()) {
			echo "exec";
			$message = isset($_GET['id_categorie'])
				? 'La catégorie a bien été modifiée'
				: 'La catégorie a bien été créée'
			;
			setFlashMessage($message);
			header('Location: categories.php');
			die;
		} else {
			$errors['bdd'] = 'Une erreur est survenue';
		}
	}
} elseif (isset($_GET['id_categorie'])) {
	// si on a reçu un id dans l'url, on est en modification
	// on va chercher la catégorie en bdd
	$query = 'SELECT * FROM categorie WHERE id_categorie = ' . $_GET['id_categorie'];
	$stmt = $pdo->query($query);
	$categorie = $stmt->fetch();

	if (empty($categorie)) {
		// redirection si l'id ne correspond à aucune catégorie
		setFlashMessage($message);
		header('Location: categories.php');
		die;
	}

	$titre = $categorie['titre'];
	$cles = $categorie['motscles'];
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
															Categorie
                        </h2>
												<p class="text-center">

													<a href="categorie-edit.php"><?php if (isset($_GET['id_categorie'])) {echo 'Modification';} else {echo 'Nouvelle';}?> catégorie</a>
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
													<div class="form-group <?php displayErrorClass('titre', $errors); ?>">
														<label class="control-label">Titre</label>
														<input class="form-control" type="text" name="titre" value="<?= $titre; ?>">
														<?php displayErrorMsg('titre', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('cles', $errors); ?>">
														<label class="control-label">Mots cles</label>
														<input class="form-control" type="text" name="cles" value="<?= $cles; ?>">
														<?php displayErrorMsg('cles', $errors); ?>
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
