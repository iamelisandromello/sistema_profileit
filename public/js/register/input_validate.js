$(document).ready(function () {
    'use strict';

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid",
    });

    jQuery.validator.addMethod("celular", function(value, element) {
        return this.optional(element) || /^(\(11\) [9][0-9]{4}-[0-9]{4})|(\(1[2-9]\) [5-9][0-9]{4}-[0-9]{4})|(\([2-9][1-9]\) [5-9][0-9]{4}-[0-9]{4})$/.test(value);
    }, "Hiii, número inválido no Brasil");

    jQuery.validator.addMethod("password", function(value, element) {
        return this.optional(element) || /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/.test(value);
    }, "Maiúsculas, Minúsculas & Números");

    jQuery.validator.addMethod("letras", function(value, element) {
        return this.optional(element) || /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÒÖÚÇÑ ]+$/.test(value);
    }, "Formato de Entrada Inválido");

    jQuery.validator.addMethod("usersocial", function(value, element) {
        return this.optional(element) || /^[a-z\d\.]{5,}$/.test(value);
    }, "Formato de Usuario invalido!!!");

    jQuery.validator.addMethod("twitter", function(value, element) {
        return this.optional(element) || /^[a-z\d\.]{5,}$/.test(value);
    }, "Infome um usuário válido Twitter");

    jQuery.validator.addMethod("web", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/.test(value);
    }, "Infome um Dominio Válido");

   var form = $( "#registration-form" );

    $("#registration-form").validate({
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
                maxlength: 10,
                letras: true
            },
            last_name: {
                required: true,
                minlength: 4,
                maxlength: 40,
                letras: true
            },
            about: {
                required: true,
                minlength: 3,
                maxlength: 500
            },
            institution: {
                required: true,
                minlength: 5,
                maxlength: 25
            },
            company: {
                required: true,
                minlength: 5,
                maxlength: 25
            },
            local: {
                required: true,
                minlength: 7,
                maxlength: 20,
                letras: true
            },
            date_entry : {
                required: true,
                schedule1: true
            },
            date_out : {
                required: true,
                schedule1: true
            },
            username: {
                required: true,
                minlength: 8,
                maxlength: 15
            },
            email: {
                required: true,
                email: true,
                minlength: 10
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
            beighborhood: {
                required: true,
                minlength: 4,
                maxlength: 25,
            },
            zipcode: {
                required: true,
                minlength: 9,
                maxlength: 9
            },
            facebook: {
                required: true,
                usersocial: true
            },
            linkedin: {
                required: true,
                usersocial: true
            },
            instagram: {
                usersocial: true
            },
            twitter: {
                twitter: true
            },
            web: {
                web: true
            },
            password: {
                required: true
            },
            confirmPassword: {
                required: true,
                equalTo: "#password"
            },
            termos: {
                required: true
            },
            mensagem: {
                rangelength: [50, 1050],
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
            about: {
                required: ";) Fale-nos um pouco sobre vc!",
                minlength: "Mínimo de 250 caracteres",
                maxlength: "Maxímo de 500 caracteres"
            },
            institution: {
                required: "Nos conte aonde eestudou!",
                minlength: "Mínimo de 7 caracteres",
                maxlength: "Maxímo de 25 caracteres"
            },
            company: {
                required: "Digite corretamente sua empresa",
                minlength: "Mínimo de caracteres permitidos 7",
                maxlength: "Maxímo de caracteres permitidos 25"
            },
            celular: {
                required: "Informe seu celular"
            },
            email: {
                required: "Bruh, informe um endereço de e-mail válido"
            },
            date_out: {
                required: "Informe Data de Saída"
            },
            date_entry: {
                required: "Informe Data de Admissão"
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
            beighborhood: {
                required: "Digite corretamente sua cidade",
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
            },
            username: {
                required: "Digite corretamente seu nome de usuário",
                minlength: "Mínimo de caracteres permitidos 8",
                maxlength: "Maxímo de caracteres permitidos 15"
            },
            password: {
                required: "Defina senha de acesso!"
            },
            facebook: {
                required: "Usuário Facebook requerido"
            },
            linkedin: {
                required: "Usuário LinkedIn requerido"
            },
            twitter: {
                required: "Usuário Twitter requerido"
            },
            instagram: {
                required: "Usuário Instagram requerido"
            },
            web: {
                required: "Dominio Web requerido"
            },
            confirmPassword: {
                equalTo: "Whoops, senhas não são idênticas"
            },
            termos: {
                required: "Por gentileza, aceite os termos para prosseguir"
            },
            mensagem: {
                required: "D",
                minlength: "Mínimo de caracteres permitidos 50",
                maxlength: "Maxímo de caracteres permitidos 1050"
            },
        }//</Messages>
    });//<("#registration-form").validate()>

});//<(document).ready(function ())>