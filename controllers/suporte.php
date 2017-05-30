<?php

class Suporte extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Instancia a classe de MODEL relacionado
        require 'models/suporte_model.php'; // O MODEL não é "auto-carregado" como as libs
        $suporte_model = new Suporte_Model();

        // Consulta os atendimentos do cliente logado
        $this->view->lista_atendimentos = $suporte_model->Lista_Atendimentos($_SESSION['ID_CLIENTE']);

        // Consulta os tipos de atendimentos
        $this->view->lista_tipos_atendimentos = $suporte_model->Lista_TiposAtendimento($_SESSION['ID_EMPRESA']);

        // Consulta os anexos
        $this->view->lista_anexos = $suporte_model->Lista_Anexos($_SESSION['ID_CLIENTE']);

        // Renderiza a view relacionada
        $this->view->renderJQ('suporte/index');
    }

}

?>