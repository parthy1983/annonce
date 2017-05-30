jQuery(document).ready(function()
{
  $('select[name="categorieAjax"]').on('change', function ()
  {
		alert('cou');

      //alert( "Handler for .click() called." );
      var categorie_id = jQuery(this).val();

            console.log(categorie_id);

            jQuery.ajax({
                url: '/annonceo/ajax.php',
                method: 'POST',
                data: {
                  categorie_id: categorie_id

                },
                dataType: 'json',
                error: function(request, error){
                  console.log(error);
                  console.log(request);
                },
                success: function(data, status, jqXHR){
                  console.log(data);
                  var texte = '';

                  for(i = 0; i < data.length; i++){
                texte += '<p><b>' + data['id_annonce'] + data['photo'] + data['description_courte']+'</b></p>';
              }
              jQuery('#display').html(texte);


                }

          });
    });

});
