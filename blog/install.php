<!doctype html>
<html>
<head>
    <title>turbo-blog installation</title>
    <meta charset="utf-8">
</head>
<?php
include_once "./class/database.php";
include "./class/user.php";

$user = new User();
$database = new Database();

if (isset($_POST["submit"])) {
    //CREATE TABLES
    $database->mysqli->query("CREATE TABLE blog (
                            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            subject varchar(255) NOT NULL,
                            category varchar(255) NOT NULL,
                            content text NOT NULL,
                            date datetime NOT NULL,
                            author varchar(255) NOT NULL,
                            view_count int NOT NULL);");

    $database->mysqli->query("CREATE TABLE blog_images (
                            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            name varchar(255) NOT NULL,
                            path text NOT NULL,
                            date datetime NOT NULL);");
    
    $database->mysqli->query("CREATE TABLE comments (
                            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            post_id int NOT NULL,
                            author varchar(255) NOT NULL,
                            date datetime NOT NULL,
                            content text NOT NULL);");
    
    $database->mysqli->query("CREATE TABLE users (
                            id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            username varchar(255) NOT NULL,
                            first_name varchar(255) NOT NULL,
                            last_name varchar(255) NOT NULL,
                            password varchar(255) NOT NULL);");
                            
    //REGISTER USER
    $username = $_POST["username"];
    $password = $_POST["password"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];

    if ($user->register($username, $first_name, $last_name, $password)) {
        echo "<script>alert('Succesfully installed...');</script>";
        header("Location: ./admin/index.php?delete=delete"); 
    }
}

?>
<h1> Installation of turbo-blog </h1>
Register so you can access your blog-system from <a href="./admin">admin page</a>
<form method="post">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="text" name="first_name" placeholder="First name" />
    <input type="text" name="last_name" placeholder="Last name" />
    <input type="submit" name="submit" value="Install" />
</form>
