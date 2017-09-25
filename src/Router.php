<?php


namespace Xandros15\Blog;


class Router
{
    /** @var array */
    private $get = [];

    /** @var array */
    private $post = [];

    /**
     * @param string $endpoint
     * @param string $callback
     */
    public function get(string $endpoint, string $callback)
    {
        $this->get[$endpoint] = $callback;
    }

    /**
     * @param string $endpoint
     * @param string $callback
     */
    public function post(string $endpoint, string $callback)
    {
        $this->post[$endpoint] = $callback;
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function resolve(Request $request)
    {
        $resolver = new RouteResolver();

        return $resolver->resolve($request, [
            'POST' => $this->post,
            'GET' => $this->get,
        ]);
    }
}
