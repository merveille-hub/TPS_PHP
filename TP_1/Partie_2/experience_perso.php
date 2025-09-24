<?php
session_name('TP1_PHP');
session_start();

if(isset($_POST['intitule-poste'])){
    $experiences = [];
    $descriptions = [];
    foreach ($_POST['description'] as $key => $description) :
        $descriptions[] = $description;
    endforeach;
    foreach ($_POST['intitule-poste'] as $index => $poste) {
        $experience = [
            'poste' => $poste,
            'employeur' => $_POST['employeur'][$index] ?? '',
            'localisation' => $_POST['localisation-experience'][$index] ?? '',
            'date_debut' => $_POST['date-debut'][$index] ?? '',
            'date_fin' => $_POST['date-fin'][$index] ?? '',
            'description' => $descriptions
        ];
        $experiences[] = $experience;
    }
    $_SESSION['experiences-perso'] = $experiences;
}
var_dump($_POST);
//$_SESSION['experiences-perso'] = $_POST;
echo 'reponse experience perso recue';