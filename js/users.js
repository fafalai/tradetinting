function validatePwd_Users() {
    $("#fldConfirmPwd").keyup(function () {
        var pwd = $("#fldPwd").val();
        if (pwd === this.value && pwd !== "") {
            $("#error_message").hide();
            $("#btnSave").attr("disabled", false);
            $("#btnSave").css("background-color", "red");

        } else {
            $("#btnSave").attr("disabled", true);
            $("#btnSave").css("background-color", "gray");
            $("#error_message").show();

        }
    });
    $("#fldPwd").keyup(function () {
        var pwd = $("#fldConfirmPwd").val();
        if (pwd === this.value && pwd !== "") {
            $("#error_message").hide();
            $("#btnSave").attr("disabled", false);
            $("#btnSave").css("background-color", "red");

        } else {
            $("#btnSave").attr("disabled", true);
            $("#btnSave").css("background-color", "gray");
            $("#error_message").show();

        }
    });

    $("#fldPwd").keyup(function () {
        var pwd = $("#fldConfirmPwd").val();
        if (pwd === this.value && pwd !== "") {
            $("#error_message").hide();
            $("#btnSavePwd").attr("disabled", false);
            $("#btnSavePwd").css("background-color", "red");
        } else {
            $("#btnSavePwd").attr("disabled", true);
            $("#btnSavePwd").css("background-color", "gray");
            $("#error_message").show();
        }
    });

    $("#fldConfirmPwd").keyup(function () {
        var pwd = $("#fldPwd").val();
        if (pwd === this.value && pwd !== "") {
            $("#error_message").hide();
            $("#btnSavePwd").attr("disabled", false);
            $("#btnSavePwd").css("background-color", "red");
        } else {
            $("#btnSavePwd").attr("disabled", true);
            $("#btnSavePwd").css("background-color", "gray");
            $("#error_message").show();
        }
    });
}

$(document).ready(function () {
    validatePwd_Users();
})