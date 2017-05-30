<?php

class NotaFiscal extends Controller {

    function __construct() {

        parent::__construct();

        @session_start();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Postagem pelo formulario
        if (isset($_POST['nf_arquivo']) AND ! empty($_POST['nf_arquivo']) AND isset($_POST['nf_cnpjcpf']) AND ! empty($_POST['nf_cnpjcpf']) AND isset($_POST['nf_numero']) AND ! empty($_POST['nf_numero'])) {

            // Remove aspas do conteúdo postado (segurança contra SQL Injection) limitando os caracteres
            $nf_idempresa = substr($this->funcoes->removeAspas($_POST['nf_idempresa']), 0, 11);
            $nf_arquivo = substr($this->funcoes->removeAspas($_POST['nf_arquivo']), 0, 15);
            $nf_cnpjcpf = substr($this->funcoes->removeAspas($_POST['nf_cnpjcpf']), 0, 14);
            $nf_numero = substr($this->funcoes->removeAspas($_POST['nf_numero']), 0, 9);

            // Instancia a classe de MODEL relacionado
            require 'models/empresa_model.php';
            $empresa_model = new Empresa_Model();

            // Consulta dados da empresa para impressao na nota
            $dados_empresa = $empresa_model->Dados_Empresa($nf_idempresa); // Executa a query no BD e armazena o resultado numa array

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

            // Instancia a classe de MODEL relacionado
            require 'models/notasfiscais_model.php';
            $notasfiscais_model = new NotasFiscais_Model();

            // Consulta registro da nota fiscal no arquivo Mestre
            $dados_mestre = $notasfiscais_model->Nota_Fiscal_Mestre($nf_arquivo, $nf_cnpjcpf, $nf_numero);

            if ($dados_mestre[0][modelo] == 21 ? $tipoNF = 'COMUNICA&Ccedil;&Atilde;O' : $tipoNF = 'TELECOMUNICA&Ccedil;&Atilde;O')
                ;

            $mestre->numero = utf8_encode($dados_mestre[0][numero]);
            $mestre->referencia = utf8_encode($dados_mestre[0][referencia]);
            $mestre->serie = utf8_encode($dados_mestre[0][serie]);
            $mestre->modelo = utf8_encode($dados_mestre[0][modelo]);
            $mestre->tipo = utf8_encode($tipoNF);
            $mestre->emissao = utf8_decode(utf8_encode($dados_mestre[0][emissao]));
            $mestre->ano_mes = utf8_decode(utf8_encode($dados_mestre[0][ano_mes]));
            $mestre->boleto_numero = utf8_decode(utf8_encode($dados_mestre[0][boleto_nnumero]));
            $mestre->boleto_banco = utf8_decode(utf8_encode($dados_mestre[0][boleto_idbanco]));
            $mestre->base_calculo = utf8_decode(utf8_encode($dados_mestre[0][bc_icms]));
            $mestre->valor_icms = utf8_decode(utf8_encode($dados_mestre[0][icms]));
            $mestre->valor_total = utf8_decode(utf8_encode($dados_mestre[0][valor_total]));
            $mestre->reservado_fisco = utf8_decode(utf8_encode($dados_mestre[0][cad_md5]));
            $mestre->codigo_cliente = utf8_decode(utf8_encode($dados_mestre[0][codigo]));
            $mestre->situacao = utf8_decode(utf8_encode($dados_mestre[0][situacao]));

            // Instancia a classe de MODEL relacionado
            require 'models/sessao_model.php';
            $sessao_model = new Sessao_Model();

            // Consulta se o cliente e pessoa fisica ou juridica
            $tipoPessoa = $sessao_model->Tipo_Pessoa($mestre->codigo_cliente);
            $tipoPessoa = $tipoPessoa[0][tipo];

            // Instancia a classe de MODEL relacionado
            require 'models/boletos_model.php';
            $boletos_model = new Boletos_Model();

            // Consulta se o cliente e pessoa fisica ou juridica
            $referenciaBoleto = $boletos_model->Referencia_Boleto($mestre->boleto_banco, $mestre->boleto_numero);

            // Consulta registro da nota fiscal no arquivo Dados
            $dados_cadastro = $notasfiscais_model->Nota_Fiscal_Dados($nf_arquivo, $nf_cnpjcpf, $nf_numero); // Executa a query no BD e armazena o resultado numa array
            // Se for pessoa fisica
            if ($tipoPessoa == 'F'):

                $cnpj_cpf = 'CPF: ' . $this->funcoes->cpf($dados_cadastro[0][cnpjcpf]);
                $ie_rg = 'RG: ';

            // Senão é pessoa juridica
            else:

                $cnpj_cpf = 'CNPJ: ' . $this->funcoes->cnpj($dados_cadastro[0][cnpjcpf]);
                $ie_rg = 'IE: ';

            endif;

            $cadastro->id = utf8_decode(utf8_encode($dados_cadastro[0][id]));
            $cadastro->razao_social = utf8_decode(utf8_encode($dados_cadastro[0][rsocial]));
            $cadastro->endereco = utf8_decode(utf8_encode($dados_cadastro[0][logradouro]));
            $cadastro->bairro = utf8_decode(utf8_encode($dados_cadastro[0][bairro]));
            $cadastro->cep = utf8_decode(utf8_encode($dados_cadastro[0][cep]));
            $cadastro->cidade = utf8_decode(utf8_encode($dados_cadastro[0][municipio]));
            $cadastro->estado = utf8_decode(utf8_encode($dados_cadastro[0][uf]));
            $cadastro->cnpj_cpf = utf8_decode(utf8_encode($cnpj_cpf));
            $cadastro->ie_rg = $ie_rg . utf8_decode(utf8_encode($dados_cadastro[0][ie]));

            // Consulta registro da nota fiscal no arquivo Item
            $this->view->nota_fiscal_itens = $notasfiscais_model->Nota_Fiscal_Item($nf_arquivo, $nf_cnpjcpf, $nf_numero); // Executa a query no BD e armazena o resultado numa array
            // Instancia a classe de MODEL relacionado
            require 'models/config_model.php'; // O MODEL não é "auto-carregado" como as libs
            $config_model = new Config_Model();

            // Consulta de chaves de configuracao
            $nf_boleto = $config_model->Sistema_Config('NF_BOLETO');
            $nf_ibpt = $config_model->Sistema_Config('NF_IBPT');
            $nf_ibpt_municipal = $config_model->Sistema_Config('NF_IBPT_MUNICIPAL');
            $nf_aliquota = $config_model->Sistema_Config('NF_ALIQUOTA');
            $nf_optante = $config_model->Sistema_Config('NF_OPTANTE');
            $nf_fust = $config_model->Sistema_Config('NF_FUST');
            $nf_regime = $config_model->Sistema_Config('NF_REGIME');
            $nf_mensagem = $config_model->Sistema_Config('NF_MENSAGEM');

            // Recupera o valor das chaves de configuracao
            $config->nf_boleto = utf8_decode(utf8_encode($nf_boleto[0][valor]));
            $config->nf_ibpt = utf8_decode(utf8_encode($nf_ibpt[0][valor]));
            $config->nf_ibpt_municipal = utf8_decode(utf8_encode($nf_ibpt_municipal[0][valor]));
            $config->nf_aliquota = utf8_decode(utf8_encode($nf_aliquota[0][valor]));
            $config->nf_optante = utf8_decode(utf8_encode($nf_optante[0][valor]));
            $config->nf_fust = utf8_decode(utf8_encode($nf_fust[0][valor]));
            $config->nf_regime = utf8_decode(utf8_encode($nf_regime[0][valor]));
            $config->nf_mensagem = utf8_decode(utf8_encode($nf_mensagem[0][valor]));
            $config->nf_ref_boleto = utf8_decode(utf8_encode($referenciaBoleto[0][referencia]));

            // Renderiza a view relacionada
            $this->view->empresa = $empresa;
            $this->view->mestre = $mestre;
            $this->view->cadastro = $cadastro;
            $this->view->config = $config;

            $this->view->renderLimpo('notafiscal/index');
        }
    }

}

?>