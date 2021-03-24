<?php
require_once("../controllers/users/UserController.php");

use controllers\users\UserController;
use models\users\User;

header("Content-Type: application-json");


if (!isset($_POST["email"]) || !$_POST["email"] ||
	!isset($_POST["password"]) || !$_POST["password"]) {
	echo json_encode(["error" => "Please enter your email and password to log in!"]);
	return;
}
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);

$controller = new UserController();
$user = $controller->getUserByEmail($email);
if (!$user || !password_verify($password, $user->password)) {
	$controller->closeConnection();
	echo json_encode(["error" => "There is no user with the email and password entered!"]);
	return;
}

session_start();
$_SESSION["user_id"] = $user->id;
$controller->closeConnection();
echo json_encode(["success" => true]);