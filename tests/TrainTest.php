<?php
declare(strict_types=1);

namespace App\Tests;

use App\Models\Wagon;
use App\Models\Train;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class TrainTest extends TestCase
{
    public function controllaClasseArgomentoTrain(){
        $treno = new Train();
        $vagone = new Wagon(10);
        $treno->add_wagon($vagone);
        $controllo = get_class($vagone);
        $this->assertSame("Wagon", $controllo);
    }

    public function testAddWagon(){
        $treno = new Train();
        $vagone = new Wagon(10);
        $controllo = $treno->add_wagon($vagone);
        $this->assertSame(null, $controllo);
    }
}