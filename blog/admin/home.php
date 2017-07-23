<?php
session_start();

include_once "../class/database.php";
include "../class/user.php";
include "../class/blog.php";

$blog = new Blog();
$user = new User();

if ($user->is_logged_in() == false) {
	header("Location: index.php");	
}

if (!empty($_GET["delete"])) {
	$blog->delete_post($_GET["delete"]);
}

$posts = $blog->get_all_posts();

echo "<center>"
	."<table id='home' cellpadding='5px'>"
 	."<tr> <th>Title</th> <th>Category</th> <th>Date</th> <th>Views</th>  <th>Edit</th> <th>Delete</th> </tr>";

foreach ($posts as $post) {
	$date = date("d.m.Y H:i", strtotime($post["date"]));
	echo "<tr>"
	 	."<td>".$post["subject"]."</td>"
		."<td>".$post["category"]."</td>"
		."<td>".$date."</td>"
		."<td>".$post["view_count"]."</td>"
		."<td>"."<a href='/blog/admin/edit-post.php?id=".$post["id"]."'>Edit</a>"
		."<td>"."<a href='/blog/admin/home.php?delete=".$post["id"]."'>Delete</a>"."</td>"
		."</tr>";
}

echo "</table>"
	."<br />"
	."<a href='/blog/admin/add-post.php'>Add post</a>"
	." | "
	."<a href='/blog'>Preview</a>"
	."</center>";

?>

