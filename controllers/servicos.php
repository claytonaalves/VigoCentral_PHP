<?php

class Servicos extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Instancia a classe de MODEL relacionado
        require 'models/servicos_model.php'; // O MODEL não é "auto-carregado" como as libs
        $servicos_model = new Servicos_Model();

        // Consulta as notas fiscais do cliente logado
        $this->view->lista_servicos = $servicos_model->Lista_Servicos($_SESSION['ID_CLIENTE']);

        // Renderiza a view relacionada
        $this->view->renderJQ('servicos/index');
    }

}

?>