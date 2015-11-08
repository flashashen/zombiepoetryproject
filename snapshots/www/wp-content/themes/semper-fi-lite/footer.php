    </div>

    <div class="finishing"></div>
    
</main>    

<footer>
    <?php if ( ( get_theme_mod('footer_text_setting') != 'Replace the text in the footer' ) && ( get_theme_mod('footer_text_setting') != '' ) ) : ?>
    
    <p><?php echo get_theme_mod('footer_text_setting') ;?>
    
    <?php else : ?>
    
    <p><?php _e('Good Old Fashioned Hand Written Code by', 'localize_adventure'); ?> <a href="http://schwarttzy.com/about-2/">Eric J. Schwarz</a>
        
    <?php endif; ?><!-- <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds --></p></footer>

<!-- Start of WordPress Footer  -->
<?php wp_footer(); ?>
<!-- End of WordPress Footer -->
    
</body>
</html>