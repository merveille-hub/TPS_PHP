<?php
session_name('TP1_PHP');
session_start();
$langues = [];
if(isset($_POST['langues'])){
    foreach ($_POST['langues'] as $index => $langue) {
        $langues[] = [
            'langue' => $langue,
            'niveau' => $_POST['niveau_langues'][$index]
        ];
    }
}
var_dump($_POST);
$_SESSION['langues'] = $langues;
//$_SESSION['experiences-perso'] = $_POST;
echo 'reponse langues perso recue';