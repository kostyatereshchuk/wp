<?php
get_header(); ?>

    <div class="container">
        <div class="row">
            <section id="primary" class="content-area col-sm-12 col-md-12 col-lg-8">
                <main id="main" class="site-main" role="main">

                    <?php woocommerce_content(); ?>

                </main>
            </section>

            <?php get_sidebar(); ?>
        </div>
    </div>

<?php
get_footer();
