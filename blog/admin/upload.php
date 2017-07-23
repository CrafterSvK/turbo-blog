<?php
session_start();

include_once "../class/database.php";
include "../class/user.php";
include "../class/upload.php";

$user = new User();
$upload = new Upload();

if ($user->is_logged_in() == false) {
	header("Location: index.php");	
}

if (!empty($_GET["delete"])) {
	$file = $_GET["delete"];

	$upload->delete_image($file);
}

if (isset($_POST["submit"])) {
	$file = $_FILES["file"]["tmp_name"];
	$name = $_POST["name"];

	$upload->add_image($name, $file);	
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="text" name="name" required />
	<input type="file" name="file" required />
	<input type="submit" name="submit" value="Upload image" />
</form>
<?php
$images = $upload->return_images();

foreach ($images as $image) {
	echo "<img src='".$image["path"]."'></img>"
		."<p>".$image["name"]." | "."<a href='/blog/admin/upload.php?delete=".$image["id"]."'>Delete image</a></p>";
}
?>
