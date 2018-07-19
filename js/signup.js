function validatePwd_Signup() {
    $("#sign_secondPwd").keyup(function () {
        var pwd = $("#sign_password").val();
        if (pwd !== this.value) {
            $("#signup_noplan_button").attr("disabled", true);
            $("#signup_noplan_button").css("background-color", "gray");
            $("#signup_plan_button").attr("disabled", true);
            $("#signup_plan_button").css("background-color", "gray");
            $("#error_message").show();

        } else {
            $("#error_message").hide();
            $("#signup_noplan_button").attr("disabled", false);
            $("#signup_noplan_button").css("background-color", "red");
            $("#signup_plan_button").attr("disabled", false);
            $("#signup_plan_button").css("background-color", "red");
        }
    });

    $("#sign_password").keyup(function () {
        var pwd = $("#sign_secondPwd").val();
        if (pwd !== this.value) {
            $("#signup_noplan_button").attr("disabled", true);
            $("#signup_noplan_button").css("background-color", "gray");
            $("#signup_plan_button").attr("disabled", true);
            $("#signup_plan_button").css("background-color", "gray");
            $("#error_message").show();

        } else {
            $("#error_message").hide();
            $("#signup_noplan_button").attr("disabled", false);
            $("#signup_noplan_button").css("background-color", "red");
            $("#signup_plan_button").attr("disabled", false);
            $("#signup_plan_button").css("background-color", "red");
        }
    });
}


function planOption_Select() {
    $('#plan_options input[type=radio]').change(function () {
        //console.log ( $(this).val() ) 
        var plan = $(this).val();
        if (plan == 0) {
            document.getElementById('signup_noplan_button').style.display = 'block';
            document.getElementById('signup_plan_button').style.display = 'none';
        } else if (plan == 99) {
            document.getElementById('signup_noplan_button').style.display = 'none';
            document.getElementById('signup_plan_button').style.display = 'block';
            document.getElementById('signup_plan_button').innerText = "SIGN UP FOR ANNUAL PLAN";
        } else {
            document.getElementById('signup_noplan_button').style.display = 'none';
            document.getElementById('signup_plan_button').style.display = 'block';
            document.getElementById('signup_plan_button').innerText = "SIGN UP FOR 3 YEAR PLAN";
        }
    });
}

$(document).ready(function () {
    validatePwd_Signup();
    planOption_Select();
});