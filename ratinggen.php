<?php
/**
 * Plugin Name: Rating Comment Generator
 */

use App\Core\Core;

require __DIR__ . '/vendor/autoload.php';

const PLUGIN_TITLE = 'Rating Comment Generator';
const PLUGIN_NAME = 'rating-comment-generator';
const PLUGIN_VERSION = '0.0.1';

(new Core())->init();