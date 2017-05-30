<?php

function dump($var)
{
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

function sanitizeValue(&$value)
{
	$value = trim(strip_tags($value));
	// trim() supprime les espaces en d�but et fin de cha�ne
	// strip_tags() supprime le balisage de la cha�ne
}

function sanitizeArray(array &$array)
{
	// array_walk parcours le tableau et applique la fonction pass�e en 2e param�tre � chaque �l�ment du tableau
	array_walk($array, 'sanitizeValue');
	/* m�me chose avec une fonction anonyme :
	array_walk($array, function(&$value){
		trim(strip_tags($value))
	});
	*/
}

function sanitizePost()
{
	sanitizeArray($_POST);
}

function displayErrorClass($nomChamp, array $errors)
{
	if (isset($errors[$nomChamp])) {
		echo ' has-error';
	}
}

function displayErrorMsg($nomChamp, array $errors)
{
	if (isset($errors[$nomChamp])) {
		echo '<span class="help-block">' . $errors[$nomChamp] . '</span>';
	}
}

function isUserConnected()
{
	return isset($_SESSION['membre']);
}

function getUserFullName()
{
	if (isUserConnected()) {
		return $_SESSION['membre']['prenom'] . ' ' . $_SESSION['membre']['nom'];
	}

	return '';
}


function getMemberPseudo($id_membre)
{
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	];

	$pdo = new PDO('mysql:host=localhost;dbname=annonceo', 'root', '', $options);

	$query = "SELECT pseudo FROM membre WHERE id_membre = ".$id_membre;

	$stmt = $pdo->query($query);
	$membre_pseudo = $stmt->fetch();
	echo  $membre_pseudo['pseudo'];


	}





function isUserAdmin()
{
		return isUserConnected() && $_SESSION['membre']['statut'] == 1;
}

function adminSecurity()
{
	if (!isUserAdmin()) {
		if (isUserConnected()) {
			header('Location: ' . RACINE_WEB . 'index.php');
		} else {
			header('Location: ' . RACINE_WEB . 'connexion.php');
		}

		die;
	}
}

function setFlashMessage($message, $type = 'success')
{
	$_SESSION['flashMessage'] = [
		'message' => $message,
		'type' => $type,
	];
}

function displayFlashMessage()
{
	if (isset($_SESSION['flashMessage'])) {
		$type = $_SESSION['flashMessage']['type'] == 'error'
			? 'danger' // class alert-danger du bootstrap
			: $_SESSION['flashMessage']['type']
		;

		$alert = '<div class="alert alert-' . $type . '" role="alert">'
			. '<strong>' . $_SESSION['flashMessage']['message'] . '</strong>'
			. '</div>'
		;

		echo $alert;

		// suppression du message de la session pour affichage "one shot"
		unset($_SESSION['flashMessage']);
	}
}

function ajouterPanier(array $produit, $quantite)
{
	// on crée le panier s'il n'existe pas
	if(!isset($_SESSION['panier'])){
		$_SESSION['panier'] = [];
	}
//on ajoute le produit au panier
	if(!isset($_SESSION['panier'][$produit['id']]))
	{
		$_SESSION['panier'][$produit['id']] = [
			'nom' => $produit['nom'],
			'prix' => $produit['prix'],
			'quantite' => $quantite,
		];
	}else { // ou on augmente la qté s'il y est déja
		$_SESSION['panier'][$produit['id']]['quantite'] += $quantite;


			}
}

function formatEuro($prix)
{
	return number_format($prix,2,',',' '). '€';
}


function getTotalPanier()
{
	$total = 0;
	if(!empty($_SESSION['panier'])){
		foreach ($_SESSION['panier'] as $produit) {
			$total += $produit['prix'] * $produit['quantite'];
		}
	}
	return $total;
}


function modifierQuantitePanier($idProduit,$quantite){
	if(!empty($_SESSION['panier'])){
		if($quantite == 0){
			unset($_SESSION['panier'][$idProduit]);
		}else{
			$_SESSION['panier'][$idProduit]['quantite'] = $quantite;
		}
	}

}
