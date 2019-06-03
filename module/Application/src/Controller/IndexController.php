<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Service\CurrencyConverter;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{
    /** @var CurrencyConverter $currencyConverter */
    protected $currencyConverter;

    /**
     * IndexController constructor.
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @param MvcEvent $e
     * @return mixed
     */
    public function onDispatch(MvcEvent $e)
    {
        //echo __METHOD__;die;
        return parent::onDispatch($e); // TODO: Change the autogenerated stub
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        var_dump($this->accessPlugin()->checkAccess('f'));

//        throw new \Exception();

        //var_dump($this->currencyConverter);die;
        return new ViewModel;
    }

    /**
     * @return ViewModel
     */
    public function aboutAction()
    {
        /** @var string $appName */
        $appName = 'HelloWorld';
        
        /** @var string $appDescription */
        $appDescription = 'A sample application for the Using Zend Framework 3 book';
        
        return new ViewModel([
            'appName' => $appName,
            'appDescription' => $appDescription,
        ]);
    }

    /**
     * @return void
     */
    public function viewAction()
    {
        /** @var Response $response */
        $response = $this->getResponse();

        $response->setStatusCode(500);
        return;
    }

    /**
     * @return JsonModel
     */
    public function getJsonAction()
    {
        return new JsonModel([
            'status' => 'SUCCESS',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ],
        ]);
    }
}
