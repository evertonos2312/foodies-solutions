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
        <div class="row" id="produtos">
            {if !isset($carrinho)}
            <div class="text-center">
                <h2 class="text-center">Seu carrinho de compras está vazio</h2>
                <a href="{$app_url}#menu" class="btn btn-lg" style="background-color: #990100;color: #fff;margin-top: 2em" >Mais delícias</a>

            </div>
            {else}
            <div class="table-responsive">
                <h3>Resumo do carrinho de compras</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col">Remover</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Tamanho</th>
                        <th class="text-center" scope="col">Quantidade</th>
                        <th scope="col">Preço</th>
                        <th scope="col">Sub total</th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $carrinho as $produto}
                    <tr>
                        <th class="text-center" scope="row">
                            {form_open('carrinho/remover', ['class' => 'form-inline', 'csrf_id' => 'txt_csrfname'])}
                            <div class="form-group">
                                <input type="hidden" name="produto[slug]" value="{$produto['slug']}">
                            </div>
                            <button type="submit" class="btn btn-danger float-right">
                                <i class="fas fa-trash"></i>
                            </button>
                            {form_close()}
                        </th>
                        <td>{$produto['nome']}</td>
                        <td>{$produto['tamanho']}</td>
                        <td class="text-center">
                            {form_open('carrinho/atualizar', ['class' => 'form-inline'])}
                                <div class="form-group">
                                    <input type="number" name="produto[quantidade]" value="{$produto['quantidade']}" min="1" max="10" step="1">
                                    <input type="hidden" name="produto[slug]" value="{$produto['slug']}">
                                </div>
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fas fa-refresh"></i>
                            </button>
                            {form_close()}
                        </td>
                        <td>R$&nbsp;{$produto['preco']}</td>
                        <td>R$&nbsp;{number_format($produto['subtotal'],2,',', '.')}</td>
                    </tr>
                    {/foreach}
                    <tr>
                        <td class="text-right" colspan="5" style="font-weight: bold">Total produtos:</td>
                        <td colspan="5">R$&nbsp;{number_format($total,2, ',', '.')}</td>
                    </tr>
                    <tr>
                        <td class="text-right border-top-0" colspan="5" style="font-weight: bold">Taxa entrega:</td>
                        <td class="border-top-0" colspan="5" id="valor_entrega">Não calculado</td>
                    </tr>
                    <tr>
                        <td class="text-right border-top-0" colspan="5" style="font-weight: bold">Total pedido:</td>
                        <td class="border-top-0" colspan="5" id="total">R$&nbsp;{number_format($total,2, ',', '.')}</td>
                    </tr>

                    </tbody>
                </table>
                <div class="input-group col-md-4">
                    <input placeholder="Consulte a taxa de entrega" type="text" name="cep" id="cep_input" class="cep form-control">
                    <span class="input-group-btn">
                        <button id="cep_buscar" class="btn btn-default">Buscar</button>
                    </span>
                </div>
                    <div class="" id="cep">

                    </div>
            </div>
            <hr>
            <div class="col-md-12">
                <a href="{$app_url}carrinho/limpar" style="font-family: 'Montserrat-Bold', sans-serif;" class="btn btn-default">Limpar carrinho</a>
                <a href="{$app_url}#menu" style="font-family: 'Montserrat-Bold', sans-serif;" class="btn btn-primary">Mais delícias</a>
                <a href="{$app_url}checkout" class="btn btn-custom pull-right" >Finalizar pedido</a>
            </div>
            {/if}
        </div>
    </div>
    <!-- end product -->
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>
<script>
    {if !empty($total)}
    let total = "{number_format($total, 2, ',', '.')}"
    {else}
    total = '';
    {/if}
    $("#cep_buscar").on('click', function () {
        var cep = $("#cep_input").val()
        if(cep.length === 9) {
            var csrfName = $('#txt_csrfname').attr('name');
            var csrfHash = $('#txt_csrfname').val();
            $.ajax({
                type: 'post',
                url: app_url + 'carrinho/consultacep',
                dataType: 'json',
                data:{
                  cep: cep,
                    [csrfName]: csrfHash
                },
                beforeSend: function (){
                    $("#cep").html('Consultando..');
                    $("#cep_buscar").prop('disabled', true)
                    $("#cep_input").val('');
                },
                success: function (response){
                    $("#cep_buscar").prop('disabled', false)
                    $('#txt_csrfname').val(response.token)
                    if(response.status === 'success') {
                        $("#valor_entrega").html(response.detail.valor_entrega);
                        $("#total").html(response.detail.total);
                        $("#cep").html(response.detail.bairro);

                    } else {
                        $("#valor_entrega").html('Não calculado');
                        $("#cep").html('* '+response.msg_error);
                        $("#total").html('R$ '+total);
                    }
                },
                error: function () {
                    $("#cep_buscar").prop('disabled', false)
                    $("#cep").html('Não foi possível consultar a taxa de entrega..');
                }
            });
        }
    });
</script>

