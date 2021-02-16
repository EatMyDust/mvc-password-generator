<?php


namespace app\core;


class Response
{
    public static function setHttpCode($code)
    {
        http_response_code($code);
    }

    public static function redirect($path)
    {
        header("Location: $path");
    }
}