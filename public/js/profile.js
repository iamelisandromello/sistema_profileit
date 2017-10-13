
jQuery(document).ready(function() {
  
   function valSenior() {
      $("#requerimentoFormacao").val("1");
      $("#requerimentoStatusF").val("1");
      $("#requerimentoPos").val("4");
      $("#requerimentoStatusP").val("1");
      $("#requerimentoInglês").val("1");
      $("#requerimentoExperiencia").val("1");
      $("#requerimentoDominio").val("1");
      $("#requerimentoCertificacao").val("1");
      $("#requerimentoExchange").val("1");
      $("#requerimentoVirtualizacao").val("1");
      $("#requerimentoRoteadores").val("1");
      $("#requerimentoItil").val("1");
      $("#requerimentoAgile").val("1");
      $("#requerimentoProjetos").val("1");
      $("#requerimentoHabilitacao").val("1");
   }

   function valPleno() {
      $("#requerimentoFormacao").val("2");
      $("#requerimentoStatusF").val("1");
      $("#requerimentoPos").val("5");
      $("#requerimentoStatusP").val("4");
      $("#requerimentoInglês").val("2");
      $("#requerimentoExperiencia").val("2");
      $("#requerimentoDominio").val("2");
      $("#requerimentoCertificacao").val("2");
      $("#requerimentoExchange").val("2");
      $("#requerimentoVirtualizacao").val("2");
      $("#requerimentoRoteadores").val("2");
      $("#requerimentoItil").val("4");
      $("#requerimentoAgile").val("2");
      $("#requerimentoProjetos").val("2");
      $("#requerimentoHabilitacao").val("2");
   }

   function valJunior() {
      $("#requerimentoFormacao").val("3");
      $("#requerimentoStatusF").val("1");
      $("#requerimentoPos").val("5");
      $("#requerimentoStatusP").val("4");
      $("#requerimentoInglês").val("3");
      $("#requerimentoExperiencia").val("4");
      $("#requerimentoDominio").val("3");
      $("#requerimentoCertificacao").val("5");
      $("#requerimentoExchange").val("3");
      $("#requerimentoVirtualizacao").val("3");
      $("#requerimentoRoteadores").val("3");
      $("#requerimentoItil").val("5");
      $("#requerimentoAgile").val("4");
      $("#requerimentoProjetos").val("4");
      $("#requerimentoHabilitacao").val("3");
   }

   $( "#btnAddVaga" ).on( "click", function() {
      $('input:radio[name="checkboxProfile"][value="1"]').attr("checked",false);
      $('input:radio[name="checkboxProfile"][value="2"]').attr("checked",false);
      $('input:radio[name="checkboxProfile"][value="3"]').attr("checked",false);
      $('input:radio[name="checkboxProfile"][value="3"]').attr("checked",true);
      valJunior();
   });

   /*
   * Função para definir Perfil da Nova Vaga
   *
   */
   $( ".senior" ).on( "click", function() {
      valSenior();
   });

   $( ".pleno" ).on( "click", function() {
      valPleno();
   });

   $( ".junior" ).on( "click", function() {
      valJunior();
   });

});
