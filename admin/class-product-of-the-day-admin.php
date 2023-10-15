<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/arbie1234
 * @since      1.0.0
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Product_Of_The_Day
 * @subpackage Product_Of_The_Day/admin
 * @author     Arbie <arbie1234@gmail.com>
 */
class Product_Of_The_Day_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/product-of-the-day-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/product-of-the-day-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add custom post type
	 *
	 * @return void
	 */
	public function product_of_the_day_post_type_registration(){
		$labels = array(
			'name'               => 'Product of the Day',
			'singular_name'      => 'Product of the Day',
			'add_new'            => 'Add New Product of the Day',
			'add_new_item'       => 'Add New Product of the Day',
			'edit_item'          => 'Edit Product of the Day',
			'new_item'           => 'New Product of the Day',
			'all_items'          => 'All Products',
			'view_item'          => 'View Product of the Day',
			'search_items'       => 'Search Products',
			'not_found'          => 'No Products found',
			'not_found_in_trash' => 'No Products found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Product of the day',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array('slug' => 'product-of-the-day'),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
		);

    	register_post_type('product_of_the_day', $args);
	}

	/**
	 * Add product of the day custom meta field
	 *
	 * @return void
	 */
	public function add_product_of_the_day_metabox(){
		 // Add custom meta box for custom fields
    	add_meta_box('custom_field_metabox', 'Product of the day', [&$this,'product_of_the_day_metabox_callback'], 'product_of_the_day', 'normal', 'high');
	}

	/**
	 * Callback for displaying the custom field
	 *
	 * @return void
	 */
	public function product_of_the_day_metabox_callback() {
		global $post;
		$custom_field_value = get_post_meta($post->ID, 'product_of_the_day', true);
		
		// Check if the custom field is checked
		$checked = ($custom_field_value === 'on') ? 'checked' : '';
		
		echo '<label for="product_of_the_day">Product of the day:&nbsp;</label>';
		echo '<input type="checkbox" id="product_of_the_day" name="product_of_the_day" value="on" ' . $checked . ' />';

		// Provide a description if needed
		echo '<p>Check this box to enable as product of the day.</p>';
	}


	/**
	 * Hook for saving custom post type
	 *
	 * @param [type] $post_id
	 * @return void
	 */
	function save_product_of_the_day_field($post_id) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
			return $post_id;
		
		// Limit product of the day tags to 5
		// Set the earliest flag to off
		if(get_post_type() == 'product_of_the_day'){
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
				'orderby' => 'modified',
				'order'=> 'ASC',
				'posts_per_page' => '5',
			);

			$products_of_the_day = new WP_Query($args);
			if($products_of_the_day->found_posts >= 5){
				 $first_post = $products_of_the_day->posts[0];
				update_post_meta($first_post->ID, 'product_of_the_day', 'off');
			}
		}



		if ($post_id) {

			

			$product_of_the_day = $_POST['product_of_the_day'] ?? 'off';
			update_post_meta($post_id, 'product_of_the_day', sanitize_text_field($product_of_the_day));
		}
	}

	/**
	 * Hook for custom column
	 *
	 * @param [type] $columns
	 * @return void
	 */
	public function filter_product_of_the_day_columns($columns){
		$columns['product_of_the_day'] = 'Product of the Day?';
		return $columns;
	}

	/**
	 * Hook for custom column value
	 *
	 * @param [type] $column_id
	 * @param [type] $post_id
	 * @return void
	 */
	public function add_product_of_the_day_column ( $column_id, $post_id ) {
		switch( $column_id ) { 
			case 'product_of_the_day':
				$value = get_post_meta($post_id, 'product_of_the_day', true );

				if($value != null){
					echo $value == 'on' ? 'Yes':'No';
				}else{
					echo $value = 'NO';
				}
			break;
		}
	}


	/**
	 * Added menu page
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Product of the day Settings', 'product-of-the-day-settings' ),
			__( 'Product of the day Settings', 'product-of-the-day-settings' ),
			apply_filters( 'tempadmin_user_cap', 'manage_options' ),
			'product-of-the-day-settings',
			array(
				__class__,
				'admin_settings',
			),
			'dashicons-schedule',
			4
		);
	}

	/**
	 * Manage admin settings
	 *
	 * @return void
	 *
	 */
	public static function admin_settings() {

		$action              = ! empty( $_GET['action'] ) ? $_GET['action'] : '';
		$user_id             = ! empty( $_GET['user_id'] ) ? $_GET['user_id'] : '';
		$do_update           = ( 'update' === $action ) ? 1 : 0;

		$product_of_the_day_settings       = maybe_unserialize( get_option( 'product_of_the_day_settings', array() ) );
		$_template_file = PRODUCT_OF_THE_DAY_PLUGIN_DIR . '/templates/admin-settings.php';

		$product_of_the_day_email = ( ! empty( $product_of_the_day_settings ) && isset( $product_of_the_day_settings['product_of_the_day_email'] ) ) ? $product_of_the_day_settings['product_of_the_day_email'] : '';
		$block_title = ( ! empty( $product_of_the_day_settings ) && isset( $product_of_the_day_settings['block_title'] ) ) ? $product_of_the_day_settings['block_title'] : 'Product of the day';
	

		include $_template_file;
	}

	/**
	 * Manage settings
	 *
	 */
	public function update_product_of_the_day_settings() {

		if ( empty( $_POST['product_of_the_day'] ) || empty( $_POST['potd-settings-nonce'] ) || ! wp_verify_nonce( $_POST['potd-settings-nonce'], 'product_of_the_day_settings' ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$data = $_POST['product_of_the_day'];
		$product_of_the_day_email             = $data['product_of_the_day_email'] ?? NULL;
		$block_title             = $data['block_title'] ?? NULL;




		$potd_settings = array(
			'product_of_the_day_email' => $product_of_the_day_email,
			'block_title' => $block_title,
		);

		update_option( 'product_of_the_day_settings', maybe_serialize( $potd_settings ), true );

        $result = array(
            'status'  => 'success',
            'message' => 'settings_updated',
            'tab'     => 'settings',
        );

		
		$redirect_link = Product_Of_The_Day_Common::get_redirect_link( $result );

		wp_redirect($redirect_link, 302 );
		exit();
	}


}
