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
                {form_open("admin/produtos/salvar", 'enctype="multipart/form-data"')}
                        <div class="col-lg-12 custom-body">
                            <div class="row gx-3">
                                <div class="col-4">
                                    <label class="form-label">Nome produto</label>
                                    {if (!empty($produto))}
                                        {$nome = $produto['nome']}
                                    {else}
                                        {$nome = set_value('nome')}
                                    {/if}
                                    <input class="form-control"  autocomplete="off" name="nome" type="text" value="{$nome}">
                                </div>
                                <div class="col-4">
                                    {if (!empty($produto['categoria_id']))}
                                        {$categoria_id = $produto.categoria_id}
                                    {else}
                                        {$categoria_id = set_value('categoria_id')}
                                    {/if}
                                    <label  class="form-label" for="categoria_id">Categoria</label>
                                    {form_dropdown('categoria_id', $categorias, $categoria_id,
                                        ['id' => 'categoria_id', 'class' => 'form-control']
                                    )}
                                </div>
                                <div class="col-lg-2 ">
                                    <label class="form-label">Status</label>
                                    {$options = [''=> 'Selecione', '1' => 'Ativo', '0' => 'Inativo']}
                                    {if (!empty($produto))}
                                    {$situacao = $produto['ativo']}
                                    {else}
                                    {$situacao = set_value('ativo')}
                                    {/if}
                                    {form_dropdown('ativo', $options, $situacao, ['id' => 'ativo', 'class' => 'form-control'])}
                                </div>
                                {if (!empty($produto) || !empty(set_value('id')))}
                                <div class="col-2">
                                    <label class="form-label">ID</label>
                                    {if (!empty($produto))}
                                        {$id = $produto['id']}
                                    {else}
                                        {$id = set_value('id')}
                                    {/if}
                                    <input class="form-control" name="id" readonly type="text" value="{$id}">
                                    <input class="form-control" name="id_hidden" readonly type="hidden" value="{$id}">
                                </div>
                                {/if}
                                <div class="form-group col-md-12">
                                    {if (!empty($produto))}
                                        {$ingredientes = $produto['ingredientes']}
                                    {else}
                                        {$ingredientes = set_value('ingredientes')}
                                    {/if}
                                    <label for="ingredientes">Ingredientes</label>
                                    <textarea class="form-control" name="ingredientes" id="ingredientes" rows="3">{$ingredientes}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 custom-card">
                                <label class="form-label" for=""></label>
                                <div class="card" style="width: 18rem;">
                                    {if !empty($produto['imagem'])}
                                        <img id="imgProduto" src="{$app_url}uploads/imagens/produtos/{$produto['imagem']}" class="card-img-top" alt="{$produto['nome']}">
                                    {else}
                                    <img id="imgProduto"  src="{$app_url}assets/imagens/produto-sem-imagem.jpg" class="card-img-top" alt="Produto sem imagem">
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
                    <a class="btn btn-primary" href="{$app_url}admin/produtos/show/{$id}" >Voltar</a>
                    {else}
                    <a class="btn btn-primary" href="{$app_url}admin/produtos" >Voltar</a>
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