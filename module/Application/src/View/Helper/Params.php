<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 01.06.19
 * Time: 13:41
 */

namespace Application\View\Helper;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

/**
 * Class Params
 * @package Application\ViewHelper
 */
class Params extends AbstractHelper
{
    /** @var Request $request */
    protected $request;

    /**
     * Params constructor.
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @param null $name
     * @param null $defaul
     * @return mixed|\Zend\Stdlib\ParametersInterface
     */
    public function fromQuery($name = null, $defaul = null)
    {
        return $this->request->getQuery($name, $defaul);
    }
}
