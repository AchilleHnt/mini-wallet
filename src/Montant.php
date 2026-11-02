<?php 

namespace App;

use Exception\MontantInvalide;

final readonly class Montant 
{
    private const DEVISE = "XOF"; 
    public int $montant;

    public function __construct(
        int $montant
    ){
        if($montant < 0) {
            throw new MontantInvalide();
        }
        $this->montant = $montant;
    }

    public function ajouter(Montant $montant) : Montant
    {
        return new Montant($this->montant + $montant->montant);
    }

    public function soustraire(Montant $montant) : Montant
    {
        return new Montant($this->montant - $montant->montant);
    }

    public function estSuperieurOuEgalA(int $montant) : bool 
    {
        if($this->montant >= $montant) {
            return True;
        } else {
            return False;
        }
    }

    public function egal(int $montant) : bool 
    {
        if($this->montant == $montant) {
            return True;
        } else {
            return False;
        }
    }

    public function zero()
    {
        return new Montant(0); 
    }

    public function showMontant() : string 
    {
        return $this->montant . "" . Montant::DEVISE;
    }
}