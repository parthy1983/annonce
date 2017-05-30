<?php
include '../include/init.php';
adminSecurity();

if (isset($_GET['id'])) {
	// suppression de la photo, s'il y a
	$query = 'SELECT photo FROM produit WHERE id = ' . (int)$_GET['id'];
	$stmt = $pdo->query($query);
	$photo = $stmt->fetchColumn();
	
	if (!empty($photo)) {
		unlink(PHOTO_SITE . $photo);
	}
	
	// suppression du produit
	$query = 'DELETE FROM produit WHERE id = ' . (int)$_GET['id'];
	
	$pdo->exec($query);
	
	setFlashMessage('Le produit est supprimé');
}

header('Location: produits.php');
die;