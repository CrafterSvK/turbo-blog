<?php
header('Content-type: image/png');

session_start();

include_once "./class/database.php";
include "./class/comments.php";

$comments_class = new Comments();

$string = $comments_class->generate_string(6);

$_SESSION["captcha"] = $string;

$image = imagecreatetruecolor(125, 25);
$background = imagecolorallocate($image, 0, 0, 0);
$foreground = imagecolorallocate($image, 255, 255, 255);
$line_color = imagecolorallocate($image, 100, 100, 100);


imagettftext($image, 20, 0, 10, 20, $foreground, "./fonts/arial.ttf", $string);

for ($i = 0; $i < 10; $i++) {
    imageline($image, 0, rand()%50, 200, rand()%50, $line_color);
}

imagepng($image);
imagedestroy($image);
?>
