<?php
/**
 * Plugin Name: WordPress Core Lab
 * Description: Plugin para practicar las APIs nativas de WordPress Core.
 * Version: 1.0.0
 * Author: WordPress Core Lab
 * Text Domain: wordpress-core-lab
 */

if (!defined('ABSPATH')) {
    exit;
}

// Mostrar un mensaje para verificar que el plugin funciona.
add_action('admin_notices', function () {
    if (current_user_can('manage_options')) {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<p>WordPress Core Lab está funcionando correctamente.</p>';
        echo '</div>';
    }
});