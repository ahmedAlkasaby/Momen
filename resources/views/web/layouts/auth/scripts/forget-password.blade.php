<script
let RESET_OTP = "";

$("#verifyOtpModal .otp-input").on("input", function () {
    if (this.value.length === 1) {
        $(this).next(".otp-input").focus();
    }
});

$("#forgetPasswordForm").on("submit", function (e) {
    e.preventDefault();
    
    let email = $("#fp_email").val();
    let $btn = $(this).find("button[type='submit']:visible");

    $("#fp_error").hide().html("");

    $btn.prop("disabled", true);

    $.ajax({
        url: "/forget-password",
        type: "POST",
        data: { email },
        success: function () {
            let forgetModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("forgetPasswordModal"));
            forgetModal.hide();

            let verifyModal = new bootstrap.Modal(document.getElementById("verifyOtpModal"));
            verifyModal.show();
        },
        error: function (xhr) {
            let msg = "Something went wrong";

            if (xhr.responseJSON?.error) {
                msg =
                    typeof xhr.responseJSON.error === "object"
                        ? Object.values(xhr.responseJSON.error).flat().join("<br>")
                        : xhr.responseJSON.error;
            }

            $("#fp_error").html(msg).show();
        },
        complete: function () {
            $btn.prop("disabled", false);
        },
    });
});

$("#verifyOtpForm").on("submit", function (e) {
    e.preventDefault();

    $("#verifyOtp_error").hide().html("");

    RESET_OTP = "";
    $("#verifyOtpModal .otp-input").each(function () {
        RESET_OTP += $(this).val();
    });

    let email = $("#fp_email").val();

    $.ajax({
        url: "/confirm-otp",
        type: "POST",
        data: { code: RESET_OTP, email },
        success: function () {
            let verifyModal = bootstrap.Modal.getOrCreateInstance(document.getElementById("verifyOtpModal"));
            verifyModal.hide();

            let resetModal = new bootstrap.Modal(document.getElementById("resetPasswordModal"));
            resetModal.show();
        },
        error: function (xhr) {
            let msg = xhr.responseJSON?.error || "Invalid Code";
            $("#verifyOtp_error").html(msg).show();
        },
    });
});

$("#resetPasswordForm").on("submit", function (e) {
    e.preventDefault();

    $("#reset_error").hide().html("");

    let password = $("#new_password").val();
    let confirm = $("#confirm_password").val();

    $.ajax({
        url: "/reset-password",
        type: "POST",
        data: {
            password,
            password_confirmation: confirm,
            code: RESET_OTP,
        },
        success: function (data) {
            location.reload();
        },
        error: function (xhr) {
            let msg = xhr.responseJSON?.error || "Something went wrong";
            $("#reset_error").html(msg).show();
        },
    });
});
</script>