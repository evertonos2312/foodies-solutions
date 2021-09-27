<link href="{$app_url}assets/admin/vendors/select2/select2.min.css" rel="stylesheet" type="text/css"/>
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
                {form_open("admin/produtos/cadastar_extras/{$produto['id']}")}
                        <div class="col-lg-12 custom-body">
                            <div class="row gx-3">
                                <div class="col-12">
                                    {if (!empty($produto['extra_id']))}
                                        {$extra_id = $produto.categoria_id}
                                    {else}
                                        {$extra_id = set_value('extra_id')}
                                    {/if}
                                    <label  class="form-label" for="categoria_id">Extras de produto (opcional)</label>
                                    {form_dropdown('extra_id', $extras, $extra_id,
                                        ['id' => 'extra_id', 'class' => 'form-control js-example-basic-single']
                                    )}
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
                                </div>
                            </div>
                        </div>
                    <br>
                    <button class="btn btn-primary" type="submit" >Inserir Extra</button>
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
        <div class="table-responsive">
            {if (!empty($produtosExtras))}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Extra</th>
                    <th scope="col">Preço</th>
                    <th scope="col" class="text-center"> Ações </th>
                </tr>
                </thead>
                <tbody>
                {foreach $produtosExtras as $produto_extra}
                <tr>
                    <td><b>{$produto_extra['extra']}</b></td>
                    <td>R$ {number_format($produto_extra['preco'], 2, ',', '.')}</td>
                    <td class="text-center">
                        <button class="btn btn-light text-danger" onclick="excluirProdutoExtra('{$produto_extra.id}', '{$produto_extra.extra}')">Excluir</button>
                    </td>
                </tr>
                {/foreach}


                </tbody>
                {else}
                <tr>
                    <td colspan="6">Nenhuma extra encontrado</td>
                </tr>
                {/if}
                <input type="hidden" class="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
            </table>
        </div>
        {if ($pager)}
            {$pager_links}
        {/if}
    </div>
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>
<script src="{$app_url}assets/admin/vendors/select2/select2.min.js"></script>
<script src="{$app_url}assets/admin/js/produtos/extras.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            placeholder: 'Digite o nome do extra...',
            allowClear: false,
            "language":{
                "noResults": function (){
                    return "Extra não encontrado&nbsp;&nbsp;<a class='btn btn-primary btn-sm' href="+app_url+"admin/extras/criar>Cadastrar</a>";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });
</script>

