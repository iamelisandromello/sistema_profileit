$(function() {
   var url     = 'http://localhost/profileit/home/checkMessage/';
   var base    = 'http://localhost/profileit/public/uploads/users/';
   var textoMensagem   = "";


   function cleanMessage (nome) {
      triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', Deseja editar a mensagem?', 'É importante manter contatos e agregar relacionamentos com a comunidade!!');
   };

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

   function confirmMessage ($nome) {
      window.profileConfirm('cool',$nome,';) Ohhhhh ' + $nome + ', Enviar mensagem para o colega?', ';) Confirmar', ':( Desistir', msgSuccess);
   };

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

   window.checkMessage = function(idMessage, user_id) {
         $.ajax({
            url: url, //caminho do arquivo servidor
            type: 'post', //formato de envio
            dataType: 'json', //formato de Retorno
            data: {  //Dados enviados para o servidor
               'message_id'   : idMessage,
               'user_id'      : user_id
            }
         }).done(function( response ){
               var mensagem  = response.mensagem;
               var nome    = response.nome;
               triggerNotify('purple', 'bubbles', 'Ohhhh Show ' + nome + ',  Mensagem marcada como lida', 'Não aparecerá na sua timeline na próxima atualização!!');
               //confirmOpportunity(perfil, nome);
         }).fail(function(jqXHR, textStatus ) {
               console.log("Requisição ao servidor falhou: " + textStatus);
         }).always(function() {
               console.log("completou o Processamento");
         });
         return false;
   };

   //window.replyModal = function($sender_id, $sender_image, $mensagem) {
   window.replyModal = function($sender_id, $sender_image) {
      status = true;
      $('#replyText').val('');
      $('#replyText').removeClass( 'input-error' );
      $("#imgSender").attr("src", base + $sender_id + "/" + $sender_image);
   };

   window.replyMessage = function(user) {

      next_step = true;
      //var user= $('#hiddenUserM').val();

      temp = window.validaMensagem('replyText');
      offMessage('resposeMessage');

      if (!temp) {
         $('#replyText').addClass( 'input-error' );
         next_step = false;
      }
      else {
         $('#replyText').removeClass( 'input-error' );
      }

      if(next_step){
         alert('responder Mensagem');
         confirmMessage(user);
      }
   };

});


