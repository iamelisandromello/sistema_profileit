
jQuery(document).ready(function() {
	
  
    /*
        Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.quiz-form input[type="text"], .quiz-form input[type="password"], .quiz-form textarea, .quiz-form select, .quiz-form radio').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // next step
    $('.quiz-form .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;

        var validaRadio = "";

        // Verificando Radio Button
        $('.valida_teste').each(function(i){
            if ($(this).is(':checked')) {
                validaRadio = $(this).val();
            }
        });

        if(validaRadio == "") {
            $(this).addClass('input-error');
            next_step = false;
            alert( "RESPONDA TODOS." );
        }
        else{
            $(this).removeClass('input-error');
                        alert( "TODOS oK." );
        }
   	
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
	    		$(this).next().fadeIn();
	    	});
    	}
    	
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
