<?php
class User extends Database {

	public function register($username, $first_name, $last_name, $password) {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$query = "INSERT INTO users (username, first_name, last_name, password) VALUES (?, ?, ?, ?)";
		$stmt = $this->mysqli->prepare($query);   
        $stmt->bind_param("ssss", $username, $first_name, $last_name, $hashed_password);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function login($username, $password) {
		$query = "SELECT * FROM users WHERE username = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("s", $username);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		if (password_verify($password, $row["password"])) {
			$_SESSION["user_session"] = $row["id"];
			return true;
		} else {
			return false;
		}
	}
	
	public function return_info($id) {
		$query = "SELECT * FROM users WHERE id = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		return $row;
	}


	public function is_logged_in() {
		if (isset($_SESSION["user_session"])) {
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		session_destroy();
		unset($_SESSION["user_session"]);
		return true;
	}
}

?>
