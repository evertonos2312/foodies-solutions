<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Money | {$title}</title>
    <link rel="stylesheet" href="{$app_url}assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{$app_url}assets/bootstrap/css/bootstrap.css.map">
    <link rel="stylesheet" href="{$app_url}assets/bootstrap/css/bootstrap.min.css.map">
    <link rel="stylesheet" href="{$app_url}assets/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{$app_url}assets/sweetalert/css/sweetalert2.min.css">
    <link rel="stylesheet" href="{$app_url}assets/datepicker/css/datepicker.css">
    <script src="{$app_url}assets/jquery/jquery-3.5.0.min.js"></script>
    <script src="{$app_url}assets/jquery.mask/jquery.mask.js"></script>
    <script src="{$app_url}assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="{$app_url}assets/bootstrap/js/bootstrap.min.js.map"></script>
    <script src="{$app_url}assets/sweetalert/js/sweetalert2.all.min.js"></script>
    <script src="{$app_url}assets/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="{$app_url}assets/datepicker/js/locales/bootstrap-datepicker.pt-BR.js"></script>
    <script src="{$app_url}assets/js/utils.js"></script>
    <style>
        body{
            padding-top: 80px;
        }
        .logo_site {
            height: 40px;
            margin: 0;
        }
    </style>
    <script type="text/javascript">
        var app_url = '{$app_url}';
    </script>
</head>
<header>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a href="{$app_url}" class="navbar-brand"><img src="{$app_url}assets/imagens/logo_php_exp_white.png" alt="Logo PHP Money" class="logo_site"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropDown" aria-controls="navbarNavDropDown" aria-expanded="false" aria-label="Toggle-navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropDown">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"> <a href="{$app_url}" class="nav-link">Home</a></li>
                    <li class="nav-item"> <a href="{$app_url}lancamento" class="nav-link">Lançamentos</a></li>
                    <li class="nav-item"> <a href="{$app_url}categoria" class="nav-link">Categorias</a></li>
                    <li class="nav-item"> <a href="{$app_url}orcamento" class="nav-link">Orçamentos</a></li>
                    <li class="nav-item"> <a href="{$app_url}relatorio" class="nav-link">Relatório</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Configurações
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a href="{$app_url}perfil" class="dropdown-item">Perfis</a>
                            <a href="{$app_url}usuario" class="dropdown-item">Usuários</a>
                        </div>
                    </li>
                    {if ($isLoggedIn)}
                        <li class="nav-item">
                            <a href="{$app_url}login/logout" class="nav-link">Sair</a>
                        </li>
                    {/if}
                </ul>
            </div>
        </nav>
    </div>

</header>
<body>
    <section class="container mt-5">
        {$content}
    </section>
</body>
    
</html>