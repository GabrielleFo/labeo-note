<?php

// Ajouter de nouvelles colonnes pour les champs personnalisés

function add_frais_de_note_columns($columns) {

    // $columns['amount'] = 'Montant';

    $columns['code_analytique'] = 'Code Analytique';

    $columns['motif'] = 'Motif';

    $columns['start_date'] = 'Date de Début';

    $columns['end_date'] = 'Date de Fin';

    $columns['price_ht'] = 'Prix HT';

    $columns['price_ttc'] = 'Prix TTC';

    $columns['justificatif'] = 'Justificatif';

    return $columns;

}

add_filter('manage_frais_de_note_posts_columns', 'add_frais_de_note_columns');



// Afficher les données dans les colonnes personnalisées

function custom_frais_de_note_column($column, $post_id) {

    switch ($column) {

        // case 'amount':

        //     $amount = get_post_meta($post_id, 'amount', true);

        //     echo esc_html($amount);

        //     break;

        case 'code_analytique':

            $code_analytique = get_post_meta($post_id, 'code_analytique', true);

            echo esc_html($code_analytique);

            break;

        case 'motif':

            $motif = get_post_meta($post_id, 'motif', true);

            echo esc_html($motif);

            break;

        case 'start_date':

            $start_date = get_post_meta($post_id, 'start_date', true);

            echo esc_html($start_date);

            break;

        case 'end_date':

            $end_date = get_post_meta($post_id, 'end_date', true);

            echo esc_html($end_date);

            break;

        case 'price_ht':

            $price_ht = get_post_meta($post_id, 'price_ht', true);

            echo esc_html($price_ht);

            break;

        case 'price_ttc':

            $price_ttc = get_post_meta($post_id, 'price_ttc', true);

            echo esc_html($price_ttc);

            break;

        case 'justificatif':

            $justificatif = get_post_meta($post_id, 'justificatif', true);

            if ($justificatif) {

                echo '<a href="' . wp_get_attachment_url($justificatif) . '" target="_blank">Voir le fichier</a>';

            }

            break;

    }

}

add_action('manage_frais_de_note_posts_custom_column', 'custom_frais_de_note_column', 10, 2);

