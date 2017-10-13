<?php


namespace Xandros15\Blog\Controllers;


use Xandros15\Blog\DI;
use Xandros15\Blog\Renderer;

abstract class AbstractController
{
    const TEMPLATES_DIR = __DIR__ . '/../../templates/';
    /** @var DI */
    protected $container;
    /** @var Renderer */
    protected $view;

    public function __construct(DI $container)
    {
        $this->container = $container;
        $this->view = new Renderer(self::TEMPLATES_DIR, [
            'title' => 'Blog',
            'content' => '',
        ]);
    }

    protected function render(string $template, array $data = [])
    {
        $content = $this->view->render($template, $data);
        echo $this->view->render('base.php', ['content' => $content]);
    }
}
