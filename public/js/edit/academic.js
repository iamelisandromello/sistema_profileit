jQuery(document).ready(function() {
    'use strict';
    var status;
    var successCorrect;

    window.resetForm = function (idForm) { 
    //function resetForm(idForm) {
    // seleciona o form a ser resetado
        var form = document.getElementById(idForm);
        alert(idForm);
        alert(form);
    // limpa todos os inputs do tipo text, password, etc...
        var inputs = form.querySelectAll('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type != 'checkbox' && inputs[i].type != 'radio') {
                inputs[i].value = '';
            }
        }
    // limpa todas as textareas
        var textarea = form.querySelectAll('textarea');
        for (var i = 0; i < textarea.length; i++) {
            textarea[i].value = '';
        }
    // desmarca todos os checkboxes e radios
        inputs = form.querySelectAll('input[type=checkbox], input[type=radio]');
        for (i = 0; i < inputs.length; i++) {
            inputs[i].checked = false;
        }
    // seleciona a primeira opcao de todos os selects
        var selects = form.querySelectAll('select');
        for (i = 0; i < selects.length; i++) {
            var options = selects[i].querySelectorAll('option');
            if (options.length > 0) {
                selects[i].value = options[0].value;
            }
        }
    }
    
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
                alert('Foi carregado e não está preenchido!');
                $('#adddate_conclusion').addClass("input-error");
                next_step = false;  
              }
            } else {
             alert('Não foi carregado!');      
            }
        }
        else {
            $('#adddate_conclusion').removeClass("input-error");
            $('adddate_conclusion').datepicker('setDate', null);
        }

        if( next_step ) {
            document.getElementById("addAcademicForm").submit();
        }
        else{
            alert('nao preenchidos');
            successCorrect = "#msg-box3 span";
            alert(successCorrect);
            $(successCorrect)
            .html("")
            .html("Não Foram Selecionados as <strong> Opções Obrigatórias </strong>.")
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
    * InputDate Danta de Conclusão dA Formação
    */
    $( "#level03" ).on( "click", function() {
        //alert(this.id); // alerta 'seuid'
        $("#boxDataConclusion").hide("slow");
    });

    $( "#level02" ).on( "click", function() {
        //alert(this.id); // alerta 'seuid'
        $("#boxDataConclusion").hide("slow");
    });

    $( "#level01" ).on( "click", function() {
        //alert(this.id); // alerta 'seuid'
        $("#boxDataConclusion").show(1000);
    });

});