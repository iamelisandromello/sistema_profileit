/* ========================================= */
/* $TABLE OF CONTENTS                        */
/* ========================================= */

/*

	> $CONDITIONAL LOADERS

		> #WOW PLUGIN
		> #STELLAR
		> #FASTCLICK PLUGIN
		> #SMOOTHWHEEL

	> $PRELOADER
	> $FULLSCREEN SECTION
	> $NAVIGATION

		> #STICKY NAVBAR
		> #SMOOTH SCROLL

	> $TIMELINE LOADER
	> $MILESTONES COUNTERUP
	> $PORTFOLIO 

		> #SHUFFLE
		> #LIGHTBOX
		> #SHOW MORE ITEMS
	
	> $RSLIDES
	> $FITVIDS
	> $TESTIMONIALS ROTATOR
	> $CONTACT FORMS

*/

jQuery(document).ready
(
	function ($) 
	{
		'use strict';

		/* ========================================= */
		/* $TIMELINE LOADER                          */
		/* ========================================= */

		var timeline = $('.timeline');

		timeline.each
		(
			function ()
			{
				var $self = $(this),
					 relatedShowMoreBtn = $self.find('.timeline-loader-btn'),
					 relatedItems = $self.find('.timeline-item'),
					 relatedHiddenItems = relatedItems.filter(':hidden'),
					 numberOfRelatedHiddenItems = relatedHiddenItems.length;

				if ( numberOfRelatedHiddenItems !== 0 ) 
				{
					// if there are hidden items then
					// on show more button show all the hidden items
					// in the current timeline
					relatedShowMoreBtn.on
					(
						'click',
						function (event)
						{
							event.preventDefault();

							// show hidden items
							relatedHiddenItems.removeClass('hidden');

							// hide show more button
							relatedShowMoreBtn.hide();
						}
					);
				}

				else
				{
					// hide more button if there are no items
					// to show on page load
					relatedShowMoreBtn.hide();
				}
			}
		);
	}
);