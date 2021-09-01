<!DOCTYPE HTML>
<html lang="pt_br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Pizza Planet - {$title}</title>

    <link href="{$app_url}assets/admin/images/pizza_ico.png" rel="shortcut icon" type="image/x-icon">

    <link href="{$app_url}assets/admin/css/bootstrap.css?v=1.1" rel="stylesheet" type="text/css"/>
    <link href="{$app_url}assets/css/fontawesome-all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{$app_url}assets/sweetalert/css/sweetalert2.min.css">

    <!-- custom style -->
    <link href="{$app_url}assets/admin/css/ui.css?v=1.1" rel="stylesheet" type="text/css"/>
    <link href="{$app_url}assets/admin/css/responsive.css?v=1.1" rel="stylesheet" />

    <!-- iconfont -->
    <link rel="stylesheet" href="{$app_url}assets/admin/fonts/material-icon/css/round.css"/>
    <script src="{$app_url}assets/admin/js/jquery-3.5.0.min.js"></script>
    <script src="{$app_url}assets/admin/js/bootstrap.min.js"></script>
    <script src="{$app_url}assets/admin/js/bootstrap.min.js.map"></script>
    <script src="{$app_url}assets/js/fontawesome.min.js"></script>
    <script src="{$app_url}assets/sweetalert/js/sweetalert2.all.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{$app_url}assets/js/utils.js"></script>
    <script type="text/javascript">
        const app_url = '{$app_url}';
    </script>
    <style>
        .displayBadge{
            margin-top: 5%;
            display: none;
            text-align :center;
        }
    </style>

</head>
<body>

<b class="screen-overlay"></b>

<main>
    <header class="main-header navbar">
        <div class="col-brand">
            <a href="page-index-1.html" class="brand-wrap">
<!--                <img src="" height="46" class="logo" alt="Ecommerce dashboard template">-->
                Imagem pizza planet - Nav Bar
            </a>
        </div>
    </header>

    <section class="content-main">
        <div class="card shadow mx-auto" style="max-width: 380px; margin-top:100px;">
            <div class="card-body">
                <img id="nav-icon" src="{$app_url}assets/admin/images/pizza-planet.png" height="66" class="logo mb-4" alt="Pizza Planet">
                <h4 class="card-title mb-4">{$title}</h4>
                {if ($msg)}
                <div class="alert {if ($msg_type)}{$msg_type}{else}alert-danger{/if} alert-dismissible fade show" role="alert">
                    <i class="far fa-lightbulb mr-5"></i>
                    <span>&nbsp;</span>
                    {$msg}
                    <button type="button" class="{if ($msg_type)}{$msg_type}{else}alert-danger{/if} close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {/if}
                {form_open('password/processar', 'id="formReset"')}
                <input type="hidden" name="token" value="{$token}">
                    <div class="mb-3 ">
                        <label for="password" class="label-form">Nova senha</label>
                        <div id="show_hide_password" class="input-group custom-group">
                            <input class="form-control" required autocomplete="off" id="password" name="password" type="password">
                            <div class="input-group-addon">
                                <span class="show-hide"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <span id="StrengthDisp" class="badge displayBadge">Nível de segurança (Muito fraco)</span>
                    </div>
                    <div class="mb-3">
                        <span id="confirm_error" style="display: none; color: red"> *Senhas não conferem</span>
                        <label for="password_confirmation">Confirmação da nova senha</label>
                        <div id="show_hide_password_confirmation" class="input-group custom-group">
                            <input class="form-control" required id="password_confirmation" name="password_confirmation" type="password">
                            <div class="input-group-addon">
                                <span class="show-hide"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                            </div>

                        </div>
                    </div>


                    <div class="mb-4">
                        <button type="button" id="btnSubmit" onclick="validation()" class="btn btn-primary w-100"> Redefinir senha  </button>
                    </div>
                {form_close()}
            </div>
            <input type="hidden" class="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
            <div class="overlay"></div>
        </div>
    </section>
</main>
</body>
</html>
<script src="{$app_url}assets/js/password/script.js"></script>