<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Compte;
use App\Montant;
use Paiement\PasserelleB;
use Service\TransfertService;

// Deux comptes de 3 000 FCFA
$a = new Compte('A', new Montant(3000));
$b = new Compte('B', new Montant(3000));

// On choisit la passerelle : c'est la seule ligne à changer pour en utiliser une autre
$passerelle = new PasserelleB();
$service    = new TransfertService($passerelle);

// A envoie 1 000 FCFA à B
$service->transferer($a, $b, new Montant(1000));

echo $passerelle->logs() . PHP_EOL;
echo "Solde de A : ".$a->getSolde()->montant."\n";
echo "Solde de B : ".$b->getSolde()->montant."\n";
