
            <?php
              include '../include/init.php';
							adminSecurity();
							$query = 'SELECT * FROM categorie ORDER BY id_categorie';
							$stmt = $pdo->query($query);
							$categories = $stmt->fetchAll();
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
                            Categorie Liste
												</h2>
												<?php displayFlashMessage(); ?>
												<p class="text-center">
													<a href="categorie-edit.php">Ajouter une catégorie</a>
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
														<th>id_categorie</th>
														<th>Titre</th>
														<th>Mots cles</th>
														<th>Actions</th>
													</tr>
													<?php
													foreach ($categories as $categorie) :
													?>
														<tr>
															<td><?= $categorie['id_categorie']; ?></td>
															<td><?= $categorie['titre']; ?></td>
															<td><?= $categorie['motscles']; ?></td>
															<td>
                                <a class="btn btn-success" href="categorie-edit.php?id_categorie=<?= $categorie['id_categorie']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-danger" href="categorie-delete.php?id_categorie=<?= $categorie['id_categorie']; ?>"><span  class="glyphicon glyphicon-trash"></span></a>
															</td>
														</tr>
													<?php
													endforeach;
													?>
												</table>

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
