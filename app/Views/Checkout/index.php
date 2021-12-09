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
            <div class="col-md-12 col-xs-12">
                <h2 class="section-title">{$title}</h2>
            </div>

            <div class="col-md-6">
                <ul class="list-group">
                    {foreach $carrinho as $produto}
                    <li class="list-group-item">
                        <div>
                            <h4>{ellipsize($produto['nome'], 60)}</h4>
                            <p class="text-muted">Quantidade: {$produto['quantidade']}</p>
                            <p class="text-muted">Preço: R$ {$produto['preco']}</p>
                            <p class="text-muted">Subtotal: R$ {number_format($produto['subtotal'], 2 , ',', '.')}</p>
                        </div>
                    </li>
                    {/foreach}
                    <li class="list-group-item">
                        <span>Total produtos:</span>
                        <strong>R$ {number_format($total, 2, ',','.')}</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Taxa de entrega:</span>
                        <strong id="valor_entrega" class="text-danger">Não calculado <small>(obrigatório)</small></strong>
                    </li>
                    <li class="list-group-item">
                        <span>Valor do pedido:</span>
                        <strong id="total">R$ {number_format($total, 2, ',','.')}</strong>
                    </li>
                    <li class="list-group-item">
                        <span>Endereço de entrega:</span>
                        <strong id="endereco" class="text-danger">Não calculado <small>(obrigatório)</small></strong>
                    </li>
                </ul>
                <a href="{$app_url}#menu" style="font-family: 'Montserrat-Bold', sans-serif;" class="btn btn-primary">Mais delícias</a>
                <a href="{$app_url}carrinho" style="font-family: 'Montserrat-Bold', sans-serif;" class="btn btn-default">Voltar para carrinho</a>
            </div>
            <div class="col-md-6">
                {form_open('checkout/processar', ['id' => 'form-checkout', 'csrf_id' => 'txt_csrfname'])}
                <p style="font-size: 18px; font-weight: bold">Escolha a forma de pagamento na entrega.</p>

                <div class="form-row">
                    {foreach $formas as $forma}
                    <div class="radio">
                        <label style="font-size: 16px">
                            <input id="forma" type="radio" style="margin-top: 2px;" data-forma="{$forma['id']}" class="forma" name="forma">{$forma['nome']}
                        </label>
                    </div>
                    {/foreach}
                </div>
                <hr>
                <div class="hidden" id="troco" style="margin-bottom: 15px">
                    <div style="margin-bottom: 5px">
                        <label for="">Precisa de troco?</label>
                        <input type="text" id="troco_para" name="checkout[troco_para]" class="form-control money" placeholder="Enviar troco para:">
                    </div>
                    <div>
                        <label for="">
                            <input type="checkbox" id="sem_troco" name="checkout[sem_troco]">
                            Não preciso de troco
                        </label>
                    </div>
                <hr>
                </div>
                <div class="input-group" style="margin-bottom: 15px">
                    <input placeholder="Consulte a taxa de entrega" type="text" name="cep" id="cep_input" class="cep form-control">
                    <span class="input-group-btn">
                        <button id="cep_buscar" class="btn btn-default">Buscar</button>
                    </span>
                </div>
                <div id="cep"></div>
                <div>
                    <label for="">Endereço:</label>
                    <input type="text" id="endereco_rua" class="form-control" name="checkout[endereco_rua]" readonly required>
                </div>
                <div>
                    <label for="">Número</label>
                    <input type="text" id="numero" class="form-control" name="checkout[numero]" required >
                </div>
                <div>
                    <label for="">Ponto de referência</label>
                    <input type="text" id="referencia" class="form-control" name="checkout[referencia]" required >
                </div>

                <div>
                    <input type="hidden" id="forma_id" name="checkout[forma_id]" placeholder="checkout[forma_id]">
                    <input type="hidden" id="bairro_slug" name="checkout[bairro_slug]" placeholder="checkout[bairro_slug]">
                </div>
                <div class="" style="margin-top: 25px">
                    {if $check_expediente}
                    <input type="submit" id="btn-checktout" class="btn btn-food btn-block" value="Antes, consulte a taxa de entrega">
                    <div class="col-md-12 col-md-offset-3">
                        <div class="loader ">Carregando...</div>
                    </div>
                    {else}
                    <span>Estamos fechados agora, volte mais tarde e confira nossas delícias.</span>
                    {/if}
                </div>
                {form_close()}
            </div>
            {if !empty($total)}
            <input type="hidden" id="total_value" value="{number_format($total, 2, ',', '.')}">
            {/if}
        </div>
    </div>
    <!-- end product -->
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>
<script>

    $(document).ready(function (){
        window.location.hash = '#produtos';
        document.getElementById('btn-checktout').disabled = true;
    });

    $(".forma").on('click', function () {
        var forma_id = $(this).attr('data-forma');
        $("#forma_id").val(forma_id)
        if(forma_id == 1) {
            $("#troco").removeClass('hidden');
        } else {
            $("#troco").addClass('hidden');
            $("#troco_para").val('');
            $("#sem_troco").prop('checked', false);
        }
    });

    $("#sem_troco").on('click', function () {
        if(this.checked) {
            $("#troco_para").prop('disabled', true);
            $("#troco_para").val('');
            $("#troco_para").attr('placeholder', 'Não preciso de troco');

        }else {
            $("#troco_para").prop('disabled', false);
            $("#troco_para").attr('placeholder', 'Enviar troco para:');
        }
    });




    $("#cep_buscar").on('click', function () {
        var cep = $("#cep_input").val()
        if(cep.length === 9) {
            var csrfName = $('#txt_csrfname').attr('name');
            var csrfHash = $('#txt_csrfname').val();
            $.ajax({
                type: 'post',
                url: app_url + 'checkout/consultacep',
                dataType: 'json',
                data:{
                  cep: cep,
                    [csrfName]: csrfHash
                },
                beforeSend: function (){
                    $("#cep").html('Consultando..');
                    $("#cep_buscar").prop('disabled', true)
                    $("#cep_input").val('');
                    document.getElementById('btn-checktout').disabled = true;
                    $("#btn-checktout").val('Consultando..');
                },
                success: function (response){
                    $("#cep_buscar").prop('disabled', false)
                    $('#txt_csrfname').val(response.token)
                    if(response.status === 'success') {
                        $("#valor_entrega").html(response.detail.valor_entrega);
                        $("#bairro_slug").val(response.detail.bairro_slug);
                        $("#cep").html(response.detail.bairro);

                        document.getElementById('btn-checktout').disabled = false;
                        $("#btn-checktout").val('Processar pedido');
                        if(response.detail.logradouro) {
                            $("#endereco_rua").val(response.detail.logradouro)

                        } else {
                            $("#endereco_rua").prop('readonly', false);
                        }

                        $("#endereco").html(response.detail.endereco);

                        $("#total").html(response.detail.total);

                    } else {
                        $("#valor_entrega").html('Não calculado');
                        $("#cep").html('* '+response.msg_error);
                        $("#total").html('R$ '+$("#total_value").val());
                        document.getElementById('btn-checktout').disabled = true;
                        $("#btn-checktout").val('Antes, consulte a taxa de entrega');
                    }
                },
                error: function () {
                    $("#cep_buscar").prop('disabled', false)
                    $("#cep").html('Não foi possível consultar a taxa de entrega..');
                }
            });
        }
    });
    $("form").submit(function () {
       $(this).find(":submit").attr('disabled', 'disabled');
        $("#btn-checktout").hide();
        $(".loader").css('display', 'block');
    });
    $(window).keydown(function (event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    })
</script>

