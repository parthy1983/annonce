<?php
include '../include/init.php';
adminSecurity();

// pagination
$nbProduitsParPage = 2;

$query = 'SELECT COUNT(*) FROM annonce';
$stmt = $pdo->query($query);
$nbAnnonces = $stmt->fetchColumn(); // nb total de produits

$nbPages = ceil($nbAnnonces / $nbProduitsParPage);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = $nbProduitsParPage;
$offset = ($page - 1) * $nbProduitsParPage;

$query = 'SELECT a.*, p.*'
	. ' FROM annonce a'
	. ' JOIN photo p ON p.id_photo = a.photo_id'
	. ' ORDER BY date_enregistrement'
	. ' LIMIT ' . $limit
	. ' OFFSET ' . $offset
;
$stmt = $pdo->query($query);
$annonces = $stmt->fetchAll();

include '../layout/top.php';

displayFlashMessage();
?>
<h1>Annonces</h1>

<p class="text-center">
	<a href="annonce-edit.php">Ajouter un annonce</a>
</p>

<table class="table table-striped">
	<tr>
		<th>Id</th>
		<th>Titre</th>
		<th>Description Courte</th>
		<th>Description longue</th>
		<th>Prix</th>
		<th>Photo</th>
		<th>Pays</th>
		<th>Ville</th>
		<th>Adresse</th>
		<th>CP</th>
		<th>Membre</th>
		<th>Categorie</th>
		<th>Date_enregistrement</th>
		<th>Actions</th>
	</tr>
	<?php
	foreach ($annonces as $annonce) :
	?>
		<tr>
			<td><?= $annonce['id']; ?></td>
			<td><?= $annonce['nom']; ?></td>
			<td><?= nl2br($annonce['description']); ?></td>
			<td><?= $annonce['nom_categorie']; ?></td>
			<td><?= number_format($annonce['prix'], 2, ',', ' ') . '€'; ?></td>
			<td align="center">
			<?php
			if (!empty($annonce['photo'])) :
			?>
				<img src="<?= PHOTO_WEB . $annonce['photo']; ?>" height="50px">
			<?php
			else :
				echo '-';
			endif;
			?>
			</td>
			<td>
				<a class="btn btn-primary" href="annonce-edit.php?id_annonce=<?= $produit['id_annonce']; ?>">Modifier</a>
				<a class="btn btn-danger" href="annonce-delete.php?id_annonce=<?= $produit['id_annonce']; ?>">Supprimer</a>
			</td>
		</tr>
	<?php
	endforeach;
	?>
</table>

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
<?php
include '../layout/bottom.php';
?>
