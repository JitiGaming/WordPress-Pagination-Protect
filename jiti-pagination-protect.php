<?php
/**
 * Plugin Name: Jiti Pagination Protect
 * Description: Supprime les paramètres d'URL des pages de pagination et redirige vers l'URL propre, afin d'éviter le NSEO.
 * Version: 1.2
 * Author: Jiti
 * Author URI: https://jiti.me/
 * License: Copyleft
 */

// Hook pour initier le plugin
add_action('template_redirect', 'remove_pagination_params_redirect');

function remove_pagination_params_redirect() {
    // Récupérer l'URL actuelle
    $current_url = home_url( add_query_arg( NULL, NULL ) );

    // Parse l'URL pour obtenir ses composants
    $parsed_url = parse_url($current_url);

    // Si l'URL contient des paramètres et "/page/" dans le chemin
    if (!empty($parsed_url['query']) && strpos($parsed_url['path'], '/page/') !== false) {
        // Construit la nouvelle URL sans les paramètres
        $clean_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];

        // Effectue une redirection 301 vers l'URL propre
        wp_redirect($clean_url, 301);
        exit();
    }
}
