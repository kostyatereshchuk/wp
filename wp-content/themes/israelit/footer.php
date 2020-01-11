	</main><!-- #site-main -->


    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="social">
                <a href="<?php echo get_theme_mod( 'facebook_url' ); ?>" target="_blank">
                    <i class="fab fa-facebook-square"></i>
                </a>
                <a href="<?php echo get_theme_mod( 'linkedin_url' ); ?>" target="_blank">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="mailto:<?php echo get_theme_mod( 'email' ); ?>">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="tel:<?php echo get_theme_mod( 'phone' ); ?>">
                    <i class="fas fa-phone"></i>
                </a>
            </div>
            <div class="copyright">
                <?php echo get_theme_mod( 'site_copyright' ); ?>
            </div>
        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>