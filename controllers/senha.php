<?php

class Senha extends Controller {

    function __construct() {

        parent::__construct();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Remove aspas do conteúdo postado (segurança contra SQL Injection) e limitando a 50 caracteres
        @$senhaAtual = substr($this->funcoes->removeAspas($_POST['txtSenhaAtual']), 0, 50);
        @$senhaNova = substr($this->funcoes->removeAspas($_POST['txtSenhaNova']), 0, 50);
        @$senhaConfirma = substr($this->funcoes->removeAspas($_POST['txtSenhaConfirma']), 0, 50);

        if (($senhaAtual != '') && ($senhaNova != '') && ($senhaConfirma != '')) {

            // Instancia a classe de MODEL relacionado
            require 'models/senha_model.php'; // O MODEL não é "auto-carregado" como as libs
            $senha_model = new Senha_Model();

            // Processar a troca da senha
            $senha_anterior = $senha_model->Pega_Senha($_SESSION['ID_CLIENTE']);

            if ($senha_anterior[0][senha] == $senhaAtual):

                if ($senhaNova == $senhaConfirma):

                    // Troca a senha
                    $senha_model->Troca_Senha($_SESSION['ID_CLIENTE'], $senhaNova);

                    // Exibe a mensagem informando que a senha foi alterada
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'sucesso';
                    $_SESSION['ALERTA_TITULO'] = 'TUDO CERTO: SENHA ALTERADA';
                    $_SESSION['ALERTA_MENSAGEM'] = 'Sua senha foi alterada com sucesso. A nova senha entrar&aacute; em vigor no pr&oacute;ximo acesso.';

                    header("Location: senha");
                    exit;

                else:

                    // Exibe a mensagem informando que as senhas são diferentes
                    @session_start();
                    $_SESSION['ALERTA_TIPO'] = 'erro';
                    $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHAS DIFERENTES';
                    $_SESSION['ALERTA_MENSAGEM'] = 'Voc&ecirc; digitou duas senhas diferentes no formul&aacute;rio. Para alterar sua senha informe e repita os mesmos caracteres !';

                    header("Location: senha");
                    exit;

                endif;

            else:

                // Exibe a mensagem informando que a senha atual é inválida
                @session_start();
                $_SESSION['ALERTA_TIPO'] = 'erro';
                $_SESSION['ALERTA_TITULO'] = 'ERRO: SENHA ATUAL INV&Aacute;LIDA';
                $_SESSION['ALERTA_MENSAGEM'] = 'A senha atual informada n&atilde;o confere com a registrada em nossa base de dados !';

                header("Location: senha");
                exit;

            endif;
        }else {

            // Renderiza a view relacionada
            $this->view->login = $_SESSION['LOGIN'];

            $this->view->renderJQ('senha/index');
        }
    }

}

?>