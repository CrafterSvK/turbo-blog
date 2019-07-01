<footer>
	Jakub Janek | 2019 |
	<a class="lang-change" href="javascript:void(0)" data-lang="sk"><?= t("Slovenčina") ?></a> | <a class="lang-change" href="javascript:void(0)" data-lang="en"><?= t("Angličtina") ?></a>
	<script>
		document.querySelectorAll('.lang-change').forEach(function(e) {
		   e.onclick = function(f) {
		       console.log(f.target.dataset.lang);
		       document.cookie = `lang=${f.target.dataset.lang};max-age=2147483647;path=/`;
		       window.location.reload();
		   }
		});
	</script>
</footer>
