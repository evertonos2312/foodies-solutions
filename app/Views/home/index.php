


    <!--    Menus   -->
    <div class="container section" id="menu" data-aos="fade-up" style="margin-top: 3em">
        <div class="title-block">
            <h1 class="section-title">Conheça as nossas delícias</h1>
        </div>

        <!--    Menus filter    -->
        <div class="menu_filter text-center">
            <ul class="list-unstyled list-inline d-inline-block">
                <li id="todas" class="item active">
                    <a href="javascript:;" class="filter-button" data-filter="todass">Todas</a>
                </li>
                {if !empty(categorias)}
                {foreach $categorias as $key => $categoria}
                <li class="item">
                    <a href="javascript:;" class="filter-button" data-filter="{$categoria.slug}">{$categoria.nome}</a>
                </li>
                {/foreach}
                {/if}
            </ul>
        </div>

        <!--    Menus items     -->
        <div id="menu_items">

            <div class="row">
            {foreach $produtos as $produto}
                <div class="col-sm-6 filter burger active {$produto.categoria_slug}">
                    <a href="{$app_url}uploads/imagens/produtos/{$produto.imagem}" class="block fancybox" data-fancybox-group="fancybox">
                        <div class="content">
                            <div class="filter_item_img">
                                <i class="fa fa-search-plus"></i>
                                <img src="{$app_url}uploads/imagens/produtos/{$produto.imagem}" alt="sample" />
                            </div>
                            <div class="info">
                                <div class="name">{$produto.nome}</div>
                                <div class="short">{word_limiter($produto.ingredientes, 5)}</div>
                                <span class="filter_item_price">A partir de R$ {number_format($produto['preco'], 2)}</span>
                            </div>
                        </div>
                    </a>
                </div>
            {/foreach}
            </div>

        </div>
    </div>


    <!-- End Sections -->

