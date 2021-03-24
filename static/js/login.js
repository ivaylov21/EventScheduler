$(document).ready(function(){
	$("#loginForm").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: window.location.origin + '/EventScheduler/middleware/login.php',
            method: 'POST',
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = window.location.origin + "/EventScheduler/views/home.php";
                } else {
                    var errorDiv = $("#error");
                    errorDiv.removeClass("hidden");
                    errorDiv.text(response.error);
                }
            }
        })
    });
});