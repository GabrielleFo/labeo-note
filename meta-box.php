<?php
//affichage des métadonnées dans l'admin
function display_frais_de_note_meta_box($post) {
    $amount = get_post_meta($post->ID, 'amount', true);
    $code_analytique = get_post_meta($post->ID, 'code_analytique', true);
    $motif = get_post_meta($post->ID, 'motif', true);
    $start_date = get_post_meta($post->ID, 'start_date', true);
    $end_date = get_post_meta($post->ID, 'end_date', true);
    $price_ht = get_post_meta($post->ID, 'price_ht', true);
    $price_ttc = get_post_meta($post->ID, 'price_ttc', true);
    $justificatif = get_post_meta($post->ID, 'justificatif', true);
    ?>
    <table>
        <tr>
            <td style="width: 150px">Montant</td>
            <td><input type="text" size="80" name="amount_meta" value="<?php echo esc_attr($amount); ?>" /></td>
        </tr>
        <tr>
            <td>Code Analytique</td>
            <td><input type="text" size="80" name="code_analytique_meta" value="<?php echo esc_attr($code_analytique); ?>" /></td>
        </tr>
        <tr>
            <td>Motif</td>
            <td><input type="text" size="80" name="motif_meta" value="<?php echo esc_attr($motif); ?>" /></td>
        </tr>
        <tr>
            <td>Date et Heure de Début</td>
            <td><input type="datetime-local" size="80" name="start_date_meta" value="<?php echo esc_attr($start_date); ?>" /></td>
        </tr>
        <tr>
            <td>Date et Heure de Fin</td>
            <td><input type="datetime-local" size="80" name="end_date_meta" value="<?php echo esc_attr($end_date); ?>" /></td>
        </tr>
        <tr>
            <td>Prix HT</td>
            <td><input type="text" size="80" name="price_ht_meta" value="<?php echo esc_attr($price_ht); ?>" /></td>
        </tr>
        <tr>
            <td>Prix TTC</td>
            <td><input type="text" size="80" name="price_ttc_meta" value="<?php echo esc_attr($price_ttc); ?>" /></td>
        </tr>
        <tr>
            <td>Justificatif</td>
            <td>
                <?php if ($justificatif) : ?>
                    <a href="<?php echo wp_get_attachment_url($justificatif); ?>" target="_blank">Voir le fichier</a>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php
}

function save_frais_de_note_meta($post_id, $post) {
    if ($post->post_type == 'frais_de_note') {
        if (isset($_POST['amount_meta']) && $_POST['amount_meta'] != '') {
            update_post_meta($post_id, 'amount', $_POST['amount_meta']);
        }
        if (isset($_POST['code_analytique_meta']) && $_POST['code_analytique_meta'] != '') {
            update_post_meta($post_id, 'code_analytique', $_POST['code_analytique_meta']);
        }
        if (isset($_POST['motif_meta']) && $_POST['motif_meta'] != '') {
            update_post_meta($post_id, 'motif', $_POST['motif_meta']);
        }
        if (isset($_POST['start_date_meta']) && $_POST['start_date_meta'] != '') {
            update_post_meta($post_id, 'start_date', $_POST['start_date_meta']);
        }
        if (isset($_POST['end_date_meta']) && $_POST['end_date_meta'] != '') {
            update_post_meta($post_id, 'end_date', $_POST['end_date_meta']);
        }
        if (isset($_POST['price_ht_meta']) && $_POST['price_ht_meta'] != '') {
            update_post_meta($post_id, 'price_ht', $_POST['price_ht_meta']);
        }
        if (isset($_POST['price_ttc_meta']) && $_POST['price_ttc_meta'] != '') {
            update_post_meta($post_id, 'price_ttc', $_POST['price_ttc_meta']);
        }
    }
}
add_action('save_post', 'save_frais_de_note_meta', 10, 2);
