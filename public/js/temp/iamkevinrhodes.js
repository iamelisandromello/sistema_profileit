$( document ).ready(function() {


	/*============================================
	Navbar
	==============================================*/

	$(window).scroll(function(){
		if($(window).scrollTop() <= 50) {
			$("#home-nav").removeClass("scroll");
	    } else {
	        $("#home-nav").addClass("scroll");
	    }
	});

   	/*============================================
	Closes the Responsive Menu on Menu Item Click
	==============================================*/

	$('.navbar-collapse ul li a').click(function() {
	    $('.navbar-toggle:visible').click();
	});

	/*============================================
	CSS-Tricks smooth-scrolling
	http://css-tricks.com/snippets/jquery/smooth-scrolling/
	==============================================*/

    // Scrolls to the selected menu item on the page
    $(function() {
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') || location.hostname === this.hostname) {

                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top-70	// Height of fixed nav
                    }, 1000);
                    return false;
                }
            }
        });
    });


});
