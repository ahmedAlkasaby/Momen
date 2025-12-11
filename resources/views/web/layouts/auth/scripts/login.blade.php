<script>
$(document).ready(function () {
    $("#exampleModalToggle form").on("submit", function (e) {
        e.preventDefault();

        let $submitButton = $(this).find("button[type='submit']:visible");
        $submitButton.prop("disabled", true);

        let formData = {
            email: $("#login_email").val(),
            password: $("#password1").val(),
        };

        $.ajax({
            url: "/login", 
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (data) {
                $("#exampleModalToggle").modal("hide");
                location.reload(); 
            },
            error: function (xhr) {
                let messages = "Invalid credentials";
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    messages = Object.values(xhr.responseJSON.errors)
                        .flat()
                        .join("<br>");
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    messages = xhr.responseJSON.error;
                }
                if ($("#loginError").length === 0) {
                    $(this).append(
                        '<div id="loginError" style="color:red; text-align:center; margin-top:10px;"></div>'
                    );
                }
                $("#loginError").html(messages).show();
            },
            complete: function () {
                $submitButton.prop("disabled", false);
            },
        });
    });
});
</script>