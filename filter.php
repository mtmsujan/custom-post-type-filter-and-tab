<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Widget_Filter extends Elementor\Widget_Base {


	

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'mixitup_filter';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Portfolio Gallery', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'filter', 'gallery', 'mixitup', 'isotope', 'portfolio' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		?>
        
		<div class="post-type-gallery">
            <ul class="category-list">
                <li class="category-button" data-filter="all">
                    <div class="icon-image">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>assets/all.png" alt="all portfolio">
                    </div>
                    <div class="category-title">
                        All
                    </div>
                </li>


                <?php 
                	$portfolio_categories = get_terms( array(
                		'taxonomy' => 'portfolio-category',
                		'hide_empty' => false, 
                		'order'	=> 'DESC'
                	) );

                	if( isset($portfolio_categories) && is_array($portfolio_categories) ) :

                	foreach( $portfolio_categories as $category ) :

                	$category_image = get_term_meta( $category->term_id, 'portfolio-category-image', true );

                ?>
                <li class="category-button" data-filter=".<?php echo $category->slug; ?>">
                    <div class="icon-image">
                        <img src="<?php echo $category_image; ?>" alt="<?php echo $category->name; ?>">
                    </div>
                    <div class="category-title">
                        <?php echo $category->name; ?>
                    </div>
                </li>

            	<?php endforeach; else : echo "No Categories Found"; endif; ?>


            </ul>

            <div class="container">
            	<?php 
            		$portfolio = new WP_Query(array(
            			'post_type' => 'portfolio',
            			'posts_per_page' => -1,
            			'order'	=> 'asc'
            		));

            		if($portfolio->have_posts()) :

            		while($portfolio->have_posts()) : $portfolio->the_post();

            		$the_cats = get_the_terms(get_the_ID(), 'portfolio-category');

            		$classes = '';

            		if( isset($the_cats) && is_array($the_cats) ){
	            		foreach($the_cats as $the_cat){
							$classes = $classes . ' ' . $the_cat->slug;
	            		}
	            	}
            	?>
                <div class="mix<?php echo $classes; ?>">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'full' ); ?>
                        <h3><?php the_title(); ?></h3>
                        
                    </a>
                </div>
                
                <?php endwhile; else : echo "No Portfolio Found"; endif; ?>

                <div class="gap"></div>
                <div class="gap"></div>
                <div class="gap"></div>
            </div>
        </div>       

		<?php 
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	
}
