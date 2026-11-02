<?php

namespace Paiement;

use App\Compte;
use App\Montant;
use App\StatutTranscation;
use Traits\Horodatage;

class PasserelleA extends PasserelleAbstraite
{
    use Horodatage;
    public function executer(Compte $src, Compte $dest, Montant $montant) : string
    {
        $this->checkMontantZero($montant);
        return StatutTranscation::APPROVED->value;
    }

    public function nom() {
        return "Nom";
    }

    public static function creerStatic(): static
    {
        return new static();
    }
}