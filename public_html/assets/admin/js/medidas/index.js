$(function () {
    $("#pesquisa_query").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: app_url + 'admin/medidas/procurar',
                data: {
                    'term': request.term,
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    if (data.length < 1) {
                        var data = [
                            {
                                label: 'Medida não encontrada',
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
                window.location.href = app_url + 'admin/medidas/show/' + ui.item.id;
            }
        }
    })
});

function excluirMedida(medida_id, medida_nome)
{
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    let id_medida = medida_id;
    Swal.fire({
        title: 'Deletar medida - ' + medida_nome + '?',
        text: "Essa ação não pode ser revertida!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url + 'admin/medidas/excluir',
                method: 'post',
                data: {
                    'medida_id': id_medida,
                    [csrfName]: csrfHash
                },
                success: function (response) {
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if (response.status === 'success' && !!response.detail.id) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Medida excluído com sucesso!',
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
                        text: 'Não foi possível excluir este extra',
                        icon: 'error',
                        timer: 1800,
                        timerProgressBar: true,
                    });
                }
            });
        }
    })
}