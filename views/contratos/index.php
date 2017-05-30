<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>

<!-- SECAO: CONTRATOS -->
<section class="dados">			
    <div class="container">
        <h1>Meus Contratos</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="financeiro">FINANCEIRO</a></li>
            <li class="target">MEUS CONTRATOS</li>
        </ul>

        <p>O quadro abaixo exibe o contrato atual vigente.</p>

        <h3>Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;o</h3>


        <!-- CONTRATO PADRÃO -->
        <?php if ($_SESSION['CENTRAL_TIPO_CONTRATO'] == 'default'): ?>
            <ul class="tabela">

                <div class="tHeader">
                    <li class="tRow">
                        <span class="align-l">Descri&ccedil;&atilde;o</span>
                        <span class="align-l">&nbsp;</span>
                    </li>
                </div>

                <div class="tBody">
                    <li class="tRow">
                        <span data-th="Descri&ccedil;&atilde;o" class="align-l maiusculo"><div class="lColorAcqua legenda flaticon-checkedCirc">&nbsp;CONTRATO PADR&Atilde;O DE PRESTA&Ccedil;&Atilde;O DE SERVI&Ccedil;O</div></span>
                        <span style="width:100px;" class="align-r">
                            <form id="formContrato" name="formContrato" action="contrato" method="post" target="_blank">
                                <input type="hidden" class="input" value="0" readonly name="id_contrato" id="id_contrato" size="20" maxlength="30" />
                                <button type="submit" class="botao btnLarge" value=""><div class="flaticon-busca align-c"><span class="print">&nbsp;Visualizar<span></div></button>
                                                </form>
                                            </span>
                                            </li>
                                    </div>

                                    </ul>
                                <?php endif; ?>
                                <!-- /FIM - CONTRATO PADRÃO -->

                                <!-- CONTRATO PERSONALIZADO -->
                                <?php if ($_SESSION['CENTRAL_TIPO_CONTRATO'] == 'custom'): ?>

                                    <?php if (empty($this->lista_contratos)) { ?>

                                        <div class="tHeader">
                                            <span class="align-c vazio">&nbsp;Nenhum contrato emitido para este cliente !</span>
                                        </div>

                                    <?php } elseif ((isset($this->lista_contratos)) AND ( !empty($this->lista_contratos))) { ?>

                                        <ul class="tabela">

                                            <div class="tHeader">
                                                <li class="tRow">
                                                    <span class="align-l">Descri&ccedil;&atilde;o</span>
                                                    <span class="align-l">&nbsp;</span>
                                                </li>
                                            </div>

                                            <div class="tBody">
                                                <?php
                                                $total_contratos = 0;
                                                foreach ($this->lista_contratos as $contratos) {
                                                    ?>
                                                    <li class="tRow">
                                                        <span data-th="Descri&ccedil;&atilde;o" class="align-l maiusculo"><div class="lColorAcqua legenda flaticon-checkedCirc">&nbsp;<?php echo utf8_encode($contratos[descricao]); ?></div></span>
                                                        <span style="width:100px;" class="align-r">
                                                            <form id="formContrato" name="formContrato" action="contrato" method="post" target="_blank">
                                                                <input type="hidden" class="input" value="<?php echo utf8_encode($contratos[id]); ?>" readonly name="id_contrato" id="id_contrato" size="20" maxlength="30" />
                                                                <button type="submit" class="botao btnLarge" value=""><div class="flaticon-busca align-c"><span class="print">&nbsp;Visualizar<span></div></button>
                                                                                </form>
                                                                            </span>
                                                                            </li>
                                                                            <?php
                                                                            $total_contratos ++;
                                                                        }
                                                                        ?>
                                                                </div>
                                                                <!--
                                                                <div class="tFooter">
                                                                        <li class="tRow">
                                                                                <span class="align-l">Total: <strong><?php echo ($total_contratos < 10) ? '0' . $total_contratos : $total_contratos; ?></strong></span>
                                                                                <span class="align-l">&nbsp;</span>
                                                                        </li>
                                                                </div>
                                                                -->

                                                                </ul>

                                                            <?php } ?>

                                                        <?php endif; ?>
                                                        <!-- /FIM - CONTRATO PERSONALIZADO -->

                                                        <div class="clear"></div>
                                                    </div><div class="clear"></div>
                                                </section><!-- /FIM - SECAO: CONTRATOS -->