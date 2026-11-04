<?php 

namespace Traits;

trait Horodatage
{
    public function logs()
    {
        return $date = "[".date("Y-m-d H:i:s")."]";
    }
}