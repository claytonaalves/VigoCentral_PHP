<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();

function esquerda($entra, $comp) {
    return substr($entra, 0, $comp);
}

function direita($entra, $comp) {
    return substr($entra, strlen($entra) - $comp, $comp);
}

function montacodigodebarras($valor) {
    $lw = 1;
    $hi = 50;

    $tabcodbarra[0] = "00110";
    $tabcodbarra[1] = "10001";
    $tabcodbarra[2] = "01001";
    $tabcodbarra[3] = "11000";
    $tabcodbarra[4] = "00101";
    $tabcodbarra[5] = "10100";
    $tabcodbarra[6] = "01100";
    $tabcodbarra[7] = "00011";
    $tabcodbarra[8] = "10010";
    $tabcodbarra[9] = "01010";

    for ($f1 = 9; $f1 >= 0; $f1--) {
        for ($f2 = 9; $f2 >= 0; $f2--) {
            $f = ($f1 * 10) + $f2;
            $texto = "";
            for ($i = 1; $i < 6; $i++) {
                $texto .= substr($tabcodbarra[$f1], ($i - 1), 1) . substr($tabcodbarra[$f2], ($i - 1), 1);
            }
            $tabcodbarra[$f] = $texto;
        }
    }

    $img = ImageCreate(405, 60);
    $preto = ImageColorAllocate($img, 0, 0, 0);
    $branco = ImageColorAllocate($img, 255, 255, 255);

    ImageFilledRectangle($img, 0, 0, 405, 60, $branco);
    ImageFilledRectangle($img, 0, 0, 0, 60, $preto);
    ImageFilledRectangle($img, 1, 0, 1, 60, $branco);
    ImageFilledRectangle($img, 2, 0, 2, 60, $preto);
    ImageFilledRectangle($img, 3, 0, 3, 60, $branco);

    $fino = 1;
    $largo = 3;
    $pos = 4;
    $texto = $valor;

    if ((strlen($texto) % 2) <> 0)
        $texto = "0" . $texto;

    while (strlen($texto) > 0) {
        $i = round(esquerda($texto, 2));
        $texto = direita($texto, strlen($texto) - 2);

        $f = $tabcodbarra[$i];

        for ($i = 1; $i < 11; $i += 2) {
            if (substr($f, ($i - 1), 1) == "0")
                $f1 = $fino;
            else
                $f1 = $largo;

            ImageFilledRectangle($img, $pos, 0, $pos + $f1, 60, $preto);
            $pos = $pos + $f1;

            if (substr($f, $i, 1) == "0")
                $f2 = $fino;
            else
                $f2 = $largo;

            ImageFilledRectangle($img, $pos, 0, $pos + $f2, 60, $branco);
            $pos = $pos + $f2;
        }
    }

    ImageFilledRectangle($img, $pos, 0, $pos - 1 + $largo, 60, $preto);
    $pos = $pos + $largo;
    ImageFilledRectangle($img, $pos, 0, $pos - 1 + $fino, 60, $branco);
    $pos = $pos + $fino;
    ImageFilledRectangle($img, $pos, 0, $pos - 1 + $fino, 60, $preto);
    $pos = $pos + $fino;

    //header("Content-Type: image/png");
    ImagePNG($img);
}

function montalinhadigitavel($valor) {
    $largura = ImageFontWidth(2) * strlen($valor);
    $altura = ImageFontHeight(2);

    $img = @ImageCreate($largura, $altura);
    $cor_fundo = ImageColorAllocate($img, 255, 255, 255);
    $cor_texto = imageColorAllocate($img, 0, 0, 0);

    //header("Content-Type: image/png");
    imagestring($img, 2, 0, 0, $valor, $cor_texto);
    imagepng($img);
}
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        <link rel='shortcut icon' href='<?php echo $funcoes->baseProjeto(); ?>/public/images/favicon.ico'/>
        <link rel="stylesheet" href="<?php echo $funcoes->baseProjeto(); ?>/public/css/boleto.css" type="text/css" />
        <title>BOLETO - <?php echo $this->empresa->fantasia; ?></title>
    </head>
    <body>
    <center>
        <table class="instrucoes" border="0" style="height:50px;">
            <tr>
                <td valign="center" style="height:20px;">
                    <div align="center">
                        <strong style="font-size:9pt;">Instru&ccedil;&otilde;es de Impress&atilde;o</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">
                    <div class="trace" align="center">
                        Imprimir em impressora jato de tinta (ink jet) ou laser em qualidade normal. (N&atilde;o use modo econ&ocirc;mico).<br />
                        Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) - Corte na linha indicada<br />
                    </div>
                </td>
            </tr>

        </table>

        <table class="instrucoes" border="0" style="height:90px;">
            <tr>
                <td style="width:100px;text-align:center;">
                    <img class="logo" width="200" height="90" src="data:image/jpeg;base64,<?php echo base64_encode($this->empresa->foto); ?>" />
                </td>
                <td style="padding-left:20px;text-align:left;vertical-align:middle;">
                    <strong><?php echo utf8_decode($this->empresa->fantasia); ?></strong><br />
                    CNPJ: <?php echo $this->empresa->cnpj; ?><br />
                    <?php echo utf8_decode($this->empresa->cidade); ?> - <?php echo $this->empresa->uf; ?>
                </td>
            </tr>
        </table>

        <table>
            <tbody>
                <tr>
                    <td id='logo'><img src='<?php echo $funcoes->baseProjeto(); ?>/public/images/banco-<?php echo substr($this->bloqueto_final->numerobanco, 0, 3); ?>.bmp'></td>
                    <td colspan='5' id='Titulo'>RECIBO DO SACADO</td>
                </tr>
                <tr>
                    <td colspan='5' class='Texto1'>Benefici&aacute;rio<br /><b><?php echo $this->bloqueto_final->cedente; ?></b></td>
                    <td class='DirEsp'>Vencimento<br /><span style='float:right;margin-right:5px;'><b><?php echo $this->bloqueto_final->vencimento; ?></b><span></td>
                                </tr>
                                <tr>
                                    <td class='esp'>Data<br /><span style='float:left;margin-right:5px;'><?php echo $this->bloqueto_final->vencimento; ?></span></td>
                                    <td>Documento</td>
                                    <td>Esp&eacute;cie<br />DS</td>
                                    <td>Aceite<br />N</td>
                                    <td>Dt.Processamento<br /><?php echo $funcoes->dataToBR($this->bloqueto_final->emissao); ?></td>
                                    <td class="Dir">Nosso N&uacute;mero<br /><span style='float:right;margin-right:5px;'><?php echo $this->bloqueto_final->nossonumero; ?><span></td>
                                                </tr>
                                                <tr>
                                                    <td class="esp">Conta</td>
                                                    <td>Carteira<br /><?php echo $this->bloqueto_final->carteira; ?></td>
                                                    <td>Esp&eacute;cie<br />Real</td>
                                                    <td>Quantidade<br /></td>
                                                    <td>Valor</td>
                                                    <td class='DirEsp'>(=) Valor do documento<br /><span style='float:right;margin-right:5px;'><?php echo number_format($this->bloqueto_final->valor_original, 2, ',', '.'); ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td rowspan='5' colspan='5' class='Instru'><b>INSTRU&Ccedil;&Otilde;ES DE RESPONSABILIDADE DO BENEFICI&Aacute;RIO:<br /></b>*** VALORES EM REAIS ***<br /><br /><pre><?php echo $this->bloqueto_final->obs; ?></pre></td>
					<td class='Dir'>(-) Desconto<br /><span style='float:right;margin-right:5px;'>0,00</span></td>
				</tr>
                <tr>
					<td class='Dir'>(-) Outras dedu&ccedil;&otilde;es<br /><span style='float:right;margin-right:5px;'>0,00</span></td>
				</tr>
                <tr>
					<td class='Dir'>(+) Mora / Multa / Juros<br /><span style='float:right;margin-right:5px;'><b><?php echo number_format($this->bloqueto_final->adicional, 2, ',', '.'); ?></b></span></td>
				</tr>
                <tr>
					<td class='Dir'>(+) Outros acr&eacute;scimos<br /><span style='float:right;margin-right:5px;'>0,00</span></td>
				</tr>
                <tr>
					<td class='Dir'>(=) Valor cobrado<br /><span style='float:right;margin-right:5px;'><b><?php echo number_format($this->bloqueto_final->valor, 2, ',', '.'); ?></b></span></td>
				</tr>
                <tr>
					<td colspan='6' class='Rodape'>Pagador:<br /><?php echo $this->bloqueto_final->nome; ?><br /><?php echo $this->bloqueto_final->endereco; ?><br /><?php echo $this->bloqueto_final->cep; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->bloqueto_final->cidade; ?> - <?php echo $this->bloqueto_final->uf; ?></td>
				</tr>
            </tbody>
        </table>
		
		<div id='Auten'>Autentica&ccedil;&atilde;o Mec&acirc;nica&nbsp;&nbsp;&nbsp;&nbsp;</div>
		
        <table>
            <tbody>
                <tr>
					<td><img src='<?php echo $funcoes->baseProjeto(); ?>/public/images/banco-<?php echo substr($this->bloqueto_final->numerobanco, 0, 3); ?>.bmp'></td>
					<td id='Num'><?php echo $this->bloqueto_final->numerobanco; ?></td>
					<td colspan='4' id='Numero'>
                                                                <?php
                                                                // Renderizar a linha digitável de forma que fique oculto no HTML

                                                                ob_start();
                                                                montalinhadigitavel($this->bloqueto_final->linhadigitavel);
                                                                $imagedata = ob_get_contents();
                                                                ob_end_clean();

                                                                echo '<img src="data:image/png;base64,' . base64_encode($imagedata) . '" />';

                                                                //echo $this->bloqueto_final->linhadigitavel; 
                                                                ?>
					</td>
				</tr>
                <tr>
					<td colspan='5' class='Texto1'>Local de Pagamento<br /><b><?php echo $this->bloqueto_final->localpagamento; ?></b></td>
					<td class='DirEsp'>Vencimento<br /><span style='float:right;margin-right:5px;'><b><?php echo $this->bloqueto_final->vencimento; ?></b></span></td>
				</tr>
                <tr>
					<td colspan='5' class='Texto1'>Benefici&aacute;rio<br /><b><?php echo $this->bloqueto_final->cedente; ?></b></td>
					<td class='Dir'>Ag&ecirc;ncia / C&oacute;digo<br /><span style='float:right;margin-right:5px;'><?php echo $this->bloqueto_final->agencia . " / " . $this->bloqueto_final->conta; ?></span></td>
				</tr>
                <tr>
					<td class="esp">Data<br /><?php echo $this->bloqueto_final->vencimento; ?></td>
					<td>Documento</td>
					<td>Esp&eacute;cie<br />DS</td>
					<td>Aceite<br />N</td><td>Dt.Processamento<br /><?php echo $funcoes->dataToBR($this->bloqueto_final->emissao); ?></td>
					<td class='Dir'>Nosso N&uacute;mero<br /><span style='float:right;margin-right:5px;'><?php echo $this->bloqueto_final->nossonumero; ?></span></td>
				</tr>
                <tr>
					<td class="esp">Conta</td>
					<td>Carteira<br /><?php echo $this->bloqueto_final->carteira; ?></td>
					<td>Esp&eacute;cie<br />Real</td>
					<td>Quantidade<br /></td>
					<td>Valor</td>
					<td class='DirEsp'>(=) Valor do documento<br />&nbsp;&nbsp;<span style='float:right;margin-right:5px;'><?php echo number_format($this->bloqueto_final->valor_original, 2, ',', '.'); ?></span></td>
				</tr>
                <tr>
					<td rowspan='5' colspan='5' class='Instru'><b>INSTRU&Ccedil;&Otilde;ES DE RESPONSABILIDADE DO BENEFICI&Aacute;RIO:</b><br />*** VALORES EM REAIS ***<br /><br /><pre><?php echo $this->bloqueto_final->obs; ?></pre></td>
					<td class='Dir'>(-) Desconto<br />&nbsp;&nbsp;<span style='float:right;margin-right:5px;'>0,00</span></td>
				</tr>
                <tr>
					<td class='Dir'>(-) Outras dedu&ccedil;&otilde;es<br />&nbsp;&nbsp;<span style='float:right;margin-right:5px;'>0,00</span></td>
				</tr>
                <tr>
					<td class='Dir'>(+) Mora / Multa / Juros<br />&nbsp;&nbsp;<span style='float:right;margin-right:5px;'><b><?php echo number_format($this->bloqueto_final->adicional, 2, ',', '.'); ?></b></span></td>
				</tr>
                <tr>
					<td class='Dir'>(+) Outros acr&eacute;scimos<br />&nbsp;&nbsp;<span style='float:right;margin-right:5px;'>0,00</span></td>
				</tr>
                <tr>
					<td class='Dir'>(=) Valor cobrado<br />&nbsp;&nbsp;<span style='float:right;margin-right:5px;'><b><?php echo number_format($this->bloqueto_final->valor, 2, ',', '.'); ?></b></span></td>
				</tr>
                <tr>
					<td colspan='6' class='Rodape'>Pagador:<br /><?php echo $this->bloqueto_final->nome; ?><br /><?php echo $this->bloqueto_final->endereco; ?><br /><?php echo $this->bloqueto_final->cep; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->bloqueto_final->cidade; ?> - <?php echo $this->bloqueto_final->uf; ?></td>
				</tr>
            </tbody>
        </table>
        <div class='cbarra'>
                                                    <?php
                                                    // Renderizar o código de barras de forma que fique oculto no HTML

                                                    ob_start();
                                                    montacodigodebarras($this->bloqueto_final->codigobarras);
                                                    $imagedata = ob_get_contents();
                                                    ob_end_clean();

                                                    echo '<img src="data:image/png;base64,' . base64_encode($imagedata) . '"/>';
                                                    ?>
        </div>
		</center>
    </body>
</html>