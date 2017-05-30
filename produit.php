<?php
include 'include/init.php';

$query = 'SELECT * FROM produit WHERE id = ' . (int)$_GET['id'];
$stmt = $pdo->query($query);
$produit = $stmt->fetch();

if (empty($produit)) {
	header('Location: index.php');
	die;
}

if (!empty($_POST)) {
	ajouterPanier($produit, $_POST['quantite']);
	setFlashMessage('Le produit est ajouté au panier');
}

include 'layout/top.php';
displayFlashMessage();
?>

<h1><?= $produit['nom']; ?></h1>

<div class="row">
	<div class="col-md-3 text-center">
		<?php
		if (!empty($produit['photo'])) :
		?>
			<p>
				<img src="<?= PHOTO_WEB . $produit['photo']; ?>" style="width:100%">
			</p>
		<?php
		endif;
		?>
		<p>
			<?= number_format($produit['prix'], 2, ',', ' ') . '€'; ?>
		</p>
		<form class="form-inline" method="post">
			<label>Qté</label>
			<select class="form-control" name="quantite">
				<?php
					for ($i = 1; $i <= 10; $i++) {
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
				?>
			</select>
			<button type="submit" class="btn btn-primary">Ajouter au panier</button>
		</form>
	</div>
	<div class="col-md-9">
		<p><?= nl2br($produit['description']); ?></p>
	</div>
</div>
<?php
include 'layout/bottom.php';
?>