<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package jm
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="page-writing">	
				<section id="featured">
					<?php 
					
					// Query
					$posts = get_field('featured'); 
					// Loop
					if ( $posts ):
						foreach ( $posts as $post ):
					
					?>				
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>						
						<header>
							<span class="sticky-post">Featured</span>
							
							<div class="feature-title">								
								<div class=""><a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a></div>
								<div class="entry-meta">
								<?php 
								$categories = get_the_category();
									foreach ( $categories as $category ) {
										$parent_name = get_the_category_by_ID($category->parent);
										if ( $parent_name == 'Publisher' ) {
											echo '<div class="publisher" title="This article was originally published by '. $category->name . '">' . $category->name . '</div>';
										}
									}
								?>	
								</div>
								<div class="featured-img">							
								<?php echo get_the_post_thumbnail($post->ID, 'medium'); ?>
								</div>
							</div>
							
						</header>
						
					</article>				
					<?php 
						
						endforeach;
						else :
							echo 'No posts have been selected';
					endif;
					?>
				</section><!-- #featured --> 
				<section id="recent-posts" class="recent-writing">	
				<div id="myBtnContainer">
				<button class="btn active" onclick="filterSelection('all')"> Show all</button>
				<button class="btn" onclick="filterSelection('article')"> Article</button>
				<button class="btn" onclick="filterSelection('blog')"> Blog</button>
				</div>
					<?php
					
					// WP_Query arguments
					$args = array(
						'post_type' => array( 'post' ),
						'posts_per_page'   => -1
					);

					// The Query
					$query = new WP_Query( $args );

					// The Loop
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post(); 
							
							$cats = get_the_category();
							//var_dump($cat);
							?>

							<div class="entry filterDiv <?php foreach ( $cats as $cat ) { echo $cat->slug, ' '; } ?>"> 
								<a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>
								<div class="entry-meta">
								<?php 
									$categories = get_the_category();
									foreach ( $categories as $category ) {
										$parent_name = get_the_category_by_ID($category->parent);
										if ( $parent_name == 'Publisher' ) {
											echo '<div class="publisher" title="This article was originally published by '. $category->name . '">' . $category->name . '</div>';
										}
									}
								?>									
								</div>
							</div>


					<?php	}
					} else {
						// no posts found
					}
						
						// Restore original Post Data
						wp_reset_postdata();

					?>
				</section>				
			</div><!-- .entry-content -->			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();