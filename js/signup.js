function validatePwd_Signup() {
    $("#sign_secondPwd").keyup(function () {
        var pwd = $("#sign_password").val();
        if (pwd !== this.value) {
            $("#signup_button").attr("disabled", true);
            $("#signup_button").css("background-color", "gray");
            $("#error_message").show();

        } else {
            $("#error_message").hide();
            $("#signup_button").attr("disabled", false);
            $("#signup_button").css("background-color", "red");
        }
    });

    $("#sign_password").keyup(function () {
        var pwd = $("#sign_secondPwd").val();
        if (pwd !== this.value) {
            $("#signup_button").attr("disabled", true);
            $("#signup_button").css("background-color", "gray");
            $("#error_message").show();

        } else {
            $("#error_message").hide();
            $("#signup_button").attr("disabled", false);
            $("#signup_button").css("background-color", "red");
        }
    });
}

$(document).ready(function () {
    validatePwd_Signup();
});