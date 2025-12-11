<script>

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    $("#signupForm").on("submit", function (e) {
        e.preventDefault();
        let $sumitButton = $(this).find("button[type='submit']:visible");
        console.log($sumitButton);
        $sumitButton.prop("disabled", true);
        let formData = {
            name_first: $("#name_first").val(),
            name_last: $("#name_last").val(),
            email: $("#signup_email").val(),
            phone: $("#phone").val(),
            password: $("#password2").val(),
            password_confirmation: $("#password3").val(),
        };
        $.ajax({
            url: "/register",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (data) {
                $("#exampleModalToggle2").modal("hide");
                $("#otpModal").modal("show");
            },
            error: function (xhr) {
                let messages = "";

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors; 
                    messages = Object.values(errors).flat().join("<br>");
                } else {
                    messages = xhr.responseJSON.error || "Something went wrong";
                }

                $("#signupError").html(messages).show();
            },
            complete: function () {
                $sumitButton.prop("disabled", false);
            },
            
        });
    });
});
</script>
