<?php

namespace craftersvk\turboblog\controller;

use craftersvk\turboblog\model\Blog;
use function file_get_contents;
use function json_decode;
use function password_verify;

class AdminController extends \cheetah\Controller {
	public $error;
	public $blog_posts;
	public $blog_post;

	public function __construct() {
		if (isset($_POST['login']) && !$_SESSION['logged']) {
			$config = json_decode(file_get_contents('config.json'));

			if (password_verify($_POST['password'], $config->password)) {
				$_SESSION['logged'] = true;
			} else {
				$this->error = t("Zlé heslo");

				$this->render('app/view/login.tpl.php');
			}
		} else if (!$_SESSION['logged']) {
			$this->render('app/view/login.tpl.php');
		}

	}

	public function admin($page = 0) {
		$this->blog_posts = Blog::getByPage($page);
		$this->render('app/view/admin.tpl.php');
	}

	public function manipulate_blog(string $lang, $bid = 0) {
		$this->blog_post = new Blog($bid, $lang);

		if ($bid != 0) {
			if (isset($_POST['edit-blog'])) {
				$this->blog_post->title = $_POST['title'];
				$this->blog_post->description = $_POST['description'];
				$this->blog_post->markdown = $_POST['markdown'];
				$this->blog_post->lang = $lang;

				$this->blog_post->update();
			}
		} else {
			if (isset($_POST['edit-blog'])) {
				$this->blog_post->title = $_POST['title'];
				$this->blog_post->description = $_POST['description'];
				$this->blog_post->markdown = $_POST['markdown'];
				$this->blog_post->lang = $lang;

				$this->blog_post->add();
			}
		}

		$this->render('app/view/edit-blog.tpl.php');

	}
}