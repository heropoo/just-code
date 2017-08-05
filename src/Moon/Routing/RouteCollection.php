<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/8/3
 * Time: 16:13
 */

namespace Moon\Routing;


class RouteCollection implements \Countable, \IteratorAggregate
{
    protected $routes = [];

    /**
     * @return int
     */
    public function count()
    {
        return count($this->routes);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }

    /**
     * @param string $name
     * @param Route $route
     */
    public function add($name, Route $route)
    {
        $this->routes[$name] = $route;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->routes;
    }

    /**
     * @param string $name
     * @return Route|null
     */
    public function get($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
    }

    /**
     * @param string $name
     */
    public function remove($name)
    {
        unset($this->routes[$name]);
    }

    public function addPrefix($prefix)
    {
        $prefix = trim(trim($prefix), '/');
        if ($prefix === '') {
            return;
        }

        /**
         * @var Route $route
         */
        foreach ($this->routes as $route) {
            $route->setPath('/' . $prefix . $route->getPath());
        }
    }

    public function addCollection(RouteCollection $collection)
    {
        foreach ($collection->all() as $name => $route) {
            $this->routes[$name] = $route;
        }
    }

}