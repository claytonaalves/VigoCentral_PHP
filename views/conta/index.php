<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>
<!-- SECAO: MINHA CONTA -->
<section class="home">			
    <div class="container">
        <h1>Minha Conta</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target">MINHA CONTA</li>
        </ul>

        <ul class="icons">

            <li><a href="dados" title="Meus Dados"><span class="flaticon-dados"></span><div>Dados</div></a></li>

            <?php if ($_SESSION['CENTRAL_MOD_SENHA'] == 'S'): ?>
                <li><a href="senha" title="Alterar Senha da Central"><span class="flaticon-senha"></span><div>Alterar Senha</div></a></li>
            <?php endif; ?>

        </ul>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: MINHA CONTA -->