<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Annonceo</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


		<style>
			.navbar-inverse {		margin-bottom:0;
			}
		</style>


	</head>
		<body>

			<div id="loginModal" class="modal fade" role="dialog">
			      <div class="modal-dialog">
			   <!-- Modal content-->
			           <div class="modal-content">
									 			   <div class="modal-header">
			                     <button type="button" class="close" data-dismiss="modal">&times;</button>
			                     <h4 class="modal-title">Login</h4>
													 <div id="display">

													 </div>
			                </div>
			                <div class="modal-body">
			                     <label>Username</label>
			                     <input type="text" name="email" id="email" class="form-control" />
			                     <br />
			                     <label>Password</label>
			                     <input type="password" name="mdp" id="mdp" class="form-control" />
			                     <br />
			                     <button type="button" name="login_button" id="login_button" class="btn btn-warning">Login</button>
			                </div>
			           </div>
			      </div>
			 </div>


		<?php
		if (isUserAdmin()) :
		?>
			<nav class="navbar navbar-inverse">
				<div class="container">
					<a class="navbar-brand">Admin</a>
					<ul class="nav navbar-nav">
						<li><a href="<?= RACINE_WEB; ?>admin/annonces.php">Gestion Annonces</a></li>
						<li><a href="<?= RACINE_WEB; ?>admin/categories.php">Gestion Categories</a></li>
						<li><a href="<?= RACINE_WEB; ?>admin/membres.php">Gestion Membres</a></li>
						<li><a href="<?= RACINE_WEB; ?>admin/commentaire.php">Gestion Commentaire</a></li>
						<li><a href="<?= RACINE_WEB; ?>admin/notes.php">Gestion Notes</a></li>

					</ul>
				</div>
			</nav>
		<?php
		endif;
		?>
		<nav class="navbar navbar-default">
			<div class="container">
				<a class="navbar-brand" href="<?= RACINE_WEB; ?>index.php">Annonceo</a>
				<ul class="nav navbar-nav">
					<li><a href="<?= RACINE_WEB; ?>index.php">Qui Sommes Nous</a></li>
					<li><a href="<?= RACINE_WEB; ?>index.php">Contact</a></li>
					<li><a><input type="text" class="form-control" placeholder="Recherche...."></a></li>
					<li></li>
				</ul>


				<ul class="nav navbar-nav navbar-right">
				<?php
				if (isUserConnected()) :
				?>
					<li><a><?= getUserFullName(); ?></a></li>
					<li><a href="<?= RACINE_WEB; ?>deconnexion.php">Déconnexion</a></li>
				<?php
				else :
				?>
					<li><a href="<?= RACINE_WEB; ?>inscription.php">Inscription</a></li>
					<li><a data-toggle="modal" data-target="#loginModal">Connexion</a></li>
				<?php
				endif;
				?>

				</ul>
			</div>
		</nav>
		<div class="container">
