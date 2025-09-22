<?php
session_name('TP1_PHP');
session_start();
$_SESSION['formation'] = $_POST;
echo 'reponse formation perso recue';