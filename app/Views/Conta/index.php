<link href="{$app_url}src/assets/css/produto.css" type="text/css" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em;min-height: 50px">
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
        {include file='Conta/sidebar.php'}
        <div class="row" id="conta">
            <div class="col-md-12 col-xs-12">
                <h2 class="section-title">{$title}</h2>
            </div>
            <div class="col-md-12">
                {if !isset($pedidos)}
                    <h4 class="text-info">Nessa área aparecerá o seu histórico de pedidos realizados</h4>
                {else}
                    {foreach $pedidos as $key => $pedido}
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#collapse{$key}">Pedido #{esc($pedido.codigo)} - Realizado {$pedido.criado_em|date_format:"%d/%m/%Y %Hh%M"} - {$pedido['situacao_translate']}</a>
                                    </h4>
                                    <div id="collapse{$key}" class="panel-collpase collapse">
                                        <div class="panel-body">
                                            <h5>Situação do pedido {$pedido['situacao_translate']}</h5>
                                            <ul class="list-group">
                                                {foreach $pedido['produtos'] as $produto}
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                {/if}
            </div>
        </div>
    </div>
    <!-- end product -->
</div>

<script>
    $(document).ready(function (){
        window.location.hash = '#conta';
    });
</script>

