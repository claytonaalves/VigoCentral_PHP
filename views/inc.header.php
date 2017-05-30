<header class="tema">
    <!-- TÍTULO PINCIPAL -->
    <h1 class="float-l"><?php $fantasia = explode(' ', utf8_decode(utf8_encode($_SESSION['FANTASIA'])));
echo $fantasia[0]; ?></h1>
    <!-- CONTROLE MENU RESPONSIVO -->
    <input type="checkbox" id="control-nav" />
    <label for="control-nav" class="control-nav tooltips"><span id="tooltip">Menu</span></label>
    <label for="control-nav" class="control-nav-close"></label>
    <!-- MENU -->
    <nav class="float-r">
        <ul class="list-auto">
            <li><a href="core" title="Home">Home</a></li>
            <li><a href="conta" title="Minha Conta">Minha Conta</a></li>
            <li><a href="financeiro" title="Financeiro">Financeiro</a></li>
            <li><a href="conectividade" title="Conectividade">Conectividade</a></li>
            <li><a href="logout" title="Sair">Sair</a></li>
        </ul>
    </nav>
</header><!-- /FIM - HEADER DA PAGINA -->