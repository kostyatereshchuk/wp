<?php
/**
* Template Name: Test
 */

get_header(); ?>

    <div class="container">
        <div class="row">
            <section class="site-content col-lg-8">

                Site Logo: <?php echo get_theme_mod( 'site_logo' ); ?><br>
                Test Color: <?php echo get_theme_mod( 'customize_test_color' ); ?><br>
                Test Text: <?php echo get_theme_mod( 'customize_test_text' ); ?><br>
                Test Textarea: <?php echo get_theme_mod( 'customize_test_textarea' ); ?><br>
                Test Select: <?php echo get_theme_mod( 'customize_test_select' ); ?><br>
                Test Radio: <?php echo get_theme_mod( 'customize_test_radio' ); ?><br>
                Test Checkbox: <?php echo get_theme_mod( 'customize_test_checkbox' ); ?><br>

            </section>
        </div>
    </div>
<?php
get_footer();
