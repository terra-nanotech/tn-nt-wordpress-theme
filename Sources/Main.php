<?php

namespace TerraNanotech\Theme\TerraNanotech;

use TerraNanotech\Theme\TerraNanotech\Libs\YahnisElsts\PluginUpdateChecker\v5p7\PucFactory;

class Main {
    /**
     * Constructor
     *
     * @return void
     * @access public
     */
    public function __construct() {
        $this->doUpdateCheck();
        $this->initializeHooks();
    }

    /**
     * Check GitHub for updates
     *
     * @return void
     * @access public
     */
    public function doUpdateCheck(): void {
        PucFactory::buildUpdateChecker(
            metadataUrl: THEME_GITHUB_URI,
            fullPath: THEME_DIRECTORY,
            slug: THEME_SLUG
        )->getVcsApi()->enableReleaseAssets();
    }

    /**
     * Initialize hooks
     *
     * @return void
     * @access private
     */
    private function initializeHooks(): void {
        add_action(
            hook_name: 'after_setup_theme',
            callback: [$this, 'loadTextDomain']
        );
    }

    /**
     * Load text domain
     *
     * @return void
     * @access public
     */
    public function loadTextDomain(): void {
        load_child_theme_textdomain(
            domain: 'terra-nanotech',
            path: THEME_DIRECTORY . '/l10n'
        );
    }

    /**
     * Initialize the theme
     *
     * @return void
     * @access public
     */
    public function init(): void {
        array_map(static fn($class) => new $class(), $this->getClassesToLoad());
    }

    /**
     * Get classes to load
     *
     * @return array
     * @access private
     */
    private function getClassesToLoad(): array {
        return [
            AssetLoader::class, // Load assets
            Overrides\WesiteLogo::class, // Website logo overrides
        ];
    }
}
