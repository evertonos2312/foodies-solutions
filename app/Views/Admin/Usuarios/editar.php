<div class="content-header">
    <h2 class="content-title">{$title} </h2>
</div>
{$breadcrumbs}

<div class="card">
    <div class="card-body">
        <div class="col-lg-12">
            <section class="content-body p-xl-4">

                {include file="Admin/Usuarios/form.php"}




                <div class="row" style="max-width:920px">
                    <div class="col-md">
                        <article class="box mb-3 bg-light">
                            <a class="btn float-end btn-light btn-sm" href="#">Reiniciar</a>
                            <h6>Senha</h6>
                            <small class="text-muted d-block" style="width:70%">Você pode reiniciar a senha do usuário aqui.</small>
                        </article>
                    </div> <!-- col.// -->
                    <div class="col-md">
                        <article class="box mb-3 bg-light">
                            <button class="btn float-end btn-outline-danger btn-sm" >Excluir</button>
                            <h6>Remover conta</h6>
                            <small class="text-muted d-block" style="width:70%">Cuidado, exclusão permanente.</small>
                        </article>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<script src="{$app_url}assets/admin/vendors/mask/jquery.mask.min.js"></script>
<script src="{$app_url}assets/admin/vendors/mask/app.js"></script>