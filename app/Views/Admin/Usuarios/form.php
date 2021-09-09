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
                                        <input class="form-control" minlength="4" required autocomplete="off" name="nome" type="text" value="{$nome}">
                                    </div>
                                    {if (!empty($usuario) || !empty(set_value('id')))}
                                    <div class="col-2  mb-3">
                                        <label class="form-label">ID</label>
                                        {if (!empty($usuario))}
                                            {$id = $usuario['id']}
                                        {else}
                                            {$id = set_value('id')}
                                        {/if}
                                        <input class="form-control" required name="id" readonly type="text" value="{$id}">
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
                                        <input id="user_email" required class="form-control" autocomplete="off" name="email"  type="email" value="{$email}">
                                    </div>
                                    <div class="col-lg-6  mb-3">
                                        <label class="form-label">Telefone</label>
                                        {if (!empty($usuario))}
                                            {$telefone = $usuario['telefone']}
                                        {else}
                                            {$telefone = set_value('telefone')}
                                        {/if}
                                        <input class="form-control sp_celphones" required autocomplete="off" name="telefone" type="tel"  value="{$telefone}">
                                    </div>
                                    <div class="col-lg-3  mb-3">
                                        <label class="form-label">Perfil</label>
                                        {$options_perfil = [''=> 'Selecione', '1' => 'Administrador', '0' => 'Cliente']}
                                        {if (!empty($usuario))}
                                            {$perfil = $usuario['is_admin']}
                                        {else}
                                            {$perfil = set_value('is_admin')}
                                        {/if}
                                        {form_dropdown('is_admin', $options_perfil, $perfil, ['id' => 'is_admin', 'class' => 'form-control', 'required' => true])}
                                    </div>
                                    <div class="col-lg-3  mb-3">
                                        <label class="form-label">Status</label>
                                        {$options = [''=> 'Selecione', '1' => 'Ativo', '0' => 'Inativo']}
                                        {if (!empty($usuario))}
                                            {$situacao = $usuario['ativo']}
                                        {else}
                                            {$situacao = set_value('ativo')}
                                        {/if}
                                        {form_dropdown('ativo', $options, $situacao, ['id' => 'ativo', 'class' => 'form-control', 'required' => true])}

                                    </div>
                                    <div class="col-lg-6  mb-3">
                                        <label class="form-label">CPF</label>
                                        {if (!empty($usuario))}
                                            {$cpf = $usuario['cpf']}
                                        {else}
                                            {$cpf = set_value('cpf')}
                                        {/if}
                                        <input class="form-control cpf" required autocomplete="off" name="cpf" type="text"  value="{$cpf}">
                                    </div>
                                    {if (empty($id))}
                                    <div class="col-lg-6 mb-3">
                                        <label for="password">Senha
                                            <span class="required">*</span>
                                        </label>
                                        <input class="form-control" required autocomplete="off" required id="password" type="password" name="password">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="password_confirmation">Confirmar Senha <span class="required">*</span></label>
                                        <input class="form-control" required autocomplete="off" required id="password_confirmation" type="password" name="password_confirmation">
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
                {if (!empty($id) AND ($auth_user['id'] == $id))}
                <div class="row" style="max-width:920px">
                    <div class="col-md">
                        <article id="article_pass" class="box mb-3 bg-light">
                        <div id="send_pass">
                            <button class="btn float-end btn-light btn-sm" onclick="redefinirAdmin()" >Redefinir</button>
                            <h6>Senha</h6>
                            <small class="text-muted d-block" style="width:70%">Você receberá um email com instruções para alterar sua senha.</small>
                        </div>
                        <div id="send_msg" style="display: none">
                            <h6 id="response_msg"></h6>
                            <small id="response_small_txt" class="text-muted d-block" style="width:70%">Você receberá um email com instruções para alterar sua senha.</small>
                        </div>

                        </article>
                        <div class="loader">Carregando...</div>
                    </div>
                </div>
                {/if}
                <input type="hidden" class="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
            </section>

        </div>
    </div>
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>

<script src="{$app_url}assets/admin/js/usuarios/form.js" type="text/javascript"></script>
