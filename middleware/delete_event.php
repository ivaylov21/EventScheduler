<?php
require_once("../controllers/events/EventController.php");

use controllers\events\EventController;
use models\events\Event;

header("Content-Type: application-json");

session_start();

if (!isset($_SESSION["user_id"]) || !$_SESSION["user_id"]) {
	echo json_encode(["error" => "Please log in!"]);
	return;
}

if (!isset($_POST["id"]) || !$_POST["id"]) {
	echo json_encode(["error" => "Invalid event is selected!"]);
	return;
}

$controller = new EventController();
$event = $controller->getEventById($_POST["id"]);
if (!$event) {
	$controller->closeConnection();
	echo json_encode(["error" => "The event is already deleted!"]);
	return;
}

if ($event->user_id != $_SESSION["user_id"]) {
	$controller->closeConnection();
	echo json_encode(["error" => "You do not have permissions to delete the event!"]);
	return;
}

$result = $controller->deleteEvent($_POST["id"]);
if (!$result) {
	$controller->closeConnection();
	echo json_encode(["error" => "Something went wrong!"]);
	return;
}

$controller->closeConnection();
echo json_encode(["success" => true]);