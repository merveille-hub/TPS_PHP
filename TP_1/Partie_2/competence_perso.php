<?php
session_name('TP1_PHP');
session_start();
echo 'post: ';
echo'<pre>';
print_r($_POST);
echo '</pre>';
if (isset($_POST['competences'])) {
    /* competences = $l;
    foreach ($_POST['competence-perso'] as $key => $competence) {
        $competence = [
            'competence' => $_POST['competences'][$key],
            'niveau' => $competence['niveau_competences'][$key]
        ];
        $competences[] = $competence;
    }
    $_SESSION['competence-perso'] = $competences;
 */

    $competences_associees = [];

    foreach ($_POST['competences'] as $index => $competence) {
        $niveau = $_POST['niveau_competences'][$index] ?? null; // Sécurité si l'index n'existe pas
        $competences_associees[] = [
            'competence' => $competence,
            'niveau' => $niveau
        ];
    }
    $_SESSION['competences-perso'] = $competences_associees;
    
}

echo 'reponse competence perso recue';
