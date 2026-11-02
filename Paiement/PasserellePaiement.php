<?php 

namespace Paiement;

use App\Compte;
use App\Montant;

interface PasserellePaiement
{
    public function executer(Compte $src, Compte $dest, Montant $montant) : string;

    public function nom();
}