  $(document).ready(function () {
    'use strict';

    $("#celular").inputmask({
        mask: ["(99) 99999-9999", "(99) 99999-9999", ],
        keepStatic: true
    });

    $(".numero").inputmask({
        mask: ["999", "99", ],
        keepStatic: true
    });

    $("#date_conclusion").inputmask({
        mask: ["99/99/9999", "99/99/9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });
    
    $("#schedule").inputmask({
        mask: ["99/99/9999", "99/99/9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#date_out").inputmask({
        mask: ["99/99/9999", "99/99/9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#date_entry").inputmask({
        mask: ["99/99/9999", "99/99/9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#birth_date").inputmask({
        mask: ["99/99/9999", "99/99/9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#birth").inputmask({
        mask: ["99/99/9999", "99/99/9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#cnpj").inputmask({
        mask: ["99.999.999/9999-99", "99.999.999/9999-99", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#cpf").inputmask({
        mask: ["999.999.999-99", "999.999.999-99", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#rg").inputmask({
        mask: ["99.999.999-9", "99.999.999-9", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#agencia").inputmask({
        mask: ["9999-9", "9999-9", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#conta").inputmask({
        mask: ["99.999-9", "99.999-9", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#zipcode").inputmask({
        mask: ["99999-999", "99999-999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#certificadoreservista").inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999", {
            placeholder: "teste",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#tituloeleitor").inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

    $("#passaporte").inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });

  });