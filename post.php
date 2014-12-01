<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article>
			<?php the_title('<h1>', '</h1>') ?>

			<div class="meta">
				<?php if( comments_open() ) : ?>
					<span class="comments-link">
						<?php comments_popup_link( __( 'Comment', 'less' ), __( '1 Comment', 'less' ), __( '% Comments', 'less' ) ); ?>
					</span>
				<?php endif; ?>
			</div>

			<?php if ( has_post_thumbnail()) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="post-thumbnail" >
					<?php the_post_thumbnail('medium'); ?>
				</a>
			<?php endif; ?>

			<div class="content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>

			<div class="meta">
				<div class="category"><?php echo get_the_category_list(); ?></div>
				<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
			</div>
		</article>
	<?php endwhile; ?>

	<?php
	// If comments are open or we have at least one comment, load up the comment template
	if ( comments_open() || '0' != get_comments_number() )
		comments_template( '', true );
	?>

<?php else : ?>
	<article">
		<h1>Huch, hier scheint nichts zu sein...</h1>
	</article>
<?php endif; ?>