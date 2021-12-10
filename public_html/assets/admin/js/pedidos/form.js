$("#btn-salvar").prop('disabled', true);

let id = $('name[id_hidden]').val()
if(id !== '') {
   $("#btn-salvar").prop('disabled', false);
}

$('[name=cep]').focusout(function (){
   var cep = $(this).val();
   var csrfName = $('#txt_csrfname').attr('name');
   var csrfHash = $('#txt_csrfname').val();

   $.ajax({
      type: 'post',
      url: app_url + 'admin/bairros/consultacep',
      dataType: 'json',
      data: {
         cep: cep,
         [csrfName]: csrfHash
      },
      beforeSend: function () {
        $("#cep").html('Consultando...');
        $('[name=nome]').val('');
        $('[name=cidade]').val('');
        $('[name=estado]').val('');

         $("#btn-salvar").prop('disabled', true);
      },
      success: function (response) {
         $('#txt_csrfname').val(response.token)
         if(response.status === 'success') {
            $("#cep").html('');
            $('[name=nome]').val(response.detail.endereco.bairro);
            $('[name=cidade]').val(response.detail.endereco.localidade);
            $('[name=uf]').val(response.detail.endereco.uf);

            $("#btn-salvar").prop('disabled', false);

         } else {
            $("#cep").html(response.msg_error);
         }
      },
      error: function () {
         $("#btn-salvar").prop('disabled', true);
         Swal.fire({
            title: 'Ops! Aconteceu algo de errado',
            text: 'Não foi possível consultar o cep. Entre em contato com o suporte técnico.',
            icon: 'error',
            timer: 1800,
            timerProgressBar: true,
         });
      }
   });
});
