<?php

namespace Tests\AppBundle\Dinosaur;

use AppBundle\Dinosaur\DinosaurLengthDeterminator;
use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurLengthDeterminatorTest extends TestCase
{
    /**
     * @dataProvider getSpecLengthTests
     */
    public function testItReturnsTheCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize)
    {
        $determinator = new DinosaurLengthDeterminator();
        $actualSize = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertLessThanOrEqual($maxExpectedSize, $actualSize);
    }

    public function getSpecLengthTests()
    {
        return [
            // specification, min length, max length
            ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE - 1],
            'default response' => ['give me all the cookies!!!', 0, Dinosaur::LARGE - 1],
            ['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE - 1],
            ['huge dinosaur', Dinosaur::HUGE, 100],
            ['huge dino', Dinosaur::HUGE, 100],
            ['huge', Dinosaur::HUGE, 100],
            ['OMG', Dinosaur::HUGE, 100],
            ['😱', Dinosaur::HUGE, 100],
        ];
    }
}