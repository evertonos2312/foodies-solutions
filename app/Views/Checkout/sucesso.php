<link href="{$app_url}src/assets/css/produto.css" type="text/css" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
        {if ($msg)}
        <div class="alert {if ($msg_type)}{$msg_type}{else}alert-danger{/if} alert-dismissible" role="alert">
            <button type="button" class="{if ($msg_type)}{$msg_type}{else}alert-danger{/if} close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span>&nbsp;</span>
            <ul>
            {foreach $msg as $err}
            <li>{$err}</li>
            {/foreach}
            </ul>
        </div>
        {/if}
        <div class="row" id="produtos">
            {if $pedido['situacao'] == 0 }
            <div class="col-md-12 col-xs-12">
                <h2 class="section-title">{$title}</h2>
            </div>
            {/if}

            <div class="col-md-12 col-xs-12">
                <h4 class="text-center">No momento o seu pedido está com o status de {$pedido['situacao_translate']}</h4>

            </div>


            {if $pedido['situacao'] != 3 }
            <div class="col-md-12 col-xs-12">
                <h5 class="text-center">Quando ocorrer uma mudança no status do seu pedido, nós notificaremos você por e-mail.</h5>
            </div>
            {/if}

            <div class="col-md-12">
                <ul class="list-group">
                    {foreach $produtos as $produto}
                    <li class="list-group-item">
                        <div>
                            <h4>{ellipsize($produto['nome'], 100)}</h4>
                            <p class="text-muted">Quantidade: {$produto['quantidade']}</p>
                            <p class="text-muted">Preço: R$ {$produto['preco']}</p>
                        </div>
                    </li>
                    {/foreach}
                    <li class="list-group-item">
                        <span>Data do pedido:</span>
                        <strong>{$pedido.criado_em|date_format:"%d/%m/%Y %Hh%M"}</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Total produtos:</span>
                        <strong>R$ {number_format($pedido.valor_produtos, 2, ',','.')}</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Taxa de entrega:</span>
                        <strong>R$ {number_format($pedido.valor_entrega, 2, ',','.')}</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Valor final do pedido:</span>
                        <strong>R$ {number_format($pedido.valor_pedido, 2, ',','.')}</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Endereço de entrega:</span>
                        <strong>{$pedido['endereco_entrega']} </strong>
                    </li>
                    <li class="list-group-item">
                        <span>Forma de pagamento na entrega:</span>
                        <strong>{$pedido['forma_pagamento']} </strong>
                    </li>
                    <li class="list-group-item">
                        <span>Observações do pedido:</span>
                        <strong>{$pedido['observacoes']} </strong>
                    </li>
                </ul>
                <a href="{$app_url}#menu" style="font-family: 'Montserrat-Bold', sans-serif;" class="btn btn-food">Mais delícias</a>
            </div>
        </div>
    </div>
    <!-- end product -->
</div>

