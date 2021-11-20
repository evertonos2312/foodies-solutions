function excluirProdutoExtra(produto_extra_id, produto_extra_nome)
{
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    let id_produto_extra = produto_extra_id;
    Swal.fire({
        title: 'Deletar extra - ' + produto_extra_nome + '?',
        text: "Essa ação não pode ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url + 'admin/produtos/excluir',
                method: 'post',
                data: {
                    'id_produto_extra': id_produto_extra,
                    [csrfName]: csrfHash
                },
                success: function (response) {
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if (response.status === 'success' && !!response.detail.id) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Extra excluído com sucesso!',
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
                        text: 'Não foi possível excluir este extra.',
                        icon: 'error',
                        timer: 1800,
                        timerProgressBar: true,
                    });
                }
            });
        }
    })
}