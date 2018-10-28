<?php
/**
 * Cart Item interface
 */

namespace Omniship\Common;

/**
 * Cart Item interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface ItemInterface
{
    /**
     * Name of the item
     */
    public function getName();

    /**
     * Quantity of the item
     */
    public function getQuantity();

    /**
     * Weight of the item
     */
    public function getWeight();

    /**
     * Price of the item
     */
    public function getPrice();
}
