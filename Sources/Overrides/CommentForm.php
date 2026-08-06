<?php

namespace TerraNanotech\Theme\TerraNanotech\Overrides;

class CommentForm {
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
        add_filter('comment_form_default_fields', [$this, 'removeUrlField'], 99);
    }

    /**
     * Remove website field from comment form to prevent backlink spam
     *
     * @param array $fields
     *
     * @return array
     * @access public
     */
    public function removeUrlField(array $fields): array {
        if (isset($fields['url'])) {
            unset($fields['url']);
        }

        return $fields;
    }
}
