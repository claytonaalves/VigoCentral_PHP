<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>

<!-- SECAO: NOTA FISCAL -->
<section class="dados">			
    <div class="container">
        <h1>Notas Fiscais</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="financeiro">FINANCEIRO</a></li>
            <li class="target">NOTAS FISCAIS</li>
        </ul>

        <p>O quadro abaixo segue um padr&atilde;o l&oacute;gico de demonstra&ccedil;&atilde;o das &uacute;ltimas notas fiscais emitidas para sua conta e permite um controle de f&aacute;cil visualiza&ccedil;&atilde;o por refer&ecirc;ncia.</p>

        <h3>Notas Fiscais</h3>

        <?php if (empty($this->lista_notas)) { ?>

            <div class="tHeader">
                <span class="align-c vazio">&nbsp;Nenhuma nota fiscal emitida para este cliente !</span>
            </div>

        <?php } else { ?>

            <ul class="tabela">
                <div class="tHeader">
                    <li class="tRow">
                        <span class="align-l">Nome</span>
                        <span class="align-c">Emiss&atilde;o</span>
                        <span class="align-l">N&uacute;mero</span>
                        <span class="align-l">Refer&ecirc;ncia</span>
                        <span class="align-c">Valor</span>
                        <span class="align-l">&nbsp;</span>
                    </li>
                </div>
                <div class="tBody">

                    <?php
                    $total_notas = 0;
                    $valor_total = 0;

                    foreach ($this->lista_notas as $notafiscal) {

                        $total_notas ++;
                        $valor_total += $notafiscal[valor_total];
                        ?>
                        <li class="tRow">
                            <span data-th="Nome" class="align-l"><div class="lColorAcqua legenda flaticon-checkedCirc">&nbsp;<?php echo utf8_decode(utf8_encode($notafiscal[rsocial])); ?></div></span>
                            <span data-th="Emiss&atilde;o" class="align-c"><?php echo $funcoes->dataToNF($notafiscal[emissao]); ?></span>
                            <span data-th="N&uacute;mero" class="align-l"><?php echo $notafiscal[numero]; ?></span>
                            <span data-th="Refer&ecirc;ncia" class="align-l"><?php echo utf8_decode(utf8_encode($funcoes->refNF($notafiscal[ano_mes]))); ?></span>
                            <span data-th="Valor" class="align-r"><?php echo number_format(($notafiscal[valor_total] / 100), 2, ',', '.'); ?></span>
                            <span style="width:120px;" class="align-r">

                                <form id="formContrato" name="formContrato" action="notafiscal" method="post" target="_blank">

                                    <input type="hidden" class="input" value="1" readonly name="nf_idempresa" id="nf_idempresa" size="20" maxlength="11" />
                                    <input type="hidden" class="input" value="<?php echo utf8_encode($notafiscal[nome_arquivo]); ?>" readonly name="nf_arquivo" id="nf_arquivo" size="20" maxlength="15" />
                                    <input type="hidden" class="input" value="<?php echo utf8_encode($notafiscal[cnpjcpf]); ?>" readonly name="nf_cnpjcpf" id="nf_cnpjcpf" size="20" maxlength="14" />
                                    <input type="hidden" class="input" value="<?php echo utf8_encode($notafiscal[numero]); ?>" readonly name="nf_numero" id="nf_numero" size="20" maxlength="9" />

                                    <button type="submit" class="botao btnLarge" value=""><div class="flaticon-impressao align-c"><span class="print">&nbsp;Imprimir<span></div></button>
                                                    </form>

                                                </span>
                                                </li>
    <?php } ?>

                                    </div>
                                    <div class="tHeader">
                                        <li class="tRow">
                                            <span class="align-l">Notas Fiscais: <strong><?php echo ($total_notas < 10) ? '0' . $total_notas : $total_notas; ?></strong></span>
                                            <span class="align-l">&nbsp;</span>
                                            <span class="align-l">&nbsp;</span>
                                            <span class="align-l">&nbsp;</span>
                                            <span class="align-r">&nbsp;<?php echo number_format(($valor_total / 100), 2, ',', '.'); ?></span>
                                            <span class="align-l">&nbsp;</span>
                                        </li>
                                    </div>
                                    </ul>

                                    <p><strong>Aviso Legal</strong><br />Esse extrato &eacute; para consulta particular do cliente e a utiliza&ccedil;&atilde;o do mesmo para qualquer outra finalidade ser&aacute; de responsabilidade exclusiva do cliente.</p>
                                    <p>Caso voc&ecirc; verifique a utiliza&ccedil;&atilde;o indevida de sua senha, providencie a altera&ccedil;&atilde;o imediata ou entre em contato com o Provedor de Acesso.</p>

<?php } ?>

                                <div class="clear"></div>
                            </div><div class="clear"></div>
                        </section><!-- /FIM - SECAO: NOTA FISCAL -->