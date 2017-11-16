jQuery(document).ready(function() {
    'use strict';
    var status;
    var successCorrect;
    var temp;

   window.limpaForm = function (idForm) {
      $("#" + idForm).each (function(){
         this.reset();
      });
   }

   $("#addFormacao").on('click', function() {
      limpaForm('addAcademicForm');
   });

   $('.addAcademicForm input[type="text"], .addAcademicForm input[type="password"], .addAcademicForm textarea, .addAcademicForm select, .addAcademicForm radio').on('focus', function() {
      $(this).removeClass('input-error');
   });

   $("#boxDataConclusion").hide("slow");

   $('.addAcademicForm .btn-UpAcademic').on('click', function() {
      var parent_fieldset = $(this).parents('fieldset');
      var next_step = true;
      parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {
         var id = $(this).attr('id');
         if (id != "adddate_conclusion"){
            if( $(this).val() == "" || $(this).val() === "-1") {
               $(this).addClass("input-error");
               next_step = false;
            }
            else{
               $(this).removeClass("input-error");
            }
         }
      });

      if ( $('input[type="radio"][name="addAcademic"]').is(':checked') ){
         $.each($('input[type="radio"][name="addAcademic"]'), function(id , val){
            if($(val).is(":checked")){
               status = $(val).val();
               return false;
            };
         });
      }
      else {
         $('#boxRadio').addClass("input-error");
         next_step = false;
      }

      /*
      * Função Verifica se foi Selecionado
      * a Opção de Formação Concluída
      */
      if (status == 1) {
         var inputText = $('#adddate_conclusion').val();
         if( inputText !== undefined) {
            if ( inputText == '' ) {
               $('#adddate_conclusion').addClass("input-error");
               next_step = false;
            }
         }
      }
      else {
         $('#adddate_conclusion').removeClass("input-error");
         $('adddate_conclusion').datepicker('setDate', null);
      }

      if( next_step ) {
         document.getElementById("addAcademicForm").submit();
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

   /*
   * Função para habilitar/desabilitar
   * InputDate Data de Conclusão da Formação
   */
   $( "#level03" ).on( "click", function() {
      $("#boxDataConclusion").hide("slow");
   });

   $( "#level02" ).on( "click", function() {
      $("#boxDataConclusion").hide("slow");
   });

   $( "#level01" ).on( "click", function() {
      $("#boxDataConclusion").show(1000);
   });

   /**
   * Área Incluir Conclusão Academica
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
      temp = window.validaData('conclusionAcademic', 'date_conclusion');
      if (temp) {
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