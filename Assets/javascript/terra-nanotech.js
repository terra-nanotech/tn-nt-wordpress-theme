jQuery(document).ready(($) => {
    'use strict';

    /**
     * Extend links to external website.
     * » add target="_blank"
     * » add referrerpolicy="no-referrer"
     * » add rel="noopener noreferrer"
     */
    const externalLinks = () => {
        // Get the current location hostname
        const internalHost = [location.hostname];

        // Regex pattern to match HTTP and HTTPS
        const protocolPattern = /^https?:\/\//i;

        // Walk through all links on the current page.
        $('a').each((index, element) => { // jshint ignore:line
            // Get the href attribute of the link
            const href = $(element).attr('href');

            // Check if it's an HTTP link
            if (protocolPattern.test(href)) {
                // Get the hostname of the link
                const hrefHostname = $(new URL(href)).attr('hostname');

                // Check if the hostname is not in the internalHost array and add the target and classes and attributes to the link element.
                if ($.inArray(hrefHostname, internalHost) === -1) {
                    $(element).addClass('external-link');
                    $(element).attr('target', '_blank');
                    $(element).attr('rel', 'noopener noreferrer');
                    $(element).attr('referrerpolicy', 'no-referrer');
                }
            }
        });
    };

    /**
     * Inject a blurred background to the body.
     */
    const injectBlurBodyBackground = () => {
        $('<div class="blur-background"></div>').prependTo('body');
    };

    /**
     * Functions that need to be executed on successful ajax events.
     */
    $(document).ajaxSuccess(() => {
        externalLinks();
    });

    /**
     * Functions that need to be executed when the page is loaded.
     */
    (() => {
        injectBlurBodyBackground();
        externalLinks();

        console.log('Terra Nanotech JS: Loaded');
    })();
});
