<?php


namespace Xandros15\Blog\Controllers;


use Xandros15\Blog\Request;

abstract class AbstractController
{
    /** @var Request */
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }
}
