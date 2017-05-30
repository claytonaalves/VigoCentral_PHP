<?php

class Login extends Controller {

    function __construct() {

        parent::__construct();

        // Renderiza a view relacionada
        $this->view->render('login/index');
    }

}

?>