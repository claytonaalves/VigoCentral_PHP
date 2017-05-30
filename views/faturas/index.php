<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>

<!-- SECAO: MINHAS FATURAS -->
<section class="dados">			
    <div class="container">
        <h1>Minhas Faturas</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="financeiro">FINANCEIRO</a></li>
            <li class="target">MINHAS FATURAS</li>
        </ul>

        <p>O quadro abaixo segue um padr&atilde;o l&oacute;gico de demonstra&ccedil;&atilde;o dos &uacute;ltimos 12 (doze) boletos emitidos para sua conta e permite um controle de f&aacute;cil visualiza&ccedil;&atilde;o das cobran&ccedil;as por data.</p>
        <p>Possui uma legenda colorida para ajudar a compreender a sua situa&ccedil;&atilde;o atual. Uma forma inteligente de administrar a sua conta.</p>

        <div class="lColorDark legenda flaticon-legenda">&nbsp;Boletos pagos</div><div class="separador">&nbsp;</div><div class="lColorRed legenda flaticon-legenda">&nbsp;Boletos em aberto</div>

        <h3>Boletos Banc&aacute;rios</h3>

        <?php if (empty($this->lista_boletos)) { ?>

            <div class="tHeader">
                <span class="align-c vazio">&nbsp;Nenhum boleto bancário emitido para este cliente !</span>
            </div>

        <?php } else { ?>

            <ul class="tabela">
                <div class="tHeader">
                    <li class="tRow">
                        <span class="align-l">Nosso N&uacute;mero</span>
                        <span class="align-l">Refer&ecirc;ncia</span>
                        <span class="align-c">Vencimento</span>
                        <span class="align-r">Valor</span>
                        <span class="align-c">Pagamento</span>
                        <span class="align-r">V.Pago</span>
                        <span class="align-r">&nbsp;</span>
                    </li>
                </div>
                <div class="tBody">

                    <?php
                    $total_boletos = 0;
                    $valor_total = 0;
                    $total_pago = 0;

                    foreach ($this->lista_boletos as $boletos) {

                        $total_boletos ++;
                        $valor_total += $boletos[valor];
                        $total_pago += $boletos[pago_valor];

                        $data_pgto = $funcoes->dataToBR($boletos[pago_data]);
                        if ($data_pgto == '01/01/0001')
                            $data_pgto = '';

                        $valor_pago = number_format($boletos[pago_valor], 2, ',', '.');
                        //if($valor_pago == "0,00") $valor_pago = '';
                        if ($valor_pago <= 0)
                            $valor_pago = '';

                        if ($boletos[pago_valor] <= 0) {
                            $txtBoletos = 'tRow tBoletoAberto';
                            $legBoletos = 'lColorRed';
                            $btnBoletos = '<a class="botao btnDefault" href="segvia/' . $boletos[id] . '" target="_blank"><div class="flaticon-impressao align-r"><span class="print"> Imprimir<span></div></a>';
                        } else {
                            $txtBoletos = 'tRow';
                            $legBoletos = 'lColorDark';
                            $btnBoletos = '&nbsp;';
                        }
                        ?>
                        <li class="<?php echo $txtBoletos; ?>">
                            <span data-th="Nosso N&uacute;mero" class="align-l"><div class="<?php echo $legBoletos; ?> legenda flaticon-legenda">&nbsp;<?php echo utf8_encode($boletos[nossonumero]); ?></div></span>
                            <span data-th="Refer&ecirc;ncia" class="align-l maiusculo"><?php echo utf8_decode(utf8_encode($boletos[referencia])); ?></span>
                            <span data-th="Vencimento" class="align-c"><?php echo $funcoes->dataToBR($boletos[vencimento]); ?></span>
                            <span data-th="Valor" class="align-r"><?php echo number_format($boletos[valor], 2, ',', '.'); ?></span>
                            <span data-th="Pagamento" class="align-c"><?php echo $data_pgto; ?></span>
                            <span data-th="Valor Pago" class="align-r"><?php echo $valor_pago; ?></span>
                            <span class="align-r"><?php echo $btnBoletos; ?></span>
                        </li>
                    <?php } ?>

                </div>

                <div class="tFooter">
                    <li class="tRow">
                        <span class="align-l">Boletos: <strong><?php echo ($total_boletos < 10) ? '0' . $total_boletos : $total_boletos;
                ; ?></strong></span>
                        <span class="align-l">&nbsp;</span>
                        <span class="align-l">&nbsp;</span>
                        <span class="align-r">&nbsp;<?php echo number_format($valor_total, 2, ',', '.'); ?></span>
                        <span class="align-l">&nbsp;</span>
                        <span class="align-r">&nbsp;<?php echo number_format($total_pago, 2, ',', '.'); ?></span>
                        <span class="align-l">&nbsp;</span>
                    </li>
                </div>

            </ul>

<?php } ?>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: MINHAS FATURAS -->