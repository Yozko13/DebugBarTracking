<?php

namespace DebugBar\Enums;

use MyCLabs\Enum\Enum;

class ProfilerTypes extends Enum
{
    public const PROFILER_TYPE_AURASQL = 1;
    public const PROFILER_TYPE_PDO     = 2;


}