<?php

namespace AppBundle\Factory;

use AppBundle\Entity\Dinosaur;

class DinosaurFactory
{
    public function growVelociraptor(int $length)
    {
        return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        // defaults
        $codeName = 'InG-' . random_int(1, 99999);
        $length = random_int(1, Dinosaur::LARGE - 1);
        $isCarnivorous = false;

        if (stripos($specification, 'large') !== false) {
            $length = random_int(Dinosaur::LARGE, 100);
        }

        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        $dinosaur = $this->createDinosaur($codeName, $isCarnivorous, $length);

        return $dinosaur;
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $length): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);
        $dinosaur->setLength($length);

        return $dinosaur;
    }
}
