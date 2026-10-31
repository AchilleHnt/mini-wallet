<?php
declare(strict_types=1);

require 'vendor/autoload.php';


use App\Montant;


$montant1 = new Montant(4000);
$montant2 = new Montant(4000);
$montant3 = $montant1->ajouter(100);
echo $montant1->showMontant() ."\n";
echo $montant2->showMontant() ."\n";
// $montant->ajouter(200);
   
