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
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\RequestInterface as Request;

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

    public function match(Request $request)
    {
    }

    public function assemble(array $params = [], array $options = [])
    {
    }

    public function getAssembledParams()
    {
        
    }
}
