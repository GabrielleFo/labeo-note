<?php
// Fonction pour créer la table lors de l'activation
function create_frais_de_note_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'frais_de_note';

    // Vérifier si la table existe déjà
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

        // Si la table n'existe pas, la créer
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id bigint(20) UNSIGNED NOT NULL,
            code_analytique varchar(50) DEFAULT '' NOT NULL,
            responsable_n_plus_un varchar(255) DEFAULT '' NOT NULL,
            tickets_restaurant enum('oui', 'non') DEFAULT 'non' NOT NULL,
            start_date datetime NOT NULL,
            end_date datetime NOT NULL,
            motif varchar(255) DEFAULT '' NOT NULL,
            lieu varchar(255) DEFAULT '' NOT NULL,
            repas_midi enum('magasin', 'restaurant') DEFAULT NULL,
            prix_depense_midi decimal(10,2) DEFAULT '0.00' NOT NULL,
            justificatif_midi varchar(255) DEFAULT '' NOT NULL,
            transport longtext DEFAULT NULL,
            km int(11) DEFAULT '0' NOT NULL,
            puissance_fiscale int(11) DEFAULT '0' NOT NULL,
            carte_grise varchar(255) DEFAULT '' NOT NULL,
            montant_carburant decimal(10,2) DEFAULT '0.00' NOT NULL,
            ticket_carburant varchar(255) DEFAULT '' NOT NULL,
            montant_peage decimal(10,2) DEFAULT '0.00' NOT NULL,
            ticket_peage varchar(255) DEFAULT '' NOT NULL,
            depense_totale_vehicule decimal(10,2) DEFAULT '0.00' NOT NULL,
            montant_taxi decimal(10,2) DEFAULT '0.00' NOT NULL,
            justificatif_taxi varchar(255) DEFAULT '' NOT NULL,
            montant_transport_commun decimal(10,2) DEFAULT '0.00' NOT NULL,
            justificatif_transport_commun varchar(255) DEFAULT '' NOT NULL,
            montant_avion decimal(10,2) DEFAULT '0.00' NOT NULL,
            justificatif_avion varchar(255) DEFAULT '' NOT NULL,
            question_nuitee enum('aucune', 'province', 'grande_ville') DEFAULT 'aucune' NOT NULL,
            montant_depense_hotel decimal(10,2) DEFAULT '0.00' NOT NULL,
            justificatif_hotel varchar(255) DEFAULT '' NOT NULL,
            grand_deplacement tinyint(1) DEFAULT '0' NOT NULL,
            date_demande datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            statut_n_plus_un varchar(50) DEFAULT '' NOT NULL,
            statut_comptabilite varchar(50) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id),
            KEY post_id (post_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    error_log('Table created successfully'); // Vérifier si cette ligne est dans vos logs
}

// Activer la fonction lors de l'activation du plugin ou thème
register_activation_hook(__FILE__, 'create_frais_de_note_table');