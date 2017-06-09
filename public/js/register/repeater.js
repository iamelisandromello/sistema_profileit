window.onload = function () {

  $(document).ready(function () {
  
    $('.repeater-default').repeater();

    $('.repeater-custom-show-hide').repeater({
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