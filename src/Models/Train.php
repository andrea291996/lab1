<?php
declare(strict_types=1);

namespace App\Models;

use InvalidArgumentException;

class Train {
    private int $passengers;
    private int $seats;
    private array $wagons = [];

    //chiedi se è meglio il Type Hinting oppure no
    public function add_wagon(Wagon $vagone): void{
        if(!$vagone instanceof Wagon){
            throw new InvalidArgumentException("L'argomento di add_wagon deve essere un oggetto di tipo Wagon!");
        }
        $this->wagons[] = $vagone;
    }

    public function passengers_count(): int{   
        $vagoni = $this->wagons;
        $totale = 0;
        foreach($vagoni as $vagone){
            $totale_vagone = $vagone->passengers_count();
            $totale = $totale + $totale_vagone;
        }
        $this->passengers = $totale;
        return $totale;
    }

    public function seats_count(): int
    {
        $vagoni = $this->wagons;
        $totalePosti = 0;
        foreach($vagoni as $vagone){
            $totale_posti_vagone = $vagone->seats_count();
            $totalePosti = $totalePosti + $totale_posti_vagone;
        }
        $this->seats = $totalePosti;
        return $totalePosti;
    }

    public function add_passengers($num, string $classe = "seconda"): int 
    {
        if($num < 0){
            throw new InvalidArgumentException("Non puoi inserire un numero negativo!");
        }
        if(!is_numeric($num)){
            throw new InvalidArgumentException("Devi inserire un numero come primo argomento!");
        }
        if($classe !== "seconda" && $classe !== "prima"){
            throw new InvalidArgumentException("Se inserisci il secondo argomento, questo deve essere la stringa -prima- o -seconda-!");
        }
        $vagoni = $this->get_wagons_of_class($classe);
        if(count($vagoni) == 0)
            return $num;
        $esclusi = 0;
        foreach($vagoni as $vagone){
            $esclusi = $vagone->add_passengers($num);
            $num = $esclusi;
            if($esclusi == 0){
                return $esclusi;
            }
        }
        return $esclusi;
    }
        
    public function get_wagons_of_class(string $classe): array{
        if($classe !== "seconda" && $classe !== "prima"){
            throw new InvalidArgumentException("Devi inserire la stringa -prima- o -seconda-!");
        }
        $vagoni = $this->wagons;
        $risultato = [];
        foreach($vagoni as $vagone){
            $classeVagone = $vagone->get_class();
            if($classeVagone == $classe)
            $risultato[] = $vagone;
        }
        return $risultato;
    }

    public function passengers_distribution(): array
    {
        $vagoni = $this->wagons;
        $distribuzione = [];
        foreach($vagoni as $vagone){
            $passeggeriVagone = $vagone->passengers_count();
            $distribuzione[] = $passeggeriVagone;
        }
        return $distribuzione;
    }

    public function remove_passengers($num): int 
    {
        if($num < 0){
            throw new InvalidArgumentException("Non puoi inserire un numero negativo!");
        }
        if(!is_numeric($num)){
            throw new InvalidArgumentException("Devi inserire un numero come argomento!");
        }
        $vagoni = $this->wagons;
        $invertiti = array_reverse($vagoni);
        $nonRimossi = 0;
        foreach($invertiti as $vagone){
            $nonRimossi = $vagone->remove_passengers($num);
            $num = $nonRimossi;
            if($nonRimossi == 0){
                return 0;
            }
        }
        return $nonRimossi;
    }

    public function seats_available(): int{
        $vagoni = $this->wagons;
        $postiDisponibiliTotali = 0;
        foreach($vagoni as $vagone){
            $postiDisponibili = $vagone->seats_available();
            $postiDisponibiliTotali = $postiDisponibiliTotali + $postiDisponibili;
        }
        return $postiDisponibiliTotali;
    }

    public function report(){
        $vagoni = $this->wagons;
        $numero = 1;
        foreach($vagoni as $vagone){
            echo "\n";
            echo "Vagone numero ".$numero."\n";
            echo "Classe: ".$vagone->get_class()."\n";
            echo "Totale posti: ".$vagone->seats_count()."\n";
            echo "Totale passeggeri: ".$vagone->passengers_count()."\n";
            echo "Posti disponibili: ".$vagone->seats_available()."\n";
            echo "_________________________________________\n\n";
            $numero = $numero + 1;
        }
        echo "Totale posti del treno: ".$this->seats_count()."\n";
        echo "Totale passeggeri del treno:".$this->passengers_count()."\n";
        echo "Posti disponibili del treno:".$this->seats_available()."\n";
        echo "Totale di vagoni di prima classe: ".count($this->get_wagons_of_class("prima"))."\n";
        echo "Totale di vagoni di seconda classe: ".count($this->get_wagons_of_class("seconda"))."\n";
    }

}