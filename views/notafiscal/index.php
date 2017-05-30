<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>
<?php define('BASE', '/central'); ?>
<title>NOTA FISCAL <?php echo $this->mestre->numero; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>/public/css/notafiscal.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE; ?>/public/css/nf_print.css" media="print" />

<!-- SECAO: NOTA FISCAL -->
<section>			

    <table border="0" style="width:100%;height:100%;margin:0 auto;" cellpadding="0" cellspacing="0">
        <tr style="height:150px;">
            <td>
                <table class="tabEmpresa" border="0" style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:100px;text-align:center;">
                            <img class="logo" width="200" height="90" src="data:image/jpeg;base64,<?php echo base64_encode($this->empresa->foto); ?>" />
                        </td>
                        <td style="text-align:center;">
                            <span><?php echo utf8_decode($this->empresa->fantasia); ?></span><br />
                            <span><?php echo utf8_decode($this->empresa->endereco); ?></span><br />
                            <span><?php echo utf8_decode($this->empresa->cidade); ?> - <?php echo $this->empresa->uf; ?></span>
                            <span class="mrgExtra">CEP: <?php echo $this->empresa->cep; ?></span><br />
                            <span>Insc. no CNPJ: <?php echo $this->empresa->cnpj; ?></span><br />
                            <span>Insc. Estadual: <?php echo $this->empresa->ie; ?></span>
                            <span class="mrgExtra">Insc. Municipal: <?php echo $this->empresa->im; ?></span>
                        </td>
                        <td class="txtSizeExtraFull" style="width:190px;text-align:center;">
                            <span>N&Uacute;MERO <strong><?php echo $this->mestre->numero . substr($this->mestre->ano_mes, 2,2) . substr($this->mestre->ano_mes, 0,2); ?></strong></span><br />
                            <span><strong>S&eacute;rie <?php echo $this->mestre->serie; ?></strong></span><br />
                            <span><strong>Via &Uacute;NICA</strong></span>
                        </td>
                    </tr>

                    <tr class="lineExtra">
                        <td style="text-align:center;">
                            <span>Telefone: <?php echo $this->empresa->telefone; ?></span><br />
                            <span><?php echo $this->empresa->site; ?></span>
                        </td>
                        <td style="text-align:center;">
                            <h1>NOTA FISCAL DE <?php echo $this->mestre->tipo; ?><br />
                                MODELO <?php echo $this->mestre->modelo; ?></h1>
                        </td>
                        <td style="width:190px;text-align:center;">
                            <span class="txtSizeExtra">Data de Emiss&atilde;o: <strong><?php echo $funcoes->dataToNF($this->mestre->emissao); ?></strong></span><br />
                            <span class="txtSizeExtra">Refer&ecirc;ncia: <strong><?php echo $funcoes->referenciaNF($this->mestre->ano_mes); ?></strong></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="height:90px;">
            <td>
                <table border="0" style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width:100px;text-align:left;">
                            <img src="barcode/<?php echo $this->mestre->ano_mes . $this->mestre->numero; ?>" style="margin-right:15px;" />
                        </td>
                        <td class="txtSizeNormal">
                            <span class="txtSizeMin">Dados do Cliente:</span><br />
                            <strong><?php echo $this->cadastro->razao_social; ?></strong><br />
                            <span><?php echo $this->cadastro->endereco; ?></span> - 
                            <span><?php echo $this->cadastro->bairro; ?></span><br />
                            <span>CEP: <?php echo $this->cadastro->cep; ?></span>
                            <span class="mrgExtra"><?php echo $this->cadastro->cidade; ?></span> - 
                            <span><?php echo $this->cadastro->estado; ?></span><br />
                        </td>
                        <td class="txtSizeNormal">
                            <span><?php echo $this->cadastro->cnpj_cpf; ?></span><br />
                            <span><?php echo $this->cadastro->ie_rg; ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="height:5px;">
                <hr>
            </td>
        </tr>

        <tr>
            <td style="vertical-align:top;height:380px;">
                <table class="txtSizeNormal" border="0" style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0">
                    <tr style="height:30px;">
                        <th style="text-align:left;">Descri&ccedil;&atilde;o dos Servi&ccedil;os</th>
                        <th style="width:60px;text-align:center;">Qtde.</th>
                        <th style="width:60px;text-align:center;">CFOP</th>
                        <th style="width:100px;text-align:right;">Unit&aacute;rio</th>
                        <th style="width:100px;text-align:right;">Valor</th>
                    </tr>

                    <?php foreach ($this->nota_fiscal_itens as $nota_fiscal_itens): ?>

                        <tr>
                            <td style="text-align:left;"><?php echo utf8_decode(utf8_encode($nota_fiscal_itens[desc_servico])); ?></td>
                            <td style="width:60px;text-align:center;"><?php echo $funcoes->numero($nota_fiscal_itens[quant_contratada]); ?></td>
                            <td style="width:60px;text-align:center;"><?php echo utf8_decode(utf8_encode($nota_fiscal_itens[cfop])); ?></td>
                            <td style="width:100px;text-align:right;"><?php echo $funcoes->valor($nota_fiscal_itens[total]); ?></td>
                            <td style="width:100px;text-align:right;"><?php echo $funcoes->valor($nota_fiscal_itens[total]); ?></td>
                        </tr>

                    <?php endforeach; ?>

                </table>
            </td>
        </tr>
        <tr style="height:150px;">
            <td>
                <table class="txtSizeNormal" border="0" style="width:100%;margin:0 auto;" cellpadding="0" cellspacing="0">

                    <?php if ($this->config->nf_ibpt != '0,00'): ?>
                        <tr style="height:35px;">
                            <td class="negrito" style="vertical-align:top;text-align:center;">
                                <span>Valor Aproximado do Tributo Federal R$ </span>
                                <span><?php echo $funcoes->calcIBPT($this->mestre->valor_total, $this->config->nf_ibpt); ?> </span>
                                <span>(<?php echo $this->config->nf_ibpt; ?>%)&nbsp;</span>
                                <span>e Municipal R$ </span>
                                <span><?php echo $funcoes->calcIBPT($this->mestre->valor_total, $this->config->nf_ibpt_municipal); ?> </span>
                                <span>(<?php echo $this->config->nf_ibpt_municipal; ?>%) - Fonte: IBPT - Chave ca7gi3</span>


                                <!--Valor aproximado do Tributo Federal R$ ... (13,45%) e Municipal R$ ... (2,00%) - FONTE IBPT - Chave ca7gi3 -->
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($this->config->nf_boleto == 'S'): ?>
                        <tr style="height:40px;">
                            <td class="negrito" style="vertical-align:top;text-align:left;">
                                <span>NOTA FISCAL REFERENTE AO BOLETO BANC&Aacute;RIO N&Uacute;MERO: <?php echo $this->mestre->boleto_numero; ?></span><br />
                                <span>REFER&Ecirc;NCIA DO BOLETO: <?php echo $this->config->nf_ref_boleto; ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td>
                            <table class="txtSizeNormal" border="0" style="border:1px solid #000;width:100%;margin:0 auto;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:25%;text-align:left;padding:5px;border-right:1px solid #000;">
                                        <span style="text-align:left;">Base de C&aacute;lculo</span>
                                    </td>
                                    <td style="width:25%;text-align:left;padding:5px;border-right:1px solid #000;">
                                        <span>Al&iacute;quota (%)</span>
                                    </td>
                                    <td style="width:25%;text-align:left;padding:5px;border-right:1px solid #000;">
                                        <span>ICMS</span>
                                    </td>
                                    <td style="width:25%;text-align:left;padding:5px;">
                                        <span>VALOR TOTAL</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:25%;text-align:right;padding:5px;border-right:1px solid #000;">
                                        <strong class="txtSizeExtraGG" style="text-align:right;"><?php echo $funcoes->valor($this->mestre->base_calculo); ?></strong>
                                    </td>
                                    <td style="width:25%;text-align:right;padding:5px;border-right:1px solid #000;">
                                        <strong class="txtSizeExtraGG" style="text-align:right;"><?php echo $this->config->nf_aliquota; ?></strong>
                                    </td>
                                    <td style="width:25%;text-align:right;padding:5px;border-right:1px solid #000;">
                                        <strong class="txtSizeExtraGG" style="text-align:right;"><?php echo $funcoes->valor($this->mestre->valor_icms); ?></strong>
                                    </td>
                                    <td style="width:25%;text-align:right;padding:5px;">
                                        <strong class="txtSizeExtraGG" style="text-align:right;"><?php echo $funcoes->valor($this->mestre->valor_total); ?></strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <?php if ($this->config->nf_optante == 'S'): ?>
                        <tr style="height:60px;">
                            <td class="negrito" style="text-align:center;">
                                <span>EMPRESA OPTANTE DO SIMPLES NACIONAL CONFORME LEI COMPLEMENTAR 123/2006<br />
                                    N&Atilde;O GERA DIREITO A CR&Eacute;DITO DE ICMS</span>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr style="height:50px;">
                            <td style="text-align:left;">&nbsp;</td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td>
                            <table class="txtSizeNormal" border="0" style="border:1px solid #000;width:100%;margin:0 auto;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:100%;text-align:center;padding:5px;">
                                        <span>RESERVADO AO FISCO</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:25%;text-align:center;padding:5px;">
                                        <strong class="txtSizeExtraGG"><?php echo $funcoes->chave($this->mestre->reservado_fisco); ?></strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <?php if ($this->config->nf_fust == 'S'): ?>
                        <tr style="height:35px;">
                            <td class="txtSizeNormal" style="text-align:center;">
                                <span>Contribui&ccedil;&otilde;es para FUST (1%) e FUNTTEL (0,5%) sobre o valor dos servi&ccedil;os n&atilde;o repassados &agrave;s tarifas.</span>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($this->config->nf_regime != ''): ?>
                        <tr style="height:30px;">
                            <td class="txtSizeNormal negrito" style="text-align:center;">
                                <span><?php echo $this->config->nf_regime; ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($this->config->nf_mensagem != ''): ?>
                        <tr style="height:35px;">
                            <td class="txtSizeNormal" style="text-align:center;">
                                <span><?php echo $this->config->nf_mensagem; ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>

                </table>
            </td>
        </tr>
    </table>

    <?php if ($this->mestre->situacao == 'S'): ?>
        <div class="cancelada">CANCELADA</div>
    <?php endif; ?>

</section>
<!-- /FIM - SECAO: NOTA FISCAL -->