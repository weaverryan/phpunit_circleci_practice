<?php

namespace Tests\AppBundle\Factory;

use AppBundle\Dinosaur\DinosaurLengthDeterminator;
use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @var DinosaurFactory
     */
    private $factory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $lengthDeterminator;

    protected function setUp()
    {
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
    }

    public function testItGrowsALargeVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }

        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {
        $this->lengthDeterminator->expects($this->once())
            ->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(20);
        $dinosaur = $this->factory->growFromSpecification($spec);
        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diet does not match');
        $this->assertSame(20, $dinosaur->getLength());
    }

    public function getSpecificationTests()
    {
        return [
            // specification, is carnivorous
            ['large carnivorous dinosaur', true],
            'default response' => ['give me all the cookies!!!', false],
            ['large herbivore', false]
        ];
    }
}
