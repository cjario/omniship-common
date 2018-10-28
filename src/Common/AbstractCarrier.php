<?php
/**
 * Base shipping commpany class
 */

namespace Omniship\Common;

use Omniship\Common\Http\Client;
use Omniship\Common\Http\ClientInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Base shipping carrier class
 *
 * This abstract class should be extended by all shipping carriers
 * throughout the Omniship system.  It enforces implementation of
 * the CarrierInterface interface and defines various common attibutes
 * and methods that all carriers should have.
 *
 * Example:
 *
 * <code>
 *   // Initialise the carrier
 *   $carrier->initialize(...);
 *
 *   // Get the carrier parameters.
 *   $parameters = $carrier->getParameters();
 *
 *   // Do an shipping quote on the carrier
 *   if ($carrier->supportsQuote()) {
 *       $carrier->quote(...);
 *   } else {
 *       throw new \Exception('Carrier does not support quote()');
 *   }
 * </code>
 *
 * For further code examples see the *omnipay-example* repository on github.
 *
 * @see CarrierInterface
 */
abstract class AbstractCarrier implements CarrierInterface
{
    use ParametersTrait;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $httpRequest;

    /**
     * Create a new carrier instance
     *
     * @param ClientInterface $httpClient  A HTTP client to make API calls with
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        $this->httpClient = $httpClient ?: $this->getDefaultHttpClient();
        $this->httpRequest = $httpRequest ?: $this->getDefaultHttpRequest();
        $this->initialize();
    }

    /**
     * Get the short name of the Carrier
     *
     * @return string
     */
    public function getShortName()
    {
        return Helper::getCarrierShortName(get_class($this));
    }

    /**
     * Initialize this carrier with default parameters
     *
     * @param  array $parameters
     * @return $this
     */
    public function initialize(array $parameters = array())
    {
        $this->parameters = new ParameterBag;

        // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters->set($key, reset($value));
            } else {
                $this->parameters->set($key, $value);
            }
        }

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array();
    }

    /**
     * Supports Quote
     *
     * @return boolean True if this carrier supports the quote() method
     */
    public function supportsQuote()
    {
        return method_exists($this, 'quote');
    }

    /**
     * Supports Track
     *
     * @return boolean True if this carrier supports the track() method
     */
    public function supportsTrack()
    {
        return method_exists($this, 'track');
    }

    /**
     * Create and initialize a request object
     *
     * This function is usually used to create objects of type
     * Omniship\Common\Message\AbstractRequest (or a non-abstract subclass of it)
     * and initialise them with using existing parameters from this carrier.
     *
     * Example:
     *
     * <code>
     *   class MyRequest extends \Omniship\Common\Message\AbstractRequest {};
     *
     *   class MyCarrier extends \Omniship\Common\AbstractCarrier {
     *     function myRequest($parameters) {
     *       $this->createRequest('MyRequest', $parameters);
     *     }
     *   }
     *
     *   // Create the carrier object
     *   $gw = Omniship::create('MyCarrier');
     *
     *   // Create the request object
     *   $myRequest = $gw->myRequest($someParameters);
     * </code>
     *
     * @see \Omniship\Common\Message\AbstractRequest
     * @param string $class The request class name
     * @param array $parameters
     * @return \Omniship\Common\Message\AbstractRequest
     */
    protected function createRequest($class, array $parameters)
    {
        $obj = new $class($this->httpClient, $this->httpRequest);

        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }

    /**
     * Get the global default HTTP client.
     *
     * @return ClientInterface
     */
    protected function getDefaultHttpClient()
    {
        return new Client();
    }

    /**
     * Get the global default HTTP request.
     *
     * @return HttpRequest
     */
    protected function getDefaultHttpRequest()
    {
        return HttpRequest::createFromGlobals();
    }
}
