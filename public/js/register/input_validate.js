$(document).ready(function () {
    'use strict';

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid",
    });
    
    jQuery.validator.addMethod("birth_date", function(value, element) {
      return this.optional(element) || /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/.test(value);
    }, "Formato de Data Inválido");
    
    jQuery.validator.addMethod("celular", function(value, element) {
      return this.optional(element) || /\([0-9]{2}\)[0-9]{4,6}-[0-9]{3,4}$/.test(value);
    }, "Celular com Formato Inválido Brasil");

    jQuery.validator.addMethod("phone", function(value, element) {
        return this.optional(element) || /\([0-9]{2}\)[0-9]{4,6}-[0-9]{3,4}$/.test(value);
    },  "Telefone Residencial com Formato Inválido Brasil");

    jQuery.validator.addMethod("senha", function(value, element) {
        return this.optional(element) || /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/.test(value);
    },  "Telefone Residencial com Formato Inválido Brasil");

    jQuery.validator.addMethod("letras", function(value, element) {
        return this.optional(element) || /^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÊÍÏÓÒÖÚÇÑ ]+$/.test(value);
    },  "Formato de Entrada Inválido");
    
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
                maxlength: 30,
                letras: true
            },
            institution: {
                required: true,
                minlength: 5,
                maxlength: 25
            },
            local: {
                required: true,
                minlength: 7,
                maxlength: 20
            },
            course: {
                required: true,
                minlength: 7,
                maxlength: 25
            },           
            conclusion_date : {
                required: true
            },
            birth_date : {
                required: true,
                birth_date: true
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
            phone: {
                required: true,
                phone: true
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
            senha: {
                required: true,
                senha: true
            },
            confirmaSenha: {
                required: true,
                equalTo: "#senha"
            },
            termos: {
                required: true
            },
            mensagem: {
                rangelength: [50, 1050],
            }
        },
        messages: {
            nome: {
                required: "Digite corretamente seu nome ",
                minlength: "Mínimo de caracteres permitidos 7",
                maxlength: "Maxímo de caracteres permitidos 25"
            },
            celular: {
                required: "Digite corretamente seu celular"
            },
            email: {
                required: "Bruh, that email address is invalid"
            },
            phone: {
                required: "Digite corretamente seu telefone"
            },
            birth_date: {
                required: "Informe Data de Nascimento"
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
            senha: {
                required: "Digite corretamente sua senha"
            },
            confirmaSenha: {
                equalTo: "Whoops, passwords do not match!"
            },
            termos: {
                required: "Por gentileza, aceite os termos para prosseguir"
            },
            mensagem: {
                required: "D",
                minlength: "Mínimo de caracteres permitidos 50",
                maxlength: "Maxímo de caracteres permitidos 1050"
            },
        }
    });
});;