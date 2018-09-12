<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>

<!-- SECAO: MEUS SERVICOS -->
<section class="dados">			
    <div class="container">
        <h1>Meus Servi&ccedil;os</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="financeiro">FINANCEIRO</a></li>
            <li class="target">MEUS SERVI&Ccedil;OS</li>
        </ul>

        <p>O quadro abaixo segue um padr&atilde;o l&oacute;gico de demonstra&ccedil;&atilde;o dos servi&ccedil;os contratados e seus respectivos valores.</p>

        <h3>Servi&ccedil;os Contratados</h3>

        <?php if (empty($this->lista_servicos)) { ?>

            <div class="tHeader">
                <span class="align-c vazio">&nbsp;Nenhum servi&ccedil;o contratado !</span>
            </div>

        <?php } else { ?>

            <ul class="tabela">
                <div class="tHeader">
                    <li class="tRow">
                        <span class="align-l">Descri&ccedil;&atilde;o</span>
                        <span class="align-r mobile">Valor</span>
                        <span class="align-r noVisible">&nbsp;</span>
                    </li>
                </div>
                <div class="tBody">
                    <?php
                    $total_servicos = 0;
                    $valor_total = 0;

                    foreach ($this->lista_servicos as $servicos) {

                        $total_servicos ++;
                        $valor_total += $servicos[valor];
                        ?>
                        <li class="tRow">
                            <span data-th="Descri&ccedil;&atilde;o" class="align-l maiusculo"><div class="lColorAcqua legenda flaticon-checkedCirc">&nbsp;<?php echo utf8_decode(utf8_encode($servicos[descricao])); ?></div></span>
                            <span data-th="Valor" class="align-r mobile"><?php echo number_format($servicos[valor], 2, ',', '.'); ?></span>
                            <span class="align-r noVisible">&nbsp;</span>
                        </li>
    <?php } ?>
                </div>
                <div class="tHeader">
                    <li class="tRow">
                        <span class="align-l">Total: <strong><?php echo ($total_servicos < 10) ? '0' . $total_servicos : $total_servicos; ?></strong></span>
                        <span class="align-r mobile"><strong><?php echo number_format($valor_total, 2, ',', '.'); ?></strong></span>
                        <span class="align-r noVisible">&nbsp;</span>
                    </li>
                </div>
            </ul>

<?php } ?>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: MEUS SERVICOS -->