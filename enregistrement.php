<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    global $wpdb;
    $table_name = $wpdb->prefix . 'frais_de_note';

     // Gestion des fichiers justificatifs
     $justificatif_midi = sanitize_file_name($_FILES['justificatif_midi']['name']);
     $justificatif_midi_path = $_FILES['justificatif_midi']['tmp_name'];
 
     // Vérifie si un fichier a été téléchargé et le déplace dans un répertoire sûr
     if (!empty($justificatif_midi_path)) {
         require_once ABSPATH . 'wp-admin/includes/file.php';
         $upload_overrides = array('test_form' => false);
         $movefile = wp_handle_upload($justificatif_midi_path, $upload_overrides);
         if ($movefile && !isset($movefile['error'])) {
             // Fichier correctement téléchargé, obtenez l'URL du fichier
             $justificatif_midi_url = $movefile['url'];
         } else {
             // Erreur lors du téléchargement du fichier
             error_log('Erreur lors du téléchargement du fichier justificatif midi : ' . $movefile['error']);
             // Gestion de l'erreur : renvoyer un message à l'utilisateur ou effectuer une action appropriée
         }
     } else {
         // Aucun fichier téléchargé
         $justificatif_midi_url = '';
     }

    // Récupérer le responsable N+1 (nom et prénom)
    // $responsable_n_plus_un = get_userdata(intval($_POST['responsable_n_plus_un']));
    // $responsable_nom_prenom = $responsable_n_plus_un ? $responsable_n_plus_un->first_name . ' ' . $responsable_n_plus_un->last_name : '';

    // Récupérer les tickets restaurant (oui ou non)
    $tickets_restaurant = isset($_POST['tickets_restaurant']) && $_POST['tickets_restaurant'] === 'oui' ? 'oui' : 'non';

    // Récupérer le type de repas midi (magasin ou restaurant)
    $repas_midi = sanitize_text_field($_POST['repas_midi']);

    // Récupérer la nuitée (province ou grande ville)
    $question_nuitee = sanitize_text_field($_POST['question_nuitee']);

    // Préparer les données à insérer dans la table
    $data = [
        'code_analytique' => sanitize_text_field($_POST['code_analytique']),
        // 'responsable_n_plus_un' => $responsable_nom_prenom,
        'tickets_restaurant' => $tickets_restaurant,
        'start_date' => sanitize_text_field($_POST['start_date']),
        'end_date' => sanitize_text_field($_POST['end_date']),
        'motif' => sanitize_text_field($_POST['motif']),
        'lieu' => sanitize_text_field($_POST['lieu']),
        'repas_midi' => $repas_midi,
        'prix_depense_midi' => floatval($_POST['prix_depense_midi']),
        'justificatif_midi' => sanitize_file_name($_FILES['justificatif_midi']['name']),
        'transport' => maybe_serialize($_POST['transport']),
        'km' => intval($_POST['km']),
        'puissance_fiscale' => intval($_POST['puissance_fiscale']),
        'carte_grise' => sanitize_file_name($_FILES['carte_grise']['name']),
        'montant_carburant' => floatval($_POST['montant_carburant']),
        'ticket_carburant' => sanitize_file_name($_FILES['ticket_carburant']['name']),
        'montant_peage' => floatval($_POST['montant_peage']),
        'ticket_peage' => sanitize_file_name($_FILES['ticket_peage']['name']),
        'depense_totale_vehicule' => floatval($_POST['depense_totale_vehicule']),
        'montant_taxi' => floatval($_POST['montant_taxi']),
        'justificatif_taxi' => sanitize_file_name($_FILES['justificatif_taxi']['name']),
        'montant_transport_commun' => floatval($_POST['montant_transport_commun']),
        'justificatif_transport_commun' => sanitize_file_name($_FILES['justificatif_transport_commun']['name']),
        'montant_avion' => floatval($_POST['montant_avion']),
        'justificatif_avion' => sanitize_file_name($_FILES['justificatif_avion']['name']),
        'question_nuitee' => $question_nuitee,
        'montant_depense_hotel' => floatval($_POST['montant_depense_hotel']),
        'justificatif_hotel' => sanitize_file_name($_FILES['justificatif_hotel']['name']),
        'grand_deplacement' => isset($_POST['grand_deplacement']) ? 1 : 0,
        'date_demande' => current_time('mysql', 1),
        'statut_n_plus_un' => '', // À définir lors de la validation par N+1
        'statut_comptabilite' => '', // À définir lors de la validation par la comptabilité
    ];

    // Log the data to be inserted for debugging
    error_log(print_r($data, true));

    // Insérer les données dans la table
    $wpdb->insert($table_name, $data);

    // Vérifier si l'insertion a réussi
    if ($wpdb->last_error) {
        error_log('Erreur lors de l\'insertion des données : ' . $wpdb->last_error);
    } else {
        error_log('Données insérées avec succès, ID de la ligne : ' . $wpdb->insert_id);
    }

}
