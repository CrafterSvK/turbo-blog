<?php

//include config.php from any directory without returning error.
if ((@include "config.php") === false) {
    include "../config.php";
} 

$config = new Config();

class Database extends mysqli {

	public function __construct() {

        $config = new Config();

        $this->config = $config;
        $this->mysqli = new mysqli($config->db_host, $config->db_username, $config->db_password, $config->db_database);
		$this->mysqli->set_charset("utf8");

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
}
?>
