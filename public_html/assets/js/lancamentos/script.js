function lancamentosDelete(lancamento_id, lancamento_nome)
{
    let csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
    let csrfHash = $('.txt_csrfname').val(); // CSRF hash

    let id_lancamento = lancamento_id;
    Swal.fire({
        title: 'Deletar lançamento - ' + lancamento_nome + '?',
        text: "Essa ação não pode ser revertida!",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url+'lancamento/delete',
                method: 'post',
                data: {
                    'ctg_id' : id_lancamento,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(response){
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if (response.status === 'success' && !!response.detail.id) {
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Categoria excluída com sucesso!',
                            icon: 'success'
                        }).then(function(){
                            location.reload();
                        });
                        
                    }
                },
                error: function(response){
                    Swal.close();
                    Swal.fire({
                        title: 'Ops! Aconteceu algo de errado',
                        text: 'Não foi possível excluir esta categoria.',
                        icon: 'error',
                    });
                }
            });
        }
      })
}