<?php

class WSSenha extends Controller {

    function __construct() {

        parent::__construct();

        // Instancia a classe de MODEL relacionado
        require 'models/config_model.php';
        $config_model = new Config_Model();

        // Alterar Senha WSConfig
        if (isset($_POST['txtModSenha']) && !empty($_POST['txtModSenha']) && ($_POST['txtModSenha'] == 'AlterarSenha')) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) e limitando a 50 caracteres
            $senhaNova = substr($this->funcoes->removeAspas(strtolower($_POST['txtSenhaNova'])), 0, 15);
            $senhaConfirma = substr($this->funcoes->removeAspas(strtolower($_POST['txtSenhaConfirma'])), 0, 15);

            if (empty($senhaNova) OR empty($senhaConfirma)):

                // Exibe a mensagem informando que os dados não foram preenchidos
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'alerta';
                $_SESSION['ALERTA_TITULO'] = 'OPSSS: ALGO FICOU FALTANDO';
                $_SESSION['ALERTA_MENSAGEM'] = 'Para efetuar a troca da senha, voc&ecirc; deve informar a senha atual, a nova senha e confirmar a nova senha.';

                header("Location: wssenha");
                exit;

            elseif (!empty($senhaNova) OR ! empty($senhaConfirma)):

                // Processar a troca da senha
                $senhaPadrao = 'wsc1234';

                // Consulta a senha registrada no banco
                $senhaAnterior = $config_model->Sistema_Config('CENTRAL_SENHA');

                if ($senhaNova == $senhaConfirma):

                    if (($senhaNova != $senhaPadrao)):

                        // Troca a senha
                        $config_model->Chave_Edit('CENTRAL_SENHA', $senhaNova);

                        // Exibe a mensagem informando que a senha foi alterada
                        @session_start();
                        $_SESSION['ALERTA_TIPO'] = 'sucesso';
                        $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: SENHA ALTERADA';
                        $_SESSION['ALERTA_MENSAGEM'] = 'Sua senha foi alterada com sucesso. Fa&ccedil;a novamente o acesso utilizando sua nova senha.';

                        header("Location: index");
                        exit;

                    else:

                        // Exibe a mensagem informando que não pode utilizar a senha wsc1234
                        @session_start();
                        $_SESSION['ALERTA_TIPO'] = 'erro';
                        $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHA INV&Aacute;LIDA';
                        $_SESSION['ALERTA_MENSAGEM'] = 'Voc&ecirc; n&atilde;o pode utilizar "<strong>wsc1234</strong>" como senha. Por favor, informe outra !';

                        header("Location: wssenha");
                        exit;

                    endif;

                else:

                    // Exibe a mensagem informando que as senhas são diferentes
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHAS DIFERENTES';
                    $_SESSION['ALERTA_MENSAGEM'] = 'Voc&ecirc; digitou duas senhas diferentes no formul&aacute;rio. Para alterar sua senha informe e repita os mesmos caracteres !';

                    header("Location: wssenha");
                    exit;

                endif;

            else:

                // Exibe a mensagem informando que algo deu errado
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'erro';
                $_SESSION['ALERTA_TITULO'] = 'ERRO: ALGO DEU ERRADO';
                $_SESSION['ALERTA_MENSAGEM'] = 'Por favor, tente executar o processo novamente !';

                header("Location: wssenha");
                exit;

            endif;
        }

        // Renderiza a view relacionada
        $this->view->renderConfig('wssenha/index');
    }

}

?>