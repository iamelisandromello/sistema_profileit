$(function() {
   var next_step = true;

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

   function msgTextarea( $idFront, $num ) {
      target = $('#' + $idFront).closest('.textareaInput');
      boxData = $(target).find('.msgFront');
      $(boxData)
      .html("")
      .html('seu texto tem ' + $num + ' caracteres')
      .show();

      if($num >= 144){
         $(boxData)
         .html("")
         .html('Seu texto tem ' + $num + ' caracteres de um limite de 144 Caracteres')
         .show();
      }
      else if($num <= 5){
         $(boxData)
         .html("")
         .html('Seu texto tem ' + $num + ' caracteres de um minimo de 20 Caracteres')
         .show();
      }
   }

   validaMensagem = function ($idText) {
      var textStatus = true;
      var num = $('#' + $idText).val().length;
      msgTextarea( $idText, num );
      if(num >= 145 || num < 5){
         $('#' + $idText).val($('#' + $idText).val().substring(0,144));
         textStatus = false;
      }
      return textStatus;
   }

   //Função retorna mensagem de Cancelamento
   function cleanRecommendation (nome) {
      triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', Vamos Reeditar essa Recomendação?', 'É importante realizar recomendações interagindo com a comunidade!!');
   };

   function cleanMessage (nome) {
      triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', Deseja editar a mensagem?', 'É importante manter contatos e agregar relacionamentos com a comunidade!!');
   };

	//Função retorna mensagem de Sucesso
   function recommendationSuccess (data, nome) {
      if (data){
         document.getElementById("registration-recommendation").submit();
         triggerNotify('purple', 'bubbles', 'Ohhhh Show ' + nome + ',  Recomendação Enviada', 'Aguardar aprovação do colega!!');
      }
      else{
        cleanRecommendation(nome);
      }
   }

   //Função retorna mensagem de Sucesso
   function msgSuccess (data, nome) {
      if (data){
         document.getElementById("registration-message").submit();
         triggerNotify('purple', 'bubbles', 'Ohhhh Show ' + nome + ',  Mensagem Enviada', 'Aguardar retorno do colega!!');
      }
      else{
        cleanMessage(nome);
      }
   }

   function confirmRecommendation ($nome) {
      window.profileConfirm('cool',$nome,';) Ohhhhh ' + $nome + ', Enviar recomendação referente ao colega?', ';) Confirmar', ':( Desistir', recommendationSuccess);
   };

   function confirmMessage ($nome) {
      window.profileConfirm('cool',$nome,';) Ohhhhh ' + $nome + ', Enviar mensagem para o colega?', ';) Confirmar', ':( Desistir', msgSuccess);
   };

   //Função no carregamneto do Modal Limpar Configurações
   $( "#btnAddRecomendacao" ).on( "click", function() {
   	$('#relationship').removeClass( 'input-error' );
   	$('#charge_recommendation').removeClass( 'input-error' );
      $('#charge_recommended').removeClass( 'input-error' );
      $('#description').removeClass( 'input-error' );
   });

   $( "#btnAddMessage" ).on( "click", function() {
      $('#addMensagem').removeClass( 'input-error' );
   });

   //Função de Validação e Envio de Recomendação
   $('#btRecommendation').on('click', function() {
		parent_fieldset = $(this).parents('fieldset');
      next_step = true;
      var user= $('#hiddenUser').val();
      var id = $(this).attr("id"); // captura o ID do Button Step
      idFieldset = parent_fieldset.attr("id");
      parent_fieldset.find('input[type="text"], input[type="password"], input[type="email"], textarea, select').each(function() {
         if( $(this).val() == "" || $(this).val() === "-1") {
            $(this).addClass('input-error');
            next_step = false;
         }
         else{
            $(this).removeClass('input-error');
         }// Verfica se Input Obrigatório não está vazio
      });

		if(next_step){
			confirmRecommendation(user);
		}

	});/*</btRecommendation Click>*/

   //Função de Validação e Envio de Recomendação
   $('#btMessage').on('click', function() {
      next_step = true;
      var user= $('#hiddenUserM').val();

      temp = window.validaMensagem('textoMensagem');
      offMessage('addMessage');

      if (!temp) {
         $('#textoMensagem').addClass( 'input-error' );
         next_step = false;
      }
      else {
         $('#textoMensagem').removeClass( 'input-error' );
      }

      if(next_step){
         confirmMessage(user);
      }

   });/*</btRecommendation Click>*/

});/*</JQuery>*/
