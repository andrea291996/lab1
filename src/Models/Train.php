<?php
declare(strict_types=1);

namespace App\Models;

class Train {
    private int $passengers;
    private int $seats;
    private array $wagons = [];


    // $vagone è un oggetto di classe Wagon (infatti in alto l'abbiamo richiamata)
    public function add_wagon(Wagon $vagone): void{

         // ogni nuovo oggetto verrà aggiunto all'array della proprietà wagon che abbiamo dichiarato all'inizio, che fa parte di questa istanza ($this->)
        $this->wagons[] = $vagone;
        // da adesso dentro la mia classe wagons[] ci saranno tutti i metodi della classe Wagon
    }


    // questo dà 0
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

    // questo dà 120, ovvero il numero totale di posti
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

     // questo restituisce il numero di passeggeri che avanzano, in questo caso 0. I paggeggeri vengono alloggiati nel primo vagone fino ad esaurirlo, poi nel secondo fino ad esaurirlo e così via
    public function add_passengers(int $num, string $classe = "seconda"): int 
    {

    //Ticket1: voglio che mi crei una variabile all’interno di foreach che sia uguale alla classe del vagone che in quel momento é rappresentato dalla variabile $vagone. Ergo: voglio sapere di che classe é $vagone. (Nel foreach $vagone é al primo giro il vagone 1, al secondo giro il vagone 2 e cosi via).
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
        $vagoni = $this->wagons;
        $risultato = [];
        foreach($vagoni as $vagone){
            $classeVagone = $vagone->get_class();
            if($classeVagone == $classe)
            $risultato[] = $vagone;
        }
        return $risultato;
    }

    // questo restituisce una lista con la distribuzione dei passeggeri nei vagono, in questo caso [10, 0, 0]
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

    // i passeggeri vengono rimossi dall'ultimo vagone fino a svuotarlo, poi si passa al penultimo e così via
    public function remove_passengers($num): void 
    {
        $vagoni = $this->wagons;
        $invertiti = array_reverse($vagoni);
        $nonRimossi = 0;
        foreach($invertiti as $vagone){
            $nonRimossi = $vagone->remove_passengers($num);
            $num = $nonRimossi;
            if($nonRimossi == 0){
                return;
            }
        }
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