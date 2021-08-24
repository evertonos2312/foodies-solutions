{form_open("admin/usuarios/atualizar")}
<div class="row">
    <div class="col-lg-8">
        <div class="row gx-3">
                <div class="col-10  mb-3">
                    <label class="form-label">Nome completo</label>
                    <input class="form-control"  name="nome" type="text" value="{$usuario['nome']}">
                </div>
                <div class="col-2  mb-3">
                    <label class="form-label">ID</label>
                    <input class="form-control" name="id" readonly type="text" value="{$usuario['id']}">
                </div>
                <div class="col-lg-6  mb-3">
                    <label class="form-label">E-mail</label>
                    <input class="form-control" name="email"  type="email" value="{$usuario['email']}">
                </div>
                <div class="col-lg-6  mb-3">
                    <label class="form-label">Telefone</label>
                    <input class="form-control sp_celphones" name="telefone" type="tel"  value="{$usuario['telefone']}">
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

                    {if (!empty($errors['perfil']))}
                    <div class="alert alert-danger mt-2">{$errors['perfil']}</div>
                    {/if}
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

                    {if (!empty($errors['status']))}
                    <div class="alert alert-danger mt-2">{$errors['status']}</div>
                    {/if}
                </div>
                <div class="col-lg-6  mb-3">
                    <label class="form-label">CPF</label>
                    <input class="form-control cpf" name="cpf" type="text"  value="{$usuario['cpf']}">
                </div>
        </div>
    </div>
</div>
<br>
<button class="btn btn-primary" type="submit" >Salvar</button>
<a class="btn btn-primary" href="{$app_url}admin/usuarios/show/{$usuario['id']}" >Voltar</a>
<hr class="my-5">
{form_close()}
