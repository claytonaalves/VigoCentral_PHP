<?php

class Download extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        if (isset($_GET['id'])) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $id = substr($this->funcoes->removeAspas($_GET['id']), 0, 9);

            // Instancia a classe de MODEL relacionado
            require 'models/suporte_model.php'; // O MODEL não é "auto-carregado" como as libs
            $suporte_model = new Suporte_Model();

            // Baixa o arquivo
            $retorno = $suporte_model->Baixa_Anexo($id);
            $nome = "arquivo_central." . $retorno[0][extensao];

            header("Content-type: {$retorno[0][tipo]}");
            header("Content-Disposition: attachment; filename={$nome}");
            print $retorno[0][dados];
        } else {

            header("Location: erro");
        }
    }

}

?>