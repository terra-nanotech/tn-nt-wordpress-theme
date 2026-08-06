<?php

namespace TerraNanotech\Theme\TerraNanotech\Overrides;

class PostExcerpt {
    /**
     * Constructor
     *
     * @return void
     * @access public
     */
    public function __construct() {
        $this->initializeHooks();
    }

    /**
     * Initialize hooks
     *
     * @return void
     * @access private
     */
    private function initializeHooks(): void {
        add_filter('excerpt_more', [$this, 'excerptMore'], 20);
        add_filter('the_content_more_link', [$this, 'contentMore'], 20);
    }

    /**
     * Override the excerpt "read more" link.
     *
     * @param string $more The string shown within the more link.
     * @return string The HTML for the more link.
     * @access public
     */
    public function excerptMore(string $more): string {
        return apply_filters(
            'generate_excerpt_more_output',
            sprintf(
                '… <a title="%1$s" class="read-more" href="%2$s" aria-label="%4$s">%3$s</a>',
                the_title_attribute(['echo' => false]),
                esc_url(get_permalink(get_the_ID())),
                esc_html(generate_get_read_more_text()),
                esc_attr(generate_get_read_more_aria_label())
            )
        );
    }

    /**
     * Override the content "read more" link (<!--more--> tag).
     *
     * @param string $more The string shown within the more link.
     * @return string The HTML for the more link.
     * @access public
     */
    public function contentMore(string $more): string {
        return apply_filters(
            'generate_content_more_link_output',
            sprintf(
                '<p class="read-more-container"><a title="%1$s" class="read-more content-read-more" href="%2$s" aria-label="%4$s">%3$s</a></p>',
                the_title_attribute(['echo' => false]),
                esc_url(get_permalink(get_the_ID()) . apply_filters('generate_more_jump', '#more-' . get_the_ID())),
                esc_html(generate_get_read_more_text()),
                esc_attr(generate_get_read_more_aria_label())
            )
        );
    }
}
