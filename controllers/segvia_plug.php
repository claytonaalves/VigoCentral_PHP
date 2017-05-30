<?php

///////////////////////////////////////////////////////////////////////////////////////
// Funções para cálculo da segunda-via com vencimento e valor re-calculados          //
//                                                                                   //
// NÃO ALTERAR NADA DESTE PONTO PARA BAIXO, A NÃO SER QUE SAIBA O QUE ESTÁ FAZENDO ! //
///////////////////////////////////////////////////////////////////////////////////////
//
function NovoVencimento($hoje = NULL) {
    if (!is_null($hoje))
        $d = getdate($hoje);
    else
        $d = getdate();

    $vencimento = mktime(0, 0, 0, $d['mon'], $d['mday'], $d['year']);

    while (!EhDiaUtil($vencimento))
        $vencimento += 86400;

    return date('d/m/Y', $vencimento);
}

function getHolidays($year = null) {
    if ($year === null)
        $year = intval(date('Y'));

    $easterDate = easter_date($year);
    $easterDay = date('j', $easterDate);
    $easterMonth = date('n', $easterDate);
    $easterYear = date('Y', $easterDate);

    $holidays = array(
        mktime(0, 0, 0, 1, 1, $year), // Ano novo
        mktime(0, 0, 0, 4, 21, $year), // Tiradentes
        mktime(0, 0, 0, 5, 1, $year), // Dia do trabalho
        mktime(0, 0, 0, 9, 7, $year), // Independencia
        mktime(0, 0, 0, 10, 12, $year), // Nossa Senhora (dia das criancas)
        mktime(0, 0, 0, 11, 2, $year), // Finados
        mktime(0, 0, 0, 11, 15, $year), // Proclamacao da Republica
        mktime(0, 0, 0, 12, 25, $year), // Natal
        mktime(0, 0, 0, $easterMonth, $easterDay - 47, $easterYear), // Carnaval
        mktime(0, 0, 0, $easterMonth, $easterDay - 2, $easterYear), // Paixao de Cristo
        mktime(0, 0, 0, $easterMonth, $easterDay + 60, $easterYear) // Corpus Christi
    );

    sort($holidays);

    return $holidays;
}

function EhDiaUtil($dt) {
    $feriados = getHolidays();
    $aux = getdate($dt);

    if (($aux['wday'] == 0) or ( $aux['wday'] == 6))
        return FALSE;

    if (in_array($dt, $feriados))
        return FALSE;

    return TRUE;
}

function DiasEmAtraso($vencimento, $hoje = NULL) {
    if (!is_null($hoje))
        $d = getdate($hoje);
    else
        $d = getdate();

    $hoje = mktime(0, 0, 0, $d['mon'], $d['mday'], $d['year']);

    $vencimento = strtotime($vencimento);
    if ($vencimento > $hoje)
        return 0;

    $atraso = round(($hoje - $vencimento) / 86400);

    if (!EhDiaUtil($vencimento)) {
        $proximo_dia_util = ProximoDiaUtil($vencimento);
        $diff = ($hoje - $proximo_dia_util) / 86400;
        return $diff;
    }

    return $atraso;
}

function ProximoDiaUtil($param) {
    while (!EhDiaUtil($param))
        $param += 86400;
    return $param;
}

function NovosDadosBoleto($params) {
    switch ($params['numbanco']) {
        case '341':
            $boleto = new BoletoItau($params);
            break;
        case '104':
            $boleto = new BoletoCaixa($params);
            break;
        case '001':
            $boleto = new BoletoBancodoBrasil($params);
            break;
        case '004':
            $boleto = new BoletoBancodoNordeste($params);
            break;
        case '033':
            $boleto = new BoletoSantander($params);
            break;
        case '237':
            $boleto = new BoletoBradesco($params);
            break;
        case '748':
            $boleto = new BoletoBansicredi($params);
            break;
        case '756':
            $boleto = new BoletoSicoob($params);
            break;
        case '356':
            $boleto = new BoletoBancoReal($params);
            break;
        case '399':
            $boleto = new BoletoBancoHSBC($params);
            break;
        default:
            return NULL;
    }

    $novos_dados = array('codigobarras' => $boleto->codigo_barras, 'linhadigitavel' => $boleto->linha_digitavel);

    return $novos_dados;
}

class Boleto {

    public $moeda = '9';

    function __construct($entrada) {
        $this->carteira = '';
        $this->agencia = substr($entrada['agencia'], 0, 4);
        $this->valor = str_pad(str_replace('.', '', trim($entrada['valor'])), 10, '0', STR_PAD_LEFT);

        if (is_null($entrada['vencimento']))
            $this->vencimento = NovoVencimento();
        else
            $this->vencimento = $entrada['vencimento'];

        $this->fator_vcto = $this->fator_vencimento($this->vencimento);
    }

    function mod10($num) {
        $numtotal10 = 0;
        $fator = 2;

        for ($i = strlen($num); $i > 0; $i--) {
            $numeros[$i] = substr($num, $i - 1, 1);
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;

            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0+=$v;
            }

            $parcial10[$i] = $temp0;
            $numtotal10 += $parcial10[$i];

            if ($fator == 2)
                $fator = 1;
            else
                $fator = 2;
        }

        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;

        if ($resto == 0)
            $digito = 0;

        return $digito;
    }

    function mod11($num, $base = 9, $r = 0) {
        $soma = 0;
        $fator = 2;

        for ($i = strlen($num); $i > 0; $i--) {
            $numeros[$i] = substr($num, $i - 1, 1);
            $parcial[$i] = $numeros[$i] * $fator;
            $soma += $parcial[$i];

            if ($fator == $base)
                $fator = 1;

            $fator++;
        }

        if ($r == 0) {
            $soma *= 10;
            $digito = $soma % 11;

            if ($digito == 10)
                $digito = 0;

            return $digito;
        }
        elseif ($r == 1) {
            $resto = $soma % 11;
            return $resto;
        }
    }

    function fator_vencimento($data) {
        $data = explode("/", $data);
        $ano = $data[2];
        $mes = $data[1];
        $dia = $data[0];

        return abs(($this->_dateToDays("1997", "10", "07")) - ($this->_dateToDays($ano, $mes, $dia)));
    }

    function _dateToDays($year, $month, $day) {
        $century = substr($year, 0, 2);
        $year = substr($year, 2, 2);

        if ($month > 2) {
            $month -= 3;
        } else {
            $month += 9;
            if ($year) {
                $year--;
            } else {
                $year = 99;
                $century --;
            }
        }

        return ( floor(( 146097 * $century) / 4) + floor(( 1461 * $year) / 4) + floor(( 153 * $month + 2) / 5) + $day + 1721119);
    }

    function prepara_conta($conta, $len = NULL) {
        $conta = str_replace('.', '', $conta);
        $conta = str_replace('-', '', $conta);
        $conta = (int) substr($conta, 0, 8);

        if (!isset($len))
            $len = 5;

        $conta = str_pad($conta, $len, '0', STR_PAD_LEFT);
        return $conta;
    }

    function digitoVerificador_barra($numero) {
        $resto2 = $this->mod11($numero, 9, 1);
        $digito = 11 - $resto2;

        if ($digito == 0 || $digito == 1 || $digito == 10 || $digito == 11) {
            $dv = 1;
        } else {
            $dv = $digito;
        }

        return $dv;
    }

    function geraLinhaDigitavel() {
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;

        $campo_livre = substr($this->codigo_barras, 19, 25);
        $dv1 = $this->mod10($banco . $moeda . substr($campo_livre, 0, 5));
        $resnnum = substr($this->codigo_barras, 24, 6);
        $dac1 = substr($this->codigo_barras, 30, 1);
        $dddag = substr($this->codigo_barras, 31, 3);
        $dv2 = $this->mod10($resnnum . $dac1 . $dddag);
        $resag = substr($this->codigo_barras, 34, 1);
        $contadac = substr($this->codigo_barras, 35, 6);
        $zeros = substr($this->codigo_barras, 41, 3);
        $dv3 = $this->mod10($resag . $contadac . $zeros);
        $dv4 = substr($this->codigo_barras, 4, 1);
        $fator = substr($this->codigo_barras, 5, 4);
        $valor = substr($this->codigo_barras, 9, 10);

        $campo1 = substr($banco . $moeda . substr($campo_livre, 0, 5), 0, 5) . '.' . substr($banco . $moeda . substr($campo_livre, 0, 5), 5, 5) . $dv1;
        $campo2 = substr($resnnum . $dac1 . $dddag . $dv2, 0, 5) . '.' . substr($resnnum . $dac1 . $dddag . $dv2, 5, 6);
        $campo3 = substr($resag . $contadac . $zeros . $dv3, 0, 5) . '.' . substr($resag . $contadac . $zeros . $dv3, 5, 6);
        $campo4 = $dv4;
        $campo5 = $fator . $valor;

        $this->linha_digitavel = "$campo1  $campo2  $campo3  $campo4  $campo5";
    }

}

class BoletoItau extends Boleto {

    public $numbanco = '341';
    public $moeda = '9';
    public $carteira = '';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->conta = $this->prepara_conta($entrada['conta']);
        $this->carteira = $entrada['carteira'];
        $this->nosso_numero = substr(str_replace("/", "", $entrada['nnumero']), 0, 11);

        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $cb = $banco . $moeda . $fator . $valor . $nnum . $dac1 . $ag . $cc . $dac2 . '000';
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

}

class BoletoCaixa extends Boleto {

    public $numbanco = '104';
    public $moeda = '9';
    public $carteira = '';

    function __construct($entrada) {
        parent::__construct($entrada);

        $teste = substr($entrada['nnumero'], 0, 1);
        switch ($teste) {
            case '1': // SIGCB
                $this->nosso_numero = substr($entrada['nnumero'], 2, 15);
                $this->conta = substr($entrada['convenio'], 0, 7);
				$this->complemento = "1";
                $this->geraCodigoBarras_SIGCB();
                $this->geraLinhaDigitavel();
                break;
            case '2': // SIGCB
                $this->nosso_numero = substr($entrada['nnumero'], 2, 15);
                $this->conta = substr($entrada['convenio'], 0, 7);
				$this->complemento = "2";
                $this->geraCodigoBarras_SIGCB();
                $this->geraLinhaDigitavel();
                break;
            case '8': // SICOB
                $this->nosso_numero = substr($entrada['nnumero'], 0, 10);
                $this->conta = $this->prepara_conta($entrada['conta'], 8);
                $this->geraCodigoBarras_SICOB();
                $this->geraLinhaDigitavel_SICOB();
                break;
            case '9': // SINCO
                $this->nosso_numero = substr($entrada['nnumero'], 1, 17);
                $this->conta = $this->prepara_conta($entrada['convenio'], 6);
                $this->geraCodigoBarras_SINCO();
                $this->geraLinhaDigitavel_SICOB();
                break;
        }
    }

    function geraCodigoBarras_SINCO() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $campo_livre = '1' . $cc . '9' . $nnum;

        $cb = $banco . $moeda . $fator . $valor . $campo_livre;
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

    function prepara_conta_SIGCB($conta, $len = NULL) {
        $conta = str_replace('.', '', $conta);
        $conta = str_replace('-', '', $conta);
        $conta = (int) substr($conta, 0, 9);

        if (!isset($len))
            $len = 5;

        $conta = str_pad($conta, $len, '0', STR_PAD_LEFT);
        return $conta;
    }

    function geraCodigoBarras_SIGCB() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);
		
		if ($this->complemento=="1")
			$ad1="1";
		else
			$ad1="2";

        $campo_livre = $cc . substr($nnum, 0, 3) . $ad1 . substr($nnum, 3, 3) . '4' . substr($nnum, 6, 9);
        $clivre_dv = $this->mod11($campo_livre);

        $cb = $banco . $moeda . $fator . $valor . $campo_livre . $clivre_dv;
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

    function geraCodigoBarras_SICOB() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $cb = $banco . $moeda . $fator . $valor . $nnum . $ag . '870' . $cc;
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

    function geraLinhaDigitavel_SICOB() {
        $c1 = $this->numbanco . $this->moeda . substr($this->codigo_barras, 19, 5);
        $c2 = substr($this->codigo_barras, 24, 10);
        $c3 = substr($this->codigo_barras, 34, 10);

        $campo1 = substr($c1, 0, 5) . '.' . substr($c1, 5, 4) . $this->mod10($c1);
        $campo2 = substr($c2, 0, 5) . '.' . substr($c2, 5, 6) . $this->mod10($c2);
        $campo3 = substr($c3, 0, 5) . '.' . substr($c3, 5, 6) . $this->mod10($c3);
        $campo4 = substr($this->codigo_barras, 4, 1);
        $campo5 = substr($this->codigo_barras, 5, 4) . substr($this->codigo_barras, 9, 10);

        $this->linha_digitavel = "$campo1  $campo2  $campo3  $campo4  $campo5";
    }

}

class BoletoBancodoBrasil extends Boleto {

    public $numbanco = '001';
    public $moeda = '9';

    function __construct($entrada) {
        parent::__construct($entrada);
		
		if ($entrada['complemento'] == 0) {
			$this->carteira = '18';
		} else {
		    $this->carteira = '17'; }

        if (strlen($entrada['nnumero']) == 13) {
            $this->conta = $this->prepara_conta($entrada['conta'], 8);
            $this->nosso_numero = substr($entrada['nnumero'], 0, 11);
            $this->geraCodigoBarras();
        } elseif (strlen($entrada['nnumero']) == 19) {
            $this->conta = $this->prepara_conta($entrada['conta'], 8);
            $this->nosso_numero = substr(str_replace('-', '', $entrada['nnumero']), 0, 17);
            $this->geraCodigoBarrasConvenio7();
        }

        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $campo_livre = $nnum . $ag . $cc . $this->carteira;

        $cb = $banco . $moeda . $fator . $valor . $campo_livre;
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

    function geraCodigoBarrasConvenio7() {
        $campo_livre = '000000' . $this->nosso_numero . $this->carteira;
        $cb = $this->numbanco . $this->moeda . $this->fator_vcto . $this->valor . $campo_livre;
        $dv = $this->digitoVerificador_barra($cb);
        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

}

class BoletoBancodoNordeste extends Boleto {

    public $numbanco = '004';
    public $moeda = '9';

    function __construct($entrada) {
        parent::__construct($entrada);

        $conta = str_replace('.', '', $entrada['conta']);
        $conta = str_replace('-', '', $conta);
        $conta = (int) substr($conta, 1, 8);
        $conta = str_pad($conta, 8, '0', STR_PAD_LEFT);
        $this->conta = $conta;
        $this->nosso_numero = str_replace('-', '', $entrada['nnumero']);
		$this->carteira = $entrada['convenio'];

        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $campo_livre = $ag . $cc . $nnum . $cart . '000';

        $cb = $banco . $moeda . $fator . $valor . $campo_livre;
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

}

class BoletoBradesco extends Boleto {

    public $numbanco = '237';
    public $moeda = '9';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->conta = $this->prepara_conta($entrada['conta'], 7);
        $this->nosso_numero = substr(str_replace("/", "", $entrada['nnumero']), 0, 11);
        $this->carteira = substr($entrada['convenio'], 0, 2);

        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $campo_livre = $ag . $this->carteira . $nnum . $cc . '0';

        $cb = $banco . $moeda . $fator . $valor . $campo_livre;
        $dv = $this->digitoVerificador_barra($cb);

        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

}

class BoletoBansicredi extends Boleto {

    public $numbanco = '748';
    public $moeda = '9';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->conta = substr($this->prepara_conta($entrada['conta'], 5), 0, 5);
        $this->nosso_numero = str_replace('-', '', $entrada['nnumero']);
        $this->nosso_numero = substr($this->nosso_numero, 11, 9);
        $this->carteira = $entrada['convenio'];

        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $vcto = $this->vencimento;
        $banco = $this->numbanco;
        $moeda = $this->moeda;
        $cart = $this->carteira;
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $dac1 = $this->mod10($ag . $cc . $nnum);
        $dac2 = $this->mod10($ag . $cc);

        $cobranca = '3'; //~ 3 - Codigo numerico
        $carteira = '1'; // Carteira Simples
        $posto = $this->carteira;
        $campo_livre = $cobranca . $carteira . $nnum . $ag . $posto . $cc . '10';
        $campo_livre .= $this->mod11($campo_livre);

        $dv = $this->digitoVerificador_barra($banco . $moeda . $fator . $valor . $campo_livre);

        $this->codigo_barras = $banco . $moeda . $dv . $fator . $valor . $campo_livre;
    }

}

class BoletoSicoob extends Boleto {

    public $numbanco = '756';
    public $moeda = '9';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->conta = str_replace('-', '', $entrada['conta']);
        $this->conta = str_replace('.', '', $this->conta);
        $this->conta = substr($this->conta, 2);
        $this->nosso_numero = str_replace('-', '', $entrada['nnumero']);
        $this->convenio = $entrada['convenio'];
        $this->complemento = $entrada['complemento'];

        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->convenio;
	
		if ($this->complemento == "1")
			$campo_livre = '1' . $ag . '01' . $cc . $nnum . '001';
		else
			$campo_livre = '1' . $ag . '02' . $cc . $nnum . '001';

        $dv = $this->digitoVerificador_barra($this->numbanco . $this->moeda . $fator . $valor . $campo_livre);

        $this->codigo_barras = $this->numbanco . $this->moeda . $dv . $fator . $valor . $campo_livre;
    }

}

class BoletoBancoReal extends BoletoItau {

    public $numbanco = '356';
    public $moeda = '9';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->conta = str_replace('-', '', $entrada['conta']);
        $this->conta = str_replace('.', '', $this->conta);
        $this->conta = substr($this->conta, 1, 7);
        $this->nosso_numero = substr(str_replace('-', '', $entrada['nnumero']), 0, 13);

        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $digitao_da_cobranca = $this->mod10($nnum . $ag . $cc);
        $campo_livre = $ag . $cc . $digitao_da_cobranca . $nnum;

        $dv = $this->digitoVerificador_barra($this->numbanco . $this->moeda . $fator . $valor . $campo_livre);

        $this->codigo_barras = $this->numbanco . $this->moeda . $dv . $fator . $valor . $campo_livre;
    }

}

class BoletoBancoHSBC extends Boleto {

    public $numbanco = '399';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->conta = $entrada['convenio'];

        if (strlen($entrada['nnumero']) <= 11) {
            $this->nosso_numero = '00000' . substr($entrada['nnumero'], 0, 8);
        } else {
            $this->nosso_numero = substr($entrada['nnumero'], 0, 13);
        }

        $this->vencimento = $entrada['vencimento'];
        $this->geraCodigoBarras();
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras() {
        $fator = $this->fator_vcto;
        $valor = $this->valor;
        $nnum = $this->nosso_numero;
        $ag = $this->agencia;
        $cc = $this->conta;

        $campo_livre = $cc . $nnum . $this->dataJuliano($this->vencimento) . '2';

        $dv = $this->digitoVerificador_barra($this->numbanco . $this->moeda . $fator . $valor . $campo_livre);

        $this->codigo_barras = $this->numbanco . $this->moeda . $dv . $fator . $valor . $campo_livre;
    }

    function dataJuliano($data) {
        $dia = (int) substr($data, 0, 2);
        $mes = (int) substr($data, 3, 2);
        $ano = (int) substr($data, 6, 4);
        $dataf = strtotime("$ano/$mes/$dia");
        $datai = strtotime(($ano - 1) . '/12/31');
        $dias = (int) (($dataf - $datai) / (60 * 60 * 24));

        return str_pad($dias, 3, '0', STR_PAD_LEFT) . substr($data, 9, 4);
    }

}

class BoletoSantander extends Boleto {

    public $numbanco = '033';

    function __construct($entrada) {
        parent::__construct($entrada);

        $this->convenio = $this->prepara_conta($entrada['convenio'], 7);
        $nosso_numero = str_replace('-', '', $entrada['nnumero']);
        $this->nosso_numero = substr($nosso_numero, 0, 13);

        $complemento = $entrada['complemento'];

        $this->geraCodigoBarras($complemento);
        $this->geraLinhaDigitavel();
    }

    function geraCodigoBarras($complemento) {
        $fator = $this->fator_vcto;
        $valor = $this->valor;

        $campo_livre = '9' . $this->convenio . $this->nosso_numero . '0' . $complemento;

        $cb = $this->numbanco . $this->moeda . $fator . $valor . $campo_livre;

        $dv = $this->digitoVerificador_barra($cb);
        $this->codigo_barras = substr($cb, 0, 4) . $dv . substr($cb, 4, 43);
    }

}

?>