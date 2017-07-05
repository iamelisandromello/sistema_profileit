  $(document).ready(function () {
    'use strict';

    window.academicRepeater = $('.academic-repeater').repeater({
      isFirstItemUndeletable: true,
      show: function () {
        console.log('academic show');
        $(this).slideDown();
      },
      hide: function (deleteElement) {
        console.log('academic delete');
        $(this).slideUp(deleteElement);
      },
    });

    window.courseRepeater = $('.course-repeater').repeater({
      isFirstItemUndeletable: true,
      show: function () {
        console.log('course show');
        $(this).slideDown();
      },
      hide: function (deleteElement) {
        console.log('course delete');
        $(this).slideUp(deleteElement);
      },
    });

    window.professionalRepeater = $('.professional-repeater').repeater({
      isFirstItemUndeletable: true,
      show: function () {
        console.log('professional show');
        $(this).slideDown();
      },
      hide: function (deleteElement) {
        console.log('professional delete');
        $(this).slideUp(deleteElement);
      },
    });

  });