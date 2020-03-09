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
# Class(es)                                                                    #
################################################################################

class SimpleLogLevel
{

    const OFF = 0;
    const FATAL = 1;
    const ERROR = 2;
    const WARN = 3;
    const INFO = 4;
    const DEBUG = 5;

    private $level = self::DEBUG;
    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new SimpleLogLevel();
        }

        return self::$instance;
    }

    public static function set($level)
    {
        SimpleLogLevel::getInstance()->level = $level;
    }

    public static function get()
    {
        return SimpleLogLevel::getInstance()->level;
    }

    public static function levelToString($level)
    {
        switch ($level) {
            case self::OFF:
                return 'OFF';
            case self::FATAL:
                return 'FATAL';
            case self::ERROR:
                return 'ERROR';
            case self::WARN:
                return 'WARN';
            case self::INFO:
                return 'INFO';
            case self::DEBUG:
                return 'DEBUG';
        }

        return null;
    }

    public static function levelToId($level)
    {
        $levelString = self::levelToString($level);
        if (!empty($levelString)) {
            return substr($levelString, 0, 1);
        }

        return null;
    }
}

################################################################################
#                                End of file                                   #
################################################################################
