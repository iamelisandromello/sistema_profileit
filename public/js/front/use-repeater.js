window.onload = function () {
  $(document).ready(function () {
    'use strict';

    $('.repeater-default').repeater();

    $('.repeater-custom-show-hide').repeater({
      defaultValues: {
        nivel: '1',
       domain: -1,
      },
      show: function () {
        $(this).slideDown();
      },
      hide: function (remove) {
        if(confirm('Are you sure you want to remove this item?')) {
          $(this).slideUp(remove);
        }
      }
    });
  });
}; //window.onload