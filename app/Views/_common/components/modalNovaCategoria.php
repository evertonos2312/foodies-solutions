<div class="modal fade" id="modalNovaCategoria" tabindex="-1" role="dialog" aria-labelledby="modalNovaCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="descricao_nova_categoria">Categoria</label>
                    <input type="text" name="descricao_nova_categoria" id="descricao_nova_categoria" required class="form-control">
                    <div id="erro_descricao"></div>
                </div>
                <div class="form-group">
                    <label for="tipo_nova_categoria">Tipo</label>
                    {form_dropdown('tipo_nova_categoria', ['' => 'Selecione', 'd' => 'Despesa', 'r' => 'Receita'], null, "id='tipo_nova_categoria' class='form-control' required")}
                    <div id="erro_tipo"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary"  onclick="salvaNovaCategoria()">Salvar</button>
            </div>

        </div>
    </div>
</div>