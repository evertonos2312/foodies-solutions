<link href="{$app_url}assets/admin/vendors/auto-complete/jquery-ui.css" rel="stylesheet" type="text/css"/>
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
    <h2 class="content-title">{$title}</h2>
</div>
{$breadcrumbs}

<div class="card mb-4">
    <header class="card-header">
        <div class="row gx-3">
            <div class="ui-widget col-lg-9 col-md-6 me-auto">
                <input id="pesquisa_query" placeholder="Pesquise por um código de pedido.." class="form-control bg-light" name="pesquisa_query" type="search">
            </div>

            <div class="col-lg-1 col-6 col-md-3">
                {form_open('admin/pedidos/index', ['id' => 'form_perpage'])}
                {$options_page = ['10'=> '10', '20' => '20', '40' => '40']}
                {if (!empty($filtro['per_page']))}
                {$filtro_page = $filtro['per_page']}
                {else}
                {$filtro_page = '10'}
                {/if}
                {form_dropdown('per_page', $options_page, $filtro_page, ['class' => 'form-select'])}
                {form_close()}
            </div>
        </div>
    </header> <!-- card-header end// -->
    <div class="card-body">
        <div class="table-responsive">
            {if (isset($pedidos))}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Código do pedido</th>
                    <th scope="col">Data do pedido</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Situação</th>
                </tr>
                </thead>
                <tbody>
                    {foreach $pedidos as $pedido}
                    <tr>
                        <td><b><a href="{$app_url}admin/pedidos/show/{$pedido['codigo']}">#{$pedido['codigo']}</a></b></td>
                        <td>{$pedido.criado_em|date_format:"%d/%m/%Y %Hh%M"}</td>
                        <td>{$pedido.cliente}</td>
                        <td>R$ {number_format($pedido.valor_pedido, 2, ',','.')}</td>
                        <td>{$pedido['situacao_translate']}</td>
                    </tr>
                    {/foreach}

                </tbody>
                    {else}
                        <tr>
                            <td colspan="6">Não há pedidos para exibir</td>
                        </tr>
                    {/if}
                <input type="hidden" class="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
            </table>
        </div>
        {if ($pager)}
            {$pager_links}
        {/if}
    </div>
</div>
<script>
    $(".pagination a").click(function() {
        var url = $(this).attr("href");
        var form = $("#form_perpage");
        $(form).attr("action", url);
        $(form).submit();
        return false;
    });

    $('select[name="per_page"]').change(function() {
        var url = $(this).attr('action');
        var form = $(this).closest('form')[0];
        $(form).attr('action', url);
        $(form).submit();
    });
</script>
<script src="{$app_url}assets/admin/vendors/auto-complete/jquery-ui.js" type="text/javascript"></script>
<script src="{$app_url}assets/admin/js/pedidos/index.js" type="text/javascript"></script>