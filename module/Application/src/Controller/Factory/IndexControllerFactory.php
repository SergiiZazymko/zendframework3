<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 31.05.19
 * Time: 20:40
 */

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Application\Service\CurrencyConverter;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class IndexControllerFactory
 * @package Application\Factory
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return IndexController|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IndexController(
            $container->get(CurrencyConverter::class)
        );
    }
}
