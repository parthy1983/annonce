<?php
include 'include/init.php';
adminSecurity();

include 'layout/top.php';
?>
<div id="page-wrapper">

		<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
						<div class="col-lg-12">
								<h2 class="page-header">
											Categorie
								</h2>
								<p class="text-center">

									<a href="ajax-cat-edit.php">Ajax - Categorie Ajouter
								</p>
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

								<form method="post" id="myForm">
									<div class="form-group ">
										<label class="control-label">Article</label>
										<input class="form-control" type="text" name="article" value="">

									</div>
									<div class="form-group ">
										<label class="control-label">Contenu</label>
										<input class="form-control" type="text" name="contenu" value="">

									</div>



									<div class="pull-right">
										<button type="submit" name="submit" id="submit" class="btn btn-primary">Valider</button>
									</div>
								</form>

						</div>
				</div>

				<!-- /.row -->

				<!-- /.row -->

		</div>
		<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->











<?php
include 'layout/bottom.php';
?>
<script>
jQuery(document).ready(function(){

	$( "#myForm" ).submit(function( event )
	{
			var formValid = true;
			event.preventDefault();


			var article = jQuery('input[name="article"]').val();
			var contenu = jQuery('input[name="contenu"]').val();
				console.log(article);
				console.log(contenu);
			if((article === '') || (contenu === '')){
				alert('article et contenu  sont obligatoire !!');
				formValid = false;

				}


			if(formValid === true){
				console.log(formValid);
				jQuery.ajax({
						url: '/anonnceo/ajax-cat-edit.php',
						method: 'POST',
						data: {
							article: article,
							contenu: contenu
						},
						dataType: 'json',
						error: function(request, error){
							console.log(error);
							console.log(request);
						},
						success: function(data, status, jqXHR){

							var message = data;
							var titre = jQuery('input[name="titre"]').val('');
							var cles = jQuery('input[name="cles"]').val('');
							jQuery('#display').html(message);

						}

			});

		}

});


});
</script>
