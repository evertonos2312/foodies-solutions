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

<div class="card">
    <div class="card-body">
        <div class="col-lg-12">
            <section class="content-body p-xl-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row gx-3">
                            <div class="col-10  mb-3">
                                <label class="form-label">Nome</label>
                                <input class="form-control" readonly type="text" value="{$extra['nome']}">
                            </div>
                            <div class="col-2  mb-3">
                                <label class="form-label">ID</label>
                                <input class="form-control" readonly type="text" value="{$extra['id']}">
                            </div>
                            <div class="col-6  mb-3">
                                <label class="form-label">Slug</label>
                                <input class="form-control" readonly type="text" value="{$extra['slug']}">
                            </div>
                            <div class="col-6  mb-3">
                                <label class="form-label">Preço</label>
                                <input class="form-control" readonly type="text" value="R$ {number_format($extra['preco'], 2, ',', '.')}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Status</label>
                                <input class="form-control" type="text" readonly value="{$extra['ativo']}">
                            </div>
                            <div class="col-lg-3  mb-3">
                                <label class="form-label">Criado</label>
                                <input class="form-control" type="text" readonly value="{toDataBR($extra['criado_em'], true)}">
                            </div>
                            <div class="col-lg-3  mb-3">
                                <label class="form-label">Atualizado</label>
                                <input class="form-control" type="text" readonly value="{toDataBR($extra['atualizado_em'], true)}">
                            </div>
                            <div class="col-lg-12  mb-3">
                                <label class="form-label">Atualizado</label>
                                <textarea class="form-control" readonly rows="3">{$extra['descricao']}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-primary" href="{$app_url}admin/extras/editar/{$extra['id']}" >Editar</a>
                <a class="btn btn-primary" href="{$app_url}admin/extras" >Voltar</a>

                <hr class="my-5">
