<?php
include '../include/init.php';
adminSecurity();

$errors = [];
$titre = $descriptionCourte = $descriptionLongue = $prix = $photoActuelle = $pays = $ville = $adress = $cp = $membre = $categorie = '';

if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	// remplace la virgule par un point
	$prix = str_replace(',', '.', $prix);

	if (empty($titre)) {
		$errors['titre'] = 'Le nom est obligatoire';
	}

	if (empty($descriptionCourte)) {
		$errors['descriptionCourte'] = 'La description Courte est obligatoire';
	}

	if (empty($descriptionLongue)) {
		$errors['descriptionLongue'] = 'La description Longue est obligatoire';
	}

	if (empty($prix)) {
		$errors['prix'] = 'Le prix est obligatoire';
	} elseif (!is_numeric($prix)) {
		$errors['prix'] = 'Le prix doit être une valeur numérique';
	}

	// si il y a un fichier téléchargé
	if (!empty($_FILES['photo']['tmp_name'])) {
		if ($_FILES['photo']['size'] > 1000000) {
			$errors['photo'] = 'La photo ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

		if (!in_array($_FILES['photo']['type'], $allowedMimeTypes)) {
			$errors['photo'] = 'La photo doit être une image JPG, GIF ou PNG';
		}
	}


	if (empty($pays)) {
		$errors['pays'] = 'Le pays est obligatoire';
	}

	if (empty($adress)) {
		$errors['adress'] = "L'adress est obligatoire";
	}




	if (empty($errors)) {
		if (!empty($_FILES['photo']['tmp_name'])) {
			$nomPhoto = uniqid() . '_' . $_FILES['photo']['name'];
			move_uploaded_file($_FILES['photo']['tmp_name'], PHOTO_SITE . $nomPhoto);

			// on supprime l'ancienne photo si une nouvelle est uploadée
			if (!empty($photoActuelle)) {
				unlink(PHOTO_SITE . $photoActuelle);
			}
		} else {
			$nomPhoto = $photoActuelle;
		}

		if (isset($_GET['id_annonce'])) {
			$query = 'UPDATE annonce SET'
				. ' titre = :titre,'
				. ' description_courte = :descriptionCourte,'
				. ' description_longue = :descriptionLongue,'
				. ' prix = :prix,'
				. ' photo = :photo,'
				. ' pays = :pays,'
				. ' ville = :ville,'
				. ' adresse = :adresse,'
				. ' cp = :cp,'
				. ' categorie_id = :categorie_id'
 				.' WHERE id_annonce = :id_annonce'
			;

			$message = 'Le annonce est modifié';
		} else {
			$query = 'INSERT INTO annonce(titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, date_enregistrement,membre_id,categorie_id)
			VALUES (:titre, :description_courte, :description_longue, :prix, :photo,:pays, :ville, :adresse, :cp, now(), :membre_id, :categorie_id)';

			$message = 'Le annonce est créé';
		}

		$stmt = $pdo->prepare($query);

		$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
		$stmt->bindParam(':description_courte', $description, PDO::PARAM_STR);
		$stmt->bindParam(':description_longue', $categorie, PDO::PARAM_INT);
		$stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
		$stmt->bindParam(':pays', $nom, PDO::PARAM_STR);
		$stmt->bindParam(':ville', $description, PDO::PARAM_STR);
		$stmt->bindParam(':adresse', $categorie, PDO::PARAM_INT);
		$stmt->bindParam(':cp', $prix, PDO::PARAM_STR);
		$stmt->bindParam(':membre_id', $nom, PDO::PARAM_STR);
		$stmt->bindParam(':categorie_id', $categorie, PDO::PARAM_INT);



		if (!empty($nomPhoto)) {
			$stmt->bindParam(':photo', $nomPhoto, PDO::PARAM_STR);
		} else {
			$stmt->bindValue(':photo', null, PDO::PARAM_NULL);
		}

		if (isset($_GET['id_annonce'])) {
			$stmt->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_INT);
		}

		if ($stmt->execute()) {
			setFlashMessage($message);

			header('Location: annonces.php');
			die;
		} else {
			$errors['bdd'] = 'Une erreur est survenue';
		}
	}
} elseif (isset($_GET['id_annonce'])) {
	$query = 'SELECT * FROM annonce WHERE id_annonce = ' . (int)$_GET['id_annonce'];
	$stmt = $pdo->query($query);
	$annonce = $stmt->fetch();

	if (empty($annonce)) {
		header('Location: annonces.php');
		die;
	}

	extract($annonce);
	$categorie = $annonce['categorie_id'];
	$photoActuelle = $annonce['photo'];
}

// requête pour remplir le select des catégories
$query = 'SELECT * FROM categorie ORDER BY titre';
$stmt = $pdo->query($query);
$categories = $stmt->fetchAll();

include '../layout/top.php';

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
<h1>Edition Produit</h1>

<form method="post" enctype="multipart/form-data">
	<div class="form-group <?php displayErrorClass('titre', $errors); ?>">
		<label class="control-label">titre</label>
		<input class="form-control" type="text" name="titre" value="<?= $titre; ?>">
		<?php displayErrorMsg('titre', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('descriptionCourte', $errors); ?>">
		<label class="control-label">Description Courte</label>
		<textarea class="form-control" name="descriptionCourte"><?= $descriptionCourte; ?></textarea>
		<?php displayErrorMsg('descriptionCourte', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('descriptionLongue', $errors); ?>">
		<label class="control-label">Description Longue</label>
		<textarea class="form-control" name="descriptionCourte"><?= $descriptionLongue; ?></textarea>
		<?php displayErrorMsg('descriptionLongue', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('prix', $errors); ?>">
		<label class="control-label">Prix</label>
		<input class="form-control" type="text" name="prix" value="<?= $prix; ?>">
		<?php displayErrorMsg('prix', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('photo', $errors); ?>">
		<label class="control-label">Photo</label>
		<input type="file" name="photo">
		<?php displayErrorMsg('photo', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('pays', $errors); ?>">
		<label class="control-label">Pays</label>
		<input class="form-control" type="text" name="pays" value="<?= $pays; ?>">
		<?php displayErrorMsg('pays', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('ville', $errors); ?>">
		<label class="control-label">Ville</label>
		<input class="form-control" type="text" name="ville" value="<?= $ville; ?>">
		<?php displayErrorMsg('ville', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('adress', $errors); ?>">
		<label class="control-label">Adress</label>
		<textarea class="form-control" name="adress"><?= $adress; ?></textarea>
		<?php displayErrorMsg('adress', $errors); ?>
	</div>

	<div class="form-group <?php displayErrorClass('cp', $errors); ?>">
		<label class="control-label">Cp</label>
		<input class="form-control" type="text" name="cp" value="<?= $cp; ?>">
		<?php displayErrorMsg('cp', $errors); ?>
	</div>


		<div class="form-group <?php displayErrorClass('membre', $errors); ?>">
			<label class="control-label">membre</label>
			<input class="form-control" type="text" name="membre" value="<?= $membre; ?>">
			<?php displayErrorMsg('membre', $errors); ?>
		</div>


		<div class="form-group <?php displayErrorClass('membre', $errors); ?>">
			<label class="control-label">Membre</label>
			<select class="form-control" name="membre">
				<option value="">Choisissez...</option>
				<?php
				foreach ($categories as $cat) :
					$selected = ($cat['id'] == $categorie)
						? 'selected'
						: ''
					;
				?>
					<option value="<?= $cat['id_annonce']; ?>" <?= $selected; ?>><?= $cat['titre']; ?></option>
				<?php
				endforeach;
				?>
			</select>
			<?php displayErrorMsg('membre', $errors); ?>
		</div>




	<?php
	if (!empty($photoActuelle)) :
		echo '<p>Actuellement : <img src="' . PHOTO_WEB . $photoActuelle . '" height="150px"></p>';
	endif;
	?>
	<input type="hidden" name="photoActuelle" value="<?= $photoActuelle; ?>">
	<div class="pull-right">
		<button type="submit" class="btn btn-primary">Valider</button>
	</div>
</form>

<?php
include '../layout/bottom.php';
?>
