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
                {form_open("admin/formas/salvar")}
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row gx-3">
                                <div class="col-10  mb-3">
                                    <label class="form-label">Nome forma de pagamento</label>
                                    {if (!empty($forma))}
                                        {$nome = $forma['nome']}
                                    {else}
                                        {$nome = set_value('nome')}
                                    {/if}
                                    <input class="form-control"  autocomplete="off" name="nome" type="text" value="{$nome}">
                                </div>
                                {if (!empty($forma) || !empty(set_value('id')))}
                                <div class="col-2  mb-3">
                                    <label class="form-label">ID</label>
                                    {if (!empty($forma))}
                                        {$id = $forma['id']}
                                    {else}
                                        {$id = set_value('id')}
                                    {/if}
                                    <input class="form-control" name="id" readonly type="text" value="{$id}">
                                    <input class="form-control" name="id_hidden" readonly type="hidden" value="{$id}">
                                </div>
                                {/if}
                                <div class="col-lg-12  mb-3">
                                    <label class="form-label">Status</label>
                                    {$options = [''=> 'Selecione', '1' => 'Ativo', '0' => 'Inativo']}
                                    {if (!empty($forma))}
                                        {$situacao = $forma['ativo']}
                                    {else}
                                        {$situacao = set_value('ativo')}
                                    {/if}
                                    {form_dropdown('ativo', $options, $situacao, ['id' => 'ativo', 'class' => 'form-control'])}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-primary" type="submit" >Salvar</button>
                    {if (!empty($id))}
                    <a class="btn btn-primary" href="{$app_url}admin/formas/show/{$id}" >Voltar</a>
                    {else}
                    <a class="btn btn-primary" href="{$app_url}admin/formas" >Voltar</a>
                    {/if}
                    <hr class="my-5">
                {form_close()}
                <input type="hidden" class="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
            </section>
        </div>
    </div>
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>

<script src="{$app_url}assets/admin/js/formas/form.js" type="text/javascript"></script>
