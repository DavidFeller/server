<?php

/**
 * \AppserverIo\WebServer\Loggers\ErrorLogLogger
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

namespace AppserverIo\Server\Loggers;

/**
 * Logger implementation that uses the PHP 'error_log' function.
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ErrorLogLogger extends DummyLogger
{

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   The log level
     * @param string $message The message to log
     * @param array  $context The context for log
     *
     * @return null
     */
    public function log($level, $message, array $context = array())
    {

        // check the log level
        if ($this->shouldLog($level)) {
            // prepare the log message
            $logMessage = sprintf('[%s] - %s (%s): %s %s', date('Y-m-d H:i:s'), gethostname(), $level, $message, json_encode($context));

            // write the log message
            error_log($logMessage);
        }
    }
}
