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
        <a href="{$app_url}admin/entregadores/criar" class="btn btn-primary"><i class="material-icons md-plus"></i> Criar Novo</a>
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
                {form_open('admin/entregadores/index', ['id' => 'form_status'])}
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
                {form_open('admin/entregadores/index', ['id' => 'form_perpage'])}
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
            {if (!empty($entregadores))}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Imagem</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center"> Ações </th>
                </tr>
                </thead>
                <tbody>
                    {foreach $entregadores as $entregador}
                    <tr>
                        <td>
                             {if !empty($entregador['imagem'])}
                                <img src="{$app_url}uploads/imagens/entregadores/{$entregador['imagem']}" class="img-sm img-avatar" alt="{$entregador['nome']}">
                            {else}
                                <img src="{$app_url}assets/imagens/sem_foto.jpg" class="img-sm img-avatar" alt="Sem Imagem">
                            {/if}
                        </td>
                        <td><b><a href="{$app_url}admin/entregadores/show/{$entregador['id']}">{$entregador['nome']}</a></b></td>
                        <td>{$entregador['telefone']}</td>
                        <td>{$entregador['placa']}</td>
                        <td><span class="badge rounded-pill {$entregador['ativo_class']}">{$entregador['ativo']}</span></td>
                        <td class="text-center">
                            <a class="btn btn-light" id="editar_anchor_{$entregador['id']}" href="{$app_url}admin/entregadores/editar/{$entregador['id']}">Editar</a>
                            <button class="btn btn-light text-danger" onclick="excluirEntregador('{$entregador.id}', '{$entregador.nome}')">Excluir</button>
                        </td>
                    </tr>
                    {/foreach}

                </tbody>
                    {else}
                        <tr>
                            <td colspan="6">Nenhum entregador encontrado</td>
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
<script src="{$app_url}assets/admin/js/entregadores/index.js" type="text/javascript"></script>