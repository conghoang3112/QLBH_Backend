<?php

namespace App\Helpers;

use Throwable;

class ExceptionHelper
{
    /**
     * Convert exception to readable message for DEBUG only
     * @param Throwable|null $e
     * @param int $limit
     * @return array
     */
    public static function makePrettyException(?Throwable $e, int $limit=3, int $limitLines = 5): array
    {
        if ($limit <= 0) return [];
        $trace = $e->getTrace();
        $ret = [];
        $currentError = [];
        for ($i = 0; $i < min([count($trace), $limitLines]); $i++) {
            $codeLine = empty($trace[$i]['line']) ? '' : $trace[$i]['line'];

            $result = '#' . $i . ': Line ';
            $result = empty($codeLine) ? $result . '-' : $result . $codeLine . '-';
            $result .= ' [' . $e->getCode() . '] ';
            if (!empty($trace[$i]['class'])) {
                $result .= $trace[$i]['class'];
                $result .= '->';
            }
            $result .= $trace[$i]['function'] . '()';
            $result .= ': ' . $e->getMessage();
            $currentError[] = $result;
        }
        $ret[] = $currentError;
        if ($limit > 0 && !is_null($e->getPrevious()))
        {
            $ret = array_merge($ret, self::makePrettyException($e->getPrevious(), $limit - 1));
        }
        return $ret;
    }
}
