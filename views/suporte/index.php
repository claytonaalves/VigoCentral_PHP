<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>

<?php
@session_start();

if (isset($_SESSION['ALERTA_MENSAGEM']) AND ( $_SESSION['ALERTA_MENSAGEM'] != NULL)) {
    echo "<div class='messageBox' id='messageBox'><span class='close' onclick=\"javascript:document.getElementById('messageBox').className='fecharMessage';\">&nbsp;</span><div class='" . $_SESSION['ALERTA_TIPO'] . "'><p><strong>" . $_SESSION['ALERTA_TITULO'] . "...</strong><br />" . $_SESSION['ALERTA_MENSAGEM'] . "</p></div></div>";
}

$_SESSION['ALERTA_TIPO'] = NULL;
$_SESSION['ALERTA_TITULO'] = NULL;
$_SESSION['ALERTA_MENSAGEM'] = NULL;

unset($_SESSION['ALERTA_TIPO']);
unset($_SESSION['ALERTA_TITULO']);
unset($_SESSION['ALERTA_MENSAGEM']);
?>
<div style="display:none;" class="messageBox" id="messageBox"></div>

<!-- SECAO: ATENDIMENTOS -->
<section class="dados">

    <div class="container">
        <h1>Meus Atendimentos</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="conectividade">CONECTIVIDADE</a></li>
            <li class="target">MEUS ATENDIMENTOS</li>
        </ul>

        <p>O quadro abaixo segue um padr&atilde;o l&oacute;gico de demonstra&ccedil;&atilde;o dos &uacute;ltimos 12 (doze) chamados de atendimento para sua conta e permite um controle de f&aacute;cil visualiza&ccedil;&atilde;o por situa&ccedil;&atilde;o.</p>

<?php if ($_SESSION['CENTRAL_MOD_ABRIR_ATENDIMENTO'] == 'S'): ?>
            <!-- ABRIR ATENDIMENTO -->
            <a style="position:relative;" class="botao btnTicket btnTicketExtra" id="abrirChamado" href="#abrirAtendimento">Abrir Novo Atendimento</a>
<?php endif; ?>

        <!-- BOX: DETALHES DO ACESSO -->   
        <div style="display:none;" class="boxExtrato" id="abrirAtendimento">

            <span class="close" title="Fechar">&nbsp;</span>

            <div class="info" id="boxAtendimento">

                <h2 class="align-c">Abrir Novo Atendimento...</h2>

                <!-- FORMULARIO -->
                <div class="formAtendimento">

                    <form name="formAtendimento" action="chamado" method="post">

                        <label id="lblAssunto" for="txtAssunto">
                            <span>Assunto:</span>
                            <input type="text" required="required" name="txtAssunto" id="txtAssunto" class="txtAssunto" maxlength="30" autofocus />
                        </label>

                        <label for="txtTipo" class="optTipo">
                            <span>Tipo:</span>
                            <select name="txtTipo" id="txtTipo" required="required">

                                <option value="" selected="selected" disabled="disabled">Selecione&nbsp;&nbsp;</option>
                                <option value="" disabled="disabled">&nbsp;</option>

<?php foreach ($this->lista_tipos_atendimentos as $tipos_atendimentos) { ?>
                                    <option value="<?php echo $tipos_atendimentos[id]; ?> - <?php echo $tipos_atendimentos[descricao]; ?>"><?php echo $tipos_atendimentos[descricao]; ?></option>
                                <?php } ?>

                            </select>
                        </label>

                        <label id="lblMensagem" for="txtMensagem" class="lblMensagem">
                            <span>Mensagem:</span>
                            <textarea class="input textarea" name="txtMensagem" id="txtMensagem" cols="40" rows="5" required="required" onKeyUp="blocTexto(this.value, this.id, <?php echo $limiteTextArea; ?>, contaLimite.id)"></textarea>
                            <div class="barStatus">
                                <div id="statusLimite" class="span">Caracteres restantes:&nbsp;</div><div name="contaLimite" id="contaLimite" class="span"><?php echo $limiteTextArea; ?></div>
                            </div>
                        </label>

                        <input class="botao btnExtra" type="submit" value="Enviar" />

                    </form>

                </div><!-- /FIM - FORMULARIO -->

            </div>

        </div><!-- /FIM - BOX: DETALHES DO ACESSO -->
        <!-- /FIM - ABRIR ATENDIMENTO -->

        <h3>Lista de Atendimentos</h3>

<?php if (empty($this->lista_atendimentos)) { ?>

            <div class="tHeader">
                <span class="align-c vazio">&nbsp;No momento n&atilde;o h&aacute; nenhum chamado de atendimento !</span>
            </div>

<?php } else { ?>

            <ul class="tabela">
                <div class="tHeader">
                    <li class="tRow">
                        <span class="align-l">N&uacute;mero</span>
                        <span class="align-c">Data / Hora</span>
                        <span class="align-l">Tipo</span>
                        <span class="align-l">Assunto</span>
                        <span class="align-l">Situa&ccedil;&atilde;o</span>
                        <span class="align-l">&nbsp;</span>
                        <span class="align-c">&Aacute;udios</span>
                    </li>
                </div>
                <div class="tBody">

    <?php
    $total_chamados = 0;

    $id_sub = 0;

    foreach ($this->lista_atendimentos as $atendimento) {

        $total_chamados ++;
        $id_sub ++;

        if ($atendimento[situacao] == 'FECHADO') {
            $txtAtendimentos = 'tRow';
            $legAtendimentos = 'lColorDark';
        } else {
            $txtAtendimentos = 'tRow tBoletoAberto';
            $legAtendimentos = 'lColorRed';
        }
        ?>
                        <li class="<?php echo $txtAtendimentos; ?>">
                            <span data-th="N&uacute;mero" class="align-l"><?php echo $atendimento[numero_os]; ?></span>
                            <span data-th="Data" class="align-c"><?php echo $funcoes->dataToBR($atendimento[dt_abertura]) . " - " . $atendimento[h_abertura]; ?></span>
                            <span data-th="Tipo" class="align-l maiusculo"><?php echo $atendimento[desc_tatendimento]; ?></span>
                            <span data-th="Assunto" class="align-l maiusculo"><?php echo $atendimento[descricao]; ?></span>
                            <span data-th="Situa&ccedil;&atilde;o" class="align-l maiusculo"><?php echo $atendimento[situacao]; ?></span>

                            <span style="width:100px;position:relative;" class="align-r">
                                <a class="botao btnDefault" id="<?php echo $atendimento['id'] ?>" href="#box<?php echo $atendimento['id'] ?>"><div class="flaticon-busca align-l"><span class="print">&nbsp;Visualizar</span></div></a>
                            </span>

                            <span style="width:95px;position:relative;" class="align-c">
                                <a class="botao2 btnDefault" id="<?php echo $atendimento['id'] ?>" href="#anexo<?php echo $atendimento['id'] ?>"><div class="flaticon-pasta align-r"><span class="print">&nbsp;Anexos</span></div></a>
                            </span>

                            <!-- BOX: DETALHES DO ATENDIMENTO -->   
                            <div style="display:none;" class="boxExtrato" id="box<?php echo $atendimento['id']; ?>">
                                <span class="close" title="Fechar">&nbsp;</span>
                                <div class="info" id="info<?php echo $atendimento['id']; ?>">
                                    <h2 class="align-c">Detalhes do Atendimento</h2>
                                    <p  id="leitor<?php echo $atendimento['id']; ?>" class="boxLeitor">
                                        <span>N&uacute;mero O.S.: <strong><?php echo $atendimento[numero_os]; ?></strong><br /></span>
                                        <span>Assunto: <strong><?php echo $atendimento[descricao]; ?></strong><br /><br /></span>
        <?php echo nl2br($atendimento[historico]); ?>
                                    </p>
                                </div>
                            </div>
                            <!-- /FIM - BOX: DETALHES DO ATENDIMENTO -->

                            <!-- BOX: ANEXOS -->   
                            <div style="display:none;" class="boxExtrato" id="anexo<?php echo $atendimento['id']; ?>">
                                <span class="close" title="Fechar">&nbsp;</span>
                                <div class="info" id="info2<?php echo $atendimento['id']; ?>" style="overflow-y:scroll;">
                                    <h2 class="align-c">Anexos do Atendimento</h2>
        <?php
        echo "<table style=\"border:1px solid #333;width:100%;font-family:Arial;font-weight:normal;color:black;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
        echo "<tr style=\"height:30px;background:#ccc;\">";
        echo "<th style=\"text-align:center;\">ID</th>";
        echo "<th style=\"text-align:center;\">MimeType</th>";
        echo "<th style=\"text-align:center;\">Tipo</th>";
        echo "<th>Descri&ccedil;&atilde;o</th>";
        echo "<th style=\"width:140px;\"></th>";
        echo "</tr>";

        foreach ($this->lista_anexos as $anexo_item) {

            if ($anexo_item[id_atendimento] == $atendimento['id']) {

                echo "<tr style=\"height:30px;\">";
                echo "<td style=\"border-top:1px solid #333;padding:5px;text-align:center;\">{$anexo_item[id]}</td>";
                echo "<td style=\"border-top:1px solid #333;padding:5px;text-align:center;\">{$anexo_item[tipo]}</td>";
                echo "<td style=\"border-top:1px solid #333;padding:5px;text-align:center;\">{$anexo_item[extensao]}</td>";
                echo "<td style=\"border-top:1px solid #333;padding:5px;\">{$anexo_item[descricao]}</td>";
                echo "<td style=\"border-top:1px solid #333;padding:5px;text-align:right;\"><a href=\"download?id={$anexo_item[id]}\" class=\"botao btnDefault2\"><div class=\"flaticon-pasta align-r\"><span class=\"print\">&nbsp;Fazer Download</span></div></a></td>";
                echo "</tr>";
            }
        }

        echo "</table><br>";
        ?>
                                </div>
                            </div>
                            <!-- /FIM - BOX: ANEXOS -->
                        </li>

    <?php } ?>

                </div>
            </ul>

                <?php } ?>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: ATENDIMENTOS -->