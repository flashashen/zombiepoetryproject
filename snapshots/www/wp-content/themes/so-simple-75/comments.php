<?php
/**
 * The template for displaying Comments.
 *
 * @package so-simple-75
 */

if (post_password_required())
    return;
?>
<div class="comments-wrap">
    <div class="clearfix"></div>

    <h6 class="comment-title">
        <?php printf(_nx('1 Comment', '%1$s Comments', get_comments_number(), 'comments number', 'so-simple-75'), number_format_i18n(get_comments_number())); ?>
    </h6>

    <div id="comments" class="comments-area ">

        <?php if (have_comments()) : ?>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                <nav id="comment-nav-above" class="comment-navigation" role="navigation">
                    <h1 class="screen-reader-text"><?php _e('Comment navigation', 'so-simple-75'); ?></h1>

                    <div
                        class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'so-simple-75')); ?></div>
                    <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'so-simple-75')); ?></div>
                </nav><!-- #comment-nav-above -->
            <?php endif; // check for comment navigation ?>

            <ol class="comment-list">
                <?php wp_list_comments(array('callback' => 'sosimplecomment')); ?>
            </ol><!-- .comment-list -->

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
                <nav id="comment-nav-below" class="comment-navigation" role="navigation">
                    <h1 class="screen-reader-text"><?php _e('Comment navigation', 'so-simple-75'); ?></h1>

                    <div
                        class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'so-simple-75')); ?></div>
                    <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'so-simple-75')); ?></div>
                </nav><!-- #comment-nav-below -->
            <?php endif; // check for comment navigation ?>

        <?php endif; // have_comments() ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
            ?>
            <p class="no-comments"><?php _e('Comments are closed.', 'so-simple-75'); ?></p>
        <?php endif; ?>

        <?php
        ob_start();
        comment_form(
            array(
                'title_reply' => __('Leave Your Reply', 'so-simple-75'),
                'comment_notes_after'=>'',
                'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_attr( 'Comment', 'so-simple-75' ) . '</label>' .
                ( $req ? ' <span class="required">*</span>' : '' ) .
                '<br /><textarea id="comment" name="comment" class="form-control full" rows="5"></textarea></p>',
                'fields' => apply_filters('comment_form_default_fields', array(
                        'author' =>
                            '<p class="comment-form-author">' .
                            '<label for="author">' . __('Name', 'so-simple-75') . '</label> ' .
                            ($req ? '<span class="required">*</span>' : '') .
                            '<input id="author" class="full" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
                            '" size="30" /></p>',

                        'email' =>
                            '<p class="comment-form-email"><label for="email">' . __('Email', 'so-simple-75') . '</label> ' .
                            ($req ? '<span class="required">*</span>' : '') .
                            '<input id="email" class="full" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) .
                            '" size="30" /></p>',

                    )
                ),
            )
        );
        $string = ob_get_contents();
        $string = str_replace('<input name="submit"', '<input class="btn btn-primary" name="submit" ', $string);
        ob_end_clean();

        echo $string;
        ?>

    </div>
    <!-- #comments -->
</div>