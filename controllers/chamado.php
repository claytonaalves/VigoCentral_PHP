<?php

class Chamado extends Controller {

    function __construct() {

        parent::__construct();
        session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Remove aspas do conteúdo postado (segurança contra SQL Injection) e limitando a 50 caracteres
        $txtAssunto = substr($this->funcoes->removeAspas($_POST['txtAssunto']), 0, 30);
        $txtTipo = substr($this->funcoes->removeAspas($_POST['txtTipo']), 0, 50);
        $txtMensagem = $this->funcoes->removeAspas($_POST['txtMensagem']);

        if (($txtAssunto != '') && ($txtTipo != '') && ($txtMensagem != '')) {

            $txtTipoAtendimento = explode(' - ', $txtTipo);

            // Instancia a classe de MODEL relacionado
            require 'models/sessao_model.php'; // O MODEL não é "auto-carregado" como as libs
            $core_model = new Sessao_Model();

            // Captura as informações do cliente autenticado corretamente
            $dados = $core_model->Dados_Cliente($_SESSION['LOGIN']);

            $idCliente = $dados[0][id];

            if (($idCliente >= 0) && ($idCliente < 10)) {
                $idCliente = '00000' . $idCliente;
            } elseif (($idCliente >= 10) && ($idCliente < 100)) {
                $idCliente = '0000' . $idCliente;
            } elseif (($idCliente >= 100) && ($idCliente < 1000)) {
                $idCliente = '000' . $idCliente;
            } elseif (($idCliente >= 1000) && ($idCliente < 10000)) {
                $idCliente = '00' . $idCliente;
            } elseif (($idCliente >= 10000) && ($idCliente < 100000)) {
                $idCliente = '0' . $idCliente;
            } else {
                $idCliente = $idCliente;
            }

            // Instancia a classe de MODEL relacionado
            require 'models/suporte_model.php'; // O MODEL não é "auto-carregado" como as libs
            $suporte_model = new Suporte_Model();

            $data = date('Y-m-d');
            $hora = date('H:i');

            // Dados a serem gravados
            $id_empresa = $dados[0][idempresa];
            $id_cliente = $dados[0][id];
            $id_funcionario = '9999';
            $desc_funcionario = 'ABERTO PELA CENTRAL';
            $nome = $dados[0][nome];
            $endereco = $dados[0][endereco];
            $bairro = $dados[0][bairro];
            $cep = $dados[0][cep];
            $cidade = $dados[0][cidade];
            $uf = $dados[0][uf];
            $telefone = $dados[0][telefone];
            $celular = $dados[0][celular];
            $email = $dados[0][email];
            $numero_os = date('dm') . $idCliente . rand(1000, 9999);
            $dt_abertura = $data;
            $dt_agendamento = $data;
            $h_abertura = $hora;
            $h_agendamento = $hora;
            $descricao = $txtAssunto;
            $historico = $txtMensagem . '<br />===============================<br />';
            $id_tatendimento = $txtTipoAtendimento[0];
            $desc_tatendimento = $txtTipoAtendimento[1];
            $aberto_por = 'adm';

            // Processar a abertura do atendimento
            $abrirAtendimento = $suporte_model->Abrir_Atendimento($id_empresa, $id_cliente, $id_funcionario, $desc_funcionario, $nome, $endereco, $bairro, $cep, $cidade, $uf, $telefone, $celular, $email, $numero_os, $dt_abertura, $dt_agendamento, $h_abertura, $h_agendamento, $descricao, $historico, $id_tatendimento, $desc_tatendimento, $aberto_por);

            // Exibe a mensagem informando que o atendimento foi aberto 
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'sucesso';
            $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: ATENDIMENTO ENVIADO';
            $_SESSION['ALERTA_MENSAGEM'] = 'Seu atendimento foi enviado com sucesso.';

            // Redireciona para a pagina de atendimentos
            header("Location: suporte");
            exit;
        } else {

            // Exibe a mensagem de falha na abertura do atendimento
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'erro';
            $_SESSION['ALERTA_TITULO'] = 'ERRO: FALHA AO ABRIR O ATENDIMENTO';
            $_SESSION['ALERTA_MENSAGEM'] = 'Ocorreu um erro ao abrir seu atendimento. Por favor, tente novamente !';

            header("Location: suporte");
            exit;
        }
    }

}

?>