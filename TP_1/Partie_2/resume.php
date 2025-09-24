<?php
session_name('TP1_PHP');
session_start();
$data = $_SESSION;
$infos_perso = $data['infos-perso'];
$experience_perso = $data['experiences-perso'];
$formations = $data['formations'];
$competences_perso = $data['competence-perso'];
$langues = $data['langues'];
$centre_interets = $data['centre-interets'];
$motivation = $data['motivation-perso'];
//$descriptions = $data['description'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Récapitulatif CV</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
    }

    h1,
    h2 {
      border-bottom: 2px solid #007BFF;
      padding-bottom: 5px;
      color: #333;
    }

    .section {
      margin-bottom: 30px;
    }

    .grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .experience,
    .competence {
      margin-bottom: 15px;
    }

    .label {
      font-weight: bold;
    }

    .motivation {
      background: #f9f9f9;
      padding: 10px;
      border-left: 4px solid #007BFF;
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Récapitulatif de votre CV</h1>

    <div class="section">
      <h2>Informations personnelles</h2>
      <div class="grid-2">
        <div><span class="label">Nom :</span> <?= $infos_perso['lastname'] ?></div>
        <div><span class="label">Prénom :</span> <?= $infos_perso['firstname'] ?></div>
        <div><span class="label">Email :</span> <?= $infos_perso['email'] ?></div>
        <div><span class="label">Téléphone :</span> <?= $infos_perso['phone'] ?></div>
        <div><span class="label">Ville :</span> <?= $infos_perso['ville'] ?></div>
        <div><span class="label">Poste désiré :</span> <?= $infos_perso['poste'] ?></div>
      </div>
    </div>

    <div class="section">
      <h2>Motivation</h2>
      <p class="motivation">
        <?= $motivation['motivation']; ?>
      </p>
    </div>

    <div class="section">
      <h2>Formations</h2>
      <?php
      foreach ($formations as $index => $formation) :
      ?>
        <p><strong>Ecole : </strong><?= $formation['nom-ecole'] ?></p>
        <p><strong>Diplome : </strong><?= $formation['diplome'] ?></p>
        <p><strong>Localisation : </strong><?= $formation['localisation'] ?></p>
        <p><strong>Periode : </strong><?= $formation['date-debut'] ?> / <?= $formation['date-fin'] ?></p>
        <p><strong>Description : </strong>
        <ul>
          <?php foreach ($formation['description'] as $key => $description) : ?>
            <li><?= $description ?></li>
          <?php endforeach; ?>
        </ul>
        </p>
        <hr>
      <?php endforeach; ?>
    </div>

    <div class="section">
      <h2>Expériences professionnelles</h2>

      <div class="experience">
        <?php
        foreach ($experience_perso as $index => $experience) :
        ?>
          <p><strong>Poste : </strong><?= $experience['poste'] ?> <?= $experience['poste'] ?> </p>
          <p><strong>Employeur : </strong><?= $experience['employeur'] ?></p>
          <p><strong>Localisation : </strong><?= $experience['localisation'] ?></p>
          <p><strong>Periode : </strong><?= $experience['date_debut'] ?> / <?= $experience['date_fin'] ?></p>
          <p><strong>Description : </strong>
            <ul>
              <?php foreach ($experience['description'] as $key => $description) : ?>
                <li><?= $description ?></li>
              <?php endforeach; ?>
            </ul>
          </p>
          <hr>
        <?php endforeach;
        ?>
      </div>

      <div class="section">
        <h2>Compétences</h2>
        <ul>
          <?php 
            echo '<pre>';
            print_r($competences_perso);
            echo '</pre>';
            foreach ($competences_perso['competences'] as $key => $competence) : ?>
            <li><?= $competence ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="section">
        <h2>Langues</h2>
        <ul>
          <?php foreach ($langues as $key => $langue) : ?>
            <li><?= $langue ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="section">
        <h2>Centre d'intérêts</h2>
        <ul>
          <?php foreach ($centre_interets as $key => $centre_interet) : ?>
            <li><?= $centre_interet ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>


  </div>
  <br>
  <div style="text-align: center;">
    <button type="button" id="btn-retour" name="actionne" value="btn-retour">SUIVANT</button>
    <button type="button" id="btn-valider" name="actionne" value="btn-valider">VALIDER</button>
    <button type="button" id="btn-recommencer" name="actionne" value="btn-recommencer">RECOMMENCER</button>
  </div>
  <script>
    document.getElementById('btn-retour').addEventListener('click', function() {

    });
    document.getElementById('btn-valider').addEventListener('click', function() {
      window.location.href = 'cv1.php';
    });
    document.getElementById('btn-recommencer').addEventListener('click', function() {
      window.location.href = 'reset.php';
    });
  </script>

</body>

</html>