{if ($msg)}
<div class="alert {if ($msg_type)}{$msg_type}{else}alert-danger{/if} alert-dismissible fade show" role="alert">
    <i class="far fa-lightbulb mr-5"></i>
    <span>&nbsp;</span>
    {$msg}
    <button type="button" class="{if ($msg_type)}{$msg_type}{else}alert-danger{/if} close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
{/if}
<div class="content-header">
    <h2 class="content-title">{$title} </h2>
</div>
{$breadcrumbs}

<div class="col-lg-6 grid-margin stretch-card" >
<div class="card">
    <div class="card-body">
        <p class="card-text">
            <span class="font-weight-bold-custom">Situação:</span>
            {$pedido['situacao_translate']}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Criado:</span>
            {$pedido.criado_em|date_format:"%d/%m/%Y %Hh%M"}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Atualizado:</span>
            {$pedido.atualizado_em|date_format:"%d/%m/%Y %Hh%M"}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Forma de pagamento:</span>
            {$pedido['forma_pagamento']}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Valor dos produtos:</span>
            R$ {number_format($pedido['valor_produtos'], 2, ',', '.')}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Valor de entrega:</span>
            R$ {number_format($pedido['valor_entrega'], 2, ',', '.')}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Valor do pedido:</span>
            R$ {number_format($pedido['valor_pedido'], 2, ',', '.')}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Endereço de entrega:</span>
            {$pedido.endereco_entrega}
        </p>
        <p class="card-text">
            <span class="font-weight-bold-custom">Observações:</span>
            {$pedido.observacoes}
        </p>
        {if $pedido.entregador_id != null}
        <p class="card-text">
            <span class="font-weight-bold-custom">Entregador:</span>
            {$pedido.entregador}
        </p>
        {/if}

        <ul class="list-group">
            {if isset($produtos)}
                {foreach $produtos as $produto}
                <li class="list-group-item">
                    <p><strong> Produto:</strong> {$produto.nome}</p>
                    <p><strong> Quantidade:</strong> {$produto.quantidade}</p>
                    <p><strong> Preço:</strong> R$ {$produto['preco']}</p>
                </li>
                {/foreach}
            {/if}
        </ul>

    </div>
</div>
<br>
<a class="btn btn-primary" href="{$app_url}admin/pedidos/editar/{$pedido['codigo']}" >Alterar situação</a>
<a class="btn btn-primary" href="{$app_url}admin/pedidos" >Voltar</a>

<hr class="my-5">
