/* global ResponsiveToolkit, Masonry */

(($, viewport) => {
    'use strict';

    $(document).ready(() => {
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

                    // Check if the hostname is not in the internalHost array or if the link has the class 'external-link',
                    // and add the target and classes and attributes to the link element.
                    if (
                        // Check if the hostname is not in the internalHost array
                        $.inArray(hrefHostname, internalHost) === -1
                        // Check if the link has the class 'external-link'
                        || $(element).hasClass('external-link') // jshint ignore:line
                        // Check if the parent <li> element has the class 'external-link'.
                        // This is useful for links in navigation menus that are marked as
                        // external links, as WordPress does not add the 'external-link'
                        // class to the <a> element, but to the parent <li> element.
                        || $(element).parent('li.menu-item').hasClass('external-link') // jshint ignore:line
                    ) {
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
         * Initialize Masonry layout for blog, search, and archive pages.
         */
        const initMasonry = () => {
            const grid = document.querySelector(
                'body.blog .site-main, body.search .site-main, body.archive .site-main'
            );
            const articles = grid ? grid.querySelectorAll('article') : [];

            // Only initialize Masonry if there are multiple articles to display
            if (grid && articles.length > 1) {
                articles.forEach(article => article.classList.add('masonry-item'));

                const msnry = new Masonry(grid, { // eslint-disable-line no-unused-vars
                    columnWidth: '.masonry-item',
                    gutter: 20,
                    itemSelector: '.masonry-item',
                    maxColumnHeightDifference: 1,
                    percentPosition: true,
                    stamp: '.site-main .page-header'
                });
            }
        };

        /**
         * Functions that need to be executed on successful ajax events.
         */
        $(document).ajaxSuccess(() => {
            externalLinks();
        });

        /**
         * Detect the current device type based on the viewport size.
         */
        const getDevice = () => (
            ['xs', 'sm'].includes(viewport.current()) ? 'mobile' : 'desktop'
        );

        console.log(`Terra Nanotech JS: Viewport is ${viewport.current()}`);

        let activeDevice = null;

        /**
         * Fix the sticky menu based on the current device type.
         *
         * @param {string} device - The current device type ('desktop' or 'mobile').
         */
        const fixStickyMenu = (device) => {
            const $siteHeader = $('header.site-header');

            if (device === 'desktop') {
                $siteHeader
                    .addClass('site-header-desktop')
                    .sticky({
                        zIndex: 10
                    })
                    .sticky('update');
            } else {
                $siteHeader.removeClass('site-header-desktop').unstick();
            }
        };

        /**
         * Synchronize the sticky menu based on the current device type.
         * This function checks the current device type and updates the sticky menu accordingly.
         * It only reconfigures the sticky menu when the device mode actually changes.
         */
        const syncStickyMenu = () => {
            const nextDevice = getDevice();

            // Only reconfigure sticky when device mode actually changes.
            if (nextDevice === activeDevice) {
                return;
            }

            activeDevice = nextDevice;
            fixStickyMenu(nextDevice);
        };

        /**
         * Functions that need to be executed when the page is loaded and rendered.
         */
        (() => {
            injectBlurBodyBackground();
            externalLinks();
            initMasonry();
            syncStickyMenu();

            console.log('Terra Nanotech JS: Loaded');
        })();

        /**
         * Functions that need to be executed when the viewport is resized.
         */
        $(window).resize(viewport.changed(() => {
            syncStickyMenu();
        }, 1));
    });
})(jQuery, ResponsiveToolkit);
