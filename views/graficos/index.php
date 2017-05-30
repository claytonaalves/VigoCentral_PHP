<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
@session_start();
?>

<!-- SECAO: ACESSOS -->
<section class="dados">
    <div class="container">
        <h1>Gr&aacute;fico De Consumo</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="conectividade">CONECTIVIDADE</a></li>
            <li class="target">GR&Aacute;FICO DE CONSUMO</li>
        </ul>

        <p><strong>Aviso Legal</strong><br />Esse extrato &eacute; para consulta particular do cliente e a utiliza&ccedil;&atilde;o do mesmo para qualquer outra finalidade ser&aacute; de responsabilidade exclusiva do cliente.</p>

        <?php if (!empty($this->lista_mklogins)) { ?>
            <!-- FORMULARIO -->
            <div class="formFiltro" style="margin:0;padding:0;">
                <form class="f_filtro" name="formFiltro" action="" method="post">

                    <input type="hidden" name="acao" value="listar"/>

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

                    <button class="botao btnExtra" type="submit" value="" /><div class="flaticon-busca align-c"><span class="print">&nbsp;Pesquisar<span></div></button>

                                </form>

                                </div><!-- /FIM - FORMULARIO -->

                                <h3>Gr&aacute;fico do extrato de horas</h3>

                                <!-- LISTA DE ACESSOS -->
                                <?php if ((isset($this->lista_acessos)) AND ( !empty($this->lista_acessos))) { ?>

                                    <!-- LISTA DE DADOS DO GRAFICO -->
                                    <?php
                                    @session_start();
                                    // Cria a lista de dados para o grafico

                                    $total1 = 0;

                                    foreach ($this->lista_acessos as $acessos) {

                                        if ($acessos['AcctOutputOctets'] > $total1)
                                            $total1 = $acessos['AcctOutputOctets'];

                                        $listaJSON .= "{ Tempo: '" . $funcoes->tempoConexao($acessos[AcctStartTime], $acessos[AcctStopTime]) . "', Upload:'" . $funcoes->bandaToGB($acessos['AcctInputOctets']) . "', Download:'" . $funcoes->bandaToGB($acessos['AcctOutputOctets']) . "'},";
                                        $listaJSON = substr_replace($listaJSON, ",\n", -1, 1);
                                        $linha++;
                                    }

                                    $dados = substr_replace($listaJSON, "", -1, 1);

                                    // Captura o login e plano do cliente
                                    foreach ($this->lista_plano as $plano)
                                        ;
                                    ?>
                                    <!-- /FIM - LISTA DE DADOS DO GRAFICO -->

        <?php ?>

                                    <link rel="stylesheet" href="public/js/jqwidgets/styles/jqx.base.css" type="text/css" />
                                    <script type="text/javascript" src="public/js/jquery.js"></script>
                                    <script type="text/javascript" src="public/js/jqwidgets/jqxcore.js"></script>
                                    <script type="text/javascript" src="public/js/jqwidgets/jqxchart.core.js"></script>
                                    <script type="text/javascript" src="public/js/jqwidgets/jqxdraw.js"></script>
                                    <script type="text/javascript" src="public/js/jqwidgets/jqxdata.js"></script>
                                    <script type="text/javascript">
                                                $(document).ready(function () {

                                                    // Prepara os dados do grafico
                                                    var sampleData = [<?php echo $dados; ?>];

                                                    // Prepara as configuracoes do grafico
                                                    var settings = {
                                                        title: "<?php echo utf8_decode('Total de Tráfego'); ?> - <?php echo utf8_decode(utf8_encode($plano[username])); ?>",
                                                                    description: "<?php echo utf8_decode('Período'); ?>: <?php echo $_SESSION['DT_INICIO']; ?> - <?php echo $_SESSION['DT_FINAL']; ?>",
                                                                                padding: {left: 5, top: 5, right: 20, bottom: 5},
                                                                                titlePadding: {left: 10, top: 0, right: 0, bottom: 10},
                                                                                source: sampleData,
                                                                                xAxis:
                                                                                        {
                                                                                            dataField: 'Tempo',
                                                                                            labels: {
                                                                                                //angle: -90,
                                                                                                visible: false
                                                                                            },
                                                                                            description: '<?php echo utf8_decode('Conexões'); ?>',
                                                                                            tickMarks: {visible: true},
                                                                                            gridLines: {visible: false}
                                                                                        },
                                                                                colorScheme: 'scheme05',
                                                                                seriesGroups:
                                                                                        [
                                                                                            {
                                                                                                /*

                                                                                                 ### Tipo de gráficos ###

                                                                                                 INGLES   : column, line, stackedline, spline, stackedspline, area, stackedarea
                                                                                                 PORTUGUES: coluna, linha, linha empilhados, linha curva, linha curva empilhadas, área, área empilhada

                                                                                                 */
                                                                                                type: '<?php echo $_SESSION['CENTRAL_GRAFICO']; ?>', // LEGAIS: column, line, spline e area
                                                                                                columnsGapPercent: 30,
                                                                                                seriesGapPercent: 0,
                                                                                                valueAxis:
                                                                                                        {
                                                                                                            minValue: 0,
                                                                                                            maxValue: <?php echo round($total1 / 1024 / 1024 / 1024, 3); ?>,
                                                                                                            labels: {
                                                                                                                formatSettings: {
                                                                                                                    decimalPlaces: 3,
                                                                                                                    sufix: ' GB'
                                                                                                                }
                                                                                                            },
                                                                                                            unitInterval: 1,
                                                                                                            description: 'Gigabytes'
                                                                                                        },
                                                                                                series: [
                                                                                                    {dataField: 'Download', displayText: 'Download', opacity: 1},
                                                                                                    {dataField: 'Upload', displayText: 'Upload', opacity: 1}
                                                                                                ]
                                                                                            }
                                                                                        ]
                                                                            };

                                                                            // Seleciona o elemento DIV 'chartContainer' onde sera renderizado o grafico.
                                                                            $('#chartContainer').jqxChart(settings);
                                                                        });
                                    </script>
                                    <div class='default'>
                                        <div id='chartContainer' style="width:100%;height:500px">
                                        </div>
                                    </div>

                                    <?php
                                    $_SESSION['MK_LOGIN'] = NULL;
                                    $_SESSION['DT_INICIO'] = NULL;
                                    $_SESSION['DT_FINAL'] = NULL;

                                    unset($_SESSION['MK_LOGIN']);
                                    unset($_SESSION['DT_INICIO']);
                                    unset($_SESSION['DT_FINAL']);
                                    ?>
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
                                    <span class="align-c">&nbsp;Nenhum login de conectividade atribuido a este cliente !</span>
                                </div>

<?php } ?><!-- /FIM - MENSAGEM: SEM LOGIN DE CONECTIVIDADE -->

                            <div class="clear"></div>
                        </div><div class="clear"></div>
                    </section><!-- /FIM - SECAO: ACESSOS -->
					