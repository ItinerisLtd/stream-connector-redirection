<?php
/**
 * Plugin Name:     Stream - Redirection
 * Plugin URI:      https://www.itineris.co.uk/
 * Description:     Redirection plugin connector for Stream to track redirect management
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * Text Domain:     stream-connector-redirection
 */

declare(strict_types=1);

namespace Itineris\StreamConnectorRedirection;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

add_filter('wp_stream_connectors', function (array $classes): array {
    if (! is_plugin_active('stream/stream.php')) {
        return $classes;
    }

    require __DIR__ . '/src/Redirection.php';

    $classes[] = new Redirection();

    return $classes;
});
