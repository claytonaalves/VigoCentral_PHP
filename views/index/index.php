<div class="telaLogin">

    <?php if ($this->empresa->foto == ''): ?>
        <div class="login_topo">
            <div class="box_logo">
                <span class="seta-01">&nbsp;</span>
                <span class="seta-02">&nbsp;</span>
                <span class="seta-03">&nbsp;</span>
                <span class="seta-04">&nbsp;</span>
                <span class="seta-05">&nbsp;</span>
                <span class="seta-06">&nbsp;</span>
                <span class="seta-07">&nbsp;</span>
                <span class="seta-08">&nbsp;</span>
            </div>
            <span>Central do Cliente</span>
        </div>
    <?php else: ?>
        <div class="login_topo">
            <img class="img_ico_topo" width="200" height="90" title="<?php echo $this->empresa->fantasia; ?>" src="data:image/jpeg;base64,<?php echo base64_encode($this->empresa->foto); ?>" />
        </div>
    <?php endif; ?>


    <h1>Acesse sua conta e tenha acesso aos boletos, notas fiscais e extrato de conex&otilde;es.</h1>

    <div class="boxLogin">
        <div class="container">

            <?php
            @session_start();

            if (isset($_SESSION['ALERTA_MENSAGEM']) AND ( $_SESSION['ALERTA_MENSAGEM'] != NULL)) {
                echo "<div class='messageBox' id='messageBox'><span class='close' onclick=\"javascript:document.getElementById('messageBox').className='fecharMessage';\">&nbsp;</span><div class='" . $_SESSION['ALERTA_TIPO'] . "'><p><strong>" . $_SESSION['ALERTA_TITULO'] . "...</strong></p><p>" . $_SESSION['ALERTA_MENSAGEM'] . "</p></div></div>";
            }

            $_SESSION['ALERTA_TIPO'] = NULL;
            $_SESSION['ALERTA_TITULO'] = NULL;
            $_SESSION['ALERTA_MENSAGEM'] = NULL;

            unset($_SESSION['ALERTA_TIPO']);
            unset($_SESSION['ALERTA_TITULO']);
            unset($_SESSION['ALERTA_MENSAGEM']);

            // Remove todas as variáveis de sessão
            @session_unset();

            // Destrói a sessão
            @session_destroy();
            ?>
            <div style="display:none;" class="messageBox" id="messageBox"></div>

            <form name="formLogin" action="logar" method="post">
                <label>
                    <span>Login</span>
                    <input type="text" class="input" name="login" id="login" size="20" maxlength="30" autofocus />
                </label>
                <label>
                    <span>Senha</span>
                    <input type="password" class="input" name="senha" id="senha" size="20" maxlength="30" />
                </label>
                <label>
                    <input type="submit" class="botaoLogar" value="Acessar"/>
                </label>
            </form>
            <span class="recupera"><a href="recupera" class="forgot_pass">esqueci minha senha</a></span>
        </div>
    </div>
</div>