<!DOCTYPE HTML>
<html lang="pt_br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Pizza Planet - {$title}</title>

    <link href="{$app_url}assets/admin/images/pizza_ico.png" rel="shortcut icon" type="image/x-icon">

    <link href="{$app_url}assets/admin/css/bootstrap.css?v=1.1" rel="stylesheet" type="text/css"/>

    <!-- custom style -->
    <link href="{$app_url}assets/admin/css/ui.css?v=1.1" rel="stylesheet" type="text/css"/>
    <link href="{$app_url}assets/admin/css/responsive.css?v=1.1" rel="stylesheet" />

    <!-- iconfont -->
    <link rel="stylesheet" href="{$app_url}assets/admin/fonts/material-icon/css/round.css"/>
    <script src="{$app_url}assets/admin/js/jquery-3.5.0.min.js"></script>
    <script src="{$app_url}assets/admin/js/bootstrap.min.js"></script>
    <script src="{$app_url}assets/admin/js/bootstrap.min.js.map"></script>
    <script src="{$app_url}assets/js/fontawesome.min.js"></script>

    <script type="text/javascript">
        const app_url = '{$app_url}';
    </script>

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
                    <div class="mb-3">
                        <input class="form-control" name="password" placeholder="Digite a sua senha" type="password">
                    </div>

                    <div class="mb-3">
                        <a href="#" class="float-end">Forgot password?</a>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary w-100"> Entrar  </button>
                    </div>
                {form_close()}
                <p class="text-center mb-4">Não é cadastrado?  <a href="{$app_url}registrar">Criar conta</a></p>
            </div>
        </div>
    </section>
</main>
</body>
</html>