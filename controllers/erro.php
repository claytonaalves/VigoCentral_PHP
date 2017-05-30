<?php

class Erro extends Controller {

    function __construct() {

        parent::__construct();

        // Renderiza a view relacionada
        $this->view->render('erro/index');
    }

}

?>