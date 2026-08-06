<?php

namespace TerraNanotech\Theme\TerraNanotech\Overrides;

class Website {
    public function __construct() {
        add_action(
            hook_name: 'document_title_separator',
            callback: [$this, 'documentTitleSeparator']
        );
    }

    public function documentTitleSeparator(): string {
        return '»';
    }
}
