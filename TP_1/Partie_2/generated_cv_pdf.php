<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if(session_status() === PHP_SESSION_NONE) :
session_name('TP1_PHP');
session_start();
endif;

ob_start(); // Commencer à capturer la sortie HTML
include 'cv.php'; // Ton fichier HTML/PHP avec le CV
$html = ob_get_clean(); // Récupère le HTML généré

// Options pour DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // Pour charger des images externes

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// Format A4 portrait
$dompdf->setPaper('A4', 'portrait');

// Génération du PDF
$dompdf->render();

// Envoi du PDF au navigateur
$dompdf->stream('cv.pdf', ['Attachment' => false]); // false = l'ouvre dans le navigateur