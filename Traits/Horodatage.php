<?php 

namespace Traits;

trait Horodatage
{
    public function logs()
    {
        $date = new \DateTime();
        return $date->format('d-m-y H:i:s');
    }
}