<?php 

namespace MagicEnum;

abstract class MagicEnum
{
    protected static $constCache = [];

    public static function getConstants()
    {
        if(isset(self::$constCache[static::class])){
            return self::$constCache[static::class];
        }
        self::$constCache[static::class] = (new \ReflectionClass(static::class))->getConstants();
        return static::getConstants();
    }

    public static function __callStatic($method, array $args)
    {
        return new static(static::getConstantValue($method));
    }

    public static function getConstantValue($name)
    {
        $consts = static::getConstants();
        if(isset($consts[$name]))
        {
            return $consts[$name];
        }
        throw new \InvalidArgumentException("Constant $name not defined");
    }

    public static function getConstantName($value)
    {
        return array_search($value, static::getConstants());
    }

    protected $value;
    protected $constName;

    public function __construct($value)
    {
        $this->validateValue($value);

        $this->value = $value;
        $this->constName = static::getConstantName($value);
    }

    protected function validateValue($value)
    {
        if(!in_array($value, static::getConstants())){
            throw new \InvalidArgumentException("$value is not a valid const value");
        }
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->constName;
    }
}