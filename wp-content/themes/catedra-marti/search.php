<?php
/**
 * Template: Resultados de búsqueda (RF44)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

get_header();
?>

<div class="cm-container cm-section">
    <header class="cm-search-results__header">
        <h1 class="cm-section__title">
            <?php
            printf(
                /* translators: %s: Término buscado */
                esc_html__('Resultados para: "%s"', 'catedra-marti'),
                '<span>' . get_search_query() . '</span>'
            );
            ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        <p class="cm-search-results__count">
            <?php
            global $wp_query;
            printf(
                esc_html(_n(
                    'Se encontró %d resultado.',
                    'Se encontraron %d resultados.',
                    $wp_query->found_posts,
                    'catedra-marti'
                )),
                $wp_query->found_posts
            );
            ?>
        </p>

        <div class="cm-search-results__list">
            <?php while (have_posts()) : the_post(); ?>
                <article class="cm-search-results__item">
                    <span class="cm-search-results__item-type">
                        <?php
                        $post_type_obj = get_post_type_object(get_post_type());
                        echo esc_html($post_type_obj ? $post_type_obj->labels->singular_name : get_post_type());
                        ?>
                    </span>
                    <h2 class="cm-search-results__item-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="cm-search-results__item-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="cm-search-results__item-meta">
                        <span><?php echo get_the_date(); ?></span>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <?php the_posts_pagination([
            'prev_text' => '&laquo; ' . __('Anterior', 'catedra-marti'),
            'next_text' => __('Siguiente', 'catedra-marti') . ' &raquo;',
        ]); ?>
    <?php else : ?>
        <div class="cm-search-results__empty">
            <p><?php esc_html_e('No se encontraron resultados para tu búsqueda.', 'catedra-marti'); ?></p>
            <p><?php esc_html_e('Intenta con otros términos o explora las secciones del portal.', 'catedra-marti'); ?></p>
            <?php get_search_form(); ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
