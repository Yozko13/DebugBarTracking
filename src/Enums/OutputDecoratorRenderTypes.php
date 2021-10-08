<?php

namespace DebugBar\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class OutputDecoratorRenderTypes
 */
class OutputDecoratorRenderTypes extends Enum
{
    /**
     * HTML
     */
    public const DECORATE_HTML  = 1;

    /**
     * Table
     */
    public const DECORATE_TABLE = 2;

    /**
     * Array
     */
    public const DECORATE_ARRAY = 3;

    /**
     * JSON
     */
    public const DECORATE_JSON  = 4;
}