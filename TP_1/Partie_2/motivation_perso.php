<?php
session_name('TP1_PHP');
session_start();
$_SESSION['motivation-perso'] = $_POST;
echo 'reponse competence perso recue';