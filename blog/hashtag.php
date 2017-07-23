<?php
include_once "./class/database.php";
include "./class/blog.php";
include "./class/user.php";

$blog = new Blog();

if (empty($_GET["string"])) {
	header("Location: /blog");
} else {
	$posts = $blog->get_all_posts_hashtag($_GET["string"]);
}

foreach ($posts as $post) {
	echo "<article>"
		."<h1><a id='title' href='/blog/post.php?id=".$post['id']."'>".$post['subject']."</a></h1>"
		.date("d.m.Y H:m", strtotime($post['date']))
		."<br />"
		."<b><a id='hashtag' href='/blog/hashtag.php?string=".$post['category']."'>#".$post['category']."</a></b>"
		."<br />"
		.$post['content']
		."<br />"
		."<a href='/blog/post.php?id=".$post['id']."'>Read whole thing...</a>"
		."</article>"
		."<br />";
}

?>
