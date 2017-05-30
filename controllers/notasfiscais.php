<?php

class NotasFiscais extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Instancia a classe de MODEL relacionado
        require 'models/notasfiscais_model.php'; // O MODEL não é "auto-carregado" como as libs
        $notasfiscais_model = new NotasFiscais_Model();

        // Consulta as notas fiscais do cliente logado
        $this->view->lista_notas = $notasfiscais_model->Lista_Notas($_SESSION['ID_CLIENTE'], $_SESSION['CPFCNPJ']); // Executa a query no BD e armazena o resultado numa array
        // Renderiza a view relacionada
        $this->view->renderJQ('notasfiscais/index');
    }

}

?>