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
    <h2 class="content-title"> Dashboard </h2>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="card card-body mb-3">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-local_shipping"></i></span>
                <div class="text">
                    <h6 class="mb-1">Pedidos entregues ( {$valorPedidosEntregues['total']} )</h6>
                    <span>R$ {number_format($valorPedidosEntregues['valor_pedido'], 2, ',','.')} </span>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-body mb-3">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-danger"><i class="text-white material-icons md-cancel"></i></span>
                <div class="text">
                    <h6 class="mb-1">Pedidos cancelados ( {$valorPedidosCancelados['total']} )</h6>
                    <span>R$ {number_format($valorPedidosCancelados['valor_pedido'], 2, ',','.')}</span>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-body mb-3">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-people"></i></span>
                <div class="text">
                    <h6 class="mb-1">Clientes ativos ( {$totalClientesAtivos} )</h6>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-body mb-3">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-motorcycle"></i></span>
                <div class="text">
                    <h6 class="mb-1">Entregadores ativos ( {$totalEntregadoresAtivos} ) </h6>
                </div>
            </article>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        {if isset($novosPedidos)}
        <div id="atualiza" class="table-responsive">
            <h5 class="card-title">Novos pedidos</h5>
            <table class="table table-hover">
                {foreach $novosPedidos as $pedido}
                <tr>
                    <td><a href="{$app_url}admin/pedidos/show/{$pedido['codigo']}"> {$pedido.codigo}</a></td>
                    <td><b>{$pedido.cliente}</b></td>
                    <td>{$pedido.email}</td>
                    <td>R$ {number_format($pedido.valor_pedido, 2, ',','.')}</td>
                    <td><span class="badge rounded-pill alert-warning">Pendente</span></td>
                    <td>{$pedido.criado_em|date_format:"%d/%m/%Y %Hh%M"}</td>
                </tr>
                {/foreach}
            </table>
            <span>Última atualização: {$horaAtual}</span>
        {else}
        <h5 class="card-title">Não há novos pedidos no momento <small style="font-weight: normal!important;font-size: 14px">{date('d/m/Y H:i:s')}</small></h5>
        </div>
        {/if}

    </div>
</div>
<script>
    setInterval("atualiza()", 15000); // 15 segundos
    function atualiza() {
        $("#atualiza").load(app_url+'admin/home' + ' #atualiza');
    }
</script>
