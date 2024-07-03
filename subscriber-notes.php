<?php
// Ajouter une page de menu pour les abonnés
function add_subscriber_menu() {
    if (!current_user_can('administrator')) {
        add_menu_page(
            'Mes Notes de Frais',
            'Mes Notes de Frais',
            'read',
            'mes_notes_de_frais',
            'display_subscriber_notes_page',
            'dashicons-media-text',
            6
        );
    }
}
add_action('admin_menu', 'add_subscriber_menu');

// enregistrement des noms des auteurs des notes de frais 
function save_frais_de_note_meta_data($post_id) {
    if (get_post_type($post_id) == 'frais_de_note') {
        $current_user = wp_get_current_user();
        $author_name = $current_user->first_name . ' ' . $current_user->last_name;
        update_post_meta($post_id, 'author_name', $author_name);
    }
}
add_action('save_post', 'save_frais_de_note_meta_data');


// Fonction pour afficher les notes de frais de l'utilisateur actuel
function display_subscriber_notes_page() {
    $current_user_id = get_current_user_id();
    $args = array(
        'post_type' => 'frais_de_note',
        'post_status' => 'any',
        'author' => $current_user_id,
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    echo '<div class="wrap">';
    echo '<h1>Mes Notes de Frais</h1>';

    if ($query->have_posts()) {
        echo '<table class="widefat fixed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Date de Création</th>';
        // echo '<th>Titre</th>';
        // echo '<th>Description</th>';
        // echo '<th>Montant</th>';
        echo '<th>Code Analytique</th>';
        echo '<th>Motif</th>';
        echo '<th>Date de Début</th>';
        echo '<th>Date de Fin</th>';
        echo '<th>Prix HT</th>';
        echo '<th>Prix TTC</th>';
        echo '<th>Justificatif</th>';
        echo '<th>Statut</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $meta_data = get_post_meta($post_id);

            echo '<tr>';
            echo '<td>' . $post_id . '</td>';
            // echo '<td>' . get_the_title() . '</td>';
            // echo '<td>' . get_the_content() . '</td>';
            // echo '<td>' . (isset($meta_data['amount'][0]) ? $meta_data['amount'][0] : '') . '</td>';
            echo '<td>' . get_the_date('Y-m-d H:i:s') . '</td>'; // Affichage de la date de création
            echo '<td>' . (isset($meta_data['code_analytique'][0]) ? $meta_data['code_analytique'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['motif'][0]) ? $meta_data['motif'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['start_date'][0]) ? $meta_data['start_date'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['end_date'][0]) ? $meta_data['end_date'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['price_ht'][0]) ? $meta_data['price_ht'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['price_ttc'][0]) ? $meta_data['price_ttc'][0] : '') . '</td>';
            echo '<td>' . wp_get_attachment_url(isset($meta_data['justificatif'][0]) ? $meta_data['justificatif'][0] : '') . '</td>';
            echo '<td>' . get_post_status($post_id) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Aucune note de frais trouvée.</p>';
    }

    echo '</div>';

    wp_reset_postdata();
}
?>