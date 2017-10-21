<?php    
session_start();

include_once "../class/database.php";
include "../class/user.php";
include "../class/blog.php";
	
$blog = new Blog();
$user = new User();

include "./header.php";

if (isset($_GET["delete"])) {
    unlink("install.php");
    header("Location: index.php");
}

if ($user->is_logged_in() == true) {
	header("Location: home.php");
}

if (isset($_POST["submit"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	if ($user->login($username, $password) == true) {
		header("Location: home.php");
	} else {
		echo "<script>alert('Wrong password');</script>";
	}
}

?>
<div class="blog" id="login">
<h2>Admin - login</h2>
<form method="post">
	<input type="text" name="username" placeholder="Name"><br />
	<input type="password" name="password" placeholder="Password"><br />
	<input type="submit" name="submit" value="Login">
</form>

</div>
