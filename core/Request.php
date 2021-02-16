<?php


namespace app\core;

class Request
{
    //get current path without addition parameters
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = parse_url($path,  PHP_URL_PATH);
        return $position;
    }

    public function getParams()
    {
        $result = [];
        $path = $_SERVER['REQUEST_URI'];
        $query = parse_url($path, PHP_URL_QUERY);
        parse_str($query, $result);
        return $result;
    }

    //get method and set it to lower case
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];
        if($this->getMethod() === 'get'){
            foreach ($_GET as $key => $item) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }else if($this->getMethod() === 'post') {
            foreach ($_POST as $key => $item) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function getFolder()
    {
        $folder = '';
        if(Application::$app->controller) {
            $class = explode('\\', get_class(Application::$app->controller));
            $folder = strtolower(str_replace("Controller", "", end($class)));
        }
        return $folder;
    }
}