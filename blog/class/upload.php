<?php
class Upload extends Database {

	public function add_image($name, $image) {
		$date = date("Y-m-d H:i:s");
		$random_name = $this->_generate_name(10);
		$path_to_file = $_SERVER['DOCUMENT_ROOT']."/cdn/blog/".$random_name.".png";

		while (file_exists($path_to_file)) {
			$random_name = $this->_generate_name(10);
			$path_to_file = $_SERVER['DOCUMENT_ROOT']."/cdn/blog/".$random_name.".png";	
		}

		move_uploaded_file($image, $path_to_file);

		$query = "INSERT INTO blog_images (name, path, date) VALUES (?, ?, ?)";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("sss", $name, $path_to_file, $date);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function delete_image($id) {
		$query = "SELECT path FROM blog_images WHERE id = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();

		unlink($result);

		$query = "DELETE FROM blog_images WHERE id = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function rename_image($id, $name) {
		$query = "UPDATE blog_images SET name = ? WHERE id = ?"; 
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("si", $name, $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function return_images() {
		$query = "SELECT * FROM blog_images ORDER BY date DESC";
		$result = $this->mysqli->query($query); 
		$row = $result->fetch_all(MYSQLI_ASSOC);

		return $row;
	}

	private function _generate_name($length) {
    	$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    	$characters_length = strlen($characters);
    	$random_string = "";

		for ($i = 0; $i < $length; $i++) {
        	$random_string .= $characters[rand(0, $characters_length - 1)];
    	}

		return $random_string;
	}
}
?>
