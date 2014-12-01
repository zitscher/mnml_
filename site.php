<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article>
			<div class="content">
				<?php the_content(); ?>

				<?php wp_link_pages(); ?>
			</div>
		</article>
	<?php endwhile; ?>
<?php else : ?>
	<article>
		<h1 class="404">Huch, hier scheint nichts zu sein...</h1>
	</article>

<?php endif; ?>