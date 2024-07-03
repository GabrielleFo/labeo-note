<?php

// code pour ajouter des options dans le menu déroulant notes de frais administrateurs 

// function custom_post_status_bulk_actions($bulk_actions) {

//     $bulk_actions['mark_pending_approval'] = 'Marquer comme en attente de validation';

//     $bulk_actions['mark_pending_payment'] = 'Marquer comme en attente de paiement';

//     return $bulk_actions;

// }

// add_filter('bulk_actions-edit-frais_de_note', 'custom_post_status_bulk_actions');



// function handle_custom_post_status_bulk_action($redirect_to, $doaction, $post_ids) {

//     if ($doaction === 'mark_pending_approval') {

//         foreach ($post_ids as $post_id) {

//             $post = array(

//                 'ID' => $post_id,

//                 'post_status' => 'pending_approval',

//             );

//             wp_update_post($post);

//         }

//         $redirect_to = add_query_arg('marked_pending_approval', count($post_ids), $redirect_to);

//     }



//     if ($doaction === 'mark_pending_payment') {

//         foreach ($post_ids as $post_id) {

//             $post = array(

//                 'ID' => $post_id,

//                 'post_status' => 'pending_payment',

//             );

//             wp_update_post($post);

//         }

//         $redirect_to = add_query_arg('marked_pending_payment', count($post_ids), $redirect_to);

//     }



//     return $redirect_to;

// }

// add_filter('handle_bulk_actions-edit-frais_de_note', 'handle_custom_post_status_bulk_action', 10, 3);