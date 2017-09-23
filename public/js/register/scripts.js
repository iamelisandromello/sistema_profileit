
jQuery(document).ready(function() {
   var parent_fieldset;
   var msgRodape;
   var msgInvalida;
   var idFieldset;
   var target;
   var boxData;
   var radios;
   var myId;
   var temp;
   var target;
   var hoje = new Date();
   var datasPicker;
   var textsAreas;
   var dataIngles;
   var valorSelect = 0;
   var next_step = true;
   var radioStatus = true;
   var dataStatus = true;
   var radioAcademic = [];
   var a = []; //criar array;
   var b = []; //criar array;
   var c = []; //criar array;
   var d = []; //criar array;

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

   function msgTeste( $idFront, $msg ) {
      target = $('#' + $idFront).closest('.select_input');
      boxData = $(target).find('.msgFront');
      $(boxData)
      .html("")
      .html($msg)
      .show();
   }

   function msgTextarea( $idFront, $num ) {
      target = $('#' + $idFront).closest('.textareaInput');
      boxData = $(target).find('.msgFront');

      $(boxData)
      .html("")
      .html('seu texto tem ' + $num + ' caracteres')
      .show();

      if($num >= 10){
         $(boxData)
         .html("")
         .html('Seu texto tem ' + $num + ' caracteres de um limite de 10 Caracteres')
         .show();
      }
   }

   function msgFront( $idFront, $msg ) {
      target = $('#' + $idFront).closest('.sandbox-container');
      boxData = $(target).find('.msgFront');
      $(boxData)
      .html("")
      .html($msg)
      .show()
   }

   function msgRegister( $idFront, $msg ) {
      $('span[name="mensagem"').html('');
      $('span[name="mensagem"')
      .html($msg)
      .show();
      setTimeout(function(){
      $('span[name="mensagem"').hide();
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

   /*
   * Oculta as Mensagens de Front End após período programado
   * $idFieldset: recebe como parametro o ID do FieldSet de contexto
   * Busca div "msgFront" e oculta mensagem
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
      var dataTemp = $($dataBR ).val();   
      if (dataTemp == '') {
         dataEN = '';
      }
      else {
         var dataQuebrada = $($dataBR).val().split("/");
         var dataEN = new Date(dataQuebrada[2], dataQuebrada[1] - 1, dataQuebrada[0]); 
      }
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

   /* Retorna Names inputDate
   *  $idFieldset: Recebe o ID do fieldset do Step
   *  Retorna array com os ID's dos InputDatas
   */
   window.returnDatas = function($idFieldset) {
      var dataAcademic;
      var temp;
      var ctr = 0;
      $('#' + $idFieldset).find('.inputData').each(function() {
         temp = $(this).attr("id");
         if (!dataAcademic) {
            dataAcademic = temp;
            c[ctr] = dataAcademic;
            ctr = ctr + 1;
         }
         else if (temp != dataAcademic){
            dataAcademic = temp;
            c[ctr] =dataAcademic;
            ctr = ctr + 1;
         }
      });
      return c;
   }

   /* Retorna ID's de todos TextArea
   *  $idFieldset: Recebe o ID do fieldset do Step
   *  Retorna array com os ID's dos TextArea
   */
   window.returnTextArea = function($idFieldset) {
      var dataAcademic;
      var temp;
      var ctr = 0;
      $('#' + $idFieldset).find('textarea').each(function() {
         temp = $(this).attr("id");
         if (!dataAcademic) {
            dataAcademic = temp;
            d[ctr] = dataAcademic;
            ctr = ctr + 1;
         }
         else if (temp != dataAcademic){
            dataAcademic = temp;
            d[ctr] =dataAcademic;
            ctr = ctr + 1;
         }
      });
      return d;
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
            msgInvalida = "Informar Data!!";                
         }
         else {
            dataIngles = convertBREN( "#" + $idData ); // Variável recebe date EN
            if (dataIngles > hoje) {
               msgInvalida = "Data deve ser anterior a data atual!!";
               dataStatus = false;
               $("#" + $idData).addClass("input-error");
            }
            else {
               msgInvalida = "";
               $("#" + $idData).removeClass("input-error");
               dataStatus = true;
            }
         }
      }
      msgFront( $idData, msgInvalida );
      return dataStatus;    
   }

   /* Valida Periodo de Dats
   *  $idFieldset: Recebe o ID do fieldset do Step
   *  $idData: Recebe como parametro o ID do elemnto DataPicker
   *  retorna True ou False conforme validação da Data
   */
   window.validaPeriodo = function($idFieldset, $idEntry, $idOut) {
      var inputEntry = convertBREN( "#" + $idEntry ); // Variável recebe date EN
      var inputOut = convertBREN( "#" + $idOut ); // Variável recebe date EN
      var msgElemento;

      if( inputEntry !== undefined || inputOut !== undefined ) {
         if( inputEntry == '' || inputOut == '' ) {
            if( inputEntry == '') {
               $("#" + $idEntry).addClass("input-error");
               msgElemento = $idEntry;
            }
            else {
               $("#" + $idOut).addClass("input-error");
               msgElemento = $idOut;
            }
            dataStatus = false;
            msgInvalida = "Informar Data!!";                
         }
         else if (inputEntry > hoje) {
            msgInvalida = "Data de Entrada deve ser anterior a data atual!!";
            dataStatus = false;
            msgElemento = $idEntry;
            $("#" + $idEntry).addClass("input-error"); 
         }
         else if (inputEntry > inputOut) {
            msgInvalida = "Data de Entrada deve ser anterior a data de saída!!";
            dataStatus = false;
            msgElemento = $idOut;
            $("#" + $idEntry).addClass("input-error");  
         }
         else if (inputOut > hoje) {
            msgInvalida = "Data de Saída deve ser anterior a data atual!!";
            dataStatus = false;
            msgElemento = $idEntry;
            $("#" + $idEntry).addClass("input-error"); 
         }
         else {
            msgInvalida = "";
            dataStatus = true;
            msgElemento = $idEntry;
            $("#" + $idEntry).removeClass("input-error"); 
         }

      }
      msgFront( msgElemento, msgInvalida );
      return dataStatus;
   }

   window.validaText = function ($idText) {
      var textStatus = true;
      var num = $('#' + $idText).val().length;
      /*if(num>=10){
         $('#' + $idText).val($('#' + $idText).val().substring(0,9));
      }*/
      msgTextarea( $idText, num );
      if(num >= 10 || num < 1){
         $('#' + $idText).val($('#' + $idText).val().substring(0,9));
         textStatus = false;
      }
      return textStatus;
   }

   window.validaTextbkp = function ($idText) {
      var num = $('#' + $idText).val().length;
      // informo ao usuario quantos caracteres há no texto
      // $('#' + $idText).find('span[name="msgassignments"]').html('seu texto tem '+num+' caracteres');
      $('span[name="msgassignments"').html('seu texto tem '+num+' caracteres');
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

   // Validação dos Inputs do Form
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


      parent_fieldset.find('input[type="text"], input[type="password"], input[type="email"], textarea, select').each(function() {
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
      if (idFieldset == "stepPersonal") {
         //Validação de Seleção radioInput 
         var radioSegmento = window.validaRadio(idFieldset, 'scope');
         if (!radioSegmento) {
            next_step = false;
         }

         var inputText = $( '#birth_date' ).val();
         var idBirth = $( '#birth_date' ).attr("ID");
         if( inputText !== undefined ) {
            if (inputText == '') {
               $('#birth_date').addClass("input-error");
               next_step = false;
               msgInvalida = "Informar Data Nascimento!!";
               msgRegister( idBirth, msgInvalida );
            }
            else {
               var dataIngles = convertBREN( "#birth_date" ); // Variável recebe date EN
               var returnString = dataString( dataIngles ); // Variável recebe String dd/mm/YYYY
               var returnIdade = calculaIdade( returnString );
               if( returnIdade < 0 ) {
                  $( '#birth_date' ).addClass( "input-error" );
                  next_step = false;                
                  msgInvalida = "Data Informada Inválida";
                  msgRegister( idBirth, msgInvalida );
                  document.getElementById( 'birth_date' ).value = ''; // Limpa o campo
               }
               else if ( returnIdade < 16 ) {
                  $( '#birth_date' ).addClass( "input-error" );
                  next_step = false;
                  msgInvalida = "Idade Minima p/Cadastro 16 anos!";
                  msgRegister( idBirth, msgInvalida );
                  document.getElementById( 'birth_date' ).value=''; // Limpa o campo                    
               }
               else {
                  $('span[name="mensagem"').html('');
                  $( '#birth_date' ).removeClass( 'input-error' );
               }
            }// Validação de Data Informada
         }//Validação Data Vazia
      }// Final StepPersonal
      else if (idFieldset == "stepAcademic") {
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
         //Identifica todos os DatePicker e valida se Data Válida
         datasPicker = window.returnDatas(idFieldset);
         for (var i = 0; i < datasPicker.length; i++) {
            temp = window.validaData(idFieldset, datasPicker[i]);
            if (!temp) {next_step = false;}    
         }
         offMessage(idFieldset);//Função Ocultar Mensagens Front
      }
      else if (idFieldset == "stepProfessional") {
         //Identifica todos os DatePicker e valida se Data Válida
         datasPicker = window.returnDatas(idFieldset);
         for (var i = 0; i < datasPicker.length; i++) {
            temp = window.validaPeriodo(idFieldset, datasPicker[i], datasPicker[i+1]);
            if (!temp) {next_step = false;}
            i = i + 1;
         }

         //Identifica todos osTextArea 
         textsAreas = window.returnTextArea(idFieldset);
         for (var i = 0; i < textsAreas.length; i++) {
            //temp = window.validaData(idFieldset, textsAreas[i]);
            temp = window.validaText(textsAreas[i]);
            if (!temp) {next_step = false;}
            
         }
         offMessage(idFieldset);//Função Ocultar Mensagens Front
      }

      /*
      * Contole de Avanço e Validação de Erros
      *
      */
      if (! form.valid()) {
         if (next_step) { 
            next_step = false; //Desabilita o Button de Avançar o Formulário
            msgRodape = ": ( Ops! Dados com Formatos Incorretos <strong> nos Campos Indicados!</strong>.";
         }
         else {
            msgRodape = ": ( Bhurrr! Não Foram Informadas <strong> Opções Obrigatórias </strong>.";                
         }       
      }
      else {
         msgRodape = ": ( Bhurrr! Verifique <strong> Opções Obrigatórias </strong>.";
      }

      if( next_step ) {
         parent_fieldset.fadeOut(400, function() {
            $(this).next().fadeIn();
         });
      }
      else {
         var msg100 = "#msg-" + id;            
         msgValidacao( msg100, msgRodape );
      }      
      
      //Verifica se Step de Avanço está Habilitado
    	/*if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
	    		$(this).next().fadeIn();
	    	});
    	}*/

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
   //$('.registration-form').on('submit', function(e) {
   $('.registration-form .btn-finish').on('click', function(e) {   
      parent_fieldset = $(this).parents('fieldset');
      idFieldset = parent_fieldset.attr("id") 

    	parent_fieldset.find('input[type="text"], input[type="password"], select').each(function() {
         /*if (!$(this).hasClass("inputData")) { 
            if( $(this).val() == -1 ) {
               e.preventDefault();
        			$(this).addClass('input-error');
               msgInvalida = "Selecionar opção";
               msgTeste( $(this).attr("ID"), msgInvalida );
               offMessage(idFieldset);//Função Ocultar Mensagens Front
     		   }
     		   else {
     			   $(this).removeClass('input-error');
               document.getElementById("registration-form").submit();
     		   }
         }*/
         document.getElementById("registration-form").submit();
    	});
   });
});
