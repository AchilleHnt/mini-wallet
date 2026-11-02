<?php 

namespace App;

use Exception\SoldeInsuffisant;

class Compte 
{
    public function __construct(
        private string $titulaire,
        private Montant $solde
    ){}

    public function getSolde() : Montant
    {
        return $this->solde;
    }

    public function crediter(Montant $mnt) 
    {
        $this->solde = $this->solde->ajouter($mnt);
    }

    public function debiter(Montant $mnt)
    {
        if($mnt->montant > $this->solde->montant)
        {
            throw new SoldeInsuffisant();
        }
        $this->solde = $this->solde->soustraire($mnt);
    }

    
}