<?php
session_start();

include_once "./class/database.php";
include "./class/blog.php";
include "./class/comments.php";

$blog = new Blog();
$comments_class = new Comments();

$blog->add_view($_GET["id"]);
$post = $blog->get_post($_GET["id"]);
$comments = $comments_class->get_all($_GET["id"]);
?>
<div id="content">
<div id="post">
<article>
<?php
if (empty($_GET["id"])) {
	header("Location: /blog");
}

if (isset($_POST["submit"])) {
	$author = $_POST["author"];
	$content = $_POST["comment_content"];
	$user_captcha = $_POST["captcha"];
	$real_captcha = $_SESSION["captcha"];

	if ($user_captcha == $real_captcha) {
		$comments_class->add_comment($post["id"], $author, $content);
		echo "Comment succesfully added!";
	} else {
		echo "There is something wrong with the catchpa!";
	}
}

if ($blog->post_exist($post["id"]) == false) {
	header("Location: /blog");
} else {
	$date = date("d.m.Y H:m", strtotime($post['date']));

	echo "<h1><a id='title' href='/blog/post.php?id=".$post['id']."'>".$post['subject']."</a></h1>"
		.date("d.m.Y H:m", strtotime($post['date']))
		."<br />"
		."<b><a id='hashtag' href='/blog/hashtag.php?string=".$post['category']."'>#".$post['category']."</a></b>"
		."<br />"
		."<p>"
		.$post['content']
		."</p>"
		."<br />";

}

?>
</article>
</div>
Add comment: <br />
<form method="post">
	<input type="text" name="author" placeholder="Name" required /><br />
	<textarea name="comment_content" placeholder="Comment" style="resize: none;" required ></textarea><br />
	<img src="/janek/captcha" /><br />
	<input type="text" name="captcha" placeholder="Captcha" /><br />
	<input type="submit" value="Comment" name="submit" />
</form>
<hr>

<?php

if ($comments) {
	foreach ($comments as $comment) {
		$comment_date = date("d.m.Y H:m", strtotime($comment['date']));

		echo "<div class='comment' id='".$comment['id']."'>"
			."<h4>".$comment["author"]."</h4>"
			.$comment_date
			."<p>".$comment["content"]."</p>"
			."</div>";
	}	
} else {
	echo "No comments to display!";
}
?>
</div>
<?php
include "footer.php";
?>
</body>
</html>
