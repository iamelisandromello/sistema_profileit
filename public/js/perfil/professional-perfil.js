jQuery(document).ready(function() {
    'use strict';
    var status;
    var successCorrect;
    var temp;

   function limpaForm(idForm) {
      $("#" + idForm).each (function(){
         this.reset();
      });
   };

   $("#addExperiencia").on('click', function() {
      limpaForm('addProfessionalForm');
   });

   $('#boxDataOut').hide("slow");
   /*
    * Inclusão de Experiênci Profissional
   */
   $('.addProfessionalForm input[type="text"], .addProfessionalForm input[type="password"], .addProfessionalForm textarea, .addProfessionalForm select, .addProfessionalForm radio').on('focus', function() {
      $(this).removeClass('input-error');
   });

   $('.addProfessionalForm .btn-addProfessional').on('click', function() {
      var parent_fieldset = $(this).parents('fieldset');
      var next_step = true;
      parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {
         var id = $(this).attr('id');
         if(!id == $("adddate_out")){
            if( $(this).val() == "" || $(this).val() === "-1") {
               $(this).addClass("input-error");
               next_step = false;
            }
            else{
               $(this).removeClass("input-error");
            }
         }
      });

      //Verifica Período de Entrada e Saída Válida
      //Verifica se Usuário Informou Empregado
      if ($('input[type="checkbox"][name="atual"]').is(':checked') ) {
         temp = window.validaData('addProfessionalField', 'adddate_entry'); //Verifica Data Válida
         $("#adddate_out").datepicker('setDate', null);
      }
      else {
         //Verifica Período de Entrada e Saída Válida
         temp = window.validaPeriodo('addProfessionalField', 'adddate_entry', 'adddate_out');
      }

      if (!temp) {
         next_step = false;
      }

      if( next_step ) {
            document.getElementById("addProfessionalForm").submit();
      }
      else{
         successCorrect = "#msg-box3 span";
         var mensagemUP = ""
         if (temp) {
            mensagemUP = "Não Foram Selecionados as <strong> Opções Obrigatórias </strong>.";
         }
         else {
            mensagemUP = "Inconsistências nas Datas <strong> Corrija as Informações </strong>.";
         }

         $(successCorrect)
         .html("")
         .html(mensagemUP)
         .removeClass()
         .addClass("alert alert-success")
         .show();
         setTimeout(function(){
           $(successCorrect).hide();
         } , 5000);
      }
   });

   /*
    * Atualização de Experiência Profissional
   */
   $('.upProfessionalForm input[type="text"], .upProfessionalForm input[type="password"], .upProfessionalForm textarea, .upProfessionalForm select, .upProfessionalForm radio').on('focus', function() {
      $(this).removeClass('input-error');
   });

   $('.upProfessionalForm .btn-UpProfessional').on('click', function() {
      var parent_fieldset = $(this).parents('fieldset');
      var next_step = true;
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

      //Verifica Período de Entrada e Saída Válida
      temp = window.validaPeriodo('upProfessionalField', 'update_entry', 'update_out');
      if (!temp) {
         next_step = false;
      }

      if( next_step ) {
            document.getElementById("upProfessionalForm").submit();
      }
      else{
         successCorrect = "#msg-box3 span";
         var mensagemUP = ""
         if (temp) {
            mensagemUP = "Não Foram Selecionados as <strong> Opções Obrigatórias </strong>.";
         }
         else {
            mensagemUP = "Inconsistências nas Datas <strong> Corrija as Informações </strong>.";
         }

         $(successCorrect)
         .html("")
         .html(mensagemUP)
         .removeClass()
         .addClass("alert alert-success")
         .show();
         setTimeout(function(){
           $(successCorrect).hide();
         } , 5000);
      }
   });


   /*
   * Função para habilitar/desabilitar
   * InputDate DataPicker de Trabalho Atual
   */
   $( "#atual" ).on( "click", function() {
      if ( ! $('input[type="checkbox"][name="atual"]').is(':checked') ) {
         $('#boxDataOut').show(1000);
      }
      else {
         $('#boxDataOut').hide("slow");
      }
   });

   /**
   * Área Incluir Conclusão Academica
   */
   window.delReturnProfessional = function(data, nome, idProfessional) {
      if (data){
         $(location).attr('href', 'http://localhost/profileit/perfil/delProfessional/' + idProfessional);
        }
      else{
         triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', então Iremos Cancelar essa Exclusão', 'OK Fica para Depois!!!');
      }
   }

   window.academicConclusion = function() {
      temp = window.validaData('conclusionAcademic', 'date_conclusion');
      if (temp) {
         document.getElementById("addconclusion").submit();
      }
      else{
         document.getElementById('date_conclusion').value=''; // Limpa o campo
         triggerNotify('purple', 'tongue2', 'Eeei , Data de Conclusão Informada Inválida', 'Realize o Processo Novamente!!!');
      }
   };

   window.sendUpProfessional = function(idProfessional) {
      $(".modal-content #modalIdpro").val(idProfessional);
   };

   window.sendDelProfessional = function(idProfessional, user) {
      triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Exclusão deste Histórico Profissional?', ';) Agora', ':( Ainda Não', delReturnProfessional, idProfessional);
   };


});