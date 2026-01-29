<?php


use App\Models\Wagon;
use App\Models\Train;

$wagon1 = new Wagon(40);
$wagon2 = new Wagon(40, "prima");
$wagon3 = new Wagon(40);

$train = new Train();
$train->add_wagon($wagon1);
$train->add_wagon($wagon2);
$train->add_wagon($wagon3);
$res = $train->get_wagons_of_class("prima");
echo $train->add_passengers(50, "prima"); //restituisce 0

$train->add_passengers(50, "prima"); //restituisce 0

var_dump($train->passengers_distribution()); //[40,0,10];

echo "\n ciao \n";
echo $train->report($wagon1);

/*
 * Gestire le eccezioni con throw
 */
