
            <?php
              include '../include/init.php';
							//adminSecurity();
							$query = 'SELECT * FROM membre ORDER BY id_membre';
							$stmt = $pdo->query($query);
							$membres = $stmt->fetchAll();
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
                            membres Listes
												</h2>
												<?php displayFlashMessage(); ?>
												<p class="text-center">
													<a href="membre-edit.php">Ajouter une membre</a>
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
														<th>id membre</th>
														<th>pseudo</th>
														<th>nom</th>
														<th>prenom</th>
                            <th>email</th>
														<th>Telephone</th>
														<th>civilite</th>
														<th>statut</th>
                            <th>date_enregistrement</th>
														<th>actions</th>
													</tr>
													<?php
													foreach ($membres as $membre) :
													?>
														<tr>
															<td><?= $membre['id_membre']; ?></td>
															<td><?= $membre['pseudo']; ?></td>
															<td><?= $membre['nom']; ?></td>
                              <td><?= $membre['prenom']; ?></td>
                              <td><?= $membre['telephone']; ?></td>
                              <td><?= $membre['email']; ?></td>
                              <td><?= $membre['civilite'];?></td>
                              <td><?= $membre['statut']; ?></td>
                              <td><?= $membre['date_enregistrement']; ?></td>

															<td>
                                <a class="btn btn-success" href="membre-edit.php?id_membre=<?= $membre['id_membre']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-danger" href="membre-delete.php?id_membre=<?= $membre['id_membre']; ?>"><span  class="glyphicon glyphicon-trash"></span></a>
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
