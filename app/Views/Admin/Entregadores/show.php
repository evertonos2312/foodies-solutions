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
                            <label class="form-label">Entregador</label>
                            <input class="form-control" readonly type="text" value="{$entregador['nome']}">
                        </div>
                        <div class="col-6  mb-3">
                            <label class="form-label">Telefone</label>
                            <input class="form-control" readonly type="text" value="{$entregador['telefone']}">
                        </div>
                        <div class="col-6  mb-3">
                            <label class="form-label">ID</label>
                            <input class="form-control" readonly type="text" value="{$entregador['id']}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">Status</label>
                            <input class="form-control" type="text" readonly value="{$entregador['ativo']}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">Criado</label>
                            <input class="form-control" type="text" readonly value="{toDataBR($entregador['criado_em'], true)}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">Atualizado</label>
                            <input class="form-control" type="text" readonly value="{toDataBR($entregador['atualizado_em'], true)}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">CPF</label>
                            <input class="form-control" type="text" readonly value="{$entregador['cpf']}">
                        </div>
                        <div class="col-lg-6  mb-3">
                            <label class="form-label">CNH</label>
                            <input class="form-control" type="text" readonly value="{$entregador['cnh']}">
                        </div>
                        <div class="col-lg-12  mb-3">
                            <label class="form-label">Veículo</label>
                            <input class="form-control" type="text" readonly value="{$entregador['veiculo']} | {$entregador['placa']}">
                        </div>
                    </div>
                    <div class="col-lg-4 custom-card">
                        <label class="form-label" for=""></label>
                        <div class="card" style="width: 18rem;">
                            {if !empty($entregador['imagem'])}
                                <img src="{$app_url}uploads/imagens/entregadores/{$entregador['imagem']}" class="card-img-top" alt="{$entregador['nome']}">
                            {else}
                                <img src="{$app_url}assets/imagens/sem_foto.jpg" class="card-img-top" alt="Entregador sem imagem">
                            {/if}
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-primary" href="{$app_url}admin/entregadores/editar/{$entregador['id']}" >Editar</a>
                <a class="btn btn-primary" href="{$app_url}admin/entregadores" >Voltar</a>

                <hr class="my-5">
            </section>
        </div>
    </div>
</div>
