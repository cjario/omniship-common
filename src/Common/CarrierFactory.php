<?php
/**
 * Omniship Carrier Factory class
 */

namespace Omniship\Common;

use Omniship\Common\Exception\RuntimeException;
use Omniship\Common\Http\ClientInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Omniship Carrier Factory class
 *
 * This class abstracts a set of companies that can be independently
 * registered, accessed, and used.
 *
 * Note that static calls to the Omniship class are routed to this class by
 * the static call router (__callStatic) in Omniship.
 *
 * Example:
 *
 * <code>
 *   // Create a carrier for the Correios Shipping Carrier
 *   // (routes to CarrierFactory::create)
 *   $carrier = Omniship::create('Correios');
 * </code>
 *
 * @see \Omniship\Omniship
 */
class CarrierFactory
{
    /**
     * Internal storage for all available companies
     *
     * @var array
     */
    private $companies = array();

    /**
     * All available companies
     *
     * @return array An array of carrier names
     */
    public function all()
    {
        return $this->companies;
    }

    /**
     * Replace the list of available companies
     *
     * @param array $companies An array of carrier names
     */
    public function replace(array $companies)
    {
        $this->companies = $companies;
    }

    /**
     * Register a new carrier
     *
     * @param string $className Carrier name
     */
    public function register($className)
    {
        if (!in_array($className, $this->companies)) {
            $this->companies[] = $className;
        }
    }

    /**
     * Create a new carrier instance
     *
     * @param string               $class       Carrier name
     * @param ClientInterface|null $httpClient  A HTTP Client implementation
     * @param HttpRequest|null     $httpRequest A Symfony HTTP Request implementation
     * @throws RuntimeException                 If no such carrier is found
     * @return CarrierInterface                 An object of class $class is created and returned
     */
    public function create($class, ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        $class = Helper::getCarrierClassName($class);

        if (!class_exists($class)) {
            throw new RuntimeException("Class '$class' not found");
        }

        return new $class($httpClient, $httpRequest);
    }
}
