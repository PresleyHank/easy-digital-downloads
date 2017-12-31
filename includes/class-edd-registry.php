<?php
/**
 * Registry utility superclass
 *
 * This class should be extended to create object registries.
 *
 * @package     EDD
 * @subpackage  Classes/Utilities
 * @copyright   Copyright (c) 2018, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
 */

/**
 * Defines the construct for building an item registry.
 *
 * @since 3.0.0
 * @abstract
 */
abstract class EDD_Registry extends \ArrayObject {

	/**
	 * Adds an item to the registry.
	 *
	 * @since 3.0
	 *
	 * @throws EDD_Exception If the `$attributes` array is empty.
	 *
	 * @param string $item_id    Item ID.
	 * @param array  $attributes Array of item attributes. Each extending registry will
	 *                          handle item ID and attribute building in different ways.
	 * @return bool True if `$attributes` is not empty, otherwise false.
	 */
	public function add_item( $item_id, $attributes ) {
		$result = false;

		if ( ! empty( $attributes ) ) {
			$this->offsetSet( $item_id, $attributes );

			$result = true;
		} else {

			$message = sprintf( "The attributes were missing when attempting to add item '%s'.", $item_id );

			throw new \EDD_Exception( $message );
		}

		return $result;
	}

	/**
	 * Removes an item from the registry by ID.
	 *
	 * @since 3.0
	 *
	 * @param string $item_id Item ID.
	 */
	public function remove_item( $item_id ) {
		if ( $this->offsetExists( $item_id ) ) {
			return $this->offsetUnset( $item_id );
		}
	}

	/**
	 * Retrieves an item and its associated attributes.
	 *
	 * @since 3.0
	 *
	 * @throws EDD_Exception if the item does not exist.
	 *
	 * @param string $item_id Item ID.
	 * @return array Array of attributes for the item if the item is set,
	 *               otherwise an empty array.
	 */
	public function get_item( $item_id ) {

		$item = array();

		if ( $this->offsetExists( $item_id ) ) {

			$item = $this->offsetGet( $item_id );

		} else {

			$message = sprintf( "The item '%s' does not exist.", $item_id );

			throw new \EDD_Exception( $message );
		}

		return $item;
	}

	/**
	 * Retrieves registered items.
	 *
	 * @since 3.0
	 *
	 * @return array The list of registered items.
	 */
	public function get_items() {
		return $this->getArrayCopy();
	}

	/**
	 * Only intended for use by tests.
	 *
	 * @since 3.0
	 */
	public function _reset_items() {
		if ( ! defined( 'WP_TESTS_DOMAIN' ) ) {
			_doing_it_wrong( 'This method is only intended for use in phpunit tests', '3.0' );
		} else {
			$this->exchangeArray( array() );
		}
	}

}