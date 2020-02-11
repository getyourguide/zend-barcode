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
		'codabar'           => ZendObject\Codabar::class,
		'code128'           => ZendObject\Code128::class,
		'code25'            => ZendObject\Code25::class,
		'code25interleaved' => ZendObject\Code25interleaved::class,
		'code39'            => ZendObject\Code39::class,
		'ean13'             => ZendObject\Ean13::class,
		'ean2'              => ZendObject\Ean2::class,
		'ean5'              => ZendObject\Ean5::class,
		'ean8'              => ZendObject\Ean8::class,
		'error'             => ZendObject\Error::class,
		'identcode'         => ZendObject\Identcode::class,
		'itf14'             => ZendObject\Itf14::class,
		'leitcode'          => ZendObject\Leitcode::class,
		'planet'            => ZendObject\Planet::class,
		'postnet'           => ZendObject\Postnet::class,
		'royalmail'         => ZendObject\Royalmail::class,
		'upca'              => ZendObject\Upca::class,
		'upce'              => ZendObject\Upce::class,
    ];

    protected $factories = [
		ZendObject\Codabar::class           => InvokableFactory::class,
		ZendObject\Code128::class           => InvokableFactory::class,
		ZendObject\Code25::class            => InvokableFactory::class,
		ZendObject\Code25interleaved::class => InvokableFactory::class,
		ZendObject\Code39::class            => InvokableFactory::class,
		ZendObject\Ean13::class             => InvokableFactory::class,
		ZendObject\Ean2::class              => InvokableFactory::class,
		ZendObject\Ean5::class              => InvokableFactory::class,
		ZendObject\Ean8::class              => InvokableFactory::class,
		ZendObject\Error::class             => InvokableFactory::class,
		ZendObject\Identcode::class         => InvokableFactory::class,
		ZendObject\Itf14::class             => InvokableFactory::class,
		ZendObject\Leitcode::class          => InvokableFactory::class,
		ZendObject\Planet::class            => InvokableFactory::class,
		ZendObject\Postnet::class           => InvokableFactory::class,
		ZendObject\Royalmail::class         => InvokableFactory::class,
		ZendObject\Upca::class              => InvokableFactory::class,
		ZendObject\Upce::class              => InvokableFactory::class,

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

    protected $instanceOf = ZendObject\AbstractObject::class;

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
                ZendObject\AbstractObject::class
            ), $e->getCode(), $e);
        }
    }
}
