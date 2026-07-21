jQuery(document).ready(($) => {
    'use strict';

    /**
     * Inject a blurred background to the body.
     */
    const injectBlurBodyBackground = () => {
        $('<div class="blur-background"></div>').prependTo('body');
    };

    injectBlurBodyBackground();
});
