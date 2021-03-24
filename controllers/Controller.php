<?php

namespace controllers;

class Controller {
	protected $db_connection;

	public function __construct() {
		$this->db_connection = mysqli_connect(DB_CONNECTION_HOST,DB_CONNECTION_USER,DB_CONNECTION_PASSWORD,DB_CONNECTION_NAME);
		if (!$this->db_connection) {
			die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
	}

	public function closeConnection() {
		mysqli_close($this->db_connection);
	}
}