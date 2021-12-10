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
                {form_open("admin/pedidos/atualizar", ['csrf_id' => 'txt_csrfname'])}
                <input type="hidden" name="codigo_pedido" value="{$pedido.codigo}">
                    <div class="form-check form-check-flat form-check-primary mb-4">
                        <label for="saiu_entrega" class="form-check-label">
                            {if $pedido.situacao == 1}
                            {$checked = 'checked'}
                            {else}
                            {$checked = ''}
                            {/if}
                            <input type="radio" id="saiu_entrega" class="form-check-input situacao" name="situacao" value="1" {$checked}> Saiu para entrega
                        </label>
                    </div>
                    <div id="box_entregador" class="form-group col-md-3 d-none mb-3">
                        {form_dropdown('entregador_id', $entregadores, $pedido['entregador_id'], ['id' => 'entregador_id', 'class' => 'form-control'])}
                    </div>
                    <div class="form-check form-check-flat form-check-primary mb-4">
                        <label class="form-check-label">
                            {if $pedido.situacao == 2}
                            {$checked = 'checked'}
                            {else}
                            {$checked = ''}
                            {/if}
                            <input type="radio"  class="form-check-input situacao" name="situacao" value="2" {$checked}> Pedido entregue
                        </label>
                    </div>
                    <div class="form-check form-check-flat form-check-primary mb-4">
                        <label class="form-check-label">
                            {if $pedido.situacao == 3}
                            {$checked = 'checked'}
                            {else}
                            {$checked = ''}
                            {/if}
                            <input type="radio" class="form-check-input situacao" name="situacao" value="3" {$checked}> Retirado no balcão
                        </label>
                    </div>
                    <div class="form-check form-check-flat form-check-primary mb-4">
                        <label class="form-check-label">
                            {if $pedido.situacao == 4}
                            {$checked = 'checked'}
                            {else}
                            {$checked = ''}
                            {/if}
                            <input type="radio" class="form-check-input situacao" name="situacao" value="4" {$checked}> Cancelado
                        </label>
                    </div>
                    <br>
                    <input class="btn btn-primary" id="btn-editar-pedido" type="submit" value="Salvar">
                    <a class="btn btn-primary" href="{$app_url}admin/pedidos/show/{$pedido['codigo']}" >Voltar</a>
                    <hr class="my-5">
                {form_close()}
            </section>
        </div>
    </div>
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>

<script src="{$app_url}assets/admin/js/pedidos/form.js" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        var entregador_id = $("#saiu_entrega").prop('checked');
        if(entregador_id) {
            $("#box_entregador").removeClass('d-none');
        }
    });
    $(".situacao").on('click', function () {
       var valor = $(this).val();
       if(valor == 1) {
           $("#box_entregador").removeClass('d-none');
       } else {
           $("#box_entregador").addClass('d-none');
       }
    });

    $("form").submit(function () {
        $(this).find(":submit").attr('disabled', 'disabled');
        $("#btn-editar-pedido").val('Processando..');
    });
</script>
