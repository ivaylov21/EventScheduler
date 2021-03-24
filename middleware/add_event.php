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

if (!isset($_POST["name"]) || !$_POST["name"] ||
	!isset($_POST["priority"]) || !$_POST["priority"] ||
	!isset($_POST["description"])) {
	echo json_encode(["error" => "Name and priority are required!"]);
	return;
}
$name = trim($_POST["name"]);
$priority = trim($_POST["priority"]);

if (!in_array($priority, array_keys($EVENT_PRIORITY_CHOICES))) {
	echo json_encode(["error" => "Invalid priority is chosen!"]);
	return;
}

$editedId = null;
if ($_POST["editId"]) {
	$editedId = $_POST["editId"];
}

$controller = new EventController();
if ($editedId) {
	$event = $controller->getEventById($editedId);
	if (!$event) {
		echo json_encode(["error" => "Invalid event is edited!"]);
		return;
	} else if ($event->user_id != $_SESSION["user_id"]) {
		echo json_encode(["error" => "You do not have permissions for editing that event!"]);
		return;
	}
	$event->name = $name;
	$event->priority = $priority;
	$event->description = $_POST["description"];
	$success = $controller->updateEvent($event);
} else {
	$event = new Event($name, $priority, $_POST["description"], $_SESSION["user_id"]);
	$success = $controller->addEvent($event);
}

if (!$success) {
	$controller->closeConnection();
	echo json_encode(["error" => "Something went wrong! Please, try again."]);
	return;
}
$controller->closeConnection();
echo json_encode(["success" => true]);