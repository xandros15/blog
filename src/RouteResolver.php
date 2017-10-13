<?php


namespace Xandros15\Blog;


class RouteResolver
{

    /**
     * @param DI $container
     * @param array $routes
     *
     * @return mixed
     */
    public function resolve(DI $container, array $routes)
    {
        $request = $container->get(Request::class);
        $query = $request->getQueryParams();
        $route = $query['p'] ?? '';
        $method = $request->getEnv()['REQUEST_METHOD'] ?? '';

        if (!isset($routes[$method])) {
            throw new \RuntimeException("Method Not Allowed", 405);
        }

        if (!isset($routes[$method][$route])) {
            throw new \RuntimeException("Not Found", 404);
        }

        $callback = $routes[$method][$route];
        if ($callback instanceof \Closure) {
            $callback->bindTo($container);
        } elseif (strpos($callback, ':') !== false) {
            list($class, $functionName) = explode(':', $callback);
            $controller = new $class($container);
            $callback = [$controller, $functionName];
        }

        if (!is_callable($callback)) {
            throw new \RuntimeException(sprintf('Callback isn\'t callable. Method: %s. Route: %s.', $method, $route));
        }

        return call_user_func($callback);
    }
}
