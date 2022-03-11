<?php namespace Falbar\SystemLog\Helper;

/**
 * Class RegexHelper
 * @package Falbar\SystemLog\Helper
 */
class RegexHelper
{
    const LOG_LARAVEL_FILE = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/';
    const LOG_LARAVEL_FILE_LEVEL = [
        'BEFORE' => '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
        'AFTER'  => ': (.*?)( in .*?:[0-9]+)?$/i',
    ];
    const LOG_LARAVEL_FILE_STACK = '/^\n*/';
}
