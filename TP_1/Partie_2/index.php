<?php
session_name('TP1_PHP');
session_start();
//$_SESSION = [];
/* if(session_status() === PHP_SESSION_ACTIVE)
{
  unset($_SESSION);
}
else
  session_start(); */
/* echo 'session';
echo '<pre>';
print_r($_SESSION);
echo '</pre>'; */
//todo: mettre session_destroy quand on clique sur "creer un nouveau cv"
//POUR IMPORTER UN FICHIER IMAGE
/* 
<?php
session_start(); // si tu veux stocker les infos en session

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $uploadDir = 'uploads/'; // Assure-toi que ce dossier existe et est accessible
    $fileName = basename($_FILES['photo']['name']);
    $targetFile = $uploadDir . time() . "_" . $fileName;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    // Vérifie si c’est une image valide
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            echo "Image importée avec succès : <br>";
            echo "<img src='$targetFile' alt='Photo utilisateur' style='max-width:200px;'>";
        } else {
            echo "Erreur lors de l'importation de l'image.";
        }
    } else {
        echo "Format d'image non autorisé. Types acceptés : jpg, jpeg, png, gif.";
    }
}
?>
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>


<body>
  <div style="position: absolute; top: 45%; left: 50%; transform: translate(-50%);">
    <button type="button" id="btn-nouveau-cv">CRÉER UN NOUVEAU CV</button>
  </div>

  <div id="infos-perso" style="display: none;"> <!-- à afficher dynamiquement -->
    <fieldset>
      <legend>Coordonnées</legend>
      <h2>Ajoutez vos coordonnées à jour afin que les employeurs et les recruteurs puissent facilement vous joindre.</h2>
      <form action="infos_perso.php" enctype="multipart/form-data" method="post" id="form-infos-perso">
        <div class="grid-2" style="gap: 50px;">
          <div>
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" placeholder="John" value="Merveille">
          </div>
          <div>
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" placeholder="Doe" value="Tsafack">
          </div>
          <div>
            <label for="phone">Téléphone</label>
            <input type="tel" name="phone" id="phone" value="+212 617807220">
          </div>
          <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="exemple@exemple.com" value="tsafackmerveille15@gmail.com">
          </div>
          <div>
            <label for="poste">Intitulé de poste désiré</label>
            <input type="text" name="poste" id="poste" placeholder="Comptable" value="IT engineer">
          </div>
          <div>
            <label for="photo">Téléverser votre photo</label>
            <input type="file" name="photo" id="photo" accept="image/*"><!-- doit etre required -->
          </div>
        </div>

        <details>
          <summary>Informations Complémentaires</summary>
          <div class="grid-2" style="gap: 50px;">
            <div>
              <label for="pays">Pays</label>
              <input type="text" name="pays" id="pays" placeholder="Maroc" value="Maroc">
            </div>
            <div>
              <label for="ville">Ville</label>
              <input type="text" name="ville" id="ville" placeholder="Tetouan" value="Tétouan">
            </div>
            <div>
              <label for="adresse">Adresse</label>
              <input type="text" name="adresse" id="adresse" placeholder="Avenue Khenifra" value="Avenue Khenifra">
            </div>
            <div>
              <label for="code-postal">Code postal</label>
              <input type="text" name="code-postal" id="code-postal" placeholder="93150" value="93150">
            </div>
          </div>
        </details>
        <br>
        <div class="flex-2" style="position: relative; left: 45%;">
          <button type="button" id="btn-infos-perso" name="actionne" value="btn-infos-perso">ENVOYER : SUIVANT</button>
          <button type="reset">REINITIALISER</button>
        </div>
      </form>
    </fieldset>
  </div>
  <div id="experience-perso" style="display: none;"> <!-- à afficher dynamiquement -->
    <fieldset>
      <legend>Expérience</legend>
      <h2>Énumérez votre expérience professionnelle en commençant par le poste le plus récent en premier.</h2>
      <form action="experience_perso.php" method="post" id="form-experience-perso">
        <div id="experiences-container">
          <div class="experience-entry poste-1" name="experience[]" value="experience">
            <div class="grid-2 intitule-poste">
              <div>
                <label for="intitule-poste">Intitulé de poste</label><br>
                <input type="text" name="intitule-poste[]" placeholder="Comptable" value="Data Analyst Engineer">
              </div>
              <div>
                <label for="employeur">Employeur</label><br>
                <input type="text" name="employeur[]" placeholder="Orange" value="Microsoft">
              </div>
              <div>
                <label for="localisation-experience">Localisation</label><br>
                <input type="text" name="localisation-experience[]" placeholder="Tétouan Morocco" value="Tetouan Morocco">
              </div>
              <div class="grid-cols-2">
                <div>
                  <label for="date-debut">Date de debut</label><br>
                  <input type="date" name="date-debut[]" value="2025-06-22" required>
                </div>
                <div>
                  <label for="date-fin">Date de fin</label><br>
                  <input type="date" name="date-fin[]" value="2025-09-22" required>
                </div>
              </div>
            </div>
            <div>
              <label for="description">Description poste</label><br>
              <input type="text" name="description[]" id="description" class="flex-1" rows="10" cols="40"
                placeholder="Satisfaction client accrue grâce à des solutions adaptées.
                            Gestion de budgets de projet avec un retour sur investissement élevé.
                            Formation et mentorat d'équipes pour maximiser le potentiel." value="• Satisfaction client accrue grâce à des solutions adaptées.
                        • Gestion de budgets de projet avec un retour sur investissement élevé.
                        • Formation et mentorat d'équipes pour maximiser le potentiel." />
            </div>
            <hr>
          </div>
        </div>

        <button type="button" id="btn-ajouter-experience">Ajouter une autre expérience</button>

        <div class="flex-2" style="position: relative; left: 45%;">
          <button type="button" id="btn-experience-perso" name="actionne" value="btn-experience-perso">ENVOYER : SUIVANT</button>
          <button type="reset">REINITIALISER</button>
        </div>
      </form>

    </fieldset>
  </div>
  <div id="formations-perso" style="display: none;">
    <fieldset>
      <legend>Formations</legend>
      <h2>Ajoutez vos détails académiques, même si vous n'avez pas encore obtenu votre diplôme.</h2>
      <form action="formation_perso.php" enctype="multipart/form-data" method="post" id="form-formation-perso">
        <div class="grid-2">
          <div id="formations-container">
            <div class="formation-entry poste-1">
              <div class="grid-2 intitule-formation">
                <div>
                  <label for="nom-ecole">Nom de l'école: </label>
                  <input type="text" name="nom-ecole[]" id="nom-ecole" placeholder="ENSA de Tétouan" value="ENSA de Tétouan">
                </div>
                <div>
                  <label for="localisation-emploi">Localisation</label>
                  <input type="text" name="localisation-emploi[]" id="localisation-emploi" placeholder="New York" value="Tetouan">
                </div>
                <div>
                  <label for="diplome">Diplome</label>
                  <input type="text" name="diplome[]" id="diplome" placeholder="Licence en finance" value="Ingenieur en Génie Informatique">
                </div>
                <div class="grid-cols-2">
                  <div>
                    <label for="date-debut">Date de debut</label>
                    <input type="date" name="date-debut[]" id="date-debut" value="2025-06-22" required>
                  </div>
                  <div>
                    <label for="date-fin">Date de fin</label>
                    <input type="date" name="date-fin[]" id="date-fin" value="2025-09-22" required>
                  </div>
                </div>
                <div>
                  <label for="description">Description poste</label>
                  <input type="text" name="description[]" id="description" class="flex-1" rows="10" cols="40"
                    placeholder="Formation axée sur l’administration des réseaux, la cybersécurité et les systèmes embarqués." />
                </div>
              </div>
            </div>
          </div>
        </div>

        <button type="button" id="btn-ajouter-formation">Ajouter une autre formation</button>

        <div class="flex-2" style="position: relative; left: 45%;">
          <button type="button" id="btn-formation-perso" name="actionne" value="btn-formation-perso">ENVOYER : SUIVANT</button>
          <button type="reset">REINITIALISER</button>
        </div>
      </form>
    </fieldset>
  </div>
  <div id="competences-perso" style="display: none;">
    <fieldset>
      <legend>Compétences</legend>
      <h2>Ajoutez vos compétences professionnelles les plus pertinentes.</h2>
      <form action="competence_perso.php" enctype="multipart/form-data" method="post" id="form-competence-perso">
        <div>
          <div id="competences-container">
            <div class="competence-entry poste-1">
              <div class="grid-2" id="intitule-competence">
                <div class="competence">
                  <label>Compétence</label><br>
                  <input type="text" name="competences[]" placeholder="Office365" value="Merveille">
                </div>
              </div>
              <button type="button" id="btn-ajouter-competence">Ajouter une autre compétence</button>

              <div class="flex-2" style="position: relative; left: 45%;">
                <button type="button" id="btn-competence-perso" name="actionne" value="btn-competence-perso">ENVOYER : SUIVANT</button>
                <button type="reset">REINITIALISER</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </fieldset>
  </div>

  <div id="langues-perso" style="display: none;">
    <fieldset>
      <legend>Langues</legend>
      <h2>Ajoutez vos langues parlés </h2>
      <form action="langue_perso.php" enctype="multipart/form-data" method="post" id="form-langue-perso">
        <div>
          <div id="langues-container">
            <div class="langue-entry poste-1">
              <div class="grid-2" id="intitule-langue">
                <div class="langue">
                  <label>Langue</label><br>
                  <input type="text" name="langues[]" placeholder="Anglais" value="Anglais">
                </div>
              </div>
              <button type="button" id="btn-ajouter-langue">Ajouter une autre langue</button>

              <div class="flex-2" style="position: relative; left: 45%;">
                <button type="button" id="btn-langue-perso" name="actionne" value="btn-langue-perso">ENVOYER : SUIVANT</button>
                <button type="reset">REINITIALISER</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </fieldset>
  </div>
  <div id="centre-interets-perso" style="display: none;">
    <fieldset>
      <legend>Centre d'intérêts</legend>
      <h2>Ajoutez vos centre d'intérêts.</h2>
      <form action="centre-interet_perso.php" enctype="multipart/form-data" method="post" id="form-centre-interet-perso">
        <div>
          <div id="centre-interets-container">
            <div class="centre-interet-entry poste-1">
              <div class="grid-2" id="intitule-centre-interet">
                <div class="centre-interet">
                  <label>Centre d'intérêt</label><br>
                  <input type="text" name="centre-interets[]" placeholder="Reading" value="Reading">
                </div>
              </div>
              <button type="button" id="btn-ajouter-centre-interet">Ajouter un autre centre d'intérêt</button>

              <div class="flex-2" style="position: relative; left: 45%;">
                <button type="button" id="btn-centre-interet-perso" name="actionne" value="btn-centre-interet-perso">ENVOYER : SUIVANT</button>
                <button type="reset">REINITIALISER</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </fieldset>
  </div>

  <div id="motivations-perso" style="display: none;">
    <fieldset>
      <legend>Motivation</legend>
      <h2>Parlez brièvement de vous, pourquoi ce poste vous intéresse, et ce qui vous motive.</h2>

      <form action="motivation_perso.php" method="post" id="form-motivation-perso">
        <div>
          <label for="motivation">Votre message</label><br>
          <textarea
            name="motivation"
            id="motivation"
            rows="6"
            cols="150"
            placeholder="Exemple : Passionné(e) par le domaine de la data, je souhaite rejoindre votre entreprise pour..."
            required></textarea>
        </div>

        <br>
        <div style="text-align: center;">
          <button type="button" id="btn-motivation-perso" name="actionne" value="btn-motivation-perso">ENVOYER : SUIVANT</button>
          <button type="reset">Réinitialiser</button>
        </div>
      </form>
    </fieldset>

  </div>
  <div id="resume-perso" style="display: none;">
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

      .grid-2-resume {
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
    <div class="container">
      <h1>Récapitulatif de votre CV</h1>
      <?php
        $data = $_SESSION;
        $infos_perso = $data['infos-perso'];
        $experience_perso = $data['experiences-perso'];
        $formations = $data['formations'];
        $competences_perso = $data['competence-perso'];
        $langues = $data['langues'];
        $centre_interets = $data['centre-interets'];
        $motivation = $data['motivation-perso'];
      ?>
      <div class="section">
        <h2>Informations personnelles</h2>
        <div class="grid-2-resume">
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
          <p><strong>Description : </strong><?php var_dump($formation['description']); ?></p>
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
            <p><strong>Description : </strong><?= $experience['description'] ?></p>
            <hr>
          <?php endforeach;
          ?>
        </div>

        <div class="section">
          <h2>Compétences</h2>
          <ul>
            <?php foreach ($competences_perso['competences'] as $key => $competence) : ?>
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
      <button type="button" id="btn-valider" name="actionne" value="btn-valider">VALIDER</button>
      <button type="button" id="btn-recommencer" name="actionne" value="btn-recommencer">RECOMMENCER</button>
    </div>
  </div>
</body>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Sélection des éléments
    const btnNouveauCv = document.getElementById('btn-nouveau-cv');
    const infosPerso = document.getElementById('infos-perso');
    const formInfosPerso = document.getElementById('form-infos-perso');
    const btnInfosPerso = document.getElementById('btn-infos-perso');
    const experiencePerso = document.getElementById('experience-perso');

    // Au départ : cacher les formulaires
    infosPerso.style.display = 'none';
    experiencePerso.style.display = 'none';

    // 1) Quand on clique sur "CRÉER UN NOUVEAU CV" => afficher infos perso
    btnNouveauCv.addEventListener('click', function() {
      <?php
      /* if(session_status() === PHP_SESSION_ACTIVE)
        $_SESSION = []; */
      ?>

      infosPerso.style.display = 'block';
      btnNouveauCv.style.display = 'none';
    });

    // 2) Quand on clique sur "ENVOYER : SUIVANT" dans infos perso
    document.getElementById('btn-infos-perso').addEventListener('click', function() {
      const form = document.getElementById('form-infos-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);

      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur :', data);

          // Passe à l'étape suivante (afficher formulaire expérience)
          document.getElementById('infos-perso').style.display = 'none';
          document.getElementById('experience-perso').style.display = 'block';
        })
        .catch(error => {
          console.error("Erreur lors de l'envoi des infos perso :", error);
        });
    });
    //a regarder à la maison -
    //:;:
    document.getElementById('btn-experience-perso').addEventListener('click', function() {
      const form = document.getElementById('form-experience-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);


      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur :', data);

          // Passe à l'étape suivante (afficher formulaire formations)
          document.getElementById('experience-perso').style.display = 'none';
          document.getElementById('formations-perso').style.display = 'block';
        })
        .catch(error => {
          console.error("Erreur lors de l'envoi des infos perso :", error);
        });
    });

    document.getElementById('btn-ajouter-experience').addEventListener('click', function() {
      const container = document.getElementById('experiences-container');
      const experiences = container.getElementsByClassName('experience-entry');
      const last = experiences[experiences.length - 1];
      const clone = last.cloneNode(true); // duplique le bloc

      // Réinitialise les champs dans le clone
      const inputs = clone.querySelectorAll('input, textarea');
      inputs.forEach(input => input.value = '');

      container.appendChild(clone);
    });

    //btn-formation-perso
    document.getElementById('btn-formation-perso').addEventListener('click', function() {
      const form = document.getElementById('form-formation-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);


      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur :', data);

          // Passe à l'étape suivante (afficher formulaire compétences)
          document.getElementById('formations-perso').style.display = 'none';
          document.getElementById('competences-perso').style.display = 'block';
        })
        .catch(error => {
          console.error("Erreur lors de l'envoi des infos perso :", error);
        });
    });

    document.getElementById('btn-ajouter-formation').addEventListener('click', function() {
      const container = document.getElementById('formations-container');
      const formations = container.getElementsByClassName('formation-entry');
      const last = formations[formations.length - 1];
      const clone = last.cloneNode(true); // duplique le bloc

      // Réinitialise les champs dans le clone
      const inputs = clone.querySelectorAll('input, textarea');
      inputs.forEach(input => input.value = '');

      container.appendChild(clone);
    });

    document.getElementById('btn-competence-perso').addEventListener('click', function() {
      const form = document.getElementById('form-competence-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);

      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur : ', data);
          //Passe à l'étape suivante (afficher formulaire resumé)
          document.getElementById('competences-perso').style.display = 'none';
          document.getElementById('langues-perso').style.display = 'block';
        })
        .catch(error => {
          console.error("Erreur lors de l'envois des compétences " + error);
        });
    });

    /* function creerCompteurCompetence() {
      let compteur = 0; // privé, statique
      return function() {
        compteur++;
        console.log("Compteur =", compteur);
      };
    }    */
    document.getElementById('btn-ajouter-competence').addEventListener('click', function() {
      const newEntry = document.createElement('div');
      const container = document.getElementById('intitule-competence');
      newEntry.classList.add('competence');

      newEntry.innerHTML = `
        <label>Compétence</label><br>
        <input type="text" name="competences[]" placeholder="Nouvelle compétence">
      `;

      container.appendChild(newEntry);
    });

    document.getElementById('btn-langue-perso').addEventListener('click', function() {
      const form = document.getElementById('form-langue-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);

      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur : ', data);
          //Passe à l'étape suivante (afficher formulaire resumé)
          document.getElementById('langues-perso').style.display = 'none';
          document.getElementById('centre-interets-perso').style.display = 'block';
        })
        .catch(error => {
          console.error("Erreur lors de l'envois des centres d'intérêts " + error);
        });
    });

    document.getElementById('btn-ajouter-langue').addEventListener('click', function() {
      const newEntry = document.createElement('div');
      const container = document.getElementById('intitule-langue');
      newEntry.classList.add('langue');

      newEntry.innerHTML = `
        <label>Compétence</label><br>
        <input type="text" name="langues[]" placeholder="Nouvelle langue">
      `;

      container.appendChild(newEntry);
    });

    document.getElementById('btn-centre-interet-perso').addEventListener('click', function() {
      const form = document.getElementById('form-centre-interet-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);

      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur : ', data);
          //Passe à l'étape suivante (afficher formulaire resumé)
          document.getElementById('centre-interets-perso').style.display = 'none';
          document.getElementById('motivations-perso').style.display = 'block';
        })
        .catch(error => {
          console.error("Erreur lors de l'envois des centre d'intérêts " + error);
        });
    });

    document.getElementById('btn-ajouter-centre-interet').addEventListener('click', function() {
      const newEntry = document.createElement('div');
      const container = document.getElementById('intitule-centre-interet');
      newEntry.classList.add('centre-interet');

      newEntry.innerHTML = `
        <label>Compétence</label><br>
        <input type="text" name="centre-interets[]" placeholder="Nouveau centre d'intérêt">
      `;

      container.appendChild(newEntry);
    });

    document.getElementById('btn-motivation-perso').addEventListener('click', function() {
      const form = document.getElementById('form-motivation-perso');
      const formData = new FormData(form);
      console.log('form: ', form);
      console.log('form action: ', form.action);

      fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
          }
          return response.text();
        })
        .then(data => {
          console.log('Réponse du serveur : ', data);
          //Passe à l'étape suivante (afficher formulaire resumé)
          document.getElementById('motivations-perso').style.display = 'none';
          //document.getElementById('resume-perso').style.display = 'block';
          window.location.href = 'resume.php';
        })
        .catch(error => {
          console.error("Erreur lors de l'envois des centres d'intérêts " + error);
        });
    });

    
    /* document.getElementById('btn-ajouter-competence').addEventListener('click', function() {
      const container = document.getElementById('competences-container');
      const competences = container.getElementsByClassName('intitule-competence');
      const last = competences[competences.length - 1];
      const clone = last.cloneNode(true); // duplique le bloc
     
      const btn_ajouter_competence = document.getElementById('btn-ajouter-competence');
      //const competence = container.getElementById('competence');
      console.log(competences);
      
      //const last = competences[competences.length - 1];
      //const clone = competence.cloneNode(true); // duplique le bloc

      // Réinitialise les champs dans le clone
      const inputs = clone.querySelectorAll('input, textarea');
      inputs.forEach(input => input.value = '');
      container.insertBefore(clone, btn_ajouter_competence);
      //container.appendChild(clone);
    });
 */
  });
</script>

</html>