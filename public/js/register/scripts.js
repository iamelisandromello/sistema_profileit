
jQuery(document).ready(function() {
    var parent_fieldset;
    var idFieldset;
    var target;
    var boxData;
    var radios;
    var myId;
    var temp;
    var target;
    var hoje = new Date();
    var datasPicker;
    var dataIngles;
    var valorSelect = 0;
    var next_step = true;
    var radioStatus = true;
    var dataStatus = true;
    var radioAcademic = [];
    var a = []; //criar array;
    var b = []; //criar array;
    var c = []; //criar array;

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

    function msgFront( $idFront, $msg ) {
        target = $('#' + $idFront).closest('.sandbox-container');
        boxData = $(target).find('.msgFront');
        $(boxData)
        .html("")
        .html($msg)
        .removeClass()
        .addClass("error")
        .show();
    }

    /*
    * Converte formato de Data BR para ENdiv
    * $dataBR: recebe como parametro uma string com o ID do elemento dataPicker
    * return objeto date formato EN
    */
    function offMessage ($idFieldset) {
        setTimeout(function(){
            $('#' + $idFieldset).find('div [name="msgFront"]').each(function() {
                $(this).hide();
            });
        } , 5000);
    }

    /*
    * Converte formato de Data BR para ENdiv
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

    /* Retorna Names Radios
    *  $idFieldset: Recebe o ID do fieldset do Step
    *  Retorna array com os Names dos InputRadio
    */
    window.returnRadios = function($idFieldset) {
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

    /* Valida InputRadio
    *  $idFieldset: Recebe o ID do fieldset do Step
    *  $idName: Recebe comoparametro o Name do conjunto RadioInput
    *  retorna True ou False se existe radio selecionado
    */
    window.validaRadio = function($idFieldset, $idName) {    
        jQuery("#" + $idFieldset + " input[type='radio'][name='" + $idName + "']").each(function(id , val) {  //Percorre os Radios da área informada (#StepACademic)
            target = $(this).attr("id");// Captura como alvo o id do primeiro inputRadio do conjunto
            if ( ! $('input[type="radio"][name="' + $idName + '"]').is(':checked') ) {
                radioStatus = false; //
            }
            else if ( $('input[type="radio"][name="' + $idName + '"]').is(':checked') ) {
                if($(val).is(":checked")){
                    radioStatus = $(val).val();
                    return false;
                };
            }
        });
        //Se Nenhum radio foi selecionado no conjunto add input-error
        if (!radioStatus) {
            $("#" + target).closest('.boxRadio').addClass( 'input-error' );
        }
        else {
            $("#" + target).closest('.boxRadio').removeClass( 'input-error' );
        }
        return radioStatus;
    }

    /* Retorna Names inputDate
    *  $idFieldset: Recebe o ID do fieldset do Step
    *  Retorna array com os Names dos InputDatas
    */
    window.returnDatas = function($idFieldset) {
        var dataAcademic;
        var temp;
        var ctr = 0;
        $('#' + $idFieldset).find('.inputData').each(function() {
            temp = $(this).attr("id");
            if (!dataAcademic) {
               dataoAcademic = temp;
                c[ctr] =dataoAcademic;
                ctr = ctr + 1;
            }
            else if (temp !=dataoAcademic){
               dataoAcademic = temp;
                c[ctr] =dataoAcademic;
                ctr = ctr + 1;
            }
        });
        return c;
    }

    /* Valida InputData
    *  $idFieldset: Recebe o ID do fieldset do Step
    *  $idData: Recebe como parametro o ID do elemnto DataPicker
    *  retorna True ou False conforme validação da Data
    */
    window.validaData = function($idFieldset, $idData) {
        var inputText = $( "#" + $idData ).val();
        if( inputText !== undefined ) {
            if (inputText == '') {
                $("#" + $idData).addClass("input-error");
                dataStatus = false;
                var msgInvalida = "Informar Data!!";                
            }
            else {
                dataIngles = convertBREN( "#" + $idData ); // Variável recebe date EN
                if (dataIngles > hoje) {
                    var msgInvalida = "Data deve ser anterior a data atual!!";
                    dataStatus = false;
                    $("#" + $idData).addClass("input-error");
                }
                else {
                    $("#" + $idData).removeClass("input-error");
                    dataStatus = true;
                }
            }
        }
        msgFront( $idData, msgInvalida );

        return dataStatus;    
    }

    window.validaText = function ($idText) {
        var num = $('#' + $idText).val().length;
        // informo ao usuario quantos caracteres há no texto
        $('#' + $idText).find('span[name="msgAbout"]').html('seu texto tem '+num+' caracteres');
        //$('span[name="msgAbout"').html('seu texto tem '+num+' caracteres');
        //se os caracteres for maior ou igual a 10
        // entao atingiu o número maximo de caracteres pemitido
        if(num>=10){
            
            $('b').show().html('você atingiu o número máximo de caracteres '+num+' / 10');
            //trava o textarea
            $('#' + $idText).val($('#' + $idText).val().substring(0,9));
        }
        else{
        // se ainda nao for maior ou igual a 10 escondo o b, assim o texto nao aparece na hora errada =)
        $('b').hide();
        }
    }

    // just for the demos, avoids form submit
    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });
    var form = $( "#registration-form" );
    form.validate();

    /*
        Formulario de Cadastro <registration-form>
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea, .registration-form select, .registration-form radio').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // next step
    $('.registration-form .btn-next').on('click', function() {
    	parent_fieldset = $(this).parents('fieldset');
    	next_step = true;
        var id = $(this).attr("id"); // captura o ID do Button Step
        idFieldset = parent_fieldset.attr("id")


    	parent_fieldset.find('input[type="text"], input[type="password"], input[teypw="textarea"], select').each(function() {
            if (!$(this).hasClass("inputData")) {            
                if( $(this).val() == "" || $(this).val() === "-1") {
                    $(this).addClass('input-error');
                    next_step = false;
                }
                else{
                    $(this).removeClass('input-error');
                }
            }
    	});
        if (idFieldset == "stepAcademic") {
            alert('passo 5');
            //Identifica todos os Radios e valida se opções foram selecionada
            radios = window.returnRadios(idFieldset);
            for (var i = 0; i < radios.length; i++) {
                radioAcademic[i] = window.validaRadio(idFieldset, radios[i]);
                if (!radioAcademic[i]) {
                    next_step = false;
                }
            }

            //Identifica todos os DatePicker e valida se Data Válida
            datasPicker = window.returnDatas(idFieldset);
            for (var i = 0; i < datasPicker.length; i++) {
                temp = window.validaData(idFieldset, datasPicker[i]);
                if (radioAcademic[i] != 1 && radioAcademic[i] != false ) {
                    $(datasPicker[i]).removeClass("input-error");
                    $(datasPicker[i]).datepicker('setDate', null);
                }
                else {
                    if (!temp) {next_step = false;}    
                }
            }
            offMessage(idFieldset);//Função Ocultar Mensagens Front
        }//Final StepAcademic
        else if (idFieldset == "stepCourse") {

            alert('passo 6');
            //Identifica todos os DatePicker e valida se Data Válida
            datasPicker = window.returnDatas(idFieldset);
            for (var i = 0; i < datasPicker.length; i++) {
                temp = window.validaData(idFieldset, datasPicker[i]);
                 if (!temp) {next_step = false;}    
            }
            offMessage(idFieldset);//Função Ocultar Mensagens Front
        }
        else if (idFieldset == "stepProfessional") {
            alert('passo 7');
            //Identifica todos os DatePicker e valida se Data Válida
            datasPicker = window.returnDatas(idFieldset);
            for (var i = 0; i < datasPicker.length; i++) {
                temp = window.validaData(idFieldset, datasPicker[i]);
                 if (!temp) {next_step = false;}    
            }
            offMessage(idFieldset);//Função Ocultar Mensagens Front
        }        

        //Verifica se Step de Avanço está Habilitado
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
	    		$(this).next().fadeIn();
	    	});
    	}

    });

    $('.form-about-yourself').keyup(function(){
        // crio uma variavel que seleciona os caracteres dentro do textarea
        var idTextArea = ($(this).attr("id"));
        validaText(idTextArea);
    });


    /*
    * Função para habilitar/desabilitar
    * InputDate DataPicker de Conclusão da Formação
    */
    $( ".not_enabled" ).on( "click", function() {
        target = $(this).closest('.wraper_conclusion');
        boxData = $(target).find('#boxDataConclusion');
        $(boxData).hide("slow");
    }); 

    $( ".yes_enabled" ).on( "click", function() {
        target = $(this).closest('.wraper_conclusion');
        boxData = $(target).find('#boxDataConclusion');
        $(boxData).show(1000);
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
            if (!$(this).hasClass("inputData")) { 
                if( $(this).val() == "" ) {
        			e.preventDefault();
        			$(this).addClass('input-error');
        		}
        		else {
        			$(this).removeClass('input-error');
        		}
            }
    	});
    });
    
    
});
