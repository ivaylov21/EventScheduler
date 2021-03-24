<?php

namespace controllers\events;

require_once __DIR__ . "/../../models/events/Event.php";
require_once __DIR__ . "/../users/UserController.php";

use models\events\Event;
use controllers\Controller;
use controllers\users\UserController;

class EventController extends Controller {
	private $userController;

	public function __construct() {
		parent::__construct();
		$this->userController = new UserController();
	}

	public function closeConnection() {
		parent::closeConnection();
		$this->userController->closeConnection();
	}

	public function getEventById($id) {
		$sql = "SELECT * FROM event WHERE id=" . $id;
		$result = $this->db_connection->query($sql);
		$event = null;

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$event = new Event($row["name"],$row["priority"],$row["description"],$row["user_id"],$row["id"]);
			}
		}
		return $event;
	}

	private function getEventsByQuery($query) {
		$result = $this->db_connection->query($query);
		$events = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$user = $this->userController->getUserById($row["user_id"]);
				if (!$user) {
					return [];
				}
				$event = new Event($row["name"],$row["priority"],$row["description"],$row["user_id"],$row["id"]);
				$event = Event::setUserFullName($event, $user);
				$events[] = $event;
			}
		}
		return $events;
	}

	public function getAllEvents() {
		$sql = "SELECT * FROM event";
		return $this->getEventsByQuery($sql);
	}

	public function filterEventsByName($pattern) {
		$sql = "SELECT * FROM event WHERE name LIKE '%".$pattern."%'";
		return $this->getEventsByQuery($sql);
	}

	public function addEvent(Event $event) {
		$sql = "INSERT INTO event (name, priority, description, user_id)
				VALUES ('".$event->name."', '".$event->priority."', '".$event->description."', ".$event->user_id.")";
		if ($this->db_connection->query($sql) === TRUE) {
		  return true;
		}
		return false;
	}

	public function updateEvent(Event $event) {
		$sql = "UPDATE event SET name='". $event->name . "', priority='". $event->priority. "', description='". 
		$event->description. "' WHERE id=". $event->id;
		$result = $this->db_connection->query($sql);
		if ($result === true) {
			return true;
		}
		return false;
	}

	public function deleteEvent($id) {
		$sql = "DELETE from event WHERE id=". $id;
		$result = $this->db_connection->query($sql);
		if ($result === true) {
			return true;
		}
		return false;
	}
}