<?php
if (isset($_GET)) {
    $data = $_GET;
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
    <form action="recap.php" method="post" enctype="multipart/form-data">
        <section class="personal-infos">
            <fieldset>
                <legend>Renseignements Personnels</legend><br>
                Nom : <input type="text" name="nom" id="nom" value="<?= $nom ?>" required><br><br>
                Prenom : <input type="text" name="prenom" id="prenom" value="<?= $prenom ?>"><br><br>
                Age : <input type="number" name="age" id="age" min="1" value="<?= $age ?>" required><br><br>
                Numéro de téléphone : <input type="tel" name="phone" id="phone" value="<?= $phone ?>" required><br><br>
                Email : <input type="email" name="email" id="email" value="<?= $email ?>" required><br><br>
            </fieldset>
        </section>
        <section class="academic-infos">
            <fieldset>
                <legend>Renseignements Académiques</legend>
                <label>Vous êtes en : </label>
                <br>
                <div>
                    <?php
                    $filieres = [
                        "2AP" => "Années Préparatoires",
                        "GSTR" => "Génie des Systèmes et Télécommunications et Réseaux",
                        "GI" => "Génie Informatique",
                        "SCM" => "Supply Chain Management",
                        "GC" => "Génie Civil",
                        "MS" => "MS"
                    ];
                    foreach ($filieres as $key => $f) {
                        $checked = ($filiere == $key) ? 'checked' : '';
                        echo '<label for="' . $key . '">' . $key . '</label>
                        <input type="radio" name="filiere" id="' . $key . '" value="' . $key . '"' . $checked . '?>';
                    }
                    ?>
                </div>
                <div>
                    <?php
                    $annees = ["1e" => "1ère année", "2e" => "2ème année", "3e" => "3ème année"];
                    foreach ($annees as $key => $label) {
                        $checked = ($annee === $key) ? 'checked' : '';
                        echo "<label>$label<input type='radio' name='annee' value='$key' $checked></label> ";
                    }
                    ?>
                </div>

                <div class="modules-suivis">
                    <label for="">Modules suivis cette année : </label>
                </div>
                <div class="projets-realises">
                    <label for="nb-projets">Nombre de projets réalisés cette annés.</label>
                    <input type="number" name="nb-projets" id="nb-projets" min="0" value="<?= $nb_projets ?>">
                </div>

                <div id="liste-projets">
                    <h3>Liste des projets réalisés par l'étudiant : <span style="color: #3796;" class="detail">chaque projet sur sa ligne</span></h3>
                    <textarea name="liste-projets" id="" cols="60" rows="6" placeholder="Entrer vos projets réaliés ici"><?= $liste_projets ?></textarea>
                </div>
                <div class="competences">
                    <h3>Certifications acquis : </h3>
                    <textarea name="competences" id="competences" min="0" cols="60" rows="4" placeholder="DBA1, CCNA, ...."><?= $competences ?></textarea>
                </div>
            </fieldset>
        </section>
        <section class="other-infos">
            <fieldset>
                <legend>Informations Connexes </legend>
                <div id="centre-interet">
                    <h3>Centre d'intérêt : </h3>
                    <textarea name="centre-interet" id="" cols="60" rows="6" placeholder="Entrer vos centres d'intérets ici"><?= $centre_interet ?></textarea>
                </div>
                <div id="langues-parles">
                    <h3>Langues parlées : </h3>
                    <textarea name="langues-parles" id="" cols="60" rows="6" placeholder="Entrer vos langues parlés ici" ><?= $langues_parles ?></textarea>
                </div>
            </fieldset>
        </section>
        <section>
            <fieldset>
                <legend>Vos remarques</legend><br>
                <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                <!-- Le nom de l'élément input détermine le nom dans le tableau $_FILES -->
                <input type="file" name="userfile" id="fichier" value="Choisir un fichier"><br>
            </fieldset>
        </section>
        <br>
        <div style="display: flex; gap: 50px;">
            <input type="submit" name="envoyer" value="ENVOYER">
            <input type="reset" name="reset" value="EFFACER">
        </div>
    </form>
</body>
<script>
    // Attendre que la page soit chargée
    document.addEventListener("DOMContentLoaded", function() {
        /* const nb_projets = document.getElementById('nb-projets');

        nb_projets.addEventListener("input", function() { 
            const nb = nb_projets.value;
            const liste_projets = document.getElementById("liste-projet");
            
            for (let index = 0; index < nb; index++) {
                const div = document.createElement('div');

                // Affichage du numéro correct du projet
                const texte = "Entrer le projet n° " + (index + 1);

                // Créer un label ou texte
                const label = document.createElement("label");
                label.textContent = texte;

                // Créer le champ input
                const input = document.createElement("input");
                input.type = "text";
                input.name = "projet_" + (index + 1);
                input.placeholder = "Nom du projet " + (index + 1);

                // Assembler tout dans la div
                div.appendChild(label);
                div.appendChild(document.createElement("br"));
                div.appendChild(input);

                // Ajouter la div au conteneur principal
                liste_projets.appendChild(div);
            }
        });*/
    });
    /* const champNombre = document.getElementById("monNombre");

    champNombre.addEventListener("input", function() {
        const valeur = champNombre.value;
        document.getElementById("result").innerText = "Vous avez entré : " + valeur;
    }); */
    /* 
        // 1. Créer un élément
        const monBouton = document.createElement('button');

        // 2. Ajouter du contenu et des attributs
        monBouton.textContent = 'Cliquez ici !';
        monBouton.id = 'bouton-dynamique';
        monBouton.classList.add('btn');

        // 3. Sélectionner un élément parent
        const container = document.getElementById('container');

        // 4. Insérer l'élément dans le DOM
        container.appendChild(monBouton);
     */
</script>

</html>