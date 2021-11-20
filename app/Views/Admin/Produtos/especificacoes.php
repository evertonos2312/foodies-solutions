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
                {form_open("admin/produtos/cadastar_especificacoes/{$produto['id']}")}
                        <div class="col-lg-12 custom-body">
                            <div class="row gx-3">
                                <div class="col-12">
                                    <label  class="form-label" for="categoria_id">Medidas de produto</label>
                                    {form_dropdown('medida_id', $medidas, null,
                                        ['id' => 'medida_id', 'class' => 'form-control js-example-basic-single']
                                    )}
                                </div>
                                <div class="col-4">
                                    <label for="preco" class="form-label">Preço</label>
                                    <input id="preco" class="money form-control"  autocomplete="off" name="preco" type="text" value="{old('preco')}">
                                </div>
                                <div class="col-4">
                                    <label for="customizavel" class="form-label">Produto customizável?</label>
                                    <select name="customizavel" class="form-control" id="customizavel">
                                        <option value="">Escolha...</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                    
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
                    <button class="btn btn-primary" type="submit" >Inserir Especificação</button>
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
            {if (!empty($produtosEspeficacoes))}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Medida</th>
                    <th scope="col">Preço</th>
                    <th scope="col">Customizável</th>
                    <th scope="col" class="text-center"> Ações </th>
                </tr>
                </thead>
                <tbody>
                {foreach $produtosEspeficacoes as $produto_especificacao}
                <tr>
                    <td><b>{$produto_especificacao['medida']}</b></td>
                    <td>R$ {number_format($produto_especificacao['preco'], 2, ',', '.')}</td>
                    <td>{$produto_especificacao['customizavel']}</td>
                    <td class="text-center">
                        <button class="btn btn-light text-danger" onclick="excluirEspecificacao('{$produto_especificacao.id}', '{$produto_especificacao.medida}')">Excluir</button>
                    </td>
                </tr>
                {/foreach}


                </tbody>
            {else}
            <tr>
                <td colspan="6">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Esse produto não possui especificações até o momento. Portando, ele <strong>não será exibido</strong> como opção de compra na área pública.</p>
                        <hr>
                        <p class="mb-0">Aproveite para cadastrar ao menos uma especificação para o produto <strong>{$produto['nome']}.</strong></p>
                    </div>
                </td>
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
<script src="{$app_url}assets/admin/js/produtos/especificacoes.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            placeholder: 'Digite o nome da medida...',
            allowClear: false,
            "language":{
                "noResults": function (){
                    return "Medida não encontrado&nbsp;&nbsp;<a class='btn btn-primary btn-sm' href="+app_url+"admin/medidas/criar>Cadastrar</a>";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });
</script>

