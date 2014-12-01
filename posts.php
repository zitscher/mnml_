<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article>
			<a href="<?php the_permalink(); ?>" title="<?php the_title('<h1>', '</h1>'); ?>">
				<?php the_title('<h1>', '</h1>') ?>
			</a>

			<div class="meta">
				<?php if( comments_open() ) : ?>
					<span class="comments-link">
						<?php comments_popup_link( __( 'Comment', 'break' ), __( '1 Comment', 'break' ), __( '% Comments', 'break' ) ); ?>
					</span>
				<?php endif; ?>
			</div>

			<?php if ( has_post_thumbnail()) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="post-thumbnail" >
					<?php the_post_thumbnail('medium'); ?>
				</a>
			<?php endif; ?>

			<div class="content">
				<?php the_content( 'Continue...' ); ?>

				<?php wp_link_pages(); ?>
			</div>

			<div class="meta">
				<div class="category"><?php echo get_the_category_list(); ?></div>
				<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
			</div>
		</article>
	<?php endwhile; ?>

	<div id="pagination">
		<div class="past-page"><?php previous_posts_link( 'Newer &raquo;' ); ?></div>
		<div class="next-page"><?php next_posts_link( ' &laquo; Older' ); ?></div>
	</div>

<?php else : ?>
	<article class="post error">
		<h1 class="404">Huch, hier scheint nichts zu sein...</h1>
	</article>
<?php endif; ?>