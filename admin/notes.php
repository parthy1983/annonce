
            <?php
              include '../include/init.php';
							adminSecurity();
              // pagination
              $nbProduitsParPage = 2;

              $query = 'SELECT COUNT(*) FROM note';
              $stmt = $pdo->query($query);
              $nbAnnonces = $stmt->fetchColumn(); // nb total de produits

              $nbPages = ceil($nbAnnonces / $nbProduitsParPage);
              $page = isset($_GET['page']) ? $_GET['page'] : 1;
              $limit = $nbProduitsParPage;
              $offset = ($page - 1) * $nbProduitsParPage;





						$query = 'select n.*,m.*
                        from note n, membre m
                        where n.membre_id1= m.id_membre '
                        . ' LIMIT ' . $limit
                        . ' OFFSET ' . $offset;

							$stmt_note = $pdo->query($query);
							$notes = $stmt_note->fetchAll();
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
                            Notes Liste
												</h2>
												<?php displayFlashMessage(); ?>
												<p class="text-center">
													<a href="note-edit.php">Ajouter une notes</a>
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
														<th>id note</th>
														<th>Id - membre1</th>
														<th>Id - membre2 </th>
                            <th>note</th>
                            <th>Avis</th>
                            <th>date_enregistrement</th>
														<th>Actions</th>
													</tr>
													<?php
													foreach ($notes as $note) :
													?>
														<tr>
															<td><?= $note['id_note']; ?></td>
															<td><?= $note['membre_id1']; ?> - <?= $note['email']; ?></td>
                              <td><?= $note['membre_id2']; ?> - <?= $note['email']; ?></td>
															<td><?= $note['note']; ?></td>
                              <td><?= $note['avis']; ?></td>
                              <td><?= $note['date_enregistrement']; ?></td>
															<td>
                                <a class="btn btn-success" href="note-edit.php?id_commentaire=<?= $note['id_note']; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                <a class="btn btn-danger" href="note-delete.php?id_commentaire=<?= $note['id_note']; ?>"><span  class="glyphicon glyphicon-trash"></span></a>
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
