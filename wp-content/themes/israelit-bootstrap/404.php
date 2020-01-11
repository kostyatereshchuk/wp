<?php
get_header(); ?>

    <div class="container">
        <div class="row">
            <section id="primary" class="content-area col-sm-12 col-lg-8">
                <main id="main" class="site-main" role="main">

                    <section class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'israelit'); ?></h1>
                        </header>

                        <div class="page-content">
                            <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'israelit'); ?></p>

                            <?php
                            get_search_form();
                            ?>

                        </div>
                    </section>

                </main>
            </section>

            <?php get_sidebar(); ?>
        </div>
    </div>

<?php
get_footer();
