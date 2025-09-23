<?php
session_name('TP1_PHP');
session_start();
$data = $_SESSION;
$infos_perso = $data['infos-perso'];
$experience_perso = $data['experiences-perso'];
$formations = $data['formations'];
$competences_perso = $data['competence-perso'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CV <?= $data['infos-perso']['firstname'] . $data['infos-perso']['lastname'] ?></title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #fff;
            color: #2b2b2b;
            margin: 40px auto;
            max-width: 800px;
            padding: 20px;
        }

        .header {
            background-color: #e6dbd5;
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .header img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            margin-right: 20px;
            object-fit: cover;
        }

        .header-info {
            font-family: 'Georgia', serif;
        }

        .header-info h1 {
            margin: 0;
            font-weight: bold;
            font-size: 28px;
        }

        .header-info h2 {
            margin: 4px 0 12px 0;
            font-weight: normal;
            font-style: italic;
            font-size: 18px;
        }

        .header-info p {
            margin: 3px 0;
            font-size: 14px;
        }

        h3 {
            border-bottom: 2px solid #2b2b2b;
            font-size: 16px;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1.5px;
        }

        .two-columns {
            display: flex;
            gap: 40px;
        }

        .left-column {
            flex: 1;
        }

        .right-column {
            flex: 2;
        }

        .section {
            margin-bottom: 30px;
        }

        .skills ul {
            list-style-type: none;
            padding-left: 0;
        }

        .skills ul li::before {
            content: '•';
            color: #2b2b2b;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        .experience-item {
            margin-bottom: 20px;
        }

        .experience-item .title {
            font-weight: bold;
            font-style: italic;
        }

        .school-item .diplome {
            font-weight: bold;
            color: #513a3aff;
            font-style: italic;
        }

        .experience-item .company,
        .school {
            font-weight: bold;
        }

        .experience-item .date {
            float: right;
            font-style: italic;
            font-weight: normal;
        }

        .experience-item ul {
            margin: 8px 0 0 20px;
            padding-left: 0;
        }

        .experience-item ul li {
            margin-bottom: 6px;
        }

        .education p {
            margin: 0;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div id="cv" style="background-color: #f7f1ed; padding: 5%">
        <div class="header">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="<?= $data['infos-perso']['firstname'] . $data['infos-perso']['lastname'] ?>" />
            <div class="header-info">
                <h1><?= $data['infos-perso']['firstname'] . ' ' . $data['infos-perso']['lastname'] ?></h1>
                <h2><?= $infos_perso['poste'] ?></h2>
                <p><?= $infos_perso['ville'] . ', ' . $infos_perso['code-postal'] ?></p>
                <p><?= $infos_perso['email'] ?></p>
                <p><?= $infos_perso['phone'] ?></p>
            </div>
        </div>

        <div class="two-columns">
            <div class="left-column">
                <div class="section summary">
                    <h3>Summary</h3>
                    <p>Senior Analyst with 5+ years of experience in data analysis, business intelligence, and process optimization. Skilled in driving operational efficiency, forecasting, and leading data-driven strategies to support business decisions and improvements. Strong communicator focused on results.</p>
                </div>

                <div class="section skills">
                    <h3>Skills</h3>
                    <ul>
                        <?php
                        foreach ($competences_perso['competences'] as $key => $competence) :
                            if (trim($competence) !== '') : ?>
                                <li><?= $competence ?></li>
                        <?php endif;
                        endforeach;
                        ?>
                    </ul>

                </div>
                <div class="section competence">
                    <h3>Competences</h3>
                    <?php
                    foreach ($competences_perso['competences'] as $key => $competence) : ?>
                        <li>&nbsp;&nbsp;<?= $competence ?></li>
                    <?php endforeach;
                    ?>

                </div>
            </div>

            <div class="right-column">
                <div class="section experience">
                    <h3>Experiences</h3>
                    <?php
                    foreach ($experience_perso as $key => $experience) : ?>
                        <div class="experience-item">
                            <span class="date"><?= $experience['date_debut'] ?> — <?= $experience['date_fin'] ?></span>
                            <div class="title"><?= $experience['poste'] ?></div>
                            <div class="company"><?= $experience['localisation'] ?></div>
                            <ul>
                                <?php
                                $descriptions = $experience['description'];
                                $descriptions = explode('\n \t', $descriptions);
                                foreach ($descriptions as $key => $description) : ?>
                                    <li><?= $description ?></li>
                                <?php endforeach;
                                ?>
                            </ul>

                        </div>
                    <?php endforeach;
                    ?>
                </div>

                <div class="section education">
                    <h3>Formations</h3>
                    <?php
                    foreach ($formations as $key => $formation) : ?>
                        <div class="school-item">
                            <div><span class="school"><?= $formation['nom-ecole'] ?></span> - <span class="diplome"><?= $formation['diplome'] ?></span></div>
                            <div class="localisation"><?= $formation['localisation'] ?></div>
                            <span class="date"><?= $formation['date-debut'] ?> — <?= $formation['date-fin'] ?></span>


                            <ul>
                                <?php
                                $descriptions = $formation['description'];
                                //$descriptions = explode('\n \t', $descriptions);
                                foreach ($descriptions as $key => $description) : ?>
                                    <li><?= $description ?></li>
                                <?php endforeach;
                                ?>
                            </ul>

                        </div>
                    <?php endforeach;
                    ?>
                </div>


            </div>
        </div>

    </div>
    <div>
        <!-- Bouton d'impression -->
        <button id="btn-imprimer">🖨️ Imprimer</button>

        <!-- Bouton de téléchargement -->
        <button id="btn-telecharger">⬇️ Télécharger en PDF</button>

        <script>
            document.getElementById('btn-imprimer').addEventListener('click', function() {
                document.getElementById('btn-imprimer').style.display = 'none';
                document.getElementById('btn-telecharger').style.display = 'none';
                window.print();
            });
        </script>

        <!-- Le contenu à convertir en PDF -->
        <div id="cv">
            <!-- Ton CV ici -->
        </div>

        <!-- Import de html2pdf.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

        <script>
            document.getElementById('btn-telecharger').addEventListener('click', function() {
                document.getElementById('btn-imprimer').style.display = 'none';
                document.getElementById('btn-telecharger').style.display = 'none';
                const element = document.getElementById('cv');
                html2pdf().from(element).save('mon-cv.pdf');
            });
        </script>

    </div>
</body>

</html>