<?php
class Database extends mysqli {

	public function __construct() {
		$this->mysqli = new mysqli("IP_TO_MYSQL", "NAME", "PASSWORD", "DATABASE");
		$this->mysqli->set_charset("utf8");

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
}
?>
