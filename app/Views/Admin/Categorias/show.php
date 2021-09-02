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
                            <div class="col-6  mb-3">
                                <label class="form-label">Categoria</label>
                                <input class="form-control" readonly type="text" value="{$categoria['nome']}">
                            </div>
                            <div class="col-6  mb-3">
                                <label class="form-label">Slug</label>
                                <input class="form-control" readonly type="text" value="{$categoria['slug']}">
                            </div>
                            <div class="col-6  mb-3">
                                <label class="form-label">ID</label>
                                <input class="form-control" readonly type="text" value="{$categoria['id']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Status</label>
                                <input class="form-control" type="text" readonly value="{$categoria['ativo']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Criado</label>
                                <input class="form-control" type="text" readonly value="{toDataBR($categoria['criado_em'], true)}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Atualizado</label>
                                <input class="form-control" type="text" readonly value="{toDataBR($categoria['atualizado_em'], true)}">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-primary" href="{$app_url}admin/categorias/editar/{$categoria['id']}" >Editar</a>
                <a class="btn btn-primary" href="{$app_url}admin/categorias" >Voltar</a>

                <hr class="my-5">
