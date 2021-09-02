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
        <a href="{$app_url}admin/categorias/criar" class="btn btn-primary"><i class="material-icons md-plus"></i> Criar Novo</a>
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
                {form_open('admin/categorias/index')}
                <input type="hidden" name="per_page" value="{$results_perpage}">
                <select name="filtro_status" class="form-control">
                    {foreach from=$status_options item=filtro}
                        <option value="{$filtro.status_value}" {$filtro.status_selected}>{$filtro.status_nome}</option>
                    {/foreach}
                </select>
                {form_close()}
            </div>
            <div class="col-lg-1 col-6 col-md-3">
                {form_open('admin/categorias/index')}
                <input type="hidden" name="filtro_status" value="{$filtro_status}">
                <select class="form-select" name="per_page">
                    {foreach $perpage_options  as $page}
                        {if (is_array($page))}
                            {$results = $page[0]}
                            <option value="{$page[0]}" {$page[1]}>{$page[0]}</option>
                            {else}
                            <option value="{$page}">{$page}</option>
                        {/if}
                    {/foreach}
                </select>
                {form_close()}
            </div>
        </div>
    </header> <!-- card-header end// -->
    <div class="card-body">
        <div class="table-responsive">
            {if (!empty($categorias))}
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
                    {foreach $categorias as $categoria}
                    <tr>
                        <td>{$categoria['id']}</td>
                        <td><b><a class="" href="{$app_url}admin/categorias/show/{$categoria['id']}">{$categoria['nome']}</a></b></td>
                        <td>{toDataBR($categoria['criado_em'], true)}</td>
                        <td><span class="badge rounded-pill {$categoria['ativo_class']}">{$categoria['ativo']}</span></td>
                        <td class="text-center">
                            <a class="btn btn-light" id="editar_anchor_{$categoria['id']}" href="{$app_url}admin/categorias/editar/{$categoria['id']}">Editar</a>
                            <button class="btn btn-light text-danger" onclick="excluirCategoria('{$categoria.id}', '{$categoria.nome}')">Excluir</button>
                        </td>
                    </tr>
                    {/foreach}

                </tbody>
                    {else}
                        <tr>
                            <td colspan="6">Nenhuma categoria encontrado</td>
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
        var form = $(this).closest('form')[0];
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

    $('select[name="filtro_status"]').change(function() {
        var url = $(this).attr('action');
        var form = $(this).closest('form')[0];
        $(form).attr('action', url);
        $(form).submit();
    });
</script>
<script src="{$app_url}assets/admin/vendors/auto-complete/jquery-ui.js" type="text/javascript"></script>
<script src="{$app_url}assets/admin/js/categorias/index.js" type="text/javascript"></script>