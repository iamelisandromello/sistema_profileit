$(document).ready(function () {
    jQuery.validator.setDefaults({
      debug: false
    });

    $( "#testeformulario" ).validate({
      rules: {
        city: {
          required: true
        }
      }
    });

/*
var validator = $( "#form-registry" ).validate();
validator.form();
*/


});//<(document).ready(function ())>