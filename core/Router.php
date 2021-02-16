<?php
namespace app\core;

class Router
{
    public $request;
    public $response;
    protected $routes = [];

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            Response::setHttpCode(404);
            $this->renderView("404");
            return "error page";
        }
        if(is_array($callback))
        {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request, $this->response);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $view = $this->request->getFolder().'/'.$view;
        $clearRenderView = $this->clearRenderView($view, $params);
        return str_replace("{{CONTENT}}", $clearRenderView, $layoutContent);
    }

    protected function layoutContent()
    {

        $layout = Application::$app->controller->layout;
        ob_start();
        include_once __DIR__ . "/../view/layout/$layout.php";
        return ob_get_clean();
    }

    public function clearRenderView($view, $params)
    {
        $result = [];
        foreach ($params as $key => $param){
            $result[$key] = $param;
        }
        ob_start();
        include_once __DIR__ . "/../view/$view.php";
        return ob_get_clean();
    }
}