<?php

namespace DebugBar\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class ProfilerTypes
 */
class ProfilerTypes extends Enum
{
    /**
     * AURA SQL
     */
    public const PROFILER_TYPE_AURASQL = 1;
    /**
     * PDO
     */
    public const PROFILER_TYPE_PDO = 2;


}