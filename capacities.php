<?php

// modifier la capaciter du manager pour qu'il puisse éditer les notes de frais 

 function add_custom_capabilities() {
   // Ajouter une capacité pour valider les notes de frais
     $role = get_role('manager_n1'); // Remplacez 'manager' par le nom du rôle que vous avez défini

//      Définir une nouvelle capacité spécifique aux notes de frais
    $role->add_cap('validate_expense_notes');
 }
 add_action('init', 'add_custom_capabilities');