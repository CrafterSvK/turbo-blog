<?php
require_once "vendor/autoload.php";

use cheetah\Database;
use cheetah\Router;

new Router("routes.json", "config.json");

function t($string) {
	if (!isset($_COOKIE['lang']) || $_COOKIE['lang'] === 'en') {
		$db = new Database();

		$trans = $db->select('translation')
			->item('translation')
			->condition('original', $string)
			->execute()->fetch_array()['translation'];

		if ($trans === NULL) {
			$db->insert('translation')
				->value('original', $string)
				->execute();

			return $string;
		} else if (!empty($trans)) {
			return $trans;
		} else {
			return $string;
		}
	} else {
		return $string;
	}
}