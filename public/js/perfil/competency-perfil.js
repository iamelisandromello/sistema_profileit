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

	window.sendAddCompetency = function(data, nome) {
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

	$('.addcompetency input[type="text"], .addcompetency input[type="password"], .addcompetency textarea, .addcompetency select, .addcompetency radio').on('focus', function() {
	   $(this).removeClass('input-error');
	});


	$('.addcompetency .btn-addCompetency').on('click', function() {
	   var parent_fieldset = $(this).parents('fieldset');
	   var next_step = true;
	   var user = ($("#btnOK").val());

	   parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {
	      var id = $(this).attr('id');
	      if( $(this).val() == "" || $(this).val() === "-1") {
	         $(this).addClass("input-error");
	         next_step = false;
	      }
	      else{
	         $(this).removeClass("input-error");
	      }
	   });

	   if (next_step) {
			triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Inclusão de uma Nova Competência?', ';) Só se For Agora', ':( Ainda Não', sendAddCompetency);
 		}
 		else {
	      successCorrect = "#msg-box3 span";
	      $(successCorrect)
	      .html("")
	      .html("Não Foram Selecionados as <strong> Opções Obrigatórias </strong>.")
	      .removeClass()
	      .addClass("alert alert-success")
	      .show();
	      setTimeout(function(){
	         $(successCorrect).hide();
	      }  , 5000);
	   }
	});

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
