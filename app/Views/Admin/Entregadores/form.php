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
                {form_open("admin/entregadores/salvar", 'enctype="multipart/form-data"')}
                        <div class="col-lg-12 custom-body">
                            <div class="row gx-3">
                                <div class="col-4">
                                    <label class="form-label">Nome entregador</label>
                                    {if (!empty($entregador))}
                                        {$nome = $entregador['nome']}
                                    {else}
                                        {$nome = set_value('nome')}
                                    {/if}
                                    <input class="form-control"  autocomplete="off" name="nome" type="text" value="{$nome}">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Telefone</label>
                                    {if (!empty($entregador))}
                                    {$telefone = $entregador['telefone']}
                                    {else}
                                    {$telefone = set_value('telefone')}
                                    {/if}
                                    <input class="form-control phone_with_ddd"  autocomplete="off" name="telefone" type="text" value="{$telefone}">
                                </div>

                                <div class="col-lg-2 ">
                                    <label class="form-label">Status</label>
                                    {$options = [''=> 'Selecione', '1' => 'Ativo', '0' => 'Inativo']}
                                    {if (!empty($entregador))}
                                    {$situacao = $entregador['ativo']}
                                    {else}
                                    {$situacao = set_value('ativo')}
                                    {/if}
                                    {form_dropdown('ativo', $options, $situacao, ['id' => 'ativo', 'class' => 'form-control'])}
                                </div>
                                {if (!empty($entregador) || !empty(set_value('id')))}
                                <div class="col-2">
                                    <label class="form-label">ID</label>
                                    {if (!empty($entregador))}
                                        {$id = $entregador['id']}
                                    {else}
                                        {$id = set_value('id')}
                                    {/if}
                                    <input class="form-control" name="id" readonly type="text" value="{$id}">
                                    <input class="form-control" name="id_hidden" readonly type="hidden" value="{$id}">
                                </div>
                                {/if}
                                <div class="row">
                                    <div class="col-3">
                                        <label class="form-label">CNH</label>
                                        {if (!empty($entregador))}
                                        {$cnh = $entregador['cnh']}
                                        {else}
                                        {$cnh = set_value('cnh')}
                                        {/if}
                                        <input class="form-control cnh"  autocomplete="off" name="cnh" type="text" value="{$cnh}">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">CPF</label>
                                        {if (!empty($entregador))}
                                        {$cpf = $entregador['cpf']}
                                        {else}
                                        {$cpf = set_value('cpf')}
                                        {/if}
                                        <input class="form-control cpf"  autocomplete="off" name="cpf" type="text" value="{$cpf}">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Veículo</label>
                                        {if (!empty($entregador))}
                                        {$veiculo = $entregador['veiculo']}
                                        {else}
                                        {$veiculo = set_value('veiculo')}
                                        {/if}
                                        <input class="form-control"  autocomplete="off" name="veiculo" type="text" value="{$veiculo}">
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Placa</label>
                                        {if (!empty($entregador))}
                                        {$placa= $entregador['placa']}
                                        {else}
                                        {$placa= set_value('placa')}
                                        {/if}
                                        <input class="form-control placa"  autocomplete="off" name="placa" type="text" value="{$placa}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Endereço</label>
                                        {if (!empty($entregador))}
                                        {$endereco= $entregador['endereco']}
                                        {else}
                                        {$endereco= set_value('endereco')}
                                        {/if}
                                        <input class="form-control"  autocomplete="off" name="endereco" type="text" value="{$endereco}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 custom-card">
                                <label class="form-label" for=""></label>
                                <div class="card" style="width: 18rem;">
                                    {if !empty($entregador['imagem'])}
                                        <img id="imgProduto" src="{$app_url}uploads/imagens/entregadores/{$entregador['imagem']}" class="card-img-top" alt="{$entregador['nome']}">
                                    {else}
                                    <img id="imgProduto"  src="{$app_url}assets/imagens/sem_foto.jpg" class="card-img-top" alt="Entregador sem imagem">
                                    {/if}
                                    <div class="form-group">
                                        <input type="file" id="img" name="imagem" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Carregar Imagem">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button"><i class="fas fa-upload"></i></button>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <br>
                    <button class="btn btn-primary" type="submit" >Salvar</button>
                    {if (!empty($id))}
                    <a class="btn btn-primary" href="{$app_url}admin/entregadores/show/{$id}" >Voltar</a>
                    {else}
                    <a class="btn btn-primary" href="{$app_url}admin/entregadores" >Voltar</a>
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

<script src="{$app_url}assets/admin/js/produtos/form.js" type="text/javascript"></script>
<script>

    (function($) {
        'use strict';
        $(function() {
            $('.file-upload-browse').on('click', function() {
                var file = $(this).parent().parent().parent().find('.file-upload-default');
                file.trigger('click');
            });
            $('.file-upload-default').on('change', function() {
                $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
            });
        });
    })(jQuery);
    img.onchange = evt => {
        const [file] = img.files
        if (file) {
            imgProduto.src = URL.createObjectURL(file)
        }
    }
</script>