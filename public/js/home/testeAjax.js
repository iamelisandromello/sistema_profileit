
$(function() {
   var url = 'http://localhost/profileit/home/valida/';
   var clickme = $('#returnProfile');
   var analista;

   //Função de Reset Respostas do Questionário
   window.clean = function(nome) {
      triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', Vamos Analisar outra Vaga?', 'Você pode optar por usar os modelos definidos (Junior, Pleno ou Sênior)!!');
   };

   window.msgSuccess = function(data, nome) {
      if (data){
         document.getElementById("quiz-form").submit();
         triggerNotify('purple', 'bubbles', 'Ohhhh Show ' + nome + ',  Perfil Completo', 'Você Precisa Completar esta Etapa para Criar seu Perfil!!');
      }
      else{
         window.clean(nome);
      }
   }

   window.confirmOpportunity = function($perfil, $nome) {
      if ($perfil == 1) {
         analista = 'Junior';
      }
      else if ($perfil == 2) {
         analista = 'Pleno';
      } else if ($perfil == 3) {
         analista = 'Sênior';
      }
      profileConfirm('cool',$nome,';) Ohhhhh ' + $nome + ', O perfil selecionado corresponde a uma Analista ' + analista + '. Deseja Confirmar?', ';) Confirmar', ':( Desistir', msgSuccess);
   };

   clickme.on('click', function() {
      $.ajax({
         url: url, //caminho do arquivo servidor
         type: 'post', //formato de envio
         dataType: 'json', //formato de Retorno
         data: {  //Dados enviados para o servidor
            'atributo_1'   : $('#requerimentoIngles').val(),
            'atributo_2'   : $('#requerimentoExperiencia').val(),
            'atributo_3'   : $('#requerimentoCertificacao').val(),
            'atributo_4'   : $('#requerimentoFormacao').val(),
            'atributo_5'   : $('#requerimentoStatusF').val(),
            'atributo_6'   : $('#requerimentoPos').val(),
            'atributo_7'   : $('#requerimentoStatusP').val(),
            'atributo_8'   : $('#requerimentoDominio').val(),
            'atributo_9'   : $('#requerimentoExchange').val(),
            'atributo_10'  : $('#requerimentoVirtualizacao').val(),
            'atributo_11'  : $('#requerimentoRoteadores').val(),
            'atributo_12'  : $('#requerimentoItil').val(),
            'atributo_13'  : $('#requerimentoAgile').val(),
            'atributo_14'  : $('#requerimentoProjetos').val(),
            'atributo_15'  : $('#requerimentoHabilitacao').val()
         }
      }).done(function( response ){
            var desvio  = response.desvio;
            var perfil  = response.perfil;
            var nome    = response.nome;
            confirmOpportunity(perfil, nome);
      }).fail(function(jqXHR, textStatus ) {
            console.log("Requisição ao servidor falhou: " + textStatus);
      }).always(function() {
            console.log("completou o Processamento");
      });
      return false;
   });
});
