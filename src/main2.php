<?php

declare(strict_types=1);

require_once __DIR__ . '/Models/Wagon.php'; 
require_once __DIR__ . '/Models/Train.php';

use App\Models\Wagon;
use App\Models\Train;

class errore{};

try{
$wagon1 = new Wagon(40);
$wagon2 = new Wagon(40, "prima");
$wagon3 = new Wagon(40);
$treno = new Train();
$treno->add_wagon($wagon1);
$treno->add_wagon($wagon2);
$treno->add_wagon($wagon3);
$treno->add_passengers("10");
$treno->remove_passengers("ciao");
var_dump($treno->passengers_distribution());
}
catch(\Throwable $t){
    echo $t->getMessage();
}

