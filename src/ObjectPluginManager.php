<?php
/**
 * @see       https://github.com/zendframework/zend-barcode for the canonical source repository
 * @copyright Copyright (c) 2005-2019 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-barcode/blob/master/LICENSE.md New BSD License
 */

namespace Zend\Barcode;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception\InvalidServiceException;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * Plugin manager implementation for barcode parsers.
 *
 * Enforces that barcode parsers retrieved are instances of
 * Object\AbstractObject. Additionally, it registers a number of default
 * barcode parsers.
 */
class ObjectPluginManager extends AbstractPluginManager
{
    /**
     * @var bool Ensure services are not shared (v2 property)
     */
    protected $shareByDefault = false;

    /**
     * @var bool Ensure services are not shared (v3 property)
     */
    protected $sharedByDefault = false;

    /**
     * Default set of symmetric adapters
     *
     * @var array
     */
    protected $aliases = [
		'codabar'           => CObject\Codabar::class,
		'code128'           => CObject\Code128::class,
		'code25'            => CObject\Code25::class,
		'code25interleaved' => CObject\Code25interleaved::class,
		'code39'            => CObject\Code39::class,
		'ean13'             => CObject\Ean13::class,
		'ean2'              => CObject\Ean2::class,
		'ean5'              => CObject\Ean5::class,
		'ean8'              => CObject\Ean8::class,
		'error'             => CObject\Error::class,
		'identcode'         => CObject\Identcode::class,
		'itf14'             => CObject\Itf14::class,
		'leitcode'          => CObject\Leitcode::class,
		'planet'            => CObject\Planet::class,
		'postnet'           => CObject\Postnet::class,
		'royalmail'         => CObject\Royalmail::class,
		'upca'              => CObject\Upca::class,
		'upce'              => CObject\Upce::class,
    ];

    protected $factories = [
		CObject\Codabar::class           => InvokableFactory::class,
		CObject\Code128::class           => InvokableFactory::class,
		CObject\Code25::class            => InvokableFactory::class,
		CObject\Code25interleaved::class => InvokableFactory::class,
		CObject\Code39::class            => InvokableFactory::class,
		CObject\Ean13::class             => InvokableFactory::class,
		CObject\Ean2::class              => InvokableFactory::class,
		CObject\Ean5::class              => InvokableFactory::class,
		CObject\Ean8::class              => InvokableFactory::class,
		CObject\Error::class             => InvokableFactory::class,
		CObject\Identcode::class         => InvokableFactory::class,
		CObject\Itf14::class             => InvokableFactory::class,
		CObject\Leitcode::class          => InvokableFactory::class,
		CObject\Planet::class            => InvokableFactory::class,
		CObject\Postnet::class           => InvokableFactory::class,
		CObject\Royalmail::class         => InvokableFactory::class,
		CObject\Upca::class              => InvokableFactory::class,
		CObject\Upce::class              => InvokableFactory::class,

		// v2 canonical FQCNs

		'zendbarcodeobjectcodabar'           => InvokableFactory::class,
		'zendbarcodeobjectcode128'           => InvokableFactory::class,
		'zendbarcodeobjectcode25'            => InvokableFactory::class,
		'zendbarcodeobjectcode25interleaved' => InvokableFactory::class,
		'zendbarcodeobjectcode39'            => InvokableFactory::class,
		'zendbarcodeobjectean13'             => InvokableFactory::class,
		'zendbarcodeobjectean2'              => InvokableFactory::class,
		'zendbarcodeobjectean5'              => InvokableFactory::class,
		'zendbarcodeobjectean8'              => InvokableFactory::class,
		'zendbarcodeobjecterror'             => InvokableFactory::class,
		'zendbarcodeobjectidentcode'         => InvokableFactory::class,
		'zendbarcodeobjectitf14'             => InvokableFactory::class,
		'zendbarcodeobjectleitcode'          => InvokableFactory::class,
		'zendbarcodeobjectplanet'            => InvokableFactory::class,
		'zendbarcodeobjectpostnet'           => InvokableFactory::class,
		'zendbarcodeobjectroyalmail'         => InvokableFactory::class,
		'zendbarcodeobjectupca'              => InvokableFactory::class,
		'zendbarcodeobjectupce'              => InvokableFactory::class,
    ];

    protected $instanceOf = CObject\AbstractObject::class;

    /**
     * Validate the plugin is of the expected type (v3).
     *
     * Validates against `$instanceOf`.
     *
     * @param mixed $plugin
     * @throws InvalidServiceException
     */
    public function validate($plugin)
    {
        if (! $plugin instanceof $this->instanceOf) {
            throw new InvalidServiceException(sprintf(
                '%s can only create instances of %s; %s is invalid',
                get_class($this),
                $this->instanceOf,
                (is_object($plugin) ? get_class($plugin) : gettype($plugin))
            ));
        }
    }

    /**
     * Validate the plugin is of the expected type (v2).
     *
     * Proxies to `validate()`.
     *
     * @param mixed $plugin
     * @throws Exception\InvalidArgumentException
     */
    public function validatePlugin($plugin)
    {
        try {
            $this->validate($plugin);
        } catch (InvalidServiceException $e) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Plugin of type %s is invalid; must extend %s',
                (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
                CObject\AbstractObject::class
            ), $e->getCode(), $e);
        }
    }
}
