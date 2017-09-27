<?php


namespace Xandros15\Blog;


class Router
{
    /** @var array */
    private $routes = ['GET' => [], 'POST' => []];

    public function map(array $methods, string $endpoint, string $callback)
    {
        $methods = array_map('strtoupper', $methods);
        foreach ($methods as $method) {
            if (!in_array($method, array_keys($this->routes))) {
                throw new \InvalidArgumentException('Wrong method to add. Got ' . $method);
            }
            $this->routes[$method][$endpoint] = $callback;
        }
    }

    /**
     * @param string $endpoint
     * @param string $callback
     */
    public function get(string $endpoint, string $callback)
    {
        $this->map(['GET'], $endpoint, $callback);
    }

    /**
     * @param string $endpoint
     * @param string $callback
     */
    public function post(string $endpoint, string $callback)
    {
        $this->map(['post'], $endpoint, $callback);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function run(Request $request)
    {
        $resolver = new RouteResolver();

        return $resolver->resolve($request, $this->routes);
    }
}
