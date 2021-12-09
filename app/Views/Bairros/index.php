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
        <div class="row" id="bairros">
            <div class="col-md-12 col-xs-12">
                <h2 class="section-title">{$title}</h2>
            </div>
            {foreach $bairros as $bairro}
                <div class="col-md-3">
                     <div class="panel panel-default">
                         <div class="panel-heading panel-food">{$bairro['nome']}</div>
                         <div class="panel-body fonte-food">Taxa de entrega: R$ {number_format($bairro['valor_entrega'], 2)}</div>
                     </div>
                </div>
            {/foreach}
        </div>
    </div>
    <!-- end product -->
</div>

<script>
    $(document).ready(function (){
        window.location.hash = '#bairros';
    });
</script>


