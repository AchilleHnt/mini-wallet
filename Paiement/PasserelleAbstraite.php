<?php 

namespace Paiement;

use App\Montant;
use Exception\MontantInvalide;

abstract class PasserelleAbstraite implements PasserellePaiement
{
   function checkMontantZero(Montant $montant)
   {
        if($montant->montant == 0) {
            throw new MontantInvalide();
        }
   }
}