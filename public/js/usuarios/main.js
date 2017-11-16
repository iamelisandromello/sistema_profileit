jQuery(function($){

var BRUSHED = window.BRUSHED || {};



/*============================================
Navbar
==============================================*/

BRUSHED.scroll = function(){
	$(window).scroll(function(){
		if($(window).scrollTop() <= 50) {
			$("#home-nav").removeClass("scroll");
	    } else {
	        $("#home-nav").addClass("scroll");
	    }
	});
}

/*============================================
Closes the Responsive Menu on Menu Item Click
==============================================*/
BRUSHED.colapse = function(){
	$('.navbar-collapse ul li a').click(function() {
	    $('.navbar-toggle:visible').click();
	});
}

/* ==================================================
	Scroll to Top
================================================== */

BRUSHED.scrollToTop = function(){
	var windowWidth = $(window).width(),
		didScroll = false;

	var $arrow = $('#back-to-top');

	$arrow.click(function(e) {
		$('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo' );
		e.preventDefault();
	})

	$(window).scroll(function() {
		didScroll = true;
	});

	setInterval(function() {
		if( didScroll ) {
			didScroll = false;

			if( $(window).scrollTop() > 1000 ) {
				$arrow.css('display', 'block');
			} else {
				$arrow.css('display', 'none');
			}
		}
	}, 250);
}


/* ==================================================
   Accordion
================================================== */

BRUSHED.accordion = function(){
	var accordion_trigger = $('.accordion-heading.accordionize');
	
	accordion_trigger.delegate('.accordion-toggle','click', function(event){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		   	$(this).addClass('inactive');
		}
		else{
		  	accordion_trigger.find('.active').addClass('inactive');          
		  	accordion_trigger.find('.active').removeClass('active');   
		  	$(this).removeClass('inactive');
		  	$(this).addClass('active');
	 	}
		event.preventDefault();
	});
}

/* ==================================================
   Toggle
================================================== */

BRUSHED.toggle = function(){
	var accordion_trigger_toggle = $('.accordion-heading.togglize');
	
	accordion_trigger_toggle.delegate('.accordion-toggle','click', function(event){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		   	$(this).addClass('inactive');
		}
		else{
		  	$(this).removeClass('inactive');
		  	$(this).addClass('active');
	 	}
		event.preventDefault();
	});
}

/* ==================================================
   Tooltip
================================================== */

BRUSHED.toolTip = function(){ 
    $('a[data-toggle=tooltip]').tooltip();
}



/*============================================
Flexslider for quotes
==============================================*/

BRUSHED.quote = function(){ 
	$('.quote-slider').flexslider({
		slideshowSpeed: 5000,
		useCSS: true,
		pauseOnAction: false, 
		pauseOnHover: true,
		directionNav: false,
		animation: 'slide'
	});
}


/*============================================
WOW animations
==============================================*/
BRUSHED.wow = function(){ 
	wow = new WOW(
    {
      offset:       200,          // default
      mobile: false
    }
  	)
  	wow.init();
}

/* ==================================================
	Init
================================================== */

$(document).ready(function(){
		
	// Preload the page with jPreLoader
	$('body').jpreLoader({
		splashID: "#jSplash",
		showSplash: true,
		showPercentage: true,
		autoClose: true,
		splashFunction: function() {
			$('#circle').delay(250).animate({'opacity' : 1}, 500, 'linear');
		}
	});
	BRUSHED.scroll();
	BRUSHED.colapse();
	BRUSHED.scrollToTop();
	BRUSHED.accordion();
	BRUSHED.toggle();
	BRUSHED.toolTip();
	BRUSHED.quote();
	BRUSHED.wow();
});


});
