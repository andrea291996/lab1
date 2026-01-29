<?php
declare(strict_types=1);

namespace App\Tests;

use App\Models\Wagon;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class WagonTest extends TestCase
{
    public function testNewWagonHasZeroPassengersAndCorrectSeats(): void
    {
        $wagon = new Wagon(40);

        $this->assertSame(0, $wagon->passengers_count());
        $this->assertSame(40, $wagon->seats_count());
    }

    public function testConstructorRejectsNegativeSeats(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Wagon(-1);
    }

    public function testAddPassengersWithinCapacityReturnsZeroAndIncreasesCount(): void
    {
        $wagon = new Wagon(40);

        $overflow = $wagon->add_passengers(10);

        $this->assertSame(0, $overflow);
        $this->assertSame(10, $wagon->passengers_count());
    }

    public function testAddPassengersOverCapacityReturnsOverflowAndCapsPassengers(): void
    {
        $wagon = new Wagon(40);

        $wagon->add_passengers(10);
        $overflow = $wagon->add_passengers(55); // 30 posti rimasti -> overflow 25

        $this->assertSame(25, $overflow);
        $this->assertSame(40, $wagon->passengers_count());
    }

    public function testAddPassengersWithZeroIsNoOp(): void
    {
        $wagon = new Wagon(40);

        $overflow = $wagon->add_passengers(0);

        $this->assertSame(0, $overflow);
        $this->assertSame(0, $wagon->passengers_count());
    }

    public function testAddPassengersRejectsNegative(): void
    {
        $wagon = new Wagon(40);

        $this->expectException(InvalidArgumentException::class);
        $wagon->add_passengers(-1);
    }

    public function testRemovePassengersReducesCount(): void
    {
        $wagon = new Wagon(40);
        $wagon->add_passengers(40);

        $overflow = $wagon->remove_passengers(15);

        $this->assertSame(0, $overflow);
        $this->assertSame(25, $wagon->passengers_count());
    }

    public function testRemovePassengersToZero(): void
    {
        $wagon = new Wagon(40);
        $wagon->add_passengers(25);

        $overflow = $wagon->remove_passengers(25);

        $this->assertSame(0, $overflow);
        $this->assertSame(0, $wagon->passengers_count());
    }

    public function testRemovePassengersOverAvailableReturnsOverflowAndEmptiesWagon(): void
    {
        $wagon = new Wagon(40);
        $wagon->add_passengers(10);

        $overflow = $wagon->remove_passengers(15); // ne mancano 5

        $this->assertSame(5, $overflow);
        $this->assertSame(0, $wagon->passengers_count());
    }

    public function testRemovePassengersWithZeroIsNoOp(): void
    {
        $wagon = new Wagon(40);
        $wagon->add_passengers(10);

        $overflow = $wagon->remove_passengers(0);

        $this->assertSame(0, $overflow);
        $this->assertSame(10, $wagon->passengers_count());
    }

    public function testRemovePassengersRejectsNegative(): void
    {
        $wagon = new Wagon(40);

        $this->expectException(InvalidArgumentException::class);
        $wagon->remove_passengers(-1);
    }

    public function testMixedOperationsMatchScenario(): void
    {
        $wagon = new Wagon(40);

        $this->assertSame(0, $wagon->passengers_count());
        $this->assertSame(40, $wagon->seats_count());

        $this->assertSame(0, $wagon->add_passengers(10));
        $this->assertSame(10, $wagon->passengers_count());

        $this->assertSame(25, $wagon->add_passengers(55));
        $this->assertSame(40, $wagon->passengers_count());

        $this->assertSame(0, $wagon->remove_passengers(15));
        $this->assertSame(25, $wagon->passengers_count());

        $this->assertSame(0, $wagon->remove_passengers(25));
        $this->assertSame(0, $wagon->passengers_count());
    }
}
