
jQuery(document).ready(function() {
   var msgRodape;
   var conf = true;

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
        Form de Inclusaõ de Perfil de Competências
   */
   $('.registration-skill input[type="text"], .registration-skill input[type="password"], .registration-skill textarea').on('focus', function() {
    	$(this).removeClass('input-error');
   });


   // submit
   $('.registration-skill').on('submit', function(e) {

      $(this).find('input[type="text"], input[type="password"], select, textarea').each(function() {
         if( $(this).val() == "" || $(this).val() < 0 ) {
            e.preventDefault();
             $(this).addClass('input-error');
             conf = false;
         }
         else {
            $(this).removeClass('input-error');
         }
      });
      if (!conf) {
         msgRodape = ": ( Bhurrr! Não Foram Informadas <strong> Opções Obrigatórias </strong>.";
         msgValidacao( "#msg-alert", msgRodape );
      }

   });

   /*
   *  Form de Inclusaõ de Perfil de Competências
   */
   $('.registration-preference input[type="text"], .registration-preference input[type="password"], .registration-preference textarea').on('focus', function() {
      $(this).removeClass('input-error');
   });


   // submit
   $('.registration-preference').on('submit', function(e) {

      $(this).find('input[type="text"], input[type="password"], select, textarea').each(function() {
         if( $(this).val() == "" || $(this).val() <= 0 ) {
            e.preventDefault();
             $(this).addClass('input-error');
             conf = false;
         }
         else {
            $(this).removeClass('input-error');
         }
      });
      if (!conf) {
         msgRodape = ": ( Bhurrr! Não Foram Informadas <strong> Opções Obrigatórias </strong>.";
         msgValidacao( "#msg-preference", msgRodape );
      }

   });
});
