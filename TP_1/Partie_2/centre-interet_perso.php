<?php
session_name('TP1_PHP');
session_start();
$centre_interets = [];
if(isset($_POST['centre-interets'])){
    foreach ($_POST['centre-interets'] as $index => $centre_interet) {
        $centre_interets[] = $centre_interet;
    }
}
var_dump($_POST);
$_SESSION['centre-interets'] = $centre_interets;
//$_SESSION['experiences-perso'] = $_POST;
echo 'reponse centre interet perso recue';