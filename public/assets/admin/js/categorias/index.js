$(function () {
    $("#pesquisa_query").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: app_url + 'admin/categorias/procurar',
                data: {
                    'term': request.term,
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    if (data.length < 1) {
                        var data = [
                            {
                                label: 'Categoria não encontrado',
                                value: -1
                        }
                        ];
                    }
                    response(data);
                },
            });
        },
        minLength: 3,
        select: function (event, ui) {
            if (ui.item.value === -1) {
                $(this).val("");
                return false;
            } else {
                window.location.href = app_url + 'admin/categorias/show/' + ui.item.id;
            }
        }
    })
});

function excluirCategoria(categoria_id, categoria_nome)
{
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    let id_categoria = categoria_id;
    Swal.fire({
        title: 'Deletar categoria - ' + categoria_nome + '?',
        text: "Essa ação não pode ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url + 'admin/categorias/excluir',
                method: 'post',
                data: {
                    'categoria_id': id_categoria,
                    [csrfName]: csrfHash
                },
                success: function (response) {
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if (response.status === 'success' && !!response.detail.id) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Categoria excluída com sucesso!',
                            icon: 'success',
                            timer: 1800,
                            timerProgressBar: true,
                            onClose: () => {
                                location.reload();
                            }
                        })
                    } else {
                        Swal.fire({
                            title: 'Ops! Aconteceu algo de errado',
                            text: response.msg_error,
                            icon: 'error',
                            timer: 1800,
                            timerProgressBar: true,
                        });
                    }
                },
                error: function (response) {
                    Swal.close();
                    Swal.fire({
                        title: 'Ops! Aconteceu algo de errado',
                        text: 'Não foi possível excluir esta categoria.',
                        icon: 'error',
                        timer: 1800,
                        timerProgressBar: true,
                    });
                }
            });
        }
    })
}