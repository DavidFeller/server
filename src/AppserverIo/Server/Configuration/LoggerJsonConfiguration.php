<?php

/**
 * \AppserverIo\Server\Configuration\LoggerJsonConfiguration
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Configuration;

use AppserverIo\Server\Interfaces\LoggerConfigurationInterface;

/**
 * Class LoggerJsonConfiguration
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class LoggerJsonConfiguration implements LoggerConfigurationInterface
{

    /**
     * Holds the data instance read by json file
     *
     * @var \stdClass
     */
    protected $data;

    /**
     * Holds the handlers data
     *
     * @var array
     */
    protected $handlers;

    /**
     * Holds the processors data
     *
     * @var array
     */
    protected $processors;

    /**
     * Constructs config
     *
     * @param \stdClass $data The data object
     */
    public function __construct(\stdClass $data)
    {
        // set data
        $this->data = $data;

        // prepare handlers
        $this->handlers = $this->prepareHandlers($data);
        // prepare processors
        $this->processors = $this->prepareProcessors($data);
    }

    /**
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->data->name;
    }

    /**
     * Returns type
     *
     * @return string
     */
    public function getType()
    {
        return $this->data->type;
    }

    /**
     * Returns channel
     *
     * @return string|null
     */
    public function getChannel()
    {
        // check if channel is given
        if (isset($this->data->channel)) {
            return $this->data->channel;
        }
    }

    /**
     * Returns defined handlers for logger
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Returns defined processors for logger
     *
     * @return array
     */
    public function getProcessors()
    {
        return $this->processors;
    }

    /**
     * Prepares handlers array for config
     *
     * @param \stdClass $data The data object get information from
     *
     * @return array
     */
    public function prepareHandlers(\stdClass $data)
    {
        $handlers = array();
        if ($data->handlers) {
            foreach ($data->handlers as $handler) {
                // build up params
                $params = (array)$handler->params;
                // set up handler infos
                $handlers[$handler->type]['params'] = $params;
                // build up formatter infos if exists
                if (isset($handler->formatter)) {
                    $formatterType = $handler->formatter->type;
                    $formatterParams = (array)$handler->formatter->params;
                    // setup formatter info
                    $handlers[$handler->type]['formatter'] = array(
                        'type' => $formatterType,
                        'params' => $formatterParams
                    );
                }
            }
        }
        return $handlers;
    }

    /**
     * Prepares processors array for config
     *
     * @param \stdClass $data The data object get information from
     *
     * @return array
     */
    public function prepareProcessors(\stdClass $data)
    {
        $processors = array();
        if (isset($data->processors)) {
            foreach ($data->processors as $processor) {
                $processors[$processor->type] = $processor->type;
            }
        }
        return $processors;
    }
}
