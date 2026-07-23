<?php

namespace TerraNanotech\Theme\TerraNanotech\Overrides;

class WebsiteFooter {
    /**
     * Constructor
     *
     * @return void
     * @access public
     */
    public function __construct() {
        $this->overrideFooter();
    }

    /**
     * Override the website footer
     *
     * @return void
     * @access private
     */
    private function overrideFooter(): void {
        // Override the website footer copyright
        add_filter('generate_copyright', [$this, 'generateCopyright']);
    }

    /**
     * Generate the website footer copyright
     *
     * @return string
     * @access public
     */
    public function generateCopyright(): string {
        $copyright = sprintf(
            '<span class="copyright">&copy; %1$s %2$s</span> &bull; ',
            date('Y'),
            esc_html(get_bloginfo('name')),
        );

        $legal_note = sprintf(
            // translators: %1$s is the name and the link to the copyright holder (Fenris Creations - https://www.fenriscreations.com/), which will be replaced automatically at runtime.
            __('All EVE-related materials are the property of %1$s.', 'terra-nanotech'),
            sprintf(
                '<a href="%1$s" target="_blank" referrerpolicy="no-referrer">Fenris Creations</a>',
                esc_url('https://www.fenriscreations.com/')
            )
        );

        return $copyright . $legal_note;
    }
}
