
$(function() {
   var url = 'http://localhost/profileit/home/valida/';

   var clickme = $('#validar');
   var listUsers = $('.list-users');

   clickme.on('click', function(){
     alert('cick');
      $.ajax({
         url: url, //caminho do arquivo servidor
         type: 'post',                                   //formato de envio
         dataType: 'json'
      }).done(function( user ){
         alert( users );
      });
      return false;
   });

   $("#js-ajax-php-json").submit(function(e){
      alert('teste return');

      e.preventDefault();

      if ($('#enviar').val() == 'Enviando...') {
         return (false);
      }

      $('#enviar').val('Enviando...');

      $.ajax({
         url: 'http://localhost/profileit/home/return/', //caminho do arquivo servidor
         type: 'post',                                   //formato de envio
         dataType: 'json',                               //tipo de dado que sera retornado
         //Dados enviados para o servidor
         data: {
            'metodo' : $('#metodo').val(),
            'bebida' : $('#vinho').val(),
            'local' : $('#restaurante').val(),
            'sexo' : $('#sexo').val()
         }

      }).done(function(data){
         alert(data);
         $('#enviar').val('Enviar');
         $('#metodo').val('');
         $('#vinho').val('');
         $('#restaurante').val('');
         $('#sexo').val('');
      });

   });


   $("#js-ajax-php-jsonbkp").submit(function(e){
      alert('teste return');

      e.preventDefault();

      if ($('#enviar').val() == 'Enviando...') {
         return (false);
      }

      $('#enviar').val('Enviando...');

      $.ajax({
         url: 'http://localhost/profileit/home/return/', //caminho do arquivo servidor
         type: 'post',                                   //formato de envio
         dataType: 'html',                               //tipo de dado que sera retornado
         //Dados enviados para o servidor
         data: {
            'metodo' : $('#metodo').val(),
            'bebida' : $('#vinho').val(),
            'local' : $('#restaurante').val(),
            'sexo' : $('#sexo').val()
         }

      }).done(function(data){
         alert(data);
         $('#enviar').val('Enviar');
         $('#metodo').val('');
         $('#vinho').val('');
         $('#restaurante').val('');
         $('#sexo').val('');
      });

   });

});
