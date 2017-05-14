/**/
/* on load event */
/**/
$(function()
{
	$('#tuner-switcher').on('click', function()
	{
		$('#tuner').toggleClass('tuner-visible');
	});
	
	$('#tuner').on('click', '.colors li', function()
	{
		$(this).addClass('active').siblings().removeClass('active');
		$('#foxin img').attr('src', 'images/' + $(this).data('color') + '/logo.png');
     	$('#fox_footer img').attr('src', 'images/' + $(this).data('color') + '/logofooter.png');
		$('head').append('<link rel="stylesheet" href="css/themes/color-' + $(this).data('color') + '.css">');
	});
	
	$('#tuner').on('click', '.layouts li', function()
	{
		$(this).addClass('active').siblings().removeClass('active');
		if( $(this).data('layout') == 'boxed' )
			$('.page').addClass('page-boxed');
		else
			$('.page').removeClass('page-boxed');
	});
});