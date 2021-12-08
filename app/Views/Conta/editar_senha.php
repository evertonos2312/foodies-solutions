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
                {form_open('conta/atualizarsenha', ['id' => 'formReset'])}
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div>
                            <label for="">Sua senha atual</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        <div>
                            <label for="password">Nova senha</label>
                            <div id="show_hide_password" class="input-group custom-group">
                                <input class="form-control" required autocomplete="off"   id="password" name="password" type="password">
                                <div class="input-group-addon">
                                    <span class="show-hide"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <span id="StrengthDisp" class="badge displayBadge">Nível de segurança (Muito fraco)</span>
                        </div>
                        <div>
                            <span id="confirm_error" style="display: none; color: red"> *Senhas não conferem</span>
                            <label for="password_confirmation">Confirmar nova senha</label>
                            <div id="show_hide_password_confirmation" class="input-group custom-group">
                                <input class="form-control" required id="password_confirmation" name="password_confirmation" type="password">
                                <div class="input-group-addon">
                                    <span class="show-hide"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="button" onclick="validation()" class="btn btn-primary">Alterar senha</button>
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
<script src="{$app_url}assets/js/password/script.js"></script>

