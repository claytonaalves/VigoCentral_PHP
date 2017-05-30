<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
@session_start();
?>

<!-- SECAO: ACESSOS -->
<section class="dados">			
    <div class="container">
        <h1>Meus Acessos</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="conectividade">CONECTIVIDADE</a></li>
            <li class="target">MEUS ACESSOS</li>
        </ul>

        <p><strong>Aviso Legal</strong><br />Esse extrato &eacute; para consulta particular do cliente e a utiliza&ccedil;&atilde;o do mesmo para qualquer outra finalidade ser&aacute; de responsabilidade exclusiva do cliente.</p>

        <?php if (!empty($this->lista_mklogins)) { ?>
            <!-- FORMULARIO -->
            <div class="formFiltro">
                <form class="f_filtro" name="formFiltro" action="" method="post">

                    <input type="hidden" name="acao" value="listar" />

                    <label>
                        <span>Login de acesso</span>
                        <select name="txtLogin" id="login">
                            <?php foreach ($this->lista_mklogins as $mklogins) { ?>
                                <option value="<?php echo utf8_decode(utf8_encode($mklogins[UserName])); ?>" <?php if (utf8_decode(utf8_encode($mklogins[UserName])) == $_SESSION['MK_LOGIN']) {
                            echo 'selected';
                        } else {
                            echo '';
                        } ?> ><?php echo utf8_decode(utf8_encode($mklogins[UserName])); ?></option>
    <?php } ?>
                        </select>		
                    </label>

                    <label class="lblSpace">
                        <span>Inicio</span>
                        <input type="date" name="txtInicio" value="<?php echo $funcoes->dataToUS($_SESSION['DT_INICIO']); ?>" min="2000-01-01" />
                    </label>

                    <label>
                        <span>Fim</span>
                        <input type="date" name="txtFinal" value="<?php echo $funcoes->dataToUS($_SESSION['DT_FINAL']); ?>" max="<?php echo $this->dataAtual; ?>" />
                    </label>

                    <label class="optFiltro">
                        <span>Filtro R&aacute;pido</span>
                        <label class="txtLabel" for="dias07" style="cursor:pointer;">
                            <input onclick="javascript:formFiltro.txtInicio.value = '<?php echo $funcoes->dataToUS($this->dataInicio07); ?>';
                                                                    javascript:formFiltro.txtFinal.value = '<?php echo $this->dataAtual; ?>';" type="radio" id="dias07" name="dias" value="0" <?php if ($funcoes->dataToUS($this->dataInicio07) == $funcoes->dataToUS($_SESSION['DT_INICIO'])) {
        echo 'checked';
    } ?> />
                            <span>7 dias</span>
                        </label>

                        <label class="txtLabel" for="dias15" style="cursor:pointer;">
                            <input onclick="javascript:formFiltro.txtInicio.value = '<?php echo $funcoes->dataToUS($this->dataInicio15); ?>';
                                                                    javascript:formFiltro.txtFinal.value = '<?php echo $this->dataAtual; ?>';" type="radio" id="dias15" name="dias" value="0" <?php if ($funcoes->dataToUS($this->dataInicio15) == $funcoes->dataToUS($_SESSION['DT_INICIO'])) {
                            echo 'checked';
                        } ?> />
                            <span>15 dias</span>
                        </label>

                        <label class="txtLabel" for="dias30" style="cursor:pointer;">
                            <input onclick="javascript:formFiltro.txtInicio.value = '<?php echo $funcoes->dataToUS($this->dataInicio30); ?>';
                                                                    javascript:formFiltro.txtFinal.value = '<?php echo $this->dataAtual; ?>';" type="radio" id="dias30" name="dias" value="0" <?php if ($funcoes->dataToUS($this->dataInicio30) == $funcoes->dataToUS($_SESSION['DT_INICIO'])) {
                            echo 'checked';
                        } ?> />
                            <span>30 dias</span>
                        </label>
                    </label>

                    <button class="botao btnExtra align-c" type="submit" value="" /><div class="flaticon-busca align-c"><span class="print">&nbsp;Pesquisar<span></div></button>

                                </form>

                                </div><!-- /FIM - FORMULARIO -->

                                <!-- LISTA DE PLANOS -->
    <?php if (isset($this->lista_plano) and ! empty($this->lista_plano)) { ?>

                                    <ul class="tabela">

                                        <div class="tHeader">
                                            <li class="tRow">
                                                <span class="align-l" style="width:50%;">Usu&aacute;rio</span>
                                                <span class="align-l" style="width:50%;">Plano</span>
                                            </li>
                                        </div>

                                        <div class="tBody">
                                    <?php foreach ($this->lista_plano as $plano) { ?>
                                                <li class="tRow trClear">
                                                    <span data-th="Usu&aacute;rio" class="align-l"><?php echo utf8_decode(utf8_encode($plano[username])); ?></span>
                                                    <span data-th="Plano" class="align-l"><?php echo utf8_encode($plano[groupname]); ?></span>
                                                </li>
                                    <?php } ?>
                                        </div>

                                    </ul>

    <?php } ?><!-- /FIM - LISTA DE PLANOS -->

                                <h3>Extrato de horas</h3>

                                <!-- LISTA DE ACESSOS -->
    <?php if ((isset($this->lista_acessos)) AND ( !empty($this->lista_acessos))) { ?>

                                    <ul class="tabela">

                                        <div class="tHeader">
                                            <li class="tRow">
                                                <span class="align-l">In&iacute;cio</span>
                                                <span class="align-l">Final</span>
                                                <span class="align-r">Upload</span>
                                                <span class="align-r">Download</span>
                                                <span class="align-l">&nbsp;</span>
                                            </li>
                                        </div>

                                        <div class="tBody">

                                                    <?php 
													$total1=0;
													$total2=0;
													
													foreach ($this->lista_acessos as $acessos) { 
													
													$total1 = $total1 + $acessos['AcctInputOctets'];
													$total2 = $total2 + $acessos['AcctOutputOctets'];
													
													?>

                                                <li class="tRow">

                                                    <span data-th="In&iacute;cio" class="align-l">
            <?php echo @date("d/m/Y - H:i:s", @strtotime($acessos[AcctStartTime])); ?>
                                                    </span>
                                                    <span data-th="Final" class="align-l">
            <?php echo @date("d/m/Y - H:i:s", @strtotime($acessos[AcctStopTime])); ?>
                                                    </span>
                                                    <span data-th="Upload" class="align-r">
            <?php echo $funcoes->bandaToMB($acessos['AcctInputOctets']); ?>
                                                    </span>
                                                    <span data-th="Download" class="align-r">
            <?php echo $funcoes->bandaToMB($acessos['AcctOutputOctets']); ?>
                                                    </span>

                                                    <span style="width:110px;position:relative;" class="align-r">
                                                        <a class="botao btnDefault" id="<?php echo $acessos['RadAcctId'] ?>" href="#box<?php echo $acessos['RadAcctId'] ?>"><div class="flaticon-busca align-c"><span class="print">&nbsp;Visualizar<span></div></a>

                                                                        <!-- BOX: DETALHES DO ACESSO -->   
                                                                        <div style="display:none;" class="boxExtrato" id="box<?php echo $acessos['RadAcctId']; ?>">

                                                                            <span class="close" title="Fechar">&nbsp;</span>

                                                                            <div class="info" id="info<?php echo $acessos['RadAcctId']; ?>">
                                                                                <h2 class="align-c">Detalhes do Acesso...</h2>

                                                                                <p class="align-l">
                                                                                <fieldset class="fieldsetLeft">

                                                                                    <legend>Conex&atilde;o:</legend>

                                                                                    <span>In&iacute;cio: <strong class="infoData"><?php echo @date("d/m/Y - H:i:s", @strtotime($acessos[AcctStartTime])); ?></strong></span>
                                                                                    <span>T&eacute;rmino: <strong class="infoData"><?php echo @date("d/m/Y - H:i:s", @strtotime($acessos[AcctStopTime])); ?></strong></span>
                                                                                    <span>Dura&ccedil;&atilde;o: <strong class="infoData"><?php echo $funcoes->tempoConexao($acessos[AcctStartTime], $acessos[AcctStopTime]); ?></strong></span>

                                                                                </fieldset>

                                                                                <fieldset class="fieldsetRight">

                                                                                    <legend>Endere&ccedil;o:</legend>

                                                                                    <span>IP: <strong class="infoData"><?php echo $acessos[FramedIPAddress]; ?></strong></span>
                                                                                    <span>MAC: <strong class="infoData"><?php echo $acessos[CallingStationId]; ?></strong></span>
                                                                                    <span class="fieldset">Motivo da desconex&atilde;o:</span>
                                                                                    <span><strong class="infoData"><?php echo $funcoes->motivoDesconexao($acessos[AcctTerminateCause]); ?></strong></span>

                                                                                </fieldset>
                                                                                </p>

                                                                            </div>

                                                                        </div><!-- /FIM - BOX: DETALHES DO ACESSO -->

                                                                    </span>

                                                                    </li>

                                                        <?php } ?>

                                                        </div>
                <div class="tFooter">
                    <li class="tRow">
                        <span class="align-l">&nbsp;</span>
                        <span class="align-l">&nbsp;</span>
                        <span class="align-r"><?php echo $funcoes->bandaToMB($total1); ?></span>
                        <span class="align-r"><?php echo $funcoes->bandaToMB($total2); ?></span>
                        <span class="align-l">&nbsp;</span>
                    </li>
                </div>

        <?php
        $_SESSION['MK_LOGIN'] = NULL;
        $_SESSION['DT_INICIO'] = NULL;
        $_SESSION['DT_FINAL'] = NULL;

        unset($_SESSION['MK_LOGIN']);
        unset($_SESSION['DT_INICIO']);
        unset($_SESSION['DT_FINAL']);
        ?>

                                                        </ul>
                                                        <!-- /FIM - LISTA DE ACESSOS -->

                                                        <!-- MENSAGEM: SEM CONEXAO NO PERIODO -->
                                                    <?php } else { ?>

                                                        <div class="tHeader vazio">
                                                            <span class="align-c">&nbsp;Nenhuma conex&atilde;o para este per&iacute;odo !</span>
                                                        </div>

                                                    <?php } ?><!-- /FIM - MENSAGEM: SEM CONEXAO NO PERIODO -->


                                                    <!-- MENSAGEM: SEM LOGIN DE CONECTIVIDADE -->
<?php } else { ?>

                                                    <div class="tHeader vazio">
                                                        <span class="align-c">&nbsp;Nenhum login de conectividade para este cliente !</span>
                                                    </div>

<?php } ?><!-- /FIM - MENSAGEM: SEM LOGIN DE CONECTIVIDADE -->

                                                <div class="clear"></div>
                                            </div><div class="clear"></div>
                                        </section><!-- /FIM - SECAO: ACESSOS -->