<?php 

namespace Exception;

class SoldeInsuffisant extends \DomainException
{
    protected $message = "Solde Insuffisant( le solde est pas suffisant par rapport au retrait)";
}