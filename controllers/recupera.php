<?php

class Recupera extends Controller {

    function __construct() {

        parent::__construct();

        // Recuperar senha de acesso
        if (($_POST['txtRecuperar']) && ($_POST['txtRecuperar'] == 'RecuperarSenha')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $login_informado = substr($this->funcoes->removeAspas($_POST['txtLogin']), 0, 30);

            // Se não existir post do login ou o post for vazio
            if (!isset($login_informado) OR empty($login_informado)):

                // Aviso informando da necessidade de informar login
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'alerta';
                $_SESSION['ALERTA_TITULO'] = 'OPSSS: ALGO FICOU FALTANDO';
                $_SESSION['ALERTA_MENSAGEM'] = 'Para recuperar sua senha informe seu login.';

                // Redireciona para o controller relacionado
                header("Location: recupera");
                exit;

            else:

                // Instancia a classe de MODEL relacionado
                require 'models/sessao_model.php';
                $logar_model = new Sessao_Model();

                // Consulta se existe algum cliente com login informado
                $existe = $logar_model->Pesquisa_Credenciais($login_informado);

                if (($existe[0][total] == 0)):

                    // Aviso de login invalido e força um logout
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: LOGIN INV&Aacute;LIDO';
                    $_SESSION['ALERTA_MENSAGEM'] = 'N&atilde;o encontramos nenhum usu&aacute;rio com o login informado.';

                    // Redireciona para o controller relacionado
                    header("Location: recupera");
                    exit;

                else:

                    // Recupera as informações do cliente
                    $dados = $logar_model->Dados_Cliente($login_informado);

                    $clienteIdEmpresa = $dados[0][idempresa];
                    $clienteLogin = $dados[0][login];
                    $clienteSenha = $dados[0][senha];
                    $clienteEmail = $dados[0][email];

                    // Instancia a classe de MODEL relacionado
                    require 'models/empresa_model.php';
                    $empresa_model = new Empresa_Model();

                    // Consulta dados da empresa para assinar o email
                    $dados_empresa = $empresa_model->Dados_Empresa($clienteIdEmpresa);

                    $empresaFantasia = utf8_encode($dados_empresa[0][fantasia]);
                    $empresaTelefone = utf8_encode($dados_empresa[0][telefone]);
                    $empresaEndereco = utf8_encode($dados_empresa[0][endereco]);
                    $empresaCEP = utf8_encode($dados_empresa[0][cep]);
                    $empresaCidade = utf8_encode($dados_empresa[0][cidade]);
                    $empresaUF = utf8_encode($dados_empresa[0][uf]);
                    $empresaSite = utf8_encode($dados_empresa[0][site]);
                    $empresaEmail = utf8_encode($dados_empresa[0][email]);

                    ##### MONTA A ESTRUTURA DO EMAIL #####
                    // Define o assunto do email
                    $headerAssunto = 'SENHA DE ACESSO RECUPERADA';

                    // Define a estrutura da mensagem do email
                    $headerMensagem = "============ SENHA RECUPERADA ============\n\n";
                    $headerMensagem.= "Login...: $clienteLogin\n";
                    $headerMensagem.= "Senha...: $clienteSenha\n";
                    $headerMensagem.= "\n\n";
                    $headerMensagem.= "$empresaFantasia\n";
                    $headerMensagem.= "Telefone: $empresaTelefone\n";
                    $headerMensagem.= "End: $empresaEndereco\n";
                    $headerMensagem.= "$empresaCEP - $empresaCidade/$empresaUF\n";
                    $headerMensagem.= "$empresaSite\n\n";
                    $headerMensagem.= "==========================================\n";
                    $headerMensagem.= "Enviada em " . date("d/m/Y") . " às " . date("h:i") . "\n\n";
                    $headerMensagem.= "==========================================\n\n";

                    // Define o remetente do email
                    $headerRemetente = "From: $empresaFantasia <$empresaEmail>";

                    // Envia o email de recuperação da senha
                    @mail($clienteEmail, $headerAssunto, $headerMensagem, $headerRemetente);

                    // Exibe a mensagem informando que a senha foi recuperada e encaminhada no email
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'sucesso';
                    $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: SENHA RECUPERADA';
                    $_SESSION['ALERTA_MENSAGEM'] = 'Sua senha foi enviada para o e-mail: <b>' . $clienteEmail . '</b>';

                    // Redireciona para o controller relacionado
                    header("Location: index");
                    exit;

                endif;

            endif;
        }

        // Instancia a classe de MODEL relacionado
        require 'models/empresa_model.php';
        $empresa_model = new Empresa_Model();

        // Consulta dados da empresa para exibição da logo
        $id_empresa = 1;
        $dados_empresa = $empresa_model->Dados_Empresa($id_empresa);

        $empresa->foto = $dados_empresa[0][foto];
        $empresa->fantasia = utf8_encode($dados_empresa[0][fantasia]);

        // Instancia a classe de MODEL relacionado
        require 'models/config_model.php'; // O MODEL não é "auto-carregado" como as libs
        $config_model = new Config_Model();

        // Aplica o tema da central
        $central_tema = $config_model->Sistema_Config('CENTRAL_TEMA');
        $config->tema = $central_tema[0][valor];

        // Renderiza a view relacionada
        $this->view->config = $config;
        $this->view->empresa = $empresa;

        $this->view->render('recupera/index');
    }

}

?>