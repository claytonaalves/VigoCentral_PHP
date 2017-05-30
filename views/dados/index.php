<?php
require_once 'libs/Functions.php';
$funcoes = new Functions(); // Instancia a classe de FUNÇÕES BÁSICAS
$funcoes->verificaSessao();
?>
<!-- SECAO: DADOS -->
<section class="dados">			
    <div class="container">
        <h1>Meus Dados</h1>

        <ul class="caminho">
            <span>Voc&ecirc; est&aacute; em: </span>
            <li class="target"><a href="core">HOME</a></li>
            <li class="target"><a href="conta">MINHA CONTA</a></li>
            <li class="target">MEUS DADOS</li>
        </ul>

        <h3>Dados Pessoais</h3>

        <label>
            <span>Nome:</span>
            <strong class="maiusculo"><?php echo utf8_decode(utf8_encode($this->cliente->nome)); ?></strong>
        </label>
        <label>
            <span>CPF/CNPJ:</span>
            <strong><?php echo utf8_decode(utf8_encode($this->cliente->cpfcgc)); ?></strong>
        </label>
        <label>
            <span>RG/IE:</span>
            <strong class="maiusculo"><?php echo utf8_decode(utf8_encode($this->cliente->rgie)); ?></strong>
        </label>
        <label>
            <span>Data de Nascimento:</span>
            <strong><?php echo $funcoes->dataToBR($this->cliente->dt_nascimento); ?></strong>
        </label>

        <h3>Endere&ccedil;o e Contato</h3>

        <label>
            <span>Endere&ccedil;o:</span>
            <strong class="maiusculo"><?php echo utf8_decode(utf8_encode($this->cliente->endereco . ' - ' . $this->cliente->bairro)); ?></strong>
        </label>
        <label>
            <span>Cidade:</span>
            <strong class="maiusculo"><?php echo utf8_decode(utf8_encode($this->cliente->cidade . ' - ' . $this->cliente->uf)); ?></strong>
        </label>
        <label>
            <span>CEP:</span>
            <strong><?php echo utf8_decode(utf8_encode($this->cliente->cep)); ?></strong>
        </label>
        <label>
            <span>Telefone:</span>
            <strong><?php echo utf8_decode(utf8_encode($this->cliente->telefone)); ?></strong>
        </label>
        <label>
            <span>Celular:</span>
            <strong><?php echo utf8_decode(utf8_encode($this->cliente->celular)); ?></strong>
        </label>
        <label>
            <span>E-mail:</span>
            <strong><?php echo utf8_decode(utf8_encode($this->cliente->email)); ?></strong>
        </label>

        <h3>Dados da Conta</h3>

        <label>
            <span>Dia de Vencimento:</span>
            <strong><?php echo utf8_decode(utf8_encode($this->cliente->vencimento)); ?></strong>
        </label>
        <label>
            <span>Cliente Desde:</span>
            <strong><?php echo $funcoes->dataToBR($this->cliente->dt_entrada); ?></strong>
        </label>

        <div class="clear"></div>
    </div><div class="clear"></div>
</section><!-- /FIM - SECAO: DADOS -->