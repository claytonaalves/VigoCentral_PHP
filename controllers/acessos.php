<?php

class Acessos extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        ########## DADOS DO FORMULARIO ##########
        // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
        $mkLogin = substr($this->funcoes->removeAspas($_POST['txtLogin']), 0, 30);
        $dtInicio = substr($this->funcoes->removeAspas($_POST['txtInicio']), 0, 30);
        $dtFinal = substr($this->funcoes->removeAspas($_POST['txtFinal']), 0, 30);

        ########## FIM -> DADOS DO FORMULARIO ##########
        ########## PADRAO DE DATAS PARA FILTRAGEM ##########
        // Data atual
        $txtDataAtual = date('Y-m-d');

        // Cria a data inicial com 7 dias para o filtro rápido
        $txtPeriodo7 = 7;
        $txtInicio07 = @date("d/m/Y", @strtotime('now') - ($txtPeriodo7 * 24 * 60 * 60));

        // Cria a data inicial com 15 dias para o filtro rápido
        $txtPeriodo15 = 15;
        $txtInicio15 = @date("d/m/Y", @strtotime('now') - ($txtPeriodo15 * 24 * 60 * 60));

        // Cria a data inicial com 30 dias para o filtro rápido
        $txtPeriodo30 = 30;
        $txtInicio30 = @date("d/m/Y", @strtotime('now') - ($txtPeriodo30 * 24 * 60 * 60));

        $this->view->dataAtual = $txtDataAtual;
        $this->view->dataInicio07 = $txtInicio07;
        $this->view->dataInicio15 = $txtInicio15;
        $this->view->dataInicio30 = $txtInicio30;

        ########## FIM -> PADRAO DE DATAS ##########
        ########## MODELO DA CLASSE ##########
        // Instancia a classe de MODEL relacionado
        require 'models/extrato_model.php'; // O MODEL não é "auto-carregado" como as libs
        $extrato_model = new Extrato_Model();

        // Consulta os mk_logins do cliente
        $query = $extrato_model->Lista_MkLogins($_SESSION['ID_CLIENTE']);
        $this->view->lista_mklogins = $query;

        // Para dados via POST
        if (!empty($mkLogin) OR ! empty($dtInicio) OR ! empty($dtFinal)) {

            $mkLogin = $mkLogin;
            $txtInicio = $this->funcoes->dataToBR($dtInicio);
            $txtFinal = $this->funcoes->dataToBR($dtFinal);

            // Para dados via GET
        } else {

            $mkLogin = $query[0][UserName];
            $txtInicio = $txtInicio07;
            $txtFinal = $this->funcoes->dataToBR($txtDataAtual);
        }

        $_SESSION['MK_LOGIN'] = $mkLogin;
        $_SESSION['DT_INICIO'] = $txtInicio;
        $_SESSION['DT_FINAL'] = $txtFinal;

        // Consulta o plano de banda do login informado
        $this->view->lista_plano = $extrato_model->Exibir_Plano($mkLogin);

        // Consulta os acessos do login informado
        $query = $extrato_model->Lista_Acessos($mkLogin, $this->funcoes->dataToUS($txtInicio), $this->funcoes->dataToUS($txtFinal));
        $this->view->lista_acessos = $query;

        // Renderiza a view relacionada 
        $this->view->renderJQ('acessos/index');
    }

}

?>