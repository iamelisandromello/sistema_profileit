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
   var geral = 0;
   var a = []; //criar array;
   var b = []; //criar array;
   var c = []; //criar array;
   var d = []; //criar array;
   var datasPicker = []; //criar array;
   var resume = []; // resumo final

   function msgFront( $idFront, $msg ) {
      target = $('#' + $idFront).closest('.sandbox-container');
      boxData = $("#msg");
      $(boxData)
      .html("")
      .html($msg)
      .show()
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
      msgFront( $idData, msgInvalida);
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
});
