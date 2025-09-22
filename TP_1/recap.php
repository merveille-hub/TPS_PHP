<?php
session_start();
// Fonction récursive pour formater en texte lisible
function formatDataToText($data, $indent = 0)
{
    $output = '';
    $spaces = str_repeat("  ", $indent);

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $output .= $spaces . ucfirst($key) . ":\n";
            $output .= formatDataToText($value, $indent + 1);
        } else {
            $output .= $spaces . ucfirst($key) . ": " . $value . "\n";
        }
    }

    return $output;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer']) && $_POST['envoyer'] === "ENVOYER") {
    $projets = $_POST['liste-projets'];
    $liste_projets[] = explode('\n', $projets);
    
    $interets = $_POST['centre-interet'];
    $centre_interet[] = explode('\n', $interets);
    
    $competences = $_POST['competences'];
    $liste_competences[] = explode('\n', $competences);
    
    $_SESSION['data'] = [
        'nom' => $_POST['nom'] ?? '',
        'prenom' => $_POST['prenom'] ?? '',
        'age' => $_POST['age'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'filiere' => $_POST['filiere'] ?? '',
        'annee' => $_POST['annee'] ?? '',
        'nb-projets' => $_POST['nb-projets'] ?? '',
        'competences' => $_POST['competences'] ?? [],
        'liste-projets' => $_POST['liste-projets'] ?? [],
        'centre-interet' => $_POST['centre-interet'] ?? [],
        'langues-parles' => $_POST['langues-parles'] ?? [],
    ];
}

if (isset($_POST)) {
    $data = $_SESSION['data'];
    //$_SESSION['user-infos'] = $_POST;
    //var_dump($data);
    $nom = isset($data['nom']) ? htmlspecialchars($data['nom']) : "";
    $prenom = isset($data['prenom']) ? $data['prenom'] : "";
    $age = isset($data['age']) ? $data['age'] : "";
    $phone = isset($data['phone']) ? $data['phone'] : "";
    $email = isset($data['email']) ? $data['email'] : "";
    $filiere = isset($data['filiere']) ? $data['filiere'] : "";
    $annee = isset($data['annee']) ? $data['annee'] : "";
    $nb_projets = isset($data['nb-projets']) ? $data['nb-projets'] : "";
    $competences = isset($data['competences']) ? $data['competences'] : "";
    $liste_projets = isset($data['liste-projets']) ? $data['liste-projets'] : "";
    $centre_interet = isset($data['centre-interet']) ? $data['centre-interet'] : "";
    $langues_parles = isset($data['langues-parles']) ? $data['langues-parles'] : "";

    if (isset($_FILES['userfile'])) :
        $uploaddir = '/var/www/uploads/';
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            echo "Le fichier est valide, et a été téléchargé
           avec succès. Voici plus d'informations :\n";
        } else {
            echo "Attaque potentielle par téléchargement de fichiers.
          Voici plus d'informations :\n";
        }

        echo 'Voici quelques informations de débogage :';
        print_r($_FILES);

        echo '</pre>';
    endif;
}
if (isset($_GET) && isset($_GET['action']) && isset($data)) {
    /* $data[] = $_SESSION['user-infos'];
    var_dump($data);
    var_dump($_SESSION); */
    $data = $_SESSION['data'];
    if ($_GET['action'] == 'VALIDER') {

        $result = file_put_contents(
            "cvs.txt",
            formatDataToText(
                [
                    "a propos" => "rien à dire",
                    "infos personnelles" => [
                        'nom' => $data['nom'],
                        'prenom' => $data['prenom'],
                        "age" => $data['age'],
                        'phone' => $data['phone'],
                        "email" => $data['email'],
                    ],
                    "infos académiques" => [
                        "filiere" => $data['filiere'],
                        'annee' => $data['annee'],
                        "nb projets" => $data['nb-projets'],
                        "projets réalisés" => $data['liste-projets'],
                        "competences" => $data['competences']
                    ],
                    "autres infos" => [
                        "centre interet" => $data['centre-interet'],
                        "langue parles" => $data['langues-parles'],
                    ]
                ]
            )
        );
        if ($result)
            echo 'cv crée avec succès';
        else
            echo 'Erreur lors de l\ouverture ou de l\ecriture dans le fichier';
        /* 
        $file_name = 'cv.pdf'; // Le nom réel du fichier
        $full_path = '/file/cv.pdf'; // Le chemin complet vers le fichier sur le serveur

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream'); // Type MIME pour un téléchargement général
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($full_path)); // La taille du fichier

        // --- Lecture et envoi du fichier --- */
        //readfile($full_path);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Récapitulatif des Informations Saisies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        h2 {
            color: #2980b9;
            margin-top: 30px;
        }

        ul {
            list-style-type: none;
            padding-left: 20px;
        }

        ul li {
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-radius: 5px;
        }

        ul li ul {
            margin-top: 8px;
        }

        ul li ul li {
            background: #ecf0f1;
            border: none;
            padding: 5px 10px;
            margin-bottom: 5px;
            border-radius: 3px;
        }

        strong {
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <h1>Récapitulatif des Informations Saisies</h1>

    <h2>Renseignements Personnels</h2>
    <ul>
        <li><strong>Nom :</strong> <?= $nom ?></li>
        <li><strong>Prénom :</strong> <?= $prenom ?></li>
        <li><strong>Âge :</strong> <?= $age ?></li>
        <li><strong>Numéro de téléphone :</strong> <?= $phone ?></li>
        <li><strong>Email :</strong> <?= $email ?></li>
    </ul>

    <h2>Renseignements Académiques</h2>
    <ul>
        <li><strong>Filière : </strong> <?= $filiere ?>
        </li>
        <li><strong>Année d'étude : </strong> <?= $annee ?>
        </li>
        <li><strong>Modules suivis cette année : </strong> (Champ non défini dans le formulaire)</li>
        <li><strong>Nombre de projets réalisés cette année :</strong> <?= $nb_projets ?></li>
        <li><strong>Liste de projets réalisés cette année :</strong> <?= print_r($liste_projets) ?></li>
        <li><strong>Certifications : </strong> <?= $competences ?></li>
    </ul>

    <h2>Autres Renseignements</h2>
    <ul>
        <li><strong>Centre d'intérêt : </strong> <?= $centre_interet ?></li>
        <li><strong>Langues parlés : </strong> <?= $langues_parles ?></li>
    </ul>

    <h2>Autres Informations</h2>
    <ul>
        <li><strong>Fichier à joindre :</strong> Upload d’un fichier</li>
    </ul>
    <!-- <form action="formulaire.php">
        <div>
            <button type="submit" name="btn" value="valider">VALIDER</button>
            <button type="submit" name="btn" value="modifier">MODIFIER</button>
        </div>
    </form> -->
    <form action="" method="get">
        <input type="submit" name="action" id="" value="VALIDER">
    </form>
    <form action="formulaire.php" method="get">
        <input type="hidden" name="nom" value="<?= htmlspecialchars($nom) ?>">
        <input type="hidden" name="prenom" value="<?= htmlspecialchars($prenom) ?>">
        <input type="hidden" name="age" value="<?= htmlspecialchars($age) ?>">
        <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="filiere" value="<?= htmlspecialchars($filiere) ?>">
        <input type="hidden" name="annee" value="<?= htmlspecialchars($annee) ?>">
        <input type="hidden" name="nb-projets" value="<?= htmlspecialchars($nb_projets) ?>">
        <input type="hidden" name="competences" value="<?= htmlspecialchars($competences) ?>">
        <input type="hidden" name="liste-projets" value="<?= htmlspecialchars($liste_projets) ?>">
        <input type="hidden" name="centre-interet" value="<?= htmlspecialchars($centre_interet) ?>">
        <input type="hidden" name="langues-parles" value="<?= htmlspecialchars($langues_parles) ?>">
        <input type="submit" value="MODIFIER">
    </form>
    
</body>
<script>

</script>

</html>