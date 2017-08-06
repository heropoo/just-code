<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/8/3
 * Time: 16:13
 */

namespace Moon\Routing;

/**
 * Class Route
 * @method Route setOptions(array $options)
 * @method Route setPath(string $path)
 * @method Route setCallback(callable $action)
 * @method array getMethods()
 * @method array getOptions()
 * @method string getPath()
 * @method callable getCallback()
 * @package Moon\Routing
 */
class Route
{
    /**
     * @var string $path
     */
    protected $path = '/';

    /**
     * @var array $methods
     */
    protected $methods = [];

    /**
     * @var string
     */
    protected $condition = '';

    /**
     * @var Callable $callback
     */
    protected $callback;

    /**
     * @var array $options
     */
    protected $options = [];

    /**
     * @param array|string $methods
     * @return $this
     */
    public function setMethods($methods){
        $this->methods = array_map('strtoupper', (array)$methods);
        return $this;
    }

    public function __construct(array $attributes = [])
    {
        if(!empty($attributes)){
            foreach($attributes as $attribute => $value){
                if (property_exists($this, $attribute)) {
                    $method = 'set'.ucfirst($attribute);
                    call_user_func([$this, $method], $value);
                }
            }
        }
    }

    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 3);
        if (strlen($name) > 3) {
            if ($prefix === 'set') {
                $property = lcfirst(substr($name, 3));
                if (property_exists($this, $property)) {
                    $this->$property = $arguments[0];
                    return $this;
                }
            } else if ($prefix === 'get') {
                $property = lcfirst(substr($name, 3));
                if (property_exists($this, $property)) {
                    return $this->$property;
                }
            }
        }
        throw new Exception('Call to undefined method ' . get_class($this) . '::' . $name . '()');
    }
}