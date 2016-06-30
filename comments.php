<?php
    if (post_password_required()) {
        return;
    }
?>

<div id="comments" class="comments">
    <?php if (have_comments()) : ?>

        <h2 class="comments-title">
            <?php
                printf(_n('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'scaffolder'),
                    number_format_i18n(get_comments_number()), get_the_title());
            ?>
        </h2>

        <?php scaffolder_comment_nav(); ?>

        <ol class="comment-list">
            <?php
                wp_list_comments(array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 56,
                ));
            ?>
        </ol>

        <?php scaffolder_comment_nav(); ?>

        <?php if (! comments_open()) : ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'scaffolder'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php comment_form(); ?>
</div>