<?php
class Blog extends Database {	

	public function show_blog($page_number) { 
		$offset = $page_number * 5;

		//Display blog
		$query = "SELECT * FROM blog ORDER BY date DESC LIMIT 5 OFFSET ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $offset);
		$stmt->execute();

		$result	= $stmt->get_result();	
		$posts = $result->fetch_all(MYSQLI_ASSOC);
	
		$this->_print_blog($posts);

		$next = $page_number + 1;
		$previous = $page_number - 1;	

		//Check if there is more needed to be displayed 
		$query = "SELECT * FROM blog ORDER BY date DESC LIMIT ?, 10";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $start);
		$stmt->execute();

		$result = $stmt->get_result();

		//Most sketchiest thing I have ever made
		if ($result->num_rows >= 6) {
			if ($page_number == 0) {
				echo "<a href='/janek/page/".$next."'>Next</a>";
			} else {
				echo "<a href='/janek/page/".$previous."'>Prev</a>"
					." | "
					."<a href='/janek/page/".$next."'>Next</a>";
			}	
		} else {
			if ($page_number != 0) {
				echo "<a href='/janek/page/".$previous."'>Previous</a>";
			} 
		}	
	}

	private function _print_blog($posts) {
		foreach ($posts as $post) {
			echo "<article>"
				."<h1><a id='title' href='/janek/post/".$post['id']."'>".$post['subject']."</a></h1>"
				.date("d.m.Y H:m", strtotime($post['date']))
				."<br />"
				."<b><a id='hashtag' href='/janek/hashtag/".$post['category']."'>#".$post['category']."</a></b>"
				."<br />"
				.$post['content']
				."<br />"
				."<a href='/janek/post/".$post['id']."'>Read whole thing...</a>"
				."</article>"
				."<br />";	
		}	
	}

	public function add_post($subject, $category, $content, $first_name, $last_name) {
		$author = $first_name." ".$last_name;
		$date = date("Y-m-d H:i:s");

		$query = "INSERT INTO blog (subject, category, content, date, author) VALUES (?, ?, ?, ?, ?)";	
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("sssss", $subject, $category, $content, $date, $author);
		$stmt->execute();
		
		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function edit_post($id, $subject, $category, $content) {
		$query = "UPDATE blog SET subject = ?, category = ?, content = ? WHERE id = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("sssi", $subject, $category, $content, $id);
		$stmt->execute();
		
		$result = $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function get_post($id) {
		$query = "SELECT * FROM blog WHERE id = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		return $row;
	}

	public function get_all_posts_hashtag($hashtag) {
		$query = "SELECT * FROM blog WHERE category = ? ORDER BY date DESC";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("s", $hashtag);
		$stmt->execute();

		$result = $stmt->get_result(); 
		$row = $result->fetch_all(MYSQLI_ASSOC);

		return $row;
	}

	public function get_all_posts() {
		$query = "SELECT * FROM blog ORDER BY date DESC";
		$result = $this->mysqli->query($query);	
		$row = $result->fetch_all(MYSQLI_ASSOC);
		
		return $row;
	}		

	public function delete_post($id) {
		$query = "DELETE FROM blog WHERE id = ?";
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

	public function add_view($id) {
		$query = "UPDATE blog SET view_count = view_count + 1 WHERE id = ?"; 
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$result	= $stmt->get_result();

		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function post_exist($id) {
		$query = "SELECT subject FROM blog WHERE id = ?";
		$stmt = $this->mysqli->prepare($query);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();
		
		if ($result != null) {
			return true;
		} else {
			return false;
		}
	}

	public function content_preview($content) {
		$content_preview = substr($content, 0, 400);

		return $content_preview;
	}
}
?>
