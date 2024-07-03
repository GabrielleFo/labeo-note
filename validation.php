<?php

function handle_validation() {
    if (isset($_POST['valider_n1'])) {
        $post_id = intval($_POST['post_id']);
        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => 'validated_by_n1'
        ));
    }

    if (isset($_POST['valider_compta'])) {
        $post_id = intval($_POST['post_id']);
        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => 'validated_by_compta'
        ));
    }
}
add_action('init', 'handle_validation');

// diiferents statut valaidation 


function add_custom_post_statuses() {

       register_post_status('awaiting_validation', array(
        'label'                     => _x('En attente de validation', 'post'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('En attente de validation <span class="count">(%s)</span>', 'En attente de validation <span class="count">(%s)</span>'),
    ));
    register_post_status('validated_by_n1', array(
        'label'                     => _x('Validé par N+1', 'post'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Validé par N+1 <span class="count">(%s)</span>', 'Validé par N+1 <span class="count">(%s)</span>'),
    ));
    register_post_status('validated_by_compta', array(
        'label'                     => _x('Validé par Comptabilité', 'post'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop('Validé par Comptabilité <span class="count">(%s)</span>', 'Validé par Comptabilité <span class="count">(%s)</span>'),
    ));
}
add_action('init', 'add_custom_post_statuses');
