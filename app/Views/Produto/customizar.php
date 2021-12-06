<link href="{$app_url}src/assets/css/produto.css" type="text/css" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
        {if ($msg)}
        <div class="alert {if ($msg_type)}{$msg_type}{else}alert-danger{/if} alert-dismissible" role="alert">
            <button type="button" class="{if ($msg_type)}{$msg_type}{else}alert-danger{/if} close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span>&nbsp;</span>
            <ul>
            {foreach $msg as $err}
            <li>{$err}</li>
            {/foreach}

            </ul>
        </div>
        {/if}
        <div class="row">

            <h2 class="name" style="margin-bottom: 2em">
                {$title}
            </h2>

            {form_open('carrinho/especial', ['csrf_id' => 'txt_csrfname'])}
            <div class="col-md-6" style="margin-bottom: 2em">
                <div class="card center-block" id="imagemPrimeiroProduto" style="width: 18rem; min-height: 224px" >
                    <img class="card-img-top" src="{$app_url}src/assets/img/pizza_thinking.png" width="200" alt="Escolha o produto" />
                </div>

                <label for="primeira_metade">Escolha a primeira metade do produto</label>
                <select name="primeira_metade" class="form-control" id="primeira_metade">
                    <option value="">Escolha seu produto...</option>
                    {foreach $opcoes as $opcao}
                    <option value="{$opcao['id']}">{$opcao['nome']}</option>
                    {/foreach}
                </select>
            </div>
            <div class="col-md-6" style="margin-bottom: 2em">
                <div class="card center-block" id="imagemSegundoProduto" style="width: 18rem; min-height: 224px">
                    <img class="card-img-top" src="{$app_url}src/assets/img/pizza_thinking.png" width="200" alt="Escolha o produto" />
                </div>
                <label for="segunda_metade">Escolha a segunda metade</label>
                <select name="segunda_metade" class="form-control" id="segunda_metade">

                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="valor_produto" id="valor_produto_customizado">

                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 3em; margin-bottom: 3em;">
            <div style="display: none;" id="div_tamanho" class="col-md-6">
                <label for="tamanho">Tamanho do produto</label>
                <select name="tamanho" id="tamanho" class="form-control">

                </select>
            </div>
            <div class="col-md-6">
                <div id="boxInfoExtras" style="display: none">
                    <label for="">Extras</label>
                    <div id="radio" class="radio">

                    </div>
                    <div class="loader">Carregando...</div>
                </div>

            </div>
        </div>
        <div>
            <input type="hidden" name="extra_id" id="extra_id" value="">
        </div>
        <div class="row" style="margin-top: 30px">
            <div class="col-sm-4 custom-flex">
                {if $check_expediente}
                <input type="submit" id="btn-adiciona" class="btn btn-success" value="Adicionar ao carrinho">
                {else}
                <span>Estamos fechados agora, volte mais tarde e confira nossas delícias.</span>
                {/if}
            </div>
            <div class="col-sm-4 custom-flex">
                <a href="{$app_url}produto/detalhes/{$produto['slug']}" class="btn btn-info" >Voltar</a>
            </div>
        </div>
        {form_close()}
    </div>
    <!-- end product -->
</div>
<script>
    let categoria_id = '{$produto.categoria_id}';
</script>
<script src="{$app_url}src/assets/js/produto/customizar.js"></script>
