<?php
include 'include/init.php';

if (isset($_POST['modifier-quantite'])) {
	//dump($_POST);
	modifierQuantitePanier($_POST['id-produit'], $_POST['quantite']);
}

include 'layout/top.php';
?>
<h1>Panier</h1>
<?php
if (!empty($_SESSION['panier'])) :
?>
	<table class="table">
		<tr>
			<th>Nom produit</th>
			<th>Prix unitaire</th>
			<th>Quantité</th>
			<th>Total produit</th>
		</tr>
		<?php
		foreach ($_SESSION['panier'] as $idProduit => $produit) :
		?>
			<tr>
				<td><?= $produit['nom']; ?></td>
				<td><?= formatEuro($produit['prix']); ?></td>
				<td>
					<form method="post" class="form-inline">
						<select name="quantite" class="form-control">
						<?php
						for ($i = 0; $i <= 10; $i++) {
							$selected = $i == $produit['quantite'] ? 'selected' : '';
							echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
						}
						?>
						</select>
						<input type="hidden" name="id-produit" value="<?= $idProduit; ?>">
						<button type="submit" name="modifier-quantite" class="btn btn-primary">Modifier</button>
					</form>
				</td>
				<td>
					<?= formatEuro($produit['prix'] * $produit['quantite']); ?>
				</td>
			</tr>
		<?php
		endforeach;
		?>
		<tr>
			<th colspan="3">Total</th>
			<td><?= formatEuro(getTotalPanier()); ?></td>
		</tr>
	</table>

<?php
else :
	echo '<p>Votre panier est vide</p>';
endif;

include 'layout/bottom.php';
?>
