<?php 

namespace Service;

use App\Compte;
use App\Montant;
use App\StatutTranscation;
use Paiement\PasserellePaiement;

class TransfertService 
{
    public function __construct(
        private PasserellePaiement $passerelle
    ){}

    public function transferer(Compte $src, Compte $dest, Montant $montant)
    {
        $statut =  $this->passerelle->executer($src,$dest,$montant);

        if($statut == StatutTranscation::APPROVED->value)
        {
            $src->debiter($montant);
            $dest->crediter($montant);
        }
        
    }
}