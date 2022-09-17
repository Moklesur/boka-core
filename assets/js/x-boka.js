!(function ($) {
    "use strict";

    var BokaGlobal = function ($scope, $) {

        // Js Start
        $('[data-background]').each(function () {
            $(this).css('background-image', 'url(' + $(this).attr('data-background') + ')');
        });

        // Js End

    };

    $(window).on('elementor/frontend/init', function () {
        if (elementorFrontend.isEditMode()) {
            console.log('Elementor editor mod loaded');
            elementorFrontend.hooks.addAction('frontend/element_ready/global', BokaGlobal);

        } else {
            console.log('Elementor frontend mod loaded');
            elementorFrontend.hooks.addAction('frontend/element_ready/global', BokaGlobal);
            // elementorFrontend.hooks.addAction('frontend/element_ready/boka-banner.default', Bokavideo);
        }
    });
    console.log('addon js loaded');
})(jQuery);