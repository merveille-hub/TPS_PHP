<?php
session_name('TP1_PHP');
session_start();
$experiences = [];
if(isset($_POST['intitule-poste'])){
    foreach ($_POST['intitule-poste'] as $index => $poste) {
        $experience = [
            'poste' => $poste,
            'employeur' => $_POST['employeur'][$index] ?? '',
            'localisation' => $_POST['localisation-experience'][$index] ?? '',
            'date_debut' => $_POST['date-debut'][$index] ?? '',
            'date_fin' => $_POST['date-fin'][$index] ?? '',
            'description' => $_POST['description'][$index] ?? '',
        ];
        $experiences[] = $experience;
    }
}
var_dump($_POST);
$_SESSION['experiences-perso'] = $experiences;
//$_SESSION['experiences-perso'] = $_POST;
echo 'reponse experience perso recue';