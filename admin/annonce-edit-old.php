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
$titre = $description_courte = $description_longue = $prix = $photoActuelle = $pays = $ville = $adresse = $cp = $membre = $categorie = $photoActuelle2 = $photoActuelle3 = $photoActuelle4 = $photoActuelle5 = '';
print_r($_POST);
if (!empty($_POST)) {
	sanitizePost();
	extract($_POST);

	// remplace la virgule par un point
	$prix = str_replace(',', '.', $prix);

	if (empty($titre)) {
		$errors['titre'] = 'Le nom est obligatoire';
	}

	if (empty($description_courte)) {
		$errors['description_courte'] = 'La description Courte est obligatoire';
	}

	if (empty($description_longue)) {
		$errors['description_longue'] = 'La description Longue est obligatoire';
	}

	if (empty($prix)) {
		$errors['prix'] = 'Le prix est obligatoire';
	} elseif (!is_numeric($prix)) {
		$errors['prix'] = 'Le prix doit être une valeur numérique';
	}

	// si il y a un fichier téléchargé photo 1
	if (!empty($_FILES['photo']['tmp_name'])) {
		if ($_FILES['photo']['size'] > 1000000) {
			$errors['photo1'] = 'La photo1 ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

		if (!in_array($_FILES['photo']['type'], $allowedMimeTypes)) {
			$errors['photo1'] = 'La photo1 doit être une image JPG, GIF ou PNG';
		}
	}


	// si il y a un fichier téléchargé photo 2
	if (!empty($_FILES['photo2']['tmp_name'])) {
		if ($_FILES['photo2']['size'] > 1000000) {
			$errors['photo2'] = 'La photo2 ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

		if (!in_array($_FILES['photo2']['type'], $allowedMimeTypes)) {
			$errors['photo2'] = 'La photo2 doit être une image JPG, GIF ou PNG';
		}
	}




	// si il y a un fichier téléchargé photo 3
	if (!empty($_FILES['photo3']['tmp_name'])) {
		if ($_FILES['photo3']['size'] > 1000000) {
			$errors['photo3'] = 'La photo3 ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

		if (!in_array($_FILES['photo3']['type'], $allowedMimeTypes)) {
			$errors['photo3'] = 'La photo3 doit être une image JPG, GIF ou PNG';
		}
	}


	// si il y a un fichier téléchargé photo 4
	if (!empty($_FILES['photo4']['tmp_name'])) {
		if ($_FILES['photo4']['size'] > 1000000) {
			$errors['photo4'] = 'La photo4 ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

		if (!in_array($_FILES['photo4']['type'], $allowedMimeTypes)) {
			$errors['photo4'] = 'La photo4 doit être une image JPG, GIF ou PNG';
		}
	}


	// si il y a un fichier téléchargé photo 4
	if (!empty($_FILES['photo5']['tmp_name'])) {
		if ($_FILES['photo5']['size'] > 1000000) {
			$errors['photo5'] = 'La photo5 ne doit pas faire plus de 1Mo';
		}

		$allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];

		if (!in_array($_FILES['photo5']['type'], $allowedMimeTypes)) {
			$errors['photo5'] = 'La photo5 doit être une image JPG, GIF ou PNG';
		}
	}






	if (empty($pays)) {
		$errors['pays'] = 'Le pays est obligatoire';
	}

	if (empty($adresse)) {
		$errors['adresse'] = "L'adress est obligatoire";
	}




	if (empty($errors)) {
		//echo "photo";
		if (!empty($_FILES['photo']['tmp_name'])) {
			$nomPhoto = uniqid() . '_' . $_FILES['photo']['name'];
			move_uploaded_file($_FILES['photo']['tmp_name'], PHOTO_SITE . $nomPhoto);

			// on supprime l'ancienne photo si une nouvelle est uploadée
			if (!empty($photoActuelle)) {
				unlink(PHOTO_SITE . $photoActuelle);
			}
		} else {
			echo $nomPhoto = $photoActuelle;
		}


// photo 2
if (!empty($_FILES['photo2']['tmp_name'])) {
	$nomPhoto2 = uniqid() . '_' . $_FILES['photo2']['name'];
	move_uploaded_file($_FILES['photo2']['tmp_name'], PHOTO_SITE . $nomPhoto2);

	// on supprime l'ancienne photo2 si une nouvelle est uploadée
	if (!empty($photoActuelle2)) {
		unlink(PHOTO_SITE . $photoActuelle2);
	}
} else {
	 $nomPhoto2 = $photoActuelle2;
}


// photo 3
if (!empty($_FILES['photo3']['tmp_name'])) {
	$nomPhoto3 = uniqid() . '_' . $_FILES['photo3']['name'];
	move_uploaded_file($_FILES['photo3']['tmp_name'], PHOTO_SITE . $nomPhoto3);

	// on supprime l'ancienne photo2 si une nouvelle est uploadée
	if (!empty($photoActuelle3)) {
		unlink(PHOTO_SITE . $photoActuelle3);
	}
} else {
	 $nomPhoto3 = $photoActuelle3;
}


// photo 4
if (!empty($_FILES['photo4']['tmp_name'])) {
	$nomPhoto4 = uniqid() . '_' . $_FILES['photo4']['name'];
	move_uploaded_file($_FILES['photo4']['tmp_name'], PHOTO_SITE . $nomPhoto4);

	// on supprime l'ancienne photo2 si une nouvelle est uploadée
	if (!empty($photoActuelle4)) {
		unlink(PHOTO_SITE . $photoActuelle4);
	}
} else {
	 $nomPhoto4 = $photoActuelle4;
}


// photo 5
if (!empty($_FILES['photo5']['tmp_name'])) {
	$nomPhoto5 = uniqid() . '_' . $_FILES['photo5']['name'];
	move_uploaded_file($_FILES['photo5']['tmp_name'], PHOTO_SITE . $nomPhoto5);

	// on supprime l'ancienne photo2 si une nouvelle est uploadée
	if (!empty($photoActuelle5)) {
		unlink(PHOTO_SITE . $photoActuelle5);
	}
} else {
	 $nomPhoto5 = $photoActuelle5;
}

		if (isset($_GET['id_annonce'])) {
			echo $query = 'UPDATE annonce SET'
				. ' titre = :titre,'
				. ' description_courte = :description_courte,'
				. ' description_longue = :description_longue,'
				. ' prix = :prix,'
				. ' photo = :photo,'
				. ' pays = :pays,'
				. ' ville = :ville,'
				. ' adresse = :adresse,'
				. ' cp = :cp,'
				. ' categorie_id = :categorie_id,'
				. ' membre_id = :membre_id'
 				.' WHERE id_annonce = :id_annonce'
			;
///////////////////////////////////// modification des photos
			if (isset($_GET['photo_id'])) {


			echo	$query = 'UPDATE photo SET'
					. ' photo1 = :photo,'
					. ' photo2 = :photo2,'
					. ' photo3 = :photo3,'
					. ' photo4 = :photo4,'
					. ' photo5 = :photo5,'
					.' WHERE id_photo = :id_photo'
				;

				$stmt_update_image = $pdo->prepare($query);

				// photo 1
				if (!empty($nomPhoto)) {
					$stmt_update_image->bindParam(':photo', $nomPhoto, PDO::PARAM_STR);
					//echo "if";
				} else {
					$stmt_update_image->bindValue(':photo', null, PDO::PARAM_NULL);
					//echo "else";
				}

				// photo 2
				if (!empty($nomPhoto2)) {
					$stmt_update_image->bindParam(':photo2', $nomPhoto2, PDO::PARAM_STR);
					//echo "if";
				} else {
					$stmt_update_image->bindValue(':photo2', null, PDO::PARAM_NULL);
					//echo "else";
				}

				// photo 3
				if (!empty($nomPhoto3)) {
					$stmt_update_image->bindParam(':photo3', $nomPhoto3, PDO::PARAM_STR);
					//echo "if";
				} else {
					$stmt_update_image->bindValue(':photo3', null, PDO::PARAM_NULL);
					//echo "else";
				}


				// photo 4
				if (!empty($nomPhoto4)) {
					$stmt_update_image->bindParam(':photo4', $nomPhoto4, PDO::PARAM_STR);
					//echo "if";
				} else {
					$stmt_update_image->bindValue(':photo4', null, PDO::PARAM_NULL);
					//echo "else";
				}


				// photo 5
				if (!empty($nomPhoto5)) {
					$stmt_update_image->bindParam(':photo5', $nomPhoto5, PDO::PARAM_STR);
					//echo "if";
				} else {
					$stmt_update_image->bindValue(':photo5', null, PDO::PARAM_NULL);
					//echo "else";
				}

				if ($stmt_update_image->execute()) { // execution de modification des images
						} else {
					$errors['bdd'] = 'Une erreur est survenue photo-updation';
				}

			}	///////////////////////////////////////////////////////////// image updation fin




			$message = 'Le annonce est modifié';
		} else {

			echo $query = 'INSERT INTO photo(photo1, photo2, photo3, photo4, photo5)
			VALUES (:photo, :photo2, :photo3, :photo4, :photo5)';

			$stmtPhoto = $pdo->prepare($query);

			// photo 1
			if (!empty($nomPhoto)) {
				$stmtPhoto->bindParam(':photo', $nomPhoto, PDO::PARAM_STR);
				//echo "if";
			} else {
				$stmtPhoto->bindValue(':photo', null, PDO::PARAM_NULL);
				//echo "else";
			}

			// photo 2
			if (!empty($nomPhoto2)) {
				$stmtPhoto->bindParam(':photo2', $nomPhoto2, PDO::PARAM_STR);
				//echo "if";
			} else {
				$stmtPhoto->bindValue(':photo2', null, PDO::PARAM_NULL);
				//echo "else";
			}

			// photo 3
			if (!empty($nomPhoto3)) {
				$stmtPhoto->bindParam(':photo3', $nomPhoto3, PDO::PARAM_STR);
				//echo "if";
			} else {
				$stmtPhoto->bindValue(':photo3', null, PDO::PARAM_NULL);
				//echo "else";
			}


			// photo 4
			if (!empty($nomPhoto4)) {
				$stmtPhoto->bindParam(':photo4', $nomPhoto4, PDO::PARAM_STR);
				//echo "if";
			} else {
				$stmtPhoto->bindValue(':photo4', null, PDO::PARAM_NULL);
				//echo "else";
			}


			// photo 5
			if (!empty($nomPhoto5)) {
				$stmtPhoto->bindParam(':photo5', $nomPhoto5, PDO::PARAM_STR);
				//echo "if";
			} else {
				$stmtPhoto->bindValue(':photo5', null, PDO::PARAM_NULL);
				//echo "else";
			}

			if (isset($_GET['id_annonce'])) {
				$stmt->bindParam(':id_annonce', $_GET['id_annonce'], PDO::PARAM_INT);
			}

			if ($stmtPhoto->execute()) {
						$last_id_photo = $pdo->lastInsertId();
					} else {
				$errors['bdd'] = 'Une erreur est survenue photo';
			}

//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: seconde insertion annonce
			echo $query = 'INSERT INTO annonce(titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, date_enregistrement,categorie_id,membre_id,photo_id)
			VALUES (:titre, :description_courte, :description_longue, :prix, :photo,:pays, :ville, :adresse, :cp, now(), :categorie_id,:membre_id,:photo_id)';

			//,membre_id , :membre_id

			$message = 'Le annonce est créé';
		}

		$stmt = $pdo->prepare($query);

		$stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
		$stmt->bindParam(':description_courte', $description_courte, PDO::PARAM_STR);
		$stmt->bindParam(':description_longue', $description_longue, PDO::PARAM_INT);
		$stmt->bindParam(':prix', $prix, PDO::PARAM_STR);
		$stmt->bindParam(':pays', $pays, PDO::PARAM_STR);
		$stmt->bindParam(':ville', $ville, PDO::PARAM_STR);
		$stmt->bindParam(':adresse', $adresse, PDO::PARAM_INT);
		$stmt->bindParam(':cp', $cp, PDO::PARAM_STR);
	//	$stmt->bindParam(':membre_id', $nom, PDO::PARAM_STR);
		$stmt->bindParam(':photo_id', $last_id_photo, PDO::PARAM_INT);
		$stmt->bindParam(':categorie_id', $categorie, PDO::PARAM_INT);
		$stmt->bindParam(':membre_id', $_SESSION['membre']['id_membre'], PDO::PARAM_STR);



		if (!empty($nomPhoto)) {
			$stmt->bindParam(':photo', $nomPhoto, PDO::PARAM_STR);
			//echo "if";
		} else {
			$stmt->bindValue(':photo', null, PDO::PARAM_NULL);
			//echo "else";
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
//include 'include/adminTop.php';
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
															Annonce
                        </h2>
												<p class="text-center">

													<a href="annonce-edit.php"><?php if (isset($_GET['id_membre'])) {echo 'Modification';} else {echo 'Nouvelle';}?> annonce</a>
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

												<form method="post" enctype="multipart/form-data">
													<div class="form-group <?php displayErrorClass('titre', $errors); ?>">
														<label class="control-label">titre</label>
														<input class="form-control" type="text" name="titre" value="<?= $titre; ?>">
														<?php displayErrorMsg('titre', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('description_courte', $errors); ?>">
														<label class="control-label">Description Courte</label>
														<textarea class="form-control" name="description_courte"><?= $description_courte; ?></textarea>
														<?php displayErrorMsg('description_courte', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('description_longue', $errors); ?>">
														<label class="control-label">Description Longue</label>
														<textarea class="form-control" name="description_longue"><?= $description_longue; ?></textarea>
														<?php displayErrorMsg('description_longue', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('prix', $errors); ?>">
														<label class="control-label">Prix</label>
														<input class="form-control" type="text" name="prix" value="<?= $prix; ?>">
														<?php displayErrorMsg('prix', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('photo', $errors); ?>">
														<label class="control-label">Photo1</label>
														<input type="file" name="photo">
														<?php displayErrorMsg('photo', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('photo2', $errors); ?>">
														<label class="control-label">Photo2</label>
														<input type="file" name="photo2">
														<?php displayErrorMsg('photo2', $errors); ?>
													</div>


													<div class="form-group <?php displayErrorClass('photo3', $errors); ?>">
														<label class="control-label">photo3</label>
														<input type="file" name="photo3">
														<?php displayErrorMsg('photo3', $errors); ?>
													</div>


													<div class="form-group <?php displayErrorClass('photo4', $errors); ?>">
														<label class="control-label">Photo4</label>
														<input type="file" name="photo4">
														<?php displayErrorMsg('photo4', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('photo5', $errors); ?>">
														<label class="control-label">Photo5</label>
														<input type="file" name="photo5">
														<?php displayErrorMsg('photo5', $errors); ?>
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

													<div class="form-group <?php displayErrorClass('adresse', $errors); ?>">
														<label class="control-label">adresse</label>
														<textarea class="form-control" name="adresse"><?= $adresse; ?></textarea>
														<?php displayErrorMsg('adresse', $errors); ?>
													</div>

													<div class="form-group <?php displayErrorClass('cp', $errors); ?>">
														<label class="control-label">Cp</label>
														<input class="form-control" type="text" name="cp" value="<?= $cp; ?>">
														<?php displayErrorMsg('cp', $errors); ?>
													</div>



														<div class="form-group <?php displayErrorClass('categorie', $errors); ?>">
															<label class="control-label">categorie</label>
															<select class="form-control" name="categorie">
																<option value="">Choisissez...</option>
																<?php
																foreach ($categories as $cat) :
																	$selected = ($cat['id_categorie'] == $categorie)
																		? 'selected'
																		: ''
																	;
																?>
																	<option value="<?= $cat['id_categorie']; ?>" <?= $selected; ?>><?= $cat['titre']; ?></option>
																<?php
																endforeach;
																?>
															</select>
															<?php displayErrorMsg('categorie', $errors); ?>
														</div>




													<?php
													// selectioner des photes
													if(isset($_GET['id_annonce']))
													{
													$query = 'SELECT a.*, p.*'
														. ' FROM annonce a'
														. ' JOIN photo p ON p.id_photo = a.photo_id '
														. 'WHERE a.id_annonce = '.$_GET['id_annonce'];

														$stmt_photo_disp = $pdo->query($query);
														$display_photos = $stmt_photo_disp->fetch();
															?>
															<div class="row well">
																	<div class="col-md-2">
																		<?php
																if (!empty($display_photos["photo1"])) :
																	echo '<p><img src="' . PHOTO_WEB . $display_photos["photo1"] . '" height="150px"></p>';
																endif;
																?>
																<input type="hidden" name="photoActuelle" value="<?= $display_photos["photo1"]; ?>">
																	</div>

																	<div class="col-md-2">
																		<?php
																		if (!empty($display_photos["photo2"])) :
																			echo '<p><img src="' . PHOTO_WEB . $display_photos["photo2"] . '" height="150px"></p>';
																		endif;
																		?>
																		<input type="hidden" name="photoActuelle2" value="<?= $display_photos["photo2"]; ?>">
																	</div>

																	<div class="col-md-2">
																		<?php
																		if (!empty($display_photos["photo3"])) :
																			echo '<p><img src="' . PHOTO_WEB . $display_photos["photo3"] . '" height="150px"></p>';
																		endif;
																		?>
																		<input type="hidden" name="photoActuelle3" value="<?= $display_photos["photo3"]; ?>">

																	</div>


																	<div class="col-md-2">
																		<?php
																		if (!empty($display_photos["photo4"])) :
																			echo '<p><img src="' . PHOTO_WEB . $display_photos["photo4"] . '" height="150px"></p>';
																		endif;
																		?>
																		<input type="hidden" name="photoActuelle4" value="<?= $display_photos["photo4"]; ?>">
																	</div>

																	<div class="col-md-2">
																		<?php
																		if (!empty($display_photos["photo5"])) :
																			echo '<p><img src="' . PHOTO_WEB . $display_photos["photo5"] . '" height="150px"></p>';
																		endif;
																		?>
																		<input type="hidden" name="photoActuelle5" value="<?= $display_photos["photo5"]; ?>">

																	</div>

															</div>
											<?php
											}
													 ?>



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
