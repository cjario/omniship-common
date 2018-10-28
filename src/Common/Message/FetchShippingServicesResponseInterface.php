<?php
/**
 * Fetch Shipping Services Response interface
 */

namespace Omniship\Common\Message;

/**
 * Fetch Shipping Services Response interface
 *
 * This interface class defines the functionality of a response
 * that is a "fetch shipping service" response.  It extends the ResponseInterface
 * interface class with some extra functions relating to the
 * specifics of a response to fetch the shipping service from the carrier.
 * This happens when the carrier needs the customer to choose a
 * shipping service.
 *
 * @see ResponseInterface
 * @see \Omniship\Common\ShippingService
 */
interface FetchShippingServicesResponseInterface extends ResponseInterface
{
    /**
     * Get the returned list of shipping services.
     *
     * These represent separate shipping services which the user must choose between.
     *
     * @return \Omniship\Common\ShippingService[]
     */
    public function getShippingServices();
}
