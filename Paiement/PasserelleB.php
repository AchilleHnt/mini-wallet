<?php

namespace Paiement;

use App\Compte;
use App\Montant;
use App\StatutTranscation;
use Exception\PasserelleIndisponible;
use Traits\Horodatage;

class PasserelleB extends PasserelleAbstraite
{
    use Horodatage;
    public function executer(Compte $src, Compte $dest, Montant $montant) : string
    {
        $this->checkMontantZero($montant);
        if($montant->montant > 500000) {
            throw new PasserelleIndisponible();
        }
        return StatutTranscation::APPROVED->value;
    }
    public function nom() {
        return "Nom";
    }
}