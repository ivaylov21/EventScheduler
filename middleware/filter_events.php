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

if (!isset($_GET["filter"])) {
	echo json_encode(["error" => "Invalid data!"]);
	return;
}

$filterName = trim($_GET["filter"]);
$controller = new EventController();

if (!$filterName) {
	$events = $controller->getAllEvents();
} else {
	$events = $controller->filterEventsByName($filterName);
}

$controller->closeConnection();
echo json_encode(["success" => true, "events" => $events, "userId" => $_SESSION["user_id"]]);