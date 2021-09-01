let passOk = false;

function validation()
{
    var password = $("#password").val();
    var confirmPassword = $("#password_confirmation").val();
    if (password != confirmPassword) {
        passOk = false;
        $("#confirm_error").css('display', 'block');
        return false;
    } else {
        $("#confirm_error").css('display', 'none');
        passOk = true;
    }
    if (passOk) {
        $("#formReset").submit();
    }
}

// timeout before a callback is called

let timeout;

// traversing the DOM and getting the input and span using their IDs

let password = document.getElementById('password')
let strengthBadge = document.getElementById('StrengthDisp')

// The strong and weak password Regex pattern checker

let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')

function StrengthChecker(PasswordParameter)
{
    // We then change the badge's color and text based on the password strength

    if (strongPassword.test(PasswordParameter)) {
        passOk = true
        strengthBadge.style.backgroundColor = "#28a745"
        strengthBadge.textContent = 'Nível de segurança (Forte)'
    } else if (mediumPassword.test(PasswordParameter)) {
        passOk = true
        strengthBadge.style.backgroundColor = '#007bff'
        strengthBadge.textContent = 'Nível de segurança (OK)'
    } else {
        passOk = false
        strengthBadge.style.backgroundColor = '#dc3545'
        strengthBadge.textContent = 'Nível de segurança (Muito fraco)'
    }
}

// Adding an input event listener when a user types to the  password input

password.addEventListener("input", () => {

    //The badge is hidden by default, so we show it

    strengthBadge.style.display = 'inline-block'
    clearTimeout(timeout);

    //We then call the StrengChecker function as a callback then pass the typed password to it

    timeout = setTimeout(() => StrengthChecker(password.value), 500);

    //Incase a user clears the text, the badge is hidden again

    if (password.value.length !== 0) {
        strengthBadge.style.display != 'inline-block'
    } else {
        strengthBadge.style.display = 'none'
    }
});

$(document).ready(function () {
    $("#show_hide_password span").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });
    $("#show_hide_password_confirmation span").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password_confirmation input').attr("type") == "text") {
            $('#show_hide_password_confirmation input').attr('type', 'password');
            $('#show_hide_password_confirmation i').addClass("fa-eye-slash");
            $('#show_hide_password_confirmation i').removeClass("fa-eye");
        } else if ($('#show_hide_password_confirmation input').attr("type") == "password") {
            $('#show_hide_password_confirmation input').attr('type', 'text');
            $('#show_hide_password_confirmation i').removeClass("fa-eye-slash");
            $('#show_hide_password_confirmation i').addClass("fa-eye");
        }
    });
});