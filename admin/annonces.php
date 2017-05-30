
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

						$query = 'SELECT * FROM annonce'
							. ' LIMIT ' . $limit
							. ' OFFSET ' . $offset
						;
						$stmt = $pdo->query($query);
						$annonces = $stmt->fetchAll();

             include 'include/adminTop.php';  ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include 'include/sideMenubar.php';  ?>
            <!-- /.navbar-collapse -->

        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
                            Annonces Liste
												</h2>
												<?php displayFlashMessage(); ?>
												<p class="text-center">
													<a href="annonce-edit.php">Ajouter un annonce</a>
													<?php
													if (!empty($errors)) :
													?>
														<div class="alert alert-danger" role="alert">
															<strong>
															<?= (isset($errors['bdd']))
																? $errors['bdd']
																: 'Le formulaire contient des erreurs';
															?>
															</strong>
														</div>
													<?php
													endif;
													?>
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
															<td><?= $annonce['id_annonce']; ?></td>
															<td><?= nl2br($annonce['titre']); ?></td>
															<td><?= nl2br($annonce['description_courte']); ?></td>
															<td><?= nl2br($annonce['description_longue']); ?></td>
															<td><?= number_format($annonce['prix'], 2, ',', ' ') . '€'; ?></td>
															<td align="center">
															<?php
															if (!empty($annonce['photo'])) :
															?>
																<img src="<?= PHOTO_WEB . $annonce['photo']; ?>"  height="100px">
															<?php
															else :
																echo '-';
															endif;
															?>
															</td>
															<td><?= nl2br($annonce['pays']); ?></td>
															<td><?= nl2br($annonce['ville']); ?></td>
															<td><?= nl2br($annonce['adresse']); ?></td>
															<td><?= $annonce['cp']; ?></td>
															<td><?= nl2br($annonce['membre_id']); ?></td>
															<td><?= nl2br($annonce['categorie_id']); ?></td>
															<td><?= $annonce['date_enregistrement']; ?></td>

															<td>
																<a class="btn btn-success" href="annonce-edit.php?id_annonce=<?= $annonce['id_annonce']; ?>&photo_id=<?= $annonce['photo_id']; ?>"><span class="glyphicon glyphicon-pencil"></a>
																<a class="btn btn-danger" href="annonce-delete.php?id_annonce=<?= $annonce['id_annonce']; ?>"><span  class="glyphicon glyphicon-trash"></span></a>
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

                    </div>
                </div>

                <!-- /.row -->

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php
 include 'include/adminTop.php';
 ?>
