<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 01.06.19
 * Time: 13:48
 */

namespace Application\View\Helper\Factory;

use Application\View\Helper\Params;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ParamsFactory
 * @package Application\Factory
 */
class ParamsFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Params|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Params(
            $container->get('Application')->getRequest()
        );
    }
}
