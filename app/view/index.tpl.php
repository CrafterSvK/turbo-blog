<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="description" content="Jakub Janek's blog">
	<meta name="author" content="Jakub Janek">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="/cdn/style.css">
	<title>Janek.xyz</title>
</head>
<body>
<?php include 'app/view/page/header.tpl.php' ?>
<main>
	<section class="blog-list">
		<?php
		if (!empty($this->blog_posts)):
			foreach ($this->blog_posts as $post): ?>
				<article>
					<h3><?= $post->title . " | " . date(t("d.m.Y"), strtotime($post->created)) ?></h3>
					<p><?= $post->description ?></p>
					<a href="/blog/<?= $post->alias ?>"><?= t("Čítať viac") ?></a>
				</article>
			<?php
			endforeach;
			echo t("Viac článkov bude vydaných na ďaľší deň.");
		else:
			echo t("Nie sú tu žiadne príspevky");
		endif;
		?>
	</section>
</main>
<?php include 'app/view/page/footer.tpl.php' ?>
</body>
</html>
