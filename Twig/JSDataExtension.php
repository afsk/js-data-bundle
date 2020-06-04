<?php

namespace Zitec\JSDataBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zitec\JSDataBundle\Service\DataHandler;

/**
 * Twig extension which makes the JS data handler available in the templates through functions which are proxies
 * to its methods
 */
class JSDataExtension extends AbstractExtension
{
    /**
     * The data handler service.
     *
     * @var DataHandler
     */
    protected DataHandler $dataHandler;

    /**
     * The service constructor.
     *
     * @param DataHandler $dataHandler
     */
    public function __construct(DataHandler $dataHandler)
    {
        $this->dataHandler = $dataHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('zitec_js_data_add', array($this, 'addFunction')),
            new TwigFunction('zitec_js_data_merge', array($this, 'mergeFunction')),
            new TwigFunction(
                'zitec_js_data_get_all',
                array($this, 'getAllFunction'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'zitec_js_data_extension';
    }

    /**
     * Twig proxy to the {@see DataHandler::add()} method.
     *
     * @param string $path
     * @param mixed $value
     */
    public function addFunction(string $path, $value)
    {
        $this->dataHandler->add($path, $value);
    }

    /**
     * Twig proxy to the {@see DataHandler::merge()} method.
     *
     * @param mixed $data
     */
    public function mergeFunction($data)
    {
        $this->dataHandler->merge($data);
    }

    /**
     * Twig proxy to the {@see DataHandler::getAll()} method. The data is outputted directly in the JSON format,
     * so you can assign it to a JS variable.
     *
     * @param int $jsEncodeOptions
     * - options to pass to the {@see json_encode()} function;
     *
     * @return string
     */
    public function getAllFunction($jsEncodeOptions = 0): string
    {
        return json_encode($this->dataHandler->getAll(), $jsEncodeOptions);
    }
}
