<?php

// créer des sous menus sous frais de note 



function frais_de_note_submenus() {

    // add_submenu_page(

    //     'edit.php?post_type=frais_de_note',

    //     'Notes de frais à valider',

    //     'À valider',

    //     'manage_options',

    //     'edit.php?post_status=pending_approval&post_type=frais_de_note'

    // );



    // add_submenu_page(

    //     'edit.php?post_type=frais_de_note',

    //     'Notes de frais en attente de paiement',

    //     'En attente de paiement',

    //     'manage_options',

    //     'edit.php?post_status=pending_payment&post_type=frais_de_note'

    // );



    add_submenu_page(

        'edit.php?post_type=frais_de_note',

        'Export des notes de frais',

        'Exporter en CSV',

        'manage_options',

        'export_frais_de_note_csv',

        'export_frais_de_note_csv_page'

    );

}

add_action('admin_menu', 'frais_de_note_submenus');

