$(function() {
   var url = 'http://localhost/profileit/home/valida/';
   var clickme = $('#returnProfile');
   var analista;
   var msgInvalida;
   var temp;
   var status;

   /*
   * Oculta as Mensagens de Front End após período programado
   * $idFieldset: recebe como parametro o ID do FieldSet de contexto
   * Busca div "msgFront" e oculta mensagem
   */
   function offMessage ($idFieldset) {
      setTimeout(function(){
         $('#' + $idFieldset).find('div [name="msgFront"]').each(function() {
            $(this).hide();
         });
      } , 5000);
   }

   //Função de Reset Respostas do Questionário
   window.clean = function(nome) {
      triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', Vamos Analisar outra Vaga?', 'Você pode optar por usar os modelos definidos (Junior, Pleno ou Sênior)!!');
   };

   window.msgSuccess = function(data, nome) {
      if (data){
         document.getElementById("registration-charge").submit();
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
     window.profileConfirm('cool',$nome,';) Ohhhhh ' + $nome + ', O perfil selecionado corresponde a uma Analista ' + analista + '. Deseja Confirmar?', ';) Confirmar', ':( Desistir', msgSuccess);
   };

   function msgTextarea( $idFront, $num ) {
      target = $('#' + $idFront).closest('.textareaInput');
      boxData = $(target).find('.msgFront');
      $(boxData)
      .html("")
      .html('seu texto tem ' + $num + ' caracteres')
      .show();

      if($num >= 10){
         $(boxData)
         .html("")
         .html('Seu texto tem ' + $num + ' caracteres de um limite de 200 Caracteres')
         .show();
      }
      else if($num <= 5){
         $(boxData)
         .html("")
         .html('Seu texto tem ' + $num + ' caracteres de um minimo de 20 Caracteres')
         .show();
      }
   }

   function msgFront( $idFront, $msg ) {
      boxData = $("#msg-" + $idFront);
      $(boxData)
      .html("")
      .html($msg)
      .show()
   }

   validaAtribuicoes = function ($idText) {
      var textStatus = true;
      var num = $('#' + $idText).val().length;
      msgTextarea( $idText, num );
      if(num >= 201 || num < 5){
         $('#' + $idText).val($('#' + $idText).val().substring(0,200));
         textStatus = false;
      }
      return textStatus;
   }


   clickme.on('click', function() {
      status = true;

      temp = window.validaAtribuicoes('oppAssignments');
      offMessage('addOpportunity')

      if (!temp) {
         $('#oppAssignments').addClass( 'input-error' );
         status = false;
      }
      else {
         $('#oppAssignments').removeClass( 'input-error' );
      }

      if ($('#oppCompany').val() == "") {
         $('#oppCompany').addClass( 'input-error' );
         msgInvalida = "Informe a Empresa responsável pela oportunidade!!";
         msgFront( 'oppCompany', msgInvalida);
         status = false;
      }
      else {
         msgInvalida = "";
         $('#oppCompany').removeClass( 'input-error' );
      }

      if ($('#oppContact').val() == "") {
         $('#oppContact').addClass( 'input-error' );
         msgInvalida = "Informe o e-mail de contato para oportunidade!!";
         msgFront( 'oppContact', msgInvalida);
         status = false;
      }
      else {
         msgInvalida = "";
         $('#oppContact').removeClass( 'input-error' );
      }
      if (status) {
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
      }
   });
});
