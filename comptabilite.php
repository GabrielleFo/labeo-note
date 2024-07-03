<?php
function add_compta_menu() {
    if (current_user_can('administrator')) {
        add_menu_page(
            'Validation Comptabilité',
            'Validation Comptabilité',
            'manage_options',
            'validation_compta',
            'display_compta_notes_page',
            'dashicons-yes',
            8
        );
    }
}
add_action('admin_menu', 'add_compta_menu');

function display_compta_notes_page() {
    $args = array(
        'post_type' => 'frais_de_note',
        'post_status' => 'any',
        'meta_query' => array(
            array(
                'key' => 'statut_validation',
                'value' => 'Validé par N+1',
                'compare' => '='
            ),
        ),

    );
  

    $query = new WP_Query($args);

    echo '<div class="wrap">';
    echo '<h1>Validation notes de frais par la Comptabilité</h1>';

    if ($query->have_posts()) {
        echo '<table class="widefat fixed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nom de l\'auteur</th>'; // Nouvelle colonne pour le nom de l'auteur
        // echo '<th>Titre</th>';
        echo '<th>Motif</th>';
        echo '<th>Date de Début</th>';
        echo '<th>Date de Fin</th>';
        echo '<th>Prix HT</th>';
        echo '<th>Prix TTC</th>';
        echo '<th>Justificatif</th>';
        echo '<th>Statut</th>';
        echo '<th>Validé par</th>'; // Colonne pour le nom du manager
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $meta_data = get_post_meta($post_id);
            $author_name = isset($meta_data['author_name'][0]) ? $meta_data['author_name'][0] : 'N/A';
            $validated_by_manager = isset($meta_data['validated_by_manager'][0]) ? esc_html($meta_data['validated_by_manager'][0]) : 'N/A';


            echo '<tr>';
            echo '<td>' . $post_id . '</td>';
            echo '<td>' . $author_name . '</td>'; // Affichage du nom de l'auteur
            echo '<td>' . (isset($meta_data['motif'][0]) ? $meta_data['motif'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['start_date'][0]) ? $meta_data['start_date'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['end_date'][0]) ? $meta_data['end_date'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['price_ht'][0]) ? $meta_data['price_ht'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['price_ttc'][0]) ? $meta_data['price_ttc'][0] : '') . '</td>';
            echo '<td>' . wp_get_attachment_url(isset($meta_data['justificatif'][0]) ? $meta_data['justificatif'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['statut_validation'][0]) ? $meta_data['statut_validation'][0] : '') . '</td>';
            echo '<td>' . $validated_by_manager . '</td>';
            echo '<td>';
            if (isset($meta_data['statut_validation'][0]) && $meta_data['statut_validation'][0] == 'Validé par N+1') {
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                echo '<input type="submit" name="valider_compta" class="button button-primary" value="Valider">';
                echo '</form>';
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Aucune note de frais à valider.</p>';
    }

    echo '</div>';

    wp_reset_postdata();
}

function handle_validation_compta() {
    if (isset($_POST['valider_compta'])) {
        $post_id = intval($_POST['post_id']);
        update_post_meta($post_id, 'statut_validation', 'Validé par Comptabilité');
    }
}
add_action('init', 'handle_validation_compta');