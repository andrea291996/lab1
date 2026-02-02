<?php

declare(strict_types=1);

namespace App\Models;

use InvalidArgumentException;

class Wagon{

    private int $totalePosti;
    private int $totalePasseggeri = 0;
    private int $postiDisponibili;
    private string $classe;

    public function __construct(int $totalePosti, $classe = "seconda") 
    {
        if($totalePosti < 0){
            throw new InvalidArgumentException("Non puoi inserire un numero negativo!");
        }
        $this->totalePosti = $totalePosti;
        $this->postiDisponibili = $totalePosti;
        $this->classe = $classe;
        
    }

    public function passengers_count(): int{
        return $this->totalePasseggeri;
    }

    public function seats_count(): int{
        return $this->totalePosti;
    }

    public function add_passengers($number): int{
        if($number < 0){
            throw new InvalidArgumentException("Non puoi inserire un numero negativo!");
        }
        if(!is_numeric($number)){
            throw new InvalidArgumentException("Devi inserire un numero come argomento!");
        }
        $differenza = $this->postiDisponibili - $number;
        if($differenza >= 0){
            $this->postiDisponibili = $this->postiDisponibili - $number;
            $this->totalePasseggeri = $this->totalePasseggeri + $number;
            return 0;
        }else{
            $this->totalePasseggeri = $this->totalePosti;
            $esclusi = $number - $this->postiDisponibili;
            $this->postiDisponibili = 0;
            return $esclusi;
        }
    }

    public function remove_passengers($number): int{
        if($number < 0){
            throw new InvalidArgumentException("Non puoi inserire un numero negativo!");
        }
        if(!is_numeric($number)){
            throw new InvalidArgumentException("Devi inserire un numero come argomento!");
        }
        $differenza = $this->totalePasseggeri - $number;
        if($differenza >= 0){
            $this->totalePasseggeri = $this->totalePasseggeri - $number;
            $this->postiDisponibili = $this->postiDisponibili + $number;
            return 0;
        }else{
            $this->totalePasseggeri = 0;
            $this->postiDisponibili = $this->totalePosti;
            return -$differenza;
        }
    }

    public function seats_available(): int{
        return $this->postiDisponibili;
    }

    public function get_class(): string{
        return $this->classe;
    }

}

