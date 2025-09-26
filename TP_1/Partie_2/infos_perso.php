<?php
session_name('TP1_PHP');
session_start();


// Activer les erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donnees = $_POST;

    $upload_dir = __DIR__ . '/uploads/';
    $public_dir = 'uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $filename = basename($_FILES['photo']['name']);
        $filename = uniqid() . '_' . $filename;

        $target_server_path = $upload_dir . $filename;
        $target_public_path = $public_dir . $filename;

        $check = getimagesize($_FILES['photo']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_server_path)) {
                echo "✅ Image envoyée avec succès !<br>";
                echo "<img src='$target_public_path' width='200'><br>";

                $donnees['photo_profil'] = $target_public_path;
            } else {
                echo "❌ Erreur lors du déplacement du fichier.<br>";
                var_dump($_FILES['photo']);
                die();
            }
        } else {
            echo "❌ Le fichier n'est pas une image.";
        }
    } else {
        echo "❌ Erreur lors de l'envoi du fichier.<br>";
        var_dump($_FILES['photo']);
    }

    $_SESSION['infos-perso'] = $donnees;
    echo "✅ Données personnelles enregistrées.";
}