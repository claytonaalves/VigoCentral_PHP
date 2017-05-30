<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>
<!-- SECAO: FINANCEIRO -->
<section class="home">			
    <div class="container">
        <h1>Financeiro</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target">FINANCEIRO</li>
        </ul>

        <ul class="icons">

            <?php if ($_SESSION['CENTRAL_MOD_FATURAS'] == 'S'): ?>
                <li><a href="faturas" title="Minhas Faturas"><span class="flaticon-faturas"></span><div>Faturas</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_NFS'] == 'S'): ?>
                <li><a href="notasfiscais" title="Notas Fiscais"><span class="flaticon-nfiscal"></span><div>Notas Fiscais</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_SERVICOS'] == 'S'): ?>
                <li><a href="servicos" title="Meus Servi&ccedil;os"><span class="flaticon-servicos"></span><div>Servi&ccedil;os</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_CONTRATOS'] == 'S'): ?>
                <li><a href="contratos" title="Meus Contratos"><span class="flaticon-contrato"></span><div>Contratos</div></a></li>
            <?php endif; ?>

        </ul>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: FINANCEIRO -->