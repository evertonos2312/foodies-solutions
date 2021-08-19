function modalNovaCategoria(valor) {
    if (valor == 'n') {
        $('#modalNovaCategoria').modal('show');
        $('#modalNovaCategoria').on('shown.bs.modal', function (e) {
            $('#descricao_nova_categoria').focus();
            $(this).find('descricao_nova_categoria').trigger('reset');
            $('input[name="descricao_nova_categoria"]').val('');
            $("select#tipo_nova_categoria").val('');
        });
    }
}

function salvaNovaCategoria() {

    var csrfName = $('input[name="csrf_test_name"]').attr('name'); // CSRF Token name
    var csrfHash = $('input[name="csrf_test_name"]').val();


    var descricao = $('input[name="descricao_nova_categoria"]').val();
    var tipo = $("select#tipo_nova_categoria").val();
    if (descricao.val == '' || tipo == '') {
        Swal.fire('Preencha todos os campos antes de continuar');
        return false;
    }
    $.ajax({
        url: app_url + 'categoria/store',
        method: 'post',
        data: {
            'descricao': descricao,
            'tipo': tipo,
            [csrfName]: csrfHash
        },
        success: function (response) {
            $('input[name="csrf_test_name"]').val(response.token)
            $('#modalNovaCategoria').modal('hide');
            Swal.close();
            if (response.status == 'success' && !!response.detail.id) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Categoria criada com suceso!',
                    icon: 'success'
                }).then(function () {
                    $('#modalNovaCategoria').modal('hide');
                    carregaCategoriasDropdown(response.detail.id);
                });

            }
        },
        error: function (response) {
            $('#modalNovaCategoria').modal('hide');
            Swal.close();
            Swal.fire({
                title: 'Ops! Aconteceu algo de errado',
                text: 'Não foi possível criar esta categoria.',
                icon: 'error',
            });
        }
    });

}

function carregaCategoriasDropdown(id) {
    $('#spinnerLoading').show();
    var csrfName = $('input[name="csrf_test_name"]').attr('name'); // CSRF Token name
    var csrfHash = $('input[name="csrf_test_name"]').val();
    $selectCategorias = $('#categorias_id');
    $selectCategorias.empty();
    $.ajax({
        url: app_url + 'categoria/getCategoriaAjax',
        method: 'post',
        data: {
            [csrfName]: csrfHash
        },
        success: function (response) {
            $('input[name="csrf_test_name"]').val(response.token)
            if (response.status == 'success') {
                let options = response.detail.categorias
                $.each(options, function (i, item) {
                    $selectCategorias.append($('<option>', {
                        value: i,
                        text: item,
                        selected: (i == id),
                    }, '</option>'));
                });
                $optGroup = $("<optgroup label='---'>");
                $optGroup.append($('<option />').val('n').text('Nova categoria...'));
                $selectCategorias.append($optGroup);
                $('#spinnerLoading').hide();
            }
        },
        error: function (response) {

        }
    });
}