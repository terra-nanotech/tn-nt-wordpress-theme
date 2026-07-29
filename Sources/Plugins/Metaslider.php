<?php

/*
 * Copyright (C) 2018 p.pfeufer
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Utilizing the ML-Slider Plugin in our theme
 */

namespace TerraNanotech\Theme\TerraNanotech\Plugins;

use WP_Post;

class Metaslider {
    /**
     * Constructor
     */
    public function __construct() {
        $this->registerMetaBox();
    }

    /**
     * Register the meta box and the render action
     *
     * @return void
     */
    public function registerMetaBox(): void {
        add_action('add_meta_boxes', [$this, 'addMetaBox']);
        add_action('save_post', [$this, 'saveMetaBox']);
        add_action('generate_after_header', [$this, 'renderSlider']);
    }

    /**
     * Add Meta Slider Box to page settings
     *
     * @return boolean
     */
    public function addMetaBox(): bool {
        if ($this->metasliderPluginExists()) {
            add_meta_box(
                id:'metaslider_meta_box',
                title: __('Meta Slider', 'terra-nanotech'),
                callback: [$this, 'renderMetaBox'],
                screen: ['page', 'post'],
                context: 'side'
            );

            return true;
        }

        return false;
    }

    /**
     * Check if the main plugin actually is installed and is active
     *
     * @return boolean
     */
    public function metasliderPluginExists(): bool {
        return class_exists('\MetaSliderPlugin');
    }

    /**
     * Render the Meta Slider Box
     *
     * @param WP_Post $post
     * @return bool
     */
    public function renderMetaBox(WP_Post $post): bool {
        if ($this->metasliderPluginExists()) {
            $metaslider = get_post_meta($post->ID, 'page_metaslider_slider', true);
            $options = $this->metasliderGetOptions();
            ?>
            <div class="generate-meta-box-content">
                <div>
                    <label for="page_metaslider"><strong><?php _e('Display Meta Slider', 'terra-nanotech'); ?></strong></label>
                    <select id="page_metaslider" name="page_metaslider">
                        <?php
                        foreach ($options as $id => $name) {
                            ?>
                            <option value="<?php echo esc_attr($id); ?>" <?php selected($metaslider, $id); ?>>
                                <?php echo esc_html($name); ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
            wp_nonce_field('save', '_page_metaslider_nonce');

            return true;
        }

        return false;
    }

    /**
     * Getting the options
     *
     * @return array
     */
    public function metasliderGetOptions(): array {
        $options = ['' => __('No Slider', 'terra-nanotech')];

        if ($this->metasliderPluginExists()) {
            $sliders = get_posts([
                'post_type' => 'ml-slider',
                'numberposts' => 200,
            ]);

            foreach ($sliders as $slider) {
                $options[sanitize_title('metaSlider_ID_' . $slider->ID)] = __('Slider: ', 'terra-nanotech') . $slider->post_title;
            }
        }

        return $options;
    }

    public function saveMetaBox($post_id): bool|int {
        $postNonce = filter_input(INPUT_POST, '_page_metaslider_nonce');

        if (empty($postNonce) || !wp_verify_nonce($postNonce, 'save')) {
            return false;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return false;
        }

        if (defined('DOING_AJAX')) {
            return false;
        }

        update_post_meta(
            $post_id,
            'page_metaslider_slider',
            sanitize_title(filter_input(INPUT_POST, 'page_metaslider'))
        );

        return true;
    }

    public function renderSlider(): bool {
        if ($this->metasliderPluginExists()) {
            /**
             * Check if a slider is set for this page
             */
            $page_id = get_the_ID();
            $page_slider = get_post_meta($page_id, 'page_metaslider_slider', true);

            /**
             * No slider set, check for our default slider
             *
             * @TODO: We should add a theme option for this, so the user can set a default slider for all pages
             */
            if (empty($page_slider)) {
//                $default_slider = 'metaslider_id_1937';
//
//                if (!empty($default_slider)) {
//                    if (isset($themeOptions['default_slider_on']['frontpage_only']) && !is_front_page()) {
//                        return false;
//                    }
//
//                    $page_slider = $default_slider;
//                } else {
//                    /**
//                     * No slider set at all, not even a defalt one
//                     */
//                    return false;
//                }

                return false;
            }

            //  Check if the slider is in the correct format
            $normalizedPageSlider = sanitize_title((string)$page_slider);

            // Render the slider using the Meta Slider shortcode
            if (str_starts_with($normalizedPageSlider, 'metaslider_id_')) {
                $slider_id = absint(
                    str_replace(
                        'metaslider_id_',
                        '',
                        $normalizedPageSlider
                    )
                );

                $slider_html = do_shortcode(sprintf('[metaslider id="%d"]', $slider_id));

                echo '<div ' . generate_get_attr('page') . '><div class="meta-slider slider-' . $slider_id . '" data-stretch="true">' . $slider_html . '</div></div>';
            } else {
                // Wrong format
                return false;
            }

            return true;
        }

        return false;
    }
}
