<?php
declare(strict_types=1);

namespace App\Tests;

use App\Models\Wagon;
use App\Models\Train;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class TrainTest extends TestCase
{

    public function testRitornoAddWagonRitorno(){
        $treno = new Train();
        $vagone = new Wagon(10);
        $controllo = $treno->add_wagon($vagone);
        $this->assertSame(null, $controllo);
    }

    public function testPassengersCountRitorno(){
        $treno = new Train();
        $vagone1 = new Wagon(10);
        $vagone2 = new Wagon(5);

        $vagone1->add_passengers(2);
        $vagone2->add_passengers(4);

        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $controllo = $treno->passengers_count();
        $this->assertSame(6, $controllo);
    }

    public function testSeatsCount(){
        $treno = new Train();
        $vagone1 = new Wagon(10);
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);

        $controllo = $treno->seats_count();
        $this->assertSame(15, $controllo);
    }

    public function testAddPassengersRitorno1(){
        $treno = new Train();
        $vagone1 = new Wagon(10);
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        //classe default
        $controllo1 = $treno->add_passengers(14); //mi aspetto 0
        $this->assertSame(0, $controllo1);
        $controllo2 = $treno->add_passengers(3); //mi aspetto 2 
        $this->assertSame(2, $controllo2);
    }

    public function testAddPassengersRitorno2(){
        $treno = new Train();
        $vagone1 = new Wagon(10);
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        //classe seconda
        $controllo1 = $treno->add_passengers(14, "seconda"); //mi aspetto 0
        $this->assertSame(0, $controllo1);
        $controllo2 = $treno->add_passengers(3, "seconda"); //mi aspetto 2 
        $this->assertSame(2, $controllo2);
    }

    public function testAddPassengersRitorno3(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $vagone3 = new Wagon(5, "prima");
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $treno->add_wagon($vagone3);
        //classe mista
        $controllo1 = $treno->add_passengers(14, "prima"); //mi aspetto 0
        $this->assertSame(0, $controllo1);
        $controllo2 = $treno->add_passengers(11); //mi aspetto 6
        $this->assertSame(6, $controllo2);
        $controllo3 = $treno->add_passengers(10, "seconda"); //mi aspetto 10
        $this->assertSame(10, $controllo3);
        $controllo4 = $treno->add_passengers(9, "prima"); //mi aspetto 9
        $this->assertSame(8, $controllo4);
    }

    public function testAddPassengersArguments1(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        //numero negativo
        $this->expectException(InvalidArgumentException::class);
        $treno->add_passengers(-5, "prima");
    }

    public function testAddPassengersArguments2(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        //classe che non esiste
        $this->expectException(InvalidArgumentException::class);
        $treno->add_passengers(5, "pincopallino");
    }

    public function testAddPassengersArguments3(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        //primo argomento deve essere un numero
        $this->expectException(InvalidArgumentException::class);
        $treno->add_passengers("ciao");
    }

    public function testGetWagonsOfClassArguments(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        //classe che non esiste
        $this->expectException(InvalidArgumentException::class);
        $treno->get_wagons_of_class("pincopallino");
    }

    public function testGetWagonsOfClassRitorno(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $vagone3 = new Wagon(10, "prima");
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $treno->add_wagon($vagone3);
        
        $controllo = $treno->get_wagons_of_class("prima");
        $this->assertSame([$vagone1, $vagone3], $controllo);
    }

    public function testPassengersDistributionRitorno(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $vagone3 = new Wagon(10, "seconda");
        $vagone4 = new Wagon(100);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $treno->add_wagon($vagone3);
        $treno->add_wagon($vagone4);
        $vagone1->add_passengers(5);
        $treno->add_passengers(2, "prima");
        $treno->add_passengers(9, "seconda");

        $controllo = $treno->passengers_distribution(); //mi aspetto [7,5,4,0]
        $this->assertSame([7,5,4,0], $controllo);
    }

    public function testRemovePassengersArgument1(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $vagone3 = new Wagon(10, "seconda");
        $vagone4 = new Wagon(100);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $treno->add_wagon($vagone3);
        $treno->add_wagon($vagone4);
        $vagone1->add_passengers(5);
        $treno->add_passengers(2, "prima");
        $treno->add_passengers(9, "seconda");
        //numero negativo come argoment
        $this->expectException(InvalidArgumentException::class);
        $treno->remove_passengers(-4);
    }

    public function testRemovePassengersArgument2(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $vagone3 = new Wagon(10, "seconda");
        $vagone4 = new Wagon(100);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $treno->add_wagon($vagone3);
        $treno->add_wagon($vagone4);
        $vagone1->add_passengers(5);
        $treno->add_passengers(2, "prima");
        $treno->add_passengers(9, "seconda");
        //stringa come argomento
        $this->expectException(InvalidArgumentException::class);
        $treno->remove_passengers("ciao");
    }

    public function testRemovePassengersRitorno1(){
        $treno = new Train();
        $vagone = new Wagon(50);
        $treno->add_wagon($vagone);
        $vagone->add_passengers(10);
        //non deve ritornare nulla
        $controllo = $treno->remove_passengers(9);
        $this->assertSame(0, $controllo);
    }

    public function testRemovePassengersRitorno2(){
        $treno = new Train();
        $vagone = new Wagon(50);
        $treno->add_wagon($vagone);
        $vagone->add_passengers(10);
        //non deve ritornare nulla
        $controllo = $treno->remove_passengers(11);
        $this->assertSame(1, $controllo);
    }

    public function testSeatsAvailableRitorno1(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $vagone2 = new Wagon(5);
        $vagone3 = new Wagon(10, "seconda");
        $vagone4 = new Wagon(100);
        $treno->add_wagon($vagone1);
        $treno->add_wagon($vagone2);
        $treno->add_wagon($vagone3);
        $treno->add_wagon($vagone4);
        $vagone1->add_passengers(5);
        $treno->add_passengers(2, "prima");
        $treno->add_passengers(9, "seconda");

        $controllo = $treno->seats_available();
        $this->assertSame(109, $controllo);
    }

    public function testSeatsAvailableRitorno2(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $treno->add_wagon($vagone1);
        $treno->add_passengers(2, "prima");
        $treno->add_passengers(9, "seconda");

        $controllo = $treno->seats_available();
        $this->assertSame(8, $controllo);
    }

    public function testSeatsAvailableRitorno3(){
        $treno = new Train();
        $vagone1 = new Wagon(10, "prima");
        $treno->add_wagon($vagone1);
        $treno->add_passengers(11, "prima");

        $controllo = $treno->seats_available();
        $this->assertSame(0, $controllo);
    }
}