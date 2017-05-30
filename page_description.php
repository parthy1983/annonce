
<?php
include 'include/init.php';
// pagination
if(isset($_GET['id_annonce'])) {
	  $query = 'SELECT a.*, m.*
 FROM annonce a, membre m
 WHERE id_annonce = '  .(int)$_GET['id_annonce']
 . '	AND a.membre_id = m.id_membre'
 ;
	$stmt = $pdo->query($query);
	$annonce = $stmt->fetch();
}
include 'layout/top.php';
?>

<div class="row col-md-12">
	<div class="row col-md-12">
		<div class="row col-md-6"><h3><?= $annonce['titre']; ?></h2>
		</div>
		<div class="row col-md-6 text-right">

			<button type="submit" data-toggle="modal" data-target="#vendeurContact" name="submit_vender" class="btn btn-success"><?= $annonce['pseudo']; ?></button>
		</div>

	</div>
	<div class="row">

			<div class="col-md-6 text-center" >
					<a href="#"><?php
							if (!empty($annonce['photo'])) :
							?>
							<img src="<?= PHOTO_WEB . $annonce['photo']; ?>" width="350px" height="350px" >
							<?php
							else :
								echo '-';
							endif;
							?>
					</a>
		</div>
		<div class="col-md-6"><p><?= $annonce['description_longue'];?></p></div>
	</div>
	<br>
					<div class="row">
							<div class="col-md-3"><b>Date : <?= $annonce['date_enregistrement'];  ?></b></div>

							<div class="col-md-3"><b><?= $annonce['pseudo'];  ?> :</b>


								 <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small></div>
							<div class="col-md-3"><b>Prix : <?= number_format($annonce['prix'], 2, ',', ' ') . '€'; ?></b></div>
							<div class="col-md-3"><b>Address :<?= $annonce['adresse'];  ?> </b></div>
					</div>
					<br>
					<!-- google map -->
					<div class="row">
					<iframe class="col-md-12" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2619.0411496226516!2d2.03558601606787!3d48.971741079298695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e68b97eaec02cb%3A0xb549bc0d40d6ca69!2s4+Rue+des+Quertaines%2C+78570+Chanteloup-les-Vignes!5e0!3m2!1sen!2sfr!4v1493044990345"

						frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
					<br>
						<!-- autres annnones -->
			<?php  	$query_autre_4 = 'SELECT * FROM annonce where categorie_id = '.$annonce['categorie_id'].' and id_annonce <> '. (int)$_GET['id_annonce'].' limit 4';

						$stmt_autre_4 = $pdo->query($query_autre_4);
						$annonce4 = $stmt_autre_4->fetchAll();
?>
<div class="row">
	<a class="navbar-brand">Autres Annonces</a>

</div>
					<div class="row well">
						<?php foreach ($annonce4 as $annonce_4): ?>
								<div class="col-md-3">
															<a href="page_description.php?id_annonce=<?= $annonce_4['id_annonce'];?>"><?php
											if (!empty($annonce_4['photo'])) :
											?>
											<img src="<?= PHOTO_WEB . $annonce_4['photo']; ?>" width="200px" height="125px" class="picture" >
											<?php
											else :
												echo '-';
											endif;
											?>
									</a>
								</div>

						<?php endforeach; ?>
					</div>

					<div class="row col-md-12">
					<nav class="navbar navbar-default">
						<div class="container">
							<ul class="nav navbar-nav">
								<li><a href="" data-toggle="modal" data-target="#myModal">Déposer un commentaire ou une note</a></li>
								<li><a href=""><span class="text-right">Retour vers les annonces</span></a></li>

							</ul>
						</div>
					</nav>
					</div>



					<!-- Vendeur contact form -->
							<div class="container">
								<!-- Modal -->
								<div class="modal fade" id="vendeurContact" role="dialog">
									<div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
											<form class="" action="contactMail.php" method="post">
												<div class="modal-header">


														<div class="row col-md-6">
																<label class="control-label">
																<p>Contact par mail  à : <?= $annonce['pseudo']; ?></p>
																</label>
														</div>
																<div class="row col-md-6">
																	<label class="control-label">
																	<p>Cordonnes : <?= $annonce['telephone']; ?></p>
																	</label>

													</div>
												<button type="button" class="close" data-dismiss="modal">&times;</button>

												</div>
												<div class="modal-body" >

													<div class="form-group">
													<input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
												</div>

												<div class="form-group">
													<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" required>
												</div>
												<div class="form-group">
													<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
												</div>
												<div class="form-group">
												<textarea class="form-control" type="textarea" name="message" placeholder="Message" rows="7"></textarea>
												<br>
												<button type="submit" name="mail" class="btn btn-success" value="submit" >Envoyer</button>
												<input type="hidden" name="email" value="<?= $annonce['email'] ?>">

												</div>


												</div>
											</form>



								</div>
							</div>
						</div>
					</div>








<!-- light box commentaire ou notes -->
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
				<form class="" action="rating_process.php" method="post">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title">Commentaire et notes</h2>
					</div>
					<div class="modal-body">
								<div class="form-group">
									<label class="control-label">Notes</label>
									<select name="star" class="form-control">

												  <option value="1"><span class="glyphicon glyphicon-star">stars-1</span></option>
												  <option value="2"><span class="glyphicon glyphicon-star">stars-2</span></option>
												  <option value="3"><span class="glyphicon glyphicon-star">stars-3</span></option>
												  <option value="4"><span class="glyphicon glyphicon-star">stars-4</span></option>
													<option value="5"><span class="glyphicon glyphicon-star">stars-5</span></option>
								</select>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star"></span>
									<span class="glyphicon glyphicon-star"></span>


								</div>

								<div class="form-group">
									<label class="control-label">Avis</label>
									<textarea class="form-control" name="avis"></textarea>
								</div>
								<div class="form-group">
									<label class="control-label">commentaire</label>
									<textarea class="form-control" name="commentaire"></textarea>
								</div>
	        </div>
	        <div class="modal-footer">
						<button type="submit" name="submit" class="btn btn-success" value="submit">Envoyer</button>
						<input type="hidden" name="membre_id1" value="<?= $_SESSION['membre']['id_membre'] ?>">
						<input type="hidden" name="membre_id2" value="<?= $annonce['membre_id'];  ?>">
						<input type="hidden" name="annonce_id" value="<?= $_GET['id_annonce'] ?>">
	          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	        </div>

				</form>


      </div>
  </div>
</div>


<?php
include 'layout/bottom.php';
?>
