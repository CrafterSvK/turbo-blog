<?php

namespace craftersvk\turboblog\controller;

use craftersvk\turboblog\model\Blog;
use League\CommonMark\CommonMarkConverter;

class Controller extends \cheetah\Controller {
	public $blog;
	public $blog_posts;

	public $converter;

	public function home(int $page = 0) {
		$this->blog_posts = Blog::getByPage($page);

		$this->render('app/view/index.tpl.php');
	}

	public function about() {
		$this->render('app/view/about.tpl.php');
	}

	public function blog($alias) {
		$this->blog = Blog::getByAlias($alias);

		$this->converter = new CommonMarkConverter([
			'html_input' => 'strip',
			'allow_unsafe_links' => true,
		]);

		$this->render('app/view/blog.tpl.php');
	}
}