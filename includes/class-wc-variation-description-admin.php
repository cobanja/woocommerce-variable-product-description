<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class WC_Variation_Description_Admin.
 *
 * Admin settings class.
 *
 * @class       WC_Variation_Description_Admin
 * @version     1.0.0
 * @author      Daniel Espinoza
 */

class WC_Variation_Description_Admin {

	/*
	 *
	 */
	function __construct() {

		$this->wc_variation_description_hooks();

	}

	/**
	 * All the hooks
	 *
	 */
	public function wc_variation_description_hooks() {

		// hook into the variations panel
		add_action('woocommerce_product_after_variable_attributes', array( $this , 'output_variation_description'), 30, 3 );

		// handle saving the variation
		add_action('woocommerce_process_product_meta_variable', array( $this , 'save_variation_description'), 30);


	}

	/**
	 * Output this variation's description to the Product Data tab.
	 *
	 * @param int $loop
	 * @param $variation_data
	 * @param $variation
	 */
	public function output_variation_description( $loop, $variation_data, $variation ){

		// get variation

		// output the variation


		$_variable_description = get_post_meta( $variation->ID , '_variation_description', true );

		echo "<tr class=\"variation_description\"><td colspan=\"2\"><label>";
		echo __( 'Description:', 'woocommerce' );
		echo "</label>";
		echo "<textarea name=\"variation_description[" . $loop . "]\" cols=\"5\" rows=\"5\" placeholder=\"\">" . $_variable_description . "</textarea>";
		echo "</td><td>";
		echo "</tr>";
	}

	/**
	 * Save the variations to the post meta
	 *
	 * @param int $post_id
	 */
	public function save_variation_description( $post_id ){

		if ( isset( $_POST['variable_sku'] ) ) {

			$variable_post_id = $_POST['variable_post_id'];
			$_variation_description = array();

			if ( ! empty( $_POST['variation_description'] ) ) {
				$_variation_description = $_POST['variation_description'];
			}

			$max_loop = max( array_keys( $_POST['variable_post_id'] ) );

			for ( $i = 0; $i <= $max_loop; $i ++ ) {

				if ( ! isset( $variable_post_id[ $i ] ) ) {
					continue;
				}
				$variation_id = absint( $variable_post_id[ $i ] );

				update_post_meta( $variation_id, '_variation_description', wc_clean( $_variation_description[ $i ] ) );

			}
		}

	}

}

return new WC_Variation_Description_Admin();