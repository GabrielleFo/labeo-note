<?php

//fonction pour utiliser les custom post types 
function create_frais_de_note_post_type() {
    register_post_type('frais_de_note',
        array(
            'labels' => array(
                'name' => __('Frais de Note'),
                'singular_name' => __('Frais de Note')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'author', 'custom-fields'),
        )
    );
}
add_action('init', 'create_frais_de_note_post_type');