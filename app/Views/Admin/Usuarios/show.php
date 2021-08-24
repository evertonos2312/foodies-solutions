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

                <div class="row" style="max-width:920px">
                    <div class="col-md">
                        <article class="box mb-3 bg-light">
                            <a class="btn float-end btn-light btn-sm" href="#">Reiniciar</a>
                            <h6>Senha</h6>
                            <small class="text-muted d-block" style="width:70%">Você pode reiniciar a senha do usuário aqui.</small>
                        </article>
                    </div> <!-- col.// -->
                    <div class="col-md">
                        <article class="box mb-3 bg-light">
                            <button class="btn float-end btn-outline-danger btn-sm" >Excluir</button>
                            <h6>Remover conta</h6>
                            <small class="text-muted d-block" style="width:70%">Cuidado, exclusão permanente.</small>
                        </article>
                    </div>
                </div>