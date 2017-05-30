<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>
<!-- SECAO: CONECTIVIDADE -->
<section class="home">			
    <div class="container">
        <h1>Conectividade</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target">CONECTIVIDADE</li>
        </ul>

        <ul class="icons">

            <?php if ($_SESSION['CENTRAL_MOD_ACESSOS'] == 'S'): ?>
                <li><a href="acessos" title="Meus Acessos"><span class="flaticon-acessos"></span><div>Acessos</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_GRAFICOS'] == 'S'): ?>
                <li><a href="graficos" title="Gr&aacute;ficos de Consumo"><span class="flaticon-graficos"></span><div>Gr&aacute;ficos</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_ATENDIMENTOS'] == 'S'): ?>
                <li><a href="suporte" title="Meus Atendimentos"><span class="flaticon-suporte"></span><div>Atendimentos</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_MKSENHA'] == 'S'): ?>
                <li><a href="mksenha" title="Alterar Senha de Conex&atilde;o"><span class="flaticon-mikrotik"></span><div>Alterar Senha</div></a></li>
            <?php endif; ?>
        </ul>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: CONECTIVIDADE -->