jQuery(document).ready(function() {
	var next_step = true;

	/**
	* <b>editReturn:</b> Recebe o <Return> da função de Confirmação[triggerConfirmUp], direcionando para o Controller de Execução ou para a Função de Cancelamento [window.cancelar].
	* @param data return de True ou False da Confirmação
	* @param nome Usuário Logado que está executando o processo
	* @param idCompetency ID da competência que será atualizada no BD
	* @param levele novo valor da competência a ser atualizada
	*/
	window.editReturn = function(data, nome, idCompetency, level) {
		if (data) {
		   $(location).attr('href', 'http://localhost/profileit/perfil/upcompetency/' + idCompetency + '/' + level);
		}
		else{
			  window.cancelar(nome);
		}
	}

	window.delReturn = function(data, nome, idCompetency) {
		if (data){
		   $(location).attr('href', 'http://localhost/profileit/perfil/delcompetency/' + idCompetency);
		}
		else{
			triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', então Iremos Cancelar essa Exclusão', 'OK Fica para Depois!!!');
		}
	}

	window.addReturn = function(data, nome) {
        if (data){
            document.getElementById("addcompetency").submit();
        }
        else{
			triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', então Iremos Cancelar essa Exclusão', 'OK Fica para Depois!!!');
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
		triggerConfirmUp('cool',user,';) Ohhhhh ' + user + ', Vamos Realizar um Upgrade de Competências?', ';) Agora', ':( Ainda Não', editReturn, idCompetency, level);

		window.cancelar = function(user){
			$("select#" + idElemento).val(goback);
			triggerNotify('purple', 'bubbles', 'Eeei ' + user + ', então Iremos Canecelar esse Upgrade', 'OK Fica para Depois!!!');
		};
	};

	window.sendDel = function(idCompetency, user) {
		triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Exclusão desta Competência?', ';) Agora', ':( Ainda Não', delReturn, idCompetency);
	};

	window.addQualification = function(user) {
 		next_step = true;
 		if ($('#qualification_id').val()<= 0) {
 			alert('teste');
 			$('#qualification_id').addClass('input-error');
 			next_step = false;
 		}

 		if (next_step) {
			triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Inclusão de uma Nova Competência?', ';) Só se For Agora', ':( Ainda Não', addReturn);
 		}

   };

	/**
	* <b>onClick:</b> Funcão no Onclick do Box de Mensagem BackEnd para Fechamento
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
