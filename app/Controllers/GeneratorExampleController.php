<?php

namespace App\Controllers;

class GeneratorExampleController
{
    public function __construct()
    {

    }

    public function index()
    {
        $numbers = $this->lazyRange(1,10_0000);
        
        echo $numbers->current();
        $numbers->next();
        echo $numbers->current();
        $numbers->next();
        echo $numbers->current();
    }

    private function lazyRange($start,$end)
    {   
        for($i=$start;$i<=$end;$i++)
        {
            yield $i;
        }
    }
}