<?php 

/*
Plugin name: Sujan Custom Filter And Tab
Plugin URI: https://theitgeneralist.co
Author: Md Toriqul Mowla Sujan 
Author URI: http://mtmsujan.com 
Version: 1.0 
Description: Custom Plugin to add custom post type - mixitup gallery and custom tab
*/

// portfolio category taxonomy

function sujan_create_book_tax() {
    register_taxonomy( 'portfolio-category', 'portfolio', array(
        'label'        => __( 'Categories', 'sujan' ),
        'rewrite'      => array( 'slug' => 'portfolio-cat' ),
        'hierarchical' => true,
    ) );
}
add_action( 'init', 'sujan_create_book_tax', 0 );

// custom image field in portfolio category

add_action( 'portfolio-category_add_form_fields', 'sujan_add_term_fields' );

function sujan_add_term_fields( $taxonomy ) {

	echo '<div class="form-field">
	<label for="portfolio-category-image">Upload Category Image</label>
	<input type="text" class="category-image-input" name="portfolio-category-image" id="portfolio-category-image" />
	<button class="primary-button cat-img-btn">Upload image</button>
	</div>';

}


add_action( 'portfolio-category_edit_form_fields', 'sujan_edit_term_fields', 10, 2 );

function sujan_edit_term_fields( $term, $taxonomy ) {

	$value = get_term_meta( $term->term_id, 'portfolio-category-image', true );
	
	echo '<tr class="form-field">
	<th>
		<label for="portfolio-category-image">Category Image</label>
	</th>
	<td>
		<input class="category-image-input" name="portfolio-category-image" id="portfolio-category-image" type="text" value="' . esc_attr( $value ) .'" />
		<button class="primary-button cat-img-btn">Upload image</button>
	</td>
	</tr>';

}


add_action( 'created_portfolio-category', 'category_save_term_fields' );
add_action( 'edited_portfolio-category', 'category_save_term_fields' );

function category_save_term_fields( $term_id ) {

	update_term_meta(
		$term_id,
		'portfolio-category-image',
		sanitize_text_field( $_POST[ 'portfolio-category-image' ] )
	);

}

add_filter( 'simple_register_taxonomy_settings', 'category_image_fields' );

function category_image_fields( $fields ) {

	$fields[] = array(
 		'id'	=> 'portfolio-category-img',
 		'taxonomy' => array( 'portfolio-category' ),
 		'fields' => array(
			array(
				'id' => 'portfolio-category-image',
				'label' => 'Category Image',
				'type' => 'text',
			),
 		)
 	);

	return $fields;

}

// image upload script

add_action('admin_enqueue_scripts', function(){
	wp_enqueue_media();
	wp_enqueue_script('cat-img-btn-script', plugin_dir_url(__FILE__).'assets/custom.js', array('jquery', 'media-upload'), '1.0.0', true);
});

// custom styles and scripts 

add_action('wp_enqueue_scripts', function(){
	wp_enqueue_script('mixitup_filter', plugin_dir_url(__FILE__).'assets/mixitup.min.js', array(), '1.0.0', true);

	wp_enqueue_script('mixitup_custom', plugin_dir_url(__FILE__).'assets/script.js', array('mixitup_filter'), '1.0.0', true);

	wp_enqueue_style('mixitup_reset', plugin_dir_url(__FILE__).'assets/reset.css');

	wp_enqueue_style('mixitup_style', plugin_dir_url(__FILE__).'assets/custom-styles.css');


	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('frontend_custom', plugin_dir_url(__FILE__).'assets/frontend-custom.js', array('jquery-ui-tabs'), '1.0.0', true);
});



// register elementor widgets 

add_action( 'elementor/widgets/register', function(){
	require_once(__DIR__.'/filter.php');
	require_once(__DIR__.'/tabs.php');

	Elementor\Plugin::instance()->widgets_manager->register( new Widget_Filter );
	Elementor\Plugin::instance()->widgets_manager->register( new Widget_Tabs );

});


