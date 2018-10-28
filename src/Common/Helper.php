<?php
/**
 * Helper class
 */

namespace Omniship\Common;

use InvalidArgumentException;

/**
 * Helper class
 *
 * This class defines various static utility functions that are in use
 * throughout the Omniship system.
 */
class Helper
{
    /**
     * Convert a string to camelCase. Strings already in camelCase will not be harmed.
     *
     * @param  string  $str The input string
     * @return string camelCased output string
     */
    public static function camelCase($str)
    {
        $str = self::convertToLowercase($str);
        return preg_replace_callback(
            '/_([a-z])/',
            function ($match) {
                return strtoupper($match[1]);
            },
            $str
        );
    }

    /**
     * Convert strings with underscores to be all lowercase before camelCase is preformed.
     *
     * @param  string $str The input string
     * @return string The output string
     */
    protected static function convertToLowercase($str)
    {
        $explodedStr = explode('_', $str);
        $lowercasedStr = [];

        if (count($explodedStr) > 1) {
            foreach ($explodedStr as $value) {
                $lowercasedStr[] = strtolower($value);
            }
            $str = implode('_', $lowercasedStr);
        }

        return $str;
    }

    /**
     * Initialize an object with a given array of parameters
     *
     * Parameters are automatically converted to camelCase. Any parameters which do
     * not match a setter on the target object are ignored.
     *
     * @param mixed $target     The object to set parameters on
     * @param array $parameters An array of parameters to set
     */
    public static function initialize($target, array $parameters = null)
    {
        if ($parameters) {
            foreach ($parameters as $key => $value) {
                $method = 'set'.ucfirst(static::camelCase($key));
                if (method_exists($target, $method)) {
                    $target->$method($value);
                }
            }
        }
    }

    /**
     * Resolve a carrier class to a short name.
     *
     * The short name can be used with CarrierFactory as an alias of the carrier class,
     * to create new instances of a carrier.
     */
    public static function getCarrierShortName($className)
    {
        if (0 === strpos($className, '\\')) {
            $className = substr($className, 1);
        }

        if (0 === strpos($className, 'Omniship\\')) {
            return trim(str_replace('\\', '_', substr($className, 8, -7)), '_');
        }

        return '\\'.$className;
    }

    /**
     * Resolve a short carrier name to a full namespaced carrier class.
     *
     * Class names beginning with a namespace marker (\) are left intact.
     * Non-namespaced classes are expected to be in the \Omniship namespace, e.g.:
     *
     *      \Custom\Carrier     => \Custom\Carrier
     *      \Custom_Carrier     => \Custom_Carrier
     *      Correios              => \Omniship\Correios\Carrier
     *
     * @param  string  $shortName The short carrier name
     * @return string  The fully namespaced carrier class name
     */
    public static function getCarrierClassName($shortName)
    {
        if (0 === strpos($shortName, '\\')) {
            return $shortName;
        }

        // replace underscores with namespace marker, PSR-0 style
        $shortName = str_replace('_', '\\', $shortName);
        if (false === strpos($shortName, '\\')) {
            $shortName .= '\\';
        }

        return '\\Omniship\\'.$shortName.'Carrier';
    }
}
