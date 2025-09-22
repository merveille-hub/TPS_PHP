<?php
session_name('TP1_PHP');
session_start();
$_SESSION['infos-perso'] = $_POST;
echo 'reponse information perso recue';