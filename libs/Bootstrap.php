<?php

class Bootstrap {

    function __construct() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $file = 'controllers/' . $url[0] . '.php';

        if (empty($url[0])) {
            require 'controllers/index.php';
            $controller = new Index();
            return false;
        }

        if (file_exists($file)) {
            require $file;
        } else {
            require 'controllers/erro.php';
            $controller = new Erro();
            return false;
        }

        $controller = new $url[0];
    }

}

?>