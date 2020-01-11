<?php
get_header(); ?>

    <div class="container">
        <div class="row">
            <section id="primary" class="content-area col-sm-12 col-lg-8">
                <main id="main" class="site-main" role="main">

                    <?php
                    if (have_posts()) : ?>

                        <header class="page-header">
                            <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'israelit'), '<span>' . get_search_query() . '</span>'); ?></h1>
                        </header>

                        <?php
                        while (have_posts()) : the_post();

                            get_template_part('template-parts/content', 'search');

                        endwhile;

                        the_posts_navigation();

                    else :

                        get_template_part('template-parts/content', 'none');

                    endif; ?>

                </main>
            </section>

            <?php get_sidebar(); ?>
        </div>
    </div>

<?php
get_footer();
