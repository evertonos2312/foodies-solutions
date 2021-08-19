function categoriasDelete(categoria_id, categoria_nome)
{
    var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

    let id_categoria = categoria_id;
    let name = categoria_nome;
    Swal.fire({
        title: 'Deletar Categoria - ' + name + '?',
        text: "Essa ação não pode ser revertida!",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url+'categoria/delete',
                method: 'post',
                data: {
                    'ctg_id' : id_categoria,
                    [csrfName]: csrfHash
                },
                dataType: 'json',
                success: function(response){
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if(response.status == 'success' && !!response.detail.id){
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Categoria excluída com suceso!',
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