<?php
/**
 * Shipping Service
 */

namespace Omniship\Common;

/**
 * Shipping Service
 *
 * This class defines a shipping service to be used in the Omniship system.
 *
 * @see Issuer
 */
class ShippingService
{

    /**
     * The ID of the shipping service.
     *
     * @var string
     */
    protected $id;

    /**
     * The full name of the shipping service
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new ShippingService
     *
     * @param string $id   The identifier of this shipping service
     * @param string $name The name of this shipping service
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * The identifier of this shipping service
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The name of this shipping service
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
