<?php
namespace Nubs\Vectorix;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Nubs\Vectorix\Vector
 */
class VectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Verify that getComponents returns the same components the vector was constructed with.
     *
     * In particular, this makes sure that the keys are left alone.
     *
     * @test
     * @covers ::__construct
     * @covers ::components
     */
    public function componentsMaintainStructure()
    {
        $components = array(5, 2.4, 'z' => 1.773);
        $vector = new Vector($components);

        $this->assertSame($components, $vector->components());
    }

    /**
     * Verify that the dimension of the vector is correct.
     *
     * @test
     * @covers ::dimension
     */
    public function dimensionIsCorrect()
    {
        $vector = new Vector(array(1, 0, 0));
        $this->assertSame(3, $vector->dimension());
    }
}
