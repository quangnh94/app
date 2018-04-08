<?php

require_once './vendor/autoload.php';
$config = require '././config.php';

//redirect_router
try {
    if (isset($_SERVER['REQUEST_METHOD'])) {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $redirect_link = explode('/', $actual_link);
        if (!empty($redirect_link) && count($redirect_link) == 6) {
            if (isset($redirect_link[4]) && isset($redirect_link[5])) {
                $header = getallheaders();
                $router = $redirect_link[4];
                $action = 'action' . $redirect_link[5];
                $require_file = './app/' . $router . '.php';
                $class = $router;
                //check file exist if return true -> require file and action new object else response 404
                if (!file_exists($require_file)) {
                    throw new Exception("Error !!");
                }
                //require file api from api folder and action require from client
                require_once $require_file;
                $obj = new $class();
                $obj->$action();
            }
        } else {
            header("location: /index.php/auth/login");
        }
    } else {
        throw new Exception("Error !!");
    }
} catch (Exception $exc) {
    return http_response_code(404);
}




