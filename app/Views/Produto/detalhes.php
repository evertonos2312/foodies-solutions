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
        <div class="row" id="produto">
            <div class="col-md-2 col-sm-12 col-xs-12">
                <div class="card" style="width: 18rem">
                    <img class="card-img-top" src="{$app_url}uploads/imagens/produtos/{$produto.imagem}" alt="sample" />
                </div>
            </div>

            {form_open('carrinho/adicionar')}
            <div class="col-md-9 col-md-offset-1 col-sm-12 col-xs-12">
                <h2 class="name">
                    {$produto['nome']}
                </h2>
                <hr />
                <h3 class="price-container">
                    <p class="small"> Qual o  tamanho da sua fome?</p>
                    {foreach $especificacoes as $especificacao}
                    <div class="radio">
                        <label style="font-size: 16px">
                            <input type="radio" class="especificacao" style="margin-top: 2px;" data-especificacao="{$especificacao['especificacao_id']}" name="produto[preco]" value="{$especificacao['preco']}">
                            {$especificacao['nome']}  R$&nbsp{number_format($especificacao['preco'], 2, ',', '.')}
                        </label>
                    </div>
                    {/foreach}

                    {if !empty($extras)}
                    <hr>
                    <p class="small"> Extras do produto</p>
                        <div class="radio">
                            <label style="font-size: 16px">
                                <input type="radio" style="margin-top: 2px;" class="extra" name="extra[preco]" checked> Nenhum extra
                            </label>
                        </div>

                        {foreach $extras as $extra}
                        <div class="radio">
                            <label style="font-size: 16px">
                                <input type="radio" class="extra" style="margin-top: 2px;" data-extra="{$extra['id_principal']}" name="extra[preco]" value="{$extra['preco']}">
                                {$extra['extra']}  R$&nbsp{number_format($extra['preco'], 2, ',', '.')}
                            </label>
                        </div>
                        {/foreach}
                    {/if}
                </h3>

                <div class="row" style="margin-top: 4rem">
                    <div class="col-md-4">
                        <label for="">Quantidade</label>
                        <input type="number" class="form-control" placeholder="Quantidade" name="produto[quantidade]" value="1" min="1" max="10" step="1" required>
                    </div>
                </div>
                <hr />
                <div class="description description-tabs">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" style="font-size: 16px" id="more-information">
                            <br />
                            <strong>É uma delícia</strong>
                            <p>
                                {$produto['ingredientes']}
                            </p>
                        </div>
                    </div>
                </div>
                <hr />
                <div>
                    <input type="hidden" name="produto[slug]" value="{$produto['slug']}">
                    <input type="hidden" id="especificacao_id" name="produto[especificacao_id]">
                    <input type="hidden" id="extra_id" name="produto[extra_id]">
                </div>
                <div class="row">
                    <div class="col-sm-4 custom-flex">
                        {if $check_expediente}
                        <input type="submit" id="btn-adiciona" class="btn btn-success btn-block" value="Adicionar ao carrinho">
                        {else}
                        <span>Estamos fechados agora, volte mais tarde e confira nossas delícias.</span>
                        {/if}
                    </div>
                    {foreach $especificacoes as $especificacao}
                        {if $especificacao['customizavel']}
                            <div class="col-sm-4 custom-flex">
                                <a href="{$app_url}/produto/customizar/{$produto['slug']}/#produto" class="btn btn-primary btn-block">Customizar</a>
                            </div>
                            {break}
                        {/if}
                    {/foreach}
                    <div class="col-sm-4 custom-flex">
                        <a href="{$app_url}#menu" class="btn btn-info btn-block" >Mais delícias</a>
                    </div>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
    <!-- end product -->
</div>

<script>
    $(document).ready(function (){
        window.location.hash = '#produto';
    });
</script>
<script>
    $(document).ready(function (){
       var especificacao_id ;

       if(!especificacao_id) {
           $("#btn-adiciona").prop("disabled", true);
           $("#btn-adiciona").prop("value", 'Escolha algum produto');
       } else {
           $("#btn-adiciona").prop("disabled", false);
           $("#btn-adiciona").prop("value", 'Adicionar ao carrinho');
       }
    });

    $(".especificacao").on('click', function () {
        especificacao_id = $(this).attr('data-especificacao');
        $("#especificacao_id").val(especificacao_id);
        $("#btn-adiciona").prop("disabled", false);
        $("#btn-adiciona").prop("value", 'Adicionar ao carrinho');
    });
    $(".extra").on('click', function () {
        var extra_id = $(this).attr('data-extra');
        $("#extra_id").val(extra_id);
    });
</script>

