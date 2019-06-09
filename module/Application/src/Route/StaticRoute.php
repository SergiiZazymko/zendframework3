<?php
/**
 * Created by PhpStorm.
 * User: sergii
 * Date: 04.06.19
 * Time: 22:09
 */

namespace Application\Route;

use Traversable;
use Zend\Router\Exception\InvalidArgumentException;
use Zend\Router\RouteInterface;
use Zend\Router\RouteMatch;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;
use Zend\Uri\Uri;

/**
 * Class StaticRoute
 * @package Application\Route
 */
class StaticRoute implements RouteInterface
{
    /** @var string $dirName */
    protected $dirName;

    /** @var string $templatePrefix */
    protected $templatePrefix;

    /** @var string $fileNamePattern */
    protected $fileNamePattern = '/\\w+/';

    /** @var array $defaults */
    protected $defaults;

    /** @var array $assembledParams */
    protected $assembledParams = [];

    /**
     * StaticRoute constructor.
     * @param string $dirName
     * @param string $templatePrefix
     * @param string $fileNamePattern
     * @param array $defaults
     * @param array $assembledParams
     */
    public function __construct($dirName, $templatePrefix, $fileNamePattern, array $defaults)
    {
        $this->dirName = $dirName;
        $this->templatePrefix = $templatePrefix;
        $this->fileNamePattern = $fileNamePattern;
        $this->defaults = $defaults;
    }

    /**
     * @param array $options
     * @return StaticRoute|RouteInterface
     */
    public static function factory($options = [])
    {
        if ($options instanceof Traversable) {
            /** @var array $options */
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new InvalidArgumentException(__METHOD__ . ' expects an array or Traversable set of options');
        }

        if (!isset($options['dir_name'])) {
            throw new InvalidArgumentException('Missing "dir_name" in options array');
        }

        if (!isset($options['template_prefix'])) {
            throw new InvalidArgumentException('Missing "template_prefix" in options array');
        }

        if (!isset($options['filename_pattern'])) {
            throw new InvalidArgumentException('Missing "filename_pattern" in options array');
        }

        $options['defaults'] = $options['defaults'] ?? [];

        return new static(
            $options['dir_name'],
            $options['template_prefix'],
            $options['filename_pattern'],
            $options['defaults']
        );
    }

    /**
     * @param Request $request
     * @param null $pathOffset
     * @return RouteMatch|null
     */
    public function match(Request $request, $pathOffset = null)
    {
        if (!method_exists($request, 'getUri')) {
            return null;
        }

        /** @var Uri $uri */
        $uri = $request->getUri();

        /** @var string $path */
        $path = $uri->getPath();
        $path = $pathOffset ? substr($path, $pathOffset) : $path;

        /** @var array $segments */
        $segments = explode('/', $path);

        /** @var string $segment */
        foreach ($segments as $segment) {
            if (!strlen($segment)) {
                continue;
            }

            if (!preg_match($this->fileNamePattern, $segment)) {
                return null;
            }
        }

        /** @var string $fileName */
        $fileName = $this->dirName . DIRECTORY_SEPARATOR . $this->templatePrefix . $path . '.phtml';

        if (!is_file($fileName) || !is_readable($fileName)) {
            return null;
        }

        /** @var int $matchedLength */
        $matchedLength = strlen($path);

        return new RouteMatch(
            ArrayUtils::merge($this->defaults, ['page' => $this->templatePrefix . $path]),
            $matchedLength
        );
    }

    /**
     * @param array $params
     * @param array $options
     * @return mixed|string
     */
    public function assemble(array $params = [], array $options = [])
    {
        /** @var array $mergedParams */
        $mergedParams = ArrayUtils::merge($this->defaults, $params);

        $this->assembledParams = [];

        if (!isset($params['page'])) {
            throw new InvalidArgumentException(__METHOD__ .  ' expects the "page" parameter');
        }

        /** @var array $segments */
        $segments = explode('/', $params['page']);

        /** @var string $url */
        $url = '';

        /** @var string $segment */
        foreach($segments as $segment) {
            if(strlen($segment)==0) {
                continue;
            }

            $url .= '/' . rawurlencode($segment);
        }

        $this->assembledParams[] = 'page';

        return $url;
    }

    /**
     * @return array
     */
    public function getAssembledParams()
    {
        return $this->assembledParams;
    }
}
