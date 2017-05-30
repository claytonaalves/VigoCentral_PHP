<?php

class Contratos extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Instancia a classe de MODEL relacionado
        require 'models/contratos_model.php'; // O MODEL não é "auto-carregado" como as libs
        $contratos_model = new Contratos_Model();

        // Consulta os contratos do cliente logado
        $this->view->lista_contratos = $contratos_model->Lista_Contratos($_SESSION['ID_CLIENTE']); // Executa a query no BD e armazena o resultado numa array
        
        // Renderiza a view relacionada
        $this->view->renderJQ('contratos/index');
    }

}

?>