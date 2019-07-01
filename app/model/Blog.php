<?php
namespace craftersvk\turboblog\model;

use cheetah\Database;

class Blog {
	public $bid;
	public $title;
	public $markdown;
	public $alias;
	public $lang;
	public $created;
	public $updated;
	public $description;

	private $db;

	public function __construct(int $bid = 0, string $lang = 'sk') {
		$this->db = new Database();

		if ($bid !== 0) {
			$this->bid = $bid;
			$this->lang = $lang;

			$this->set();
		}
	}

	public function add(): Blog {
		$this->alias = $this->genAlias($this->title);

		$values = [
			'title' => $this->title,
			'description' => $this->description,
			'markdown' => $this->markdown,
			'alias' => $this->alias,
			'lang' => $this->lang
		];

		$this->bid = $this->db->insert('blog')
			->values($values)
			->execute();

		$this->set();

		return $this;
	}

	public function update(): Blog {
		$values = [
			'title' => $this->title,
			'description' => $this->description,
			'markdown' => $this->markdown,
			'alias' => $this->alias,
			'lang' => $this->lang
		];

		if ($this->lang === 'sk') {
			$this->db->update('blog')
				->condition('bid', $this->bid)
				->values($values)
				->execute();
		} else {
			$translation = $this->db->select('blog_translation')
				->item('bid')
				->condition('bid', $this->bid)
				->execute()->fetch_array();

			if ($translation === null) {
				$values['bid'] = $this->bid;
				$values['alias'] = $this->genAlias($this->title);

				$this->db->insert('blog_translation')
					->values($values)
					->execute();
			} else {
				$this->db->update('blog_translation')
					->condition('bid', $this->bid)
					->values($values)
					->execute();
			}
		}

		return $this;
	}

	private function set(): void {
		$blog = $this->db->select('blog')
			->item('*')
			->condition('bid', $this->bid)
			->execute()
			->fetch_object();

		$this->created = $blog->created;
		$this->updated = $blog->updated;

		if ($this->lang !== 'sk') {
			$blog = $this->db->select('blog_translation')
				->item('*')
				->condition('bid', $this->bid)
				->execute()
				->fetch_object();
		}

		if (isset($blog)) {
			$this->lang = $blog->lang;
			$this->title = $blog->title;
			$this->description = $blog->description;
			$this->markdown = $blog->markdown;
			$this->alias = $blog->alias;
		}
	}

	public function genAlias(string $title): string {
		$alias = preg_replace('/[-]{2,}/', '-',
			str_replace([' ', ', ', ','], '-',
				transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $title)
			)
		);

		return $alias;
	}

	public static function getByAlias($alias): Blog {
		$blog = new self();

		$blog_post = $blog->db->select('blog')
			->items(['bid', 'lang'])
			->condition('alias', $alias)
			->execute()->fetch_array();

		if ($blog_post === null) {
			$blog_post = $blog->db->select('blog_translation')
				->items(['bid', 'lang'])
				->condition('alias', $alias)
				->execute()->fetch_array();
		}

		$blog->bid = $blog_post['bid'];
		$blog->lang = $blog_post['lang'];

		$blog->set();

		return $blog;
	}

	public static function getByPage($page): array {
		$db = new Database();

		$blog_posts = $db->select('blog')
			->item('bid')
			->order('created DESC LIMIT ' . ($page * 5) . ', 5') //range
			->execute()
			->fetch_all(MYSQLI_ASSOC);

		$posts = [];

		foreach ($blog_posts as $post) {
			$posts[] = new self($post['bid'], $_COOKIE['lang'] ?? 'en');
		}

		return $posts;
	}
}