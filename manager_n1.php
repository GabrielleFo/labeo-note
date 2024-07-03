<?php
// onglet pour validation
function add_manager_menu() {
    if (current_user_can('manager_n1') || current_user_can('compta')) {
        add_menu_page(
            'Validation Notes de Frais Manager',
            'Validation Notes de Frais Manager',
            'read',
            'validation_notes_de_frais',
            'display_manager_notes_page',
            'dashicons-yes',
            7
        );
    }
}


add_action('admin_menu', 'add_manager_menu');

function display_manager_notes_page() {
    
    $current_user = wp_get_current_user();
    $post_status = $current_user->has_cap('manager_n1') ? 'publish' : 'validated_by_n1';


    $args = array(
        'post_type' => 'frais_de_note',
        // 'post_status' => 'pending',
        'post_status' => array('publish', 'validated_by_n1', 'validated_by_compta'),
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    echo '<div class="wrap">';
    echo '<h1>Validation Notes de Frais</h1>';

    if ($query->have_posts()) {
        echo '<table class="widefat fixed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        // echo '<th>Titre</th>';
        echo '<th>Nom de l\'auteur</th>'; // Nouvelle colonne pour le nom de l'auteur
        echo '<th>Motif</th>';
        echo '<th>Date de Début</th>';
        echo '<th>Date de Fin</th>';
        echo '<th>Prix HT</th>';
        echo '<th>Prix TTC</th>';
        echo '<th>Justificatif</th>';
        echo '<th>Statut</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $meta_data = get_post_meta($post_id);
            $author_name = isset($meta_data['author_name'][0]) ? $meta_data['author_name'][0] : 'N/A';


            $post_status = get_post_status($post_id);
            $status_object = get_post_status_object($post_status);

            echo '<tr>';
            echo '<td>' . $post_id . '</td>';
            // echo '<td>' . get_the_title() . '</td>';
            echo '<td>' . $author_name . '</td>'; // Affichage du nom de l'auteur
            echo '<td>' . (isset($meta_data['motif'][0]) ? $meta_data['motif'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['start_date'][0]) ? $meta_data['start_date'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['end_date'][0]) ? $meta_data['end_date'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['price_ht'][0]) ? $meta_data['price_ht'][0] : '') . '</td>';
            echo '<td>' . (isset($meta_data['price_ttc'][0]) ? $meta_data['price_ttc'][0] : '') . '</td>';
            echo '<td>' . wp_get_attachment_url(isset($meta_data['justificatif'][0]) ? $meta_data['justificatif'][0] : '') . '</td>';
            // echo '<td>' . get_post_status($post_id) . '</td>'; // Afficher le statut
            echo '<td>' . $status_object->label . '</td>'; // Afficher le label du statut

          // Ajouter un formulaire pour valider directement
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
            echo '<input type="submit" name="valider_n_plus_un" class="button button-primary" value="Valider">';
            echo '</form>';
            // Ajouter un lien pour modifier
            echo '<a href="' . admin_url('post.php?post=' . $post_id . '&action=edit') . '"class="button button-secondary" >Modifier</a>';
            echo '</td>';

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>Aucune note de frais en attente de validation.</p>';
    }

    echo '</div>';

    wp_reset_postdata();
}

function handle_validation_n_plus_un() {
    if (isset($_POST['valider_n_plus_un'])) {
        $post_id = intval($_POST['post_id']);
        
        // Vérifier si l'utilisateur a la permission d'éditer ce post
        if (current_user_can('edit_post', $post_id)) {
            update_post_meta($post_id, 'statut_validation', 'Validé par N+1');
        } else {
            // Gérer le cas où l'utilisateur n'a pas la permission
            wp_die('Désolé, vous n’avez pas l’autorisation de modifier cet élément.');
        }
    }
}
add_action('init', 'handle_validation_n_plus_un');