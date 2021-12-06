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
        <a href="{$app_url}admin/formas/criar" class="btn btn-primary"><i class="material-icons md-plus"></i> Criar Novo</a>
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
                {form_open('admin/formas', ['id' => 'form_select'])}
                <input type="hidden" name="filtro_perpage" value="{$filtro['filtro_perpage']}">
                    {$options = ['todos'=> 'Todos', '1' => 'Ativo', '0' => 'Inativo']}
                    {if (!empty($filtro['filtro_status']))}
                        {$filtro_status = $filtro['filtro_status']}
                    {else}
                        {$filtro_status = 'todos'}
                    {/if}
                    {form_dropdown('filtro_status', $options, $filtro_status, ['id' => 'filtro_status', 'class' => 'form-select'])}
                {form_close()}
            </div>
            <div class="col-lg-1 col-6 col-md-3">
                {form_open('admin/formas', ['id' => 'form_perpage'])}
                <input type="hidden" name="filtro_status" value="{$filtro['filtro_status']}">
                {$options_perpage = [10, 20, 40]}
                {if (!empty($filtro['filtro_perpage']))}
                    {$filtro_perpage = $filtro['filtro_perpage']}
                {else}
                    {$filtro_perpage = 10}
                {/if}
                {form_dropdown('filtro_perpage', $options_perpage, $filtro_perpage, ['id' => 'filtro_perpage', 'class' => 'form-select'])}
                {form_close()}
            </div>
        </div>
    </header> <!-- card-header end// -->
    <div class="card-body">
        <div class="table-responsive">
            {if (!empty($formas))}
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
                    {foreach $formas as $forma}
                    <tr>
                        <td>{$forma['id']}</td>
                        <td><b><a class="" href="{$app_url}admin/formas/show/{$forma['id']}">{mb_ucfirst($forma['nome'])}</a></b></td>
                        <td>{toDataBR($forma['criado_em'], true)}</td>
                        <td><span class="badge rounded-pill {$forma['ativo_class']}">{$forma['ativo']}</span></td>
                        <td class="text-center">
                            <a class="btn btn-light" id="editar_anchor_{$forma['id']}" href="{$app_url}admin/formas/editar/{$forma['id']}">Editar</a>
                            <button class="btn btn-light text-danger" onclick="excluirFormas('{$forma.id}', '{$forma.nome}')">Excluir</button>
                        </td>
                    </tr>
                    {/foreach}

                </tbody>
                    {else}
                        <tr>
                            <td colspan="6">Nenhuma forma de pagamento encontrada</td>
                        </tr>
                    {/if}
            </table>
            <input type="hidden" id="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
        </div>
        {if ($pager)}
            {$pager_links}
        {/if}
    </div>
</div>
<script>
    $(".pagination a").click(function() {
        var url = $(this).attr("href");
        var form = $("#form_select");
        $(form).attr("action", url);
        $(form).submit();
        return false;
    });

    $('select[name="filtro_perpage"]').change(function() {
        var url = $(this).attr('action');
        var form = $("#form_perpage");
        $(form).attr('action', url);
        $(form).submit();
    });

    $('select[name="filtro_status"]').change(function() {
        var url = $(this).attr('action');
        var form = $("#form_select");
        $(form).attr('action', url);
        $(form).submit();
    });
</script>
<script src="{$app_url}assets/admin/vendors/auto-complete/jquery-ui.js" type="text/javascript"></script>
<script src="{$app_url}assets/admin/js/formas/index.js" type="text/javascript"></script>