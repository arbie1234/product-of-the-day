<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://github.com/arbie1234
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/public
 * @author     Arbie <arbie1234@gmail.com>
 */
class Product_Of_The_Day_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
    	add_shortcode('product-of-the-day', [$this,'product_of_the_day']);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Of_The_Day_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Of_The_Day_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-of-the-day-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Product_Of_The_Day_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Product_Of_The_Day_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-of-the-day-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Handles the display of the products of the day
	 *
	 */
	public function product_of_the_day(){
		ob_start();
		$product_of_the_day_settings       = maybe_unserialize( get_option( 'product_of_the_day_settings', array() ) );
		$block_title = ( ! empty( $product_of_the_day_settings ) && isset( $product_of_the_day_settings['block_title'] ) ) ? $product_of_the_day_settings['block_title'] : 'Product of the day';

		$args = array(
			'post_type' => 'product_of_the_day',
			'posts_per_page' => -1, 
			'meta_query' => array(
				array(
					'key' => 'product_of_the_day',
					'value' => 'on',
					'compare' => '=', 
				),
			),
    		'orderby'        => 'rand',
			'posts_per_page' => '1',
		);

		$content = '';
		$products_of_the_day = new WP_Query($args);
		if ($products_of_the_day->have_posts()) {
			while ($products_of_the_day->have_posts()) {
				$products_of_the_day->the_post();
				?>
				<div>
					<div style="text-align:center;font-size:20px;font-weight:600"><?= $block_title ?></div>
					<div style="max-width: 200px; margin: auto; padding: 10px; border: 1px solid #c7c7c7; border-radius: 5px; box-shadow: 1px 1px 9px 0px #b1b1b1;">
						<div style=" text-align: center; margin-bottom: 5px; font-size: 20px; font-weight: 500; "><?= the_title() ?></div>
						<div>
							<img src="<?= get_the_post_thumbnail_url() ?>">
						</div>
						<div style=" font-size: 12px; margin-top: 10px; margin-bottom: 10px; "><?= wp_trim_words(get_the_excerpt(),10) ?></div>
						<div>
							<a style="text-align: center; text-transform: uppercase; background: #6dc371; padding: 5px; color: white; width: 100%; display: block; font-weight: 600; border-radius: 4px;" href="<?= get_permalink() ?>">Go to product</a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		wp_reset_postdata();
        $content = ob_get_clean(); // store buffered output content.
    	return $content; // Return the content.
	}


	public function track_page_click(){
		global $wpdb;
		$main_post = get_post(get_the_ID());
		if(get_post_type() == 'product_of_the_day'){
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}


			$post_id = get_post()->ID;
			$table_name = $wpdb->prefix . 'call_to_action_clicks';

			$wpdb->insert( $table_name, [
					'ip_address' => $ip, 
					'product_post_id' => $post_id
				],
				['%s', '%s'] 
			);
		}
	}



}
