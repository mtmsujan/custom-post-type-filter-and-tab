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
class Widget_Tabs extends Elementor\Widget_Base {

	public function __construct($data = [], $args = null) {
	  parent::__construct($data, $args);

	  wp_register_script('frontend_custom', plugin_dir_url(__FILE__).'assets/frontend-custom.js', array('jquery-ui-tabs'), '1.0.0', true);
	}

	public function get_script_depends() {
	   return [ 'jquery-ui-tabs' ];
	}

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
		return 'design-process';
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
		return esc_html__( 'Design Process', 'elementor' );
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
		return 'eicon-flow';
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
		return [ 'design', 'design process', 'work', 'work process', 'tab', 'tabs' ];
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
        
		<div id="tabs" class="tabs">
		  <ul>
		  	<?php 
		  	$workprocess = new WP_Query(array(
		  		'post_type' => 'workprocess',
		  		'posts_per_page' => -1,
		  		'order'	=> 'asc'
		  	));

		  	if($workprocess->have_posts()) :

		  	while($workprocess->have_posts()) : $workprocess->the_post(); 


		  	?>
			    <li class="process">

			    	<a class="process-link" href="#<?php echo get_post_field( 'post_name', get_post() ); ?>">
			    		
			    		<?php the_post_thumbnail(' main-image'); ?>
			    		<h3 class="process-title"><?php the_title(); ?></h3>			    		
			    	</a>
			    </li>
			<?php endwhile; endif; ?>
		  </ul>
		  <?php 
		  	$workprocess = new WP_Query(array(
		  		'post_type' => 'workprocess',
		  		'posts_per_page' => -1
		  	));

		  	if($workprocess->have_posts()) :

		  	while($workprocess->have_posts()) : $workprocess->the_post(); 
		  ?>
		  <div class="process-content" id="<?php echo get_post_field( 'post_name', get_post() ); ?>">
		  	<div class="left-side">
		  		<img src="<?php echo get_template_directory_uri(); ?>/img/process/process_detail_01.png" alt="process-image">
		  	</div>
		  	<div class="right-side">
		  		<h2><?php the_title(); ?></h2>
		  		<?php the_content(); ?>
		  	</div>
		    
		  </div>
		  <?php endwhile; endif; ?>
		</div>

		<?php 
	}


	
}
