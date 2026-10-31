<?php 

namespace App;

use Exception\SoldeInsuffisant;

class Compte 
{
    public function __construct(
        private string $titulaire,
        private Montant $solde
    ){}

    public function crediter(Montant $mnt) 
    {
        return $this->solde->montant + $mnt->montant;
    }

    public function debiter(Montant $mnt)
    {
        if($mnt->montant > $this->solde->montant)
        {
            throw new SoldeInsuffisant();
        }
        return $this->solde->montant - $mnt->montant;
    }

    public function getSolde() : Montant
    {
        return $this->solde;
    }
}