<link href="{$app_url}src/assets/css/produto.css" type="text/css" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em;min-height: 50px">
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
        {include file='Conta/sidebar.php'}
        <div class="row" id="conta">
            <div class="col-md-12 col-xs-12">
                <h2 class="section-title">{$title}</h2>
            </div>
            <div class="col-md-6 col-md-offset-3">
                {form_open('conta/processar')}
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div>
                            <label for="">Sua senha atual</label>
                            <input type="password" class="form-control" name="password">
                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Autenticar</button>
                        <a class="btn btn-default" href="{$app_url}conta/show">Cancelar</a>
                    </div>
                </div>
                {form_close()}
            </div>
        </div>
    </div>
    <!-- end product -->
</div>

<script>
    $(document).ready(function (){
        window.location.hash = '#conta';
    });
</script>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>

