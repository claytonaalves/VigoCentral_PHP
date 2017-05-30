<?php

class Contrato extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        //echo $_POST['id_contrato'];

        if (isset($_POST['id_contrato']) AND ! empty($_POST['id_contrato'])) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $id_contrato = substr($this->funcoes->removeAspas($_POST['id_contrato']), 0, 30);

            // Instancia a classe de MODEL relacionado
            require 'models/contratos_model.php'; // O MODEL não é "auto-carregado" como as libs
            $contratos_model = new Contratos_Model();

            // Consulta os contratos do cliente logado
            $dados = $contratos_model->Exibir_Contrato($_SESSION['ID_CLIENTE'], $id_contrato); // Executa a query no BD e armazena o resultado numa array

            @session_start();
            $_SESSION['DESCRICAO'] = $dados[0][descricao];
            $_SESSION['CONTEUDO'] = $dados[0][conteudo];

            // Renderiza a view relacionada
            $this->view->renderLimpo('contrato/index');
        } elseif (($_POST['id_contrato'] == 0)) {

            // Renderiza a view relacionada
            $this->view->renderLimpo('contrato/padrao');
        } else {

            header("Location: erro");
        }
    }

}

?>