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
        <div class="col-lg-8">
            <section class="content-body p-xl-4">
                <div class="col-lg-12 custom-body">
                    <div class="row gx-3">
                        <div class="col-6  mb-3">
                            <label class="form-label">Produto</label>
                            <input class="form-control" readonly type="text" value="{$produto['nome']}">
                        </div>
                        <div class="col-6  mb-3">
                            <label class="form-label">Slug</label>
                            <input class="form-control" readonly type="text" value="{$produto['slug']}">
                        </div>
                        <div class="col-6  mb-3">
                            <label class="form-label">ID</label>
                            <input class="form-control" readonly type="text" value="{$produto['id']}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">Status</label>
                            <input class="form-control" type="text" readonly value="{$produto['ativo']}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">Criado</label>
                            <input class="form-control" type="text" readonly value="{toDataBR($produto['criado_em'], true)}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">Atualizado</label>
                            <input class="form-control" type="text" readonly value="{toDataBR($produto['atualizado_em'], true)}">
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label" for="ingredientes">Ingredientes</label>
                            <textarea class="form-control" name="ingredientes" readonly id="ingredientes" rows="3">{$produto['ingredientes']}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-4 custom-card">
                        <label class="form-label" for=""></label>
                        <div class="card" style="width: 18rem;">
                            {if !empty($produto['imagem'])}
                                <img src="{$app_url}uploads/imagens/produtos/{$produto['imagem']}" class="card-img-top" alt="{$produto['nome']}">
                            {else}
                                <img src="{$app_url}assets/imagens/produto-sem-imagem.jpg" class="card-img-top" alt="Produto sem imagem">
                            {/if}
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-primary" href="{$app_url}admin/produtos/editar/{$produto['id']}" >Editar</a>
                <a class="btn btn-primary" href="{$app_url}admin/produtos" >Voltar</a>

                <hr class="my-5">
            </section>
        </div>
    </div>
</div>
