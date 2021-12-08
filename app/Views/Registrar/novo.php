<link href="{$app_url}src/assets/css/produto.css" type="text/css" rel="stylesheet" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />


<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil center-block" style="max-width: 40%">
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
        <div class="row" id="conta">
            <div class="col-md-12">
                {form_open('registrar/criar', ['id' => 'formNovo'])}

                <div class="form-group">
                    <label for="nome">Nome completo</label>
                    <input type="text" class="form-control" name="nome" required id="nome" value="{old('nome')}">
                </div>
                <div class="form-group">
                    <label for="email">E-mail válido</label>
                    <input type="email" class="form-control" name="email" required id="email" value="{old('email')}">
                </div>
                <div class="form-group">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input class="form-control sp_celphones" required id="telefone" name="telefone" type="text"  value="{old('telefone')}">

                </div>
                <div class="form-group">
                    <label for="cpf">CPF válido</label>
                    <input type="text" class="form-control cpf" name="cpf" required id="cpf" value="{old('cpf')}">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <div id="show_hide_password" class="input-group custom-group">
                        <input class="form-control" required autocomplete="off"   id="password" name="password" type="password">
                        <div class="input-group-addon">
                            <span class="show-hide"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <span id="StrengthDisp" class="badge displayBadge">Nível de segurança (Muito fraco)</span>
                </div>
                <div class="form-group">
                    <span id="confirm_error" style="display: none; color: red"> *Senhas não conferem</span>
                    <label for="password_confirmation">Confirmar senha</label>
                    <div id="show_hide_password_confirmation" class="input-group custom-group">
                        <input class="form-control" required id="password_confirmation" name="password_confirmation" type="password">
                        <div class="input-group-addon">
                            <span class="show-hide"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>

                    </div>
                </div>
                <button type="button" onclick="validation()" class="btn btn-block btn-food">Criar minha conta</button>

                {form_close()}
            </div>
        </div>
    </div>
    <!-- end product -->
</div>
<script>
    $(document).ready(function (){
        window.location.hash = '#conta';
        $('#email').val('Digite seu e-mail');
    });
    $('#email').click(function () {
        $("#email").val('');
    });

</script>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>
<script src="{$app_url}assets/js/password/script.js"></script>

