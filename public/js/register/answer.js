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

    //Função Add Mensagem de Resposta Selecionada FrontEnd
    function successTeste(mensagem) {  
        successCorrect = "#" + mensagem + " span";
        alert(successCorrect);
        $(successCorrect)
        .html("")
        .html("Foi selecionado a opção <strong>" + color + "</strong>.")
        .removeClass()
        .addClass("alert alert-success")
        .show();
        setTimeout(function(){
          $(successCorrect).hide();
        } , 5000);
    }

    //Função Add Mensagem de Resposta Selecionada FrontEnd
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
    //Função Add Mensagem de Resposta não Selecionada FrontEnd
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

    //Função Verifica Se Questão foi Respondida
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
        //alert(this.id); // alerta 'seuid'
        successTeste(this.name);
    });

    window.msgSuccess = function(data, nome) {
        if (data){
            document.getElementById("quiz-form").submit();
            triggerNotify('purple', 'bubbles', 'Ohhhh Show ' + nome + ',  Perfil Completo', 'Você Precisa Completar esta Etapa para Criar seu Perfil!!');
        }
        else{
            window.clean(nome);
        }
    }

    window.sendAnswer = function(nome) {
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
            triggerNotify('purple', 'bubbles', 'Eeei ' + nome + ', Esqueceu de Preencher algumas perguntas?', 'Você Precisa Completar esta Etapa para Criar seu Perfil!!');
        }
        else{
            triggerConfirm('cool',nome,';) Ohhhhh ' + nome + ', Vamos Enviar o Questionário para Análise de Perfil?', ';) Enviar', ':( Ainda Não', msgSuccess);
        }  
    };

    //Função de Reset Respsotas do Questionário
    window.clean = function(value) {
        triggerNotify('purple', 'bubbles', 'Eeei ' + value + ', Vamos Reiniciar o Questionário?', 'Você Precisa Completar esta Etapa para Criar seu Perfil!!');
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

    // Função de Submit das respostas, caso validações retornem True 
    /*$('.quiz-form').on('submit', function(e) {
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
    });*/




    /*$(ok).on('click' , function(){
        triggerConfirm('cool', ';) Ohhhhh. Vamos Enviar o Questionário para Análise de Perfil?', ';) Enviar', ':( Ainda Não', teste);
    });*/

    // Função de Submit das respostas, caso validações retornem True 
    /*$('.quiz-form').on('submit', function(e) {
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
    });*/

});
