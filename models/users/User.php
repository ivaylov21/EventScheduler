<?php

namespace models\users;

require_once __DIR__ . "/../../settings.php";

class User {
	public $id;
	public $first_name;
	public $last_name;
	public $email;
	public $password;

	public function __construct($first_name, $last_name, $email, $password, $id = null) {
		$this->id = $id;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->email = $email;
		$this->password = $password;
	}
}