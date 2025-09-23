<?php
session_name('TP1_PHP');
session_start();
var_dump($_POST);
if(isset($_POST['nom-ecole'])){
    $formations = [];
    foreach ($_POST['nom-ecole'] as $index => $ecole) {
        $formation = [
            'nom-ecole' => $ecole,
            'localisation' => $_POST['localisation-emploi'][$index],
            'diplome' => $_POST['diplome'][$index],
            'date-debut' => $_POST['date-debut'][$index],
            'date-fin' => $_POST['date-fin'][$index],
            'description' => $_POST['description']
        ];
        $formations[] = $formation;
    }
    echo 'formation ';
    print_r($formations);
    $_SESSION['formations'] = $formations;
    echo 'reponse formation perso recue ' . $formations;
}


//$_SESSION['formation'] = $_POST;

