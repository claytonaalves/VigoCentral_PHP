<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>
<!-- SECAO: HOME -->
<section class="home">			
    <div class="container">
        <h1>Ol&aacute; <strong><?php $nome = explode(' ', utf8_decode(utf8_encode($this->nome)));
echo $nome[0]; ?></strong>, TUDO BEM ?</h1>
        <p><?php if (utf8_encode($this->sexo) == 'M') {
    echo 'Bem vindo';
} else {
    echo 'Bem vinda';
} ?> ao seu ambiente virtual !<br />Aqui voc&ecirc; pode acompanhar e gerenciar suas faturas, notas fiscais, servi&ccedil;os contratados, entre outros !</p>

        <ul class="icons">

            <li><a href="dados" title="Meus Dados"><span class="flaticon-dados"></span><div>Dados</div></a></li>

            <?php if ($_SESSION['CENTRAL_MOD_FATURAS'] == 'S'): ?>
                <li><a href="faturas" title="Minhas Faturas"><span class="flaticon-faturas"></span><div>Faturas</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_NFS'] == 'S'): ?>
                <li><a href="notasfiscais" title="Notas Fiscais"><span class="flaticon-nfiscal"></span><div>Notas Fiscais</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_SERVICOS'] == 'S'): ?>
                <li><a href="servicos" title="Meus Servi&ccedil;os"><span class="flaticon-servicos"></span><div>Servi&ccedil;os</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_ACESSOS'] == 'S'): ?>
                <li><a href="acessos" title="Meus Acessos"><span class="flaticon-acessos"></span><div>Acessos</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_GRAFICOS'] == 'S'): ?>
                <li><a href="graficos" title="Gr&aacute;ficos de Consumo"><span class="flaticon-graficos"></span><div>Gr&aacute;ficos</div></a></li>
            <?php endif; ?>

            <?php if ($_SESSION['CENTRAL_MOD_CONTRATOS'] == 'S'): ?>
                <li><a href="contratos" title="Meus Contratos"><span class="flaticon-contrato"></span><div>Contratos</div></a></li>
<?php endif; ?>

<?php if ($_SESSION['CENTRAL_MOD_ATENDIMENTOS'] == 'S'): ?>
                <li><a href="suporte" title="Meus Atendimentos"><span class="flaticon-suporte"></span><div>Atendimentos</div></a></li>
<?php endif; ?>

        </ul>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: HOME -->