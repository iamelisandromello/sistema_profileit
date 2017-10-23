jQuery(document).ready(function() {

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

	window.sendAdd = function(user) {
 		triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Inclusão de uma Nova Competência?', ';) Só se For Agora', ':( Ainda Não', addReturn);
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

	/**
	* Área Hisórico Academico
	*/
	window.delReturnAcademic = function(data, nome, idAcademic) {
		if (data){
		   $(location).attr('href', 'http://localhost/profileit/perfil/delacademic/' + idAcademic);
		}
		else{
			triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', então Iremos Cancelar essa Exclusão', 'OK Fica para Depois!!!');
		}
	}

	window.academicConclusion = function() {
		var now = new Date;
		var dataConclusao = new Date(document.getElementById("date_conclusion").value);

   	if (now >= dataConclusao) {
         document.getElementById("addconclusion").submit();
     	}
     	else{
			document.getElementById('date_conclusion').value=''; // Limpa o campo
			triggerNotify('purple', 'tongue2', 'Eeei , Data de Conclusão Informada Inválida', 'Realize o Processo Novamente!!!');
     	}

	};

	window.sendUpAcademic = function(idAcademic) {
      $(".modal-content #modalId").val(idAcademic);
	};

	window.sendDelAcademic = function(idAcademic, user) {
		triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Exclusão deste Histórico Acadêmico?', ';) Agora', ':( Ainda Não', delReturnAcademic, idAcademic);
	};

});
