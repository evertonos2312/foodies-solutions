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
    <div>
        <a href="{$app_url}admin/produtos/criar" class="btn btn-primary"><i class="material-icons md-plus"></i> Criar Novo</a>
    </div>
</div>
{$breadcrumbs}

<div class="card mb-4">
    <header class="card-header">
        <div class="row gx-3">
            <div class="ui-widget col-lg-9 col-md-6 me-auto">
                <input id="pesquisa_query" placeholder="Pesquise aqui..." class="form-control bg-light" name="pesquisa_query" type="search">
            </div>

            <div class="col-lg-2 col-6 col-md-3">
                {form_open('admin/produtos/index', ['id' => 'form_status'])}
                {$options_status = ['todos'=> 'Todos', 'ativo' => 'Ativo', 'inativo' => 'Inativo']}
                {if (!empty($filtro['status']))}
                {$filtro_status = $filtro['status']}
                {else}
                {$filtro_status = 'todos'}
                {/if}
                {form_dropdown('status', $options_status, $filtro_status, ['class' => 'form-control'])}
                {form_close()}
            </div>
            <div class="col-lg-1 col-6 col-md-3">
                {form_open('admin/produtos/index', ['id' => 'form_perpage'])}
                <input type="hidden" name="filtro_status" value="{$filtro_status}">
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
            {if (!empty($produtos))}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Data de criação</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center"> Ações </th>
                </tr>
                </thead>
                <tbody>
                    {foreach $produtos as $produto}
                    <tr>
                        <td>{$produto['id']}</td>
                        <td><b><a class="" href="{$app_url}admin/produtos/show/{$produto['id']}">{$produto['nome']}</a></b></td>
                        <td>{toDataBR($produto['criado_em'], true)}</td>
                        <td><span class="badge rounded-pill {$produto['ativo_class']}">{$produto['ativo']}</span></td>
                        <td class="text-center">
                            <a class="btn btn-light" id="editar_anchor_{$produto['id']}" href="{$app_url}admin/produtos/editar/{$produto['id']}">Editar</a>
                            <button class="btn btn-light text-danger" onclick="excluirProduto('{$produto.id}', '{$produto.nome}')">Excluir</button>
                        </td>
                    </tr>
                    {/foreach}

                </tbody>
                    {else}
                        <tr>
                            <td colspan="6">Nenhuma produto encontrado</td>
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
        var form_status = $("#form_status");
        $(form).attr("action", url);
        $(form_status).attr("action", url);
        $(form).submit();
        $(form_status).submit();
        return false;
    });

    $('select[name="per_page"]').change(function() {
        var url = $(this).attr('action');
        var form = $(this).closest('form')[0];
        var form_status = $("#form_status");
        $(form_status).attr("action", url)
        $(form_status).submit();
        $(form).attr('action', url);
        $(form).submit();
    });

    $('select[name="status"]').change(function() {
        var url = $(this).attr('action');
        var form = $(this).closest('form')[0];
        var form_perpage = $("#form_perpage");
        $(form_perpage).attr("action", url)
        $(form_perpage).submit();
        $(form).attr('action', url);
        $(form).submit();
    });
</script>
<script src="{$app_url}assets/admin/vendors/auto-complete/jquery-ui.js" type="text/javascript"></script>
<script src="{$app_url}assets/admin/js/produtos/index.js" type="text/javascript"></script>