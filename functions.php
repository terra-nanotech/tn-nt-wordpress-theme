<?php

/*
 * Copyright (C) 2022 p.pfeufer
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
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace TerraNanotech\Theme\TerraNanotech;

// Define a couple of constants we might need.
// phpcs:disable
// Theme name
define(
    constant_name: __NAMESPACE__ . '\THEME_NAME',
    value: wp_get_theme()->get('Name')
);

// Theme version
define(
    constant_name: __NAMESPACE__ . '\THEME_VERSION',
    value: wp_get_theme()->get('Version')
);

// Theme directory (without trailing slash)
define(
    constant_name: __NAMESPACE__ . '\THEME_DIRECTORY',
    value: get_stylesheet_directory()
);

// Theme directory URI (without trailing slash)
define(
    constant_name: __NAMESPACE__ . '\THEME_DIRECTORY_URI',
    value: get_stylesheet_directory_uri()
);

// Theme slug
const THEME_SLUG = 'tn-nt-wordpress-theme';

// Theme Sources directory (without trailing slash)
const THEME_SOURCES_DIRECTORY = THEME_DIRECTORY . '/Sources';

// Theme Library directory (without trailing slash)
const THEME_LIBRARY_DIRECTORY = THEME_SOURCES_DIRECTORY . '/Libs';

// Theme GitHub URI
const THEME_GITHUB_URI = 'https://github.com/ppfeufer/' . THEME_SLUG . '/';
// phpcs:enable

// Include the theme autoloader
require_once THEME_SOURCES_DIRECTORY . '/autoload.php';

// Include the library autoloader
require_once THEME_LIBRARY_DIRECTORY . '/autoload.php';

// Load the themes' main class.
(new Main())->init();
