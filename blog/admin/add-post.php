<?php
session_start();

include_once "../class/database.php";
include "../class/user.php";
include "../class/blog.php";

$blog = new Blog();
$user = new User();

if ($user->is_logged_in() == false) {
	header("Location: home.php");		
} else {
	$id = $_SESSION["user_session"];
	$user_row = $user->return_info($id);
}

if (isset($_POST["submit"])) {
	$subject = $_POST["subject"];
	$category = $_POST["category"];
	$content = $_POST["content"];
	$first_name = $user_row["first_name"];
	$last_name = $user_row["last_name"];

	if ($blog->add_post($subject, $category, $content, $first_name, $last_name) == true) {
		header("Location: /blog/admin/home.php");
	} else {
		header("Location: /blog/admin/home.php");	
	}
}

?>
<form method="post">
	<input id="subject" type="text" name="subject" placeholder="Title" required />
	<input id="category" type="text" name="category" placeholder="Category" required /><br />
	<textarea id="editor_input" name="content" style="width: 600px; height: 600px;" required ></textarea><br />
		<a href="javascript:void();" onclick="window.open('upload', 'newwindow', 'width=900,height=600'); return false;"><input type="button" value="Upload image" /></a><br />
	<input type="submit" name="submit" id="submit" value="Submit post" /><br />
</form>

