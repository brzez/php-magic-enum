<?php 
namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Mocks\TestEnum;
use Tests\Mocks\OtherTestEnum;


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
        $this->assertEquals("SOMETHING", $object->getName());
    }

    /** @test */
    public function lists_constant_names()
    {
        $list = TestEnum::getConstants();
        $this->assertEquals([
            'SOMETHING'      => 1,
            'SOMETHING_ELSE' => 2
        ], $list);
    }

    /** @test */
    public function two_instances_made_from_the_same_const_should_be_equal()
    {
        $this->assertEquals(TestEnum::SOMETHING(), TestEnum::SOMETHING());

        $this->assertNotEquals(TestEnum::SOMETHING(), TestEnum::SOMETHING_ELSE());

        $this->assertNotEquals(TestEnum::SOMETHING(), OtherTestEnum::SOMETHING());
    }
}