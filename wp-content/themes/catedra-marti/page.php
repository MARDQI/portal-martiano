<?php
/**
 * Template: Página estática
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <?php while (have_posts()) : the_post(); ?>
        <article class="cm-page">
            <h1 class="cm-page__title"><?php the_title(); ?></h1>
            <div class="cm-page__content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php
get_footer();
