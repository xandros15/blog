<?php


namespace Xandros15\Blog;


class Request
{
    /** @var array */
    private $parsedBody;

    /** @var array */
    private $environment;

    /** @var array */
    private $cookies;

    /** @var array */
    private $queryParams;

    /** @var array */
    private $headers;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->environment = $_ENV ?? $_SERVER;
        $this->cookies = $_COOKIE;
        $this->queryParams = $_GET;
        $this->parsedBody = $this->parseBody();
        $this->headers = $this->parseHeaders();
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @see http://php.net/manual/en/function.getallheaders.php#84262
     * @return array
     */
    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = str_replace('_', ' ', substr($name, 5));
                $name = str_replace(' ', '-', ucwords(strtolower($name)));
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    /**
     * @return array
     */
    private function parseBody(): array
    {
        switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
            case 'GET':
                return $_GET;
            case 'POST':
                return $_POST;
            default:
                throw new \RuntimeException("Method not allow", 405);
        }
    }

    /**
     * @return array
     */
    public function getEnv(): array
    {
        return $this->environment;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->parsedBody;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * @param $name
     * @param null $default
     *
     * @return mixed
     */
    public function getParam($name, $default = null)
    {
        return $this->getParams()[$name] ?: $default;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
