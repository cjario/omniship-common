<?php
/**
 * Omniship class
 */

namespace Omniship;

use Omniship\Common\CarrierFactory;
use Omniship\Common\Http\ClientInterface;

/**
 * Omniship class
 *
 * Provides static access to the carrier factory methods.  This is the
 * recommended route for creation and establishment of shipping carrier
 * objects via the standard CarrierFactory.
 *
 * Example:
 *
 * <code>
 *   // Create a carrier for Correios
 *   // (routes to CarrierFactory::create)
 *   $carrier = Omniship::create('Correios');
 *
 *   // Initialise the carrier
 *   $carrier->initialize(...);
 *
 *   // Get the carrier parameters.
 *   $parameters = $carrier->getParameters();
 *
 *   // Do an shipping quote query on the carrier
 *   if ($carrier->supportsQuote()) {
 *       $carrier->quote(...);
 *   } else {
 *       throw new \Exception('Carrier does not support quote()');
 *   }
 * </code>
 *
 * For further code examples see the *omniship-example* repository on github.
 *
 * @method static array  all()
 * @method static array  replace(array $carriers)
 * @method static string register(string $className)
 * @method static array  find()
 * @method static array  getSupportedCarriers()
 * @codingStandardsIgnoreStart
 * @method static \Omniship\Common\CarrierInterface create(string $class, ClientInterface $httpClient = null, \Symfony\Component\HttpFoundation\Request $httpRequest = null)
 * @codingStandardsIgnoreEnd
 *
 * @see \Omniship\Common\CarrierFactory
 */
class Omniship
{

    /**
     * Internal factory storage
     *
     * @var CarrierFactory
     */
    private static $factory;

    /**
     * Get the carrier factory
     *
     * Creates a new empty CarrierFactory if none has been set previously.
     *
     * @return CarrierFactory A CarrierFactory instance
     */
    public static function getFactory()
    {
        if (is_null(self::$factory)) {
            self::$factory = new CarrierFactory;
        }

        return self::$factory;
    }

    /**
     * Set the carrier factory
     *
     * @param CarrierFactory $factory A CarrierFactory instance
     */
    public static function setFactory(CarrierFactory $factory = null)
    {
        self::$factory = $factory;
    }

    /**
     * Static function call router.
     *
     * All other function calls to the Omniship class are routed to the
     * factory.  e.g. Omniship::getSupportedCarriers(1, 2, 3, 4) is routed to the
     * factory's getSupportedCarriers method and passed the parameters 1, 2, 3, 4.
     *
     * Example:
     *
     * <code>
     *   // Create a carrier for Correios
     *   $carrier = Omniship::create('Correios');
     * </code>
     *
     * @see CarrierFactory
     *
     * @param string $method     The factory method to invoke.
     * @param array  $parameters Parameters passed to the factory method.
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $factory = self::getFactory();

        return call_user_func_array(array($factory, $method), $parameters);
    }
}
