<?php

// fonction pour traitement des données du formulaire 

function handle_frais_de_note_submission() {

    if (isset($_POST['submit_frais_de_note'])) {

        // Récupérer et assainir les données du formulaire

        // $title = sanitize_text_field($_POST['title']);

        // $description = sanitize_textarea_field($_POST['description']);

        // $amount = sanitize_text_field($_POST['amount']);

        $code_analytique = sanitize_text_field($_POST['code_analytique']);

        $motif = sanitize_text_field($_POST['motif']);

        $start_date = sanitize_text_field($_POST['start_date']);

        $end_date = sanitize_text_field($_POST['end_date']);

        $price_ht = sanitize_text_field($_POST['price_ht']);

        $price_ttc = sanitize_text_field($_POST['price_ttc']);
        $n_plus_un = sanitize_text_field($_POST['n_plus_un']);


        

        // Préparer les données du post

        $post_data = array(

            // 'post_title'    => $title,

            // 'post_content'  => $description,

            'post_status'   => 'publish',

            'post_type'     => 'frais_de_note',

        );

        

        // Insérer le post

        $post_id = wp_insert_post($post_data);

        

        if ($post_id) {

            // Enregistrer les métadonnées


            update_post_meta($post_id, 'code_analytique', $code_analytique);

            update_post_meta($post_id, 'motif', $motif);

            update_post_meta($post_id, 'start_date', $start_date);

            update_post_meta($post_id, 'end_date', $end_date);

            update_post_meta($post_id, 'price_ht', $price_ht);

            update_post_meta($post_id, 'price_ttc', $price_ttc);
            update_post_meta($post_id, 'n_plus_un', $n_plus_un);
            update_post_meta($post_id, 'statut_validation', 'En attente de validation par N+1');



            // Gérer le téléchargement du fichier justificatif

            if (!empty($_FILES['justificatif']['name'])) {

                require_once(ABSPATH . 'wp-admin/includes/file.php');

                require_once(ABSPATH . 'wp-admin/includes/media.php');

                require_once(ABSPATH . 'wp-admin/includes/image.php');



                $attachment_id = media_handle_upload('justificatif', $post_id);

                

                if (is_wp_error($attachment_id)) {

                    // Handle error

                    echo "Error uploading file: " . $attachment_id->get_error_message();

                } else {

                    update_post_meta($post_id, 'justificatif', $attachment_id);

                }

            }

        }

    }

}

add_action('init', 'handle_frais_de_note_submission');

