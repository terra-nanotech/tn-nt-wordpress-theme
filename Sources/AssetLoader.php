<?php

namespace TerraNanotech\Theme\TerraNanotech;

/**
 * Asset Loader
 *
 * This class is responsible for loading all assets for the theme.
 *
 * @package Ppfeufer\Theme\Ppfeufer
 */
class AssetLoader {
    /**
     * Constructor
     *
     * @return void
     * @access public
     */
    public function __construct() {
        add_action(hook_name: 'wp_enqueue_scripts', callback: [$this, 'loadStyles']);
        add_action(
            hook_name: 'wp_enqueue_scripts',
            callback: [$this, 'loadScripts'],
            priority: 9999
        );
//        add_action(
//            hook_name: 'admin_enqueue_scripts',
//            callback: [$this, 'loadAdminStyles']
//        );
//        add_action(hook_name: 'wp_footer', callback: [$this, 'loadSvgSprite']);
    }

    /**
     * Load styles
     *
     * @return void
     * @access public
     */
    public function loadStyles(): void {
        wp_enqueue_style(
            handle: 'terra-nanotech-theme-style-defaults',
            src: get_theme_file_uri(file: '/Assets/css/defaults.min.css'),
            deps: ['generate-style'],
            ver: THEME_VERSION
        );
        wp_enqueue_style(
            handle: 'terra-nanotech-theme-style',
            src: get_theme_file_uri(file: '/Assets/css/terra-nanotech.min.css'),
            deps: ['terra-nanotech-theme-style-defaults'],
            ver: THEME_VERSION
        );
//        wp_enqueue_style(
//            handle: 'terra-nanotech-plugin-styles',
//            src: get_theme_file_uri(file: '/Assets/css/plugin-styles.min.css'),
//            deps: ['terra-nanotech-theme-style'],
//            ver: THEME_VERSION
//        );
    }

    /**
     * Load scripts
     *
     * @return void
     * @access public
     */
    public function loadScripts(): void {
        wp_enqueue_script(
            handle: 'ppfeufer',
            src: get_theme_file_uri(file: '/Assets/javascript/terra-nanotech.min.js'),
            deps: ['jquery'],
            ver: THEME_VERSION,
            args: [
                'in_footer' => true,
                'strategy' => 'async'
            ]
        );
    }

    /**
     * Load admin styles
     *
     * @return void
     * @access public
     */
    public function loadAdminStyles(): void {
        wp_enqueue_style(
            handle: 'terra-nanotech-admin-style',
            src: get_theme_file_uri(file: '/Assets/css/admin-style.min.css'),
            ver: THEME_VERSION
        );
    }

    /**
     * Add SVG-Sprite to footer hook
     *
     * @return void
     * @access public
     */
//    public function loadSvgSprite(): void {
//        $svg_sprite = file_get_contents(
//            filename: get_theme_file_path(file: 'Assets/images/sprite.svg')
//        );
//
//        echo '<div class="svg-sprite">' . $svg_sprite . '</div>';
//    }
}
