/**
 * Start cookie consent widget script
 */

( function( $, elementor ) {

	'use strict';

	var widgetCookieConsent = function( $scope, $ ) {

		var $cookieConsent = $scope.find('.bdt-cookie-consent'),
            $settings      = $cookieConsent.data('settings'),
            editMode       = Boolean( elementorFrontend.isEditMode() ),
			gtagSettings   = $cookieConsent.data('gtag');
        
        if ( ! $cookieConsent.length || editMode ) {
            return;
        }

        window.cookieconsent.initialise($settings);

		$('.cc-compliance').append(
			`<button class="bdt-cc-close-btn cc-btn cc-dismiss">
				<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
				<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
				</svg>
		   </button>`
		);

		/**
		 * gtag consent update
		 */
		if( gtagSettings === undefined ) {
			return;
		}

		if (true !== gtagSettings.gtag_enabled) {
			return;
		}

		function consentGrantedAdStorage($args) {
			gtag('consent', 'update', $args);
		}
		
		let gtag_attr_obj = {
			'ad_user_data': gtagSettings.ad_user_data,
			'ad_personalization': gtagSettings.ad_personalization,
			'ad_storage': gtagSettings.ad_storage,
			'analytics_storage': gtagSettings.analytics_storage,
		};

		$('.cc-btn.cc-dismiss').on('click', function() {
			consentGrantedAdStorage(gtag_attr_obj);
		});

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/bdt-cookie-consent.default', widgetCookieConsent );
	});

}( jQuery, window.elementorFrontend ) );

/**
 * End cookie consent widget script
 */

