<?php
include '../include/init.php';
adminSecurity();

	// suppression du categorie
	$query = 'DELETE FROM commentaire WHERE id_commentaire = ' . (int)$_GET['id_commentaire'];

	$pdo->exec($query);

setFlashMessage('Le commentaire est supprimé');
header('Location: commentaire.php');
die;
