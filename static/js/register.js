$(document).ready(function(){
	$("#registerForm").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: window.location.origin + '/EventScheduler/middleware/register_user.php',
            method: 'POST',
            data: {
                first_name: $("#firstName").val(),
                last_name: $("#lastName").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                confirm_password: $("#confirmPassword").val()
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = window.location.origin + "/EventScheduler/index.php";
                } else {
                    var errorDiv = $("#error");
                    errorDiv.removeClass("hidden");
                    errorDiv.text(response.error);
                }
            }
        })
    });
});