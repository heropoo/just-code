<?php
/**
 * Date: 2019-12-20
 * Time: 15:50
 */

namespace App;


class Container
{
    protected $instances = [];

    /** @var Container */
    private static $_container;

    public static function getContainer()
    {
        if (self::$_container instanceof Container) {
            return self::$_container;
        }
        return self::$_container = new Container();
    }

    public static function add($key, $value)
    {
        $container = self::getContainer();

        if ($value instanceof \Closure) {
            $container->instances[$key] = $value;
        } else if (is_object($value)) {
            $container->instances[$key] = $value;
        } else {
            new Exception('Unsupported value: ' . var_export($value, 1));
        }
    }

    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public static function get($key)
    {
        $container = self::getContainer();

        if (isset($container->instances[$key])) {
            return $container->instances[$key];
        }
        throw new Exception("Class or instance named '$key' is not found!");
    }
}