<!DOCTYPE HTML>
<html lang="en">
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
    <script src="{$app_url}assets/admin/js/bootstrap.bundle.min.js"></script>





    <script type="text/javascript">
        const app_url = '{$app_url}';
    </script>

</head>
<body>

<b class="screen-overlay"></b>

<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="page-index-1.html" class="brand-wrap">
            <img id="nav-icon" src="" height="46" class="logo" alt="Pizza Planet">
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i> </button>
        </div>
    </div> <!-- aside-top.// -->

    <nav>
        <ul class="menu-aside">
            <li class="menu-item active">
                <a class="menu-link" href="{$app_url}admin/home"> <i class="icon material-icons md-home"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="menu-item has-submenu">
                <a class="menu-link" href="#"> <i class="icon material-icons md-shopping_bag"></i>
                    <span class="text">Produtos</span>
                </a>
                <div class="submenu">
                    <a href="#">Lista de produtos</a>
                    <a href="#">Categorias</a>
                </div>
            </li>
            <li class="menu-item has-submenu">
                <a class="menu-link" href="page-orders-1.html"> <i class="icon material-icons md-shopping_cart"></i>
                    <span class="text">Pedidos</span>
                </a>
                <div class="submenu">
                    <a href="">Lista de pedidos</a>
                    <a href="">Detalhes de pedidos</a>
                </div>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="{$app_url}admin/usuarios"> <i class="icon material-icons md-people"></i>
                    <span class="text">Usuários</span>
                </a>
            </li>
            <li class="menu-item has-submenu">
                <a class="menu-link" href=""> <i class="icon material-icons md-store"></i>
                    <span class="text">Entregadores</span>
                </a>
                <div class="submenu">
                    <a href="">Lista de entregadores</a>
                </div>
            </li>

            <li class="menu-item has-submenu">
                <a class="menu-link" href="#"> <i class="icon material-icons md-person"></i>
                    <span class="text">Minha Conta</span>
                </a>
                <div class="submenu">
                    <a href="">Detalhes</a>
                </div>
            </li>
        </ul>
    </nav>
</aside>

<main class="main-wrap">
    <header class="main-header navbar">
        <div class="col-search">
            <form class="searchform">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Pesquise aqui...">
                    <button class="btn btn-light bg" type="button"> <i class="material-icons md-search"></i> </button>
                </div>
            </form>
        </div>
        <div class="col-nav">
            <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i class="md-28 material-icons md-menu"></i> </button>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn-icon" onclick="darkmode(this)" title="Dark mode" href="#"> <i class="material-icons md-nights_stay"></i> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-icon" href="#"> <i class="material-icons md-notifications_active"></i> </a>
                </li>
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#"> <img class="img-xs rounded-circle" src="{$app_url}assets/admin/images/people/avatar1.jpg" alt="User"></a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">Meu perfil</a>
                        <a class="dropdown-item text-danger" href="#">Sair</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <section class="content-main">
        {$content}
    </section> <!-- content-main end// -->
</main>
<script type="text/javascript">
    if(localStorage.getItem("darkmode")){
        var body_el = document.body;
        body_el.className += 'dark';
        $("#nav-icon").attr("src",app_url+"assets/admin/images/pizza-planet-branco.png");
    } else {
        $("#nav-icon").attr("src",app_url+"assets/admin/images/pizza-planet.png");
    }

</script>
<!-- Custom JS -->
<script src="{$app_url}assets/admin/js/script.js?v=1.0" type="text/javascript"></script>