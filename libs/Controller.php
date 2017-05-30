<?php

class Controller {

    function __construct() {
        
        // Instancia a classe de FUNÇÕES BÁSICAS (já carregado anteriormente pela classe "pai")
        $this->funcoes = new Functions();

        // Instancia a view
        $this->view = new View();
    }

}

?>