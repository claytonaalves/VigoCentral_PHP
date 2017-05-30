<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessaoWSConfig();
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

    <div class="container" style="border:none;padding:0px;margin:0;">
        <h1>Ol&aacute;, TUDO BEM ?</h1>
        <p>Bem vindo ao ambiente de configura&ccedil;&atilde;o da central do cliente!</p>

        <ul class="icons">

            <li><a id="lnkSenha" href="#senha" title="Alterar Senha"><span class="flaticon-senha"></span><div>Alterar Senha</div></a></li>
            <li><a id="lnkMultaJuros" href="#multaejuros" title="Multa e Juros"><span class="flaticon-faturas"></span><div>Multa e Juros</div></a></li>
            <li><a id="lnkTema" href="#tema" title="Tema da Central"><span class="flaticon-nfiscal"></span><div>Tema</div></a></li>
            <li><a id="lnkContrato" href="#contratos" title="Tipo de Contrato"><span class="flaticon-contrato"></span><div>Contrato</div></a></li>
            <li><a id="lnkGrafico" href="#grafico" title="Tipo de Gr&aacute;fico"><span class="flaticon-graficos"></span><div>Gr&aacute;fico</div></a></li>
            <li><a id="lnkPermissoes" href="#permissoes" title="M&oacute;dulos da Central"><span class="flaticon-mikrotik"></span><div>M&oacute;dulos</div></a></li>

        </ul>

        <!-- BOX: ALTERAR SENHA WSCONFIG -->
        <div class="boxWSConfig" id="alterarSenha" style="display:none;">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfig" id="boxSenha">

                <h2 class="align-c">Troca de Senha...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formSenha" action="wsconfig" method="post">

                        <label for="txtSenhaAtual" class="optTema" title="Digite a senha atual do WSConfig">
                            <span>Senha Atual:</span>
                            <input type="password" required="required" name="txtSenhaAtual" id="txtModSenha" maxlength="15" autofocus />
                        </label>

                        <label for="txtSenhaNova" class="optTema" title="Defina a nova senha do WSConfig">
                            <span>Nova Senha:</span>
                            <input type="password" required="required" name="txtSenhaNova" id="txtModSenha" maxlength="15" />
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


        <!-- BOX: DEFINIR MULTA E JUROS -->
        <div style="display:none;" class="boxWSConfig" id="alterarMultaJuros">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfig" id="boxMultaJuros">

                <h2 class="align-c">Multa e Juros...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formMultaJuros" action="wsconfig" method="post">

                        <label for="txtTaxaMulta" class="optTema optColunas" title="<?php echo $this->taxa_multa_descricao; ?>">
                            <span>Taxa de Multa:</span>
                            <input type="text" required="required" name="txtModTaxaMulta" id="txtModTaxaMulta" value="<?php echo $this->taxa_multa_valor; ?>" maxlength="30" autofocus />
                        </label>

                        <label for="txtTaxaJuros" class="optTema optColunas optRight" title="<?php echo $this->taxa_juros_descricao; ?>">
                            <span>Taxa de Juros:</span>
                            <input type="text" required="required" name="txtModTaxaJuros" id="txtModTaxaJuros" value="<?php echo $this->taxa_juros_valor; ?>" maxlength="30" />
                        </label>

                        <input type="hidden" required="required" name="txtModMultaJuros" id="txtModMultaJuros" value="AlterarMultaJuros" maxlength="30" />
                        <input class="botao btnExtra" type="submit" value="Alterar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div>
        <!-- /FIM - DEFINIR MULTA E JUROS -->


        <!-- BOX: DEFINIR TEMA -->   
        <div style="display:none;" class="boxWSConfig" id="alterarTema">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfig" id="boxTema">

                <h2 class="align-c">Tema da Central...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formTema" action="wsconfig" method="post">

                        <label for="txtTema" class="optTema" title="<?php echo $this->central_tema_descricao; ?>">
                            <span>Tema:</span>
                            <select name="txtTema" id="txtTema" required="required" autofocus>

                                <option value="" selected="selected" disabled="disabled">Selecione um tema&nbsp;&nbsp;</option>
                                <option value="" disabled="disabled">&nbsp;</option>

                                <option <?php if ($this->central_tema_valor == 'amarelo') {
    echo 'selected';
} ?> value="amarelo">Estilo Amarelo</option>
                                <option <?php if ($this->central_tema_valor == 'azul') {
    echo 'selected';
} ?> value="azul">Estilo Azul</option>
                                <option <?php if ($this->central_tema_valor == 'cinza') {
    echo 'selected';
} ?> value="cinza">Estilo Cinza</option>
                                <option <?php if ($this->central_tema_valor == 'laranja') {
    echo 'selected';
} ?> value="laranja">Estilo Laranja</option>
                                <option <?php if ($this->central_tema_valor == 'magenta') {
    echo 'selected';
} ?> value="magenta">Estilo Magenta</option>
                                <option <?php if ($this->central_tema_valor == 'rosa') {
    echo 'selected';
} ?> value="rosa">Estilo Rosa</option>
                                <option <?php if ($this->central_tema_valor == 'roxo') {
    echo 'selected';
} ?> value="roxo">Estilo Roxo</option>
                                <option <?php if ($this->central_tema_valor == 'turquesa') {
    echo 'selected';
} ?> value="turquesa">Estilo Turquesa</option>
                                <option <?php if ($this->central_tema_valor == 'verde') {
    echo 'selected';
} ?> value="verde">Estilo Verde</option>
                                <option <?php if ($this->central_tema_valor == 'vermelho') {
    echo 'selected';
} ?> value="vermelho">Estilo Vermelho</option>

                            </select>
                        </label>

                        <input type="hidden" required="required" name="txtModTema" id="txtModTema" value="AlterarTema" maxlength="30" />
                        <input class="botao btnExtra" type="submit" value="Alterar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div>
        <!-- /FIM - DEFINIR TEMA -->


        <!-- BOX: DEFINIR TIPO DE GRAFICO -->   
        <div style="display:none;" class="boxWSConfig" id="alterarGrafico">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfig" id="boxGrafico">

                <h2 class="align-c">Tipo de Gr&aacute;fico...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formGrafico" action="wsconfig" method="post">

                        <label for="txtGrafico" class="optTema" title="<?php echo $this->central_grafico_descricao; ?>">
                            <span>Tipo do Gr&aacute;fico:</span>
                            <select name="txtGrafico" id="txtGrafico" required="required" autofocus>

                                <option value="" selected="selected" disabled="disabled">Selecione um tipo de gr&aacute;fico&nbsp;&nbsp;</option>
                                <option value="" disabled="disabled">&nbsp;</option>

                                <option <?php if ($this->central_grafico_valor == 'area') {
    echo 'selected';
} ?> value="area">Gr&aacute;fico em &Aacute;rea</option>
                                <option <?php if ($this->central_grafico_valor == 'column') {
    echo 'selected';
} ?> value="column">Gr&aacute;fico em Colunas</option>
                                <option <?php if ($this->central_grafico_valor == 'spline') {
    echo 'selected';
} ?> value="spline">Gr&aacute;fico em Curvas</option>
                                <option <?php if ($this->central_grafico_valor == 'line') {
    echo 'selected';
} ?> value="line">Gr&aacute;fico em Linhas</option>

                            </select>
                        </label>

                        <input type="hidden" required="required" name="txtModGrafico" id="txtModGrafico" value="AlterarGrafico" maxlength="30" />
                        <input class="botao btnExtra" type="submit" value="Alterar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div>
        <!-- /FIM - DEFINIR TIPO DE GRAFICO -->


        <!-- BOX: DEFINIR PERMISSÕES -->
        <div style="display:none;" class="boxWSConfig" id="alterarPermissoes">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfig" id="boxPermissoes">

                <h2 class="align-c">Par&acirc;metros de Exibi&ccedil;&atilde;o...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formPermissoes" action="wsconfig" method="post">

                        <label class="optTema optColunas lblPermissoes" title="<?php echo $this->modulo_faturas_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtFaturas" <?php if ($this->modulo_faturas_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Faturas</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes optRight" title="<?php echo $this->modulo_contratos_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtContrato" <?php if ($this->modulo_contratos_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Contrato</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes" title="<?php echo $this->modulo_notafiscal_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtNotasFiscais" <?php if ($this->modulo_notafiscal_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Nota Fiscais</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes optRight" title="<?php echo $this->modulo_atendimentos_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtAtendimento" <?php if ($this->modulo_atendimentos_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Atendimentos</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes" title="<?php echo $this->modulo_servicos_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtServicos" <?php if ($this->modulo_servicos_permissao == 'S') {
    echo 'checked="checked"';
} ?>v /></span>
                                </div>
                                <div class="blocoRotulo">Servi&ccedil;os</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes optRight" title="<?php echo $this->modulo_abrir_atendimento_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtAbrirAtendimento" <?php if ($this->modulo_abrir_atendimento_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Abrir Atendimento</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes" title="<?php echo $this->modulo_acessos_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtAcessos" <?php if ($this->modulo_acessos_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Extrato de Acessos</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes optRight" title="<?php echo $this->modulo_senha_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtSenhaCentral" <?php if ($this->modulo_senha_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Senha da Central</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes" title="<?php echo $this->modulo_graficos_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtGraficos" <?php if ($this->modulo_graficos_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Gr&aacute;ficos</div>
                            </span>
                        </label>

                        <label class="optTema optColunas lblPermissoes optRight" title="<?php echo $this->modulo_mksenha_descricao; ?>">
                            <span>
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="checkbox" name="txtMkSenha" <?php if ($this->modulo_mksenha_permissao == 'S') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Senha de Conex&atilde;o</div>
                            </span>
                        </label>

                        <input type="hidden" required="required" name="txtPermissoes" id="txtPermissoes" value="AlterarPermissoes" maxlength="30" />
                        <input class="botao btnExtra" type="submit" value="Gravar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div>
        <!-- /FIM - DEFINIR PERMISSÕES -->

        <!-- BOX: DEFINIR TIPO DE CONTRATO -->
        <div style="display:none;" class="boxWSConfig" id="alterarContrato">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="infoWSConfig" id="boxContrato">

                <h2 class="align-c">Tipo de Contrato...</h2>

                <!-- FORMULARIO -->
                <div class="formWSConfig">

                    <form name="formContrato" action="wsconfig" method="post" enctype="multipart/form-data" >

                        <label class="optTema optColunas lblHint" title="<?php echo $this->central_contrato_descricao; ?>">

                            <span>Tipo de Contrato:</span>
                            <div class="lblContrato">
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="radio" id="arquivoCustom" name="txtTipoArquivo" value="1" <?php if ($this->central_contrato_valor == 'custom') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Personalizado</div>
                            </div>

                            <div class="lblContrato lblExtra">
                                <div class="blocoRotuloChk">
                                    <span class="lblRadio"><input class="txtRadio" type="radio" id="arquivoDefault" name="txtTipoArquivo" value="0" <?php if ($this->central_contrato_valor == 'default') {
    echo 'checked="checked"';
} ?> /></span>
                                </div>
                                <div class="blocoRotulo">Padr&atilde;o</div>
                            </div>

                        </label>

                        <label id="lblArquivo" class="optTema optColunas optRight optSenha lblHint" title="Define o arquivo de contrato PADR&Atilde;O">

                            <span>Arquivo de Contrato Padr&atilde;o:</span>
                            <input type="file" id="txtArquivo" name="txtArquivo" size="20" style="border:1px solid #bbb;padding:3px;font-size:12pt;" accept="application/pdf;">

                        </label>

                        <label class="optTema lblHint boxHint">
                            <span class="hint">OBS: &Eacute; permitido somente arquivo no formato PDF</span>
                        </label>

                        <input type="hidden" required="required" name="txtContrato" id="txtContrato" value="AlterarContrato" maxlength="15" />
                        <input class="botao btnExtra" type="submit" value="Alterar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div>
        <!-- /FIM - DEFINIR TIPO DE CONTRATO -->

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: WSCONFIG -->