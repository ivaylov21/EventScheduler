<?php

namespace controllers\users;

require_once __DIR__ . "/../../models/users/User.php";
require_once __DIR__ . "/../Controller.php";

use models\users\User;
use controllers\Controller;

class UserController extends Controller {

	public function getUserByEmail($email, $editedId = null) {
		$sql = "SELECT * FROM user WHERE email='" . $email . "'";

		if ($editedId) {
			$sql .= " AND id!=".$editedId;
		}
		$result = $this->db_connection->query($sql);
		$user = null;

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$user = new User($row["first_name"],$row["last_name"],$row["email"],$row["password"],$row["id"]);
			}
		}
		return $user;
	}

	public function getUserById($id) {
		$sql = "SELECT * FROM user WHERE id=" . $id;
		$result = $this->db_connection->query($sql);
		$user = null;

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$user = new User($row["first_name"],$row["last_name"],$row["email"],$row["password"],$row["id"]);
			}
		}
		return $user;
	}

	public function getAllUsers() {
		$sql = "SELECT * FROM user";
		$result = $this->db_connection->query($sql);
		$users = [];

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$users[] = new User($row["first_name"],$row["last_name"],$row["email"],$row["password"],$row["id"]);
			}
		}
		return $users;
	}

	public function registerUser(User $user) {
		$sql = "INSERT INTO user (first_name, last_name, email, password)
				VALUES ('".$user->first_name."', '".$user->last_name."', '".$user->email."', '".$user->password."')";
		if ($this->db_connection->query($sql) === true) {
		  return true;
		}
		return false;
	}

	public function updateUser(User $user) {
		$sql = "UPDATE user SET first_name='". $user->first_name . "', last_name='". $user->last_name. "', email='". 
		$user->email. "', password='". $user->password ."' WHERE id=". $user->id;
		$result = $this->db_connection->query($sql);
		if ($result === true) {
			return true;
		}
		return false;
	}
}