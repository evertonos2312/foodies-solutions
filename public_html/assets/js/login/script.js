function recaptchaCallback()
{
    $('#enviar').removeAttr('disabled');
    $('#enviar').css('cursor', 'pointer');
}

async function recoverEmail()
{
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();
    $("#span_error").css('display', 'none');

    let user_mail = $("#user_email").val();

    if (!isEmail(user_mail)) {
        $("#span_error").css('display', 'block');
        return false;
    }

    if (isEmail(user_mail)) {
        $('#recoverModal').modal('hide');
        $.ajax({
            url: app_url + 'password/recover',
            method: 'post',
            data: {
                'email': user_mail,
                'recaptcha': grecaptcha.getResponse(),
                [csrfName]: csrfHash
            },
            success: function (response) {
                $('.txt_csrfname').val(response.token)
                Swal.close();
                grecaptcha.reset();
                $("#user_email").val('');
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Sucesso!',
                        text: 'Caso esse seja um email valido, te ajudaremos a recuperar sua senha.',
                        icon: 'success',
                    })
                }
            },
            error: function () {
                $('.txt_csrfname').val(response.token)
                grecaptcha.reset();
                Swal.close();
                Swal.fire({
                    title: 'Ops! Aconteceu algo de errado',
                    text: 'Tente novamente mais tarde',
                    icon: 'error',
                    timer: 1800,
                    timerProgressBar: true,
                });
            }
        });
    }
}