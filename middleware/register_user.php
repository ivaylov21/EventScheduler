<?php

require_once("../controllers/users/UserController.php");

use controllers\users\UserController;
use models\users\User;

header("Content-Type: application-json");

$required_fields = ["first_name", "last_name", "email", "password", "confirm_password"];

foreach ($required_fields as $field) {
	if (!isset($_POST[$field]) || !$_POST[$field]) {
		echo json_encode(["error" => "Invalid data. All fields are required!"]);
		return;
	}
	$_POST[$field] = trim($_POST[$field]);
}

if (strpos($_POST["email"], "@") === false ||
	strpos($_POST["email"], ".") === false ||
	strlen($_POST["email"]) < 6) {
	echo json_encode(["error" => "Please enter a valid email address!"]);
	return;
}

if (strlen($_POST["password"]) < 8 ||
	strlen($_POST["confirm_password"]) < 8) {
	echo json_encode(["error" => "Password must be at least 8 characters long!"]);
	return;
}

if ($_POST["password"] != $_POST["confirm_password"]) {
	echo json_encode(["error" => "You have entered two different passwords!"]);
	return;
}

$controller = new UserController();
if ($controller->getUserByEmail($_POST["email"])) {
	$controller->closeConnection();
	echo json_encode(["error" => "A user with this email already exists!"]);
	return;
}

$hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$user = new User($_POST["first_name"], $_POST["last_name"], $_POST["email"], $hashed_password);
$register = $controller->registerUser($user);

if (!$register) {
	$controller->closeConnection();
	echo json_encode(["error" => "Registration failed! Please, try again!"]);
	return;
}

$controller->closeConnection();
echo json_encode(["success" => true]);