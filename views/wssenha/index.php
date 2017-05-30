<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
//$funcoes->verificaSessaoWSConfig();
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

<!-- SECAO: WSCONFIG -->
<section class="wsconfig" style="border:1px solid transparent;padding:0px;margin:0 auto;">

    <div class="containers" style="border:none;padding:0px;margin:0;">

        <h1 class="align-c">Ol&aacute;, TUDO BEM ?</h1>

        <p><strong>Aviso Legal</strong><br />Antes de utilizar a central de configura&ccedil;&atilde;o, &eacute; necess&aacute;rio que efetue a troca da senha padr&atilde;o.<br />
            Ap&oacute;s a troca obrigat&oacute;ria, voc&ecirc; dever&aacute; logar-se novamente.</p>

        <!-- BOX: ALTERAR SENHA WSCONFIG -->
        <div class="boxWSConfigs" id="alterarSenha" style="display:block;">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfigs" id="boxSenha">

                <h2 class="align-c">Troca de Senha...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formSenha" action="wssenha" method="post">

                        <label for="txtSenhaNova" class="optTema" title="Defina a nova senha do WSConfig">
                            <span>Nova Senha:</span>
                            <input type="password" required="required" name="txtSenhaNova" id="txtModSenha" maxlength="15" autofocus />
                        </label>

                        <label for="txtSenhaConfirma" class="optTema" title="Confirme a nova senha do WSConfig">
                            <span>Confirmar Senha:</span>
                            <input type="password" required="required" name="txtSenhaConfirma" id="txtModSenha" maxlength="15" />
                        </label>

                        <input type="hidden" required="required" name="txtModSenha" id="txtModSenha" value="AlterarSenha" maxlength="15" />
                        <input class="botao btnExtra" type="submit" value="Alterar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div>
        <!-- /FIM - ALTERAR SENHA WSCONFIG -->

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: WSCONFIG -->