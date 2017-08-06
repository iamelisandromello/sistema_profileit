jQuery(document).ready(function() {
    
	 /**
	* <b>msgReturn:</b> Recebe o <Return> da função de Confirmação[triggerConfirmUp], direcionando para o Controller de Execução ou para a Função de Cancelamento [window.cancelar].
	* @param data return de True ou False da Confirmação
	* @param nome Usuário Logado que está executando o processo
	* @param idCompetency ID da competência que será atualizada no BD 
	* @param levele novo valor da competência a ser atualizada
	*/

	window.msgReturn = function(data, nome, idCompetency, level) {
		if (data){   
		   $(location).attr('href', 'http://localhost/profileit/perfil/upcompetency/' + idCompetency + '/' + level);
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

	window.sendEdit = function(idElemento, idCompetency, goback , user) {    
		level = $('#' + idElemento).val();
		triggerConfirmUp('cool',user,';) Ohhhhh ' + user + ', Vamos Realizar um Upgrade de Competências?', ';) Agora', ':( Ainda Não', msgReturn, idCompetency, level);
		
		window.cancelar = function(user){
			$("select#" + idElemento).val(goback);
			triggerNotify('purple', 'bubbles', 'Eeei ' + user + ', então Iremos Canecelar esse Upgrade', 'OK Fica para Depois!!!');
		};		
	};
	

	/**
	* <b>onClick:</b> Funcão no Onclick do BoxDe Mensagem BackEnd para Fechamento
	*/
   $("#boxTransitions").click(function (e) {
      var notifyBox = $(this);
      if (e.target === this) {
          notifyBox.fadeOut(function () {
              $(this).remove();
          });
      }
   });

});
