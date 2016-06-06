<?php 

use Tests\TestEnum;


class MagicEnumTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function validates_value()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        new TestEnum(1337);
    }

    /** @test */
    public function creates_instance_via_magic_function()
    {
        $value = TestEnum::SOMETHING;
        $object = TestEnum::SOMETHING();

        $this->assertInstanceOf(TestEnum::class, $object);
        $this->assertEquals($value, $object->getValue());
        $this->assertEquals("SOMETHING", $object->getConstantName());
    }

    /** @test */
    public function lists_constant_names()
    {
        $this->markTestIncomplete();
    }
}