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

</head>
<body>

<b class="screen-overlay"></b>

<main>
    <header class="main-header navbar">
        <div class="col-brand">
        </div>
    </header>

    <section class="content-main">
        <div class="card shadow mx-auto" style="max-width: 380px; margin-top:100px;">
            <div class="card-body">
                <img id="nav-icon" src="{$app_url}assets/admin/images/pizza-planet.png" height="66" class="logo mb-4" alt="Pizza Planet">
                <h4 class="card-title mb-4">Olá, seja bem vindo(a)!</h4>
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
                {form_open('login/criar')}
                    <div class="mb-3">
                        <input class="form-control" name="email" value="{old('email')}" placeholder="Digite o seu e-mail" type="email">
                    </div>
                    <div id="show_hide_password" class="mb-3 input-group custom-group">
                        <input class="form-control" required autocomplete="off" id="password" name="password" type="password">
                        <div class="input-group-addon">
                            <span class="show-hide"><i id="show_span" class="fa fa-eye-slash" aria-hidden="true"></i></span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <span  data-toggle="modal" data-target="#recoverModal" class="float-end anchor-link link-line">Esqueci a minha senha</span>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary w-100"> Entrar  </button>
                    </div>
                {form_close()}
                <p class="text-center mb-4">Não é cadastrado?  <a href="{$app_url}registrar">Criar conta</a></p>
            </div>
            <input type="hidden" class="txt_csrfname" name="{csrf_token()}" value="{csrf_hash()}" />
            <div class="overlay"></div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="recoverModal" tabindex="-1" role="dialog" aria-labelledby="recoverModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Recuperação de conta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span>Informe seu email que te ajudaremos a recuperar sua senha.</span>
                        <input id="user_email" type="email" class="form-control">
                        <span id="span_error" style="color: red; display: none"> *Digite um email valido.</span>
                    </div>
                    <div class="modal-footer d-lg-inline-flex justify-content-lg-between">
                        <div class=" g-recaptcha" data-callback="recaptchaCallback" data-sitekey="{$site_key}"></div>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button  type="button" onclick="recoverEmail()" disabled id="enviar" class="btn btn-primary" style="cursor: not-allowed">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="spanner">
        <div class="loader"></div>
        <p>Processando... por favor aguarde.</p>
    </div>
</main>
<script src="{$app_url}assets/js/login/script.js"></script>
</body>
</html>
<script>
    $(document).ready(function () {
        $("#show_hide_password span").on('click', function (event) {
            $("#show_span").toggleClass("fa-eye fa-eye-slash");
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
            }
        });
    });
</script>
