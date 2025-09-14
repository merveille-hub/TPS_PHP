<?php
InterpreterFormulaire($_GET);

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
    AjouterEtSupprimerDoublons('NonTrierEmailsT.txt', $email);
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

function InterpreterFormulaire(array $data)
{
  if (isset($data["action"])) {
    $action = $data["action"];
    if ($action === "emails") {
      TelechargerFichier("Emails.txt");
    }
    if ($action === "non-valide") {
      TelechargerFichier("adressesNonValides.txt");
    }
    if ($action === "supprimer-doublons") {
      SupprimerDoublons('NonTrierEmailsT.txt');
      TelechargerFichier('NonTrierEmailsT.txt');
    }
    if ($action === "trier-emails") {
      TrierFichier('EmailsT.txt');
      SupprimerDoublons('EmailsT.txt');
      TelechargerFichier('EmailsT.txt');
    }
    if ($action === "separer-emails") {
      $folder = __DIR__ . '/test'; // chemin du dossier
      $files = [];

      $files = AllFilesDir();

      foreach ($files as $key => $file) {
        //echo ($file);
        //AjouterFichier($zip, $file);
        AjouterTxtFilesInZipFiles();
      }

      TelechargerZipFile(__DIR__ . '/application.zip');
    }
  }
}
function AjouterFichier(ZipArchive $zipArchive, string $cheminFichier, string $nomFichierZip = './archive.zip')
{
  if ($zipArchive->open($nomFichierZip, ZipArchive::CREATE) !== TRUE) {
    exit("Impossible d'ouvrir le fichier $nomFichierZip\n");
  }

  $nomFichierDansZip = basename($cheminFichier); // Obtient juste le nom du fichier
  $zipArchive->addFile($cheminFichier, $nomFichierDansZip);
}
function AjouterTxtFilesInZipFiles(string $zipArchive = 'application.zip')
{
  $zip = new ZipArchive();
  $ret = $zip->open('application.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
  if ($ret !== TRUE) {
    printf('Failed with code %d', $ret);
  } else {
    $options = array('add_path' => '/', 'remove_all_path' => TRUE);
    $zip->addGlob('test/*.{txt}', GLOB_BRACE, $options);
    $zip->close();
  }
}
function AllFilesDir(string $dir = 'test'): array
{
  $folder = __DIR__ . '/' . $dir;
  $files = glob($folder . '/*'); // récupère tout

  // Extraire seulement le nom du fichier (sans chemin)
  $files = array_map('basename', $files);
  //AfficherTableauPretty($files);
  return $files;
}
/**
 * Summary of TelechargerFichier
 * @param string $fichier = "test/mon_fichier.txt"
 * @return void
 */
function TelechargerFichier(string $fichier = "Emails.txt")
{
  //$fichier = "test/mon_fichier.txt";

  // Vérifier que le fichier existe
  if (file_exists($fichier)) {
    //echo $fichier;
    // Forcer le téléchargement
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fichier) . '"');
    header('Content-Length: ' . filesize($fichier));
    readfile($fichier);
    exit;
  } else {
    echo $fichier;
    echo "Fichier introuvable.";
  }
}
function TelechargerZipFile(string $zipPath)
{
  // Forcer le téléchargement
  if (file_exists($zipPath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . basename($zipPath) . '"');
    header('Content-Length: ' . filesize($zipPath));
    readfile($zipPath);

    // Supprimer le fichier temporaire après téléchargement
    unlink($zipPath);
    exit;
  } else {
    echo $zipPath;
    echo "Fichier introuvable.";
  }
}
function FaireChoix() {}
function AjouterAdresse(string $filename, string $adresse)
{
  file_put_contents($filename, $adresse);
}
function TrierFichier($filename)
{
  //$valeurFichier = file_get_contents($filename);
  $fichier = fopen($filename, "a+");
  $lignes =  [];
  while (!feof($fichier)) {
    $lignes[] = fgets($fichier);
  }
  //$tableau = explode(',', $valeurFichier);
  sort($lignes);
  file_put_contents($filename, $lignes);
}
function AjouterEtSupprimerDoublons($filename, string $emailAdress)
{
  $lignes = file_get_contents($filename);
  if (!str_contains($lignes, $emailAdress)) {
    file_put_contents($filename, $emailAdress, FILE_APPEND);
  }
}
function AjouterEtSupprimerDoublonsLigneParLigne($filename, string $emailAdress)
{
  $file = fopen($filename, 'a+');
  $trouve = false;
  while (!feof($file)) {
    $ligne = fgets($file);
    if (trim($ligne) === trim($emailAdress)) {
      $trouve = true;
      break;
    }
  }
  if ($trouve === false) {
    fputs($file, $emailAdress . PHP_EOL);
  }
}
function SupprimerDoublons(string $filename = __DIR__ . '/Emails.txt'){
 
  //$filename = __DIR__ . '/Emails.txt';

  // Vérifier si le fichier existe
  if (!file_exists($filename)) {
      die("Fichier introuvable !");
  }

  // Lire tout le fichier en tableau (chaque ligne devient un élément)
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  // Supprimer les doublons
  $lines = array_unique($lines);

  // Réécrire le fichier avec les lignes uniques
  file_put_contents($filename, implode(PHP_EOL, $lines) . PHP_EOL);

  //echo "Doublons supprimés avec succès !";
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
    //echo $key;
    //AfficherTableauPretty($domaine);
    $path = __DIR__ . "/test/" . preg_replace('/[^a-zA-Z0-9._-]/', '_', $key) . '.txt';
    //$lignes = file_get_contents($path);
    //echo $path;
    //$file = fopen($path, 'a+');
    foreach ($domaine as $email) {
      AjouterEtSupprimerDoublonsLigneParLigne($path, $email);
    }
    /* 
        //file_put_contents($path, $email . PHP_EOL, FILE_APPEND);
      //AjouterEtSupprimerDoublons($path, $email . PHP_EOL);
    } */
    //fclose($file);
  }
}
function AfficherTableauPretty(array $tableau)
{
  echo '<pre>';
  print_r($tableau);
  echo '</pre>';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h2>BIENVENUE SUR VOTRE APPLICATION</h2>
  <form action="" method="get">
    <div>
      <button type="submit" name="action" value="emails">Telecharger 'Emails.txt'</button>
    </div>
    <div style="display: flex; gap: 20px;">
      <button type="submit" name="action" value="non-valide">1. Supprimer les adresses non valides</button>
      <button type="submit" name="action" value="supprimer-doublons">2. Supprimer doublons</button>
      <button type="submit" name="action" value="trier-emails">3. Trier les emails</button>
      <button type="submit" name="action" value="separer-emails">4. Separer emails</button>
    </div>
  </form>
</body>

</html>