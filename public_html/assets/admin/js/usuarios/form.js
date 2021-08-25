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