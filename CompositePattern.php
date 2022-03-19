<?php

/**
 * The composite design pattern is used to solve the issues of how to build a tree-like structure of objects, and how to treat the individual types of those objects uniformly
 */

/** Create interface all objects implement */
interface HousingInterface
{
    function enter(): void;
    function exit(): void;
    function location(): void;
    function getName(): string;
}

// Leaf type class - meaning it does not contain anything of it's own
class Room implements HousingInterface
{
    private string $name;


    public function __construct(string $name)
    {
        $this->name = $name;
    }

    function enter(): void
    {
        echo "You entered the {$this->name}" . PHP_EOL;
    }

    function exit(): void
    {
        echo "You left the {$this->name}" . PHP_EOL;
    }

    function location(): void
    {
        echo "You you are currently in the {$this->name}" . PHP_EOL;
    }

    function getName(): string
    {
        return $this->name;
    }
}

// Composite type - the building itself and then the floors. 
class Housing implements HousingInterface
{

    private string $address;
    private array $structure;

    public function __construct(string $address)
    {
        $this->address = $address;
        $this->structure = [];
    }

    public function addStructure(HousingInterface $structure): int
    {
        $this->structure[] = $structure;
        return count($this->structure) - 1;
    }

    public function getStructure(int $number): HousingInterface
    {
        return $this->structure[$number];
    }

    function enter(): void
    {
        echo 'Entered into the building' . PHP_EOL;
    }

    function exit(): void
    {
        echo 'Exited the building' . PHP_EOL;
    }

    function location(): void
    {
        $count = count($this->structure);
        echo "You are currently in {$this->getName()}. It has {$count} structures." . PHP_EOL;
    }

    function getName(): string
    {
        return $this->address;
    }
}

// Building itself
$building = new Housing('Example address #1');
// Floor
$floor = new Housing('Example address - first floor');
$firstFloor = $building->addStructure($floor);
// Create rooms in floor
$livingRoom = new Room('Living room - first floor');
$bedRoom = new Room('Bedroom - first floor');
$floor->addStructure($livingRoom);
$floor->addStructure($bedRoom);

// Traverse the rooms
echo $building->enter();
echo $building->location();
$currentFloor = $building->getStructure($firstFloor);
echo $currentFloor->location();
