<?php

//fonction pour le formulaire 

function frais_de_note_form() {

    ob_start();

    ?>

    <form action="" method="post" enctype="multipart/form-data">

        <label for="code_analytique">Code Analytique :</label>

        <input type="text" name="code_analytique" id="code_analytique"><br>



        <label for="motif">Motif :</label>

        <select name="motif" id="motif">

            <option value="repas d'affaire">Repas d'affaire</option>

            <option value="achats">Achats</option>

            <option value="formation">Formation</option>

            <option value="missions">Missions</option>

            <option value="evenements communication">Événements Communication</option>

            <option value="congres ou conférence">Congrès ou Conférence</option>

            <option value="déplacement">Déplacement</option>

            <option value="autre">Autre</option>

        </select><br>



        <label for="start_date">Date et Heure de Début :</label>

        <input type="datetime-local" name="start_date" id="start_date"><br>



        <label for="end_date">Date et Heure de Fin :</label>

        <input type="datetime-local" name="end_date" id="end_date"><br>



        <label for="price_ht">Prix HT :</label>

        <input type="number" step="0.01" name="price_ht" id="price_ht"><br>



        <label for="price_ttc">Prix TTC :</label>

        <input type="number" step="0.01" name="price_ttc" id="price_ttc"><br>



        <label for="justificatif">Justificatif :</label>

        <input type="file" name="justificatif" id="justificatif"><br>

        
        <label for="n_plus_un">N+1 :</label>
        <select name="n_plus_un" id="n_plus_un">
            <?php
            $users = get_users(array('role__in' => array('manager_n1', 'administrator')));
            foreach ($users as $user) {
                echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
            }
            ?>
        </select><br>



        <input type="submit" name="submit_frais_de_note" value="Soumettre">

    </form>

    <?php

    return ob_get_clean();

}



add_shortcode('frais_de_note_form', 'frais_de_note_form');