<?php
session_name('TP1_PHP');
session_start();
$_SESSION['experience-perso'] = $_POST;
echo 'reponse experience perso recue';