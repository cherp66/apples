<?php

namespace application\core;

use application\core\interfaces\EntityInterface;
use ReflectionClass;

/**
 *  Hydrator
 */ 
class Hydrator 
{
    protected static $reflectClassMap;

    /**
     * @param string $class
     * @param array|null $args
     * @return EntityInterface
     * @throws \ReflectionException
     */
    public static function instance(string $class, \StdClass $data): EntityInterface
    {
        $reflection = self::getReflectionClass($class);
        $target = $reflection->newInstanceWithoutConstructor();
        $method = $reflection->getMethod('create');
        $method->setAccessible(true);
        $method->invokeArgs($target, [$data]);
        return $target;
    }

    /**
     * @param string $class
     * @param array|null $args
     * @return EntityInterface
     * @throws \ReflectionException
     */
    public static function fill(string $class, ?array $args) : EntityInterface
    {
        $reflection = self::getReflectionClass($class);
        $target = $reflection->newInstanceWithoutConstructor();

        if (!empty($args)) {
            foreach($args as $name => $value) {
                $property = $reflection->getProperty($name);

                if($property->isPrivate() || $property->isProtected()) {
                    $property->setAccessible(true);
                }

                $property->setValue($target, $value);
            }
        }
        return $target;
    }

    /**
     * @param EntityInterface $object
     * @param array $fields
     * @return array
     * @throws \ReflectionException
     */
    public static function extract(EntityInterface $object, array $fields = []) : array
    {
        $result = [];
        $reflection = self::getReflectionClass(get_class($object));
        
        foreach ($fields as $name) {
            $property = $reflection->getProperty($name);
            
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            
            $result[$property->getName()] = $property->getValue($object);
        }
        
        return $result;
    }

    /**
     * @param string $className
     * @return mixed|\ReflectionClass
     * @throws \ReflectionException
     */
    protected static function getReflectionClass(string $className) : ReflectionClass
    {
        if (!isset(self::$reflectClassMap[$className])) {
            self::$reflectClassMap[$className] = new ReflectionClass($className);
        }
        return self::$reflectClassMap[$className];
    }
}
