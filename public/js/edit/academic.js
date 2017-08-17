jQuery(document).ready(function() {
    'use strict';
    
    window.backAcademic = function(data, nome) {
        if (data){
            document.getElementById("addacademic").submit();
        }
        else{
            triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', então Iremos Cancelar essa Exclusão', 'OK Fica para Depois!!!');
        }
    }

    $('.editAcademic-form input[type="text"], .editAcademic-form input[type="password"], .editAcademic-form textarea, .editAcademic-form select, .editAcademic-form radio').on('focus', function() {
        $(this).removeClass('input-error');
    });

    $('.editAcademic-form .btn-UpAcademic').on('click', function() {
    //window.addFormacao = function () {    
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;
        parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {
            if( $(this).val() == "" || $(this).val() === "-1") {
                $(this).addClass("input-error");
                $('input:last').addClass('input-error');
                next_step = false;
            }
            else{
                $(this).removeClass("input-error");
            }
        });
    
        if( next_step ) {
            //triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Inclusão de uma Nova Competência?', ';) Só se For Agora', ':( Ainda Não', addReturn);
            alert('ok');
        }
        else{
            alert('nao preenchidos');
        }        
    });

    /*window.academicConclusion = function(user) {
        alert()
        //triggerConfirmDel('confused',user,';) Ohhhhh ' + user + ', Vamos Realizar a Inclusão de uma Nova Competência?', ';) Só se For Agora', ':( Ainda Não', addReturn);   
   };*/

    // submit
    $('.editAcademic-form').on('submit', function(e) {
        $(this).find('input[type="text"], input[type="password"], textarea').each(function() {
            if( $(this).val() == "" ) {
                e.preventDefault();
                $(this).addClass('input-error');
            }
            else {
                $(this).removeClass('input-error');
            }
        });
    });
});