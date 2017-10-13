<?php


namespace Xandros15\Blog;


final class DI
{
    private $called = [];
    private $frozen = [];
    private $unfrozen = [];

    /**
     * DI constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $name => $param) {
            $this->set($name, $param);
        }
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        if (in_array($name, $this->called)) {
            return $this->getUnfrozen($name);
        }

        return $this->getFrozen($name);
    }

    /**
     * @param string $name
     * @param $value
     */
    private function set(string $name, $value)
    {
        if (in_array($name, array_keys($this->frozen) + $this->called)) {
            throw new \InvalidArgumentException('Can\'t set existing item');
        }

        $this->frozen[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    private function getUnfrozen(string $name)
    {
        if (!isset($this->unfrozen[$name])) {
            throw new \InvalidArgumentException('Item ' . $name . ' not found');
        }

        return $this->unfrozen[$name];
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    private function getFrozen(string $name)
    {
        if (!isset($this->frozen[$name])) {
            throw new \InvalidArgumentException('Item ' . $name . ' not found');
        }

        $item = $this->frozen[$name];
        $this->called[] = $name;
        $this->unfrozen[$name] = is_callable($item) ? call_user_func($item, $this) : $item;

        return $this->unfrozen[$name];
    }
}
