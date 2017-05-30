<?php
include '../include/init.php';
//adminSecurity();

	// suppression du categorie
	$query = 'DELETE FROM membre WHERE id_membre = ' . (int)$_GET['id_membre'];

	$pdo->exec($query);

setFlashMessage('Le membre est supprimé');
header('Location: membres.php');
die;
