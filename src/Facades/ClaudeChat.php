<?php

namespace GregPriday\ClaudeChat\Facades;

use Illuminate\Support\Facades\Facade;
use stdClass;

/**
 * @method static stdClass create(array $arguments)
 * @method static stdClass createJson(array $arguments)
 *
 * @see \GregPriday\ClaudeChat\ClaudeChat
 */
class ClaudeChat extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \GregPriday\ClaudeChat\ClaudeChat::class;
    }
}
