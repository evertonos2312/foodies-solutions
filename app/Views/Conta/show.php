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
                <div class="panel panel-info">
                    <div class="panel-body">
                        <dl>
                            <dt>Nome completo</dt>
                            <dd>{$usuario['nome']}</dd>
                            <hr>
                            <dt>E-mail de acesso</dt>
                            <dd>{$usuario['email']}</dd>
                            <hr>
                            <dt>Telefone</dt>
                            <dd>{$usuario['telefone']}</dd>
                            <hr>
                            <dt>CPF</dt>
                            <dd>{$usuario['cpf']}</dd>
                            <hr>
                            <dt>Cliente desde</dt>
                            <dd>{$usuario.criado_em|date_format:"%d/%m/%Y"}</dd>

                        </dl>
                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-primary" href="{$app_url}conta/editar">Editar</a>
                        <a class="btn btn-danger" href="{$app_url}conta/editar">Alterar senha</a>
                    </div>
                </div>
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

