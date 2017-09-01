    
jQuery(document).ready(function() {
   'use strict';
    var status;   
    /*
        Fullscreen background
    */
    $.backstretch("/profileit/public/images/backgrounds/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });

    /*function isValdata(pData)
    {
        var reTipo = /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/; // Onde ... é a expressão regular apropriada
        return reTipo.test(pData);
    }*/

    function isValNumber(pNumber)
    {
        var reNumber = /^\d+$/; // Onde ... é a expressão regular apropriada
        return reNumber.test(pNumber);
    }

    function validaCampo(pLong){
      var n     = pLong.length;
      if(n < 6){
        return false;
        campo.focus();
      }
    return true;
    }

    /*
    * Converte formato de Data BR para EN
    * $dataBR: recebe como parametro uma string com o ID do elemento dataPicker
    * return objeto date formato EN
    */
    function convertBREN ($dataBR) {
        var dataQuebrada = $($dataBR).val().split("/");
        var dataEN = new Date(dataQuebrada[2], dataQuebrada[1] - 1, dataQuebrada[0]); 
        return dataEN;
    }

    /*
    * Converte objeto date em uma string organizada DD/MM/YYYY
    * $data: recebe objeto date formato EN
    * return : String
    */
    function dataString ($data) {
        var dia = $data.getDate();
        var mes = $data.getMonth();
        mes = mes + 1;
        var ano = $data.getFullYear();
        var stringData = dia + '/' + mes + '/' + ano;
        return stringData;
    }

    /*
    * Realiza Calculo de Idade Informada no DatePicker Form
    * $dataInformada: recebe String organizada DD/MM/YYYY
    * return : String
    */
    function calculaIdade($dataInformada) {
        var birthday = new Date($dataInformada);
        var today = new Date();
        var years = today.getFullYear() - birthday.getFullYear();

        //Reinicie o aniversário para o ano atual.
        birthday.setFullYear(today.getFullYear());

        // Se o aniversário do usuário ainda não ocorreu este ano, subtrair 1.
        if (today < birthday)
        {
            years--;
        }
        return years
    }


    $( "#title" ).keyup(function() {
        //alert( "Handler for .keyup() called." );
        var x = "";
        x = validaCampo(document.getElementById("title").value);
        if (x== false){
            document.getElementById("labelTitle").innerHTML = "Necessário Minimo 6 Caracteres";
        }
        else {
            document.getElementById("labelTitle").innerHTML = "";
        }  
        document.getElementById("title").focus();        
    });

    $( "#institution" ).keyup(function() {
        //alert( "Handler for .keyup() called." );
        var x = "";
        x = validaCampo(document.getElementById("institution").value);
        if (x== false){
            document.getElementById("labelInstitution").innerHTML = "Necessário Minimo 6 Caracteres";
        }
        else {
            document.getElementById("labelInstitution").innerHTML = "";
        }  
        document.getElementById("institution").focus();        
    });


    $( "#workload" ).keyup(function() {
        //alert( "Handler for .keyup() called." );
        var x = "";
        x = isValNumber(document.getElementById("workload").value);
        if (x== false){
            document.getElementById("labelworkload").innerHTML = "Somente Numeros";
        }
        else {
            document.getElementById("labelworkload").innerHTML = "";
        }  
        document.getElementById("workload").focus();        
    });

    /*
    * Mensagem de Front end Cadastro
    * $idMsg: Recebe parâmetro o ID do label Message 
    * $message: Recebe como parâmetro um String com a Mensagem para o Usuário
    */
    function msgFront( $idMsg, $message ) {
        var msgAniver = $idMsg;
        $( msgAniver )
        .html("")
        .html( $message )
        .removeClass()
        .addClass("error")
        .show();
        setTimeout(function(){
          $( $idMsg ).hide();
        } , 5000);
    }
  
    /*
    * Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea, .registration-form select, .registration-form radio').on('focus', function() {
    	$(this).removeClass('input-error');
    });

    $('#boxRadio').removeClass("input-error");

    $("#boxDataConclusion").hide("slow");
    
    // next step
    $('.registration-form .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;

    	parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {

            if( $(this).val() == "") {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
            else{
                $(this).removeClass('input-error');
            }        

    	});

        var inputText = $( '#birth_date' ).val();
        if( inputText !== undefined ) {
            var msgBox = "#msgAniver";
            if (inputText == '') {
                $('#birth_date').addClass("input-error");
                next_step = false;
                var msgInvalida = "Informar Data Nascimento!!";
                msgFront( msgBox, msgInvalida );
            }
            else {
                var dataIngles = convertBREN( "#birth_date" ); // Variável recebe date EN
                var returnString = dataString( dataIngles ); // Variável recebe String dd/mm/YYYY
                var returnIdade = calculaIdade( returnString );
                if( returnIdade < 0 ) {
                    alert('Data Invalida');
                    $( '#birth_date' ).addClass( "input-error" );
                    next_step = false;                
                    var msgInvalida = "Data Informada Inválida";
                    msgFront( msgBox, msgInvalida );
                    document.getElementById( 'birth_date' ).value = ''; // Limpa o campo
                }
                else if ( returnIdade < 16 ) {
                    $( '#birth_date' ).addClass( "input-error" );
                    next_step = false;
                    var msgInvalida = "Idade Minima p/Cadastro 16 anos!";
                    msgFront( msgBox, msgInvalida );
                    document.getElementById( 'birth_date' ).value=''; // Limpa o campo                    
                }
                else {
                    $( '#birth_date' ).removeClass( 'input-error' );
                }
            }
        }

        //Validação Seleção radio Button Escopo Profissional
        //if ($('input[type="radio"][name="scope"]').prop("checked")) {
        if (! $("input[type='radio'][name='scope']").is(':checked') ) {
            alert('adiciona');
            $('#boxAniver').addClass( 'input-error' ); // Adiciona a Class Input-error
            next_step = false; //Desabilita o Button de Avançar o Formulário
        }
        else {
            alert('remove');
           $('#boxAniver').removeClass( 'input-error' ); // Remove a Claass Input-error
        }        

        if ( $('input[type="radio"][name="statusAcademic"]').prop("checked")){ //Verifica se o Radio Name addAcademic foi Selecionado
            alert('teste1');
            $.each($('input[type="radio"][name="statusAcademic"]'), function(id , val){ //Verifica qual dos Radio foi Selecionado
                alert('teste2');
                if($(val).is(":checked")){
                    status = $(val).val();
                    return false;
                };
            });
            $('#boxRadio').removeClass("input-error"); // Remove a Claass Input-error 
        }
        else {
            $('#boxRadio').addClass("input-error"); // Adiciona a Class Input-error
            next_step = false; //Desabilita o Button de Avançar o Formulário
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
    		parent_fieldset.fadeOut(400, function() {
	    		$(this).next().fadeIn();
	    	});
    	}
        else{
            successCorrect = "#msg-box3";
            $(successCorrect)
            .html("")
            .html(": ( Bhurrr! Não Foram Informadas <strong> Opções Obrigatórias </strong>.")
            .removeClass()
            .addClass("alertProfileIT alertRegister")
            .show();
            setTimeout(function(){
              $("#msg-box3").hide();
            } , 5000);
        }
    });

    /*
    * Função para habilitar/desabilitar
    * InputDate DataPicker de Conclusão da Formação
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
    
    // previous step
    $('.registration-form .btn-previous').on('click', function() {
    	$(this).parents('fieldset').fadeOut(400, function() {
    		$(this).prev().fadeIn();
    	});
    });
    
    // submit
    $('.registration-form').on('submit', function(e) {
    	
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
