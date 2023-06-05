<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package IKONIC
 */

get_header();

?>

<article class="blogCategorySec">
	<div class="container">
		<div class="colsHolder">
			  <?php
					if(have_posts()){
						while (have_posts()) :
							the_post();
							$thumburl=get_the_post_thumbnail_url();
							?>
							<div class="chCol chCol4">
								<a href="<?php echo get_the_permalink() ?>" class="blogCatPost">
									<div class="imgHolder">
										<img src="<?php echo $thumburl ?>" alt="image description">
									</div>
									<h3><?php echo the_title() ?></h3>
								</a>
							</div>
							<?php    
						endwhile;?>
						<ul class="pagination"><?php echo paginate_links(array('total' => $wp_query->max_num_pages)); ?></ul><?php
					} ?>
		</div>
	</div>
</article>
<?php
get_footer();
