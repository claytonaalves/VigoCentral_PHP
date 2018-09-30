<?php

class Logar extends Controller {

    function __construct() {

        parent::__construct();
        @session_start();

        // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
        @$login_informado = substr($this->funcoes->removeAspas($_POST['login']), 0, 30);
        @$senha_informada = substr($this->funcoes->removeAspas(strtolower($_POST['senha'])), 0, 30);

        // Verifica se algum login e senha foi informado
        if (!isset($login_informado) OR ! isset($senha_informada) OR empty($login_informado) OR empty($senha_informada)) {

            // Aviso informando da necessidade de login e senha
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'alerta';
            $_SESSION['ALERTA_TITULO'] = 'OPSSS: ALGO FICOU FALTANDO';
            $_SESSION['ALERTA_MENSAGEM'] = 'Para ter acesso ao sistema informe seu login e senha.';
            @header("Location: index");
            exit;

            // Verifica se o login informando é da central de configuração
        } elseif (($login_informado == 'wsconfig')) {

            // Instancia a classe de MODEL relacionado
            require 'models/config_model.php'; // O MODEL não é "auto-carregado" como as libs
            $config_model = new Config_Model();

            // Consulta a senha wsconfig
            $central_senha = $config_model->Sistema_Config('CENTRAL_SENHA');
            $senha_central = strtolower($central_senha[0][valor]);

            // Verifica se a senha informada é a senha padrão
            if (($senha_informada == 'wsc1234') && ($senha_informada == $senha_central)) {

                ###################################################################################
                /* 		   NO PRIMEIRO ACESSO, FORÇAR TROCA DA SENHA WSCONFIG PADRAO 			 */
                ###################################################################################
                // Se for a senha padrão, força a troca da senha
                @@header("Location: wssenha");
                //exit;
                ###################################################################################
                // Senão
            } else {

                @session_start();

                $_SESSION['CENTRAL_TEMA'] = NULL;
                unset($_SESSION['CENTRAL_TEMA']);

                // Consulta o login wsconfig
                $central_login = $config_model->Sistema_Config('CENTRAL_LOGIN');
                $login_central = $central_login[0][valor];

                // Consulta a senha wsconfig
                $central_senha = $config_model->Sistema_Config('CENTRAL_SENHA');
                $senha_central = $central_senha[0][valor];

                if (($login_informado == $login_central) && ($senha_informada == $senha_central)) {

                    // Consulta o tema da central
                    $central_tema = $config_model->Sistema_Config('CENTRAL_TEMA');
                    $_SESSION['CENTRAL_TEMA'] = $central_tema[0][valor];

                    $_SESSION['LOGIN'] = $login_central;

                    // Redireciona para a página de config
                    @@header("Location: wsconfig");
                } else {

                    // Aviso que a senha wsconfig está errada e força um logout
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHA INV&Aacute;LIDA';
                    $_SESSION['ALERTA_MENSAGEM'] = 'A senha informada est&aacute; incorreta. Tente novamente !';
                    @@header("Location: index");
                    exit;
                }
            }
        } else {

            // Instancia a classe de MODEL relacionado

            require 'models/sessao_model.php';
            $logar_model = new Sessao_Model();

            // Consulta se existe algum cliente com login informado
            $existe = $logar_model->Usuario_Existe($login_informado);

            if (!$existe) {

                // Aviso de login invalido e força um logout
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'erro';
                $_SESSION['ALERTA_TITULO'] = 'ERRO: LOGIN INV&Aacute;LIDO';
                $_SESSION['ALERTA_MENSAGEM'] = 'N&atilde;o encontramos nenhum usu&aacute;rio com o login informado. Por favor, verifique !';
                @@header("Location: index");
                exit;
            } else {
                // Consulta se existe algum cliente com login e senha informado
                $existe = $logar_model->Valida_Credenciais($login_informado, $senha_informada);

                if (!$existe) {

                    // Aviso de senha errada e força um logout
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHA INV&Aacute;LIDA';
                    $_SESSION['ALERTA_MENSAGEM'] = 'A senha informada est&aacute; incorreta. Tente novamente !';
                    @@header("Location: index");
                    exit;
                } else {

                    // Instancia a classe de MODEL relacionado
                    require 'models/config_model.php';
                    $config_model = new Config_Model();

                    // Consulta de chaves de configuracao
                    $sistema_multa = $config_model->Sistema_Config('MULTA');
                    $sistema_juros = $config_model->Sistema_Config('JUROS');

                    $central_tema = $config_model->Sistema_Config('CENTRAL_TEMA');
                    $central_contrato = $config_model->Sistema_Config('CENTRAL_CONTRATO');
                    $central_grafico = $config_model->Sistema_Config('CENTRAL_GRAFICO');

                    $central_mod_alterar_senha = $config_model->Sistema_Config('CENTRAL_MOD_ALTERAR_SENHA');
                    $central_mod_faturas = $config_model->Sistema_Config('CENTRAL_MOD_FATURAS');
                    $central_mod_nfs = $config_model->Sistema_Config('CENTRAL_MOD_NFS');
                    $central_mod_servicos = $config_model->Sistema_Config('CENTRAL_MOD_SERVICOS');
                    $central_mod_acessos = $config_model->Sistema_Config('CENTRAL_MOD_ACESSOS');
                    $central_mod_graficos = $config_model->Sistema_Config('CENTRAL_MOD_GRAFICOS');
                    $central_mod_contratos = $config_model->Sistema_Config('CENTRAL_MOD_CONTRATOS');
                    $central_mod_atendimentos = $config_model->Sistema_Config('CENTRAL_MOD_ATENDIMENTOS');
                    $central_mod_abrir_atendimento = $config_model->Sistema_Config('CENTRAL_MOD_ABRIR_ATENDIMENTO');
                    $central_mod_alterar_mksenha = $config_model->Sistema_Config('CENTRAL_MOD_ALTERAR_MKSENHA');

                    // Cria $_SESSION com as chaves de configurações
                    @session_start();
                    $_SESSION['CENTRAL_TEMA'] = $central_tema[0][valor];
                    $_SESSION['CENTRAL_TIPO_CONTRATO'] = $central_contrato[0][valor];
                    $_SESSION['SISTEMA_MULTA'] = $sistema_multa[0][valor];
                    $_SESSION['SISTEMA_JUROS'] = $sistema_juros[0][valor];
                    $_SESSION['CENTRAL_GRAFICO'] = $central_grafico[0][valor];
                    $_SESSION['CENTRAL_MOD_SENHA'] = $central_mod_alterar_senha[0][valor];
                    $_SESSION['CENTRAL_MOD_FATURAS'] = $central_mod_faturas[0][valor];
                    $_SESSION['CENTRAL_MOD_NFS'] = $central_mod_nfs[0][valor];
                    $_SESSION['CENTRAL_MOD_SERVICOS'] = $central_mod_servicos[0][valor];
                    $_SESSION['CENTRAL_MOD_ACESSOS'] = $central_mod_acessos[0][valor];
                    $_SESSION['CENTRAL_MOD_GRAFICOS'] = $central_mod_graficos[0][valor];
                    $_SESSION['CENTRAL_MOD_CONTRATOS'] = $central_mod_contratos[0][valor];
                    $_SESSION['CENTRAL_MOD_ATENDIMENTOS'] = $central_mod_atendimentos[0][valor];
                    $_SESSION['CENTRAL_MOD_ABRIR_ATENDIMENTO'] = $central_mod_abrir_atendimento[0][valor];
                    $_SESSION['CENTRAL_MOD_MKSENHA'] = $central_mod_alterar_mksenha[0][valor];

                    // Captura as informações do cliente autenticado corretamente
                    $dados = $logar_model->Dados_Cliente($login_informado);

                    $this->view->id_cliente = $dados[0][id];
                    $this->view->id_empresa = $dados[0][idempresa];
                    $this->view->nome = $dados[0][nome];
                    $this->view->sexo = $dados[0][sexo];
                    $this->view->endereco = $dados[0][endereco];
                    $this->view->bairro = $dados[0][bairro];
                    $this->view->cpfcgc = $dados[0][cpfcgc];
                    $this->view->cidade = $dados[0][cidade];
                    $this->view->uf = $dados[0][uf];
                    $this->view->dt_entrada = $this->funcoes->dataToBR($dados[0][dt_entrada]);
                    $this->view->login = $dados[0][login];

                    // Cria $_SESSION do cliente logando
                    @session_start();
                    $_SESSION['ID_CLIENTE'] = $dados[0][id];
                    $_SESSION['CPFCNPJ'] = $dados[0][cpfcgc];
                    $_SESSION['LOGIN'] = $dados[0][login];
                    $_SESSION['ID_EMPRESA'] = $dados[0][idempresa];
                    $_SESSION['FANTASIA'] = $dados[0][fantasia];
                    $_SESSION['FOTO_EMPRESA'] = $dados[0][foto];

                    // Redireciona para o controller relacionado
                    @@header("Location: core");
                }
            }
        }
    }

}

?>
