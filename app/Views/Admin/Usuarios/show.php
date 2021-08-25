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
                                <label class="form-label">Nome completo</label>
                                <input class="form-control" readonly type="text" value="{$usuario['nome']}">
                            </div>
                            <div class="col-2  mb-3">
                                <label class="form-label">ID</label>
                                <input class="form-control" readonly type="text" value="{$usuario['id']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">E-mail</label>
                                <input class="form-control" readonly type="email" value="{$usuario['email']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Telefone</label>
                                <input class="form-control" type="tel" readonly value="{$usuario['telefone']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Perfil</label>
                                <input class="form-control" type="text" readonly value="{$usuario['tipo']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Status</label>
                                <input class="form-control" type="text" readonly value="{$usuario['ativo']}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Criado</label>
                                <input class="form-control" type="text" readonly value="{toDataBR($usuario['criado_em'], true)}">
                            </div>
                            <div class="col-lg-6  mb-3">
                                <label class="form-label">Atualizado</label>
                                <input class="form-control" type="text" readonly value="{toDataBR($usuario['atualizado_em'], true)}">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <a class="btn btn-primary" href="{$app_url}admin/usuarios/editar/{$usuario['id']}" >Editar</a>
                <a class="btn btn-primary" href="{$app_url}admin/usuarios" >Voltar</a>

                <hr class="my-5">
