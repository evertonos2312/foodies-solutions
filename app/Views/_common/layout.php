<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<!-- BEGIN head -->


<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

    <!-- Meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{$title}</title>

    <!-- Stylesheets -->
    <link href="{$app_url}src/assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all" />
    <link href="{$app_url}src/assets/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" media="all" />
    <link href="{$app_url}src/assets/css/fonts.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/slick.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/slick-theme.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/aos.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/scrolling-nav.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/bootstrap-datepicker.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/bootstrap-datetimepicker.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/touch-sideswipe.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/jquery.fancybox.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/main.css" type="text/css" rel="stylesheet" />
    <link href="{$app_url}src/assets/css/responsive.css" type="text/css" rel="stylesheet" />

    <!-- Favicon -->
    <link href="{$app_url}assets/admin/images/pizza_ico.png" rel="shortcut icon" type="image/x-icon">

</head>
<!-- END head -->

<!-- BEGIN body -->

<body data-spy="scroll" data-target=".navbar" data-offset="50">

<!-- BEGIN  Loading Section -->
<div class="loading-overlay">
    <div class="spinner">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- END Loading Section -->

<!-- BEGIN body wrapper -->
<div class="body-wrapper">

    <!-- Begin header-->
    <header id="header">

        <!-- BEGIN carousel -->
        <div id="main-carousel" class="carousel slide" data-ride="carousel">
            <div class="container pos_rel" style="min-height: 1vh !important;">

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#main-carousel" data-slide-to="1"></li>
                    <li data-target="#main-carousel" data-slide-to="2"></li>
                </ol>

                <!-- Controls -->
                <a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                </a>
                <a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">

                    <!-- Carousel items   -->
                    <div class="item active">
                        <div class="carousel-caption">
                            <div class="fadeUp item_img">
                                <img src="{$app_url}src/assets/img/photos/pizza.png" alt="sample" />
                                <div class="item_badge">
                                    <span class="badge_btext">- 20%</span>
                                </div>
                            </div>
                            <div class="fadeUp fade-slow item_details">
                                <h4 class="item_name">Pizza saborosa</h4>
                                <p class="item_info">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <div class="item_link_box">
                                    <a href="#reservation" class="item_link page-scroll">Peça agora</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="carousel-caption">
                            <div class="fadeUp item_img">
                                <img src="{$app_url}src/assets/img/photos/burger.png" alt="sample" />
                                <div class="item_badge">
                                    <span class="badge_btext">- 20%</span>
                                </div>
                            </div>
                            <div class="fadeUp fade-slow item_details">
                                <h4 class="item_name">Uma delícia</h4>
                                <p class="item_info">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <div class="item_link_box">
                                    <a href="#reservation" class="item_link page-scroll">Peça agora</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="carousel-caption">
                            <div class="fadeUp item_img">
                                <img src="{$app_url}src/assets/img/photos/pizza.png" alt="sample" />
                                <div class="item_badge">
                                    <span class="badge_btext">20%</span>
                                    <span class="badge_stext">OFF</span>
                                </div>
                            </div>
                            <div class="fadeUp fade-slow item_details">
                                <h4 class="item_name">Pizza saborosa</h4>
                                <p class="item_info">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <div class="item_link_box">
                                    <a href="#reservation" class="item_link page-scroll">Peça agora</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container -->
        </div>
        <!-- END carousel -->

        <!-- BEGIN navigation -->
        <div class="navigation">

            <div class="navbar-container" data-spy="affix" data-offset-top="400">
                <div class="container">

                    <div class="navbar_top hidden-xs">
                        <div class="top_addr">
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> São Paulo - Perdizes</span>
                            <span><i class="fa fa-phone" aria-hidden="true"></i> (11) 98658-6356</span>
                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> 18:00 - 23:00</span>
                        </div>
                    </div>
                    <!-- /.navbar_top -->

                    <!-- BEGIN navbar -->
                    <nav class="navbar">
                        <div id="navbar_content">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <div class="navbar-brand d-nav-flex">
                                    <img src="{$app_url}src/assets/img/logo.png" alt="logo" /> <span class="bg-white">Pizza Planet</span>
                                </div>
                                <a href="#cd-nav" class="cd-nav-trigger right_menu_icon">
                                    <span><i class="fa fa-bars" aria-hidden="true"></i></span>
                                </a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="navbar">
                                <div class="navbar-right">
                                    <ul class="nav navbar-nav">
                                        <li><a class="page-scroll" href="#header">Página Inicial</a></li>
                                        <li><a class="page-scroll" href="#menu">Cardápio</a></li>
                                        <li><a class="page-scroll" href="#footer">Entre em contato</a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.navbar-collapse -->
                        </div>
                    </nav>
                </div>
                <!-- END navbar -->
            </div>
            <!-- /.navbar-container -->
        </div>
        <!-- END navigation -->

    </header>
    <!-- End header -->
        {$content}

    <!--  Begin Footer  -->
    <footer id="footer">

        <!--    Contact    -->

        <!--    Google map, Social links    -->
        <div class="section" id="contact">
            <div id="googleMap"></div>
            <div class="footer_pos">
                <div class="container">
                    <div class="footer_content">
                        <div class="row">
                            <div class="col-sm-6 col-md-4">
                                <h4 class="footer_ttl footer_ttl_padd">sobre nós</h4>
                                <p class="footer_txt">Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has survived not only five centuries but also the leap into electronic typesetting. </p>
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <h4 class="footer_ttl footer_ttl_padd">expediente</h4>
                                <div class="footer_border">
                                    <div class="week_row clearfix">
                                        <div class="week_day">Segunda-feira</div>
                                        <div class="week_time text-right">Fechado</div>
                                    </div>
                                    <div class="week_row clearfix">
                                        <div class="week_day">Terça-feia</div>
                                        <div class="week_time">
                                            <span class="week_time_start">18h</span>
                                            <span class="week_time_node">-</span>
                                            <span class="week_time_end">23h</span>
                                        </div>
                                    </div>
                                    <div class="week_row clearfix">
                                        <div class="week_day">Quarta-feira</div>
                                        <div class="week_time">
                                            <span class="week_time_start">18h</span>
                                            <span class="week_time_node">-</span>
                                            <span class="week_time_end">23h</span>
                                        </div>

                                    </div>
                                    <div class="week_row clearfix">
                                        <div class="week_day">Quinta-feira</div>
                                        <div class="week_time">
                                            <span class="week_time_start">18h</span>
                                            <span class="week_time_node">-</span>
                                            <span class="week_time_end">23h</span>
                                        </div>

                                    </div>
                                    <div class="week_row clearfix">
                                        <div class="week_day">Sexta-feira</div>
                                        <div class="week_time">
                                            <span class="week_time_start">18h</span>
                                            <span class="week_time_node">-</span>
                                            <span class="week_time_end">23h</span>
                                        </div>

                                    </div>
                                    <div class="week_row clearfix">
                                        <div class="week_day">Sábado</div>
                                        <div class="week_time">
                                            <span class="week_time_start">17h</span>
                                            <span class="week_time_node">-</span>
                                            <span class="week_time_end">23h</span>
                                        </div>
                                    </div>
                                    <div class="week_row clearfix">
                                        <div class="week_day">Domingo</div>
                                        <div class="week_time">
                                            <span class="week_time_start">17h</span>
                                            <span class="week_time_node">-</span>
                                            <span class="week_time_end">23h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <h4 class="footer_ttl footer_ttl_padd">entre em contato</h4>
                                <div class="footer_border">
                                    <div class="footer_cnt">
                                        <i class="fa fa-map-marker"></i>
                                        <span>São Paulo - SP</span>
                                    </div>
                                    <div class="footer_cnt">
                                        <i class="fa fa-phone"></i>
                                        <span>(11) 98658-6356</span>
                                    </div>
                                    <div class="footer_cnt">
                                        <i class="fa fa-envelope"></i>
                                        <span>everton.oliveirasilva@outlook.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="copy_text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- End Footer -->

</div>
<!-- END body-wrapper -->


<!-- START mobile right burger menu -->

<nav class="cd-nav-container right_menu" id="cd-nav">
    <div class="header__open_menu">
        <a href="index-2.html" class="rmenu_logo" title="yagmurmebel.az">
            <img src="{$app_url}src/assets/img/logo.png" alt="logo" />
        </a>
    </div>
    <div class="right_menu_search">
        <form method="post">
            <input type="text" name="q" class="form-control search_input" value="" placeholder="Search anything">
            <button type="submit" class="search_icon"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <ul class="rmenu_list">
        <li><a class="page-scroll" href="#header">Home</a></li>
        <li><a class="page-scroll" href="#about_us">About</a></li>
        <li><a class="page-scroll" href="#menu">Menus</a></li>
        <li><a class="page-scroll" href="#gallery">Gallery</a></li>
        <li><a class="page-scroll" href="#reservation">Reservation</a></li>
        <li><a class="page-scroll" href="#footer">Contact</a></li>
    </ul>
    <div class="right_menu_addr top_addr">
        <span><i class="fa fa-map-marker" aria-hidden="true"></i> Your country, your city, 12345</span>
        <span><i class="fa fa-phone" aria-hidden="true"></i> 123 456 789</span>
        <span><i class="fa fa-clock-o" aria-hidden="true"></i> 11:00 - 21:00</span>
    </div>
</nav>

<div class="cd-overlay"></div>
<!-- /.cd-overlay -->


<!-- END mobile right burger menu -->

<!-- JavaScript -->
<script src="{$app_url}src/assets/js/jquery-2.1.1.min.js"></script>
<script src="{$app_url}src/assets/js/bootstrap.min.js"></script>
<script src="{$app_url}src/assets/js/jquery.mousewheel.min.js"></script>
<script src="{$app_url}src/assets/js/jquery.easing.min.js"></script>
<script src="{$app_url}src/assets/js/scrolling-nav.js"></script>
<script src="{$app_url}src/assets/js/aos.js"></script>
<script src="{$app_url}src/assets/js/slick.min.js"></script>
<script src="{$app_url}src/assets/js/jquery.touchSwipe.min.js"></script>
<script src="{$app_url}src/assets/js/moment.js"></script>
<script src="{$app_url}src/assets/js/bootstrap-datepicker.js"></script>
<script src="{$app_url}src/assets/js/bootstrap-datetimepicker.js"></script>
<script src="{$app_url}src/assets/js/jquery.fancybox.js"></script>
<script src="{$app_url}src/assets/js/loadMoreResults.js"></script>
<script src="{$app_url}src/assets/js/main.js"></script>

</body>

</html>
