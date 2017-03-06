</main>

<footer class="site__footer">
	<p>&copy;<?php echo date("Y"); echo " "; bloginfo('name'); ?></p>
</footer>


<?php wp_footer(); ?>

<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	<?php $host = parse_url(site_url(), PHP_URL_HOST); ?>

	ga('create', 'UA-<?php the_field("google_analytics_id", "options"); ?>', '');
	ga('send', 'pageview');
</script>

</body>
</html>
