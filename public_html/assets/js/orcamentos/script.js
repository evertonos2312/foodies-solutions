$(document).ready(function(){
    $('#valor').mask('000.000.000.000.000,00',{
        reverse: true
    });

});

function orcamentosDelete(orcamento_id, orcamento_nome)
{
    var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
    var csrfHash = $('.txt_csrfname').val(); // CSRF hash
    let id_categoria = orcamento_id;
    let name = orcamento_nome;
    Swal.fire({
        title: 'Deletar Orçamento - ' + name + '?',
        text: "Essa ação não pode ser revertida!",
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Confirmar',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: app_url+'orcamento/delete',
                method: 'post',
                data: {
                    'ctg_id' : id_categoria,
                    [csrfName]: csrfHash
                },
                success: function(response){
                    $('.txt_csrfname').val(response.token)
                    Swal.close();
                    if(response.status == 'success' && !!response.detail.id){
                        Swal.fire({
                            title: 'Sucesso!',
                            text: 'Orçamento excluído com suceso!',
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
                        text: 'Não foi possível excluir este orçamento.',
                        icon: 'error',
                    });
                }
            });
        }
      })
}