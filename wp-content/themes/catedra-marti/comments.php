<?php
/**
 * Template: Comentarios
 * Soporta moderación previa (RF21)
 *
 * @package CatedraMarti
 * @since   1.0.0
 */

if (post_password_required()) {
    return;
}
?>

<section id="comments" class="cm-comments">

    <?php if (have_comments()) : ?>
        <h2 class="cm-comments__title">
            <?php
            $comment_count = get_comments_number();
            printf(
                esc_html(_n(
                    '%d comentario',
                    '%d comentarios',
                    $comment_count,
                    'catedra-marti'
                )),
                $comment_count
            );
            ?>
        </h2>

        <ol class="cm-comments__list">
            <?php
            wp_list_comments([
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => 'cm_custom_comment',
            ]);
            ?>
        </ol>

        <?php the_comments_pagination([
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
        ]); ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="cm-comments__closed">
            <?php esc_html_e('Los comentarios están cerrados para esta publicación.', 'catedra-marti'); ?>
        </p>
    <?php endif; ?>

    <?php
    comment_form([
        'title_reply'          => __('Deja tu comentario', 'catedra-marti'),
        'title_reply_to'       => __('Responder a %s', 'catedra-marti'),
        'cancel_reply_link'    => __('Cancelar respuesta', 'catedra-marti'),
        'label_submit'         => __('Enviar comentario', 'catedra-marti'),
        'comment_notes_before' => '<p class="cm-comments__notice">' .
            esc_html__('Tu comentario será revisado antes de ser publicado.', 'catedra-marti') .
            '</p>',
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' .
            esc_html__('Comentario', 'catedra-marti') .
            '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
    ]);
    ?>

</section>

<?php
/**
 * Callback personalizado para renderizar cada comentario.
 */
function cm_custom_comment($comment, $args, $depth)
{
    $tag = ($args['style'] === 'div') ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('cm-comment'); ?>>
        <article class="cm-comment__body">
            <header class="cm-comment__header">
                <div class="cm-comment__avatar">
                    <?php echo get_avatar($comment, $args['avatar_size']); ?>
                </div>
                <div class="cm-comment__meta">
                    <cite class="cm-comment__author"><?php comment_author_link(); ?></cite>
                    <time class="cm-comment__date" datetime="<?php comment_date('c'); ?>">
                        <?php
                        printf(
                            '%s a las %s',
                            get_comment_date(),
                            get_comment_time()
                        );
                        ?>
                    </time>
                </div>
            </header>

            <?php if ($comment->comment_approved === '0') : ?>
                <p class="cm-comment__moderation">
                    <?php esc_html_e('Tu comentario está pendiente de moderación.', 'catedra-marti'); ?>
                </p>
            <?php endif; ?>

            <div class="cm-comment__content">
                <?php comment_text(); ?>
            </div>

            <div class="cm-comment__actions">
                <?php
                comment_reply_link(array_merge($args, [
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<span class="cm-comment__reply">',
                    'after'     => '</span>',
                ]));

                edit_comment_link(
                    __('Editar', 'catedra-marti'),
                    '<span class="cm-comment__edit">',
                    '</span>'
                );
                ?>
            </div>
        </article>
    <?php
}
