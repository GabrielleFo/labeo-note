<?php
// Fonction pour gérer l'exportation CSV
function handle_frais_de_note_export() {
    if (isset($_GET['export_frais_de_note']) && current_user_can('manage_options')) {
        export_frais_de_note_csv();
    }
}
add_action('admin_init', 'handle_frais_de_note_export');

// Fonction d'exportation des frais de note en CSV
function export_frais_de_note_csv() {
    $id_client = get_current_user_id();

    $args = array(
        'post_type' => 'frais_de_note',
        'post_status' => 'any',
        'posts_per_page' => -1,
        // uniquement si export de la personne connectée 
        // 'author' => $id_client,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $filename = 'notes_de_frais_' . date('YmdHis') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // En-tête du CSV
        fputcsv($output, array('ID',  'Code Analytique', 'Motif', 'Date de Début', 'Date de Fin', 'Prix HT', 'Prix TTC', 'Justificatif', 'Statut'));

        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $meta_data = get_post_meta($post_id);

            // Récupérer les informations du post et des métadonnées
            $row = array(
                $post_id,
                // get_the_title(),
                // get_the_content(),
                // isset($meta_data['amount'][0]) ? $meta_data['amount'][0] : '',
                isset($meta_data['code_analytique'][0]) ? $meta_data['code_analytique'][0] : '',
                isset($meta_data['motif'][0]) ? $meta_data['motif'][0] : '',
                isset($meta_data['start_date'][0]) ? $meta_data['start_date'][0] : '',
                isset($meta_data['end_date'][0]) ? $meta_data['end_date'][0] : '',
                isset($meta_data['price_ht'][0]) ? $meta_data['price_ht'][0] : '',
                isset($meta_data['price_ttc'][0]) ? $meta_data['price_ttc'][0] : '',
                wp_get_attachment_url(isset($meta_data['justificatif'][0]) ? $meta_data['justificatif'][0] : ''),
                get_post_status(),
            );

            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    wp_reset_postdata();
}

// Fonction pour afficher la page d'exportation
function export_frais_de_note_csv_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Vous n\'avez pas l\'autorisation d\'accéder à cette page.'));
    }

    echo '<div class="wrap">';
    echo '<h1>Exporter les notes de frais en CSV</h1>';
    echo '<form method="get">';
    echo '<input type="hidden" name="page" value="export_frais_de_note_csv">';
    echo '<input type="submit" name="export_frais_de_note" class="button button-primary" value="Exporter">';
    echo '</form>';
    echo '</div>';
}

// Ajouter un sous-menu pour l'exportation
function add_export_menu() {
    if (current_user_can('manage_options')) {
        add_menu_page(
            'Export Notes de Frais',
            'Export Notes de Frais',
            'manage_options',
            'export_frais_de_note_csv',
            'export_frais_de_note_csv_page',
            'dashicons-download',
            6
        );
    }
}
add_action('admin_menu', 'add_export_menu');