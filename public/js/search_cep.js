window.onload = function () {
  $(document).ready(function () {
    'use strict';

      // pular campos, mais simplificado, dá para usar também, mas o de baixo tá funcionando...
      /*                $('#tabela').on('keyup', 'input', function(event) {
                          if (event.which == 13) {
                              var generico = $("#tabela").find('input:visible');
                              var indice = generico.index(event.target) + 1;
                              var seletor = $(generico[indice]).focus();

                              if (seletor.length == 0) {
                                  event.target.focus();
                              }
                          }
                      });*/
    // Método para pular campos teclando ENTER
    $('.pulacampos').on('keypress', function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);

      if (tecla == 13) {
        campo = $('.pulacampos');
        indice = campo.index(this);

        if (campo[indice + 1] != null) {
          proximo = campo[indice + 1];
          proximo.focus();
          e.preventDefault(e);
          return false; // impede o envio do formulario
        }
      }
    });
    // Método para consultar o CEP
    $('#zipcode').on('blur', function() {
      if ($.trim($("#zipcode").val()) != "") {

        $("#infocep").html('Aguarde, estamos consultando seu CEP ...');
        $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep=" + $("#zipcode").val(), function() {
          if (resultadoCEP["resultado"]) {
            $("#address").val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
            $("#burgh").val(unescape(resultadoCEP["bairro"]));
            $("#city").val(unescape(resultadoCEP["cidade"]));
            $("#state").val(unescape(resultadoCEP["uf"]));
          }
          $("#infocep").html('');
        });
      }
    })

  });
}; //window.onload