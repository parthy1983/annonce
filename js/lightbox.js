
jQuery(document).ready(function(){

jQuery('#login_button').click(function(){
  console.log("keyup");
  var email = jQuery('input[name="email"]').val();
  var mdp = jQuery('input[name="mdp"]').val();
  console.log(email);
  console.log(mdp);
  if ((email)&&(mdp)) {

    jQuery.ajax({
      url: '/annonceo/conn_ajax.php',
      method: 'POST',
      data: {
        email: email,
        mdp: mdp
      },
      dataType: 'json',
      error: function(request, error){
        console.log(error);
        console.log(request);
      },
      success: function(data, status, jqXHR){
        console.log(data);
        //alert(data);
        var message = '';
        var message = data;
        alert(message);

        if(message > 0){
          console.log('redirecyion');
          window.location = "/annonceo/index.php";
        }else if (message < 1) {
            console.log('error');
          message = "usernom et mod de pass sont ne pas correcte";
          jQuery('#display').html(message);
        }


      }

    });
  };


});

});
