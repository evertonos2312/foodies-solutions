function changeCheck()
{
    // Get the checkbox
    let checkBox = document.getElementById("change_password");
    // Get the output text
    let text = document.getElementById("change_pass");

    // If the checkbox is checked, display the output text
    if (checkBox.checked === true) {
        text.style.display = "inline-flex";
        document.getElementById("password").required = true;
        document.getElementById("password_confirmation").required = true;
    } else {
        text.style.display = "none";
        document.getElementById("password").required = false;
        document.getElementById("password_confirmation").required = false;
    }
}

async function redefinirAdmin()
{
    var csrfName = $('.txt_csrfname').attr('name');
    var csrfHash = $('.txt_csrfname').val();

    let user_mail = $("#user_email").val();


    if (user_mail !== '') {
        let delay = 1000;
        $.ajax({
            url: app_url + 'password/recoverAdmin',
            method: 'post',
            data: {
                'email': user_mail,
                [csrfName]: csrfHash
            },
            beforeSend() {
                $("#send_pass").hide();
                $("#article_pass").hide();
                $(".loader").css('display', 'block');
                $("div.spanner").addClass("show");
                $("div.overlay").addClass("show");
            },
            success: function (response) {
                $('.txt_csrfname').val(response.token)
                setTimeout(function () {
                    $(".loader").css('display', 'none');
                    $("#article_pass").css('display', 'block');
                    if (response.status === 'success') {
                        $("#send_msg").css('display', 'block');
                        let responseMsg = document.getElementById('response_msg');
                        responseMsg.style.color = "#28a745"
                        responseMsg.textContent = 'E-mail enviado com sucesso.';

                    } else {
                        $("#send_msg").css('display', 'block');
                        let responseMsg = document.getElementById('response_msg');
                        let responseSmall = document.getElementById('response_small_txt');
                        responseMsg.style.color = "#dc3545"
                        responseMsg.textContent = 'Erro ao enviar e-mail';
                        responseSmall.textContent = 'Tente novamente mais tarde.';
                    }
                }, delay);
            },
            error: function () {
                $('.txt_csrfname').val(response.token)

            }
        });
    }
}