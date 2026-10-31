<?php
declare(strict_types=1);

require 'vendor/autoload.php';


use App\Compte;
use App\Montant;
use App\StatutTranscation;

/*
$montant2 = new Montant(3000);
$montant3 = $montant1->ajouter(100);
echo $montant1->showMontant() ."\n";
echo $montant2->showMontant() ."\n";
// $montant->ajouter(200);
*/
   
echo StatutTranscation::PENDING->value."\n";
echo StatutTranscation::tryFrom("Echoué")->label()."\n";
echo StatutTranscation::tryFrom("inconnu");


$montant1 = new Montant(4000);
$montant2 = new Montant(3000);
$montant3 = new Montant(3000);

$compte = new Compte("Louis",$montant1);
echo $compte->getSolde()->montant."\n";
echo $compte->crediter($montant2)."\n";
echo $compte->debiter($montant3);
