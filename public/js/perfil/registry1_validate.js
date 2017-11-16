$(document).ready(function () {
    'use strict';

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid",
    });

    jQuery.validator.addMethod("celular", function(value, element) {
        return this.optional(element) || /^(\(11\) [9][0-9]{4}-[0-9]{4})|(\(1[2-9]\) [5-9][0-9]{4}-[0-9]{4})|(\([2-9][1-9]\) [5-9][0-9]{4}-[0-9]{4})$/.test(value);
    }, "Hiii, número inválido no Brasil");

    jQuery.validator.addMethod("letras", function(value, element) {
        return this.optional(element) || /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÒÖÚÇÑ ]+$/.test(value);
    }, "Formato de Entrada Inválido");

   var form = $( "#form-registry" );

    $("#form-registry").validate({
        // FAZ A VALIDAÇÃO EM TEMPO REAL"
        onkeyup: function(element) {
            this.element(element);
        },
        onfocusout: function(element) {
            this.element(element);
        },
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 10
            },
            last_name: {
                required: true,
                minlength: 4,
                maxlength: 40
            },
            sobremim: {
                required: true,
                minlength: 3,
                maxlength: 500
            },
            celular: {
                required: true,
                celular: true
            },
            address: {
                required: true,
                rangelength: [10, 250]
            },
            state: {
                required: true,
                minlength: 2,
                maxlength: 2
            },
            city: {
                required: true,
                minlength: 4,
                maxlength: 25,
            },
            burgh: {
                required: true,
                minlength: 4,
                maxlength: 25,
            },
            zipcode: {
                required: true,
                minlength: 9,
                maxlength: 9
            }
        },
        messages: {
            name: {
                required: "ahhh! Nos diga seu nome",
                minlength: "Mínimo de 3 caracteres",
                maxlength: "Maxímo de 25 caracteres"
            },
            last_name: {
                required: "uhhh! Precisamos de seu Sobrenome",
                minlength: "Mínimo de 4 caracteres",
                maxlength: "Maxímo de 40 caracteres"
            },
            sobremim: {
                required: ";) Fale-nos um pouco sobre vc!",
                minlength: "Mínimo de 250 caracteres",
                maxlength: "Maxímo de 500 caracteres"
            },
            celular: {
                required: "Informe seu celular"
            },
            address: {
                required: "Digite corretamente seu endereço",
                minlength: "Mínimo de caracteres permitidos 10",
                maxlength: "Maxímo de caracteres permitidos 50"
            },
            city: {
                required: "Digite corretamente sua cidade",
                minlength: "Mínimo de caracteres permitidos 4",
                maxlength: "Maxímo de caracteres permitidos 25"
            },
            burgh: {
                required: "Digite corretamente seu Bairro",
                minlength: "Mínimo de caracteres permitidos 4",
                maxlength: "Maxímo de caracteres permitidos 25"
            },
            state: {
                required: "Digite corretamente seu estado",
                minlength: "Mínimo de caracteres permitidos 2",
                maxlength: "Maxímo de caracteres permitidos 2"
            },
            zipcode: {
                required: "Digite corretamente seu cep",
                minlength: "Mínimo de caracteres permitidos 9",
                maxlength: "Maxímo de caracteres permitidos 9"
            }
        }//</Messages>
    });//<("#form-regitry").validate()>

});//<(document).ready(function ())>