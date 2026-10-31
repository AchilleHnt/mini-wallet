<?php 

namespace App;

enum StatutTranscation : string
{
    case APPROVED = "Approuvé";
    case PENDING = "En attente";
    case FAILED = "Echoué";
    

    public function label() : string 
    {
        return match ($this) {
            self::APPROVED => "Approuvé",
            self::PENDING => "En attente",
            self::FAILED => "Echoué"
        };
    }

    public function estFinal()
    {

    }
}