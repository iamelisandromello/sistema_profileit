$(document).ready(function () {
    'use strict';

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid",
    });
    
    jQuery.validator.addMethod("schedule1", function(value, element) {
      return this.optional(element) || /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/.test(value);
    }, "Formato de Data Inválido");
   
    jQuery.validator.addMethod("celular", function(value, element) {
      return this.optional(element) || /\([0-9]{2}\)[0-9]{4,6}-[0-9]{3,4}$/.test(value);
    }, "Celular com Formato Inválido Brasil");

    jQuery.validator.addMethod("phone", function(value, element) {
        return this.optional(element) || /\([0-9]{2}\)[0-9]{4,6}-[0-9]{3,4}$/.test(value);
    }, "Telefone Residencial com Formato Inválido Brasil");

    jQuery.validator.addMethod("password", function(value, element) {
        return this.optional(element) || /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/.test(value);
    }, "Regras de Complexidade: [Maiúsculas, Minúsculas & Números] ");

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

    
    window.validacao = function (){
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
                facebook: {
                    required: true,
                    usersocial: true
                },
                instagram: {
                    required: true,
                    usersocial: true
                },            
                twitter: {
                    required: true,
                    twitter: true
                },
                web: {
                    required: true,
                    web: true
                },
                password: {
                    required: true,
                    senha: true
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
                    required: "Digite corretamente seu nome ",
                    minlength: "Mínimo de caracteres permitidos 7",
                    maxlength: "Maxímo de caracteres permitidos 25"
                },
                last_name: {
                    required: "Digite corretamente seu nome ",
                    minlength: "Mínimo de caracteres permitidos 7",
                    maxlength: "Maxímo de caracteres permitidos 25"
                },
                institution: {
                    required: "Digite corretamente sua istituição de ensino",
                    minlength: "Mínimo de caracteres permitidos 7",
                    maxlength: "Maxímo de caracteres permitidos 25"
                },
                company: {
                    required: "Digite corretamente sua empresa",
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
                senha: {
                    required: "Digite corretamente sua senha"
                },            
                facebook: {
                    required: "Usuário facebook requerido"
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
            }//</Messages>
        });//<("#registration-form").validate()>
    }//<(/window.validaao())>
});;//<(document).ready(function ())>