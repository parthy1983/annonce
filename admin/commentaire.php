
            <?php
              include '../include/init.php';
							adminSecurity();
              // pagination
              $nbProduitsParPage = 2;

              $query = 'SELECT COUNT(*) FROM commentaire';
              $stmt = $pdo->query($query);
              $nbAnnonces = $stmt->fetchColumn(); // nb total de produits

              $nbPages = ceil($nbAnnonces / $nbProduitsParPage);
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $limit = $nbProduitsParPage;
              $offset = ($page - 1) * $nbProduitsParPage;





							$query = 'select c.*,a.id_annonce,a.titre,m.id_membre,m.email
                        from commentaire c, annonce a , membre m
                        where c.annonce_id= a.id_annonce
                        and c.membre_id = m.id_membre'
                        . ' LIMIT ' . $limit
                        . ' OFFSET ' . $offset;


							$stmt = $pdo->query($query);
							$commentaires = $stmt->fetchAll();
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
                            commentaire Liste
												</h2>
												<?php displayFlashMessage(); ?>
												<p class="text-center">
													<a href="commentaire-edit.php">Ajouter une commentaire</a>
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
														<th>id commentaire</th>
														<th>Id - membre</th>
														<th>Id - annonce </th>
                            <th>commentaire</th>
                            <th>date_enregistrement</th>
														<th>Actions</th>
													</tr>
													<?php
													foreach ($commentaires as $commentaire) :
													?>
														<tr>
															<td><?= $commentaire['id_commentaire']; ?></td>
															<td><?= $commentaire['membre_id']; ?> - <?= $commentaire['email']; ?></td>
                              <td><?= $commentaire['id_annonce']; ?> - <?= $commentaire['titre']; ?></td>
															<td><?= $commentaire['commentaire']; ?></td>
                              <td><?= $commentaire['date_enregistrement']; ?></td>
															<td>
                                <a class="btn btn-success" href="commentaire-edit.php?id_commentaire=<?= $commentaire['id_commentaire']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-danger" href="commentaire-delete.php?id_commentaire=<?= $commentaire['id_commentaire']; ?>"><span  class="glyphicon glyphicon-trash"></span></a>
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
