<?php

function enqueue_custom_script() {
    wp_enqueue_script('formulaire', plugin_dir_url(__FILE__) . 'js/formulaire.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');
