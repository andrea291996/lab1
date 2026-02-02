<?php

require_once __DIR__ . '/Models/Wagon.php'; 
require_once __DIR__ . '/Models/Train.php';

use App\Models\Wagon;
use App\Models\Train;

try{
$wagon1 = new Wagon("ciao");
}catch(\Exception $e){
    $e->getMessage();
}

exit;
$wagon2 = new Wagon(40, "seconda");
$wagon3 = new Wagon(40, "prima");
echo "\n";

echo $wagon3->get_class();
echo "\n";  // mi deve rendere la classe "prima"



echo $wagon1->passengers_count();
echo "\n";  // questo dà 0
echo $wagon1->seats_count();  // questo dà 40, ovvero il numero totale di posti
echo "\n"; 
echo $wagon1->add_passengers(10);  // questo restituisce il numero di passeggeri che avanzano, in questo caso 0
echo "\n"; 

echo $wagon1->passengers_count();  // adesso dà 10
echo "\n"; 
echo $wagon1->add_passengers(55);  // questo adesso restituisce 25
echo "\n"; 
echo $wagon1->passengers_count();  // adesso dà 40
echo "\n"; 
echo $wagon1->remove_passengers(15);
echo "\n"; 
echo $wagon1->passengers_count();  // adesso dà 25
echo "\n"; 
echo $wagon1->remove_passengers(25);
echo "\n"; 
echo $wagon1->passengers_count();  // adesso dà 0
echo "\n"; 
echo $wagon1->add_passengers(50);
echo "\n"; 
var_dump($wagon1);
echo "NUMERO PASSEGGERI: ";
echo $wagon1->passengers_count();  
echo "\n"; 
echo $wagon1->remove_passengers(20);
echo "\n"; 

// Un vagone vuoto restituisce tutti i posti come liberi
// Un vagone pieno restituisce 0
// Il treno restituisce la somma corretta dei posti liberi
echo "POSTI DISPONIBILI: ";
echo $wagon1->seats_available();
echo "\n"; 

 
$train = new Train();
$train->add_wagon($wagon1);
$train->add_wagon($wagon2);
$train->add_wagon($wagon3);

echo $train->passengers_count();  // questo dà 0
echo "\n"; 
echo $train->seats_count();  // questo dà 120, ovvero il numero totale di posti
echo "\n"; 

echo "ciao"; 
echo "\n"; 
echo $train->add_passengers(126540, "seconda");  // questo restituisce il numero di passeggeri che avanzano, in questo caso 0. I paggeggeri vengono alloggiati nel primo vagone fino ad esaurirlo, poi nel secondo fino ad esaurirlo e così via

echo "\n"; 

echo $train->passengers_count();  // questo dà 10
echo "\n"; 
$train->passengers_distribution();  // questo restituisce una lista con la distribuzione dei passeggeri nei vagono, in questo caso [10, 0, 0]
echo "\n"; 
echo "\n"; 
echo "\n"; 
$train->add_passengers(100);  // questo restituisce ancora 0
$train->passengers_count();  // questo dà 110
$train->passengers_distribution();  // questo restituisce [40, 40, 30]
$train->remove_passengers(71);  // i passeggeri vengono rimossi dall'ultimo vagone fino a svuotarlo, poi si passa al penultimo e così via
$train->passengers_count();  // questo dà 75
$train->passengers_distribution();  // questo restituisce [40, 35, 0]
echo "ciao"; 
var_dump($train->passengers_distribution());
echo "\n"; 
var_dump($train);
echo "\n"; 
$train->seats_available();

echo "REPORT";

$train->report();