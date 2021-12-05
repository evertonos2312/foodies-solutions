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
        <div class="row" style="min-height: 500px">

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
    $(document).ready(function (){
       $("#btn-adiciona").prop("disabled", true);
       $("#btn-adiciona").prop("value", 'Selecione um tamanho');

    });

    $("#primeira_metade").on('change', function () {
       var primeira_metade = $(this).val();
       var categoria_id = '{$produto.categoria_id}';
       $("#imagemPrimeiroProduto").html('<img class="card-img-top" src="{$app_url}src/assets/img/pizza_thinking.png" width="200" alt="Escolha o produto" />')

       if(primeira_metade) {
           var csrfName = $('#txt_csrfname').attr('name');
           var csrfHash = $('#txt_csrfname').val();
          $.ajax({
              type: 'get',
              url: app_url + 'produto/procurar',
              dataType: 'json',
              data: {
                primeira_metade: primeira_metade,
                categoria_id: categoria_id,
                [csrfName]: csrfHash
              },
              beforeSend: function (data){
                  $("#segunda_metade").html('');
              },
              success: function (data) {
                  $('#txt_csrfname').val(data.token)
                  if(data.status === 'success') {
                      if(data.detail.imagemPrimeiroProduto) {
                          $("#imagemPrimeiroProduto").html('<img class="card-img-top" width="200" src="{$app_url}uploads/imagens/produtos/'+data.detail.imagemPrimeiroProduto+'" alt="Escolha o produto" />')
                      }
                      if(data.detail.produtos) {
                          $("#segunda_metade").html('<option>Escolha a segunda metade</option');
                          $(data.detail.produtos).each(function () {
                             var option = $('<option/>');
                             option.attr('value', this.id).text(this.nome);
                             $("#segunda_metade").append(option);
                          });
                      }
                  } else {
                      $("#segunda_metade").html('<option>Não encontramos outras opções de customização</option');
                  }

              },
              error: function () {
                  $("#btn-adiciona").prop('disabled', true);
              },
          });
       } else {
           $("#segunda_metade").html('<option>Escolha a primeira metade</option');
       }
    });
    $("#segunda_metade").on('change', function (){
        var primeiro_produto_id $("#primeira_metade").val();
        var segundo_produto_id $(this).val();

        if(primeiro_produto_id && segundo_produto_id) {
            $.ajax({
                type: 'get',
                url: app_url + 'produto/exibetamanhos',
                dataType: 'json',
                data: {
                    primeiro_produto_id: primeiro_produto_id,
                    segundo_produto_id: segundo_produto_id,
                    [csrfName]: csrfHash
                },
                success: function (data) {
                    $('#txt_csrfname').val(data.token)
                    if(data.status === 'success') {


                    } else {

                    }

                },
                error: function () {
                    $("#btn-adiciona").prop('disabled', true);
                },
            });
        }

    });


</script>

