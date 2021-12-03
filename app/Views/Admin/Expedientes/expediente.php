<link href="{$app_url}assets/admin/vendors/auto-complete/jquery-ui.css" rel="stylesheet" type="text/css"/>
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
{$breadcrumbs}

<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            {form_open('admin/expedientes/expedientes', ['id' => 'form_expediente'])}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">Dia</th>
                    <th scope="col">Abertura</th>
                    <th scope="col">Fechamento</th>
                    <th scope="col">Situação</th>
                </tr>
                </thead>
                <tbody>
                    {foreach $expedientes as $expediente}
                    <tr>
                        <td class="form-group">
                            <input type="text" readonly name="dia_descricao[]" class="form-control" value="{$expediente['dia_descricao']}">
                        </td>
                        <td class="form-group">
                            <input type="time" required name="abertura[]" class="form-control" value="{$expediente['abertura']}">
                        </td>
                        <td class="form-group">
                            <input type="time" required name="fechamento[]" class="form-control" value="{$expediente['fechamento']}">
                        </td>
                        <td class="form-group">
                            {$options = ['1' => 'Aberto', '0' => 'Fechado']}
                            {form_dropdown('situacao[]', $options, $expediente['situacao'], ['id' => 'ativo', 'class' => 'form-control'])}
                        </td>

                    </tr>
                    {/foreach}
                    <tr>
                        <td colspan="4">
                            <button type="submit" class="btn btn-primary">
                                Salvar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            {form_close()}
        </div>
    </div>
</div>