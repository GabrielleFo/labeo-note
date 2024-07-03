// choix formulaire 

// custom-script.js

jQuery(document).ready(function($) {
    // Détecter le changement dans le champ de transport
    $('input[name="transport[]"]').change(function() {
        // Réinitialiser l'affichage des détails
        $('.details_transport').hide();

       // Parcourir les cases cochées et afficher les détails correspondants
       $('input[name="transport[]"]:checked').each(function() {
        var selectedOption = $(this).val();
        $('#details_' + selectedOption).show();

            // Afficher spécifiquement le montant transport en commun si sélectionné
            if (selectedOption === 'transport_en_commun') {
                $('#details_transport_commun').show();
            }
        });
    });
    

    // Détecter le changement dans le champ de nuitée
    $('input[name="question_nuitee"]').change(function() {
        var selectedValue = $(this).val();

        // Afficher ou masquer les détails de la nuitée si l'option est sélectionnée
        if (selectedValue === 'province' || selectedValue === 'grande_ville') {
            $('#details_nuitee').show();
        } else {
            $('#details_nuitee').hide();
        }
    });
});