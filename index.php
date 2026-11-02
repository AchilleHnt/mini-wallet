<?php
declare(strict_types=1);

require 'vendor/autoload.php';


use App\Compte;
use App\Montant;
use App\StatutTranscation;
use Paiement\PasserelleA;
use Paiement\PasserelleB;
use Service\TransfertService;

/*
$montant2 = new Montant(3000);
$montant3 = $montant1->ajouter(100);
echo $montant1->showMontant() ."\n";
echo $montant2->showMontant() ."\n";
// $montant->ajouter(200);
*/
   /*
echo StatutTranscation::PENDING->value."\n";
echo StatutTranscation::tryFrom("Echoué")->label()."\n";
echo StatutTranscation::tryFrom("inconnu");


$montant1 = new Montant(4000000);
$montant2 = new Montant(500000);
$montant3 = new Montant(3000);

$compte1 = new Compte("Louis",$montant1);
$compte2 = new Compte("Jean",$montant2);

echo $compte1->getSolde()->montant."\n";
echo $compte1->crediter($montant2)."\n";
echo $compte1->debiter($montant3)."\n";


$passerelle1 = new PasserelleA();
echo $passerelle1->executer($compte1,$compte2,$montant1)."\n";
echo $passerelle1->nom()."\n";

$passerelle2 = new PasserelleB();
echo $passerelle2->executer($compte1,$compte2,$montant2)."\n";
echo $passerelle2->nom()."\n";


$transfert = new TransfertService($passerelle2);
var_dump($transfert);
// echo $transfert->showPass($compte1,$compte2,$montant2)."\n";
echo $transfert->transferer($compte1,$compte2,$montant2);*/



$mon1 = new Montant(3000);
$montant = new Montant(1000);


$cp1 = new Compte("A",$mon1);
$cp2 = new Compte("B",$mon1);
var_dump($cp1->getSolde());
var_dump($cp2->getSolde());


$passerelle1 = new PasserelleB();
$service = new TransfertService($passerelle1);
$service->transferer($cp1,$cp2,$montant);

echo $passerelle1->logs()."\n";
var_dump($cp1->getSolde());
var_dump($cp2->getSolde());


// echo $cp2->getSolde()."\n";
