<?php


namespace Xandros15\Blog;


class App
{
    /**
     * @var DI
     */
    private $container;

    /**
     * App constructor.
     *
     * @param DI $config
     */
    public function __construct(DI $config)
    {
        $this->container = $config;
    }

    /**
     * @param string $endpoint
     * @param string $callback
     */
    public function get(string $endpoint, string $callback)
    {
        $this->container->get(Router::class)->get($endpoint, $callback);
    }

    /**
     * @param string $endpoint
     * @param string $callback
     */
    public function post(string $endpoint, string $callback)
    {
        $this->container->get(Router::class)->post($endpoint, $callback);
    }

    /**
     * Run application
     */
    public function run()
    {
        $this->container->get(Router::class)->run($this->container);
    }
}