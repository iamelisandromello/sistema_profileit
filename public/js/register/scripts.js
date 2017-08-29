
jQuery(document).ready(function() {
	
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
        Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea, .registration-form select, .registration-form radio').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
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

        //Validação Seleção radio Button
        if ( $('input[type="radio"][name="scope"]').is(':checked') ){ //Verifica se o Radio Name Scope foi Selecionado
            $.each($('input[type="radio"][name="scope"]'), function(id , val){ //Verifica qual dos Radio foi Selecionado
                if($(val).is(":checked")){
                    status = $(val).val();
                    return false;
                };
            });
            $('#boxRadio').removeClass('input-error'); // Remove a Claass Input-error 
        }
        else {
            $('#boxRadio').addClass("input-error"); // Adiciona a Class Input-error
            next_step = false; //Desabilita o Button de Avançar o Formulário
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
            .html("Não Foram Selecionados as <strong> Opções Obrigatórias </strong>.")
            .removeClass()
            .addClass("alertProfileIT alertRegister")
            .show();
            setTimeout(function(){
              $("#msg-box3").hide();
            } , 5000);

        }
    	
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
