<?php
    session_start();
    if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]) {
        header("Location: http://localhost/EventScheduler/views/home.php");
    }
require("../../includes/header.php");
?>
<div class="container">
    <div class="col-md-6 login-container">
        <form id="registerForm">
            <div class="form-group">
                <label for="firstName">First name</label>
                <input class="form-control" id="firstName" placeholder="Enter first name">
            </div>
            <div class="form-group">
                <label for="lastName">Last name</label>
                <input class="form-control" id="lastName" placeholder="Enter last name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm password</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password">
            </div>
            <div id="error" class="alert alert-danger hidden" role="alert"></div>
                <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</div>
</body>
<script src="../../static/js/register.js"></script>
</html>