
jQuery(document).ready(function() {
    var ok = "#btnOK";
    var clean = "#btnClean";
    var radio = ":radio";
    var color;
    var i = 1;
    var parte1 = "question_";
    var parte2 = "msg-box";
    var msg;
    var successBack;
    var failureBack;
    var answer;
    var state = true;

    function successRadio(mensagem) {
        successBack = "#" + mensagem + " span";
        $(successBack)
        .html("Foi selecionado a opção <strong>" + color + "</strong>.")
        .removeClass()
        .addClass("alert alert-success")
        .show();
        setTimeout(function(){
          $(successBack).hide();
        } , 5000);
    }

    function failureRadio(mensagem) {
        state = false;
        failureBack = "#" + mensagem + " span";
        $(failureBack)
        .html("Não foi selecionado nenhuma opção")
        .removeClass()
        .addClass("alert alert-danger")
        .show();

        setTimeout(function(){
          $(failureBack + " span").hide();
        } , 5000);
    }

    function validaRadio(nome, msgbox) {       
        if ( $('input[type="radio"][name="' + nome + '"]').is(':checked') ){
            //return false; // para submit habilite esta linha
            $.each($('input[type="radio"][name="' + nome + '"]'), function(id , val){
                if($(val).is(":checked")){
                    color = $(val).val();
                    return false;
                };
            });
            //var color = $(radio).is("checked").prop("id");
            console.log(color);
            successRadio(msgbox);
        }
        else {
            failureRadio(msgbox);
        }
    }

    $( "input" ).on( "click", function() {
        $( "#log" + i).html( $( "input:checked" ).val() + " is checked!" );
    });

    /*$(ok).on("click" , function(){
        $(".pergunta").each(function(index, value){//percorre as #div[pergunta]
            answer = parte1+i;//concatena question_ com o contador, para defenir a pergunta em análise
            msg = parte2+i;//concatena msg-box_ com o contador, para defenir a mensagem
            validaRadio(answer, msg);//Função de análise de status RadioBox
            i++;//contador         
            if(i > 15){//verifica o contador de perguntas
                i = 1;
            }
        });
    });*/

    window.clean = function(value) {
        triggerNotify('purple', 'bubbles', 'Eeei ' + value + ', Vamos Iniciar o Questionário Novamente?', 'Você Precisa Completar esta Etapa para Criar seu Perfil!!');
        i=1;
        $(".pergunta").each(function(index, value){//percorre as #div[pergunta]
            msg = parte2+i;//concatena msg-box_ com o contador, para defenir a mensagem
            successBack = "#" + msg + " span";
            $(successBack)
            .html("")
            .removeClass();        
            i++;//contador
            if(i > 15){//verifica o contador de perguntas
                i = 1;
            }
        });
        $(radio).prop("checked" , false);
    };

    $(ok).on('click' , function(){
        triggerConfirm('cool', ';) Ohhhhh. Vamos Enviar o Questionário para Análise?', 'OK', 'Cancel', 'teste');
    });


    // submit
    $('.quiz-form').on('submit', function(e) {
        state = true;
        $(".pergunta").each(function(index, value){//percorre as #div[pergunta]
            answer = parte1+i;//concatena question_ com o contador, para defenir a pergunta em análise
            msg = parte2+i;//concatena msg-box_ com o contador, para defenir a mensagem
            validaRadio(answer, msg);//Função de análise de status RadioBox
            i++;//contador         
            if(i > 15){//verifica o contador de perguntas
                i = 1;
            }
        });
        
        if(state == false){
            e.preventDefault();
            $(this).addClass('input-error');
        }
        else{
            $(this).removeClass('input-error');
        }
       
    });    

});
