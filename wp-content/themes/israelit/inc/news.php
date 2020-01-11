<?php

/**
 * Register a news post type.
 */
function israelit_register_news_post_type() {
    register_post_type( 'news', array(
        'labels' => array(
            'name' => _x( 'News', 'post type general name', 'israelit' ),
            'singular_name' => _x( 'News Article', 'post type singular name', 'israelit' ),
            'menu_name' => _x( 'News', 'admin menu', 'israelit' ),
            'name_admin_bar' => _x( 'News Article', 'add new on admin bar', 'israelit' ),
            'add_new' => _x( 'Add New', 'book', 'israelit' ),
            'add_new_item' => __( 'Add New News Article', 'israelit' ),
            'new_item' => __( 'New News Article', 'israelit' ),
            'edit_item' => __( 'Edit News Article', 'israelit' ),
            'view_item' => __( 'View News Article', 'israelit' ),
            'all_items' => __( 'All News', 'israelit' ),
            'search_items' => __( 'Search News', 'israelit' ),
            'parent_item_colon' => __( 'Parent News:', 'israelit' ),
            'not_found' => __( 'No news found.', 'israelit' ),
            'not_found_in_trash' => __( 'No news found in Trash.', 'israelit' )
        ),
        'description' => __( 'Description.', 'israelit' ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-megaphone',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'news' ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
    ) );

    register_taxonomy('news-category', array( 'news' ), array(
        'labels' => array(
            'name' => _x( 'Categories', 'taxonomy general name', 'israelit' ),
            'singular_name' => _x( 'Category', 'taxonomy singular name', 'israelit' ),
            'search_items' =>  __( 'Search Categories', 'israelit' ),
            'all_items' => __( 'All Categories', 'israelit' ),
            'parent_item' => __( 'Parent Category', 'israelit' ),
            'parent_item_colon' => __( 'Parent Category:', 'israelit' ),
            'edit_item' => __( 'Edit Category', 'israelit' ),
            'update_item' => __( 'Update Category', 'israelit' ),
            'add_new_item' => __( 'Add New Category', 'israelit' ),
            'new_item_name' => __( 'New Category Name', 'israelit' ),
            'menu_name' => __( 'Categories', 'israelit' ),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'news-category' ),
    ));
}
add_action( 'init', 'israelit_register_news_post_type' );

/**
 * Adds admin columns to news.
 *
 * @param array $columns
 * @return array
 */
function israelit_manage_news_posts_columns( $columns ) {
    $columns['image'] = __( 'Image', 'israelit' );
    $columns['price'] = __( 'Price', 'israelit' );

    return $columns;
}
add_filter( 'manage_news_posts_columns', 'israelit_manage_news_posts_columns' );

/**
 * Displays admin columns values.
 *
 * @param string $column
 * @param int $post_id
 */
function israelit_manage_news_posts_custom_column( $column, $post_id ) {
    if ( $column === 'image' ) {
        echo get_the_post_thumbnail( $post_id, array(80, 80) );
    }

    if ( $column === 'price' ) {
        $price = get_post_meta( $post_id, 'price_per_month', true );

        if ( ! $price ) {
            _e( 'n/a' );
        } else {
            echo '$ ' . number_format( $price, 0, '.', ',' ) . ' p/m';
        }
    }
}
add_action( 'manage_news_posts_custom_column', 'israelit_manage_news_posts_custom_column', 10, 2 );

/**
 * Makes admin columns sortable.
 *
 * @param array $columns
 * @return array
 */
function israelit_manage_edit_news_sortable_columns( $columns ) {
    $columns['price'] = 'price_per_month';

    return $columns;
}
add_filter( 'manage_edit-news_sortable_columns', 'israelit_manage_edit_news_sortable_columns');

/**
 * Makes meta values sortable.
 *
 * @param WP_Query $query
 */
function israelit_news_columns_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'price_per_month' === $query->get('orderby') ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'meta_key', 'price_per_month' );
        $query->set( 'meta_type', 'numeric' );
    }
}
add_action( 'pre_get_posts', 'israelit_news_columns_orderby' );

