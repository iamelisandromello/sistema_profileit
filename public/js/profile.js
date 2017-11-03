
jQuery(document).ready(function() {

   function valSenior() {
      $("#requerimentoIngles").val("4");
      $("#requerimentoExperiencia").val("5");
      $("#requerimentoCertificacao").val("5");
      $("#requerimentoFormacao").val("5");
      $("#requerimentoStatusF").val("3");
      $("#requerimentoPos").val("2");
      $("#requerimentoStatusP").val("4");
      $("#requerimentoDominio").val("5");
      $("#requerimentoExchange").val("4");
      $("#requerimentoVirtualizacao").val("4");
      $("#requerimentoRoteadores").val("4");
      $("#requerimentoItil").val("4");
      $("#requerimentoAgile").val("4");
      $("#requerimentoProjetos").val("4");
      $("#requerimentoHabilitacao").val("4")
   }

   function valPleno() {
      $("#requerimentoIngles").val("3");
      $("#requerimentoExperiencia").val("4");
      $("#requerimentoCertificacao").val("4");
      $("#requerimentoFormacao").val("4");
      $("#requerimentoStatusF").val("3");
      $("#requerimentoPos").val("1");
      $("#requerimentoStatusP").val("1");
      $("#requerimentoDominio").val("4");
      $("#requerimentoExchange").val("3");
      $("#requerimentoVirtualizacao").val("3");
      $("#requerimentoRoteadores").val("3");
      $("#requerimentoItil").val("2");
      $("#requerimentoAgile").val("3");
      $("#requerimentoProjetos").val("3");
      $("#requerimentoHabilitacao").val("3")
   }

   function valJunior() {
      $("#requerimentoIngles").val("2");
      $("#requerimentoExperiencia").val("2");
      $("#requerimentoCertificacao").val("2");
      $("#requerimentoFormacao").val("3");
      $("#requerimentoStatusF").val("3");
      $("#requerimentoPos").val("1");
      $("#requerimentoStatusP").val("1");
      $("#requerimentoDominio").val("3");
      $("#requerimentoExchange").val("2");
      $("#requerimentoVirtualizacao").val("2");
      $("#requerimentoRoteadores").val("2");
      $("#requerimentoItil").val("1");
      $("#requerimentoAgile").val("1");
      $("#requerimentoProjetos").val("1");
      $("#requerimentoHabilitacao").val("2");
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
