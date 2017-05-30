<?php

class Dados extends Controller {

    function __construct() {
        parent::__construct();

        // Verifica se existe uma seção criada
        $this->funcoes->verificaSessao();

        // Instancia a classe de MODEL relacionado
        require 'models/segvia_model.php'; // O MODEL não é "auto-carregado" como as libs
        $segvia_model = new Segvia_Model();

        // Carrega as classes a serem usadas
        require_once "libs/classes/Cliente.php";
        @$cliente = new Cliente();

        // Captura os dados do cliente ativo
        $query = $segvia_model->Pesquisa_Cliente($_SESSION['ID_CLIENTE']);

        $cliente->id = $query[0][id];
        $cliente->nome = $query[0][nome];
        $cliente->tipo = $query[0][tipo];
        $cliente->sexo = $query[0][sexo];
        $cliente->rgie = $query[0][rgie];
        $cliente->cpfcgc = $query[0][cpfcgc];
        $cliente->endereco = $query[0][endereco];
        $cliente->referencia = $query[0][referencia];
        $cliente->cidade = $query[0][cidade];
        $cliente->bairro = $query[0][bairro];
        $cliente->uf = $query[0][uf];
        $cliente->cep = $query[0][cep];
        $cliente->telefone = $query[0][telefone];
        $cliente->celular = $query[0][celular];
        $cliente->email = $query[0][email];
        $cliente->obs = $query[0][obs];
        $cliente->vendedor = $query[0][vendedor];
        $cliente->dt_entrada = $query[0][dt_entrada];
        $cliente->dt_contrato = $query[0][dt_contrato];
        $cliente->dt_cancelamento = $query[0][dt_cancelamento];
        $cliente->dt_nascimento = $query[0][dt_nascimento];
        $cliente->login = $query[0][login];
        $cliente->senha = $query[0][senha];
        $cliente->situacao = $query[0][situacao];
        $cliente->dt_situacao = $query[0][dt_situacao];
        $cliente->vencimento = $query[0][vencimento];
        $cliente->grupo = $query[0][grupo];
        $cliente->autogera = $query[0][autogera];
        $cliente->plano_conta = $query[0][plano_conta];
        $cliente->dt_desconto = $query[0][dt_desconto];
        $cliente->vlr_desconto = $query[0][vlr_desconto];
        $cliente->cob_endereco = $query[0][cob_endereco];
        $cliente->cob_referencia = $query[0][cob_referencia];
        $cliente->cob_cidade = $query[0][cob_cidade];
        $cliente->cob_bairro = $query[0][cob_bairro];
        $cliente->cob_uf = $query[0][cob_uf];
        $cliente->cob_cep = $query[0][cob_cep];
        $cliente->cob_telefone = $query[0][cob_telefone];
        $cliente->cob_celular = $query[0][cob_celular];
        $cliente->estadocivil = $query[0][estadocivil];
        $cliente->pai = $query[0][pai];
        $cliente->mae = $query[0][mae];
        $cliente->titulo = $query[0][titulo];
        $cliente->habilitacao = $query[0][habilitacao];
        $cliente->csm = $query[0][csm];
        $cliente->naturalidade = $query[0][naturalidade];
        $cliente->outros = $query[0][outros];
        $cliente->contrato_aceito = $query[0][contrato_aceito];
        $cliente->contrato_data = $query[0][contrato_data];
        $cliente->contrato_hora = $query[0][contrato_hora];
        $cliente->bloqueio = $query[0][bloqueio];
        $cliente->naolibera = $query[0][naolibera];
        $cliente->latitude = $query[0][latitude];
        $cliente->longitude = $query[0][longitude];
        $cliente->cad_por = $query[0][cad_por];
        $cliente->dt_cadastro = $query[0][dt_cadastro];
        $cliente->idempresa = $query[0][idempresa];
        $cliente->anotacoes = $query[0][anotacoes];
        $cliente->cfop = $query[0][cfop];

        // Renderiza a view relacionada
        $this->view->cliente = $cliente;
        $this->view->renderJQ('dados/index');
    }

}

?>