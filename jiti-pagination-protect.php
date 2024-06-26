<?php
/**
 * Plugin Name: Jiti Pagination Protect
 * Description: Supprime les paramètres d'URL des pages de pagination et redirige vers l'URL propre, afin d'éviter le NSEO, à l'exception des pages de recherche.
 * Version: 1.3
 * Author: Jiti
 * Author URI: https://jiti.me/
 * License: Copyleft
 */

add_action('template_redirect', 'remove_pagination_params_redirect');

function remove_pagination_params_redirect() {
    // Récupérer l'URL actuelle
    $current_url = home_url($_SERVER['REQUEST_URI']);

    // Parse l'URL pour obtenir ses composants
    $parsed_url = parse_url($current_url);

    // Vérifier si l'URL contient des paramètres, "/page/" dans le chemin, et n'est pas une page de recherche
    if (!empty($parsed_url['query']) && preg_match('/\/page\/[0-9]+/', $parsed_url['path']) && !isset($_GET['s'])) {
        // Construire la nouvelle URL sans les paramètres
        $clean_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];

        if (!empty($parsed_url['port'])) {
            $clean_url .= ':' . $parsed_url['port'];
        }

        $clean_url .= $parsed_url['path'];

        // Effectuer une redirection 301 vers l'URL propre
        wp_redirect($clean_url, 301);
        exit();
    }
}
