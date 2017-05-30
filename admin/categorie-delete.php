<?php
include '../include/init.php';
adminSecurity();

	// suppression du categorie
	$query = 'DELETE FROM categorie WHERE id_categorie = ' . (int)$_GET['id_categorie'];

	$pdo->exec($query);

setFlashMessage('Le categorie est supprimé');
header('Location: categories.php');
die;
