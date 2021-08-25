{if ($msg)}
<div class="alert {if ($msg_type)}{$msg_type}{else}alert-danger{/if} alert-dismissible fade show" role="alert">
    <i class="far fa-lightbulb mr-5"></i>
    <span>&nbsp;</span>
    <ul>
        {foreach $msg as $err}
        <li>
            {$err}
        </li>
        {/foreach}
    </ul>
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
                {form_open("admin/usuarios/salvar")}
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row gx-3">
                                    <div class="col-10  mb-3">
                                        <label class="form-label">Nome completo</label>
                                        {if (!empty($usuario))}
                                            {$nome = $usuario['nome']}
                                        {else}
                                            {$nome = set_value('nome')}
                                        {/if}
                                        <input class="form-control"  name="nome" type="text" value="{$nome}">
                                    </div>
                                    {if (!empty($usuario) || !empty(set_value('id')))}
                                    <div class="col-2  mb-3">
                                        <label class="form-label">ID</label>
                                        {if (!empty($usuario))}
                                            {$id = $usuario['id']}
                                        {else}
                                            {$id = set_value('id')}
                                        {/if}
                                        <input class="form-control" name="id" readonly type="text" value="{$id}">
                                        <input class="form-control" name="id_hidden" readonly type="hidden" value="{$id}">
                                    </div>
                                    {/if}
                                    <div class="col-lg-6  mb-3">
                                        <label class="form-label">E-mail</label>
                                        {if (!empty($usuario))}
                                            {$email = $usuario['email']}
                                        {else}
                                            {$email = set_value('email')}
                                        {/if}
                                        <input class="form-control" name="email"  type="email" value="{$email}">
                                    </div>
                                    <div class="col-lg-6  mb-3">
                                        <label class="form-label">Telefone</label>
                                        {if (!empty($usuario))}
                                            {$telefone = $usuario['telefone']}
                                        {else}
                                            {$telefone = set_value('telefone')}
                                        {/if}
                                        <input class="form-control sp_celphones" name="telefone" type="tel"  value="{$telefone}">
                                    </div>
                                    <div class="col-lg-3  mb-3">
                                        <label class="form-label">Perfil</label>
                                        {$options_perfil = [''=> 'Selecione', '1' => 'Administrador', '0' => 'Cliente']}
                                        {if (!empty($usuario))}
                                            {$perfil = $usuario['is_admin']}
                                        {else}
                                            {$perfil = set_value('is_admin')}
                                        {/if}
                                        {form_dropdown('is_admin', $options_perfil, $perfil, ['id' => 'is_admin', 'class' => 'form-control'])}
                                    </div>
                                    <div class="col-lg-3  mb-3">
                                        <label class="form-label">Status</label>
                                        {$options = [''=> 'Selecione', '1' => 'Ativo', '0' => 'Inativo']}
                                        {if (!empty($usuario))}
                                            {$situacao = $usuario['ativo']}
                                        {else}
                                            {$situacao = set_value('ativo')}
                                        {/if}
                                        {form_dropdown('ativo', $options, $situacao, ['id' => 'ativo', 'class' => 'form-control'])}

                                    </div>
                                    <div class="col-lg-6  mb-3">
                                        <label class="form-label">CPF</label>
                                        {if (!empty($usuario))}
                                            {$cpf = $usuario['cpf']}
                                        {else}
                                            {$cpf = set_value('cpf')}
                                        {/if}
                                        <input class="form-control cpf" name="cpf" type="text"  value="{$cpf}">
                                    </div>
                                    {if (empty($id))}
                                    <div class="row col-lg-6 mb-3" id="change_pass">
                                        <div class="col-md-6">
                                            <label for="senha_1">Senha
                                                <span class="required">*</span>
                                                <span class="required" id="pass_match" style="display: none"> Senhas não conferem</span>
                                            </label>
                                            <input class="form-control" autocomplete="off" required id="password" type="password" name="password">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="senha_2">Confirmar Senha <span class="required">*</span></label>
                                            <input class="form-control" autocomplete="off" required id="password_confirmation" type="password" name="password_confirmation">
                                        </div>
                                    </div>
                                    {/if}
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" >Salvar</button>
                    {if (!empty($id))}
                    <a class="btn btn-primary" href="{$app_url}admin/usuarios/show/{$id}" >Voltar</a>
                    {else}
                    <a class="btn btn-primary" href="{$app_url}admin/usuarios" >Voltar</a>
                    {/if}
                    <hr class="my-5">
                {form_close()}
                <div class="row" style="max-width:920px">
<!--                    <div class="col-md">-->
<!--                        <article class="box mb-3 bg-light">-->
<!--                            <a class="btn float-end btn-light btn-sm" href="#">Reiniciar</a>-->
<!--                            <h6>Senha</h6>-->
<!--                            <small class="text-muted d-block" style="width:70%">Você pode reiniciar a senha do usuário aqui.</small>-->
<!--                        </article>-->
<!--                    </div>-->
                </div>
            </section>

        </div>
    </div>
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>

<script src="{$app_url}assets/admin/js/usuarios/form.js" type="text/javascript"></script>
