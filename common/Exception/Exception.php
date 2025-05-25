<?php

namespace Common\Exception;

use PHPUnit\Event\Code\Throwable;

class Exception
{
    public static function getFullMessage($th)
    {
        return "Exception: {$th->getMessage()} in {$th->getFile()} on line {$th->getLine()}";
    }
}
