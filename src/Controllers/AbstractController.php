<?php


namespace Xandros15\Blog\Controllers;


use Xandros15\Blog\Renderer;
use Xandros15\Blog\Request;

abstract class AbstractController
{
    const TEMPLATES_DIR = __DIR__ . '/../../templates/';
    /** @var Request */
    protected $request;
    /** @var Renderer */
    protected $view;

    public function __construct(Request $request)
    {
        $this->request = $request;
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
