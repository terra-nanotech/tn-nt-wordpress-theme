<?php

namespace TerraNanotech\Theme\TerraNanotech\Overrides;

/**
 * Search URL
 *
 * This class is responsible for modifying the search URL.
 *
 * @package TerraNanotech\Theme\TerraNanotech\Overrides
 */
class SearchUrl {
    /**
     * Constructor
     *
     * @return void
     * @access public
     */
    public function __construct() {
        add_filter(
            hook_name: 'template_redirect',
            callback: [$this, 'searchUrl']
        );
    }

    /**
     * Search URL
     *
     * @return void
     * @access public
     */
    public function searchUrl(): void {
        if (isset($_GET['s']) && is_search()) {
            wp_redirect(
                location: home_url(
                    path: '/search/'
                ) . strtolower(string: urlencode(get_query_var(query_var: 's')) . '/')
            );

            exit();
        }
    }
}
