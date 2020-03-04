<?php
# * ********************************************************************* *
# *                                                                       *
# *   Simple Logger                                                       *
# *   This file is part of simplelog. This project may be found at:       *
# *   https://github.com/IdentityBank/Php_simplelog.                      *
# *                                                                       *
# *   Copyright (C) 2020 by Identity Bank. All Rights Reserved.           *
# *   https://www.identitybank.eu - You belong to you                     *
# *                                                                       *
# *   This program is free software: you can redistribute it and/or       *
# *   modify it under the terms of the GNU Affero General Public          *
# *   License as published by the Free Software Foundation, either        *
# *   version 3 of the License, or (at your option) any later version.    *
# *                                                                       *
# *   This program is distributed in the hope that it will be useful,     *
# *   but WITHOUT ANY WARRANTY; without even the implied warranty of      *
# *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the        *
# *   GNU Affero General Public License for more details.                 *
# *                                                                       *
# *   You should have received a copy of the GNU Affero General Public    *
# *   License along with this program. If not, see                        *
# *   https://www.gnu.org/licenses/.                                      *
# *                                                                       *
# * ********************************************************************* *

################################################################################
# Namespace                                                                    #
################################################################################

namespace xmz\simplelog;

################################################################################
# Use(s)                                                                       #
################################################################################

use Exception;

################################################################################
# Include(s)                                                                   #
################################################################################

include_once "SimpleLogLevel.php";

################################################################################
# Class(es)                                                                    #
################################################################################

class SNLog extends SimpleLogBase
{

    public static function register($loggerName, $logFile)
    {
        SimpleLogLocation::register($loggerName, $logFile);
    }

    static function fatal($loggerName, $logLine)
    {
        self::log($logLine, SimpleLogLevel::FATAL, SimpleLogLocation::get($loggerName));
    }

    static function error($loggerName, $logLine)
    {
        self::log($logLine, SimpleLogLevel::ERROR, SimpleLogLocation::get($loggerName));
    }

    static function warn($loggerName, $logLine)
    {
        self::log($logLine, SimpleLogLevel::WARN, SimpleLogLocation::get($loggerName));
    }

    static function info($loggerName, $logLine)
    {
        self::log($logLine, SimpleLogLevel::INFO, SimpleLogLocation::get($loggerName));
    }

    static function debug($loggerName, $logLine)
    {
        self::log($logLine, SimpleLogLevel::DEBUG, SimpleLogLocation::get($loggerName));
    }

    static function custom($loggerName, $logLine, $level)
    {
        self::log($logLine, $level, SimpleLogLocation::get($loggerName));
    }
}

class SimpleLog extends SimpleLogBase
{

    static function fatal($logLine)
    {
        self::log($logLine, SimpleLogLevel::FATAL);
    }

    static function error($logLine)
    {
        self::log($logLine, SimpleLogLevel::ERROR);
    }

    static function warn($logLine)
    {
        self::log($logLine, SimpleLogLevel::WARN);
    }

    static function info($logLine)
    {
        self::log($logLine, SimpleLogLevel::INFO);
    }

    static function debug($logLine)
    {
        self::log($logLine, SimpleLogLevel::DEBUG);
    }
}

class_alias('xmz\simplelog\SimpleLog', 'xmz\simplelog\SLog');

class SimpleLogBase
{

    static function log(
        $logLine,
        $level = SimpleLogLevel::INFO,
        $output = null,
        $timestampFormat = "Y-m-d H:i:s",
        $levelEnabled = true
    ) {
        if (SimpleLogLevel::get() < $level) {
            return;
        }

        if (empty($output)) {
            $output = ini_get('error_log');
        }

        if (empty($output)) {
            $output = sprintf("%s/%s.%s", sys_get_temp_dir(), 'php_error', 'log');
        }

        $timestampValue = $levelValue = null;
        if (!empty($timestampFormat)) {
            $timestampValue = "[" . date($timestampFormat) . "] ";
        }
        if ($levelEnabled) {
            $levelValue = SimpleLogLevel::levelToId($level);
            $levelValue = "[$levelValue] ";
        }
        $log = $timestampValue . $levelValue . $logLine . PHP_EOL;

        try {
            error_reporting(0);
            error_log($log, 3, $output);
            error_reporting(E_ALL);
        } catch (Exception $e) {
            // More likely - failed to open stream - Permission denied
        }

    }
}

################################################################################
#                                End of file                                   #
################################################################################
