<?php
session_name('TP1_PHP');
session_start();
$_SESSION['competence-perso'] = $_POST;
echo 'reponse competence perso recue';