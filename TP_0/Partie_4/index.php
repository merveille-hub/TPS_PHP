<?php
InterpreterFormulairePart3($_GET);
//InterpreterFormulairePart2($_GET);

$myEmailFileName = "Emails.txt";
$adressesNonValidesFileName = "adressesNonValides.txt";
$adressesValidesTriesFileName = "EmailsT.txt";

$myEmailFile = fopen($myEmailFileName, "r") or die("Unable to open file!");
$emailsTries = [];
//$pattern = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i';
//$pattern = "/(.+)@(.+)\.([a-z]{3,4})/i";
$pattern = '/^(([^<>\-\+()\[\]\\.,;:\s@"]+(\.[^<>\-\+()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/i';
//$pattern = "/^(.{3,})@([^.]+)\.([a-z]{2,10})$/i";

//$adressesNonValidesFile = fopen($adressesNonValidesFileName, "w+");
//$adressesValidesFile = fopen($adressesValidesTriesFileName, "w+");
while (!feof($myEmailFile)) {
  $email = fgets($myEmailFile);

  if (preg_match($pattern, $email)) {
    //echo 'valide : ' . $email . '<br>';
    AjouterEtSupprimerDoublons($adressesValidesTriesFileName, $email);
    AjouterEtSupprimerDoublons($myEmailFileName, $email);
    AjouterEtSupprimerDoublons('NonTrierEmailsT.txt', $email);
  } else {
    //echo 'non valide : ' . $email . '<br>';
    AjouterEtSupprimerDoublons($adressesNonValidesFileName, $email);
    AjouterEtSupprimerDoublons($myEmailFileName, $email);
    //fwrite($adressesNonValidesFile, $email);
    //filter_var($j, FILTER_VALIDATE_EMAIL)
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

function InterpreterFormulairePart3(array $data)
{
  var_dump($data);
  if(isset($data['ajout-email']) && !empty($data['ajout-email'])){
    $email = $data["ajout-email"];
    echo $email;
      if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $domain = substr(strrchr($email, "@"), 1);
        if (dns_check_record($domain, "MX") || checkdnsrr($domain, "A")) {
          AjouterEtSupprimerDoublonsLigneParLigne('EmailsT.txt', $email);
          AjouterEtSupprimerDoublonsLigneParLigne('Emails.txt', $email);         
          echo "L'adresse email existe certainement.";
        } else
          echo "L'adresse email n'existe probablement pas.";
      } else {
        echo "L'adresse mail ne correspond pas aux spécifications PHP";
      }
  }
  elseif (isset($data['emails-envoye']) && isset($data['text-email']) &&
        !empty($data['emails-envoye']) && !empty($data['text-email'])) {
    $email = $data['emails-envoye'];
    $message = $data['text-email'];
    $nb_envoi = EnvoyerMailsFichier('EmailsT.txt', $email, $message);
    echo 'nombre d\'envoi : ' . $nb_envoi;
  }
  if (isset($data["action"])) {
    var_dump($data);
    $action = $data['action'];
    if ($action === "envoyer-emails") {
      $email = $data['emails-envoye'];
      $message = $data['text-email'];
      $nb_envoi = EnvoyerMailsFichier('EmailsT.txt', $email, $message);
      echo 'nombre d\'envoi : ' . $nb_envoi;
    } else if ($action === "ajouter-email") {
      var_dump($data);
      $email = $data["email"];
      echo $email;
      if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $domain = substr(strrchr($email, "@"), 1);
        if (dns_check_record($domain, "MX") || checkdnsrr($domain, "A")) {
          AjouterEtSupprimerDoublonsLigneParLigne('EmailsT.txt', $email);
          echo "L'adresse email existe certainement.";
        } else
          echo "L'adresse email n'existe probablement pas.";
      } else {
        echo "L'adresse mail ne correspond pas aux spécifications PHP";
      }
    }
  }
}

function EnvoyerMailsFichier(
  string $filename,
  string $from = "tsafackmerveille15@gmail.com",
  string $message = "Bonjour,\n\nCeci est un message envoyé via PHP.\n\nCordialement,\nVotre site"
) {
  $file = fopen($filename, 'r');
  $headers = FaireHeaders($from);
  $subject = "Sujet du email";
  $count = 0;
  //$message = "Bonjour,\n\nCeci est un message envoyé via PHP.\n\nCordialement,\nVotre site";
  $nb_succes_envoi = 0;
  while (!feof($file)) {
    $to = fgets($file);
    if (EnvoyerMail($to, $subject, $message, $headers)) {
      $nb_succes_envoi++;
      file_put_contents(__DIR__ . 'succes_log.txt', "Envoi reussi pour l'email : $to");
    } else {
      echo "Envoi echoué pour l'email : $to";
      file_put_contents(__DIR__ . 'error_log.txt', "Envoi echoué pour l'email : $to");
    }

    // Quand on atteint 100 emails → pause 60 secondes
        if ($count % 100 == 0) {
          echo "<br>⏸ Pause pour reposer le serveur...<br>";
          flush(); // vide le buffer
          sleep(60); // pause de 1 minute
        }
  }
  return $nb_succes_envoi;
}
function FaireHeaders(string $from = "tsafackmerveille15@gmail.com")
{
  return "From: $from" . "\r\n" .
    "Reply-To: $from" . "\r\n" .
    "Content-type: text/plain; charset=utf-8";
}
function EnvoyerMail(string $to, string $subject, string $message, array|string $additional_headers): bool
{

  $to = "nananalova4@gmail.com";
  $subject = "Sujet du email";
  $message = "Bonjour,\n\nCeci est un message envoyé via PHP.\n\nCordialement,\nVotre site";
  $headers = "From: tsafackmerveille15@gmail.com" . "\r\n" .
    "Reply-To: tsafackmerveille15@gmail.com" . "\r\n" .
    "Content-type: text/plain; charset=utf-8";

  // La fonction mail() retourne TRUE si le mail est accepté pour livraison, FALSE sinon
  if (mail($to, $subject, $message,  $headers)) {
    echo "L'e-mail a été envoyé avec succès.";
    return true;
  } else {
    echo "Échec de l'envoi de l'e-mail.";
    return false;
  }
}
function InterpreterFormulairePart2(array $data)
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
function AjouterEtSupprimerDoublons(string $filename, string $emailAdress)
{
  /* echo 'filename: ';
  var_dump($filename); */
  $lignes = file_get_contents((string)$filename);
  if (!str_contains($lignes, $emailAdress)) {
    file_put_contents($filename, $emailAdress, FILE_APPEND);
  }
}
function AjouterEtSupprimerDoublonsLigneParLigne($filename, string $emailAdress)
{
  $file = fopen($filename, 'a+');
  $trouve = false;
  //echo 'email 264';
  //var_dump($emailAdress);
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
function SupprimerDoublons(string $filename = __DIR__ . '/Emails.txt')
{

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
  <form action="" method="get" id="form-email">
    <div style="display: flex; gap: 20px;">
      <div>
        <label for="emails-envoye">Entrer l'email de l'emetteur</label><br>
        <input type="text" name="emails-envoye" id="emails-envoye"><br><br>
        <label for="">Entrez votre texte</label><br>
        <textarea name="text-email" id="text-email" placeholder="Entrer votre message"></textarea><br>
        <button type="button" name="action" value="envoyer-emails" id="envoyer-emails">Envoyer message à EmailsT.txt</button>
      </div>
      <div>
        <button type="button" id="ajouter-email">Ajouter une adresse email</button>
        <div id="ajout-mail" style="opacity: 0; display: none;">
          <label for="ajout-email">Entrer l'adresse email à mettre dans 'EmailsT.txt': </label><br>
          <input type="text" id="ajout-email" name="ajout-email">
          <br><br>
          <button type="button" name="action" value="ajouter-email" id="envoyer-mail">ENREGISTRER DANS LE FICHIER</button>
        </div>
      </div>
    </div>

    <div id="envoie-mail" style="opacity: 0; display: none;">

    </div>
  </form>
</body>
<script type="text/javascript">
const btn_ajouter_email = document.getElementById('ajouter-email');
const ajout_mail = document.getElementById('ajout-mail');
const form = document.getElementById('form-email');
const btn_email_pour_envoyer = document.getElementById('envoyer-emails');
const text_email = document.getElementById('text-email');
const emailInputEnvoye = document.getElementById('emails-envoye');
const btn_envoyer_mail = document.getElementById('envoyer-mail');
const emailInputAjout = document.getElementById('ajout-email');

function VerifierEmails(email) {
  const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(email);
}

function envoyerEmailFichier() {
  const email = emailInputEnvoye.value.trim();
  const textarea = text_email.value.trim();
  if (!VerifierEmails(email) || textarea === "") {
    alert("❌ Veuillez entrer un email valide et un message.");
    return false;
  }
  alert("✅ Email + message valides (simulation envoi)");
  return true;
}

// afficher le champ ajout d'email
btn_ajouter_email.addEventListener('click', function(event){
  event.preventDefault();
  ajout_mail.style.display = "block";
  setTimeout(() => {
    ajout_mail.style.opacity = "1";
  }, 50);
});

// valider ajout d’email
btn_envoyer_mail.addEventListener('click', function(event){
  event.preventDefault();
  const email = emailInputAjout.value.trim();
  if(email === "" || !VerifierEmails(email)){
    alert("❌ Email invalide !");
    emailInputAjout.focus();
  } else {
    alert("✅ Email ajouté dans EmailsT.txt (simulation)");
    form.requestSubmit(); // ✅ envoie normal avec validations et events
  }
});

// valider l’envoi du message principal
btn_email_pour_envoyer.addEventListener('click', function(event) {
  event.preventDefault();
  if (envoyerEmailFichier()) form.requestSubmit(); // ✅ idem ici
});

// validation finale côté JS avant envoi
/* form.addEventListener("submit", function(event) {
  const email = emailInputEnvoye.value.trim();
  if (!VerifierEmails(email)) {
    event.preventDefault();
    alert("❌ Adresse email invalide !");
  } else {
    alert("✅ Email valide, envoi du formulaire...");
  }
}); */
</script>

<!-- <script>
document.getElementById("ajouter-email").addEventListener("click", function () {
    const divAjout = document.getElementById("ajout-mail");

    // Affiche le div
    divAjout.style.display = "block";

    // Petite temporisation pour lancer la transition de l'opacité
    setTimeout(() => {
        divAjout.style.opacity = 1;
    }, 50);
});
function validateEmailValide(email){
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}
// Validation en direct (à chaque frappe)
emailInput.addEventListener("input", function () {
    const email = emailInput.value.trim();

    if (email === "") {
        feedback.textContent = "";
        feedback.style.color = "";
        return;
    }

    if (regex.test(email)) {
        feedback.textContent = "✅ Email valide";
        feedback.style.color = "green";
    } else {
        feedback.textContent = "❌ Email invalide";
        feedback.style.color = "red";
    }
});

// Vérification finale à l'envoi (sécurité côté frontend)
document.getElementById("emailForm").addEventListener("submit", function (e) {
    const email = emailInput.value.trim();

    if (!regex.test(email)) {
        e.preventDefault();
        alert("Adresse email invalide !");
    }
});
</script> -->

</html>