    
jQuery(document).ready(function() {
   'use strict';
    var status;
    var msgInvalida;
    var idFieldset;
    var testeradio;
    var a = []; //criar array;
    var b = []; //criar array;

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

    /*
    * Mensagem de Front end Cadastro
    * $idMsg: Recebe parâmetro o ID do label Message 
    * $message: Recebe como parâmetro um String com a Mensagem para o Usuário
    */
    function msgFront( $idFront, $msg ) {
        var mensagemF = $idFront;
        $(mensagemF)
        .html("")
        .html($msg)
        .removeClass()
        .addClass("error")
        .show();
        setTimeout(function(){
          $(mensagemF).hide();
        } , 5000);
    }

    function msgValidacao ( $idMsg, $message ) {
        var msgValida = $idMsg;
        $( msgValida )
        .html("")
        .html( $message )
        .removeClass()
        .addClass("alertProfileIT alertRegister")
        .show();
        setTimeout(function(){
          $( $idMsg ).hide();
        } , 5000);
    }

    /* Valida SelectBox
    *  $idFieldset: Recebe o ID do fieldset do Step
    *  retorna a opção selecionada, ou undefined
    */
    window.validaSelect = function($idFieldset, $idName) {
        alert('idFieldSet: ' + $idFieldset + ' Name: ' + $idName);
        jQuery("#" + idFieldset + " input[type='radio']").each(function() {  //Percorre os Radios da área informada (#StepACademic)
            alert('entrou no each');
            if ( ! $('input[type="radio"][name="' + $idName + '"]').is(':checked')  ) {
                alert('Não selecionado');
                $('#boxAniver').addClass( 'input-error' ); // Adiciona a Class Input-error
                next_step = false; //Desabilita o Button de Avançar o Formulário
            }
            else {
               alert('selecionado');
               $('#boxAniver').removeClass( 'input-error' ); // Remove a Claass Input-error
            }
        });
        return next_step;

    }

    window.returnName = function($idFieldset) {
        var selectAcademic;
        var valorSelect;
        $('#' + $idFieldset).find('select').each(function(id, val) {
            selectAcademic = $(this).attr("name"); 
            if(selectAcademic){
                return false;
            };
        });
        return selectAcademic;
    }

    window.returnSelects = function($idFieldset) {
        var selectAcademic;
        var temp;
        var ctr = 0;

        $('#' + $idFieldset).find('select').each(function() {
            temp = $(this).attr("name");
            
            if (!selectAcademic) {
                selectAcademic = temp;
                a[0] = selectAcademic;
                ctr = ctr + 1;
            }
            else if (temp != selectAcademic){
                selectAcademic = temp;
                a[ctr] = selectAcademic;
                ctr = ctr + 1;
            }
        });
        return a;
    }

    window.returnRadios= function($idFieldset) {
        var radioAcademic;
        var temp;
        var ctr = 0;

        $('#' + $idFieldset).find('input[type="radio"]').each(function() {
            temp = $(this).attr("name");
            
            if (!radioAcademic) {
                radioAcademic = temp;
                b[ctr] = radioAcademic;
                ctr = ctr + 1;
            }
            else if (temp != radioAcademic){
                radioAcademic = temp;
                b[ctr] = radioAcademic;
                ctr = ctr + 1;
            }
        });
        return b;
    }

    window.contaElementos = function($idFieldset) {
        var cont = 0;
        $('#' + $idFieldset).find('select').each(function() {
            cont = cont +1;
        });
        return cont;
    }

  
    /*
    * Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea, .registration-form select, .registration-form radio').on('focus', function() {
    	$(this).removeClass('input-error');
    });

    $('#boxAniver').removeClass("input-error");

    $("#boxDataConclusion").hide("slow");

    // just for the demos, avoids form submit
    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });
    var form = $( "#registration-form" );
    form.validate();

    /*form.validate({ // initialize the plugin
        rules: {
            selectAcademic: {
                selectcheck: true
            }
        }
    });

    jQuery.validator.addMethod('selectcheck', function (value) {
        return (value != '-1');
    }, "Selecione uma Opção ");*/

    
    // next step
    $('.registration-form .btn-next').on('click', function() {
    	var id = $(this).attr("id"); // captura o ID do Button Step
        var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
        idFieldset = parent_fieldset.attr("id")

    	parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {

            if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
            else{
                $(this).removeClass('input-error');
            }    

    	});

        if (idFieldset == "stepPersonal") {
            alert('passo 1');
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

            //if (! $('input[type="radio"][name="scope"]').prop("checked") ) {
            if (! $("input[type='radio'][name='scope']").is(':checked') ) {
                $('#boxAniver').addClass( 'input-error' ); // Adiciona a Class Input-error
                next_step = false; //Desabilita o Button de Avançar o Formulário
            }
            else {
               $('#boxAniver').removeClass( 'input-error' ); // Remove a Claass Input-error
            }

        }
        
        /*
        * Contole de Avanço e Validação de Erros
        *
        */

        if (! form.valid()) {
            if (next_step) { 
                next_step = false; //Desabilita o Button de Avançar o Formulário
                msgInvalida = ": ( Ops! Dados com Formatos Incorretos <strong> nos Campos Indicados!</strong>.";
            }
            else {
                msgInvalida = ": ( Bhurrr! Não Foram Informadas <strong> Opções Obrigatórias </strong>.";                
            }       
        }

        if( next_step ) {
        	parent_fieldset.fadeOut(400, function() {
	    		$(this).next().fadeIn();
	    	});
    	}
        else {
            var msg100 = "#msg-" + id;            
            msgValidacao( msg100, msgInvalida );
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
