<?php
/**
 * Shipping carrier interface
 */

namespace Omniship\Common;

/**
 * Shipping carrier interface
 *
 * This interface class defines the standard functions that any
 * Omniship carrier needs to define.
 *
 * @see AbstractCarrier
 *
 * @method \Omniship\Common\Message\RequestInterface quote(array $parameters = array())               (Optional method)
 *
 * @method \Omniship\Common\Message\RequestInterface track(array $parameters = array())               (Optional method)
 *
 */
interface CarrierInterface
{
    /**
     * Get carrier display name
     *
     * This can be used by carts to get the display name for each carrier.
     * @return string
     */
    public function getName();

    /**
     * Get carrier short name
     *
     * This name can be used with CarrierFactory as an alias of the carrier class,
     * to create new instances of this carrier.
     * @return string
     */
    public function getShortName();

    /**
     * Define carrier parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     * );
     * @return array
     */
    public function getDefaultParameters();

    /**
     * Initialize carrier with parameters
     * @param array $parameters
     * @return $this
     */
    public function initialize(array $parameters = array());

    /**
     * Get all carrier parameters
     * @return array
     */
    public function getParameters();
}
