<?php
include_once "./class/database.php";
include "./class/blog.php";
include "./class/user.php";

$blog = new Blog();
$user = new User();

include "header.php";

echo "<div class='blog'>";

if (empty($_GET["page"])) {
	$blog->show_blog(0);
} else {
	$blog->show_blog($_GET["page"]);
}

echo "</div>";

include "footer.php";
?>
