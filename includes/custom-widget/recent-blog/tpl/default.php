<div class="boka-recent-blog">
	<?php if ( ! empty( $instance['title'] ) ) : ?>
		<div class="margin-bottom-30">
			<?php if ( ! empty( $instance['title'] ) ) : ?>
				<h1 class="page-header"><?php echo esc_html( $instance['title'] ); ?></h1>
			<?php endif; ?>
		</div>
	<?php endif;

	$recent_post_limit = $instance['post_limit'];
	$query_latest_blog = new WP_Query( array(
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'	  => $recent_post_limit
	) );

	?>
	<div class="recent-blog-post-widget <?php echo $instance['layout_style']; ?>-post-layout">
		<?php
		if ($query_latest_blog->have_posts()) :
			while ( $query_latest_blog->have_posts() ) : $query_latest_blog->the_post();

				$col_4 = 'col-md-12 col-sm-12 col-xs-12';
				$row = 'row';
				$col_5 = 'col-md-5 col-sm-5 col-xs-12 margin-top-30';
				$col_7 = 'col-md-7 col-sm-7 col-xs-12 margin-top-30';
				$margin = '';

				if( $instance['layout_style'] == 'default' ){
					$col_4 = 'col-md-4 col-sm-4 col-xs-12 margin-top-30';
					$row = '';
					$col_5 = '';
					$col_7 = '';
					$margin = 'margin-bottom-20';
				}
				?>
				<div class="<?php echo $col_4; ?>">
					<div class="<?php echo $row; ?>">
						<div class="<?php echo $col_5; ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-thumb">
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo get_the_post_thumbnail_url(); ?>" class="img-responsive <?php echo $margin; ?>" alt="" />
									</a>
								</div>
							<?php endif; ?>
						</div>
						<div class="<?php echo $col_7; ?>">
							<?php the_title( sprintf( '<h2 class="entry-title text-capitalize margin-null link-fix"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
							if ( 'post' === get_post_type() ) : ?>
								<div class="entry-meta margin-bottom-20 link-fix">
									<?php
									boka_posted_on();
									boka_entry_footer();
									?>
								</div><!-- .entry-meta -->
							<?php endif; ?>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>
</div>