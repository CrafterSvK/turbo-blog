<?php
class Comments extends Database {

	public function add_comment($post_id, $author, $raw_content) {
		$date = date("Y-m-d H:i:s");

		$content = strip_tags($raw_content);

		$content = $this->_make_urls($content);

		$query = "INSERT INTO comments (post_id, author, date, content) VALUES (?, ?, ?, ?)";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("isss", $post_id, $author, $date, $content);

		$stmt->execute();

		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}	
	}	

	public function delete_comment($id) {
		$query = "DELETE FROM comments WHERE id = ?";
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

	public function get_all($post_id) {
		$query = "SELECT * FROM comments WHERE post_id = ? ORDER BY date DESC";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $post_id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_all(MYSQLI_ASSOC);

		return $row;
	}

	private function _make_urls($text) {
		$expression = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
		$target = "<a href='$1' target='_blank'>$1</a>";

		$modified_text = preg_replace($expression, $target, $text);

		return $modified_text;
	}

	public function generate_string($length) {
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
