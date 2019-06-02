<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 02.06.19
 * Time: 14:49
 */

namespace Application\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class DownloadController
 * @package Application\Controller
 */
class DownloadController extends AbstractActionController
{
    /** @const string UPLOADS_FOLDER */
    const UPLOADS_FOLDER = './data/uploads';

    /**
     * @return void|\Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        /** @var string $fileName */
        $fileName = $this->params()->fromQuery('name');
        $fileName = str_replace('/', '', $fileName);
        $fileName = str_replace('\\', '', $fileName);

        /** @var Response $response */
        $response = $this->getResponse();

        /** @var string $path */
        $path = realpath(static::UPLOADS_FOLDER . DIRECTORY_SEPARATOR . $fileName);

        if (!is_file($path)) {
            $response->setStatusCOde(404);
            return;
        }

        /** @var string $fileContent */
        if (!$fileContent = file_get_contents($path)) {
            $response->setStatusCode(500);
            return;
        }

        $response->getHeaders()->addHeaders([
            'Content-Disposition' => 'attachment;filename="'. basename($path) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length: ' . filesize($path),
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
        ]);
        $response->setStatusCode(200);
        $response->setContent($fileContent);

        return $response;
    }
}
