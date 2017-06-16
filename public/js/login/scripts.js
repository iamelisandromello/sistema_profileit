
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch("/profileit/public/images/backgrounds/2.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });  
});
