/**
 * Functionality specific to Bold Headline Theme.
 *
 * Creates the bigger headlines using FitText.js
 * More info about FitText can be found at http://fittextjs.com/
 */
	
jQuery(document).ready(function(){
	jQuery("h1").fitText(1.1, { minFontSize: '24px', maxFontSize: '36px'} );
	jQuery("h2").fitText(1.1, { minFontSize: '20px', maxFontSize: '30px'} );
	jQuery("h3").fitText(1.1, { minFontSize: '18px', maxFontSize: '24px'} );
	jQuery("h4").fitText(1.1, { minFontSize: '16px', maxFontSize: '20px'} );
	jQuery("h5").fitText(1.1, { minFontSize: '14px', maxFontSize: '18px'} );
	jQuery("h6").fitText(1.1, { minFontSize: '12px', maxFontSize: '16px'} );
	
	jQuery("h1.site-title").fitText(1.1, { minFontSize: '22px', maxFontSize: '90px' })
	jQuery("h1.menu-toggle").fitText(1.1, { minFontSize: '14px', maxFontSize: '22px' })
	jQuery("h2.site-description").fitText(1.1, { minFontSize: '12px', maxFontSize: '26px' });
	jQuery(".hentry h1").fitText(1.1, { minFontSize: '16px', maxFontSize: '50px' })
	jQuery(".page-title").fitText(1.1, { minFontSize: '16px', maxFontSize: '50px' })
});
	