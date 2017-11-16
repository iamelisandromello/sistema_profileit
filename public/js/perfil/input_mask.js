$(document).ready(function () {
   'use strict';

   $("#celular").inputmask({
      mask: ["(99) 99999-9999", "(99) 99999-9999", ],
      keepStatic: true
   });

/*    $(".numero").inputmask({
        mask: ["999", "99", "9", {
            placeholder: "",
            clearMaskOnLostFocus: true
        }],
        keepStatic: true
    });*/
   $("#zipcode").inputmask({
      mask: ["99999-999", "99999-999", {
         placeholder: "",
         clearMaskOnLostFocus: true
      }],
       keepStatic: true
   });

  });