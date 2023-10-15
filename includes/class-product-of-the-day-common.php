<?php

/**
 * Class Product_Of_The_Day_Common
 */
class Product_Of_The_Day_Common {

	/**
	 * Get Redirection link
	 *
	 */
	public static function get_redirect_link( $result = array() ) {

		if ( empty( $result ) ) {
			return false;
		}

		$base_url = menu_page_url( 'product-of-the-day-settings', false );

		if ( empty( $base_url ) ) {
			return false;
		}

		$query_string = '';
		if ( ! empty( $result['status'] ) ) {
			if ( 'success' === $result['status'] ) {
				$query_string .= '&potd_success=1';
			} elseif ( 'error' === $result['status'] ) {
				$query_string .= '&potd_error=1';
			}
		}

		if ( ! empty( $result['message'] ) ) {
			$query_string .= '&potd_message=' . $result['message'];
		}

		if ( ! empty( $result['tab'] ) ) {
			$query_string .= '&tab=' . $result['tab'];
		}

		$redirect_link = $base_url . $query_string;

		return $redirect_link;

	}

}