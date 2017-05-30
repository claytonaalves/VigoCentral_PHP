<?php

class Barcode extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Remove aspas do conteúdo postado (segurança contra SQL Injection) e limitando a 10 caracteres
        $id = explode('/', $_SERVER['QUERY_STRING']);
        $id = $this->funcoes->removeAspas(rtrim(substr($id[1], 0, 10), ' '));

        // Instancia a classe de geracao de codigo de barras
        require 'libs/classes/Barcode.php';
        $barcode->imagem = new GerarBarcode($id, 0);

        // Renderiza a view relacionada
        $this->view->barcode = $barcode;
    }

}

?>