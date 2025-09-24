<?php
session_start();
$_SESSION = [];
session_unset();  // Vide toutes les variables de session
session_destroy(); // Détruit la session
header('Location: index.php'); // Redirige vers la page de départ
exit;
?>
