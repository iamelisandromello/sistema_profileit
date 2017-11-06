jQuery(document).ready(function() {

   window.triggerConfirm = function(icon, nome, confirm, btn_true, btn_false, action, idRecommendation) {
     //CREATE BOX
     btn_false = (btn_false ? "<span class='btn btn-primary btn-lg margin-btm-30 up_confirm_false'>" + btn_false + "</span>" : "");
     $("body").append("<div class='up_confirm'><div class='up_confirm_box'><div class='up_confirm_box_content'><span class='up_confirm_box_content_icon icon-" + icon + " icon-notext'></span>" + confirm + "</div><div class='up_confirm_box_action'><span class='btn btn-primary btn-lg margin-btm-30 up_confirm_true'>" + btn_true + "</span>" + btn_false + "</div></div></div>");

     //SHOW BOX
     $(".up_confirm").fadeIn(200, function () {
         $(".up_confirm_box").animate({"top": "0", "opacity": "1"}, 200);
     }).css("display", "flex");

     //ACTION BOX
     $(".up_confirm_true").click(function (data) {
         confirmRemove();
         action(true, nome,idRecommendation);
     });

      $(".up_confirm_false").click(function () {
      	confirmRemove();
         action(false, nome, idRecommendation);
      });

      function confirmRemove() {
         $(".up_confirm_box").animate({"top": "100", "opacity": "0"}, 200, function () {
            $(".up_confirm").fadeOut(200, function () {
               $(this).remove();
            });
         });
      }

   }

	/**
	* <b>editReturn:</b> Recebe o <Return> da função de Confirmação[triggerConfirmUp], direcionando para o Controller de Execução ou para a Função de Cancelamento [window.cancelar].
	* @param data return de True ou False da Confirmação
	* @param nome Usuário Logado que está executando o processo
	* @param idCompetency ID da competência que será atualizada no BD
	* @param levele novo valor da competência a ser atualizada
	*/
	window.appReturn = function( data, nome, idRecommendation ) {
		if (data) {
		   $(location).attr('href', 'http://localhost/profileit/home/apprecommendation/' + idRecommendation);
		}
		else{
			  window.cancelar(nome);
		}
	}

	window.disReturn = function( data, nome, idRecommendation ) {
		if (data) {
		   $(location).attr('href', 'http://localhost/profileit/home/disrecommendation/' + idRecommendation);
		}
		else{
			  window.cancelar(nome);
		}
	}


	/**
	* <b>sendEdit:</b> Funcão no Onclick do buton de edit de competência, recebe os parâmetros que serão analisados pelas funções de execução
	* @param idElemento recebe o ID do elemento HTML que está sendo operado
	* @param idCompetency ID da competência que será atualizada no BD
	* @param goback valor atual da competência para ataulização FrontEnd, em caso de Cancel
	* @param user Usuário Logado que está executando o processo
	*/
	window.appRecommendation = function(idRecommendation , user) {
		triggerConfirm('cool',user,';) Ohhhhh ' + user + ', Vamos Aprovar essa Recomendação?', ';) Agora', ':( Ainda Não', appReturn, idRecommendation);

		window.cancelar = function(user){
			triggerNotify('purple', 'bubbles', 'Eeei ' + user + ', então Iremos Cancelar essa Aprovação', 'OK Fica para Depois!!!');
		};
	};

	window.disRecommendation = function(idRecommendation , user) {
		triggerConfirm('cool',user,';) Ohhhhh ' + user + ', Você Pretende Reprovar essa Recomendação?', ';) Agora', ':( Ainda Não', disReturn, idRecommendation);

		window.cancelar = function(user){
			triggerNotify('purple', 'bubbles', 'Eeei ' + user + ', você deve Aprovar ou Reprovar esta Recomendação ', 'OK Fica para Depois!!!');
		};
	};

});
