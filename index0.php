<?php
include 'include/init.php';
// pagination
$nbProduitsParPage = 3;

$query = 'SELECT COUNT(*) FROM annonce ORDER BY date_enregistrement desc';
$stmt = $pdo->query($query);
$nbAnnonces = $stmt->fetchColumn(); // nb total de produits

$nbPages = ceil($nbAnnonces / $nbProduitsParPage);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = $nbProduitsParPage;
$offset = ($page - 1) * $nbProduitsParPage;

 $query = 'SELECT * FROM annonce ORDER BY date_enregistrement desc'
	. ' LIMIT ' . $limit
	. ' OFFSET ' . $offset
	;
$stmt = $pdo->query($query);
$annonces = $stmt->fetchAll();


include 'layout/top.php';
?>

<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
		<?php  // pour categorie
		$query_categorie = 'SELECT * FROM categorie ORDER BY id_categorie';
		$stmt_categorie = $pdo->query($query_categorie);
		$categories = $stmt_categorie->fetchAll();
		 ?>

				<label for="categorie">Catégorie</label>
							<select class="form-control" name="categorieAjax" id="categorieAjax">
								<option>Toules les categories</option>
								<?php
								foreach ($categories as $cat) :
								?>
									<option value="<?= $cat['id_categorie']; ?>" ><?= $cat['titre']; ?></option>
								<?php
								endforeach;
								?>
							</select>
							<br>
							<?php  // pour ville
							$query_annonce = 'SELECT * FROM annonce ORDER BY ville';
							$stmt_annonce = $pdo->query($query_annonce);
							$villes = $stmt_annonce->fetchAll();
							 ?>

				<label for="categorie">Ville</label>
									<select class="form-control" name="ville">
										<option>Toules les villes</option>
										<?php
										foreach ($villes as $ville) :
										?>
											<option value="<?= $ville['id_annonce']; ?>" ><?= $ville['ville']; ?></option>
										<?php
										endforeach;
										?>
									</select>
							<br>

							<?php // pour membre
							$query_membre = 'SELECT * FROM membre ORDER BY id_membre';
							$stmt_membre = $pdo->query($query_membre);
							$membres = $stmt_membre->fetchAll();
							 ?>

				<label for="categorie">Membre</label>
							<select class="form-control" name="membre">
								<option>Tous les membres</option>
								<?php
								foreach ($membres as $membre) :
								?>
									<option value="<?= $membre['id_membre']; ?>" ><?= $membre['pseudo']; ?></option>
								<?php
								endforeach;
								?>
							</select>
				<label for="categorie">Prix</label>


    </div>
  </div>

	<div class="col-md-8 mb-4">
			<select class="form-control" name="trier">
				<option>Trier par prix (du moins cher au plus cher)</option>
				<option>Trier par prix (du plus cher au moins cher )</option>
				<option>Trier par date (de la plus ancienne a la plus récente)</option>
				<option>Trier par date (de la plus récenté a la plus ancienne)</option>
			</select>
			<br>


		<?php
		foreach ($annonces as $annonce) :
		?>
		<div class="">

		</div>
		<div class="card h-100 thumbnail" id="display">

			<a href="page_description.php?id_annonce=<?= $annonce['id_annonce'];?>">
			<?php
			if (!empty($annonce['photo'])) :
			?>
			<img src="<?= PHOTO_WEB . $annonce['photo']; ?>" width="125px" height="125px" >
			<?php
			else :
				echo '-';
			endif;
			?>
		</a>
		<div class="card-block">
				<h4 class="card-title text-center"><a href="#"><?= nl2br($annonce['titre']); ?></a></h4>
				<h5 class="text-center"><?= number_format($annonce['prix'], 2, ',', ' ') . '€'; ?></h5>
				<p class="card-text"><?= nl2br($annonce['description_courte']); ?></p>
		</div>
		<div class="card-footer text-center">
				<small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
		</div>
		</div>
			<?php
				endforeach;
				?>


	<nav class="text-center" aria-label="Page navigation">
		<ul class="pagination">
			<li>
				<a href="?page=1" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
		<?php
		for ($i = 1; $i <= $nbPages; $i++) :
		?>
			<li><a href="?page=<?= $i; ?>"><?= $i; ?></a></li>
		<?php
		endfor;
		?>
			<li>
				<a href="?page=<?= $nbPages; ?>" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>



</div>




</div>




<?php
include 'layout/bottom.php';
?>
