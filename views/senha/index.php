<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>

<?php
@session_start();

if (isset($_SESSION['ALERTA_MENSAGEM']) AND ( $_SESSION['ALERTA_MENSAGEM'] != NULL)) {
    echo "<div class='messageBox' id='messageBox'><span class='close' onclick=\"javascript:document.getElementById('messageBox').className='fecharMessage';\">&nbsp;</span><div class='" . $_SESSION['ALERTA_TIPO'] . "'><p><strong>" . $_SESSION['ALERTA_TITULO'] . "...</strong><br />" . $_SESSION['ALERTA_MENSAGEM'] . "</p></div></div>";
}

$_SESSION['ALERTA_TIPO'] = NULL;
$_SESSION['ALERTA_TITULO'] = NULL;
$_SESSION['ALERTA_MENSAGEM'] = NULL;

unset($_SESSION['ALERTA_TIPO']);
unset($_SESSION['ALERTA_TITULO']);
unset($_SESSION['ALERTA_MENSAGEM']);
?>
<div style="display:none;" class="messageBox" id="messageBox"></div>

<!-- SECAO: ALTERAR SENHA -->
<section class="dados">

    <div class="container">

        <h1>Alterar Senha</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="conta">MINHA CONTA</a></li>
            <li class="target">ALTERAR SENHA</li>
        </ul>

        <h3>Altera&ccedil;&atilde;o de Senha</h3>

        <!-- FORMULARIO -->
        <div class="formSenha">

            <form name="formSenha" action="senha" method="post">

                <label>
                    <span>Login da Central:</span>
                    <strong class="minusculo"><?php echo utf8_decode(utf8_encode($this->login)); ?></strong>
                </label>

                <label for="txtSenhaAtual" class="optSenha">
                    <span>Senha Atual:</span>
                    <input type="password" required="required" name="txtSenhaAtual" id="txtSenhaAtual" class="txtSenhaAtual" maxlength="15" autofocus />
                </label>

                <label for="txtNovaSenha">
                    <span>Nova Senha:</span>
                    <input type="password" required="required" name="txtSenhaNova" id="txtNovaSenha" class="txtNovaSenha" maxlength="15" />
                </label>

                <label for="txtConfirmar" class="optSenha">
                    <span>Confirmar Nova Senha:</span>
                    <input type="password" required="required" name="txtSenhaConfirma" id="txtConfirmar" class="txtConfirmar" maxlength="15" />
                </label>

                <input class="botao btnExtra" type="submit" value="Alterar Senha" />

            </form>

        </div><!-- /FIM - FORMULARIO -->

        <p>Todos os dados s&atilde;o confidenciais, n&atilde;o os informem a ningu&eacute;m.<br />Nenhum funcion&aacute;rio do Provedor est&aacute; autorizado a solicit&aacute;-la.</p>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: ALTERAR SENHA -->