<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 01.06.19
 * Time: 12:21
 */

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class AccessPlugin
 * @package Application\Controller\Plugin
 */
class AccessPlugin extends AbstractPlugin
{
    /**
     * @param $actionName
     */
    public function checkAccess($actionName)
    {
        echo __METHOD__;
    }
}
