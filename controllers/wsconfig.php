<?php

class WSConfig extends Controller {

    function __construct() {

        parent::__construct();

        // Instancia a classe de MODEL relacionado
        require 'models/config_model.php';
        $config_model = new Config_Model();

        // Alterar Senha WSConfig
        if (isset($_POST['txtModSenha']) && !empty($_POST['txtModSenha']) && ($_POST['txtModSenha'] == 'AlterarSenha')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) e limitando a 50 caracteres
            $senhaAtual = substr($this->funcoes->removeAspas(strtolower($_POST['txtSenhaAtual'])), 0, 15);
            $senhaNova = substr($this->funcoes->removeAspas(strtolower($_POST['txtSenhaNova'])), 0, 15);
            $senhaConfirma = substr($this->funcoes->removeAspas(strtolower($_POST['txtSenhaConfirma'])), 0, 15);

            if (empty($senhaAtual) OR empty($senhaNova) OR empty($senhaConfirma)):

                // Exibe a mensagem informando que os dados não foram preenchidos
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'alerta';
                $_SESSION['ALERTA_TITULO'] = 'OPSSS: ALGO FICOU FALTANDO';
                $_SESSION['ALERTA_MENSAGEM'] = 'Para efetuar a troca da senha, voc&ecirc; deve informar a senha atual, a nova senha e confirmar a nova senha.';

                header("Location: wsconfig");
                exit;

            elseif (!empty($senhaAtual) OR !empty($senhaNova) OR !empty($senhaConfirma)):

                // Processar a troca da senha
                $senhaPadrao = 'wsc1234';

                // Consulta a senha registrada no banco
                $senhaAnterior = $config_model->Sistema_Config('CENTRAL_SENHA');

                if ($senhaAnterior[0][valor] == $senhaAtual):

                    if ($senhaNova == $senhaConfirma):

                        if (($senhaNova != $senhaPadrao)):

                            // Troca a senha
                            $config_model->Chave_Edit('CENTRAL_SENHA', $senhaNova);

                            // Exibe a mensagem informando que a senha foi alterada
                            @session_start();
                            $_SESSION['ALERTA_TIPO'] = 'sucesso';
                            $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: SENHA ALTERADA';
                            $_SESSION['ALERTA_MENSAGEM'] = 'Sua senha foi alterada com sucesso. A nova senha entrar&aacute; em vigor no pr&oacute;ximo acesso.';

                            header("Location: wsconfig");
                            exit;

                        else:

                            // Exibe a mensagem informando que não pode utilizar a senha wsc1234
                            @session_start();
                            $_SESSION['ALERTA_TIPO'] = 'erro';
                            $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHA INV&Aacute;LIDA';
                            $_SESSION['ALERTA_MENSAGEM'] = 'Voc&ecirc; n&atilde;o pode utilizar "<strong>wsc1234</strong>" como senha. Por favor, informe outra !';

                            header("Location: wsconfig");
                            exit;

                        endif;

                    else:

                        // Exibe a mensagem informando que as senhas são diferentes
                        @session_start();
                        $_SESSION['ALERTA_TIPO'] = 'erro';
                        $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHAS DIFERENTES';
                        $_SESSION['ALERTA_MENSAGEM'] = 'Voc&ecirc; digitou duas senhas diferentes no formul&aacute;rio. Para alterar sua senha informe e repita os mesmos caracteres !';

                        header("Location: wsconfig");
                        exit;

                    endif;

                else:

                    // Exibe a mensagem informando que a senha atual é inválida
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHA ATUAL INV&Aacute;LIDA';
                    $_SESSION['ALERTA_MENSAGEM'] = 'A senha atual informada n&atilde;o confere com a registrada em nossa base de dados !';

                    header("Location: wsconfig");
                    exit;

                endif;

            else:

                // Exibe a mensagem informando que algo deu errado
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'erro';
                $_SESSION['ALERTA_TITULO'] = 'ERRO: ALGO DEU ERRADO';
                $_SESSION['ALERTA_MENSAGEM'] = 'Por favor, tente executar o processo novamente !';

                header("Location: wsconfig");
                exit;

            endif;
        }

        // Alterar Multa e Juros
        if (($_POST['txtModMultaJuros']) && ($_POST['txtModMultaJuros'] == 'AlterarMultaJuros')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $txtMulta = substr($this->funcoes->removeAspas($_POST['txtModTaxaMulta']), 0, 30);
            $txtJuros = substr($this->funcoes->removeAspas($_POST['txtModTaxaJuros']), 0, 30);

            // Altera a taxa de multa
            $config_model->Chave_Edit('MULTA', $txtMulta);

            // Altera a taxa de juros
            $config_model->Chave_Edit('JUROS', $txtJuros);

            // Exibe a mensagem informando que as taxas foram alteradas
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'sucesso';
            $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: TAXA DE MULTA E JUROS ALTERADO';
            $_SESSION['ALERTA_MENSAGEM'] = 'A taxa de multa e juros foram alteradas com sucesso e entrar&aacute; em vigor no pr&oacute;ximo acesso.';

            header("Location: wsconfig");
            exit;
        }

        // Alterar Tema
        if (($_POST['txtModTema']) && ($_POST['txtModTema'] == 'AlterarTema')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $txtTema = substr($this->funcoes->removeAspas($_POST['txtTema']), 0, 30);

            // Altera o tema da central
            $config_model->Chave_Edit('CENTRAL_TEMA', $txtTema);

            // Exibe a mensagem informando que o tema foi alterado
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'sucesso';
            $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: TEMA ALTERADO';
            $_SESSION['ALERTA_MENSAGEM'] = 'O tema foi alterado com sucesso e entrar&aacute; em vigor no pr&oacute;ximo acesso.';

            header("Location: wsconfig");
            exit;
        }

        // Alterar Gráfico
        if (($_POST['txtModGrafico']) && ($_POST['txtModGrafico'] == 'AlterarGrafico')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $txtGrafico = substr($this->funcoes->removeAspas($_POST['txtGrafico']), 0, 30);

            // Altera o tema da central
            $config_model->Chave_Edit('CENTRAL_GRAFICO', $txtGrafico);

            // Exibe a mensagem informando que o grafico foi alterado
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'sucesso';
            $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: GR&Aacute;FICO ALTERADO';
            $_SESSION['ALERTA_MENSAGEM'] = 'O tipo de gr&aacute;fico foi alterado com sucesso.';

            header("Location: wsconfig");
            exit;
        }

        // Alterar Permissões
        if (($_POST['txtPermissoes']) && ($_POST['txtPermissoes'] == 'AlterarPermissoes')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 30 caracteres
            $txtFaturas = substr($this->funcoes->removeAspas($_POST['txtFaturas']), 0, 30);
            $txtContrato = substr($this->funcoes->removeAspas($_POST['txtContrato']), 0, 30);
            $txtNotasFiscais = substr($this->funcoes->removeAspas($_POST['txtNotasFiscais']), 0, 30);
            $txtAtendimento = substr($this->funcoes->removeAspas($_POST['txtAtendimento']), 0, 30);
            $txtServicos = substr($this->funcoes->removeAspas($_POST['txtServicos']), 0, 30);
            $txtAbrirAtendimento = substr($this->funcoes->removeAspas($_POST['txtAbrirAtendimento']), 0, 30);
            $txtAcessos = substr($this->funcoes->removeAspas($_POST['txtAcessos']), 0, 30);
            $txtSenhaCentral = substr($this->funcoes->removeAspas($_POST['txtSenhaCentral']), 0, 30);
            $txtGraficos = substr($this->funcoes->removeAspas($_POST['txtGraficos']), 0, 30);
            $txtMkSenha = substr($this->funcoes->removeAspas($_POST['txtMkSenha']), 0, 30);

            // Altera permissão: FATURAS
            if ($txtFaturas == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_FATURAS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_FATURAS', 'N');

            endif;

            // Altera permissão: CONTRATOS
            if ($txtContrato == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_CONTRATOS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_CONTRATOS', 'N');

            endif;

            // Altera permissão: NOTAS FISCAIS
            if ($txtNotasFiscais == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_NFS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_NFS', 'N');

            endif;

            // Altera permissão: ATENDIMENTOS
            if ($txtAtendimento == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_ATENDIMENTOS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_ATENDIMENTOS', 'N');

            endif;

            // Altera permissão: SERVI�OS
            if ($txtServicos == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_SERVICOS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_SERVICOS', 'N');

            endif;

            // Altera permissão: ABRIR ATENDIMENTO
            if ($txtAbrirAtendimento == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_ABRIR_ATENDIMENTO', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_ABRIR_ATENDIMENTO', 'N');

            endif;

            // Altera permissão: ACESSOS
            if ($txtAcessos == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_ACESSOS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_ACESSOS', 'N');

            endif;

            // Altera permissão: SENHA CENTRAL
            if ($txtSenhaCentral == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_ALTERAR_SENHA', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_ALTERAR_SENHA', 'N');

            endif;

            // Altera permissão: GRAFICOS
            if ($txtGraficos == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_GRAFICOS', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_GRAFICOS', 'N');

            endif;

            // Altera permissão: SENHA CONEXAO
            if ($txtMkSenha == 'on'):

                $config_model->Chave_Edit('CENTRAL_MOD_ALTERAR_MKSENHA', 'S');

            else:

                $config_model->Chave_Edit('CENTRAL_MOD_ALTERAR_MKSENHA', 'N');

            endif;

            // Exibe a mensagem informando que as permissoes foram alteradas
            @session_start();
            $_SESSION['ALERTA_TIPO'] = 'sucesso';
            $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: PERMISS&Otilde;ES ALTERADAS';
            $_SESSION['ALERTA_MENSAGEM'] = 'As permiss&otilde;es foram alteradas com sucesso.';

            header("Location: wsconfig");
            exit;
        }

        // Alterar Tipo de Contrato
        if (($_POST['txtContrato']) && ($_POST['txtContrato'] == 'AlterarContrato')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando a 15 caracteres
            $txtTipoArquivo = substr($this->funcoes->removeAspas($_POST['txtTipoArquivo']), 0, 15);
            $txtArquivo = $_FILES['txtArquivo'];

            echo $txtArquivo['tmp_name'];

            // Altera o tipo de contrato
            if ($txtTipoArquivo == "0") {

                ########## UPLOAD DO ARQUIVO ##########
                // Pasta de destino do arquivo
                $pastaDestino = 'public/contrato';

                // Se a pasta de destino não existir, ela será criada
                if (!file_exists($pastaDestino)) {

                    mkdir($pastaDestino, 0777);
                    chmod($pastaDestino, 0777);
                }

                // Atribui a permissão de escrita na pasta de destino.
                chmod($pastaDestino, 0777);

                // Tipos de arquivos permitidos.
                $tiposPermitidos = array('application/pdf');

                // Definição do nome padrão do arquivo
                $nomeArquivo = 'ContratoDefault.pdf';

                // Verifica se existe o envio de arquivo, e se a extensão não é válida
                if ((is_uploaded_file($txtArquivo['tmp_name'])) && (!in_array($txtArquivo['type'], $tiposPermitidos))) {

                    // Exibe a mensagem de erro informando tipo invalido
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: TIPO DE ARQUIVO INV&Aacute;LIDO';
                    $_SESSION['ALERTA_MENSAGEM'] = '&Eacute; permitido somente arquivo no formato <strong>PDF</strong> !';

                    header("Location: wsconfig");
                    exit;
                }

                // Verifica se existe o envio de arquivo
                if (!is_uploaded_file($txtArquivo['tmp_name'])) {

                    // Exibe a mensagem de erro informando que nenhum arquivo foi enviado
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'alerta';
                    $_SESSION['ALERTA_TITULO'] = 'OPSSS: ALGO FICOU FALTANDO';
                    $_SESSION['ALERTA_MENSAGEM'] = 'Nenhum arquivo enviado. Por favor, selecione um arquivo !';

                    header("Location: wsconfig");
                    exit;
                }

                // Verifica se existe o envio de arquivo, e se a extensão é válida e não houve erro
                if ((is_uploaded_file($txtArquivo['tmp_name'])) && (in_array($txtArquivo['type'], $tiposPermitidos)) && ($txtArquivo['error'] == 0)) {

                    // Faz o upload do arquivo
                    $upload = move_uploaded_file($txtArquivo['tmp_name'], $pastaDestino . "/" . $nomeArquivo);

                    if ($upload) {

                        $config_model->Chave_Edit('CENTRAL_CONTRATO', 'default');
                    }

                    // Exibe a mensagem informando que o tipo de contrato foi alterado
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'sucesso';
                    $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: TIPO DE CONTRATO ALTERADO';
                    $_SESSION['ALERTA_MENSAGEM'] = 'O tipo de contrato foi alterado com sucesso.';

                    header("Location: wsconfig");
                    exit;
                }
            } elseif ($txtTipoArquivo == 1) {

                $config_model->Chave_Edit('CENTRAL_CONTRATO', 'custom');

                // Exibe a mensagem informando que o tipo de contrato foi alterado
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'sucesso';
                $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: TIPO DE CONTRATO ALTERADO';
                $_SESSION['ALERTA_MENSAGEM'] = 'O tipo de contrato foi alterado com sucesso.';

                header("Location: wsconfig");
                exit;
            } else {

                // Exibe a mensagem de erro informando tipo invalido
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'erro';
                $_SESSION['ALERTA_TITULO'] = 'ERRO: TIPO INV&Aacute;LIDO';
                $_SESSION['ALERTA_MENSAGEM'] = 'O tipo informado &eacute; incorreto. Tente novamente !';

                header("Location: wsconfig");
                exit;
            }
        }

        // Consulta a taxa de multa
        $taxa_multa = $config_model->Sistema_Config('MULTA');
        $this->view->taxa_multa_valor = $taxa_multa[0][valor];
        $this->view->taxa_multa_descricao = utf8_encode($taxa_multa[0][descricao]);

        // Consulta a taxa de juros
        $taxa_juros = $config_model->Sistema_Config('JUROS');
        $this->view->taxa_juros_valor = $taxa_juros[0][valor];
        $this->view->taxa_juros_descricao = utf8_encode($taxa_juros[0][descricao]);

        // Consulta tema
        $central_tema = $config_model->Sistema_Config('CENTRAL_TEMA');
        $this->view->central_tema_valor = $central_tema[0][valor];
        $this->view->central_tema_descricao = utf8_encode($central_tema[0][descricao]);

        // Consulta tipo de gráfico
        $central_grafico = $config_model->Sistema_Config('CENTRAL_GRAFICO');
        $this->view->central_grafico_valor = $central_grafico[0][valor];
        $this->view->central_grafico_descricao = utf8_encode($central_grafico[0][descricao]);

        // Consulta tipo de contrato
        $central_contrato = $config_model->Sistema_Config('CENTRAL_CONTRATO');
        $this->view->central_contrato_valor = $central_contrato[0][valor];
        $this->view->central_contrato_descricao = utf8_encode($central_contrato[0][descricao]);

        // Consulta permissões
        $modulo_senha = $config_model->Sistema_Config('CENTRAL_MOD_ALTERAR_SENHA');
        $this->view->modulo_senha_permissao = $modulo_senha[0][valor];
        $this->view->modulo_senha_descricao = utf8_encode($modulo_senha[0][descricao]);

        $modulo_faturas = $config_model->Sistema_Config('CENTRAL_MOD_FATURAS');
        $this->view->modulo_faturas_permissao = $modulo_faturas[0][valor];
        $this->view->modulo_faturas_descricao = utf8_encode($modulo_faturas[0][descricao]);

        $modulo_notafiscal = $config_model->Sistema_Config('CENTRAL_MOD_NFS');
        $this->view->modulo_notafiscal_permissao = $modulo_notafiscal[0][valor];
        $this->view->modulo_notafiscal_descricao = utf8_encode($modulo_notafiscal[0][descricao]);

        $modulo_servicos = $config_model->Sistema_Config('CENTRAL_MOD_SERVICOS');
        $this->view->modulo_servicos_permissao = $modulo_servicos[0][valor];
        $this->view->modulo_servicos_descricao = utf8_encode($modulo_servicos[0][descricao]);

        $modulo_acessos = $config_model->Sistema_Config('CENTRAL_MOD_ACESSOS');
        $this->view->modulo_acessos_permissao = $modulo_acessos[0][valor];
        $this->view->modulo_acessos_descricao = utf8_encode($modulo_acessos[0][descricao]);

        $modulo_graficos = $config_model->Sistema_Config('CENTRAL_MOD_GRAFICOS');
        $this->view->modulo_graficos_permissao = $modulo_graficos[0][valor];
        $this->view->modulo_graficos_descricao = utf8_encode($modulo_graficos[0][descricao]);

        $modulo_contratos = $config_model->Sistema_Config('CENTRAL_MOD_CONTRATOS');
        $this->view->modulo_contratos_permissao = $modulo_contratos[0][valor];
        $this->view->modulo_contratos_descricao = utf8_encode($modulo_contratos[0][descricao]);

        $modulo_atendimentos = $config_model->Sistema_Config('CENTRAL_MOD_ATENDIMENTOS');
        $this->view->modulo_atendimentos_permissao = $modulo_atendimentos[0][valor];
        $this->view->modulo_atendimentos_descricao = utf8_encode($modulo_atendimentos[0][descricao]);

        $modulo_abrir_atendimento = $config_model->Sistema_Config('CENTRAL_MOD_ABRIR_ATENDIMENTO');
        $this->view->modulo_abrir_atendimento_permissao = $modulo_abrir_atendimento[0][valor];
        $this->view->modulo_abrir_atendimento_descricao = utf8_encode($modulo_abrir_atendimento[0][descricao]);

        $modulo_mksenha = $config_model->Sistema_Config('CENTRAL_MOD_ALTERAR_MKSENHA');
        $this->view->modulo_mksenha_permissao = $modulo_mksenha[0][valor];
        $this->view->modulo_mksenha_descricao = utf8_encode($modulo_mksenha[0][descricao]);

        // Renderiza a view relacionada
        $this->view->renderConfig('wsconfig/index');
    }

}

?>