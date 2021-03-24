<?php

namespace models\events;

require_once __DIR__ . "/../../settings.php";
require_once __DIR__ . "/../users/User.php";

use models\users\User;

class Event {
	public $id;
	public $name;
	public $priority;
	public $description;
	public $user_id;
	public $user_full_name;

	public function __construct($name, $priority, $description, $user_id, $id = null) {
		$this->id = $id;
		$this->name = $name;
		$this->priority = $priority;
		$this->description = $description;
		$this->user_id = $user_id;
	}

	public static function setUserFullName(Event &$event, User &$user) {
		$event->user_full_name = $user->first_name . " " . $user->last_name;
		return $event;
	}
}