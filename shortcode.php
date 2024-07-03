<?php
// Fonction pour le formulaire
function frais_de_note_form() {
    ob_start();
    ?>

    <form action="" method="post" enctype="multipart/form-data">

        <label for="code_analytique">Code Analytique :</label>
        <input type="text" name="code_analytique" id="code_analytique"><br>

        <label for="responsable_n_plus_un">Responsable N+1 :</label>
        <select name="responsable_n_plus_un" id="responsable_n_plus_un">
            <?php
            $users = get_users(array('role__in' => array('manager_n1', 'administrator')));
            foreach ($users as $user) {
                echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
            }
            ?>
        </select><br>

        <label for="tickets_restaurant">Possédez-vous des tickets restaurant ?</label><br>
        <input type="radio" name="tickets_restaurant" id="tickets_restaurant_oui" value="oui">
        <label for="tickets_restaurant_oui">Oui</label><br>
        <input type="radio" name="tickets_restaurant" id="tickets_restaurant_non" value="non">
        <label for="tickets_restaurant_non">Non</label><br>

        <label for="start_date">Date et Heure de Début :</label>
        <input type="datetime-local" name="start_date" id="start_date"><br>

        <label for="end_date">Date et Heure de Fin :</label>
        <input type="datetime-local" name="end_date" id="end_date"><br>

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

        <label for="lieu">Lieu :</label>
        <input type="text" name="lieu" id="lieu"><br>

        <label for="repas_midi">Repas Midi :</label><br>
        <input type="radio" name="repas_midi" id="repas_midi_magasin" value="magasin">
        <label for="repas_midi_magasin">Magasin</label><br>
        <input type="radio" name="repas_midi" id="repas_midi_restaurant" value="restaurant">
        <label for="repas_midi_restaurant">Restaurant</label><br>

        <label for="prix_depense_midi">Prix de la Dépense Midi :</label>
        <input type="number" step="0.01" name="prix_depense_midi" id="prix_depense_midi"><br>

        <label for="justificatif_midi">Justificatif de la Dépense Midi :</label>
        <input type="file" name="justificatif_midi" id="justificatif_midi"><br>

        <label for="transport">Transport :</label><br>
        <input type="checkbox" name="transport[]" value="aucun_vehicule" id="aucun_vehicule">
        <label for="aucun_vehicule">Aucun véhicule</label><br>

        <input type="checkbox" name="transport[]" value="vehicule_labeo" id="vehicule_labeo">
        <label for="vehicule_labeo">Véhicule Labéo</label><br>

        <input type="checkbox" name="transport[]" value="vehicule_personnel" id="transport_vehicule_personnel">
        <label for="transport_vehicule_personnel">Véhicule Personnel</label><br>
        
        <input type="checkbox" name="transport[]" value="taxi" id="transport_taxi">
        <label for="transport_taxi">Taxi</label><br>

        <input type="checkbox" name="transport[]" value="transport_en_commun" id="transport_transport_en_commun">
        <label for="transport_transport_en_commun">Transport en Commun</label><br>

        <input type="checkbox" name="transport[]" value="avion" id="transport_avion">
        <label for="transport_avion">Avion</label><br>

        <div id="details_vehicule_personnel" style="display: none;">
            <label for="km">Km :</label>
                <input type="number" name="km" id="km"><br>

            <label for="puissance_fiscale">Puissance Fiscale :</label>
                <input type="number" name="puissance_fiscale" id="puissance_fiscale"><br>

            <label for="carte_grise">Carte Grise :</label>
                <input type="file" name="carte_grise" id="carte_grise"><br>

            <label for="montant_carburant">Montant dépensé pour le carburant :</label>
                <input type="number" step="0.01" name="montant_carburant" id="montant_carburant"><br>

            <label for="ticket_carburant">Ticket Carburant :</label>
                <input type="file" name="ticket_carburant" id="ticket_carburant"><br>

            <label for="montant_peage">Montant du péage :</label>
                <input type="number" step="0.01" name="montant_peage" id="montant_peage"><br>

            <label for="ticket_peage">Ticket Péage :</label>
                <input type="file" name="ticket_peage" id="ticket_peage"><br>

            <label for="depense_totale_vehicule">Dépense Totale Véhicule :</label>
                <input type="number" step="0.01" name="depense_totale_vehicule" id="depense_totale_vehicule"><br>
        </div>

        <div id="details_taxi" style="display: none;">
            <label for="montant_taxi">Montant taxi :</label>
                <input type="number" step="0.01" name="montant_taxi" id="montant_taxi"><br>
                <input type="file" name="justificatif_taxi" id="justificatif_taxi"><br>
         
        </div>

        <div class="details_transport" id="details_transport_commun" style="display: none;">
            <label for="montant_transport_commun">Montant transport en commun :</label>
                <input type="number" step="0.01" name="montant_transport_commun" id="montant_transport_commun"><br>
            <label for="justificatif_transport_commun">Justificatif Transport en Commun :</label>
                <input type="file" name="justificatif_transport_commun" id="justificatif_transport_commun"><br>
        </div>

        <div id="details_avion" style="display: none;">
            <label for="montant_avion">Montant avion :</label>
            <input type="number" step="0.01" name="montant_avion" id="montant_avion"><br>
            <label for="justificatif_avion">Justificatif Avion :</label>
                <input type="file" name="justificatif_avion" id="justificatif_avion"><br>
        </div>

       
        <label for="question_nuitee">Nuitée :</label><br>
        <input type="radio" name="question_nuitee" id="question_nuitee_aucune" value="aucune">
        <label for="question_nuitee_aucune">Aucune</label><br>
        <input type="radio" name="question_nuitee" id="question_nuitee_province" value="province">
        <label for="question_nuitee_province">Province</label><br>
        <input type="radio" name="question_nuitee" id="question_nuitee_grande_ville" value="grande_ville">
        <label for="question_nuitee_grande_ville">Grande Ville</label><br>

        <div id="details_nuitee" style="display: none;">
            <label for="montant_depense_hotel">Montant dépensé dans l'hôtel :</label>
            <input type="number" step="0.01" name="montant_depense_hotel" id="montant_depense_hotel"><br>

            <label for="justificatif_hotel">Justificatif de l'hôtel :</label>
            <input type="file" name="justificatif_hotel" id="justificatif_hotel"><br>

            <label for="grand_deplacement">Grand Déplacement :</label>
            <input type="checkbox" name="grand_deplacement" id="grand_deplacement"><br>
        </div>

        <input type="submit" name="submit_frais_de_note" value="Soumettre">

    </form>

    <?php
    return ob_get_clean();
}

add_shortcode('frais_de_note_form', 'frais_de_note_form');
?>