<?php


namespace Xandros15\Blog;


class RouteResolver
{

    /**
     * @param Request $request
     * @param array $routes
     *
     * @return mixed
     */
    public function resolve(Request $request, array $routes)
    {
        $query = $request->getQueryParams();
        $route = $query['p'] ?? '';
        $method = $request->getEnv()['REQUEST_METHOD'] ?? '';

        if (!isset($routes[$method])) {
            throw new \RuntimeException("Method Not Allow", 405);
        }

        if (!isset($routes[$method][$route])) {
            throw new \RuntimeException("Not Found", 404);
        }

        list($class, $callback) = explode(':', $routes[$method][$route]);
        $controller = new $class($request);

        return $controller->$callback();
    }
}