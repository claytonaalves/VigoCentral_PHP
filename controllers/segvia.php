<?php

class segvia extends Controller {

    function __construct() {
        parent::__construct();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Captura o ID que está na URL
        // Limita a 10 caracteres, tira os espaços e as aspas (segurança básica)
        $id = explode('/', $_SERVER['QUERY_STRING']);
        $id = $this->funcoes->removeAspas(rtrim(substr($id[1], 0, 10), ' '));

        // Instancia a classe de MODEL relacionado a Segvia
        require 'models/segvia_model.php'; // O MODEL não é "auto-carregado" como as libs
        $segvia_model = new Segvia_Model();

        // Instancia a classe de MODEL relacionado a Config
        require 'models/config_model.php';
        $config_model = new Config_Model();

        // Carrega as classes a serem usadas
        require_once "libs/classes/Banco.php";
        require_once "libs/classes/Boleto.php";

        $banco = new Banco();
        $bloqueto = new Bloqueto();

        // Captura os dados do bloqueto
        $query = $segvia_model->Pesquisa_Boleto($id, $_SESSION["ID_CLIENTE"]);

        $bloqueto->id = $query[0];
        $bloqueto->id_banco = $query[1];
        $bloqueto->id_cliente = $query[2];
        $bloqueto->id_empresa = $query[3];
        $bloqueto->nome = $query[4];
        $bloqueto->cpfcgc = $query[5];
        $bloqueto->endereco = $query[6];
        $bloqueto->cidade = $query[7];
        $bloqueto->bairro = $query[8];
        $bloqueto->uf = $query[9];
        $bloqueto->cep = $query[10];
        $bloqueto->referencia = $query[11];
        $bloqueto->numero = $query[12];
        $bloqueto->nossonumero = $query[13];
        $bloqueto->seunumero = $query[14];
        $bloqueto->emissao = $query[15];
        $bloqueto->vencimento = $query[16];
        $bloqueto->valor = $query[17];
        $bloqueto->obs = trim($query[18]);
        $bloqueto->grupo_cliente = $query[19];
        $bloqueto->plano_conta = $query[20];
        $bloqueto->pago = $query[21];
        $bloqueto->pago_agencia = $query[22];
        $bloqueto->pago_data = $query[23];
        $bloqueto->pago_valor = $query[24];
        $bloqueto->pago_credito = $query[25];
        $bloqueto->pago_tarifa = $query[26];
        $bloqueto->pago_local = $query[27];
        $bloqueto->linhadigitavel = $query[28];
        $bloqueto->codigobarras = $query[29];
        $bloqueto->banco = $query[30];
        $bloqueto->agencia = $query[31];
        $bloqueto->conta = $query[32];
        $bloqueto->convenio = $query[33];
        $bloqueto->complemento = $query[34];
        $bloqueto->numerobanco = $query[35];
        $bloqueto->localpagamento = $query[36];
        $bloqueto->codigocedente = $query[37];
        $bloqueto->carteira = $query[38];
        $bloqueto->ativo = $query[39];
        $bloqueto->considerado = $query[40];
        $bloqueto->enviado = $query[41];
        $bloqueto->nf_arquivo = $query[42];
        $bloqueto->nf_numero = $query[43];
        $bloqueto->nf_situacao = $query[44];

        // Redireciona para a página de login caso não seja encontrado nenhum boleto
        if ($bloqueto->id == 0) {

            header("Location: index");
            exit;
        }

        // Instancia a classe de MODEL relacionado
        require 'models/empresa_model.php';
        $empresa_model = new Empresa_Model();

        // Consulta dados da empresa para impressao na nota
        $dados_empresa = $empresa_model->Dados_Empresa($bloqueto->id_empresa); // Executa a query no BD e armazena o resultado numa array

        $empresa->foto = $dados_empresa[0][foto];
        $empresa->fantasia = utf8_encode($dados_empresa[0][fantasia]);
        $empresa->endereco = utf8_encode($dados_empresa[0][endereco]);
        $empresa->cidade = utf8_encode($dados_empresa[0][cidade]);
        $empresa->uf = utf8_encode($dados_empresa[0][uf]);
        $empresa->cep = utf8_encode($dados_empresa[0][cep]);
        $empresa->cnpj = utf8_encode($dados_empresa[0][cnpj]);
        $empresa->ie = utf8_encode($dados_empresa[0][ie]);
        $empresa->im = utf8_encode($dados_empresa[0][im]);
        $empresa->telefone = utf8_encode($dados_empresa[0][telefone]);
        $empresa->site = utf8_encode($dados_empresa[0][site]);

        // Captura o banco relativo ao bloqueto
        $query = $segvia_model->Pesquisa_Banco($bloqueto->id_banco);

        $banco->id = $query[0];
        $banco->nomebanco = $query[1];
        $banco->agencia = $query[2];
        $banco->conta = $query[3];
        $banco->convenio = $query[4];
        $banco->complemento = $query[5];
        $banco->codigoescritural = $query[6];
        $banco->codigotransmissao = $query[7];
        $banco->tipo = $query[8];
        $banco->cedente = $query[9];
        $banco->idempresa = $query[10];

        /* CONFIGURAÇÃO DO C▒?LCULO A SER EFETUADO */

        // Consulta a taxa de multa
        $taxa_multa = $config_model->Sistema_Config('MULTA');
        $taxa_multa = $this->funcoes->valorUS($taxa_multa[0][valor]);

        // Consulta a taxa de juros
        $taxa_juros = $config_model->Sistema_Config('JUROS');
        $taxa_juros = $this->funcoes->valorDecimalUS($taxa_juros[0][valor]);

        // Definido manualmente a 1% ao mês (Formatacao especifica pois depois existe uma multiplicacao por 100) - Resultando em 0.03333
        //$taxa_juros = 0.0003333;

        $LstBancos = array(
            '001' => '001-9',
            '104' => '104-0',
            '237' => '237-2',
            '341' => '341-7',
            '033' => '033-7',
            '399' => '399-9',
            '003' => '003-5',
            '004' => '004-3',
            '748' => '748-X',
            '756' => '756-0',
            '409' => '409-0',
            '356' => '356-5',
            '099' => '099',
            '041' => '041-8');

        // Verifica o vencimento, caso esteja vencido, altera o vencimento, recalcula o valor, código de barras e linha digitável
        require_once 'segvia_plug.php';
        $dias_em_atraso = DiasEmAtraso($bloqueto->vencimento);

        if (($bloqueto->numerobanco == '003') || ($bloqueto->numerobanco == '409')) { // Estes dois bancos são obsoletos e não possuem 2a. via calculada
            $Vencimento = $this->funcoes->dataToBR($bloqueto->vencimento);
            $bloqueto->emissao = $this->funcoes->dataToBR($bloqueto->emissao);
            $CodigoBarras = $bloqueto->codigobarras;
            $LinhaDigitavel = $bloqueto->linhadigitavel;
            $ValorCalculado = $bloqueto->valor;
            $ValorMultaJuros = 0;
        } else {

            if ($dias_em_atraso > 0) {

                $bloqueto->obs = "O pagamento deste n&atilde;o quita d&eacute;bitos anteriores."; // Muda a mensagem caso haja algum desconto da mesma

                $multa = $bloqueto->valor * $taxa_multa;
                $juros = ($bloqueto->valor * $taxa_juros) * $dias_em_atraso;
                $ValorMultaJuros = $multa + $juros;
                $ValorCalculado = $bloqueto->valor + $ValorMultaJuros;
                $ValorMultaJuros = sprintf("%10.2f", $ValorMultaJuros);
                $ValorCalculado = sprintf("%10.2f", $ValorCalculado);

                // Altera o vencimento e valor caso esteja atrasado
                $Vencimento = NovoVencimento();

                if ($bloqueto->numerobanco == '237'):

                    $nosso_numero = str_replace("/", "", substr($bloqueto->nossonumero, 3, 11));

                elseif ($bloqueto->numerobanco == '341'):

                    $nosso_numero = substr(str_replace("/", "", $bloqueto->nossonumero), 0, 11);

                else:

                    $nosso_numero = $bloqueto->nossonumero;

                endif;

                $dados_boleto = array(
                    'numbanco' => $bloqueto->numerobanco,
                    'agencia' => $bloqueto->agencia,
                    'conta' => $bloqueto->conta,
                    'carteira' => $bloqueto->carteira,
                    'nnumero' => $nosso_numero,
                    'convenio' => $bloqueto->convenio,
                    'codigoescritural' => $banco->codigoescritural,
                    'valor' => $ValorCalculado,
                    'vencimento' => $Vencimento,
                    'complemento' => $banco->complemento);

                $NovosDados = NovosDadosBoleto($dados_boleto);

                if (!is_null($NovosDados)) {

                    $CodigoBarras = $NovosDados['codigobarras'];
                    $LinhaDigitavel = $NovosDados['linhadigitavel'];
                }
            } else {

                // Não modifica nada, apenas formata e preenche as variáveis de cálculo com valor 0
                $bloqueto->vencimento = $this->funcoes->dataToBR($bloqueto->vencimento);
                $bloqueto->emissao = $bloqueto->emissao;
                $CodigoBarras = $bloqueto->codigobarras;
                $LinhaDigitavel = $bloqueto->linhadigitavel;
                $ValorMultaJuros = 0;
                $ValorCalculado = $bloqueto->valor;
                $Vencimento = $bloqueto->vencimento;
            }
        }

        // Renderiza a view enviando os dados do boleto
        $this->view->bloqueto_final = $bloqueto;
        $this->view->bloqueto_final->numerobanco = $LstBancos[substr($CodigoBarras, 0, 3)];
        $this->view->bloqueto_final->codigobarras = $CodigoBarras;
        $this->view->bloqueto_final->linhadigitavel = $LinhaDigitavel;
        $this->view->bloqueto_final->valor_original = $this->view->bloqueto_final->valor;
        $this->view->bloqueto_final->adicional = $ValorMultaJuros;
        $this->view->bloqueto_final->valor = $ValorCalculado;
        $this->view->bloqueto_final->vencimento = $Vencimento;
        $this->view->bloqueto_final->cedente = $banco->cedente;

        // Renderiza a view enviando os dados da empresa
        $this->view->empresa = $empresa;

        // Renderiza a view segvia
        $this->view->renderLIMPO('segvia/index');
    }

}

?>