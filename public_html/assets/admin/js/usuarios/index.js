$(function () {
    $("#pesquisa_query").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: app_url + 'admin/usuarios/procurar',
                data: {
                    'term': request.term,
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    if (data.length < 1) {
                        var data = [
                            {
                                label: 'Usuário não encontrado',
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
                window.location.href = app_url + 'admin/usuarios/show/' + ui.item.id;
            }
        }
    })
});

function excluirUsuario(usuario_id, usuario_nome)
{
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    let id_usuario = usuario_id;
    Swal.fire({
        title: 'Deletar usuário - ' + usuario_nome + '?',
        text: "Essa ação não pode ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url + 'admin/usuarios/excluir',
                method: 'post',
                data: {
                    'user_id': id_usuario,
                    [csrfName]: csrfHash
                },
                success: function (response) {
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if (response.status === 'success' && !!response.detail.id) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Usuário excluído com sucesso!',
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
                        text: 'Não foi possível excluir este usuário.',
                        icon: 'error',
                        timer: 1800,
                        timerProgressBar: true,
                    });
                }
            });
        }
    })
}