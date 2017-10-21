<?php
include_once "./class/database.php";
include "./class/blog.php";
include "./class/user.php";

$blog = new Blog();

include "header.php";

if (empty($_GET["string"])) {
	header("Location: ".$config->installation_path);
} else {
	$posts = $blog->get_all_posts_hashtag($_GET["string"]);
}

echo "<div class='blog'>";

foreach ($posts as $post) {
	echo "<article>"
		."<h1><a id='title' href='".$config->installation_path."/post.php?id=".$post['id']."'>".$post['subject']."</a></h1>"
		.date("d.m.Y H:m", strtotime($post['date']))
		."<br />"
		."<b><a id='hashtag' href='".$config->installation_path."/hashtag.php?string=".$post['category']."'>#".$post['category']."</a></b>"
		."<br />"
		.$post['content']
		."<br />"
		."<a href='".$config->installation_path."/post.php?id=".$post['id']."'>Read whole thing...</a>"
		."</article>"
		."<br />";
}

echo "</div>";

include "footer.php";
?>
