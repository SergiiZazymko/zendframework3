<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 31.05.19
 * Time: 20:29
 */

namespace Application\Factory;

use Application\Service\CurrencyConverter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class CurrencyConverterFactory
 * @package Application\Factory
 */
class CurrencyConverterFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return CurrencyConverter|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CurrencyConverter;
    }
}
