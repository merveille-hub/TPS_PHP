<?php
$myEmailFileName = "Emails.txt";
$myEmailFile = fopen($myEmailFileName, "r") or die("Unable to open file!");
$emailsTries = [];
//$pattern = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i';
//$pattern = "/(.+)@(.+)\.([a-z]{3,4})/i";
$pattern = '/^(([^<>\-\+()\[\]\\.,;:\s@"]+(\.[^<>\-\+()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/i';
//$pattern = "/^(.{3,})@([^.]+)\.([a-z]{2,10})$/i";
$adressesNonValidesFileName = "adressesNonValides.txt";
$adressesValidesTriesFileName = "EmailsT.txt";
//$adressesNonValidesFile = fopen($adressesNonValidesFileName, "w+");
//$adressesValidesFile = fopen($adressesValidesTriesFileName, "w+");
while (!feof($myEmailFile)) {
    $email = fgets($myEmailFile);

    if (preg_match($pattern, $email)) {
        //echo 'valide : ' . $email . '<br>';
        AjouterEtSupprimerDoublons($adressesValidesTriesFileName, $email);
    } else {
        //echo 'non valide : ' . $email . '<br>';
        AjouterEtSupprimerDoublons($adressesNonValidesFileName, $email);
        //fwrite($adressesNonValidesFile, $email);
    }
}
TrierFichier($adressesValidesTriesFileName);
/* $domaines[] = ChercherDomaineEmail($adressesNonValidesFileName);
$domaines[] = ChercherDomaineEmail($adressesValidesTriesFileName);
 */
CreateFileForEachDomainAndAddAdresses([
    $adressesNonValidesFileName,
    $adressesValidesTriesFileName
]);
function FaireChoix() {}
function AjouterAdresse(string $filename, string $adresse)
{
    file_put_contents($filename, $adresse);
}
function TrierFichier($filename)
{
    $valeurFichier = file_get_contents($filename);
    $tableau = explode(',', $valeurFichier);
    sort($tableau);
    file_put_contents($filename, $tableau);
}
function AjouterEtSupprimerDoublons($filename, string $emailAdress)
{
    $lignes = file_get_contents($filename);
    if (!str_contains($lignes, $emailAdress)) {
        file_put_contents($filename, $emailAdress, FILE_APPEND);
    }
}
function ChercherDomaineEmail(string $filename): array
{
    $adressesFileStream = fopen($filename, "r");
    $domaines = [];
    while (!feof($adressesFileStream)) {
        $line = trim(fgets($adressesFileStream));
        $parts = explode('@', $line);
        if (!isset($parts[1]) || trim($parts[1]) === '')
            continue;

        $domaine = trim($parts[1]);

        // Initialiser le domaine s'il n'existe pas encore
        if (!isset($domaines[$domaine])) {
            $domaines[$domaine] = [];
        }
        // Ajouter l'email dans le tableau du domaine
        $domaines[$domaine][] = $line;
    }
    //AfficherTableauPretty($domaines);
    fclose($adressesFileStream);
    return $domaines;
}
function CreateFileForEachDomainAndAddAdresses(array $filenames)
{
    foreach ($filenames as $key => $filename) {
        $domaines[] = ChercherDomaineEmail($filename);
    }
    //$domaines = call_user_func_array('array_merge', $domaines);
    $domaines = array_merge_recursive(...$domaines);
    //$domaines = iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($domaines)), false);

    //AfficherTableauPretty($domaines);
    foreach ($domaines as $key => $domaine) {
        echo $key;
        //AfficherTableauPretty($domaine);
        $path = __DIR__ . "/test/" . preg_replace('/[^a-zA-Z0-9._-]/', '_', $key) . '.txt';
        foreach ($domaine as $email) {
            file_put_contents($path, $email . PHP_EOL, FILE_APPEND);
        }
        
    }
}
function AfficherTableauPretty(array $tableau)
{
    echo '<pre>';
    print_r($tableau);
    echo '</pre>';
}
